<?php

function motors_starter_theme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'motors-starter-theme' ),
		'id'            => 'primary-sidebar',
		'description'   => __( 'Main sidebar that appears on the right.', 'motors-starter-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'motors_starter_theme_widgets_init' );

?>
