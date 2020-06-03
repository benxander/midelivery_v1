<br>
<div id="idiomas">

	<table style="border-collapse: separate;border-spacing: 10px; width: 100%">
        <tbody>
            <tr style="border-collapse: separate">
                <?
                $numero_idioma = 0;
                foreach ($idiomas as $idioma):
					$numero_idioma++; ?>

                    <td align="left" > <!--colspan="2"-->                                    
                        <input class="checkbox_idioma" type="checkbox" value="<?= $idioma["id"] ?>" id="idioma_<?= $idioma['id'] ?>" name="idiomas[]"  /><label for="idioma_<?= $idioma['id'] ?>"><img src="<?=base_url()?>images/flags/<?=$idioma['bandera']?>" width="16" height="11"/> <?= $idioma['idioma'] ?></label>
                    </td>
					
                    <? if ($numero_idioma % 4 == 0): ?>

            </tr>
			<tr>
                    <? endif; ?>
                <? endforeach; ?>
            </tr>
        </tbody>
    </table>
</div>
<div class="clear"></div>

    