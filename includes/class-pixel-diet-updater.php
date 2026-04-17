<?php
/**
 * GitHub release update integration via plugin-update-checker.
 *
 * Library: https://github.com/YahnisElsts/plugin-update-checker
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pixel_Diet_Updater {

	const REPO_URL = 'https://github.com/mrclksr2409/pixeldiet/';
	const SLUG     = 'pixel-diet';
	const BRANCH   = 'main';

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

		$update_checker->setBranch( self::BRANCH );

		$vcs_api = $update_checker->getVcsApi();
		if ( $vcs_api && method_exists( $vcs_api, 'enableReleaseAssets' ) ) {
			$vcs_api->enableReleaseAssets( '/pixel-diet.*\.zip$/i' );
		}
	}
}
