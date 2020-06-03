<?if($anuncios):?>

<div class="ib-container" id="ib-container">
<? foreach ($anuncios as $anuncio):?>
	<a href="<?= site_url('ficha/' . strtolower(url_title($anuncio['titulo'] . "-" . $anuncio['id'])));?>" ><div class="anuncio">


	<div class="thumbnail icon">
		<img alt="<?=$anuncio['titulo']?>" src="<?if ($anuncio['imagen'] == '' || !file_exists("./uploads/thumbs/" . $anuncio['imagen']))
				echo base_url()."images/sin_imagenes.png";
			else
				echo base_url() . "uploads/thumbs/" . $anuncio['imagen'];
		?>" />
	</div>

	<div class="titulo">
		<span><?=$anuncio['titulo']?></span>
	</div>
	<div style="min-height:65px">
		<? $descripcion = rip_tags($anuncio['descripcion']); ?>
		<span><?=substr($descripcion,0,100);
			if (strlen($descripcion) > 100) echo "...";?>
		</span>
	</div>
	<div style="min-height:10px">
		<?if(!empty($anuncio['precio'])):?>
			<span><?=$anuncio['precio']?> €</span>
		<?endif;?>
	</div>

	</div></a>
<? endforeach; ?>
</div>
<script type="text/javascript">
			$(function() {

				var $container	= $('#ib-container'),
					$articles	= $container.children('.anuncio'),
					timeout;

				$articles.on( 'mouseenter', function( event ) {

					var $article	= $(this);
					clearTimeout( timeout );
					timeout = setTimeout( function() {

						if( $article.hasClass('active') ) return false;

						$articles.not( $article.removeClass('blur').addClass('active') )
								 .removeClass('active')
								 .addClass('blur');

					}, 65 );

				});

				$articles.on( 'mouseleave', function( event ) {

					clearTimeout( timeout );
					$articles.removeClass('active blur');

				});

			});
</script>

<?else:?>
	<div class="mensaje_error">De momento no hay ningún anuncio en esta sección.<br>
            <a href="<?=site_url('contactar')?>">Contactanos</a></div>
<?endif;?>