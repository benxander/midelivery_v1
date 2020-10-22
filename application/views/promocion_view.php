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
    <link rel="stylesheet" href="<?=base_url()?>css/styles-merged.css">
    <link rel="stylesheet" href="<?=base_url()?>css/style.css">



	<style>

		a:hover{opacity:0.7;text-decoration:none !important;}
		.bg-dark {
			background-color: #000000 !important;
		}
		.bar_flotante{
			float: left;
    		width: 220px;
		}
		#patrocinados {display:inline-block;width: 300px;vertical-align: top;padding: 10px;background: #fff;box-shadow: 0 1px 2px rgba(0,0,0,.1);}
		.titulo_seccion{color: #0088CC;display: block;font-weight: 400;font-size: 18px;line-height: 46px;text-align: left;}
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
		.tamano_red_social {width:32px;}
		img#fb{background-position: 0px 0px;}
		img#tw{background-position: -32px 0px;}
		img#yt{background-position: -128px 0px;}
		img#rss{background-position: -97px 0px;}
		.sprite {background-image: url(../images/social_sprite.png);background-repeat: no-repeat;}
		img#fb:hover{background-position: 0px -32px;}
		img#tw:hover{background-position: -32px -32px;}
		img#yt:hover{background-position: -128px -32px;}
		img#rss:hover{background-position: -97px -32px;}
		.flecha {
			width: 40px;
			height: 40px;
			line-height: 40px;
			text-align: center;
			background: rgba(223, 50, 36,0.48);
			color: #fff;
			border-radius: 4px;
			position: fixed;
			bottom: 10px;
			right: 10px;
			z-index: 1000;
			opacity: 0;
			filter: alpha(opacity=0);
			transition: all ease .25s;
			-webkit-transition: all ease .25s;
			-moz-transition: all ease .25s;
		}

		.flecha:hover {
			color: #fff;
			background: rgba(223, 50, 36,0.8);
			transition: all ease .25s;
			-webkit-transition: all ease .25s;
			-moz-transition: all ease .25s;
		}

		#toTop.flecha.visible {
			opacity: 1;
			filter: alpha(opacity=100);
			transition: all ease .25s;
			-webkit-transition: all ease .25s;
			-moz-transition: all ease .25s;
		}
		.probootstrap-navbar.scrolled .navbar-nav>li>a {
			color: #fff !important;
		}
		.probootstrap-navbar.scrolled .navbar-nav>li>a:hover {
			color: #fff !important; opacity:0.7;text-decoration:none !important;
		}
		.skiptranslate .goog-te-banner-frame{display:none!important;}
		body{top:0px!important;}

		.goog-te-gadget .goog-te-combo {height: 25px; border-radius: 10px;}
		.traductor{position: absolute;top: 8px;right: 20px; text-align: center;z-index: 50;}
		/* .sub-heading{
			color:#000;
		} */

		.icon:before{color: #555}

	</style>
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
					<li><a href="#" data-nav-section="home">Inicio</a></li>
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


	<div class="container-fluid mt80 mb80">

		<div class="contenedor_medio">
			<div class="row ficha fondo_gris pt-lg pb-lg pl pr">
				<?if($promocion['estado_pr'] == 1):?>

					<div class="col-md-3 mt-xl">

						<img src="<?=base_url().$promocion['imagen'];?>" width="100%" />
					</div>

					<div class="col-md-9 mt-xl">
						<h3 class="col-sm-12 titulo"><?=$promocion['titulo']?></h3>
						<hr style="border: 1px solid #007d00;" />
						<?=$promocion['contenido']?>
					</div>

					<div class="clear"></div>
				<?else:?>
					<?if(empty($promocion)):?>
						<span class="waterMarkEmptyData">ESTA PROMOCION NO EXISTE</span>
					<?else:?>
						<h3 class="titulo"><?=$promocion['titulo']?></h3>
						<span class="waterMarkEmptyData">ESTA PROMOCION NO ESTÁ ACTIVA</span>
					<?endif;?>
				<?endif;?>
			</div>
		</div>
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
								<i class="icon-facebook" style="font-size:28px"></i>
							</a>
							<a href="<?=$footer['instagram']?>">
								<i class="icon-instagram" style="font-size:28px"></i>
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

    <script src="<?=base_url()?>js/scripts.min.js"></script>
    <script src="<?=base_url()?>js/custom.js"></script>
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


		<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/vendor/shadowbox-3.0.3/shadowbox.css">

		<script src="<?=base_url()?>js/vendor/shadowbox-3.0.3/shadowbox.js"></script>

		<script>
		 	// $(document).ready(function() {
                Shadowbox.init({
                    handleOversize: "drag",
                    modal: false,
                    // language: 'es',
                    // players: ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv']
                });
                // $('a[rel="shadowbox"]').live('click', function() {
                //     Shadowbox.open(this);
                //     return false;
				// });

				// $('footer').on('click', 'a[rel="shadowbox"]', function() {
                //     Shadowbox.open(this);
                //     return false;
                // });
			// });
		</script>

</body>
</html>