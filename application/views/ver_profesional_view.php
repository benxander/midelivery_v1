<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css">
<link rel="stylesheet" href="<?= base_url() ?>css/style4.css" />
<link rel="stylesheet" href="<?=base_url();?>css/fancybox/jquery.fancybox.css" />
<link rel="stylesheet" href="<?=base_url();?>css/estilo_form.css" />
<link rel="stylesheet" href="<?=base_url();?>css/estilo_boton.css"/>

<style>
.profesional{margin-top: 20px;margin-left: 10px;width:98%}
.profesional .location{
	font-family: arial, verdana, sans-serif;
	font-size: 14px;
	line-height: 16px;
	margin: 5px 0px;
	font-weight: normal;
	color: #0088CC;height: 20px;
}
.profesional .fotos {float: left;margin-right: 25px;margin-bottom: 20px;width: 400px;}
.profesional .fotos img{height:100px;margin-right: 5px;  margin-bottom: 10px;}
.profesional .datos_profesional{margin-top: 55px;text-align: justify;
}
.telefono{float: right;font-size: 2.5em;font-family: 'Playball', cursive; margin-right: 18px;color: #C3B301;font-weight: bold;text-shadow: 1px 1px 2px #9E6C00;}
.profesional h1{font-size: 2.6em;/*font-weight: bold;*/font-family: 'Playball', cursive;text-indent: initial;position: initial;color: #c3b301;}
.profesional.modelo h2, h2.datos_anuncio_label{border-top: 2px solid;border-bottom: 2px solid;margin: 20px 0;text-align: center;line-height: 49px;}
.profesional h3{font-family: 'Playball', cursive;font-size: 1.8em;color: #B27E08;}
.profesional .service{font-family: Arial;border-top: 2px solid; border-bottom: 2px solid;font-size: 1.3em;display: inline;}
.profesional .datos_profesional .descripcion_anuncio{margin-top: 15px;}
.price{
	margin: 0.79em 0;
	font-size: 1.7em;
	text-align: center;
	color: rgb(51, 79, 137);
}
.descripcion_anuncio p{}
.video{border: 4px ridge #888888;margin: 32px 0; width:600px}
.profesional .detalle, .profesional .valor{display: inline-block;}
.modelo .thumbnail{margin-left: 10px;  width: 200px;height: 200px;overflow: hidden;vertical-align: middle;/*display:inline-block*/float:left;}
.pull-left{margin-right:20px;width:100%;height:auto;}
.mapa, .modelo{width: 90%;text-align: left;margin: 0px auto;}
.principal{float: left;min-height: 1px;}
.principal a{color: #E7A60C;}
.principal a:hover{color: #0088CC;}
.secundario{width: 300px;float: left;min-height: 1px;}
.descripcion_modelo{padding-left:40px;vertical-align:middle;  line-height: 20px;}
.separacion{border-top: 5px ridge;border-bottom: 5px ridge;padding: 10px 0;background: #00133D;margin-top: 30px;  min-height: 230px;}
.sep_top{margin-top: 0px;}
.impar{background: #00133D;}
section#form {margin: 30px 0 30px 0px;}
.conversor{border: 2px solid #f70;margin: 0 0 20px 0; overflow: hidden;}
.conversor h2{text-align:center;color:#f70;padding-top: 10px;  width: 100%;}
#foto_imp, #mapa-imprimir{display:none}
#mapa-google{width:100%;margin:20px auto;}
.contenedora{background-color: rgb(11, 33, 82);padding: 10px;border: 2px inset #3B5793;  color: #D7D7D7;}
.impresion{display:none}
.profesional h1, .profesional h2{line-height: normal;
  margin: 0;
  padding: 0;
  text-align: left;

 }
.contenedor_der{padding-bottom:0}
.py_der{width:30%;float:right;}
@media (max-width: 450px) {
	.profesional .fotos {width: 100%;}
} 
a.fancybox{ cursor: -webkit-zoom-in;}
</style>

<script type="text/javascript" src="<?=base_url();?>js/fancybox/jquery.fancybox.pack.js"></script>


<div class="ancho_centrado">
<div class="contenedora">
	<!-- TITULO Y FOTOS -->
	<div class="profesional principal">
		<h1 style="float:left;"><?= $profesional['profesional'] ?></h1>
		<?if($profesional['activo']):?>	
		<div class="telefono"><?= substr($profesional['telefono1'],0,3).' '.substr($profesional['telefono1'],3,3).' '.substr($profesional['telefono1'],6,3) ?></div>
		<div class="clear"></div>
		<h2 class="location">
			<?= $profesional['nombre_provincia']; ?>
		</h2>
		
		<!--<span><?= $profesional['direccion'] ?></span>-->
		
		<div class="fotos">
				 
		<? if ($profesional['logo'] <> ''): ?>
			<img src="<?=base_url();?>uploads/banners/<?=$profesional['logo'];?>" border="0" class="pull-left"  style="width:100%;height:auto;margin-bottom: 10px;"/>
			
			
		 <? endif; ?>
		 </div>
		 
	 
		<div class="descripcion_anuncio modelo" style="text-align: justify;">
		
			
			<p><?=$profesional['descripcion']?></p>

			
			<?if($profesional['web']<>''):?>
				<p><strong>Web:</strong> <a href="<?=prep_url($profesional['web'])?>" target="_blank"><?=$profesional['web']?></a></p>
			<?endif;?>
		</div>
		
		
	</div><!-- /profesional Principal -->
	<div class="clear"></div>
	<!-- ================= GALERIA DE FOTOS ================================ -->
	<?if(count($fotos)>0):?>
	 <div style="max-width:600px;margin: 0 auto;">
		 <? $this->load->view('modulos/galeria_profesional'); ?>
	</div>
	<?endif;?>
	<!-- =================== MAPA GOOGLE ============================= -->	
		<div class="content_mapa">
		<?if($profesional['lat']<>0 && $profesional['lng']<>0 ):?>
		<br/>
		<h2 class="datos_anuncio_label">DONDE ESTAMOS</h2>
		<div>
			<p style="text-align:left;"><span style="color: #c3b301;"><strong>Provincia: </strong></span><?=$profesional['nombre_provincia']?>&nbsp; &nbsp;&nbsp; &nbsp;<span style="color: #c3b301;"> <strong>Municipio: </strong></span><?=$profesional['nombre_municipio']?>&nbsp; &nbsp;&nbsp; &nbsp;<?if($profesional['zona']!=''):?><span style="color: #c3b301;"><strong>Zona: </strong></span><?=$profesional['zona']?><?endif;?></p>
		</div>
			<?= $map['js'];?>
			<div id="mapa-google"><?= $map['html'];?></div>
			
		<?endif;?>
		</div>
	
	<?if($profesional['video'] <> ''):?>
			<video controls class="video">
				  <source src="<?=base_url();?>uploads/videos_profesionales/<?=$profesional['video']?>" /> 
			</video> 
		<?endif;?>
	<div class="clear"></div>
	<!-- ================================== anuncioS DE LA profesional ============================== -->	
	<?if(count($anuncios)!=0):?>
	
	<div class="profesional modelo" >
	<h2>NUESTROS PRODUCTOS</h2>
		<?$i=2;?>
		<?foreach($anuncios as $anuncio):?>
		<div class="separacion">
		<div class="thumbnail">
		<?$x=0;?>
		<?foreach($anuncio['fotos'] as $foto):?>
			<?if($x === 0):?>
			<a class="fancybox" rel="gallery<?=$i;?>" href="<?=base_url();?>uploads/anuncios/<?=$foto['foto'];?>" >
				<img src="<?=base_url();?>uploads/thumbs/<?=$foto['foto'];?>" border="0" class="pull-left thumbnail-galeria"/>
			</a>
			<?else:?>
			<a class="fancybox" rel="gallery<?=$i;?>" href="<?=base_url();?>uploads/anuncios/<?=$foto['foto'];?>" >
				<img src="<?=base_url();?>uploads/thumbs/<?=$foto['foto'];?>" border="0" style="display:none"/>
			</a>
			<?endif;?>
			<?$x=$x+1;?>	
		<?endforeach;?>
		

		</div>
		<div style="  display: inline-block;  width: 77%;text-align: left;padding-left: 10px;vertical-align: middle;">
		<h3><?=$anuncio['titulo'];?></h3><span style="float:right;font-weight: bold;"><?=number_format($anuncio['precio'], 0, '', '.')?> euros</span>
		
		<div class="clear"></div>
		<div style="margin: 10px;margin-bottom: 0px;">
			<p><?=substr(strip_tags($anuncio['descripcion']),0,350);?>
			<?if(strlen($anuncio['descripcion'])>350): echo '...'; endif;?><a href="<?= site_url('inicio/ver_anuncio/' . strtolower(url_title($anuncio['titulo'] . "-" . $anuncio['id'])));?>">(VER MÁS)</a></p>
		</div>
		</div>
		</div><!-- /separacion -->
		<?$i++;?>
		<?endforeach;?>

		
	</div><!-- /profesional modelo -->
	<?endif;?>
	
		<!-- =================== CODIGO QR ============================= -->
		<div id="qr">
			
			<img src="<?=base_url();?>inicio/qr/<?=NOMBRE_PORTAL_MINUSCULAS?>/inicio/ver_profesional/<?=strtolower(url_title($profesional['profesional'] . "-" . $profesional['id']))?>" alt="<?=strtolower(url_title($profesional['profesional'] . "-" . $profesional['id']))?>" title="<?=strtolower(url_title($profesional['profesional'] . "-" . $profesional['id']))?>"></img>
		</div>

<?else:?>

		<div>
		<span style="  font-size: 3em;color: #444;text-shadow: 1px 1px 2px #999;">ESTA profesional NO ESTÁ ACTIVA</span>
		</div>
	</div><!-- /profesional Principal -->
	<div class="clear"></div>
<?endif;?>	

</div><!-- / contenedora-->



<div class="clear"></div>

<br>
</div><!-- /ancho centrado -->
<!-- ================= SCRIPT PARA SLIDER DE IMAGENES ======================= -->
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox({
		 
    	openEffect	: 'elastic',
    	closeEffect	: 'elastic',
		nextEffect	: 'fade',
    	prevEffect	: 'fade',
		openSpeed : 'slow',
		closeSpeed : 'slow',
		padding: 5
		});
	});
</script>
