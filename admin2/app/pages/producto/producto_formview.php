<style>
.splash .modal-content{overflow:visible}
</style>
<div class="modal-header">
	<h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formProducto" role="form" novalidate class="form-validation" autocomplete="off">
			<div class="row">
				<div class="form-group col-xs-12">
					<label for="producto" class="control-label minotaur-label">
						Nombre del producto <small class="text-red">(*)</small>
					</label>
					<input
						ng-model="mp.fData.descripcion_pr"
						type="text"
						name="producto"
						id="producto"
						class="form-control"
						placeholder="Registre Nombre del producto"
						autocomplete="off"
						required
					>
					<div ng-messages="formUsuario.nombre.$error" ng-if="formProducto.producto.$dirty"
						role="alert" class="help-block text-red">
						<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
					</div>
				</div>
				<div class="form-group col-xs-12">
					<label class="control-label minotaur-label">Categoria <small class="text-red">(*)</small> </label>
					<select class="form-control" ng-model="mp.fData.categoria"
						ng-options="item as item.descripcion for item in mp.fArr.listaCategorias" required></select>

				</div>

				<div class="form-group col-xs-12">
					<label class="control-label minotaur-label">Alérgenos</label>
					<div class="">
						<select multiple
							chosen="{width: '100%'}"
							data-placeholder-text-multiple="'Elige 1 o más alérgenos'"
							no-results-text="'No hay resultados para ...'"
  							ng-model="mp.fData.alergenos"
  							ng-options="item.id as item.descripcion for item in mp.fArr.listaAlergenos"
						>
							<option value=""></option>
						</select>
					</div>
					</div>

				<div class="form-group col-xs-12">
					<label for="precio" class="control-label minotaur-label">
						Precio (€)<small class="text-red">(*)</small>
					</label>
					<input
						ng-model="mp.fData.precio"
						type="text"
						name="precio"
						id="precio"
						class="form-control"
						placeholder="Registre el precio"
						autocomplete="off"
						required
					>
					<div ng-messages="formUsuario.nombre.$error" ng-if="formProducto.precio.$dirty"
						role="alert" class="help-block text-red">
						<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
<div class="modal-footer">
	<button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" ng-click="mp.cancel()"><i class="fa fa-arrow-left"></i>
		Cancelar</button>
	<button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formProducto.$invalid"
		ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>