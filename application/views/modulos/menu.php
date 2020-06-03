<?$arrMenu = get_modulo_categorias();?>
<?php
	$lista_imagenes = obtener_imagenes();
	foreach ($lista_imagenes as $key => $value) {
		$imagen[$value['nombre']] = $value['imagen'];
	}
?>
<a href="" name="menu"></a>
<div id="navegacion">
	<nav>
		<div id="navHeader">
			<div class="logo_header"><a href="<?=base_url()?>"><img src="<?=base_url('uploads/' . $imagen['logo_header'])?>" alt="<?=NOMBRE_PORTAL_MINUSCULAS?>"></a></div>
			<div id="navToggle">
				<button><i class="fa fa-bars"></i></button>
			</div>
			<div id="labelToggle"> MENU </div>

			<!-- ===================== SECCION DEL MENU =============================-->

			<ul class="menu pull-right" id="navLinks">
				<li class="estandar">
					<a href="<?=base_url()?>">
						<span><i class="fa fa-home"></i> INICIO </span>
					</a>
				</li>
				<? foreach( $arrMenu AS $menu ): ?>
					<?if(count($menu['categorias']) > 0 ):?>
						<li class="dropDownMenu title">
							<a>
								<?=$menu['modulo']?><i class="fa fa-caret-down"></i>
							</a>
							<ul>
								<? foreach($menu['categorias'] AS $submenu): ?>
									<li>
										<a href="<?=site_url('modulo/'.$menu['segmento_modulo'].'/'.$submenu['segmento_categoria'])?>">
											<span><?= $submenu['categoria'] ?></span>
										</a>
									</li>
								<? endforeach; ?>
							</ul>
						</li>
					<? else: ?>
						<li class="estandar">
							<a href="">
								<span><?=$menu['modulo']?></span>
							</a>
						</li>
					<? endif; ?>
				<? endforeach; ?>
				<li class="estandar">
					<a href="<?=site_url('contactar')?>">
						<span>CONTACTO</span>
					</a>
				</li>

			</ul>
		</div>
	</nav>
</div>

