<?php get_header(); ?>

<div id="mst-wrapper" class="mst-wrapper">
	<?php
	$show_title = get_post_meta( get_the_ID(), '_show_page_title', true );
	if ( have_posts() ) :
		while ( have_posts() ) : the_post(); ?>
			<?php if ( $show_title ) : ?>
				<?php get_template_part( 'templates/title-box' ); ?>
			<?php endif; ?>
			<div class="mst-wrapper-inner">
				<div class="container">
					<h1 class="post-title"><?php the_title(); ?></h1>
					<div class="mst-post-meta">
						<div class="post-meta">
							<div class="post-meta-info">
								<p class="post-meta-author-name">
									<i class="fa-solid fa-calendar"></i>
									<?php esc_html_e( 'Posted by:', 'motors-starter-theme' ); ?> <?php echo esc_html( get_the_author() ); ?>
								</p>
								<p class="post-meta-date">
									<i class="fa-solid fa-pen-to-square"></i>
									<?php echo esc_html( get_the_date() ); ?>
								</p>
							</div>
							<a href="<?php comments_link(); ?>" class="post_comments h6">
								<i class="fa-solid fa-comment"></i>
								<?php comments_number(); ?>
							</a>
						</div>
					</div>
					<div class="post-content">
						<?php the_content(); ?>
					</div>
					<div class="post-meta-tags">
						<?php
						$cats = get_the_category( get_the_ID() );
						if ( ! empty( $cats ) ) : ?>
							<div class="post-categories">
								<h6><?php esc_html_e( 'Category:', 'motors-starter-theme' ); ?></h6>
								<?php foreach ( $cats as $cat ) : ?>
									<span class="post-category">
										<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
											<span><?php echo esc_html( $cat->name ); ?></span>
										</a>
										<span class="divider">,</span>
									</span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<?php if ( $tags = wp_get_post_tags( get_the_ID() ) ) : ?>
							<div class="post-tags">
								<h6><?php esc_html_e( 'Tags:', 'motors-starter-theme' ); ?></h6>
								<span class="post-tag">
									<?php echo get_the_tag_list( '', ', ', '' ); ?>
								</span>
							</div>
						<?php endif; ?>
					</div>
					<?php
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
				</div>
			</div>
		<?php endwhile;
	endif;
	?>
</div>

<?php get_footer(); ?>