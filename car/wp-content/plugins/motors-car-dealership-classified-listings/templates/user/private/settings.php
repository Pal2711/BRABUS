<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$user = apply_filters( 'stm_get_user_custom_fields', '' );

$socials = array(
	'facebook' => $user['socials']['facebook'] ?? '',
	'twitter'  => $user['socials']['twitter'] ?? '',
	'linkedin' => $user['socials']['linkedin'] ?? '',
	'youtube'  => $user['socials']['youtube'] ?? '',
);

$user_bio = get_user_meta( $user['user_id'], 'description', true );
?>

<div class="stm-user-private-settings-wrapper">

	<h4 class="stm-seller-title"><?php esc_html_e( 'Profile Settings', 'stm_vehicles_listing' ); ?></h4>

	<div class="stm-my-profile-settings">
		<form action="<?php echo esc_url( add_query_arg( array( 'page' => 'settings' ), apply_filters( 'stm_get_author_link', '' ) ) ); ?>"
			method="post" enctype="multipart/form-data" id="stm_user_settings_edit">

			<!--Image-->
			<?php
			$img_url   = '';
			$img_empty = '';
			if ( ! empty( $user['image'] ) ) {
				$img_url   = $user['image'];
				$img_empty = 'hide-empty';
			} else {
				$img_empty = 'hide-photo';
			}
			?>
			<div class="clearfix stm-image-unit stm-image-avatar <?php echo esc_attr( $img_empty ); ?>">
				<div class="image ">
					<div class="stm_image_upl">
						<i class="fas fa-times"></i>
						<img src="<?php echo esc_url( $img_url ); ?>" class="img-responsive"/>
					</div>
					<?php //phpcs:disable ?>
					<script type="text/javascript">
                        jQuery('document').ready(function () {
                            var $ = jQuery;
                            $('.stm-my-profile-settings .stm-image-unit .image .fa-remove').click(function () {
                                $('.stm-image-avatar').removeClass('hide-empty').addClass('hide-photo');
                                $(this).append('<input type="hidden" value="delete" id="stm_remove_img" name="stm_remove_img" />');
                            });
                        });
					</script>
					<?php //phpcs:enable ?>
					<div class="stm-empty-avatar-icon"><i class="fas fa-camera"></i></div>

				</div>
				<div class="stm-upload-new-avatar">
					<div class="heading-font"><?php esc_html_e( 'Upload new avatar', 'stm_vehicles_listing' ); ?></div>
					<div class="stm-new-upload-area clearfix">
						<a href="#" class="button stm-choose-file"><?php esc_html_e( 'Choose file', 'stm_vehicles_listing' ); ?></a>
						<div class="stm-new-file-label"><?php esc_html_e( 'No File Chosen', 'stm_vehicles_listing' ); ?></div>
						<input type="file" name="stm-avatar"/>
					</div>
					<div class="stm-label"><?php esc_html_e( 'JPEG or PNG minimal 160x160px', 'stm_vehicles_listing' ); ?></div>
				</div>
			</div>

			<!--Main information-->
			<div class="stm-change-block">
				<div class="title">
					<div class="heading-font"><?php esc_html_e( 'Main Information', 'stm_vehicles_listing' ); ?></div>
				</div>
				<div class="main-info-settings">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'First name', 'stm_vehicles_listing' ); ?></div>
								<input class="form-control" type="text" name="stm_first_name" value="<?php echo esc_attr( $user['name'] ); ?>"
									placeholder="<?php esc_html_e( 'Enter First Name', 'stm_vehicles_listing' ); ?>" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'Last name', 'stm_vehicles_listing' ); ?></div>
								<input class="form-control" type="text" name="stm_last_name" value="<?php echo esc_attr( $user['last_name'] ); ?>"
									placeholder="<?php esc_html_e( 'Enter Last Name', 'stm_vehicles_listing' ); ?>"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'Phone', 'stm_vehicles_listing' ); ?></div>
								<input class="form-control" type="tel" name="stm_phone" value="<?php echo esc_attr( $user['phone'] ); ?>"
									placeholder="<?php esc_html_e( 'Enter Phone', 'stm_vehicles_listing' ); ?>"/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'Email*', 'stm_vehicles_listing' ); ?></div>
								<input class="form-control" type="email" name="stm_email" value="<?php echo esc_attr( $user['email'] ); ?>"
									placeholder="<?php esc_html_e( 'Enter E-mail', 'stm_vehicles_listing' ); ?>" required/>
								<label>
									<input type="checkbox" value="on" name="stm_show_mail" <?php echo( ! empty( $user['show_mail'] ) ? 'checked="checked"' : '' ); ?> />
									<span><?php esc_html_e( 'Show Email Address on my Profile', 'stm_vehicles_listing' ); ?></span>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Author Bio-->
			<div class="stm-change-block stm-author-bio">
				<div class="title">
					<div class="heading-font"><?php esc_html_e( 'About Yourself', 'stm_vehicles_listing' ); ?></div>
				</div>
				<div class="main-info-settings">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'Biographical Info', 'stm_vehicles_listing' ); ?></div>
								<textarea class="form-control" name="author_description" placeholder="<?php esc_html_e( 'Enter Bio', 'stm_vehicles_listing' ); ?>"><?php echo esc_html( $user_bio ); ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Change password-->
			<div class="stm-change-block stm-change-password-form">
				<div class="title">
					<div class="heading-font"><?php esc_html_e( 'Change password', 'stm_vehicles_listing' ); ?></div>
				</div>
				<div class="stm_change_password">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'New Password', 'stm_vehicles_listing' ); ?></div>
								<div class="stm-show-password">
									<i class="far fa-eye-slash"></i>
									<input class="form-control" type="password" name="stm_new_password"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4"><?php esc_html_e( 'Re-enter New Password', 'stm_vehicles_listing' ); ?></div>
								<div class="stm-show-password">
									<i class="far fa-eye-slash"></i>
									<input class="form-control" type="password" name="stm_new_password_confirm"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Socials-->
			<div class="stm-change-block stm-socials-form">
				<div class="title">
					<div class="heading-font"><?php esc_html_e( 'Your Social Networks', 'stm_vehicles_listing' ); ?></div>
				</div>
				<div class="stm_socials_settings">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4">
									<i class="fab fa-facebook-f"></i>
									<?php esc_html_e( 'Facebook', 'stm_vehicles_listing' ); ?>
								</div>
								<input class="form-control" type="text" name="stm_user_facebook" value="<?php echo esc_attr( $socials['facebook'] ); ?>"
									placeholder="<?php esc_html_e( 'Enter your Facebook profile URL', 'stm_vehicles_listing' ); ?>"/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4">
									<i class="fab fa-x-twitter"></i>
									<?php esc_html_e( 'Twitter', 'stm_vehicles_listing' ); ?>
								</div>
								<input class="form-control" type="text" name="stm_user_twitter" value="<?php echo esc_attr( $socials['twitter'] ); ?>"
									placeholder="<?php esc_html_e( 'Enter your Twitter URL', 'stm_vehicles_listing' ); ?>"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4">
									<i class="fab fa-linkedin"></i>
									<?php esc_html_e( 'Linked In', 'stm_vehicles_listing' ); ?>
								</div>
								<input class="form-control" type="text" name="stm_user_linkedin" value="<?php echo esc_attr( $socials['linkedin'] ); ?>"
									placeholder="<?php esc_html_e( 'Enter Linkedin Public profile URL', 'stm_vehicles_listing' ); ?>"/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="stm-label h4">
									<i class="fab fa-youtube-play"></i>
									<?php esc_html_e( 'Youtube', 'stm_vehicles_listing' ); ?>
								</div>
								<input class="form-control" type="text" name="stm_user_youtube" value="<?php echo esc_attr( $socials['youtube'] ); ?>"
									placeholder="<?php esc_html_e( 'Enter Youtube channel URL', 'stm_vehicles_listing' ); ?>"/>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Confirm Password-->
			<div class="stm-settings-confirm-password">
				<div class="heading-font"><?php esc_html_e( 'Enter your Current Password to confirm changes', 'stm_vehicles_listing' ); ?></div>
				<div class="stm-show-password">
					<i class="far fa-eye-slash"></i>
					<input class="form-control" type="password" name="stm_confirm_password" placeholder="<?php esc_html_e( 'Current Password', 'stm_vehicles_listing' ); ?>" required/>
				</div>
				<input class="button" type="submit" value="<?php esc_html_e( 'Save Changes', 'stm_vehicles_listing' ); ?>"/>
				<span class="stm-listing-loader"><i class="fas fa-spinner"></i></span>
				<h4 class="stm-user-message"></h4>
			</div>
		</form>
	</div>
</div>

<?php //phpcs:disable ?>
<script type="text/javascript">
    var stm_settings_file = {}
    jQuery(document).ready(function () {
        var $ = jQuery;
        $('body').on('change', 'input[name="stm-avatar"]', function () {
            var length = $(this)[0].files.length;

            if (length == 1) {
                $('.stm-new-file-label').text($(this).val());
            } else {
                $('.stm-new-file-label').text('<?php esc_html_e( 'No File Chosen', 'stm_vehicles_listing' ); ?>');
            }

        });

        $('.stm-show-password .fa').mousedown(function () {
            $(this).closest('.stm-show-password').find('input').attr('type', 'text');
            $(this).addClass('fa-eye');
            $(this).removeClass('fa-eye-slash');
        });

        $(document).mouseup(function () {
            $('.stm-show-password').find('input').attr('type', 'password');
            $('.stm-show-password .fa').addClass('fa-eye-slash');
            $('.stm-show-password .fa').removeClass('fa-eye');
        });

        $("body").on('touchstart', '.stm-show-password .fa', function () {
            $(this).closest('.stm-show-password').find('input').attr('type', 'text');
            $(this).addClass('fa-eye');
            $(this).removeClass('fa-eye-slash');
        });
    })
</script>
<?php //phpcs:enable ?>

