<style>
.enviar{
	position:relative;
	background: -webkit-linear-gradient(top, rgba(247,204,155,1) 2%, rgba(255,119,0,1) 64%, rgba(148,65,5,1) 100%);
	width: 120px;  height: 36px;
	margin-bottom: 20px; margin-left: 10px;
	border-radius: 10px;
	color: #fff;
	cursor: pointer;
	-webkit-box-shadow: inset 0px 1px 0px #FFC490, 0px 4px 0px #9D9D9D;
	-moz-box-shadow: inset 0px 1px 0px #FFC490, 0px 4px 0px #9D9D9D;
	-o-box-shadow: inset 0px 1px 0px #FFC490, 0px 4px 0px #9D9D9D;
	box-shadow: inset 0px 1px 0px #FFC490, 0px 4px 0px #9D9D9D;
}
.enviar:active{
	-webkit-box-shadow: inset 0px 0px 0px #FFC490, 0px 1px 0px #9D9D9D;
	-moz-box-shadow: inset 0px 0px 0px #FFC490, 0px 1px 0px #9D9D9D;
	-o-box-shadow: inset 0px 0px 0px #FFC490, 0px 1px 0px #9D9D9D;
	box-shadow: inset 0px 0px 0px #FFC490, 0px 1px 0px #9D9D9D;
	top:3px;
}
.desactivado{   opacity: 0.4; background: -webkit-linear-gradient(top, rgba(253, 230, 204, 1) 2%, rgba(184, 132, 87, 1) 64%, rgba(148,65,5,1) 100%);  cursor: not-allowed;}
</style>

<br>



<div class="act_dpto">
<? if ($this->session->flashdata('actualizado_con_exito')): ?>
    <div class="success">
        <strong>OK!</strong> Sus datos se actualizaron con exito
	</div>
<?endif;?>
<p style="margin-left: 15px;">Active 1 o mas provincias para su portal</p>
<form id="act" method="post" action="<?= site_url('admin/gestores/activar') ?>" style="margin-left: 15px;  color: #000; background-color: #EAEAEA;">

	<div style="margin: 0 auto;text-align: center">
        <a id="dpto_seleccionar_todos" href="#">Seleccionar todos</a> | <a id="dpto_deseleccionar_todos" href="#">Deseleccionar todos</a>
    </div>

	
	<table style="border-collapse: separate;border-spacing: 10px; width: 100%;background: #EAEAEA;margin-bottom: 10px;">
        <tbody>
            <!--<tr><td colspan="2">&nbsp;</td></tr>
			<tr><td colspan="2"><strong>Caracterisiticas:</strong></td></tr>-->
            <tr style="border-collapse: separate">
                <?
                $numero_provincia = 0;
                foreach ($provincias as $provincia):
					$numero_provincia++;
				?>
                    <td align="left" >                                  
                        <input class="checkbox_provincia" type="checkbox" value="<?= $provincia["id"]; ?>" 
						
							<? if($provincia["activo"]==='1'):?>
								checked="checked" 
							<?endif;?>
						
						id="provincia_<?= $provincia['id']; ?>" name="provincia[]" style="display: inline-block;" /><?= $provincia['nombre']; ?>
                    </td>
                    <? if ($numero_provincia % 4 == 0): ?>
            </tr>
			<tr>
                    <? endif; ?>
                <? endforeach; ?>
            </tr>
        </tbody>
    </table>
	<input id="guardar" type="submit" class="enviar desactivado" value="GUARDAR" disabled="disabled"/>
</form>
</div>
<div class="clear"></div>  
<script>
	$(function(){
		$('.checkbox_provincia').change(activar_boton)
		$('#dpto_seleccionar_todos').click(function(e){
			e.preventDefault();
			toggleChecked();
			activar_boton();
		});
		$('#dpto_deseleccionar_todos').click(function(e){
			e.preventDefault();
			toggleUnchecked();
			$('#guardar').addClass('desactivado');
		});
	});
	function toggleChecked() {
        // $("input[type=checkbox]").prop('checked', true);
		$("input:checkbox").prop('checked', true);
    }
    function toggleUnchecked() {
       $("input:checkbox").prop('checked', false);
	// $("input[type=checkbox]").prop('checked', false);
    }
	function activar_boton(){
		// alert('hola');
		if($('.checkbox_provincia').val()=='') alert('debe seleccionar algo');
		$('#guardar').removeClass('desactivado');
		$('#guardar').attr("disabled", false);
	}
</script>