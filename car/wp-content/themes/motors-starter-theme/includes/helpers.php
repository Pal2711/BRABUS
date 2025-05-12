<?php
// phpcs:ignoreFile

/**
 * Register Menu for Header
 */

function motors_starter_menu_import() {

	$locations = get_theme_mod( 'nav_menu_locations' );
	$menus     = wp_get_nav_menus();

	if ( ! empty( $menus ) ) {
		foreach ( $menus as $menu ) {
			$menu_names = array(
				'Motors Skins Main Menu',
			);

			if ( is_object( $menu ) && in_array( $menu->name, $menu_names ) ) {
				$locations['motors-starter-theme-main-menu'] = $menu->term_id;
			}
		}
	}
	set_theme_mod( 'nav_menu_locations', $locations );
}

add_action( 'merlin_after_all_import', 'motors_starter_menu_import' );

/**
 * Get Pages by Title
 */
function motors_starter_get_page_id_by_title( $title ) {
	$query = new WP_Query(
		array(
			'post_type'              => 'page',
			'title'                  => $title,
			'post_status'            => 'all',
			'fields'                 => 'ids',
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'orderby'                => 'post_date ID',
			'order'                  => 'ASC',
		)
	);
	wp_reset_postdata();
	return ! empty( $query->posts[0] ) ? $query->posts[0] : null;
}


function elementor_set_default_settings_starter() {
	//Elementor Settings
	$active_kit = intval( get_option( 'elementor_active_kit', 0 ) );
	$meta       = get_post_meta( $active_kit, '_elementor_page_settings', true );

	if ( ! empty( $active_kit ) ) {
		$meta                    = ( ! empty( $meta ) ) ? $meta : array();
		$meta['container_width'] = array(
			'size'  => '1230',
			'unit'  => 'px',
			'sizes' => array(),
		);
		update_post_meta( $active_kit, '_elementor_page_settings', $meta );

		if ( class_exists( 'Elementor\Core\Responsive\Responsive' ) ) {
			Elementor\Core\Responsive\Responsive::compile_stylesheet_templates();
		}
	}

	$elementor_cpt_support = array(
		'post',
		'page',
	);
	update_option( 'elementor_cpt_support', $elementor_cpt_support );

	// AddToAny Share Buttons
	$new_options       = array(
		'icon_size'                         => 20,
		'display_in_posts_on_front_page'    => '-1',
		'display_in_posts_on_archive_pages' => '-1',
		'display_in_excerpts'               => '-1',
		'display_in_posts'                  => '-1',
		'display_in_pages'                  => '-1',
		'display_in_attachments'            => '-1',
		'display_in_feed'                   => '-1',
	);
	$custom_post_types = array_values(
		get_post_types(
			array(
				'public'   => true,
				'_builtin' => false,
			),
			'objects'
		)
	);
	foreach ( $custom_post_types as $custom_post_type_obj ) {
		$placement_name                                     = $custom_post_type_obj->name;
		$new_options[ 'display_in_cpt_' . $placement_name ] = '-1';
	}

	update_option( 'addtoany_options', $new_options );

	global $wpdb;

	$from = trim( 'https://motors.stylemixthemes.com/motors-plugin/' );
	$to   = get_site_url();

	$rows_affected = $wpdb->query(
		$wpdb->prepare(
			"UPDATE {$wpdb->postmeta} 
			SET `meta_value` = REPLACE(`meta_value`, %s, %s) 
			WHERE `meta_key` = '_elementor_data' 
			AND `meta_value` 
			LIKE %s ;",
			array(
				str_replace( '/', '\\\/', $from ),
				str_replace( '/', '\\\/', $to ),
				'[%',
			)
		)
	);

	if ( class_exists( 'Elementor\Core\Responsive\Responsive' ) ) {
		Elementor\Core\Responsive\Responsive::compile_stylesheet_templates();
	}
}

add_action('wp_ajax_motors_starter_theme_builder_option', 'motors_starter_theme_builder_option');

function motors_starter_theme_builder_option() {
	if ( isset( $_POST['wpnonce'] ) && wp_verify_nonce( $_POST['wpnonce'], 'merlin_nonce' ) ) {
		$theme_builder_value = sanitize_text_field($_POST['theme_builder_value']);

		update_option( 'motors-starter-theme-builder', $theme_builder_value );

		wp_send_json_success( array( 'data' => 'Data saved successfully' ) );
	} else {
		wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
	}
}

//Reset elementor cache
function mst_reset_elementor_cache() {

	if ( class_exists( 'Elementor\\Plugin' ) ) {

		Elementor\Plugin::instance()->files_manager->clear_cache();

		$cache_key = Elementor\Api::TRANSIENT_KEY_PREFIX . ELEMENTOR_VERSION;

		$info_data = get_transient( $cache_key );

		$timeout = 25;

		$body_request = array(
			// Which API version is used.
			'api_version' => ELEMENTOR_VERSION,
			// Which language to return.
			'site_lang'   => get_bloginfo( 'language' ),
		);

		$site_key = Elementor\Api::get_site_key();

		if ( ! empty( $site_key ) ) {
			$body_request['site_key'] = $site_key;
		}

		$response = wp_remote_get(
			Elementor\Api::$api_info_url,
			array(
				'timeout' => $timeout,
				'body'    => $body_request,
			)
		);

		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			set_transient( $cache_key, array(), 2 * HOUR_IN_SECONDS );

			return false;
		}

		$info_data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $info_data ) || ! is_array( $info_data ) ) {
			set_transient( $cache_key, array(), 2 * HOUR_IN_SECONDS );

			return false;
		}

		if ( isset( $info_data['library'] ) ) {
			update_option( Elementor\Api::LIBRARY_OPTION_KEY, $info_data['library'], 'no' );

			unset( $info_data['library'] );
		}

		if ( isset( $info_data['feed'] ) ) {
			update_option( Elementor\Api::FEED_OPTION_KEY, $info_data['feed'], 'no' );

			unset( $info_data['feed'] );
		}

		set_transient( $cache_key, $info_data, 12 * HOUR_IN_SECONDS );
	}
}

//Tagging Posts Demo Content
add_action( 'stm_wp_import_insert_post', 'motors_starter_add_demo_meta_box_to_post', 10, 4 );
function motors_starter_add_demo_meta_box_to_post( $post_id ) {
	if ( $post_id && get_post_type( $post_id ) ) {
		update_post_meta( $post_id, 'motors_starter_demo', true );
	}
}

//Tagging Terms Demo Content
add_action( 'stm_wp_import_insert_term', 'motors_starter_add_demo_meta_box_to_term', 10, 4 );
function motors_starter_add_demo_meta_box_to_term( $term ) {
	update_term_meta( $term['term_id'], 'motors_starter_demo', true );
}

//Tagging Menu Items Demo Content
add_action( 'stm_wp_import_update_nav_menu', 'motors_starter_add_demo_meta_box_to_menu_item', 10, 2 );
function motors_starter_add_demo_meta_box_to_menu_item( $post_meta, $id ) {
	update_post_meta( $id, 'motors_starter_demo', true );
}

function mst_body_class($classes) {
    $classes[] = motors_get_skin_name() . '-skin'; // Добавляем класс
    return $classes;
}
add_filter('body_class', 'mst_body_class');

function mst_get_google_fonts_url($fonts, $display = 'auto', $subset = 'cyrillic', $ver = '6.7.2') {
    if (empty($fonts) || !is_array($fonts)) {
        return '';
    }
    
    $font_families = [];
    
    foreach ($fonts as $font_name => $variants) {
        // Replace spaces in names with "+"
        $name_fixed = str_replace(' ', '+', $font_name);
        
        if (!empty($variants) && is_array($variants)) {
            // Join variants with a comma
            $variants_str = implode(',', $variants);
            // Form a string in the format "FontName:variants"
            $family_str = $name_fixed . ':' . $variants_str;
        } else {
            $family_str = $name_fixed;
        }
        // Encode the resulting string (e.g., colon becomes %3A, comma becomes %2C)
        $font_families[] = urlencode($family_str);
    }
    
    // Fonts are separated by "|" (its URL encoding is %7C)
    $families_str = implode('%7C', $font_families);
    
    // Construct the final URL with additional parameters
    $url = "https://fonts.googleapis.com/css?family=" . $families_str .
           "&display=" . urlencode($display) .
           "&subset=" . urlencode($subset) .
           "&ver=" . urlencode($ver);
    
    return $url;
}

add_filter( 'motors_skin_name', 'motors_get_skin_name' );
