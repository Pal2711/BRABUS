<?php
function motors_starter_theme_footer_settings( $wp_customize ) {
	$wp_customize->add_section(
		'motors_starter_theme_footer_section',
		array(
			'title'    => __( 'Footer Settings', 'motors-starter-theme' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'mst_footer_copyright',
		array(
			'default'           => true,
			'transport'         => 'refresh',
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);

	$wp_customize->add_control(
		'mst_footer_copyright',
		array(
			'label'   => __( 'Display Copyright', 'motors-starter-theme' ),
			'section' => 'motors_starter_theme_footer_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'mst_footer_copyright_text',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'mst_footer_copyright_text',
		array(
			'label'   => __( 'Copyright Text', 'motors-starter-theme' ),
			'section' => 'motors_starter_theme_footer_section',
			'type'    => 'textarea',
		)
	);
}

add_action( 'customize_register', 'motors_starter_theme_footer_settings' );
