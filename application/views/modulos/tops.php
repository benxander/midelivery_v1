<style>
.caroufredsel_wrapper{height:340px!important;}
</style>
<?if(!empty($anuncios_destacados)):?>
	<article id="mainText">
		<div class="clear carrusel_container">
			<h2>OFERTAS DESTACADAS</h2>
			<div id="carousel">
			<?foreach ($anuncios_destacados as $row):?>

				<div class="top_destacado">
					<div class="welcome">
						<div class="thumbnail">
							<a href="<?= site_url('inicio/ver_anuncio/' . strtolower(url_title($row['titulo'] . "-" . $row['id']))) ?>"> <img src="<?= base_url() ?>uploads/thumbs/<?= $row['imagen'] ?>" title="<?= $row['titulo'] ?>"/>
							</a>
						</div>
					</div>
					<div class="datostop">
						<ul>
							<li class="titulo">
								<span><?=ucwords(strtr(strtolower($row['titulo']),"ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ","àèìòùáéíóúçñäëïöü"))?></span>
							</li>
							<?if($row['precio'] != 0):?>
								<li class="fuenteImpact text-red p-xs" style="background-color: rgba(241, 241, 241, 0.72);position: relative;bottom: 8px;">

										<span class="precio bold"><?=number_format($row['precio'], 2, ',', '.')?> €</span><span class="presentacion bold"><?=!empty($row['presentacion'])? '/ ' . $row['presentacion']: NULL ?></span>
								</li>
							<?endif;?>
						</ul>
					</div>
				</div>
			<? endforeach;?>
			</div>
			<div class="clear">
				<a id="prev_destacado" class="prev" href="#" style="display:block"></a>
				<a id="next_destacado" class="next" href="#" style="display:block"></a>
			</div>
		</div>
	</article>
<? endif; ?>
<script type="text/javascript" src="<?=base_url()?>js/carousel/jquery.carouFredSel-6.2.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Using default configuration
    // $('#carousel').carouFredSel();

    // Using custom configuration
    $('#carousel').carouFredSel({
		prev			: '#prev_destacado',
		next			: '#next_destacado',
        items           : 1,
		align			: 'center',
        direction       : "left", // "right", "left", "up" or "down"
		// padding			: 20,
		// responsive		: true,
		// auto : {
			// timeoutDuration : 15000
		// },
        scroll : {
            items           : 1,
			fx				: 'crossfade', // "none", "scroll", "directscroll", "fade", "crossfade", "cover", "cover-fade", "uncover" or "uncover-fade".
            // easing            : "elastic", //"linear" and "swing", built in: "quadratic", "cubic" and "elastic"
            duration        : 1000, // Determines the duration of the transition in milliseconds.
            pauseOnHover    : true
        }
    });
});
</script>