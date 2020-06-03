<style>
.middle_compartido #resultados_busqueda_info{
	background: none repeat scroll 0 0 #ECECEC;
	border: 1px solid #888888;
	border-radius: 5px 5px 5px 5px;
	padding: 10px;
	margin-bottom: 10px;
}
.texto_cintillo{
	color: #3D0302;
	font-weight: bold;
	padding-right: 15px;
}
</style>

<div class="middle_compartido contenedor_medio center">    
    <div class="listado full-width">
		<div class="cintillo"><span><?=strtoupper($categoria_nombre) . ' - '?><?= ($subcategoria_nombre== 'Todas las Subcategorias')? null : ($subcategoria_nombre . ' - ')?><?=($numero_anuncios===1)? $numero_anuncios.' resultado':$numero_anuncios.' resultados';?></span></div>
		
        <?if ($numero_anuncios == 0):?>
            <div class="mensaje_error">Lo sentimos. No hay <?=($subcategoria_nombre== 'Todas las Subcategorias')? $categoria_nombre : $subcategoria_nombre ?> para la búsqueda seleccionada. <br>
            <a onclick="history.back(-1)">Volver</a></div>
        <? else: ?>

		
		
		<div class="row">
			<? $this->load->view('modulos/contenido_inicial2')?>
		</div>
        
    </div>
	<? endif; ?> 
    <div class="links_paginacion">
        <ul class="paginacion_listado">
            <?= $links_paginacion_listado ?>
        </ul>
    </div>
</div>
