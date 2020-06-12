<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= get_metadata("titulo-web") ?></title>
	<meta name="description" content="<?= get_metadata("meta-description") ?>">
	<meta name="keywords" content="<?= get_metadata("meta-keywords") ?>">

	<meta name="author" content="<?= get_metadata("meta-author") ?>" />

	<link rel="canonical" href="" />
	<link rel="shortcut icon" href="<?=base_url()?>uploads/<?= get_imagen("favicon")?>">

	<!-- <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/slate/bootstrap.min.css" rel="stylesheet" integrity="sha384-FBPbZPVh+7ks5JJ70RJmIaqyGnvMbeJ5JQfEbW0Ac6ErfvEg9yG56JQJuMNptWsH" crossorigin="anonymous">
 -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pinyon+Script" rel="stylesheet">




	<style>

		a:hover{opacity:0.7;text-decoration:none !important;}
		.bg-dark {
			background-color: #000000 !important;
		}

		.banner_lateral{margin-top: 10px;}
		.banner_lateral img{ width: 95%;/*outline: 1px solid #ccc;*/}
		.publicidad{margin: 5px 0 15px 0px;display: block;width: 100%;}
		footer {
			background-repeat: no-repeat;
			background-position: center bottom;
		}
		footer #datosContactoFooter {
			margin: 0 auto;
			padding: 20px 0;
		}

		footer #datosContactoFooter div {
			text-align: center;
			padding: 10px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
		}

		footer #datosContactoFooter div > i {
			display: block;
			font-size: 50px;
			color: #CCC;
			margin-bottom: 15px;
		}

		footer #datosContactoFooter div span {
			font-size: 18px;/*20*/
			line-height: 24px;
		}

		footer #datosContactoFooter div.email a {
			text-decoration: none;
		}

		footer #datosContactoFooter div.socialLinks ul li {
			list-style: none;
			display: inline-block;
			margin-right: 10px;
		}

		footer #datosContactoFooter div.socialLinks ul li:last-child {
			margin-right: 0;
		}

		footer #datosContactoFooter div.socialLinks ul li a i {
			font-size: 26px;/*28*/
		}
		footer #creditos {
			margin: 0 auto;
			padding: 20px 0;
			border-top: 1px solid #ccc;
			font-size: 12px;
		}
		.desta{width:100%!important;}
		.desta  li{ color:#FFF;font-size: 11px;}
		.desta img{vertical-align:top;}
		.tamano_red_social {width:32px;}


		.probootstrap-navbar.scrolled .navbar-nav>li>a {
			color: #fff !important;
		}
		.probootstrap-navbar.scrolled .navbar-nav>li>a:hover {
			color: #fff !important; opacity:0.7;text-decoration:none !important;
		}
		.skiptranslate .goog-te-banner-frame{display:none!important;}
		body{top:0px!important;}
		#banderas img{width:20px}
		.goog-te-gadget .goog-te-combo {height: 25px; border-radius: 10px;}
		.traductor{position: absolute;top: 8px;right: 20px; text-align: center;z-index: 50;}
		/* .sub-heading{
			color:#000;
		} */
		section.modulo:nth-child(1),
		section.modulo:nth-child(3),
		section.modulo:nth-child(4),
		section.modulo:nth-child(6)
		{
			position:relative;
			padding-top: 10px;
			background-color: #fff !important;
			color:#000 !important;
		}
		section.modulo:nth-child(2),
		section.modulo:nth-child(5)
		{
			position:relative;
			padding-top: 10px;
			background-color: #007d00 !important;
			color:#fff !important;
		}
		section.modulo:before {
			position: absolute;
			z-index: 3;
			top: 0;
			right: 0;
			width: 0;
			height: 0;
			content: "";
		}
		section.modulo:nth-child(1) {
			padding-top: 10px;
		}
		section.modulo:nth-child(1):after{
			border-bottom: 20vh solid #007d00;
			border-right: 100vw solid transparent;
		}
		section.modulo:nth-child(2):after
		{
			border-bottom: 20vh solid #fff;
			border-right: 100vw solid transparent;
		}
		section.modulo:nth-child(4):after {
			border-bottom: 20vh solid #007d00;
			border-left: 100vw solid transparent;
		}
		section.modulo:nth-child(5):after {
			border-bottom: 20vh solid #fff;
			border-left: 100vw solid transparent;
		}

		.sub-heading{
			border-top: 2px solid;
			padding-top: 10px;
		}
		.div_flotante{
			left: 0;
			text-align: center;
			position: absolute;
			width: 25%;
			/* height: 50px; */
			line-height: 50px;
			/* background: #888; */
			z-index:100;
			-webkit-transition: top 0.8s ease-in-out;
			transition: top 0.8s ease-in-out;
		}
		.promocion img{
			width: 80%;
		}
		.div_flotante > div:nth-child(1){
			margin-top: 2em;
		}

		.icon:before{color: #555}

	</style>
	<link rel="stylesheet" href="css/styles-merged.css">
    <link rel="stylesheet" href="css/style.min.css">
</head>
<body>

	<!-- Fixed navbar -->

    <nav class="navbar navbar-default navbar-fixed-top probootstrap-navbar bg-dark">
      	<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="navbar-brand">
					<a href="/" title="<?=NOMBRE_PORTAL_MINUSCULAS?>">
						<img src="<?=base_url('uploads/' . $imagen['logo_header'])?>" alt="">
					</a>
				</div>

			</div>

			<div id="navbar-collapse" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
					<li class="active"><a href="#" data-nav-section="home">Inicio</a></li>
					<li><a href="#" data-nav-section="carta-digital">Carta Digital</a></li>
					<li><a href="#" data-nav-section="codigo-qr-pagina-web">Código QR</a></li>
					<li><a href="#" data-nav-section="ejemplos">Ejemplos</a></li>
					<li><a href="#" data-nav-section="pedidos">Pedidos</a></li>
					<li><a href="#" data-nav-section="contacto">Contacto</a></li>
				</ul>
			</div>
			<div id="google_translate_element" class="no_print traductor"></div>
     	</div>
    </nav>

	<div class="header">
		<section class="flexslider" data-section="home">
			<ul class="slides">
				<? foreach ($banners_cabecera as $banner): ?>

					<li style="background-image: url(<?=base_url()?>uploads/banners/<?= $banner['banner'] ?>)" class="overlay" data-stellar-background-ratio="0.5">
					<div class="container">
						<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="probootstrap-slider-text text-center probootstrap-animate probootstrap-heading">
							<div style="max-width:600px; margin: 0 auto;">
								<img src="images/logo_salaberria.png" alt="Sidreria Salaberria">
							</div>
							</div>
						</div>
						</div>
					</div>
					</li>
				<? endforeach; ?>


			</ul>
		</section>
	</div>

	<div class="" style="">
		<div class="text-center div_flotante">
			<? foreach ($promociones as $row) :?>
				<div class="mt10 promocion">
					<a href="<?= site_url('promocion/' . strtolower(url_title($row['titulo'] . "-" . $row['idpromocion'])));?>">
						<img src="<?= $row['imagen'] ?>" alt="<?= $row['titulo'] ?>">
					</a>
				</div>
			<? endforeach ?>
		</div>
	</div>

	<div class="container-fluid modulos">
		<? foreach($modulos AS $row): ?>
			<section id="<?=$row['segmento_modulo']?>" class="row modulo" data-section="<?=$row['segmento_modulo']?>">
				<div class="">

					<div class="col-md-offset-3 col-md-6">
						<div class="probootstrap-slider-text probootstrap-animate probootstrap-heading">
							<h1 class="primary-heading"><?=$row['titulo_principal']?></h1>
							<div class="sub-heading"><?=$row['contenido']?></div>
						</div>
						<?php
							if($row['segmento_modulo'] === 'pedidos'){
								$this->load->view('modulos/reserva');

							}else if ( $row['segmento_modulo'] === 'ejemplos' ){
								$this->load->view('modulos/carta');

							}else if ( $row['segmento_modulo'] === 'opciones' ){
								$this->load->view('modulos/menu_sidreria');

							}else if ( $row['segmento_modulo'] === 'contacto' ){
								$this->load->view('modulos/contacto');

							}
						?>
					</div>
					<div class="col-md-3">
						<div class="text-center">
							<? foreach ($row['imagenes'] as $imagen) :?>
								<div class="banner_lateral">
									<img src="<?= $imagen['nombre'] ?>" alt="">
								</div>
							<? endforeach ?>
						</div>
					</div>
				</div>
			</section>
		<? endforeach; ?>

	</div>

	<div class="container-fluid bg-dark">
		<footer class="footer">
			<div id="datosContactoFooter" class="row">

				<div class="col-md-3 email"><i class="fa fa-envelope-o"></i>
					<span>
					<? $attr = array('style' => 'text-decoration:none; color:#fff; font-weight:bold');?><?=safe_mailto($footer['email_contacto'], $footer['email_contacto'], $attr);?>
					</span>
				</div>

				<div class="col-md-3 direccion"><i class="fa fa-map-marker"></i>
					<span>
						<?if(!empty($footer['url_mapa'])): ?>
							<a href="<?=$footer['url_mapa']?>" target="_blank"><?=$footer['direccion']?></a>
						<?else:?>
							<?=$footer['direccion']?>
						<?endif;?>
					</span>
				</div>

				<div class="col-md-3 tlf">
					<i class="fa fa-phone"></i><span><?=$footer['telefono']?></span>
				</div>

				<div class="col-md-3 socialLinks">
					<i class="fa fa-globe"></i>
					<div class="desta">


							<a href="<?=$footer['facebook']?>">
								<i class="icon-facebook" style="font-size:33px"></i>
							</a>
							<a href="<?=$footer['instagram']?>">
								<i class="icon-instagram" style="font-size:33px"></i>
							</a>



					</div>
				</div>
			</div>
			<div id="creditos">
				<div class="text-center">
					<p><a rel="shadowbox;width=600;height=400" href="<?=site_url('aviso-legal')?>">Aviso Legal</a> - &copy; <?=date('Y')?> <?=NOMBRE_PORTAL_MINUSCULAS?> - <? if ($this->session->userdata('logged')): ?><a href="<?=site_url('admin')?>">Mi Panel</a><?else:?><a href="<?=site_url('admin')?>">Login</a><? endif; ?> - Diseño web: <a href="http://www.hementxe.com">Hementxe Comunicacion</a></p>

					<!--<a href="/es/sitemap/">Sitemap</a>--><br>

				</div>


			</div>
			<!-- <a href="#arriba" id="toTop" class="flecha scroll"><i class="fa fa-chevron-up"></i></a> -->
		</footer>
	</div>




	<script
		src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
		crossorigin="anonymous"></script>
	<script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="js/scripts.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script type="text/javascript">
		function googleTranslateElementInit() {
			new google.translate.TranslateElement({
				pageLanguage: 'es',
				includedLanguages: 'en,es,eu,ca,fr,it,de,ja,pt,ru,zh-TW',
				// layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			}, 'google_translate_element');
			// jQuery('.goog-logo-link').css('display', 'none');
			jQuery('.goog-logo-link').css('font-size', '8px');
			jQuery('.goog-te-gadget').css('font-size', '0');
		}
	</script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

	<script type="text/javascript" src="<?=base_url();?>js_2/jquery.cookiesdirective.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			// Cookie setting script wrapper
			var cookieScripts = function () {
				// Internal javascript called
				console.log("Running");
				// Loading external javascript file
				$.cookiesDirective.loadScript({
					uri:'external.js',
					appendTo: 'eantics'
				});
			}

			$.cookiesDirective({
				explicitConsent: false,
				duration: 10,
				backgroundOpacity: '90',
				privacyPolicyUri: 'politica-de-cookies',
				inlineAction: true,
				message: '<div style="font-size:1.5em"><b>ATENCION</b></div>',
				multipleCookieScriptBeginningLabel: ' Este sitio usa scripts de ',
				and: ' y ',
				multipleCookieScriptEndLabel: ' los cuales emplean cookies.',
				impliedSubmitText: 'OK',
				impliedDisclosureText: ' Para más información, vea nuestra ',
				// explicitFindOutMore: 'Para más información, vea nuestra ',
				// explicitCookieAcceptanceLabel: 'Entiendo y Acepto. ',
				// explicitCheckboxLabel: 'Debes seleccionar la casilla "Entiendo y Acepto" ',
				// explicitCookieAcceptButtonText: ' OK ',
				position : 'bottom',
				cookieScripts: ' google, google translate, session',
				scriptWrapper: cookieScripts,


				privacyPolicyLinkText: ' politica de cookies',
				backgroundColor: 'rgb(56, 169, 163)',
				linkColor: '#FDC609',

				explicitCookieDeletionWarning: ' Tu puedes borrar los cookies.<br>'
			});
		});
	</script>
	<script>
		// var altura = window.innerHeight;

		$(function(){
			margin = 50;
			posicionInicial = 0;
			dom = {}
			st = {
				stickyElement: '.div_flotante',
				modulo : '.modulos',
				footer : 'footer'
			};
			catchDom = function(){
				dom.stickyElement = $(st.stickyElement);
				dom.modulo = $(st.modulo);
				dom.footer = $(st.footer);
			}
			afterCatchDom = function(){
				functions.ubicarPosicionInicial()
			}
			suscribeEvents = function(){
				$(window).on('scroll', events.moveStick);
			}
			events = {
				moveStick : function(){
					var w = window.innerWidth;
					if( w < 910){
						console.log('mobile', w);
						dom.stickyElement.removeClass("div_flotante");
						return;
					}else{
						dom.stickyElement.addClass("div_flotante");

					}
					windowpos = $(window).scrollTop();
					// console.log('windowpos', windowpos);
					box = dom.stickyElement;
					modulo = dom.modulo.offset();

					// console.log('modulo', modulo);

					footer = dom.footer.offset();
					if ( (box.height() + windowpos + margin) >= footer.top ) {
						pos = footer.top - (box.height() + margin);
						dom.stickyElement.css({
							top: pos + "px",
							bottom: ''
						});
					}else{
						if ($(window).height() + margin  < (windowpos)) {
							pos = windowpos + margin;
							dom.stickyElement.css({
								top: pos + "px",
								bottom: ''
							});
						} else{
							pos = modulo.top;
							dom.stickyElement.css({
								top: pos + "px",
								bottom: ''
							});
						}
					}
				}
			}
			functions = {
				ubicarPosicionInicial : function(){
					var newPosition = $(window).height() + margin;
					$(st.stickyElement).css('top', newPosition + "px");
					posicionInicial = newPosition;
				}
			}
			var init = function(){
				catchDom();
				afterCatchDom();
				suscribeEvents();
			};
			init();
		});
	</script>
	<link rel="stylesheet" type="text/css" href="js/vendor/shadowbox-3.0.3/shadowbox.css">

	<script src="js/vendor/shadowbox-3.0.3/shadowbox.js"></script>

	<script>

		Shadowbox.init({
			handleOversize: "drag",
			modal: false,
		});

	</script>

	<script type="text/javascript" src="<?=base_url();?>js/jquery.validate.js"></script>
	<script>
		$("#form_contacto").validate({
			rules: {
				captcha: {
				required: true,
				remote: "<?=site_url('captcha/check')?>"
				}
			},
			messages: {
				politica_privacidad: "Debe aceptar la Politica de Privacidad",
				captcha:{
					required: "El captcha es obligatorio",
					remote: "El código introducido no coincide con el de la imagen!"
				}
			}
		});

		$( "#form_reserva" ).validate({
			errorClass: 'warning'
		});

	</script>
	<script async
		src="https://www.jscache.com/wejs?wtype=socialButtonIcon&amp;uniq=784&amp;locationId=3222765&amp;color=green&amp;size=med&amp;lang=es&amp;display_version=2"
		data-loadtrk onload="this.loadtrk=true">
	</script>

</body>
</html>