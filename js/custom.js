(function() {
	'use strict';

	/*----------------------------------------
		Detect Mobile
	----------------------------------------*/
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
			BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
			iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
			Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
			Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
			any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};

	/*----------------------------------------
		Carousel
	----------------------------------------*/


	/*----------------------------------------
		Slider
	----------------------------------------*/
	var flexSlider = function() {
	  jQuery('.flexslider').flexslider({
	    animation: "fade",
	    prevText: "",
	    nextText: "",
	    slideshow: true
	  });
	}

	/*----------------------------------------
		Animate Scroll
	----------------------------------------*/

	var contentWayPoint = function() {
		var i = 0;
		jQuery('.probootstrap-animate').waypoint( function( direction ) {

			if( direction === 'down' && !jQuery(this.element).hasClass('probootstrap-animated') ) {

				i++;

				jQuery(this.element).addClass('item-animate');
				setTimeout(function(){

					jQuery('body .probootstrap-animate.item-animate').each(function(k){
						var el = jQuery(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn probootstrap-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft probootstrap-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight probootstrap-animated');
							} else {
								el.addClass('fadeInUp probootstrap-animated');
							}
							el.removeClass('item-animate');
						},  k * 30, 'easeInOutExpo' );
					});

				}, 100);

			}

		} , { offset: '95%' } );
	};

	var navbarState = function() {

		jQuery(window).scroll(function(){

			var $this = jQuery(this),
				 	st = $this.scrollTop();

			if ( st > 5 ) {
				jQuery('.probootstrap-navbar').addClass('scrolled');
			} else {
				jQuery('.probootstrap-navbar').removeClass('scrolled');
			}

		});
	};




	var stellarInit = function() {
		if( !isMobile.any() ) {
			jQuery(window).stellar();
		}
	};

	var dateTimePicker = function() {
		jQuery('#time').timepicker(
			{
				'minTime': '10:00am',
				'maxTime': '10:00pm',
				'timeFormat': 'H:i'
			}
		);
		jQuery('#date').datepicker({
			format: 'dd/mm/yyyy',
		  	autoclose: true,
			todayHighlight: true,
			weekStart: 1,
			language: 'es',
		});
	};


	// Page Nav
	var clickMenu = function() {
		jQuery('.navbar-nav a:not([class="external"])').click(function(event){

			var section = jQuery(this).data('nav-section'),
				navbar = jQuery('.navbar-nav');
				if (isMobile.any()) {
					jQuery('.navbar-toggle').click();
				}
				if ( jQuery('[data-section="' + section + '"]').length ) {
			    	jQuery('html, body').animate({
			        	scrollTop: jQuery('[data-section="' + section + '"]').offset().top - 55
			    	}, 500, 'easeInOutExpo');
			   }

		    event.preventDefault();
		    return false;
		});


	};
	var clickMenuSecundario = function () {
		console.log('window.location.origin', window.location.origin );
		jQuery('.navbar-nav a:not([class="external"])').click(function (event) {
			var host = window.location.origin;
			var pathname = window.location.pathname;
			var section = jQuery(this).data('nav-section'),
			navbar = jQuery('.navbar-nav');
			console.log('host',host);
			console.log('section',section);
			if(host === 'http://localhost'){
				console.log('click local');
				window.location = 'http://localhost/sidreriasalaberria/#'+section;

			}else{
				console.log('click servidor');
				window.location = host + '/#'+section;

			}
			/* if (isMobile.any()) {
				jQuery('.navbar-toggle').click();
			}
			if (jQuery('[data-section="' + section + '"]').length) {
				console.log('seccion');
				jQuery('html, body').animate({
					scrollTop: jQuery('[data-section="' + section + '"]').offset().top - 55
				}, 500, 'easeInOutExpo');
			}
 */
			// event.preventDefault();
			return false;
		});
	}

	// Reflect scrolling in navigation
	var navActive = function(section) {

		var $el = jQuery('.navbar-nav');
		$el.find('li').removeClass('active');
		$el.each(function(){
			jQuery(this).find('a[data-nav-section="'+section+'"]').closest('li').addClass('active');
		});

	};

	var navigationSection = function() {

		var $section = jQuery('section[data-section]');

		$section.waypoint(function(direction) {
		  	if (direction === 'down') {
		    	navActive(jQuery(this.element).data('section'));
		  	}
		}, {
	  		offset: '150px'
		});

		$section.waypoint(function(direction) {
		  	if (direction === 'up') {
		    	navActive(jQuery(this.element).data('section'));
		  	}
		}, {
		  	offset: function() { return -jQuery(this.element).height() - 155; }
		});

	};

	jQuery(function(){
		var host = window.location.origin;
		var pathname = window.location.pathname;
		contentWayPoint();
		navbarState();
		// if (jQuery('.probootstrap-gallery').length > 0) {
		// 	initPhotoSwipeFromDOM('.probootstrap-gallery');
		// }
		// galleryMasonry();
		stellarInit();
		dateTimePicker();
		if (host === 'http://localhost') {
			console.log('local');
			if (pathname !== '/sidreriasalaberria/') {
				clickMenuSecundario();
			} else {
				clickMenu();

			}
		} else {
			console.log('servidor');
			if (pathname !== '/') {
				clickMenuSecundario();
			}else{
				clickMenu();

			}
		}
		navigationSection();
	});

	jQuery(window).load(function(){
		// owlCarousel();
		flexSlider();
	});

})();