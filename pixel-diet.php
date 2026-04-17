<?php
/**
 * Plugin Name:       PixelDiet
 * Plugin URI:        https://github.com/mrclksr2409/pixeldiet
 * Description:       Verkleinert hochgeladene Bilder automatisch auf eine in den Einstellungen hinterlegte maximale Größe und reduziert so Speicherplatz und Ladezeiten.
 * Version:           1.0.0
 * Requires at least: 5.5
 * Requires PHP:      7.2
 * Author:            mrclksr2409
 * Author URI:        https://github.com/mrclksr2409
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pixel-diet
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PIXEL_DIET_VERSION', '1.0.0' );
define( 'PIXEL_DIET_FILE', __FILE__ );
define( 'PIXEL_DIET_PATH', plugin_dir_path( __FILE__ ) );
define( 'PIXEL_DIET_URL', plugin_dir_url( __FILE__ ) );
define( 'PIXEL_DIET_OPTION', 'pixel_diet_settings' );

require_once PIXEL_DIET_PATH . 'includes/class-pixel-diet-settings.php';
require_once PIXEL_DIET_PATH . 'includes/class-pixel-diet-resizer.php';
require_once PIXEL_DIET_PATH . 'includes/class-pixel-diet-updater.php';
require_once PIXEL_DIET_PATH . 'includes/class-pixel-diet.php';

register_activation_hook( __FILE__, array( 'Pixel_Diet_Settings', 'set_defaults_on_activate' ) );

add_action( 'plugins_loaded', array( 'Pixel_Diet', 'instance' ) );
