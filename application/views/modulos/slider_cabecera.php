<link rel="stylesheet" type="text/css" href="<?=base_url()?>js/nivo-slider/nivo-slider.css" />
<div id="slider"><!-- slide_cab nivo-slider -->
	<div id="slide_cab">
		<? foreach ($banners_cabecera as $banner): ?>
			<img src="<?=base_url()?>uploads/banners/<?= $banner['banner'] ?>" alt="<?= $banner['titulo']?>" title="<?= $banner['titulo']?>" style="display:none;" />
		<? endforeach; ?>
	</div>
</div>