<?php
/**
 * Init Styles & scripts
 */

function motors_starter_admin_script_styles() {
	if ( 'toplevel_page_cost_calculator_builder' !== get_current_screen()->base ) {
		wp_enqueue_script( 'admin_motors_starter_script', MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/js/admin_scripts.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
		wp_localize_script(
			'admin_motors_starter_script',
			'mst_starter_theme_data',
			array(
				'mst_admin_ajax_url'           => admin_url( 'admin-ajax.php' ),
				'motors_starter_plugins_nonce' => wp_create_nonce( 'motors_starter_wizard_nonce' ),
			)
		);
		wp_enqueue_style( 'admin_motors_starter_style', MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/css/admin_styles.css', '', MOTORS_STARTER_THEME_VERSION );
		wp_enqueue_style( 'starter-icons', MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/fonts/ms/style.css', array(), MOTORS_STARTER_THEME_VERSION );
	}

	wp_enqueue_style( 'noto-sans', 'https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap', array(), MOTORS_STARTER_THEME_VERSION );
	wp_enqueue_style( 'motors-starter-wizard', MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/css/wizard.css', '', MOTORS_STARTER_THEME_VERSION );
	wp_enqueue_script( 'lottie-player', 'https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
	wp_enqueue_script( 'motors-starter-pro', MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/js/pro.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
	wp_enqueue_script( 'motors-starter-wizard', MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/js/wizard.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
	wp_enqueue_script( 'motors-starter-plugins', MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/js/install-plugins.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
	wp_enqueue_script( 'motors-starter-demo-import', MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/js/demo-import.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
	wp_enqueue_script( 'motors-starter-child-theme', MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/js/child-theme.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
}

add_action( 'admin_enqueue_scripts', 'motors_starter_admin_script_styles' );

function motors_starter_show_nav_item() {
	add_submenu_page(
		'mvl_plugin_settings',
		__( 'Welcome to Motors Skin Page', 'stm_vehicles_listing' ),
		esc_html__( 'Motors Skins', 'motors-starter-theme' ),
		'manage_options',
		'mst-starter-options',
		'motors_starter_admin_page_content',
	);
}

add_action( 'wpcfto_screen_motors_vehicles_listing_plugin_settings_added', 'motors_starter_show_nav_item', 12, 1 );

function motors_starter_admin_page_content() {
	?>
	<div class="mst-starter-info-box">
		<div class="mst-starter-info-box-column">
			<div class="mst-starter-info-box-links">
				<div class="logo">
					<img src="<?php echo esc_url( MOTORS_STARTER_THEME_TEMPLATE_URI . '/includes/dashboard/assets/images/motors-logo-128px.svg' ); ?>" alt="Motors Logo" width="128" height="128">
					<div class="logo-info">
						Welcome to
						<strong>Motors Skins</strong>
					</div>
				</div>
				<div class="starter-dashboard-text">Motors Skins are pre-designed website layouts for the Motors plugin that allow you to showcase vehicle listings. Choose from skins tailored for any type of vehicle. With a one-click setup and full customization options, you can quickly build a stunning and specialized site for your listings.</div>
			</div>
			<div class="mst-starter-info-box-tabs">
				<a href="#" class="m_s_t-starter-templates mst-starter-templates-tab active">Skins</a>
				<a href="#" class="m_s_t-starter-changelog mst-starter-templates-tab">Changelog</a>
				<a href="#" class="m_s_t-starter-system-status mst-starter-templates-tab">System Status</a>
				<div class="mst-starter-info-box-right">
					<?php if ( defined( 'HFE_VER' ) ) : ?>
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=elementor-hf' ) ); ?>" class="m_s_t-starter-elementor-header-footer"><i class="mst-icon-layout"></i> Customize Header & Footer</a>
					<?php endif; ?>
					<div class="helper-menu-wrap">
						<a href="#" class="m_s_t-starter-helper"><i class="mst-icon-Help"></i> Help <i class="mst-icon-chevron-down"></i></a>
						<div class="helper-submenu">
							<a href="https://docs.stylemixthemes.com/motors-car-dealer-classifieds-and-listing/getting-started/motors-starter-theme" target="_blank"><i class="mst-icon-documentation"></i>Documentation</a>
							<a href="<?php echo ( apply_filters( 'is_mvl_pro', false ) ) ? 'https://support.stylemixthemes.com/tickets/new/support?item_id=43' : 'https://wordpress.org/support/plugin/motors-car-dealership-classified-listings/'; ?>" target="_blank"><i class="mst-icon-Support"></i>Support Center</a>
							<a href="https://www.facebook.com/groups/motorstheme" target="_blank"><i class="mst-icon-Facebook"></i>Facebook Community</a>
							<a href="https://stylemixthemes.cnflx.io/boards/motors-car-dealer-rental-classifieds" target="_blank"><i class="mst-icon-Feedback"></i>Feature request</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			require_once MOTORS_STARTER_THEME_DIR . '/includes/dashboard/resources/templates/changelog.php';
			require_once MOTORS_STARTER_THEME_DIR . '/includes/dashboard/resources/templates/system-status.php';
		?>
		<div class="mst-starter-wizard mst-starter-templates">
			<div class="mst-starter-wizard__navigation">
				<ul class="mst-starter-wizard__navigation-progress-bar">
					<li class="progress-step-templates active"><span><em>1</em><i class="mst-icon-check"></i></span> <?php echo esc_html__( 'Choose Skin', 'motors-starter-theme' ); ?></li>
					<li class="progress-step-plugins"><span><em>2</em><i class="mst-icon-check"></i></span> <?php echo esc_html__( 'Plugin installation', 'motors-starter-theme' ); ?></li>
					<li class="progress-step-demo-content"><span><em>3</em><i class="mst-icon-check"></i></span> <?php echo esc_html__( 'Demo content import', 'motors-starter-theme' ); ?></li>
					<li class="progress-step-child-theme"><span><em>4</em><i class="mst-icon-check"></i></span> <?php echo esc_html__( 'Child theme installation', 'motors-starter-theme' ); ?></li>
				</ul>
			</div>
			<div class="mst-starter-wizard__wrapper">
				<?php load_template( MOTORS_STARTER_THEME_DIR . '/includes/dashboard/wizard/templates/templates.php', true ); ?>
			</div>
		</div>
	</div>
	<?php
}

//Remove all notices
add_action(
	'admin_head',
	function() {
		$screen = get_current_screen();

		if ( 'mst-starter_page_mst-starter-demo-import' === $screen->id || 'toplevel_page_mst-starter-options' === $screen->id ) {
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}
	},
	100
);
