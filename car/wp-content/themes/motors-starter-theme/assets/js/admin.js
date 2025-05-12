jQuery(document).ready(function ($) {
	var mediaUploader

	$('.color-picker').wpColorPicker()

	$('#upload_image_button').click(function (e) {
		e.preventDefault()

		if (mediaUploader) {
			mediaUploader.open()
			return
		}

		mediaUploader = wp.media({
			title: 'Select or Upload Image',
			button: {
				text: 'Use this image',
			},
			multiple: false,
		})

		mediaUploader.on('select', function () {
			var attachment = mediaUploader.state().get('selection').first().toJSON()
			$('#background_image').val(attachment.url)
		})

		mediaUploader.open()
	})
})

jQuery(document).ready(function ($) {
	$('#loader').on('click', function (e) {
		e.preventDefault()
		$('#loader .installing').css('display', 'inline-block')
		$('#loader span').html('Updating ')
		$('#loader').addClass('updating')
		$.ajax({
			url: ajaxurl,
			dataType: 'json',
			context: this,
			method: 'POST',
			data: {
				action: 'mvl_stm_update_starter_theme',
				slug: 'motors-starter-theme',
				type: 'theme',
				nonce: mvl_starter_theme_nonces['mvl_stm_update_starter_theme']
			},
			complete: function (data) {
				$('#loader .installing').css('display', 'none')
				$('#loader .downloaded').css('display', 'inline-block')
				$('#loader span').html('Successfully Updated')
				$('#loader').css('pointer-events', 'none')
				$('#loader').css('cursor', 'default')
			},
		})
	})
})
