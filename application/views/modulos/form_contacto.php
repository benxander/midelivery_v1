<section id="form">
	<form method="post" action="<?= site_url('contactar/enviar') ?>" id="formulario_contacto" class="contact-form validate">
		<div class="formulario">
			<div style="text-align:center;"><p style="font-size:1.5em;line-height: 32px;"><strong>CONTACTAR AHORA!</strong></p></div>
			<div class="column">
				<!--<label for="nombre">Nombre <span>(requerido)</span></label>-->
				<input required type="text" name="nombre" class="form-input" placeholder="Nombre (requerido)"/>
				
				<!--<label for="email">Email <span>(requerido)</span></label>-->
				<input required type="email" name="email" class="form-input"  placeholder="Email (requerido)" />
				
				<!--<label for="telefono">Teléfono</label>-->
				<input required type="tel" name="telefono" class="form-input" placeholder="Teléfono"/>
				
				<!--<label for="asunto">Asunto</label>-->
				<input required readonly="readonly" type="hidden" name="asunto" class="form-input" value="<?=NOMBRE_PORTAL.' REF. '.$anuncio['id']?>"/>
				
				<label for="mensaje">Mensaje <span>(requerido)</span></label>
				<textarea required name="mensaje" class="form-input" >Estoy interesad@ en este anuncio (<?=NOMBRE_PORTAL.' REF. '.$anuncio['id']?>.) y deseo recibir más información.
Muchas Gracias</textarea>
			</div>
			<input class="form-btn" type="submit" value="Enviar Mensaje" />
		</div>		
	</form>
</section>
