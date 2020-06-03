<div class="container mt10  probootstrap-animate">


    <div class="col-md-12">
        <div class="col-md-6">
                <div class="panel-group" id="accordion8" role="tablist" aria-multiselectable="false" >
                    <? foreach($secciones_carta AS $row): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="acordion2<?=$row['idseccion']?>">
                            <h4 class="panel-title">
                                <button class="btn "
                                    type="button"
                                    data-parent="#accordion8"
                                    data-toggle="collapse"
                                    data-target="#2<?=$row['seccion']?>"
                                    aria-expanded="true"
                                    aria-controls="2<?=$row['seccion']?>"
                                >
                                    <?=$row['seccion']?>
                                </button>
                            </h4>
                        </div>
                        <div id="2<?=$row['seccion']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="acordion2<?=$row['idseccion']?>">
                            <div class="panel-body">
                                <ul>
                                <? foreach ($row['lista_carta'] as $row2): ?>
                                        <li><?= $row2['carta'] ?></li>
                                <? endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <? endforeach; ?>

                </div>
            </div>

    </div>
</div>
