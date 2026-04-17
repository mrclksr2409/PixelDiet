<?php
/**
 * Bootstrap singleton for PixelDiet.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pixel_Diet {

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		new Pixel_Diet_Settings();
		new Pixel_Diet_Resizer();
		new Pixel_Diet_Updater();
	}
}
