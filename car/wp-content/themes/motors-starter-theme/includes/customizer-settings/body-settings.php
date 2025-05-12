<?php
function motors_starter_theme_body_settings( $wp_customize ) {
	$wp_customize->add_section(
		'motors_starter_theme_body_section',
		array(
			'title'    => __( 'Body Settings', 'motors-starter-theme' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'mst_body_image',
		array(
			'default'           => false,
			'transport'         => 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'mst_body_image',
			array(
				'label'    => __( 'Background Image', 'motors-starter-theme' ),
				'section'  => 'motors_starter_theme_body_section',
				'settings' => 'mst_body_image',
			)
		)
	);

	$wp_customize->add_setting(
		'mst_fixed_body_image',
		array(
			'default'           => false,
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'mst_fixed_body_image',
		array(
			'label'   => __( 'Background Image Fixed', 'motors-starter-theme' ),
			'section' => 'motors_starter_theme_body_section',
			'type'    => 'checkbox',
		)
	);
}

add_action( 'customize_register', 'motors_starter_theme_body_settings' );
