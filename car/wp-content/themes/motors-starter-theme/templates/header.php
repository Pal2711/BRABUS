<?php
	$logo             = get_theme_mod( 'mst_header_logo' );
	$logo_width       = get_theme_mod( 'mst_header_logo_width' );
	$margin_top       = get_theme_mod( 'mst_header_logo_margin_top', '0' );
	$margin_right     = get_theme_mod( 'mst_header_logo_margin_right', '0' );
	$margin_bottom    = get_theme_mod( 'mst_header_logo_margin_bottom', '0' );
	$margin_left      = get_theme_mod( 'mst_header_logo_margin_left', '0' );
	$background_color = get_theme_mod( 'mst_header_background_color', '#35475a' );
	$fixed_header     = get_theme_mod( 'mst_fixed_header' );
?>
<div class="header-listing">
	<div class="listing-header-bg" style="background-image: url('')">
		<div class="container header-inner-content">
			<div class="listing-logo-main">
				<?php if ( $logo ) : ?>
					<a class="bloglogo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img
							src="<?php echo esc_url( $logo ); ?>"
							title="<?php esc_attr_e( 'Home', 'motors' ); ?>"
							alt="<?php esc_attr_e( 'Logo', 'motors' ); ?>"
						/>
					</a>
				<?php else : ?>
					<a class="blogname" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'motors' ); ?>">
						<h1><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></h1>
					</a>
				<?php endif; ?>
			</div>
			<div class="listing-service-right clearfix">
				<?php if ( wp_is_mobile() ) : ?>
					<div class="listing-menu-mobile-wrapper">
						<div class="stm-menu-trigger">
							<span></span>
							<span></span>
							<span></span>
						</div>
						<div class="stm-opened-menu-listing">
							<ul class="listing-menu-mobile heading-font visible-xs visible-sm clearfix">
								<?php
									wp_nav_menu(
										array(
											'theme_location' => 'menu-1',
											'menu_id'     => 'primary-menu',
											'container'   => false,
											'menu_class'  => 'service-header-menu clearfix',
											'depth'       => 3,
											'items_wrap'  => '%3$s',
											'fallback_cb' => false,
										)
									);
								?>
							</ul>
						</div>
					</div>
				<?php else : ?>
					<div class="listing-right-actions clearfix">
					</div>
					<ul class="listing-menu">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
									'container'      => false,
									'menu_class'     => 'service-header-menu clearfix',
									'depth'          => 3,
									'items_wrap'     => '%3$s',
									'fallback_cb'    => false,
								)
							);
						?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
