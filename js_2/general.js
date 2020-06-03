jQuery(window).load(function() {
	// Buscador pestaña
	/*$("#buscador .tabs a").on("click", function(e) {
		e.preventDefault();
		$("#buscador > div > div").not(".busquedaAvanzada").hide();
		$($(this).data("target")).show();
		$("#buscador .tabs li.activo").removeClass("activo");
		$(this).parent().addClass("activo");
	});*/

	// Buscador avanzado
/*	$("#abreBuscadorAvanzado").on("click", function(e) {
		$("#buscadorAvanzado, .busquedaAvanzada .bg").show();
	});
	$("#buscadorAvanzado a.cerrar").on("click", function(e) {
		$("#buscadorAvanzado, .busquedaAvanzada .bg").hide();
	});

	// Externos en nueva ventana
	$("#navLinks a").filter(function() {
		return this.hostname &&
				this.hostname.replace(/^www\./, '') !==
				location.hostname.replace(/^www\./, '');
	}).each(function() {
		$(this).attr({
			target: "_blank"
		});
	});*/

	if (isTouchDevice()) {
		// Dropdown submenú click móvil
		$('ul li.dropDownMenu a').on('click', function() {
			var ul = $(this).parent().find('ul:first');
			if (ul.is(':visible')) {
				ul.stop().slideUp();
			} else {
				ul.stop().slideDown();
			}
		});
	} else {
		// Dropdown submenú hover
		$('ul li.dropDownMenu').hover(function() {
			$(this).find('ul:first').stop().slideDown();
		}, function() {
			$(this).find('ul:first').stop().slideUp();
		});
	}

	// Aviso cookie
	$("#aviso_cookie a").click(function(e) {
		e.preventDefault();
		$(this).hide();
		$.get($(this).attr("href") + "&ajax=1", function() {
			$("#aviso_cookie").remove();
		});
	});

	// Versión móvil menú
	$("#navToggle button").on("click", function(e) {
		$("#navLinks").slideToggle();
	});

	// Versión móvil buscador
	$("#searchToggle button").on("click", function(e) {
		$("#buscador").slideToggle();
	});

	// Menú fijo
	// var num = window.innerHeight - 55;
	var num = 0;
	$(window).bind('scroll', function() {
		if ($(window).scrollTop() > num) {
			$('#navegacion').addClass('fixed').fadeIn();
			console.log('Alto ventana', window.innerHeight - 55);
		} else {
			$('#navegacion').removeClass('fixed');
		}
	});

	// Subir hacia arriba fijo
	// var num3 = 586;
	var num3 = window.innerHeight;
	$(window).bind('scroll', function() {
		if ($(window).scrollTop() > num3) {
			$('#toTop').addClass('visible');
		} else {
			$('#toTop').removeClass('visible');
		}
	});

	// Scroll arriba footer
	$(".scroll").click(function(e) {
		e.preventDefault();
		$('html,body').animate({
			scrollTop: $(this.hash).offset().top
		}, 500);
	});

	// paralax slider
	$(window).stellar();
});

function isTouchDevice() {
	var el = document.createElement('div');
	el.setAttribute('ongesturestart', 'return;'); // or try "ontouchstart"
	var deviceAgent = navigator.userAgent.toLowerCase();
	return typeof el.ongesturestart === "function" ||
			(deviceAgent.match(/(iphone|ipod|ipad)/) ||
					deviceAgent.match(/(android)/) ||
					deviceAgent.match(/(iemobile)/) ||
					deviceAgent.match(/iphone/i) ||
					deviceAgent.match(/ipad/i) ||
					deviceAgent.match(/ipod/i) ||
					deviceAgent.match(/blackberry/i) ||
					deviceAgent.match(/bada/i));
}