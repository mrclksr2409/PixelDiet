<?php
/**
 * GitHub branch update integration via plugin-update-checker.
 *
 * Library: https://github.com/YahnisElsts/plugin-update-checker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pixel_Diet_Updater {

	const REPO_URL = 'https://github.com/mrclksr2409/pixeldiet/';
	const SLUG     = 'pixel-diet';
	const BRANCH      = 'main';
	const BETA_BRANCH = 'beta';

	public function __construct() {
		$loader = PIXEL_DIET_PATH . 'vendor/plugin-update-checker/plugin-update-checker.php';
		if ( ! file_exists( $loader ) ) {
			return;
		}

		require_once $loader;

		if ( ! class_exists( '\\YahnisElsts\\PluginUpdateChecker\\v5\\PucFactory' ) ) {
			return;
		}

		$update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
			self::REPO_URL,
			PIXEL_DIET_FILE,
			self::SLUG
		);

		// Updates come straight from the branch HEAD (version from the plugin header):
		// the beta branch when beta updates are enabled in the settings, otherwise main.
		$settings = Pixel_Diet_Settings::get_settings();
		$update_checker->setBranch( ! empty( $settings['beta_updates'] ) ? self::BETA_BRANCH : self::BRANCH );

		add_filter(
			$update_checker->getUniqueName( 'vcs_update_detection_strategies' ),
			array( $this, 'filter_strategies' )
		);
	}

	/**
	 * Ignore GitHub releases and tags so only the configured branch is used.
	 *
	 * @param array $strategies Update detection strategies.
	 * @return array
	 */
	public function filter_strategies( $strategies ) {
		unset( $strategies['latest_release'], $strategies['latest_tag'] );
		return $strategies;
	}
}
