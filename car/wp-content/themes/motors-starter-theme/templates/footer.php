<?php
$copyright = get_theme_mod( 'mst_footer_copyright', '' );
$copyright_text = get_theme_mod( 'mst_footer_copyright_text', '' );
?>
<div id="footer-main">
	<div class="container">
		<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
			<div id="footer-widget-area" class="footer-widget-area">
				<?php dynamic_sidebar( 'footer-sidebar' ); ?>
			</div>
		<?php endif; ?>
		<?php if ( $copyright ) : ?>
			<div id="footer-copyright">
				<div class="mst-copyright">
					<p><?php echo wp_kses_post( $copyright_text ); ?></p>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>