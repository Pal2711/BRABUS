<?php
	$title_box_bg = get_post_meta( get_the_ID(), '_background_image', true );
	if ( empty( $title_box_bg ) ) {
		$title_box_bg = get_template_directory_uri() . '/assets/img/title-box-default-bg.jpg';
	}
	$title_box_text_color = get_post_meta( get_the_ID(), '_title_box_text_color', true );

	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$author = get_queried_object();
		$title = sprintf( __( 'Posts by %s', 'motors-starter-theme' ), esc_html( $author->display_name ) );
	} elseif ( is_date() ) {
		$title = get_the_date( get_option( 'date_format' ) );
	} else {
		$title = get_the_title();
	}
?>
<div class="title-box-wrapper" style="background-image: url(<?php echo esc_url( $title_box_bg ); ?>);">
	<div class="container">
		<div class="title-box">
			<h1 style="color:<?php echo esc_attr( $title_box_text_color ); ?>"><?php echo esc_html( $title ); ?></h1>
		</div>
	</div>
</div>