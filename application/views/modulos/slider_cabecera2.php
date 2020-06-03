<div id="main-slideshow">
	<div id="rev_slider_4_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" style="margin:0px auto;background-color:#E9E9E9;padding:0px;margin-top:0px;margin-bottom:0px;max-height:634px;">
		<div id="rev_slider_4_1" class="rev_slider fullwidthabanner" style="display:none;max-height:634px;height:634px;">
		<ul>
		
		<? foreach ($banners_cabecera as $banner): ?>
		<li data-transition="fade" data-slotamount="7" data-masterspeed="1000" data-delay="10000"  data-saveperformance="off" >
			<img src="<?=base_url()?>uploads/banners/<?= $banner['banner'] ?>" alt="<?= $banner['titulo']?>" title="<?= $banner['titulo']?>" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat" />
		</li>
		<? endforeach; ?>
		</ul>
		<div class="tp-bannertimer">
		</div>
		</div>

	</div>
</div>