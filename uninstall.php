<?php
/**
 * PixelDiet uninstall handler.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'pixel_diet_settings' );
