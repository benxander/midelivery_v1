<script>
function cargar_mapa(){

};
</script>
<br>
<div id="servicios">
	<table style="border-collapse: separate;border-spacing: 10px; width: 100%">
        <tbody>
            <tr style="border-collapse: separate">
                <?
                $numero_servicio = 0;
                foreach ($servicios as $servicio):
                ?>

                    <? $numero_servicio++; ?>
					
					<? $selects = explode(",", $anuncio_servicios);?>
						
					
                    <td align="left" > <!--colspan="2"-->                                    
                        <input class="checkbox_servicio" type="checkbox" value="<?= $servicio["id"] ?>" 
						<?foreach ($selects as $select):?>
						<? if($servicio["id"]===$select):?>
						checked="checked" 
						<?endif;?>
						<?endforeach;?>
						id="servicio_<?= $servicio['id'] ?>" name="servicios[]"  /><label for="servicio_<?= $servicio['id'] ?>"><?= $servicio['servicio'] ?></label>
                    </td>
                    <? if ($numero_servicio % 4 == 0): ?>

            </tr>
			<tr>
                    <? endif; ?>
                <? endforeach; ?>
            </tr>
        </tbody>
    </table>
</div>
<div class="clear"></div>  