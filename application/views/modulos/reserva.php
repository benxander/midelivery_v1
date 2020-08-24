<div class="row">
	<div class="col-md-12 probootstrap-animate">
		<h3 style="color: #fff;">Formulario de Solicitud</h3>
		<?php echo validation_errors(); ?>
		<form id="form_reserva" method="post" class="probootstrap-form validate" action="<?=base_url()?>inicio/reserva">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					<label for="nombre">Nombre <span class="">(*)</span></label>
					<div class="form-field">
						<i class="icon icon-user-check"></i>
						<input
							type="text"
							id="nombre"
							name="nombre"
							class="form-control"
							placeholder="Ingresa tu Nombre completo"
							minlength="3"
							maxlength="50"
							required
						>
					</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					<label for="telefono">Teléfono <span class="">(*)</span></label>
					<div class="form-field">
						<i class="icon icon-mobile"></i>
						<input
							type="tel"
							id="telefono"
							name="telefono"
							class="form-control"
							placeholder="999-99-99-99"
							pattern="[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{2}"
							required
						>
					</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					<label for="email">Email <span class="">(*)</span></label>
					<div class="form-field">
						<i class="icon icon-mail"></i>
						<input
							type="email"
							id="email"
							name="email"
							class="form-control"
							placeholder="email@dominio.com"
							required
						>
					</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					<label for="empresa">Nombre de su Negocio <span class="">(*)</span></label>
					<div class="form-field">
						<i class="icon icon-office"></i>
						<input
							type="empresa"
							id="empresa"
							name="empresa"
							class="form-control"
							placeholder="En una sola palabra"
							required
						>
					</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label for="plan">Plan <span class="">(*)</span></label>
						<div class="form-field">
							<i class="icon icon-documents"></i>
							<select name="plan" id="plan" class="form-control" required>
								<option value="1">PLAN 1</option>
								<option value="2">PLAN 2</option>
								<option value="3">PLAN 3</option>
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label for="modo_pago">Modo Pago <span class="">(*)</span></label>
						<div class="form-field">
							<i class="icon icon-coin-euro"></i>
							<select name="modo_pago" id="modo_pago" class="form-control" required>
								<option value="1">MENSUAL</option>
								<option value="2">SEMESTRAL</option>
								<option value="3">ANUAL</option>
							</select>
						</div>
					</div>
				</div>


			</div>
			<!-- END row -->
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="date">Comentario (Opcional)</label>
						<div class="form-field">
							<textarea class="form-control" name="comentario" rows="10"></textarea>
						</div>
					</div>
					<p>Tras recibir su solicitud recibirá un email con las instrucciones para disponer de su carta digital</p>


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
					<input type="submit" name="btnEnviarReserva" id="btnEnviarReserva" value="Enviar" class="btn btn-lg btn-success btn-block">
				</div>

			</div>

		</form>
	</div>
</div>
