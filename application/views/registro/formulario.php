<style>
    #formulario_registro label.error, #formulario_registro input.submit {
        color: #FF0000;
    }
    form label.error, label.error {
        font-style: italic;
        font-size: 11px;
        margin-top: -12px
    }

    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
    #sortable li span { position: absolute; margin-left: -1.3em; }
</style>
<!-- Load de Librerías para los efectos javascript, en nuestro caso el sortable -->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script src="<?= base_url() ?>js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
<!-- End Load -->

<script languaje="javascript">
    $(function(){       
        $("#formulario_registro #provincia").change(function(){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('anuncios/get_municipios_provincia/'); ?>/" + $(this).val(),
                error:function(datos) {
                    $("#localidad").html("<option value='' selected='selected'>Selecciona primero la provincia</option>");
                },
                success: function(datos) {
                    $("#localidad").html(datos);
                }
            });
        });
       
        jQuery.validator.methods.oldRequired = jQuery.validator.methods.required;
        jQuery.validator.addMethod("required", function(value, element, param) {
            if (value == $(element).attr("ref")){
                return false;
            }
            return jQuery.validator.methods.oldRequired.call(this, value, element, param);
        },
        jQuery.validator.messages.required // use default message
    );
        jQuery.validator.addMethod("fechaEspanola",function(value, element, param) {
            // put your own logic here, this is just a (crappy) example
            return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
        },
        "Introduzca la fecha en formato dd/mm/aaaa"
    );

        $(".validate").each(function() {
            $(this).validate({
                errorLabelContainer:$('#errores'),
                errorContainer:$('#errores'),
                wrapper:'p',
                rules: {
                    usuario:"required email",
                    password:"required",
                    repassword: {
                        required: true,
                        equalTo: "#formulario_registro #password"
                    },
                    nombre:"required",
                    terminos_y_condiciones: "required"
                },
        
                messages: {
                    usuario: {
                        required: "El campo usuario debe ser un email y es obligatorio",
                        email: "Debe ser un email v\u00e1lido"
                    },
                    password:"El password es obligatorio",
                    repassword: {
                        required: "Debe introducir el password por duplicado",
                        equalTo: "Los passwords no coinciden"
                    },
                    nombre: "El nombre es obligatorio",
                    terminos_y_condiciones: "Debe aceptar los términos y condiciones de uso"
                }
            });
        });

        $(".enviar_formulario").click(function(e){
            e.preventDefault();
            
            if($("#formulario_registro").valid()){
                $("#formulario_registro").submit();
            }
            else{
                window.location = "#top";
            }
        });

        function eliminar_imagen(id){
            if (confirm('¿Seguro que deseas eliminarla?')) {
                $('#foto_' + id).remove();
                $('#div_imagen_' + id).remove();
                $('.qq-upload-list li:nth-child(' + id +')').fadeOut(1000, function(){
                    $(this).remove();
                });
                $('#siguiente_imagen').val(parseInt($('#siguiente_imagen').val())-1);
            }
        }
    });
</script>   

<div class="middle">
    <div class="full-width">
        <div class="one-full">

            <div class="outer-rounded-box-bold">
                <div class="simple-rounded-box">
                    <form class="validate" style="padding-left:10px;" method="post" id="formulario_registro" action="<?= site_url('usuarios/insertar') ?>">
                        <div id="errores"></div>

                        <ol class="forms">
                            <li>
                                <label for="usuario">Email<span class="required"> (*)</span></label>                              
                                <input type="text" style="width:650px;" class="requiredField" id="usuario" name="usuario" value="<?= set_value('usuario') ?>">
                            </li>
                            <li>
                                <label for="password">Password<span class="required"> (*)</span></label>                              
                                <input type="password" style="width:650px;" class="requiredField" id="password" name="password" value="<?= set_value('password') ?>">
                            </li>
                            <li>
                                <label for="repassword">Confirme password<span class="required"> (*)</span></label>                              
                                <input type="password" style="width:650px;" class="requiredField" id="repassword" name="repassword" value="<?= set_value('repassword') ?>">
                            </li>
                            <li>
                                <label for="nombre">Nombre Completo<span class="required"> (*)</span></label>                              
                                <input type="text" style="width:650px;" class="requiredField" id="nombre" name="nombre" value="<?= set_value('nombre') ?>">
                            </li>
                            <li>
                                <label for="nombre">Teléfono</label>                              
                                <input type="text" style="width:650px;" class="requiredField" id="telefono" name="telefono" value="<?= set_value('telefono') ?>">
                            </li>
                            <li>
                                <label for="nombre">Provincia</span></label>                              
                                <select class="search_data_values select requiredField" name="provincia" id="provincia">
                                    <option value="">Elige una provincia</option>
                                    <!--                                    <option value="0">Toda España</option>-->
                                    <? foreach ($provincias as $provincia): ?>
                                        <? if ($provincia['id'] != 0): ?>
                                            <option value="<?= $provincia['id'] ?>" 
                                            <?
                                            if (set_value('provincia') == $provincia['id'])
                                                echo "selected";
                                            elseif (isset($provincia_seleccionada))
                                                if ($provincia['id'] == $provincia_seleccionada)
                                                    echo "selected";
                                            ?>><?= $provincia['nombre'] ?>
                                            </option>
                                        <? endif; ?> 
                                    <? endforeach; ?>
                                </select>
                            </li>
                            <li>
                                <input style="float: left" name="terminos_y_condiciones" type="checkbox" id="terminos_y_condiciones" value="1"> 
                                <label style="float: left; margin-left: 5px" class="checkbox" for="terminos_y_condiciones">Acepto los <a title="Términos y Condiciones" rel="shadowbox;width=900;height=600;" href="<?= site_url('terminos-de-uso') ?>">Términos y Condiciones</a></label>
                            </li>

                            <div class="clear"></div>

                        </ol>

                        <div class="clear"></div>

                        <div class="form-button-left">
                            <a id="boton_enviar" class="btn-small-action enviar_formulario" href="#"><span>Enviar Información</span></a>
<!--                            <button class="form-button" type="submit"><span><cufon class="cufon cufon-canvas" alt="Enviar " style="width: 37px; height: 14px;"><canvas width="49" height="15" style="width: 49px; height: 15px; top: 0px; left: -1px;"></canvas><cufontext>Enviar </cufontext></cufon><cufon class="cufon cufon-canvas" alt="Informacion" style="width: 71px; height: 14px;"><canvas width="79" height="15" style="width: 79px; height: 15px; top: 0px; left: -1px;"></canvas><cufontext>Informacion</cufontext></cufon></span></button>-->
                        </div>
                        <div class="clear"></div>
                    </form>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>