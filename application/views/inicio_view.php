<? $this->load->view('modulos/patrocinados')?>
<div class="contenedor_medio">
	<section id="mensaje_dinamico_1" class="modulo">
		<div>
			<h2 class="mb-md"><?= $mensaje_inicio['titulo'] ?></h2>

			<? if($mensaje_inicio['tiene_imagen']): ?>
				<?=$mensaje_inicio['contenido'];?>
				<img src="<?=base_url() . 'uploads/paginas/' . $mensaje_inicio['imagen']?>" class="imagen_dinamica <?=$class?>">
			<? else: ?>
				<?=$mensaje_inicio['contenido'];?>
			<? endif; ?>
		</div>
	</section>

	<?php foreach ($modulos as $row): ?>
		<section class="modulo mt-xl">
			<div class="row">
				<h3 class="col-md-12 mt-sm mb bold"><?=$row['modulo']?></h3>
				<div class="col-md-12">
					<?=$row['contenido']?>
				</div>
				<?php foreach ($row['categorias'] as $rowCat): ?>
					<div class="col-md-4 mt-md">
						<div class="modulo" style="background-color: <?=$rowCat['color_fondo']?>">
							<div class="col-md-6 pl-n">
								<img alt="<?=$rowCat['categoria']?>" style="width: 100%"
									src="<?= $rowCat['imagen_ca'];?>"
								/>

							</div>
							<div class="col-md-6 descripcion pl-n pr-n">
								<h4 style="min-height: 44px"><?= $rowCat['categoria']; ?></h4>
								<p><?= $rowCat['descripcion_ca']; ?></p>
							</div>
							<div class="col-sm-12 text-right pl-n pr-n">
								<a href="<?=site_url('modulo/'.$row['segmento_modulo'].'/'.$rowCat['segmento_categoria'])?>"><button class="btn btn-warning">ver mas</button></a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>

			</div>
		</section>

	<?php endforeach; ?>
</div>

