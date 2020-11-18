<link rel="stylesheet" href="<?=$estilo?>">
<div class="mt10  probootstrap-animate">

    <div class="col-md-12">

        <? if( $modelo_carta === '1' ): ?>
            <div class="panel-group" id="accordion8" role="tablist" aria-multiselectable="false" >
                <?php foreach($categoria_carta AS $row): ?>
                <div class="panel panel-<?=$row['color']?>">
                    <div class="panel-heading" role="tab" id="acordion2<?=$row['idcategoria']?>">
                        <h4 class="panel-title">
                            <button class="btn"
                                type="button"
                                data-parent="#accordion8"
                                data-toggle="collapse"
                                data-target="#2<?=$row['idcategoria']?>"
                                aria-expanded="true"
                                aria-controls="2<?=$row['idcategoria']?>"
                            >
                                <?=$row['categoria']?>
                            </button>
                        </h4>
                    </div>
                    <div id="2<?=$row['idcategoria']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="acordion2<?=$row['idcategoria']?>">
                        <div class="panel-body">
                            <ul>
                            <?php foreach ($row['productos'] as $row2): ?>
                                <li>
                                    <div class="pull-left"><?= $row2['producto'] ?></div>
                                    <div class="pull-right"><?= $row2['precio'] ?> €</div>
                                    <div style="clear:both"></div>
                                    <?php if(!empty($row2['alergenos'])): ?>
                                    <div style="font-size: 0.9em;color: red;">
                                    <i class="fa fa-edit"></i>Presencia de Alérgenos <button class="btn btn-danger btn-xs">Ver Más</button>
                                    </div>
                                    <?php endif;?>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        <? else: ?>
            <div class="tabs">
                <? foreach($categoria_carta AS $key => $row): ?>

                    <div class="tab tab-<?=$row['color']?>">
                        <input type="checkbox" id="chck<?=$row['idcategoria']?>">
                        <label class="tab-label" for="chck<?=$row['idcategoria']?>"><?=$row['categoria']?></label>
                        <div class="tab-content">
                            <ul>
                                <? foreach ($row['productos'] as $row2): ?>
                                    <li>
                                        <div class="producto"><?= $row2['producto'] ?></div>
                                        <div class="precio"><?= $row2['precio'] ?> €</div>
                                        <?php if(!empty($row2['alergenos'])): ?>
                                            <div style="font-size: 0.9em;color: red;">
                                                <i class="fa fa-edit"></i>Presencia de Alérgenos <button class="btn btn-danger btn-xs">Ver Más</button>
                                            </div>
                                        <?php endif;?>

                                    </li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        <? endif; ?>


    </div>
</div>
