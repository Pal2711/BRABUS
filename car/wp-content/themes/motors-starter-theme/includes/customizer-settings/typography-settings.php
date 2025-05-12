<?php

$fonts = array(
	'Arial, sans-serif'             => 'Arial',
	'Georgia, serif'                => 'Georgia',
	'Helvetica, sans-serif'         => 'Helvetica',
	'Times New Roman, serif'        => 'Times New Roman',
	'Verdana, sans-serif'           => 'Verdana',
	'Courier New, monospace'        => 'Courier New',
	'Tahoma, sans-serif'            => 'Tahoma',
	'Roboto, sans-serif'            => 'Roboto',
	'Open Sans, sans-serif'         => 'Open Sans',
	'Lato, sans-serif'              => 'Lato',
	'Montserrat, sans-serif'        => 'Montserrat',
	'Sora, sans-serif'              => 'Sora',
	'Epilogue, sans-serif'          => 'Epilogue',
	'Oswald, sans-serif'            => 'Oswald',
	'Raleway, sans-serif'           => 'Raleway',
	'Poppins, sans-serif'           => 'Poppins',
	'Source Sans Pro, sans-serif'   => 'Source Sans Pro',
	'Nunito, sans-serif'            => 'Nunito',
	'Merriweather, serif'           => 'Merriweather',
	'Playfair Display, serif'       => 'Playfair Display',
	'Droid Sans, sans-serif'        => 'Droid Sans',
	'PT Sans, sans-serif'           => 'PT Sans',
	'Quicksand, sans-serif'         => 'Quicksand',
	'Fira Sans, sans-serif'         => 'Fira Sans',
	'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz',
	'Work Sans, sans-serif'         => 'Work Sans',
	'Cabin, sans-serif'             => 'Cabin',
	'Just Another Hand, cursive'    => 'Just Another Hand',
	'Pacifico, cursive'             => 'Pacifico',
	'Abril Fatface, serif'          => 'Abril Fatface',
	'Architects Daughter, cursive'  => 'Architects Daughter',
	'Bebas Neue, sans-serif'        => 'Bebas Neue',
	'Caveat, cursive'               => 'Caveat',
	'Cherry Swash, cursive'         => 'Cherry Swash',
	'Dancing Script, cursive'       => 'Dancing Script',
	'Eczar, serif'                  => 'Eczar',
	'Exo 2, sans-serif'             => 'Exo 2',
	'Gloria Hallelujah, cursive'    => 'Gloria Hallelujah',
	'Indie Flower, cursive'         => 'Indie Flower',
	'Julius Sans One, sans-serif'   => 'Julius Sans One',
	'Karla, sans-serif'             => 'Karla',
	'Lobster, cursive'              => 'Lobster',
	'Noto Sans, sans-serif'         => 'Noto Sans',
	'Overpass, sans-serif'          => 'Overpass',
	'Reem Kufi, sans-serif'         => 'Reem Kufi',
	'Roboto Slab, serif'            => 'Roboto Slab',
	'Rokkitt, serif'                => 'Rokkitt',
	'Sacramento, cursive'           => 'Sacramento',
	'Sanchez, serif'                => 'Sanchez',
	'Sigmar One, cursive'           => 'Sigmar One',
	'Teko, sans-serif'              => 'Teko',
	'Titillium Web, sans-serif'     => 'Titillium Web',
	'Zilla Slab, serif'             => 'Zilla Slab',
);

function motors_starter_theme_typography_settings( $wp_customize ) {
	global $fonts;

	$wp_customize->add_panel(
		'mst_typography_panel',
		array(
			'title'    => __( 'Typography', 'motors-starter-theme' ),
			'priority' => 10,
		)
	);

	$wp_customize->add_section(
		'mst_typography_body_section',
		array(
			'title'    => __( 'Body', 'motors-starter-theme' ),
			'priority' => 10,
			'panel'    => 'mst_typography_panel',
		)
	);

	$wp_customize->add_section(
		'mst_typography_headings_section',
		array(
			'title'    => __( 'Headings', 'motors-starter-theme' ),
			'priority' => 20,
			'panel'    => 'mst_typography_panel',
		)
	);

	$wp_customize->add_setting(
		'mst_body_font_family',
		array(
			'default'   => 'Montserrat, sans-serif',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		'mst_body_font_family_control',
		array(
			'label'    => __( 'Body Font Family', 'motors-starter-theme' ),
			'section'  => 'mst_typography_body_section',
			'settings' => 'mst_body_font_family',
			'type'     => 'select',
			'choices'  => $fonts,
		)
	);

	$wp_customize->add_setting(
		'mst_body_font_size',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		'mst_body_font_size_control',
		array(
			'label'    => __( 'Body Font Size', 'motors-starter-theme' ),
			'section'  => 'mst_typography_body_section',
			'settings' => 'mst_body_font_size',
			'type'     => 'number',
		)
	);

	$wp_customize->add_setting(
		'mst_body_text_transform',
		array(
			'default'   => 'none',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		'mst_body_text_transform_control',
		array(
			'label'    => __( 'Body Text Transform', 'motors-starter-theme' ),
			'section'  => 'mst_typography_body_section',
			'settings' => 'mst_body_text_transform',
			'type'     => 'select',
			'choices'  => array(
				'none'       => __( 'None', 'motors-starter-theme' ),
				'capitalize' => __( 'Capitalize', 'motors-starter-theme' ),
				'uppercase'  => __( 'Uppercase', 'motors-starter-theme' ),
				'lowercase'  => __( 'Lowercase', 'motors-starter-theme' ),
			),
		)
	);

	$wp_customize->add_setting(
		'mst_body_font_weight',
		array(
			'default'   => '400',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		'mst_body_font_weight_control',
		array(
			'label'    => __( 'Body Font Weight', 'motors-starter-theme' ),
			'section'  => 'mst_typography_body_section',
			'settings' => 'mst_body_font_weight',
			'type'     => 'select',
			'choices'  => array(
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900',
			),
		)
	);

	$wp_customize->add_setting(
		'mst_headings_font_family',
		array(
			'default'   => 'Montserrat, sans-serif',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		'mst_headings_font_family_control',
		array(
			'label'    => __( 'Headings Font Family', 'motors-starter-theme' ),
			'section'  => 'mst_typography_headings_section',
			'settings' => 'mst_headings_font_family',
			'type'     => 'select',
			'choices'  => $fonts,
		)
	);

	$headings = array(
		'h1' => 'H1',
		'h2' => 'H2',
		'h3' => 'H3',
		'h4' => 'H4',
		'h5' => 'H5',
		'h6' => 'H6',
	);

	foreach ( $headings as $heading_key => $heading_label ) {
		$wp_customize->add_setting(
			$heading_key . '_font_family',
			array(
				'default'   => 'Montserrat, sans-serif',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_setting(
			$heading_key . '_font_size',
			array(
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			$heading_key . '_font_size_control',
			array(
				'label'    => $heading_label . ' ' . __( 'Font Size', 'motors-starter-theme' ),
				'section'  => 'mst_typography_headings_section',
				'settings' => $heading_key . '_font_size',
				'type'     => 'number',
			)
		);

		$wp_customize->add_setting(
			$heading_key . '_line_height',
			array(
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			$heading_key . '_line_height_control',
			array(
				'label'    => $heading_label . ' ' . __( 'Line Height', 'motors-starter-theme' ),
				'section'  => 'mst_typography_headings_section',
				'settings' => $heading_key . '_line_height',
				'type'     => 'number',
			)
		);

		$wp_customize->add_control(
			$heading_key . '_font_family_control',
			array(
				'label'    => $heading_label . ' ' . __( 'Font Family', 'motors-starter-theme' ),
				'section'  => 'mst_typography_headings_section',
				'settings' => $heading_key . '_font_family',
				'type'     => 'select',
				'choices'  => $fonts,
			)
		);
	}
}

add_action( 'customize_register', 'motors_starter_theme_typography_settings' );
