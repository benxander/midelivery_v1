<p>Hay un nuevo comentario en Blog de <strong>"<?=NOMBRE_PORTAL_NOTACION_URL?>"</strong>:<br/>
<a href="<?= site_url('blog/ver_articulo/' . strtolower(url_title($titulo . "-" . $id_articulo))) ?>"><?=$titulo ?></a></p>

<hr>
<strong>DATOS DEL COMENTARIO</strong>
<hr>
<p><strong>Autor: </strong><?php if($nombre==''): ?>Anónimo <?php else: echo $nombre; endif;?><br/>
<strong>Comentario:</strong></br>
<?= substr(strip_tags($comentario),0,130);?>
<?php if (strlen($comentario) > 130)    echo "... ";  ?>
<a href="<?= site_url('blog/ver_articulo/' . strtolower(url_title($titulo . "-" . $id_articulo))) ?>">VER MAS</a></p>
</p>
