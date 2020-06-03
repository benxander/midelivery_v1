<script type="text/javascript">
	 $(document).ready(function() {
		// $('#buscador-home').hide();
		$('#boton_buscar').click(function(event){
			event.preventDefault();
			buscar();
		});
		$('#busc_ref').click(function(event){
			event.preventDefault();
			buscar2();
		});
	 });
	 function buscar(){
		var url = '<?= base_url() ?>busqueda/';
		var provincia = $("select#provincia option:selected").val();
		// var municipio = $("select#municipio option:selected").val();
		var anunciante = $("select#anunciante").val();
		var categoria = $("select#categoria").val();
		var subcategoria1 = $("select#subcategoria").val();
		var subcategoria2 = 0;
		var precio_max = $("input#precio_max").val();
		if(precio_max == '') precio_max = 0;
		// var offset = 1;
		var dataString = provincia+"/"+anunciante+"/"+categoria+"/"+subcategoria1+"/"+subcategoria2+"/"+precio_max;
		window.location = url + dataString;
		// window.location = url;
	}
	
	function buscar2(){
		var url = '<?= base_url() ?>buscar/';
		var ref = $("#ref").val();
		// var dataString = categoria+"/"+area+"/"+precio+"/"+departamento+"/"+provincia+"/"+distrito+"/"+offset;
		window.location = url + ref;
	}
	
	// Función que carga los Municipios luego de elegir una provincia
	$(function(){
	 $("#form_busq #provincia").change(function(){
	 //alert ("click");
            $.ajax({
                type: "POST",
		
                url: "<?php echo site_url('inicio/get_municipios_provincia/'); ?>/" + $(this).val(),
                error:function(datos) {
                    $("#municipio").html("<option value='' selected='selected'>Todos los Municipios</option>");
                },
                success: function(datos) {
				// alert (datos);
                    $("#municipio").html("<option value='0' selected='selected'>Todos los Municipios</option>"+datos);
					
                }
            });
        });
	 });
	// Función que carga las subcategorias luego de elegir una categoria
	$(function(){
	 $("#form_busq #categoria").change(function(){
	 //alert ("click");
            $.ajax({
                type: "POST",
		
                url: "<?php echo site_url('inicio/get_subcategoria_categoria/'); ?>/" + $(this).val(),
                error:function(datos) {
                    $("#subcategoria").html("<option value='' selected='selected'>Indiferente</option>");
                },
                success: function(datos) {
				// alert (datos);
                    $("#subcategoria").html("<option value='0' selected='selected'>Todas</option>"+datos);
					
                }
            });
        });
	 });
</script>

<div id="buscador">
	<div>
		<ul class="tabs">
			<li class="activo">
				<a data-target="#openProperty">	<i class="fa fa-search"></i> Busqueda Avanzada </a>
			</li>
			
			<li>
				<a data-target="#openNew"><i class="fa fa-home"></i> Busqueda por Código </a>
			</li>
			
		</ul>

		<!-- ESCORTS -->
		<div id="openProperty" class="busquedaGeneral">
			<form id="form_busq" method="post">
				<fieldset>
									
					<div class="line">
						<label for="provincia">Provincia</label>
						<div>
							<select id="provincia" name="provincia">
								<option value="0">En toda España</option>
								<? foreach ($provincias as $provincia): ?>
									<? if ($provincia['id'] != 0): ?>
										<option value="<?= $provincia['id'] ?>" 
									<?if (isset($provincia_seleccionada)):
											if ($provincia['id'] == $provincia_seleccionada):
												echo " selected";
											endif;
									endif;?>><?= $provincia['nombre'] ?></option>
									<? endif; ?>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="line">
						<label>Municipio</label>
						<div>
							<select name="municipio" id="municipio">
								<option selected="selected" value="0">Indiferente</option>
															
							</select>
						</div>
					</div>
					
					<div class="line">
						<label for="categoria">Categoria</label>
						<div>
							<select id="categoria" name="categoria">
								<option value="0">Todas</option>
								<? foreach ($categorias as $categoria): ?>
									<? if ($categoria['id'] != 0): ?>
										<option value="<?= $categoria['id'] ?>" 
									<?if (isset($categoria_seleccionada)):
											if ($categoria['id'] == categoria_seleccionada):
												echo " selected";
											endif;
										endif;
										?>
												><?= $categoria['categoria'] ?></option>
									<? endif; ?>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="line">
						<label>Subcategoria</label>
						<div>
							<select name="subcategoria" id="subcategoria">
								<option selected="selected" value="0">Indiferente</option>
															
							</select>
						</div>
					</div>
					<div class="line" id="precio">
						<label>Precio máximo ( <i class="fa fa-eur"></i> )</label>
						<div>
							<input id="precio_max" name="precio_max" type="number" min="1" step="10"class="input_promo" value="" style="width: 100%;display: inline-block;"/>
						</div>
						
					</div>
					<div class="line">
						<div>
							<input id="boton_buscar"class="btn btnDefault" type="submit" value="Buscar" />
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		<!-- BUSQUEDA POR REFERENCIA -->
		<div id="openNew" class="busquedaPromocionesNuevas" style="display:none">
			<form action="" method="post">
				<input type="hidden" name="modo" id="modo" value="" />
				<fieldset>
					<div class="line" id="numero_ref">
						<label> Nº de referencia</label>
						<div>
							<input id="ref" name="ref" type="search" maxlength="20" value="" />
						</div>
					</div>
					<div class="line">
						<div>
							<button id="busc_ref" class="btn btnDefault" type="submit">Buscar</button>
						</div>
					</div>
				</fieldset>
			</form>

		</div>
		<!-- /BUSQUEDA POR REFERENCIA -->
		

	</div>
</div>