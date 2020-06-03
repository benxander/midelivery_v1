<!DOCTYPE html>
<html lang="es_Es">
    <head>
        <title><?=NOMBRE_PORTAL?> | Administracion</title>
        <meta charset="UTF-8"></meta>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"></meta>
		<meta name="viewport" content="initial-scale=1">
        <link rel="shortcut icon" href="<?=base_url()?>uploads/<?= get_imagen("favicon")?>">
        <!-- Load CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>css_2/style_admin.css" media="screen" />
        <link rel="stylesheet" href="<?= base_url() ?>js_2/shadowbox/shadowbox.css"/>
        <script src="https://kit.fontawesome.com/0a3da6ab01.js"></script>
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->

		<link rel="stylesheet" href="<?= base_url() ?>css_2/responsive2.css" />
		<!-- Load Jquery -->
		<script type="text/javascript" src="<?= base_url() ?>js_2/jquery/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js_2/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="<?= base_url() ?>js_2/shadowbox/shadowbox.js"></script>



		<!-- Load Main Stylesheets and Default Color and Style -->

        <script>
            $(document).ready(function() {
                Shadowbox.init({
                    handleOversize: "drag",
                    modal: false,
                    language: 'en',
                    players: ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv']

                });
            });
        </script>
		<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			var loc = '<?=base_url();?>'+window.location.pathname.substring(1);
			// alert ("ruta: "+loc);
			$('.menu').find('.estandar').each(function() {
				var href = $(this).find('a').attr('href');
				if (href == loc) {
					$(this).addClass('current');
				}
			});
		});
		</script>
    </head>

    <body>
        <a name="top"></a>
        <div id="container">
            <div id="header_admin">
                <div id="logo_header" class="logo">
					<div class="bienvenido"><i class="fa fa-bars"></i> Bienvenid@: <?= $this->session->userdata('usuario') ?> &nbsp;&nbsp;&nbsp;&nbsp;Hoy: <?= date("d-m-Y") ?> &nbsp;&nbsp;&nbsp;&nbsp; Hora: <?= date("H:i") ?>
					<a href="<?= site_url('admin/logout') ?>">Cerrar Sesión</a>
					</div>

				</div>

                <div class="clear"></div>
            </div>