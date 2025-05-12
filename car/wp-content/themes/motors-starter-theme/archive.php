<?php get_header(); ?>
<div class="mst-posts-wrapper">
	<?php get_template_part( 'templates/title-box' ); ?>
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="posts-list">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h2 class="post-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="post-meta">
							<div class="post-meta-info post-author-wrapp">
								<h5 class="post-author"><?php esc_html_e('Author:', 'motors-starter-theme'); ?></h5>
								<p class="post-author-name"><?php the_author(); ?></p>
							</div>
							<div class="post-meta-info post-date-wrapp">
								<h5 class="post-date-label"><?php esc_html_e('Date:', 'motors-starter-theme'); ?></h5>
								<p class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></p>
							</div>
						</div>
						<div class="post-excerpt">
							<?php the_excerpt(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div class="mst-pagination pagination">
				<?php
					motors_starter_pagination(array(
						'prev_text' => '<i class="fas fa-chevron-left"></i>',
						'next_text' => '<i class="fas fa-chevron-right"></i>',
					));
				?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts found in this category.', 'motors-starter-theme' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>