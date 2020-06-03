<style>
    #formulario_recuperacion label.error, #formulario_recuperacion input.submit {
        color: #FF0000;
    }
    #formulario_recuperacion label{color: rgb(1, 82, 83);font-size: 1.2em;}
	form label.error, label.error {
        font-style: italic;
        font-size: 11px;
        margin-top: -12px
    }
	#formulario_recuperacion .form-button-left{width: 200px;}
	#formulario_recuperacion .form-button-left  a{color:#fff;}

</style>
<!-- Load de Librerías para los efectos javascript, en nuestro caso el sortable -->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<script src="<?= base_url() ?>js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
<!-- End Load -->

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
                    usuario:"required email"
                },
        
                messages: {
                    usuario: {
                        required: "El campo usuario debe ser un email y es obligatorio",
                        email: "Debe ser un email v\u00e1lido"
                    }
                }
            });
        });

        $(".enviar_formulario").click(function(e){
            e.preventDefault();
            
            if($("#formulario_recuperacion").valid()){
                $("#formulario_recuperacion").submit();
            }
            else{
                window.location = "#top";
            }
        });
    });
</script>   
<div class="middle">

	<div class="outer-rounded-box-bold">
		<div class="simple-rounded-box">
			<form class="validate" style="padding-left:10px;" method="post" id="formulario_recuperacion" action="<?= site_url('usuarios/recuperar_password') ?>">
				<div id="errores"></div>

				<ol class="forms">
					<li>
						<label for="email">Introduzca su email<span class="required"> (*)</span></label>                              
						<input type="email" style="width:80%;" class="requiredField" id="email" name="email" value="">
					</li>
					<div class="clear"></div>
				</ol>
				<div class="clear"></div>

				<div class="form-button-left">
					<a id="boton_enviar" class="btn-small-action enviar_formulario" href="#"><span>Enviar Información</span></a>

				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
	<div class="clear"></div>

</div>
