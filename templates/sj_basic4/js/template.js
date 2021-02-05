/**
 * @package     Joomla.Site
 * @subpackage  Templates.Cassiopeia
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       4.0
 */

Joomla = window.Joomla || {};

(function(Joomla, document) {
	'use strict';

	function initTemplate(event) {
		var target = event && event.target ? event.target : document;

		/**
		 * Prevent clicks on buttons within a disabled fieldset
		 */
		var fieldsets = target.querySelectorAll('fieldset.btn-group');
		for (var i = 0; i < fieldsets.length; i++) {
			var self = fieldsets[i];
			if (self.getAttribute('disabled') ===  true) {
				self.style.pointerEvents = 'none';
				var btns = self.querySelectorAll('.btn');
				for (var ib = 0; ib < btns.length; ib++) {
					btns[ib].classList.add('disabled');
				}
			}
		}
	}

	document.addEventListener('DOMContentLoaded', function (event) {
		initTemplate(event);

		/**
		 * Back to top
		 */
		var backToTop = document.getElementById('back-top');
		if (backToTop) {
			backToTop.addEventListener('click', function(event) {
				event.preventDefault();
				window.scrollTo(0, 0);
			});
		}
		
		
		//slider;
		document.('.contentslider').each(function () {
			var $slider = $(this),
				$panels = $slider.children(),
				data = $slider.data(),
				$totalItem = $panels.length;
				// Apply Owl Carousel
			$slider.on("initialized.owl.carousel", function () {
				setTimeout(function() {
				   $slider.parent().find('.loading-placeholder').hide();
				}, 1000);

			});
			// Apply Owl Carousel
			$slider.owlCarousel({
				responsiveClass: true,
				mouseDrag: true,
				video:true,
				autoWidth: (data.autowidth == 'yes') ? true : false,
				animateIn: data.transitionin,
				animateOut: data.transitionout,
				lazyLoad: (data.lazyload == 'yes') ? true : false,
				autoplay: (data.autoplay == 'yes') ? true : false,
				autoHeight: (data.autoheight == 'yes') ? true : false,
				autoplayTimeout: data.delay * 1000,
				smartSpeed: data.speed * 1000,
				autoplayHoverPause: (data.hoverpause == 'yes') ? true : false,
				center: (data.center == 'yes') ? true : false,
				loop: (data.loop == 'yes') ? true : false,
				dots: (data.pagination == 'yes') ? true : false,
				rtl: (data.rtl == 'yes') ? true : false,
				nav: true,
				dotClass: "owl-dot",
				dotsClass: "owl-dots",
				margin: data.margin,
				navText: ['prev','next'],
				navClass: ["owl-prev", "owl-next"],
				responsive: {
					0: {
						items   : data.items_column4,
						nav     : ($totalItem > data.items_column4 && data.arrows == 'yes') ? true : false
					},
					480: {
						items   : data.items_column3,
						nav     : ($totalItem > data.items_column3 && data.arrows == 'yes') ? true : false
					},
					768: {
						items   : data.items_column2,
						nav     : ($totalItem > data.items_column2 && data.arrows == 'yes') ? true : false
					},
					992: { 
						items   : data.items_column1,
						nav     : ($totalItem > data.items_column1 && data.arrows == 'yes') ? true : false
					},
					1200: {     
						items   : data.items_column0,
						nav     : ($totalItem > data.items_column0 && data.arrows == 'yes') ? true : false
					}
				}
			});
			

		});
	});
	
	

	/**
	 * Initialize when a part of the page was updated
	 */
	document.addEventListener('joomla:updated', initTemplate);

})(Joomla, document);