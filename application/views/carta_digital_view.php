<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Carta Digital | <?= $razon_social?></title>
	<link rel="stylesheet" href="<?=base_url();?>css/styles-merged.css">
	<link rel="stylesheet" href="<?=base_url();?>css/style_carta1.css">

</head>
<body>
	<div class="container">
		<h1 style="text-align:center"><?php echo $razon_social ?></h1>

		<div class="col-md-12">
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