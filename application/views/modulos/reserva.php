<div class="row">
	<div class="col-md-12 probootstrap-animate">
		<h3 class="secondary-heading">Formulario de Reservas</h3>
		<?php echo validation_errors(); ?>
		<form id="form_reserva" method="post" class="probootstrap-form validate" action="<?=base_url()?>inicio/reserva">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
					<label for="nombre">Nombre <span class="">(*)</span></label>
					<div class="form-field">
						<i class="icon icon-user2"></i>
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
						<i class="icon icon-phone"></i>
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
						<label for="fecha">Fecha <span class="">(*)</span></label>
						<div class="form-field">
							<i class="icon icon-calendar"></i>
							<input
								id="date"
								name="fecha"
								class="form-control"
								placeholder="dd/mm/aaaa"
								required
							>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label for="hora">Hora <span class="">(*)</span></label>
						<div class="form-field">
							<i class="icon icon-clock"></i>
							<select name="hora" id="hora" class="form-control" required>
								<option value="1330">13:30</option>
								<option value="1400">14:00</option>
								<option value="1430">14:30</option>
								<option value="1500">15:00</option>
								<option value="1530">15:30</option>
								<option disabled>──────────</option>
								<option value="2030">20:30</option>
								<option value="2100">21:00</option>
								<option value="2130">21:30</option>
								<option value="2200">22:00</option>
								<option value="2230">22:30</option>
								<option value="2300">23:00</option>
							</select>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label for="comensal">Comensales <span class="">(*)</span></label>
						<div class="form-field">
							<input
								type="number"
								id="comensal"
								name="comensal"
								class="form-control"
								min="1"
								value="1"
								style="padding-right:12px !important"
								required
							>
						</div>
					</div>
				</div>


			</div>
			<!-- END row -->
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="date">Comentario</label>
						<div class="form-field">
							<textarea class="form-control" name="comentario" rows="10"></textarea>
						</div>
					</div>
					<p>La reserva será confirmada o rechazada mediante un mensaje por email</p>


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
