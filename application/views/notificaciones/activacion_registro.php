<p>Hola <?= $usuario ?>, te damos la más cordial bienvenida a <?= NOMBRE_PORTAL ?><br />
<br />
</p>
<p>Para cualquier duda, sugerencia, comentario por favor no dudes en contactarnos.<br />
    <br />
    Estos son sus datos de Subscripción<br />
    <br />
    Nombre de Usuario: <?= $usuario ?> <br />
    <? if ($telefono != ''): ?>
        Teléfono: <?= $telefono ?> <br />
    <? endif; ?>
    <br />
	Clave:  <?= $password_desencriptado ?></p>
    email:  <?= $email ?> <br />

<hr />
<p>Atentamente.</p>
<p>El Equipo de <?=NOMBRE_PORTAL?></p>
<p><a href="<?= base_url(); ?>" target="_blank"><?= base_url(); ?></a></p>