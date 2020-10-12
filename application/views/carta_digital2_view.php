<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Carta Digital | <?= $razon_social?></title>
	<link rel="stylesheet" href="<?=base_url();?>css/styles-merged.css">
	<link rel="stylesheet" href="<?=base_url();?>css/style_carta2.css">

</head>
<body>
	<div class="container">
		<h1 style="text-align:center"><?php echo $razon_social ?></h1>

		<div class="col-md-12">
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
		</div>
	</div>

	<script
		src="//code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
		crossorigin="anonymous"></script>
	<script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="<?=base_url();?>js/scripts.min.js"></script>
    <!-- <script src="<?=base_url();?>js/custom.min.js"></script> -->
</body>
</html>