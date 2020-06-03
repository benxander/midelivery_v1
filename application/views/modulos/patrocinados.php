<style>
	#patrocinados a:hover{opacity:0.7}
</style>
<!-- PATROCINADOS -->
<div id="patrocinados" class="mr">
	<?if( !empty($banners_laterales) ):?>
    	<div style="display:inline-block">
            <? foreach ($banners_laterales as $banner_lateral): ?>
                <div class="banner_lateral" >
                    <? if ($banner_lateral['link'] == ''): ?>
                            <img src="<?= base_url() ?>/uploads/banners/<?= $banner_lateral['banner'] ?>" title="<?= $banner_lateral['titulo'] ?>"/>
                    <? else: ?>
                        <? if ($banner_lateral['destino_url'] ==1):?>
                            <a href="<?= prep_url($banner_lateral['link']) ?>">
                                    <img src="<?= base_url() ?>/uploads/banners/<?= $banner_lateral['banner'] ?>"  title="<?= $banner_lateral['titulo'] ?>"/>
                            </a>
                        <? elseif($banner_lateral['destino_url'] ==2): ?>
                            <a target="_blank" href="<?= prep_url($banner_lateral['link']) ?>">
                                    <img src="<?= base_url() ?>/uploads/banners/<?= $banner_lateral['banner'] ?>"  title="<?= $banner_lateral['titulo'] ?>"/>
                            </a>
                        <? elseif ($banner_lateral['destino_url'] ==3):?>
                            <a href="<?= prep_url($banner_lateral['link']) ?>" rel="shadowbox; width=900; height=600;">
                                    <img src="<?= base_url() ?>/uploads/banners/<?= $banner_lateral['banner'] ?>"  title="<?= $banner_lateral['titulo'] ?>" />
                            </a>
                        <? endif; ?>
                    <? endif; ?>

                </div>
            <? endforeach; ?>
    	</div>
	<?endif;?>
    <?if( !empty($videos) ):?>
        <? foreach ($videos as $row):?>
               <div class="video_lateral">
                    <iframe src="https://www.youtube.com/embed/<?=$row['codigo_video']?>" frameborder="0" allowfullscreen></iframe>
                </div>

        <? endforeach; ?>
    <?endif;?>
</div>
