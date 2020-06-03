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
	.report-div.success p{background: none;padding-left: 55px!important;}
</style>
<script>

    $(function(){
        $("#field-presentacion").attr("placeholder", "Ejm. caja x 5 Kg.").blur();
        $("#field-idmodulo").change(function(){
            var idmodulo = $("#field-idmodulo option:selected").val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('inicio/listar_categorias_modulo/'); ?>/" + idmodulo,
                beforeSend: function(){
                    $("#idcategoria").html("<option value='' selected='selected'>Cargando categorias ...</option>");
                },
                error:function(datos) {
                    $("#idcategoria").html("<option value='' selected='selected'>Selecciona primero un módulo</option>");
                },
                success: function(datos) {
                    $('#spinner_idcategoria').html('');
                    $("#idcategoria").html(datos);
                }
            });
        });
    });



</script>
<div id="contenido_gestores">
<div class="titulo_gestor">
<!--    <h3 style="text-align: center; color: #fff">Gestión de <?= $this->session->flashdata('seccion') ?></h3>-->
    <h3>Gestión de <?= $seccion ?></h3>
</div>
<div>
    <?php echo $output; ?>
</div>

</div>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>