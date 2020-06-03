<style type="text/css">

</style>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/font-awesome.min.css" />
<div class="clear"></div>

<div class="contenedor_medio">
	<h2>CALENDARIO DE EVENTOS</h2>
	<?php if (!empty($arrCalendario)) : ?>
			<?php foreach($arrCalendario as $row) : ?>
			<article class="evento">
				<div class="fecha">
					<div class="evento_dia">
						<?=date('j', strtotime($row['fecha_creacion']))?>
					</div>
					<div class="evento_mes">
						<?=date('M', strtotime($row['fecha_creacion']))?>
					</div>
					<div class="evento_anyo">
						<?=date('Y', strtotime($row['fecha_creacion']))?>
					</div>
				</div>
				<h2 class="titulo-articulo"><a class="titulo_evento" href="<?= site_url('liquidacion/articulo/' . strtolower(url_title($row['titulo'] . "-" . $row['idcalendario']))) ?>"><?=$row['titulo'] ?></a></h2>

				<div class="panel_comentario">
					<div style="width:150px">
						<a href="<?= site_url('liquidacion/articulo/' . strtolower(url_title($row['titulo'] . "-" . $row['idcalendario']))) ?>"><img src="<?=base_url()?>uploads/liquidacion/<?=$row['imagen']?>" style="float:left;width:100%;margin:0px 10px 10px 0" /></a>
					</div>
					<div style="padding: 5px 0;">
						<p style="margin: 0 0 10px;">
							<?php echo substr(strip_tags($row['contenido']),0,530);
								if (strlen($row['contenido']) > 530) {
                                   echo "...";
                            	}
                            ?>
                        </p>
                        <p class="pull-right">
                        	<a href="<?= site_url('liquidacion/articulo/' . strtolower(url_title($row['titulo'] . "-" . $row['idcalendario']))) ?>">(ver mas)</a>
                        </p>
                    </div>
				</div>

				<div class="clear">
				</div>
			</article>
			<?php endforeach; ?>


	<?php else : ?>
			<h1 class="waterMarkEmptyData">De momento no hay noticias para mostrar</h1>

	<?php endif; ?>



</div>