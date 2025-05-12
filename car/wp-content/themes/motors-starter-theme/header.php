<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( get_theme_mod( 'mst_fixed_header' ) ? 'mst-fixed-header-on' : '' ); ?>>
	<?php wp_body_open(); ?>
	<div id="wrapper">
		<div id="header">
			<?php get_template_part( 'templates/header' ); ?>
		</div>
		<div id="main">
