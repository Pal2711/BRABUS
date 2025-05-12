jQuery(document).ready(function ($) {
	function setMainMargin() {
		var $header = $('.header-listing')
		var $main = $('#main')

		if ($header.length > 0 && $main.length > 0) {
			var headerHeight = $header.outerHeight()
		}
	}

	function handleStickyHeader() {
		var $header = $('.header-listing')
		var headerHeight = $header.outerHeight()

		if ($('body').hasClass('mst-fixed-header-on')) {
			if ($(window).scrollTop() > headerHeight) {
				$header.addClass('fixed-header')
			} else {
				$header.removeClass('fixed-header')
			}
		}
	}

	setMainMargin()

	$(window).on('resize', function () {
		setMainMargin()
	})

	$(window).on('scroll', function () {
		handleStickyHeader()
	})
	$('.stm-menu-trigger').on('click', function (event) {
		event.stopPropagation()
		$(this).toggleClass('active')
		$('.stm-opened-menu-listing').toggleClass('active')
	})

	$('.listing-menu-mobile .menu-item-has-children > a').append(
		'<span class="icon-toggle">+</span>'
	)
	$(document).on('click', '.icon-toggle', function (event) {
		event.preventDefault()
		event.stopPropagation()

		$(this).toggleClass('active')

		var $subMenu = $(this).parent().next('.sub-menu')
		var $secondSubMenu = $subMenu.find('.sub-menu')
		$secondSubMenu.slideToggle(0)
		$subMenu.slideToggle(300)
	})
})