<?php

function motors_starter_theme_customize_register( $wp_customize ) {
	do_action( 'motors_starter_theme_colors', $wp_customize );
	do_action( 'motors_starter_theme_header_settings', $wp_customize );
	do_action( 'motors_starter_theme_body_settings', $wp_customize );
	do_action( 'motors_starter_theme_footer_settings', $wp_customize );
	do_action( 'motors_starter_theme_typography_settings', $wp_customize );
	do_action( 'motors_starter_theme_preloader_settings', $wp_customize );
}

add_action( 'customize_register', 'motors_starter_theme_customize_register' );

function motors_starter_theme_header_customize_css() {
	?>
	<style type="text/css" id='motors-starter-header-styles'>
		.listing-logo-main .bloglogo {
			margin-top: <?php echo esc_attr( get_theme_mod( 'mst_header_logo_margin_top', '0' ) ); ?>px;
			margin-right: <?php echo esc_attr( get_theme_mod( 'mst_header_logo_margin_right', '100' ) ); ?>px;
			margin-bottom: <?php echo esc_attr( get_theme_mod( 'mst_header_logo_margin_bottom', '0' ) ); ?>px;
			margin-left: <?php echo esc_attr( get_theme_mod( 'mst_header_logo_margin_left', '0' ) ); ?>px;
		}
		.listing-logo-main .bloglogo img {
			width: <?php echo esc_attr( get_theme_mod( 'mst_header_logo_width', '112' ) ); ?>px;
		}
	</style>
	<?php
}

add_action( 'wp_head', 'motors_starter_theme_header_customize_css' );

function motors_starter_theme_body_customize_image() {
	$background_image       = get_theme_mod( 'mst_body_image', '' );
	$background_image_fixed = get_theme_mod( 'mst_fixed_body_image', false );
	if ( $background_image ) :
		?>
	<div class="mst-body-background-image <?php echo $background_image_fixed ? 'mst-body-background-image-fixed' : ''; ?>">
		<img
			height="1"
			width="1"
			srcset="<?php echo esc_attr( $background_image ); ?>"
			alt="<?php echo esc_attr( get_the_title() ); ?>"
			class="img-responsive" loading="lazy"
		/>
	</div>
		<?php
	endif;
}

add_action( 'wp_body_open', 'motors_starter_theme_body_customize_image' );

function motors_starter_theme_typography_customize_css() {
	$headings = array(
		'h1' => 'H1',
		'h2' => 'H2',
		'h3' => 'H3',
		'h4' => 'H4',
		'h5' => 'H5',
		'h6' => 'H6',
	);
	?>
	<style type="text/css" id='motors-starter-typo-styles'>
		body {
			font-family: <?php echo esc_attr( get_theme_mod( 'mst_body_font_family', 'Montserrat' ) ); ?>;
			font-size: <?php echo esc_attr( get_theme_mod( 'mst_body_font_size', '' ) ); ?>px;
			font-weight: <?php echo esc_attr( get_theme_mod( 'mst_body_font_weight', '400' ) ); ?>;
			text-transform: <?php echo esc_attr( get_theme_mod( 'mst_body_text_transform', 'none' ) ); ?>;
		}
		p {
			font-size: <?php echo esc_attr( get_theme_mod( 'mst_body_font_size', '' ) ); ?>;
		}
		a {
			font-size: <?php echo esc_attr( get_theme_mod( 'mst_body_font_size', '' ) ); ?>;
		}
		<?php foreach ( $headings as $heading_key => $heading_label ) : ?>
			<?php echo wp_kses_post( $heading_key ); ?> {
				font-family: <?php echo esc_attr( get_theme_mod( $heading_key . '_font_family', 'Montserrat' ) ); ?>;
				font-size: <?php echo esc_attr( get_theme_mod( $heading_key . '_font_size', '' ) ); ?>px;
				text-transform: <?php echo esc_attr( get_theme_mod( $heading_key . '_text_transform', 'none' ) ); ?>;
				line-height: <?php echo esc_attr( get_theme_mod( $heading_key . '_line_height', '' ) ); ?>px;
				font-weight: <?php echo esc_attr( get_theme_mod( $heading_key . '_font_weight', '' ) ); ?>;
			}
		<?php endforeach; ?>
	</style>
	<?php
}

add_action( 'wp_head', 'motors_starter_theme_typography_customize_css' );


function mst_enqueue_customize_typography() {
	$headings = array(
		'h1' => 'H1',
		'h2' => 'H2',
		'h3' => 'H3',
		'h4' => 'H4',
		'h5' => 'H5',
		'h6' => 'H6',
	);

	if ( apply_filters( 'motors_skin_name', 'free' ) === 'luxury' ) {
		$fonts_list = array();

		foreach ( $headings as $heading_key => $heading_label ) :
			$font_name                = esc_attr( get_theme_mod( $heading_key . '_font_family', 'Montserrat' ) );
			$font_weight              = esc_attr( get_theme_mod( $heading_key . '_font_weight', '400' ) );
			$exploded_font_name       = explode( ',', $font_name );
			$font_name                = isset( $exploded_font_name[0] ) ? $exploded_font_name[0] : $font_name;
			$fonts_list[ $font_name ] = array();

			if ( ! isset( $fonts_list[ $font_name ] ) || isset( $fonts_list[ $font_name ] ) && ! in_array( $font_weight, $fonts_list[ $font_name ] ) ) {
				$fonts_list[ $font_name ][] = $font_weight;
			}
		endforeach;

		$fonts_url = mst_get_google_fonts_url( $fonts_list );
		wp_enqueue_style( 'mst-google-fonts', $fonts_url, array(), MOTORS_STARTER_THEME_VERSION );
	}
}
add_action( 'wp_enqueue_scripts', 'mst_enqueue_customize_typography' );

?>
