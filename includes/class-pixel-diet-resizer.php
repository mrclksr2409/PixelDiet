<?php
/**
 * Image resizing logic for PixelDiet.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pixel_Diet_Resizer {

	public function __construct() {
		add_filter( 'wp_handle_upload', array( $this, 'process_upload' ), 10, 2 );
		add_filter( 'jpeg_quality', array( $this, 'filter_jpeg_quality' ), 10, 2 );
		add_filter( 'wp_editor_set_quality', array( $this, 'filter_editor_quality' ), 10, 2 );
	}

	public function process_upload( $upload, $context = 'upload' ) {
		if ( ! is_array( $upload ) || empty( $upload['file'] ) || empty( $upload['type'] ) ) {
			return $upload;
		}

		$settings = Pixel_Diet_Settings::get_settings();

		if ( empty( $settings['enabled'] ) ) {
			return $upload;
		}

		if ( ! in_array( $upload['type'], (array) $settings['mime_types'], true ) ) {
			return $upload;
		}

		$file = $upload['file'];
		if ( ! file_exists( $file ) || ! is_writable( $file ) ) {
			return $upload;
		}

		$editor = wp_get_image_editor( $file );
		if ( is_wp_error( $editor ) ) {
			return $upload;
		}

		$size = $editor->get_size();
		if ( empty( $size['width'] ) || empty( $size['height'] ) ) {
			return $upload;
		}

		$max_w = (int) $settings['max_width'];
		$max_h = (int) $settings['max_height'];

		if ( (int) $size['width'] <= $max_w && (int) $size['height'] <= $max_h ) {
			return $upload;
		}

		if ( ! empty( $settings['keep_original'] ) ) {
			$this->backup_original( $file );
		}

		if ( in_array( $upload['type'], array( 'image/jpeg', 'image/webp' ), true ) ) {
			$editor->set_quality( (int) $settings['jpeg_quality'] );
		}

		$resized = $editor->resize( $max_w, $max_h, false );
		if ( is_wp_error( $resized ) ) {
			return $upload;
		}

		$saved = $editor->save( $file );
		if ( is_wp_error( $saved ) ) {
			return $upload;
		}

		return $upload;
	}

	private function backup_original( $file ) {
		$info = pathinfo( $file );
		if ( empty( $info['extension'] ) ) {
			return;
		}
		$backup = trailingslashit( $info['dirname'] ) . $info['filename'] . '.original.' . $info['extension'];
		if ( ! file_exists( $backup ) ) {
			@copy( $file, $backup );
		}
	}

	public function filter_jpeg_quality( $quality, $context = '' ) {
		$settings = Pixel_Diet_Settings::get_settings();
		if ( empty( $settings['enabled'] ) ) {
			return $quality;
		}
		return (int) $settings['jpeg_quality'];
	}

	public function filter_editor_quality( $quality, $mime_type ) {
		$settings = Pixel_Diet_Settings::get_settings();
		if ( empty( $settings['enabled'] ) ) {
			return $quality;
		}
		if ( in_array( $mime_type, array( 'image/jpeg', 'image/webp' ), true ) ) {
			return (int) $settings['jpeg_quality'];
		}
		return $quality;
	}
}
