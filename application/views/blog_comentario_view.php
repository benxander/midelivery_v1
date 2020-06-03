<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/font-awesome.min.css" />
<div class="clear"></div>

<div class="contenedor_medio articulo">
	<? if ($this->session->flashdata('publicado_con_exito')): ?>
        <div class="full-width">
			<p class="success" style="border-radius: 10px 10px 10px 10px; padding: 20px 0 20px 85px;margin-bottom: 20px;"><strong>OK!</strong> El comentario ha sido publicado con éxito.</p>
        </div>
		<div class="clear"></div>
    <? endif; ?>

	<section style="margin-bottom:40px;">
		<h2 class="post-title"><?=$articulo['titulo']?></h2>
		<div>
			<img style="max-height: 200px;"src="<?=base_url()?>uploads/articulos/<?=$articulo['imagen']?>" />
			<p><?=$articulo['contenido']?></p>
		</div>
		
		<div class="compartir">
			<span class="social-caption">Comparte esto:</span>
			<ul class="social-list">
			
			<li>
				<a class="" href="javascript:window.open('https://www.facebook.com/sharer/sharer.php?u='+document.URL,'','width=600,height=400,left=50,top=50,toolbar=yes');void 0"><img title="Facebook" alt="1x1.trans" width="45" height="45" src="<?=base_url()?>images/iconos/facebook.png" data-lazy-loaded="true" style="display: inline;"></a>
			</li>
			
			<li>
				<a class="" href="javascript:window.open('https://plus.google.com/share?url='+document.URL,'','width=600,height=400,left=50,top=50,toolbar=yes');void 0"><img title="Google" alt="1x1.trans" width="45" height="45" src="<?=base_url()?>images/iconos/google.png" style="display: inline;"></a>
			</li>
			<li>
			<a class="" href="javascript:window.open('https://twitter.com/?status=Me+gusta+'+document.URL,'','width=600,height=400,left=50,top=50,toolbar=yes');void 0"><img title="Twitter" alt="1x1.trans" width="45" height="45" src="<?=base_url()?>images/iconos/twitter.png"></a>
			</li>
			
			</ul>
		</div>
	</section>
	<?php if (!empty($comentarios)) : ?>
		<?php $total = count($comentarios);?>
		<?php if($total===1): ?>
			<h2 class="post-title"><?=$total;?> Comentario</h2>
		<?php else:?>
			<h2 class="post-title"><?=$total;?> Comentarios</h2>
		<?php endif;?>
			
			<?php foreach($comentarios as $comentario) : ?>
			<article class="panel">
				
				<div class="panel_comentario">
					<div style="width:100px"><img src="<?=base_url()?>images/anonimo.jpg" style="float:left;width:100%;margin:0px 10px 10px 0"/></div>
					<p style="margin: 0 0 10px;"><?=$comentario->comentario?></p>
				</div>
				
				<div class="panel_footer clear">
					<i class="fa fa-user"> </i>&nbsp;<? if ($comentario->nombre<>'') echo $comentario->nombre; else echo 'Anónimo';?>&nbsp;
					<?php 
					$originalDate=$comentario->fecha;
					$newDate=date_castellanize_formato_largo_sin_hora_timestamp($originalDate);
					//$newDate = date("F d, Y", strtotime($originalDate));?>
					<i class="fa fa-clock-o"></i>&nbsp;<?=$newDate?>
				</div>
			</article>	
			<?php endforeach; ?>
			
			<h2>Déjanos tu Comentario</h2>
	<?php else : ?>
			<h1>No hay comentarios</h1>
			<h2>Sé el primero en comentar</h2>
	<?php endif; ?>
	
	
        <?=form_open(base_url().'blog/insertar_comentario/')?>
		<p class="notes">Tu dirección de correo electrónico no será publicada. Los campos necesarios están marcados <span class="required">*</span></p>
		
		<?= form_hidden('id_articulo', $id_articulo);?>
		<?= form_hidden('titulo', $articulo['titulo']);?>
		<?= form_hidden('url', current_url());?>

		
		<?php $atributos = array('for' => 'nombre');?>
		<?= form_label('Nombre', '',$atributos);?>
		<?php $datos = array(
              'name'        => 'nombre',
              'id'          => 'nombre',
              'placeholder' => 'Anónimo',
              'maxlength'   => '50',
              'size'        => '40',
              'class'		=> 'form-control',
            );?>
		<p><?=form_error('nombre', '<div class="error">', '</div>');?>
        <?=form_input($datos)?></p>
		<?php $atributos = array('for' => 'email');?>
		<?= form_label('Correo electrónico *', '',$atributos);?>
		<?php $datos = array(
			'type'          => 'email',
              'name'        => 'email',
              'id'          => 'email',
              'value'       => '',
			  'minlength'	=> '7',
              'maxlength'   => '100',
              'size'        => '40',
              'required' => 'required',
			  'class'		=> 'form-control',
            );?>
		<p><?=form_error('email', '<div class="error">', '</div>');?>
		<?=form_input($datos)?></p>
		<?php $atributos = array('for' => 'comentario');?>
		<?= form_label('Comentario *', '',$atributos);?>
		<?php $datos = array(
              'name'        => 'comentario',
              'id'          => 'comentario',
             
              'cols'        => '50',
              'required' => 'required',
			  'class'		=> 'form-control',
			  'style'		=> 'height: 150px;'
            );?>
		<p><?=form_error('comentario', '<div class="error">', '</div>');?>
        <?=form_textarea($datos)?></p>
		
	<p class="subscribe-to-comments clear">
			
		<?php $datos = array(
			
              'name'        => 'subscribe',
              'id'          => 'subscribe',
              'value'       => '1',
			  'checked'     => TRUE,
			  'style'		=> 'width: auto;margin-bottom: 10px;',
            );?>
		<?=form_checkbox($datos)?>
		<?php $atributos = array('for' => 'subscribe');?>
		<?= form_label('Notifíqueme por e-mail si hay comentarios', '',$atributos);?>
		
	</p>
    <section id="buttons">
		<?php $datos = array(
			  'type'		=> 'reset',
              'name'        => 'reset',
              'id'          => 'resetbtn',
              'value'		=> 'Limpiar',
              'class'		=> 'resetbtn',
            );?>
		<?=form_input($datos)?>
		
		<?php $datos = array(
			  'type'		=> 'submit',
              'name'        => 'submit',
              'id'          => 'submitbtn',
              'value'		=> 'Enviar',
              'class'		=> 'submitbtn',
            );?>
		<?=form_input($datos)?>
		
		<br style="clear:both;">
	</section>
	<?=form_close();?>
</div>
