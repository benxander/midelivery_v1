<!-- Load Validation -->
<style>
    #formulario_contacto label.error, #formulario_contacto input.submit {color: rgb(255, 87, 87);}
    form label.error, label.error {font-style: italic;font-size: 1em;}
	#errores p{margin:0}
</style>

<? $this->load->view('modulos/patrocinados')?>
<!-- End Load -->
<a id="top"></a>
<div class="contenedor_medio">
	<section>
<?=$pagina_dinamica['contenido']?>
	</section>

<div class="redondeado contacto">

	<form class="form-datos validate" method="post" action="<?= site_url('contactar/enviar') ?>" id="formulario_contacto">

	<h3 style="text-align: center;color:#fff">FORMULARIO DE CONTACTO</h3>
	<br/>

		<div id="errores"></div>

		<ol class="forms">
			<li>
				<label for="nombre">Nombre<span class="required"> (*)</span></label>
				<input type="text" class="requiredField" id="nombre" name="nombre" value="<?= set_value('nombre') ?>" required>

			</li>

			<li>
				<label for="telefono">Teléfono</label>
				<input type="text" id="telefono" name="telefono" value="<?= set_value('telefono') ?>">
			</li>
			<li>
				<label for="email">Email<span class="required"> (*)</span></label>
				<input type="text" id="email" name="email" value="<?= set_value('email') ?>">
			</li>

			<li class="textarea">
				<label for="mensaje">Mensaje de contacto<span class="required"> (*)</span></label>
				<textarea class="requiredField" cols="56" rows="8" id="mensaje" name="mensaje"><?= set_value('mensaje') ?></textarea>
			</li>
			<li>
				<label for="imagen_captcha">Captcha:</label>
				<img id="siimage" src="<?= site_url('captcha') ?>" alt='captcha' />
				<a tabindex="-1" style="border-style: none;" href="#" title="Refrescar Imagen" onclick="document.getElementById('siimage').src = './captcha?sid=' + Math.random(); this.blur(); return false"><img src="<?=base_url()?>images/boton_refrescar.png" alt="Recargar imagen" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a>
			</li>
			<li>
				<label for="captcha">Texto de la imagen:<span class="required"> (*)</span></label>
				<input type="text" style="width:205px;" id="captcha" name="captcha" >
			</li>
			<div class="line checkbox">
				<input style="width: 15px;" type="checkbox" name="politica_privacidad" id="politica_privacidad" class="checkbox " value="" />
				<p>Acepto la <a rel="shadowbox;width=900;height=600;" href="<?=site_url('politica-de-privacidad')?>" target="_blank">política de privacidad </a> de <?=NOMBRE_PORTAL_NOTACION_URL?></p>
			</div>
		</ol>



		<div class="clear"></div>


		<a id="enviar_formulario" class="btn-small-action enviar_formulario" href="#"><div class="form-button-left">
			<span>ENVIAR</span>
		</div></a>
	</form>
</div>
</div>
<script src="<?= base_url() ?>js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
<!--<script src="<?= base_url() ?>js/validacion.js" type="text/javascript" charset="utf-8"></script>-->
<script languaje="javascript">
    $(function(){
        jQuery.validator.methods.oldRequired = jQuery.validator.methods.required;
        jQuery.validator.addMethod("required", function(value, element, param) {
            if (value == $(element).attr("ref")){
                return false;
            }
            return jQuery.validator.methods.oldRequired.call(this, value, element, param);
        },
        jQuery.validator.messages.required // use default message
    );
        $(".validate").each(function() {
            $(this).validate({
                errorLabelContainer:$('#errores'),
                errorContainer:$('#errores'),
                wrapper:'p',
                rules: {
                    nombre:"required",
                    telefono:"digits",
                    email:"required email",
                    mensaje:"required",
					politica_privacidad:"required",
                    captcha:{
                        required: true,
                        remote: "<?=site_url('captcha/check')?>"
                    }

                },
                messages: {
                    nombre:"El campo nombre es obligatorio",
                    telefono: {
                        digits:"El teléfono debe ser numérico"
                    },
                    email: {
                        required: "El campo email es obligatorio",
                        email: "Debe ser un email v\u00e1lido"
                    },
                    mensaje: "El texto del mensaje es obligatorio",
					politica_privacidad: "Debe aceptar la Politica de Privacidad",
                    captcha:{
                        required: "El captcha es obligatorio",
                        remote: "El código introducido no coincide con el de la imagen!"
                    }
                }
            });
            //}
        });

        $(".enviar_formulario").each(function() {
            $(this).click(function(e){
                e.preventDefault();
                if($("#formulario_contacto").valid()){
                    $("#formulario_contacto").submit();
                }
                else{
                    window.location = "#top";
                }
            });
        });

    });
</script>