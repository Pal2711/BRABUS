<?php
define( 'MOTORS_STARTER_THEME_DIR', get_parent_theme_file_path() );
define( 'MOTORS_STARTER_THEME_INC_PATH', get_parent_theme_file_path() . '/includes' );
define( 'MOTORS_STARTER_THEME_URI', get_parent_theme_file_uri() );
define( 'MOTORS_STARTER_THEME_VERSION', ( WP_DEBUG ) ? time() : wp_get_theme()->get( 'Version' ) );
define( 'MOTORS_STARTER_THEME_TEMPLATE_URI', get_template_directory_uri() );
define( 'MOTORS_STARTER_THEME_TEMPLATE_DIR', get_template_directory() );
define( 'MOTORS_STARTER_LIVE_URL', 'https://motors-plugin.stylemixthemes.com/starter-theme-demo/' );
define( 'MICRO_SERVICE_URL', 'https://microservices.stylemixthemes.com/changelog/' );
define( 'MOTORS_STARTER_THEME_PRICING_PLANS_LINK', admin_url( 'admin.php?page=mvl-go-pro' ) );

/* Including plugins TGM */
require_once MOTORS_STARTER_THEME_TEMPLATE_DIR . '/includes/tgm/theme-required-plugins.php';

require_once MOTORS_STARTER_THEME_TEMPLATE_DIR . '/includes/customizer-settings/header-settings.php';
require_once MOTORS_STARTER_THEME_TEMPLATE_DIR . '/includes/customizer-settings/body-settings.php';
require_once MOTORS_STARTER_THEME_TEMPLATE_DIR . '/includes/customizer-settings/footer-settings.php';
require_once MOTORS_STARTER_THEME_TEMPLATE_DIR . '/includes/customizer-settings/typography-settings.php';
require_once MOTORS_STARTER_THEME_TEMPLATE_DIR . '/includes/customizer-settings/preloader-settings.php';
require_once MOTORS_STARTER_THEME_TEMPLATE_DIR . '/includes/customizer.php';
require_once MOTORS_STARTER_THEME_TEMPLATE_DIR . '/includes/widgets.php';
require_once MOTORS_STARTER_THEME_TEMPLATE_DIR . '/includes/helpers.php';

function motors_starter_setup() {
	register_nav_menus(
		array(
			'menu-1' => __( 'Primary Menu', 'motors-starter-theme' ),
		)
	);

	if ( ! current_user_can( 'delete_posts' ) && ! is_admin() ) {
		show_admin_bar( false );
	}
}
add_action( 'after_setup_theme', 'motors_starter_setup' );

require_once MOTORS_STARTER_THEME_DIR . '/includes/upgrade/classes/class-starter-loader.php';

function motors_starter_enqueue_scripts_and_styles() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'motors-starter-theme-styles', MOTORS_STARTER_THEME_URI . '/assets/css/style.css', array(), MOTORS_STARTER_THEME_VERSION );
	wp_enqueue_style( 'motors-starter-theme-fa-styles', MOTORS_STARTER_THEME_URI . '/assets/css/fontawesome.min.css', array( 'motors-starter-theme-styles' ), MOTORS_STARTER_THEME_VERSION );
	wp_enqueue_script( 'motors-starter-theme-scripts', MOTORS_STARTER_THEME_URI . '/assets/js/script.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'motors_starter_enqueue_scripts_and_styles' );

function motors_starter_enqueue_admin_styles() {
	wp_enqueue_style( 'motors-starter-admin-styles', MOTORS_STARTER_THEME_URI . '/assets/css/admin-style.css', array(), MOTORS_STARTER_THEME_VERSION );
}
add_action( 'admin_enqueue_scripts', 'motors_starter_enqueue_admin_styles' );

function motors_starter_enqueue_preloader_scripts() {
	wp_enqueue_script( 'motors-starter-theme-preloader', get_template_directory_uri() . '/assets/js/preloader.js', array(), '1.0', true );
	$preloader_enabled = get_theme_mod( 'motors_starter_theme_preloader_enabled', true );
	$timeout_enabled   = get_theme_mod( 'motors_starter_theme_preloader_timeout_enabled', false );
	$preloader_timeout = get_theme_mod( 'motors_starter_theme_preloader_timeout', 3 );
	wp_localize_script(
		'motors-starter-theme-preloader',
		'motorsPreloaderSettings',
		array(
			'preloaderEnabled' => $preloader_enabled,
			'timeoutEnabled'   => $timeout_enabled,
			'preloaderTimeout' => $preloader_timeout,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'motors_starter_enqueue_preloader_scripts' );

function enqueue_motors_starter_theme_admin_scripts() {
	wp_enqueue_media();
	wp_enqueue_script( 'motors-starter-admin-script', MOTORS_STARTER_THEME_URI . '/assets/js/admin.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
	wp_enqueue_script( 'motors-starter-admin-script', MOTORS_STARTER_THEME_URI . '/assets/js/admin.js', array( 'jquery' ), MOTORS_STARTER_THEME_VERSION, true );
	wp_localize_script(
		'motors-starter-admin-script',
		'mvl_starter_theme_nonces',
		array(
			'mvl_stm_update_starter_theme' => wp_create_nonce( 'mvl_stm_update_starter_theme' ),
		)
	);
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}

add_action( 'admin_enqueue_scripts', 'enqueue_motors_starter_theme_admin_scripts' );

function add_title_box_meta_box() {
	add_meta_box(
		'title_box_meta',
		'Title Box',
		'render_title_box_meta_box',
		array( 'page', 'post' ),
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'add_title_box_meta_box' );

function render_title_box_meta_box( $post ) {
	$show_title       = get_post_meta( $post->ID, '_show_page_title', true );
	$background_image = get_post_meta( $post->ID, '_background_image', true );
	$text_color       = get_post_meta( $post->ID, '_title_box_text_color', true );
	?>
	<label for="show_page_title">
		<input type="checkbox" name="show_page_title" id="show_page_title" value="1" <?php checked( $show_title, '1' ); ?> />
		<?php esc_html_e( 'Show Title Box', 'motors-starter-theme' ); ?>
	</label>
	<br /><br />

	<label for="background_image">
		<?php esc_html_e( 'Background Image', 'motors-starter-theme' ); ?>
	</label>
	<input type="text" name="background_image" id="background_image" value="<?php echo esc_url( $background_image ); ?>" style="width: 80%;" />
	<button type="button" class="button button-secondary" id="upload_image_button"><?php esc_html_e( 'Upload Image', 'motors-starter-theme' ); ?></button>
	<br /><br />

	<label for="title_box_text_color">
		<?php esc_html_e( 'Title Box Text Color', 'motors-starter-theme' ); ?>
	</label>
	<input type="text" name="title_box_text_color" id="title_box_text_color" value="<?php echo esc_attr( $text_color ); ?>" class="color-picker" data-default-color="#000000" />
	<br /><br />
	<?php
	wp_nonce_field( 'save_show_page_title', 'show_page_title_nonce' );
}

function save_title_box_meta_box( $post_id ) {
	if ( ! isset( $_POST['show_page_title_nonce'] ) || ! wp_verify_nonce( $_POST['show_page_title_nonce'], 'save_show_page_title' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['show_page_title'] ) ) {
		update_post_meta( $post_id, '_show_page_title', '1' );
	} else {
		delete_post_meta( $post_id, '_show_page_title' );
	}

	if ( isset( $_POST['background_image'] ) ) {
		update_post_meta( $post_id, '_background_image', sanitize_text_field( $_POST['background_image'] ) );
	} else {
		delete_post_meta( $post_id, '_background_image' );
	}

	if ( isset( $_POST['title_box_text_color'] ) ) {
		update_post_meta( $post_id, '_title_box_text_color', sanitize_hex_color( $_POST['title_box_text_color'] ) );
	} else {
		delete_post_meta( $post_id, '_title_box_text_color' );
	}
}

add_action( 'save_post', 'save_title_box_meta_box' );

if ( ! function_exists( 'motors_starter_theme_comments' ) ) {
	function motors_starter_theme_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP );

		if ( 'div' === $args['style'] ) {
			$tag       = 'div ';
			$add_below = 'comment';
		} else {
			$tag       = 'li ';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ); ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' !== $args['style'] ) { ?>
			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body clearfix">
		<?php } ?>
		<?php if ( 0 !== $args['avatar_size'] ) { ?>
			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 80 ); ?>
			</div>
		<?php } ?>
		<div class="comment-info-wrapper">
			<div class="comment-info">
				<div class="comment-info-inner">
					<div class="comment-author pull-left"><span><?php echo get_comment_author_link(); ?></span></div>
					<div class="comment-meta comment-meta-data pull-right">
						<a class="comment-date" href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
							<?php printf( '%1$s', esc_html( get_comment_date() ) ); ?>
						</a>
						<span class="comment-meta-data-unit">
							<?php
							comment_reply_link(
								array_merge(
									$args,
									array(
										'reply_text' => __( '<span class="comment-divider">/</span><i class="fas fa-reply"></i> Reply', 'motors-starter-theme' ),
										'add_below'  => $add_below,
										'depth'      => $depth,
										'max_depth'  => $args['max_depth'],
									)
								)
							);
							?>
						</span>
						<span class="comment-meta-data-unit">
							<?php edit_comment_link( __( '<span class="comment-divider">/</span><i class="fas fa-pen-square"></i> Edit', 'motors-starter-theme' ), '  ', '' ); ?>
						</span>
					</div>
				</div>
				<?php if ( '0' === $comment->comment_approved ) { ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'motors-starter-theme' ); ?></em>
				<?php } ?>
			</div>
			<div class="comment-text">
				<?php comment_text(); ?>
			</div>
		</div>

		<?php if ( 'div' !== $args['style'] ) { ?>
			</div>
		<?php } ?>
		<?php
	}
}


function motors_starter_theme_comment_form_defaults( $defaults ) {
	$defaults['comment_field'] = '<p class="comment-form-comment">' .
		'<textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Message *', 'motors-starter-theme' ) . '" cols="45" rows="8" aria-required="true"></textarea>' .
		'</p>';
	return $defaults;
}

add_filter( 'comment_form_defaults', 'motors_starter_theme_comment_form_defaults' );

function motors_custom_comment_form_fields( $fields ) {
	$fields['author'] = '<div class="comment-form-fields-container">' .
		'<p class="comment-form-author">' .
		'<input id="author" name="author" type="text" placeholder="' . esc_attr__( 'Your Name *', 'motors-starter-theme' ) . '" value="" size="30" /></p>';

	$fields['email'] = '<p class="comment-form-email">' .
		'<input id="email" name="email" type="text" placeholder="' . esc_attr__( 'Your Email *', 'motors-starter-theme' ) . '" value="" size="30" /></p>';

	$fields['url'] = '<p class="comment-form-url">' .
		'<input id="url" name="url" type="text" placeholder="' . esc_attr__( 'Your Website', 'motors-starter-theme' ) . '" value="" size="30" /></p>';

	$fields['url'] .= '</div>';

	return $fields;
}

add_filter( 'comment_form_default_fields', 'motors_custom_comment_form_fields' );

function motors_starter_pagination( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'prev_text' => wp_kses_post( '<i class="fas fa-chevron-left"></i>' ),
			'next_text' => wp_kses_post( '<i class="fas fa-chevron-right"></i>' ),
			'type'      => 'array',
			'prev_next' => true,
		)
	);

	$links = paginate_links( $args );

	if ( is_array( $links ) ) {
		echo wp_kses_post( '<div class="mst-pagination-numbers"><ul class="mst-page-numbers-list">' );
		foreach ( $links as $link ) {
			echo wp_kses_post( '<li>' . $link . '</li>' );
		}
		echo wp_kses_post( '</ul></div>' );
	}
}

function custom_404_title() {
	if ( is_404() ) {
		echo wp_kses_post( '<title>' . esc_html( 'Page Not Found | ' . get_bloginfo( 'name' ) ) . '</title>' );
	}
}

add_action( 'wp_head', 'custom_404_title' );

add_action(
	'admin_init',
	function () {
		delete_transient( 'elementor_activation_redirect' );
	}
);

function custom_dynamic_title() {
	if ( is_home() || is_front_page() ) {
		echo '<title>' . esc_html( get_bloginfo( 'name' ) ) . ' | ' . esc_html( get_bloginfo( 'description' ) ) . '</title>';
	} elseif ( is_single() || is_page() ) {
		echo '<title>' . esc_html( get_the_title() ) . ' - ' . esc_html( get_bloginfo( 'name' ) ) . ' | ' . esc_html( get_bloginfo( 'description' ) ) . '</title>';
	} elseif ( is_category() || is_tag() || is_tax() ) {
		echo '<title>' . esc_html( single_term_title( '', false ) ) . ' - ' . esc_html( get_bloginfo( 'name' ) ) . ' | ' . esc_html( get_bloginfo( 'description' ) ) . '</title>';
	} else {
		echo '<title>' . esc_html( get_bloginfo( 'name' ) ) . ' - ' . esc_html( get_bloginfo( 'description' ) ) . '</title>';
	}
}

add_action( 'wp_head', 'custom_dynamic_title' );

function motors_starter_theme_favicon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		wp_site_icon();
	} else {
		echo '<link rel="icon" href="' . esc_url( get_template_directory_uri() . '/assets/images/favicon.ico' ) . '" type="image/x-icon">';
	}
}

add_action( 'wp_head', 'motors_starter_theme_favicon' );

function motors_starter_theme_preloader_html() {
	if ( get_theme_mod( 'motors_starter_theme_preloader_enabled', true ) ) :
		?>
		<div id="preloader" style="display: block;">
			<div class="spinner"></div>
		</div>
		<?php
		endif;
}

add_action( 'wp_head', 'motors_starter_theme_preloader_html' );

/**
 * Include dashboard.php
 */
if ( is_admin() ) {
	require_once MOTORS_STARTER_THEME_DIR . '/includes/dashboard/init.php';
	require_once MOTORS_STARTER_THEME_DIR . '/includes/dashboard/resources/includes/system-status.php';
	require_once MOTORS_STARTER_THEME_DIR . '/includes/dashboard/resources/includes/changelog.php';
	require_once MOTORS_STARTER_THEME_DIR . '/includes/dashboard/wizard/includes/functions.php';
	require_once MOTORS_STARTER_THEME_DIR . '/includes/dashboard/wizard/includes/after_demo_import.php';

	Motors_Templates_Changelog::init();
}
