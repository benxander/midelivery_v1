<style>
	.menu_icon{
		padding: 0;
		/* border: 1px solid #007d00; border-right: 0px; */
		height: 190px;
	}
	.menu_contenido{
		padding: 10px;
		/* border: 1px solid #007d00; */
		height: 190px;
	}
</style>
	<div class="row mt20">
		<? foreach($menu_sid AS $menu): ?>
		<div class="col-md-12 probootstrap-animate mt20 ">
			<div class="col-md-2 col-sm-2 menu_icon"><img src="uploads/categorias/<?= $menu['imagen_icono'] ?>" alt="<?= $menu['imagen_icono'] ?>" style="width:100%"></div>
			<div class="col-md-10 col-sm-10 menu_contenido">
				<div style="float: right; margin: 5px 10px; font-size: 1.5em; color: #007d00;"><?= $menu['precio'] ?> €
				</div>
				<div style="float: left;">
					<?= $menu['contenido'] ?>
				</div>

			</div>

		</div>
		<? endforeach; ?>
	</div>
