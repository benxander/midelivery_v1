<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/css-galeria/style.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/css-galeria/elastislide.css" />
<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow&v1' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css' />
<style>
	.es-carousel ul{display:block;}
</style>
<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">	
	<div class="rg-image-wrapper">
		{{if itemsCount > 1}}
			<div class="rg-image-nav">
				<a href="#" class="rg-image-nav-prev">Previous Image</a>
				<a href="#" class="rg-image-nav-next">Next Image</a>
			</div>
		{{/if}}
		<div class="rg-image"></div>
		<div class="rg-loading"></div>
		<div class="rg-caption-wrapper">
			<div class="rg-caption" style="display:none;">
				<p></p>
			</div>
		</div>
	</div>
</script>
<div id="rg-gallery" class="rg-gallery">
	<div class="rg-thumbs">
		<!-- Elastislide Carousel Thumbnail Viewer -->
		<div class="es-carousel-wrapper">
			<div class="es-nav">
				<span class="es-nav-prev">Previous</span>
				<span class="es-nav-next">Next</span>
			</div>
			<div class="es-carousel">
				<ul>
					<?foreach($fotos as $foto_profesional):?>
						<li><a href="#">
							<img src="<?= base_url();?>uploads/thumbs_profesionales/<?= $foto_profesional['foto'] ?>" data-large="<?=base_url();?>uploads/profesionales/<?= $foto_profesional['foto'] ?>" alt="" data-description=""/>
							</a>
						</li>
					<?endforeach;?>

				</ul>
			</div>
		</div>
		<!-- End Elastislide Carousel Thumbnail Viewer -->
	</div><!-- rg-thumbs -->
</div><!-- rg-gallery -->

<script type="text/javascript" src="<?=base_url();?>js/js-galeria/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/js-galeria/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/js-galeria/jquery.elastislide.js"></script>
<script type="text/javascript" src="<?=base_url();?>js/js-galeria/gallery.js"></script>