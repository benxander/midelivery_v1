<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Carta Digital | <?= $razon_social?></title>
	<link rel="stylesheet" href="<?=base_url();?>css/styles-merged.css">
	<link rel="stylesheet" href="<?=base_url();?>css/style.min.css">
</head>
<body>
	<h1 style="text-align:center"><?php echo $razon_social ?></h1>

    <div class="col-md-12">
		<div class="panel-group" id="accordion8" role="tablist" aria-multiselectable="false" >
			<? foreach($categoria_carta AS $row): ?>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="acordion2<?=$row['idcategoria']?>">
					<h4 class="panel-title">
						<button class="btn"
							type="button"
							data-parent="#accordion8"
							data-toggle="collapse"
							data-target="#2<?=$row['categoria']?>"
							aria-expanded="true"
							aria-controls="2<?=$row['categoria']?>"
						>
							<?=$row['categoria']?>
						</button>
					</h4>
				</div>
				<div id="2<?=$row['categoria']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="acordion2<?=$row['idcategoria']?>">
					<div class="panel-body">
						<ul>
						<? foreach ($row['productos'] as $row2): ?>
								<li><?= $row2['producto'] ?></li>
						<? endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<? endforeach; ?>

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