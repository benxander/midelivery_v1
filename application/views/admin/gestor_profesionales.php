<link rel="stylesheet" href="<?=base_url();?>assets/grocery_crud/css/ui/simple/jquery-ui-1.10.1.custom.min.css" type="text/css" />
<?php foreach ($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach ($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
    body{font-family: Arial;font-size: 14px;}
    a {color: blue;text-decoration: none;font-size: 14px;}
    a:hover{text-decoration: underline;}
	.flexigrid{background:white;}
	#lat_field_box, #lng_field_box{display:none}
	.report-div.success p{background: none;padding-left: 55px!important;}
</style>
<script>
	
    $(function(){
	// Carga municipios cuando se cambia la provincia
		$("#provincia").change(cargarmunicipios);
		$("#municipio").change(cargar_mapa);
		$('#field-direccion').keyup(activar_boton);
		
		
    });
	function activar_boton(){
		// alert('hola');
		if($('#field-direccion').val()!=''){
			$('#ubicar').attr("disabled", false);
			$('#ubicar').attr("title", "Pulsa para ubicar la direccion en el mapa");
			$('#ubicar').removeClass('desactivado');
		}else{
			$('#ubicar').attr("disabled", true);
			$('#ubicar').attr("title", "Debes colocar una dirección");
			$('#ubicar').addClass('desactivado');
		}
		
		
		
	}
			
	function cargarmunicipios(){
		var provincia = $("#provincia option:selected").val();
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('inicio/get_municipios_provincia/'); ?>/" + provincia,
			beforeSend: function(){
				$("#municipio").html("<option value='' selected='selected'>Cargando municipios ...</option>");
			},
			error:function(datos) {
				$("#municipio").html("<option value='' selected='selected'>Selecciona primero la provincia</option>");
			},
			success: function(datos) {
				$('#spinner_localidades').html('');
				$("#municipio").html(datos);
				cargar_mapa();
			}
		});           
	};
	
	
</script>
<div id="contenido_gestores">
<div class="titulo_gestor">
    <h3>Gestión de <?= $seccion ?></h3>
</div>
<div>
    <?php echo $output; ?>
</div>

</div>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>