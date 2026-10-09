<?php
/**
 * Settings page and option handling for PixelDiet.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pixel_Diet_Settings {

	const OPTION_KEY = 'pixel_diet_settings';
	const PAGE_SLUG  = 'pixel-diet';

	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( PIXEL_DIET_FILE ), array( $this, 'action_links' ) );
	}

	public static function defaults() {
		return array(
			'enabled'       => 1,
			'max_width'     => 1920,
			'max_height'    => 1920,
			'jpeg_quality'  => 82,
			'mime_types'    => array( 'image/jpeg', 'image/png', 'image/webp' ),
			'keep_original' => 0,
			'beta_updates'  => 0,
		);
	}

	public static function get_settings() {
		$stored = get_option( self::OPTION_KEY, array() );
		if ( ! is_array( $stored ) ) {
			$stored = array();
		}
		return wp_parse_args( $stored, self::defaults() );
	}

	public static function set_defaults_on_activate() {
		if ( false === get_option( self::OPTION_KEY ) ) {
			add_option( self::OPTION_KEY, self::defaults() );
		}
	}

	public function register_settings() {
		register_setting(
			'pixel_diet_group',
			self::OPTION_KEY,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize' ),
				'default'           => self::defaults(),
			)
		);

		add_settings_section(
			'pixel_diet_section_main',
			__( 'Bildverkleinerung', 'pixel-diet' ),
			array( $this, 'render_section_intro' ),
			self::PAGE_SLUG
		);

		add_settings_field( 'enabled', __( 'Plugin aktiv', 'pixel-diet' ), array( $this, 'field_enabled' ), self::PAGE_SLUG, 'pixel_diet_section_main' );
		add_settings_field( 'max_width', __( 'Maximale Breite (px)', 'pixel-diet' ), array( $this, 'field_max_width' ), self::PAGE_SLUG, 'pixel_diet_section_main' );
		add_settings_field( 'max_height', __( 'Maximale Höhe (px)', 'pixel-diet' ), array( $this, 'field_max_height' ), self::PAGE_SLUG, 'pixel_diet_section_main' );
		add_settings_field( 'jpeg_quality', __( 'JPEG-/WebP-Qualität (1-100)', 'pixel-diet' ), array( $this, 'field_jpeg_quality' ), self::PAGE_SLUG, 'pixel_diet_section_main' );
		add_settings_field( 'mime_types', __( 'Zu verarbeitende Dateitypen', 'pixel-diet' ), array( $this, 'field_mime_types' ), self::PAGE_SLUG, 'pixel_diet_section_main' );
		add_settings_field( 'keep_original', __( 'Original-Backup behalten', 'pixel-diet' ), array( $this, 'field_keep_original' ), self::PAGE_SLUG, 'pixel_diet_section_main' );

		add_settings_section(
			'pixel_diet_section_updates',
			__( 'Updates', 'pixel-diet' ),
			array( $this, 'render_section_updates' ),
			self::PAGE_SLUG
		);

		add_settings_field( 'beta_updates', __( 'Beta-Updates', 'pixel-diet' ), array( $this, 'field_beta_updates' ), self::PAGE_SLUG, 'pixel_diet_section_updates' );
	}

	public function register_menu() {
		add_options_page(
			__( 'PixelDiet', 'pixel-diet' ),
			__( 'PixelDiet', 'pixel-diet' ),
			'manage_options',
			self::PAGE_SLUG,
			array( $this, 'render_page' )
		);
	}

	public function action_links( $links ) {
		$url   = admin_url( 'options-general.php?page=' . self::PAGE_SLUG );
		$links = array_merge(
			array( '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Einstellungen', 'pixel-diet' ) . '</a>' ),
			$links
		);
		return $links;
	}

	public function sanitize( $input ) {
		$defaults = self::defaults();
		$out      = array();

		$out['enabled']       = ! empty( $input['enabled'] ) ? 1 : 0;
		$out['keep_original'] = ! empty( $input['keep_original'] ) ? 1 : 0;
		$out['beta_updates']  = ! empty( $input['beta_updates'] ) ? 1 : 0;

		// Switching the update channel drops the cached update state so the
		// next check reads the version from the other branch.
		$current = self::get_settings();
		if ( $out['beta_updates'] !== (int) $current['beta_updates'] ) {
			delete_site_option( 'external_updates-' . Pixel_Diet_Updater::SLUG );
			delete_site_transient( 'update_plugins' );
		}

		$max_width        = isset( $input['max_width'] ) ? absint( $input['max_width'] ) : $defaults['max_width'];
		$out['max_width'] = max( 100, min( 20000, $max_width ) );

		$max_height        = isset( $input['max_height'] ) ? absint( $input['max_height'] ) : $defaults['max_height'];
		$out['max_height'] = max( 100, min( 20000, $max_height ) );

		$quality             = isset( $input['jpeg_quality'] ) ? absint( $input['jpeg_quality'] ) : $defaults['jpeg_quality'];
		$out['jpeg_quality'] = max( 1, min( 100, $quality ) );

		$allowed = array( 'image/jpeg', 'image/png', 'image/webp' );
		$mime    = isset( $input['mime_types'] ) && is_array( $input['mime_types'] ) ? $input['mime_types'] : array();
		$mime    = array_values( array_intersect( $allowed, $mime ) );
		$out['mime_types'] = $mime;

		return $out;
	}

	public function render_section_intro() {
		echo '<p>' . esc_html__( 'PixelDiet verkleinert hochgeladene Bilder direkt nach dem Upload auf die hier hinterlegte maximale Größe. Das Seitenverhältnis bleibt erhalten.', 'pixel-diet' ) . '</p>';
	}

	public function field_enabled() {
		$s = self::get_settings();
		// Toggle output is escaped by WPB_Admin_UI::toggle().
		echo WPB_Admin_UI::toggle( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			self::OPTION_KEY . '[enabled]',
			1 === (int) $s['enabled'],
			__( 'Bilder beim Upload automatisch verkleinern', 'pixel-diet' )
		);
	}

	public function field_max_width() {
		$s = self::get_settings();
		printf(
			'<input type="number" min="100" max="20000" step="1" name="%1$s[max_width]" value="%2$s" class="small-text" /> px',
			esc_attr( self::OPTION_KEY ),
			esc_attr( $s['max_width'] )
		);
	}

	public function field_max_height() {
		$s = self::get_settings();
		printf(
			'<input type="number" min="100" max="20000" step="1" name="%1$s[max_height]" value="%2$s" class="small-text" /> px',
			esc_attr( self::OPTION_KEY ),
			esc_attr( $s['max_height'] )
		);
	}

	public function field_jpeg_quality() {
		$s = self::get_settings();
		printf(
			'<input type="number" min="1" max="100" step="1" name="%1$s[jpeg_quality]" value="%2$s" class="small-text" />',
			esc_attr( self::OPTION_KEY ),
			esc_attr( $s['jpeg_quality'] )
		);
		echo '<p class="description">' . esc_html__( 'Empfohlen: 80-85. Niedrigere Werte sparen mehr Speicher, reduzieren aber die Qualität.', 'pixel-diet' ) . '</p>';
	}

	public function field_mime_types() {
		$s       = self::get_settings();
		$choices = array(
			'image/jpeg' => 'JPEG (.jpg, .jpeg)',
			'image/png'  => 'PNG (.png)',
			'image/webp' => 'WebP (.webp)',
		);
		echo '<fieldset><legend class="screen-reader-text"><span>' . esc_html__( 'Zu verarbeitende Dateitypen', 'pixel-diet' ) . '</span></legend>';
		$first = true;
		foreach ( $choices as $mime => $label ) {
			if ( ! $first ) {
				echo '<br />';
			}
			$first = false;
			printf(
				'<label><input type="checkbox" name="%1$s[mime_types][]" value="%2$s" %3$s /> %4$s</label>',
				esc_attr( self::OPTION_KEY ),
				esc_attr( $mime ),
				checked( true, in_array( $mime, (array) $s['mime_types'], true ), false ),
				esc_html( $label )
			);
		}
		echo '</fieldset>';
	}

	public function field_keep_original() {
		$s = self::get_settings();
		// Toggle output is escaped by WPB_Admin_UI::toggle().
		echo WPB_Admin_UI::toggle( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			self::OPTION_KEY . '[keep_original]',
			1 === (int) $s['keep_original'],
			__( 'Vor dem Verkleinern eine Kopie als <Dateiname>.original.<Endung> speichern', 'pixel-diet' )
		);
	}

	public function render_section_updates() {
		echo '<p>' . esc_html__( 'Updates werden direkt aus GitHub geladen.', 'pixel-diet' ) . '</p>';
	}

	public function field_beta_updates() {
		$s = self::get_settings();
		// Toggle output is escaped by WPB_Admin_UI::toggle().
		echo WPB_Admin_UI::toggle( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			self::OPTION_KEY . '[beta_updates]',
			1 === (int) $s['beta_updates'],
			__( 'Beta-Versionen installieren (Branch „beta“ statt „main“)', 'pixel-diet' )
		);
		echo '<p class="description">' . esc_html__( 'Beta-Versionen enthalten neue Funktionen vor dem offiziellen Release und können Fehler enthalten. Nach dem Zurückschalten auf stabile Updates wird erst wieder aktualisiert, sobald die Version auf „main“ höher ist als die installierte Beta.', 'pixel-diet' ) . '</p>';
	}

	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<?php
			WPB_Admin_UI::header(
				array(
					'title'    => 'PixelDiet',
					'subtitle' => __( 'Verkleinert hochgeladene Bilder automatisch auf die hier eingestellte Maximalgröße.', 'pixel-diet' ),
					'icon'     => 'dashicons-format-image',
					'version'  => PIXEL_DIET_VERSION,
				)
			);
			?>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'pixel_diet_group' );
				do_settings_sections( self::PAGE_SLUG );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
