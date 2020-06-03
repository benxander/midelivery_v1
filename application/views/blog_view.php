<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/font-awesome.min.css" />
<div class="clear"></div>

<div class="contenedor_medio">

	<?php if (!empty($articulos)) : ?>
			<?php foreach($articulos as $articulo) : ?>
				<? $titulo_url = url_title(convert_accented_characters(($articulo->titulo . '-' . $articulo->id)),'-',TRUE);?>
			<article class="panel">
				<h2 class="titulo-articulo"><a href="<?= site_url('blog/ver_articulo/' . $titulo_url) ?>"><?=$articulo->titulo ?></a></h2>
				<div class="panel_comentario">
					<div style="width:150px">
						<a href="<?= site_url('blog/ver_articulo/' . strtolower(url_title($articulo->titulo . "-" . $articulo->id))) ?>"><img src="<?=base_url()?>uploads/articulos/<?=$articulo->imagen?>" style="float:left;width:100%;margin:0px 10px 10px 0" /></a>
					</div>

				<p style="margin: 0 0 10px;"><?php echo substr(strip_tags($articulo->contenido),0,530);

							if (strlen($articulo->contenido) > 530) {
                                   echo "...";
                               }?></p><p> <a href="<?= site_url('blog/ver_articulo/' . $titulo_url) ?>">(ver mas)</a></p>
				</div>

				<div class="panel_footer clear">
					<i class="fa fa-user"> </i>&nbsp;<? if ($articulo->autor<>'') echo $articulo->autor; else echo 'Anónimo';?>&nbsp;&nbsp;&nbsp;
					<?php
					$originalDate=$articulo->fecha;
					$newDate=date_castellanize_formato_largo_sin_hora_timestamp($originalDate);
					//$newDate = date("F d, Y", strtotime($originalDate));?>
					<i class="fa fa-calendar"></i>&nbsp;<?=$newDate?>
				</div>
			</article>
			<?php endforeach; ?>


	<?php else : ?>
			<h1 class="waterMarkEmptyData">De momento no hay noticias para mostrar</h1>

	<?php endif; ?>



</div>
