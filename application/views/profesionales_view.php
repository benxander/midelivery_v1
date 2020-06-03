<style>
.profesionales{width: 30%;background: #BECBD2;display: inline-block;vertical-align: top;}
.profesionales img{/*height: 210px*/max-width: 100%;}
.imagen_py {overflow: hidden;}
.descripcion {min-height: 234px;padding: 0 10px;text-align: justify;}
.descripcion button{width: 100px;height: 35px;}
.descripcion .btn{background:#6B1811}
.descripcion p{line-height: 18px;margin: 2px 0;min-height: 54px;}
.btn:after {
	content: '';
	position: absolute;
	z-index: -1;
	-webkit-transition: all 0.3s;
	-moz-transition: all 0.3s;
	transition: all 0.3s;
}
.icon-arrow-right:before {content: "\f061";}
.btn-4 {
	border-radius: 50px;
	border: 3px solid #fff;
	color: #fff;
	overflow: hidden;
}

.btn-4:active {
	border-color: #000;
	color: #E4E4E4;
}

.btn-4:hover {color: #E4E4E4;;background: #494949;}

.btn-4:before {
	position: absolute;
	height: 100%;
	font-size: 125%;
	line-height: 3.5;
	color: #fff;
	-webkit-transition: all 0.3s;
	-moz-transition: all 0.3s;
	transition: all 0.3s;
}

.btn-4:active:before {color: #DF3224;}
 
.btn-4a:before {
	left: 130%;
	bottom: 8px;
}

.btn-4a:hover:before {left: 80%;}

</style>

<div class="contenedor_medio" style="text-align: center;">
	<div id="construccion" class="cintillo">
	<span>PROFESIONALES - <?=$num;?> resultados</span>
	<select id="provincia_prof" name="provincia">
		<option value="todas">En toda España</option>
		<? foreach ($provincias as $provincia): ?>
			<? if ($provincia['id'] != 0): ?>
				<option value="<?= $provincia['segmento_amigable'] ?>" 
			<?if (isset($prov_seleccionada)):
					if ($provincia['id'] == $prov_seleccionada):
						echo " selected";
					endif;
			endif;?>><?= $provincia['nombre'] ?></option>
			<? endif; ?>
		<? endforeach; ?>
	</select>
	</div>
	 <?if ($num == 0):?>
            <div class="mensaje_error">Lo sentimos. No hay ningún anuncio para la búsqueda seleccionada. <br>
            <a onclick="history.back(-1)">Volver</a></div>
     <? else: ?>
		
	<? foreach($profesionales as $profesional):?>
	<div class="profesionales">
		<div class="imagen_py">
			<a href="<?= site_url('inicio/ver_profesional/' . strtolower(url_title($profesional['profesional'] . "-" . $profesional['id']))) ?>"><img src="<?=base_url()?>uploads/banners/<?=$profesional['logo']?>"></a>
		</div>
		
		<div class="descripcion">
			<h2><strong><?=strtr(strtoupper($profesional['profesional']),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");?></strong></h2>
			<p><?echo strip_tags(substr($profesional['descripcion'], 0, 120));
                if (strlen($profesional['descripcion']) > 120) {
                    echo "...";
                }?></p>
			<p><span style="color: #C30101;"><strong>Provincia: </strong></span><?=$profesional['nombre_provincia']?><br/><span style="color: #C30101;"> <strong>Municipio: </strong></span><?=$profesional['nombre_municipio']?><br/><?if($profesional['zona']!=''):?><span style="color: #C30101;"><strong>Zona: </strong></span><?=$profesional['zona']?><?endif;?></p>
			
			
			<a href="<?= site_url('inicio/ver_profesional/' . strtolower(url_title($profesional['profesional'] . "-" . $profesional['id']))) ?>" ><button type="button" class="btn btn-4 btn-4a icon-arrow-right">VER MAS</button></a>
		</div>
	</div>
	
	<?endforeach;?>
	<?endif;?>
	
</div><br/><br/>
<script type="text/javascript">
	$("document").ready(function(){
		$("#provincia_prof").change(function(){
			var provincia = $("#provincia_prof").val();
				alert("Esta busqueda esta en proceso. Proximante se mostrará los profesionales en: "+ provincia +"\n GRACIAS");
			});

	});
	

</script>