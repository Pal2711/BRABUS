<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="mst-comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h4 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( 1 === intval( $comments_number ) ) {
				printf(__('1 Comment', 'motors-starter-theme'), get_the_title() );
			} else {
				printf(
					__(
						'%1$s Comments',
						'%1$s Comments',
						$comments_number,
						'motors-starter-theme'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}
			?>
		</h4>

		<ul class="comment-list">
			<?php
			wp_list_comments([
				'style'      => 'ul',
				'short_ping' => true,
				'avatar_size' => 80,
				'callback'    => 'motors_starter_theme_comments'
			]);
			?>
		</ul>

		<?php the_comments_navigation(); ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'motors-starter-theme' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php
		function motors_wrap_comment_form_fields_open() {
			echo wp_kses_post( '<div class="comment-form-fields-container container">' );
		}
		add_action('comment_form_before_fields', 'motors_wrap_comment_form_fields_open');

		function motors_wrap_comment_form_fields_close() {
			echo wp_kses_post( '</div>' );
		}
		add_action('comment_form_after_fields', 'motors_wrap_comment_form_fields_close');

		comment_form([
			'title_reply'          => __( 'Leave a Comment', 'motors-starter-theme' ),
			'label_submit'         => __( 'Post Comment', 'motors-starter-theme' ),
			'comment_notes_before' => '',
			'comment_notes_after'  => '',
			'class_submit'         => 'mst-btn',
		]);
	?>

</div>