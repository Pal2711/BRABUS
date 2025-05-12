<?php get_header(); ?>

<div id="mst-wrapper" class="mst-wrapper">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			$show_title = get_post_meta( get_the_ID(), '_show_page_title', true );
			?>
			<?php if ( $show_title ) : ?>
				<?php get_template_part( 'templates/title-box' ); ?>
			<?php endif; ?>
			<div class="mst-wrapper-inner">
				<div class="container">
					<div class="page-content">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		<?php endwhile;
	endif;
	?>
</div>

<?php get_footer(); ?>