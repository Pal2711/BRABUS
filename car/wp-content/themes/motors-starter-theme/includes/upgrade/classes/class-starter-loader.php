<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


require_once MOTORS_STARTER_THEME_DIR . '/includes/upgrade/helpers/class-starter-updater.php';
require_once MOTORS_STARTER_THEME_DIR . '/includes/upgrade/helpers/update-checker.php';

/**
 * Class Loader
 * base plugin functions here
 */
class StarterLoader {

	protected function get_current_theme_text_domain() {
		$current_theme = wp_get_theme();

		return $current_theme->get( 'TextDomain' );
	}

	public function __construct() {

		if ( empty( get_transient( 'motors_starter_theme_version' ) ) ) {
			set_transient( 'motors_starter_theme_version', StarterUpdateCheck::starter_server_version(), 12 * 60 * 60 );
		}
		StarterUpdateCheck::starter_update_notice();

		add_action( 'wp_ajax_mvl_stm_update_starter_theme', array( $this, 'mvl_stm_update_starter_theme' ) );
		add_action( 'wp_ajax_nopriv_mvl_stm_update_starter_theme', array( $this, 'mvl_stm_update_starter_theme' ) );

		if ( ! current_user_can( 'update_themes' ) ) {
			return;
		}
	}

	/** Ajax query - installation */
	public function mvl_stm_update_starter_theme() {

		check_ajax_referer( 'mvl_stm_update_starter_theme', 'nonce' );

		if ( ! current_user_can( 'manage_options' )
			|| ! current_user_can( 'install_themes' ) ) {
			return;
		}

		$slug = sanitize_text_field( $_POST['slug'] );
		$type = sanitize_text_field( $_POST['type'] );

		$this->install( $slug, $type );
	}

	private function install( $slug, $type ) {

		if ( 'theme' === $type ) {
			require_once MOTORS_STARTER_THEME_DIR . '/includes/upgrade/helpers/class-starter-updater.php';
		}
		$data = StarterUpdater::get_item_info( $slug );
		if ( true === $data['is_update_available'] ) {
			StarterUpdater::install( $slug );
			StarterUpdater::activate( $slug );
		}

		if ( $data['is_installed'] && false === $data['is_active'] ) {
			StarterUpdater::activate( $slug );
		}
	}

}

new StarterLoader();
