<?php
function motors_starter_theme_preloader_settings( $wp_customize ) {
	$wp_customize->add_section(
		'motors_starter_theme_preloader_section',
		array(
			'title'    => __( 'Preloader Settings', 'motors-starter-theme' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'motors_starter_theme_preloader_enabled',
		array(
			'default'   => true,
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		'motors_starter_theme_preloader_enabled',
		array(
			'label'    => __( 'Enable Preloader', 'motors-starter-theme' ),
			'section'  => 'motors_starter_theme_preloader_section',
			'settings' => 'motors_starter_theme_preloader_enabled',
			'type'     => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'motors_starter_theme_preloader_timeout_enabled',
		array(
			'default'   => false,
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		'motors_starter_theme_preloader_timeout_enabled',
		array(
			'label'           => __( 'Enable Preloader Timeout', 'motors-starter-theme' ),
			'section'         => 'motors_starter_theme_preloader_section',
			'settings'        => 'motors_starter_theme_preloader_timeout_enabled',
			'type'            => 'checkbox',
			'active_callback' => function() use ( $wp_customize ) {
				return $wp_customize->get_setting( 'motors_starter_theme_preloader_enabled' )->value();
			},
		)
	);

	$wp_customize->add_setting(
		'motors_starter_theme_preloader_timeout',
		array(
			'default'           => '5',
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'motors_starter_theme_preloader_timeout',
		array(
			'label'           => __( 'Preloader Timeout (in seconds)', 'motors-starter-theme' ),
			'section'         => 'motors_starter_theme_preloader_section',
			'settings'        => 'motors_starter_theme_preloader_timeout',
			'type'            => 'number',
			'input_attrs'     => array(
				'min'  => 1,
				'step' => 1,
			),
			'active_callback' => function() use ( $wp_customize ) {
				return $wp_customize->get_setting( 'motors_starter_theme_preloader_timeout_enabled' )->value();
			},
		)
	);
}

add_action( 'customize_register', 'motors_starter_theme_preloader_settings' );
