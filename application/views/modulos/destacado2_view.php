<ul class="grid cs-style-3">
	<?foreach ($anuncios_destacados as $anuncio):?>
		<li class="mr-xs ml-xs mb-md">
			<div style="text-align:center">
				<figure>
					<img alt="<?=$anuncio['titulo']?>" src="
						<?if ($anuncio['imagen'] == '' || !file_exists("./uploads/thumbs/" . $anuncio['imagen'])) echo base_url()."images/sin_foto.jpg";
						else echo base_url() . "uploads/thumbs/" . $anuncio['imagen'];
						?>"
					/>
					<figcaption>
						<? $descripcion = rip_tags($anuncio['descripcion']); ?>
						<span><?=substr($descripcion,0,80);
							if (strlen($descripcion) > 80) echo "...";?>
						</span>
						<br>
						<a href="<?= site_url('ficha/' . url_title(convert_accented_characters(($anuncio['titulo'] . '-' . $anuncio['id'])),'-',TRUE));?>">VER MAS</a>
					</figcaption>
				</figure>
			</div>
			<div class="titulo_destacado"><strong><h3><a href="<?= site_url('ficha/' . url_title(convert_accented_characters(($anuncio['titulo'] . '-' . $anuncio['id'])),'-',TRUE));?>"><?=$anuncio['titulo']?></a></h3></strong></div>

		</li>
	<? endforeach;?>
</ul>


<script src="<?=base_url()?>js/modernizr.custom.js"></script>
<script src="<?=base_url()?>js/toucheffects.js"></script>
