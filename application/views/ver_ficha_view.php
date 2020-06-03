<style>
.fondo_marron{
  padding: 20px 10px 20px 10px;
  max-width: 1200px;
  margin: 0 auto 30px;
  list-style: none;
  background: #3d0302;
  border: 1px solid #ccc;
  border-radius: 4px;
  text-align: left;
    line-height: 20px;
}
.telefono{float: right;font-size: 2.5em;font-family: 'Playball', cursive; margin-right: 18px;color: #C3B301;font-weight: bold;text-shadow: 1px 1px 2px #9E6C00;line-height: 2em;}
.ficha p{color: #CFCFCF;text-shadow: 0px 1px 0px #999999;margin-top: 40px;}
.ficha .titulo{font-family: 'Playball', cursive;  color: #c3b301;
  font-size: 3.5em;  line-height: 1em;
  text-shadow: 4px 4px 4px rgba(186, 186, 186, 0.75);
  font-weight: normal;
  text-align: left;  display: inline-block;}
.ficha .detalle{width: 120px;color: #c3b301;text-align: right;margin-right: 5px;line-height: 28px; display:inline-block;text-shadow: 0 1px 0 #0A2864;font: 1.1em "Trebuchet MS", Arial, Verdana, Helvetica, sans-serif;
  }
.ficha .valor{display:inline-block;font: 1.1em "Trebuchet MS", Arial, Verdana, Helvetica, sans-serif;
  color: #CFCFCF;
  text-align: left;
  line-height: 28px;
  text-shadow: 0 1px 0 #999999;}  
.ficha .agencia{  display: inline-block;
  text-align: center;
  float: right;  margin-left: 10px;}
.agencia a, .book a{opacity: 0.8;}  
.agencia a:hover, .book a:hover{opacity: 1;}
.caracteristicas, .servicios{display: inline-block; vertical-align: top;}
.servicios{  margin-left: 50px;}
.servicios li{color: rgb(189, 172, 1); list-style: circle;  margin-right: 30px;}
.book{float:right;margin-right:5px;text-align: center;}
.ficha img{float: right;}
</style>
<div class="contenedor_medio fondo_marron">
	<?if($anuncio['activo']):?>

	<div class="ficha">
		<h3 class="titulo"><?=$anuncio['titulo']?></h3>
		<?if($anuncio['categoria']=='horoscopo'):?>
<img width="45" height="45" src="<?=base_url()?>images/signos/<?=strtolower($anuncio['titulo'])?>.png" />
<?endif;?>
		<hr style="border-color: #BFAE00;height: 3px;  margin-top: 20px;" />

	</div>

	<div style="float: left;margin: 30px 30px 16px;">
	
	<img width="100%" src="<?= base_url();?>uploads/fichas/<?= $anuncio['foto_1'] ?>" data-large="<?=base_url();?>uploads/fichas/<?= $anuncio['foto_1'] ?>" alt="<?= $anuncio['titulo'] ?>" data-description="<?= $anuncio['titulo'] ?>"/>
	</div>
	<div style="margin-top: 30px;">
	<?=$anuncio['descripcion']?>
	</div>
	<a style="float: right;" onclick="history.back(-1)">Volver</a>
<?else:?>
	<div class="ficha">
		<?if($anuncio === 0):?>
			<span style="  font-size: 3em;color: #444;text-shadow: 1px 1px 2px #999;">ESTA FICHA NO EXISTE</span>
		<?else:?>
			<h3 class="titulo"><?=$anuncio['nombre']?></h3>
			<div>
			<span style="  font-size: 3em;color: #444;text-shadow: 1px 1px 2px #999;">ESTA FICHA NO ESTÁ ACTIVA</span>
		<?endif;?>	
		</div>
	</div>	
<?endif;?>
</div>

