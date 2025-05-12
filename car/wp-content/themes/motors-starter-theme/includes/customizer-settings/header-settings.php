<?php
function motors_starter_theme_header_settings( $wp_customize ) {
	$wp_customize->add_section(
		'motors_starter_theme_header_section',
		array(
			'title'    => __( 'Header Settings', 'motors-starter-theme' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'mst_header_logo',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'mst_header_logo',
			array(
				'label'    => __( 'Logo', 'motors-starter-theme' ),
				'section'  => 'motors_starter_theme_header_section',
				'settings' => 'mst_header_logo',
			)
		)
	);

	$wp_customize->add_setting(
		'mst_fixed_header',
		array(
			'default'           => false,
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'mst_fixed_header',
		array(
			'label'   => __( 'Enable Fixed Header', 'motors-starter-theme' ),
			'section' => 'motors_starter_theme_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'mst_header_logo_width',
		array(
			'default'           => '112',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'mst_header_logo_width',
		array(
			'label'       => __( 'Logo Width (px)', 'motors-starter-theme' ),
			'section'     => 'motors_starter_theme_header_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'mst_header_logo_margin_top',
		array(
			'default'           => '0',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'mst_header_logo_margin_top',
		array(
			'label'       => __( 'Logo Margin Top (px)', 'motors-starter-theme' ),
			'section'     => 'motors_starter_theme_header_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'mst_header_logo_margin_right',
		array(
			'default'           => '100',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'mst_header_logo_margin_right',
		array(
			'label'       => __( 'Logo Margin Right (px)', 'motors-starter-theme' ),
			'section'     => 'motors_starter_theme_header_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'mst_header_logo_margin_bottom',
		array(
			'default'           => '0',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'mst_header_logo_margin_bottom',
		array(
			'label'       => __( 'Logo Margin Bottom (px)', 'motors-starter-theme' ),
			'section'     => 'motors_starter_theme_header_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'mst_header_logo_margin_left',
		array(
			'default'           => '0',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'mst_header_logo_margin_left',
		array(
			'label'       => __( 'Logo Margin Left (px)', 'motors-starter-theme' ),
			'section'     => 'motors_starter_theme_header_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 0,
				'step' => 1,
			),
		)
	);
}

add_action( 'customize_register', 'motors_starter_theme_header_settings' );
