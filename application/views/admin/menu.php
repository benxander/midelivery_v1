<div class="middle_admin">
    <div class="ancho_centrado">
        <?if (isset($mensaje)):?>
            <div class="error"><?= $mensaje ?></div>
        <?endif;?>



	<aside class="main-sidebar">

		<div class="content-box-header">
			<a href="<?= site_url('') ?>">
					<span>
						<img width="200px" src="<?=base_url()?>uploads/<?= get_imagen('logo_header')?>">
					</span>
					</a>
		</div>

		<div id="menu_lateral">
			  <? if ($this->session->userdata('administrador')): ?>
				<? $this->load->view('admin/menu_administrador'); ?>
			<? elseif($this->session->userdata('profesional')): ?>
				<? $this->load->view('admin/menu_profesional'); ?>
			<? else:?>
				<? $this->load->view('admin/menu_usuario_registrado'); ?>
			<? endif; ?>


		</div>

     </aside>	<!-- end menu_lateral -->

