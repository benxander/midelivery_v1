<? $this->load->view('modulos/patrocinados')?>
<div class="contenedor_medio">

	<section class="row">
		<div class="col-sm-12">
			<h2 class="mt-xl mb bold"><?=$rowCat['categoria']?></h2>
		</div>

		<div class="col-sm-3">
			<img alt="<?=$rowCat['categoria']?>" style="width: 100%"
				src="
				<?= ($rowCat['imagen_ca'] == '' || !file_exists("./uploads/categorias/" . $rowCat['imagen_ca'])) ?
						base_url()."images/sin_foto.jpg" :
					 	base_url() . "uploads/categorias/" . $rowCat['imagen_ca'];
				?>"
			/>
		</div>
		<div class="col-sm-9">
			<?=$rowCat['descripcion_ca'] ?>
		</div>
	</section>
	<ul class="grid cs-style-3 mt-xl">
		<?foreach ($arrFichas as $row):?>
			<li class="mr-xs ml-xs mb-md">
				<div style="text-align:center">
					<figure>
						<img alt="<?=$row['titulo']?>" src="<?=$row['foto_principal']?>"
						/>
						<figcaption>
							<span><?=$row['descripcion'];?></span>
							<br>
							<a href="<?= site_url('ficha/' . url_title(convert_accented_characters(($row['titulo'] . '-' . $row['idficha'])),'-',TRUE));?>">VER MAS</a>
						</figcaption>
					</figure>
				</div>
				<div class="titulo_destacado">
					<strong><h3><a href="<?= site_url('ficha/' . url_title(convert_accented_characters(($row['titulo'] . '-' . $row['idficha'])),'-',TRUE));?>"><?=$row['titulo']?></a></h3></strong>
					<h4 class="text-center"><?=$row['tipo_ficha']?></h4>
				</div>

			</li>
		<? endforeach;?>
	</ul>






</div>

