<div class="row">
	<div class="col-md-12 probootstrap-animate">
		<h3 class="secondary-heading">Formulario de Contacto</h3>

		<form id="form_contacto" method="post" class="probootstrap-form validate" action="<?=base_url()?>inicio/contacto">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="name">
							Nombre</label>
						<input
							class="form-control"
							type="text"
							id="nombre"
							name="nombre"
							placeholder="Ingresa tu Nombre completo"
							minlength="3"
							required
						>
					</div>
					<div class="form-group">
						<label for="email">
							Email</label>
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
							</span>
							<input
								class="form-control"
								type="email"
								id="email"
								name="email"
								placeholder="Ingrese su correo"
								required
							>
						</div>
					</div>
					<div class="form-group">
						<label for="subject">
							Asunto</label>
						<select id="subject" name="asunto" class="form-control" required="required">
							<option value="" selected="">Elija uno:</option>
							<option value="Consultas Generales">Consultas Generales</option>
							<option value="Sugerencias">Sugerencias</option>
							<option value="Soporte del Producto">Soporte del Producto</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="name">
							Mensaje</label>
						<textarea name="comentario" id="message" class="form-control" rows="9" cols="25" required
							placeholder="Ingrese aqui su mensaje"></textarea>
					</div>
				</div>

				<div class="col-md-12">
					<img id="siimage" src="<?= site_url('captcha2/securimage') ?>" alt='captcha' />
				<!-- <img id="siimage" src="<?= site_url('captcha') ?>" alt='captcha' /> -->
					<a tabindex="-1" style="border-style: none;" href="#" title="Refrescar Imagen" onclick="document.getElementById('siimage').src = './captcha2/securimage'; this.blur(); return false"><img src="<?=base_url()?>images/boton_refrescar.png" alt="Recargar imagen" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a>
				</div>
				<div class="col-md-12 form-group">
					<label for="captcha">Texto de la imagen:</label>
					<input class="form-control" type="text" style="width:205px;" id="captcha" name="captcha" required="required" >
				</div>

			</div>
			<!-- END row -->
			<div class="row">
				<div class="col-md-12">
					<div class="line checkbox">
						<input
							type="checkbox"
							id="politica_privacidad"
							name="politica_privacidad"
							style="width: 15px;"
							class="checkbox"
							value="false"
							required
						>
						<p>Acepto la <a rel="shadowbox;width=900;height=600;" href="<?=site_url('politica-de-privacidad')?>" target="_blank">política de privacidad </a> de <?=NOMBRE_PORTAL_NOTACION_URL?></p>

					</div>

				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<input type="submit" name="btnContactar" id="btnContactar" value="Enviar" class="btn btn-lg btn-success btn-block">
				</div>

			</div>

		</form>
	</div>
</div>
