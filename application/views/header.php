<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8"/>
        <title><?= get_metadata("titulo-web") ?></title>
        <meta name="description" content="<?= get_metadata("meta-description") ?>">
        <meta name="keywords" content="<?= get_metadata("meta-keywords") ?>">

		<meta name="author" content="<?= get_metadata("meta-author") ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="<?=base_url()?>uploads/<?= get_imagen("favicon")?>">

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>css/main.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/default.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/responsive.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
		<link href='http://fonts.googleapis.com/css?family=Playball' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/revslider/settings.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/responsive2.css">
		<link rel="stylesheet" href="<?= base_url() ?>js/shadowbox/shadowbox.css"/>


</head>
<body id="home">
	<div id="arriba"></div>
	<div id="container">
		<header><!--	===================== CABECERA =========================== -->

		<script
		src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
		crossorigin="anonymous"></script>
		<!-- <script type="text/javascript" src="<?= base_url() ?>js/jquery/jquery-1.11.0.min.js"></script> -->
		<script type="text/javascript" src="<?= base_url() ?>js/jquery/jquery-migrate-1.2.1.min.js"></script>
		<!--<script>window.jQuery || document.write('<script src="include/js/jquery-1.11.0.min.js">\x3C/script>')</script>-->
		<script type="text/javascript" src="<?=base_url()?>js/jquery.stellar.js"></script>
		<script type="text/javascript" src="<?=base_url()?>js/jquery.validacion.js"></script>
		<script type="text/javascript" src="<?=base_url()?>js/general.js"></script>

		<script src="<?= base_url() ?>js/shadowbox/shadowbox.js"></script>
		<script>
		 $(document).ready(function() {
                Shadowbox.init({
                    handleOversize: "drag",
                    modal: false,
                    language: 'es',
                    players: ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv']
                });
                $('a[rel="shadowbox"]').live('click', function() {
                    Shadowbox.open(this);
                    return false;
                });
			});
		</script>


		</header>
		<!-- ======== SECCION DEL MENU Y BUSCADOR ======================-->
				<?php $this->load->view('modulos/menu')?>
			<!-- =====================================================-->

	<div id="bgContent">
	<div id="content">