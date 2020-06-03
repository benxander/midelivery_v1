<div class="content-box-content">
<div class="clear"></div>
<!--FIN MENU RESPONSIVE -->
	<div style="display:block">
		<div class="elemento_menu" onclick="window.location='<?= base_url() ?>admin/menu'"  >
			<div class="elemento_menu_titulo"><i class="fa fa-reply"></i> Volver Menu Principal</div>
		</div>
		<div class="elemento_menu" onclick="window.location='<?= site_url('admin/configuracion/datos_web') ?>'"  >
			<div class="elemento_menu_titulo"><i class="fa fa-laptop-code"></i> Configuración Web</div>
		</div>
		<div class="elemento_menu" onclick="window.location='<?= site_url('admin/configuracion/gestion_footer') ?>'"  >
			<div class="elemento_menu_titulo"><i class="fa fa-file-code"></i> Configuración Pie de Página</div>
		</div>
		<div class="elemento_menu" onclick="window.location='<?= site_url('admin/configuracion/gestion_imagenes') ?>'"  >
			<div class="elemento_menu_titulo"><i class="fa fa-camera"></i> Imagenes Web</div>
		</div>

		<div class="elemento_menu" onclick="window.location='<?= site_url('admin/configuracion/gestion_paginas_dinamicas') ?>'" style="cursor: pointer" >
			<div class="elemento_menu_titulo"><i class="fa fa-clone"></i> Páginas dinámicas</div>
		</div>
		<div class="elemento_menu" onclick="window.location='<?= site_url('admin/configuracion/gestion_usuarios') ?>'" style="cursor: pointer" >
			<div class="elemento_menu_titulo"><i class="fa fa-users"></i> Usuarios</div>
		</div>
	</div>
</div>