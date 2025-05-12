<?php
	get_header();
?>

<div class="mst-not-found-page">
	<div class="mst-wrapper-inner">
		<div class="container">
			<div class="mst-not-found-page-wrapper">
				<h1 class="mst-not-found-page-title"><?php esc_html_e( '404', 'motors-starter-theme' ); ?></h1>
				<p class="mst-not-found-page-text"><?php esc_html_e( 'The page you are looking for does not exist', 'motors-starter-theme' ); ?></p>
				<a class="mst-not-found-btn mst-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mst-not-found-page-link"><?php esc_html_e( 'Home page', 'motors-starter-theme' ); ?></a>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>