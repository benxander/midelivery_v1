<p>Hay un nuevo comentario en el Artículo:<a href="<?=$url?>"> <?= $titulo?>. </a></p>
<p>Debe hacer click en el link de confirmación que aparece en este correo, si desea activar el comentario.</p>

    <a href="<?=base_url();?>blog/confirmar_comentario/<?=$email_encriptado."-".$id_encriptado?>"><?=base_url();?>blog/confirmar_comentario/<?=$email_encriptado."-".$id_encriptado?></a><br />
  <br />

<p>Si no puede acceder el URL anterior completo, favor de copiar y pegar en tu navegador.</p>
<hr>
<strong>DATOS DEL COMENTARIO</strong>
<hr>
<p><strong>Nombre: </strong><?php if($nombre==''): ?>Anónimo <?php else: echo $nombre; endif;?></p>
<p><strong>Email: </strong><?=$email?></p>
<p><strong>Comentario:</strong></p>
<?=$comentario?>
