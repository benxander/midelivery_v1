<div class="modal-header">
	<h4 class="modal-title">{{mp.modalTitle}}</h4>
</div>
<div class="modal-body">
	<section class="tile-body p-0">
		<form name="formUsuario" role="form" novalidate class="form-validation">
			<div class="row">

				<div class="form-group col-xs-12">
					<label for="username" class="control-label minotaur-label">
						Nombre de Usuario <small class="text-red">(*)</small>
					</label>
					<input
						ng-model="mp.fData.username"
						type="text"
						name="username"
						id="username"
						class="form-control"
						placeholder="Registre Nombre de Usuario"
						autocomplete="off"
						required
					>
					<div ng-messages="formUsuario.username.$error" ng-if="formUsuario.username.$dirty"
						role="alert" class="help-block text-red">
						<div ng-messages-include="app/components/templates/messages_tmpl.html"></div>
					</div>
				</div>

				<div class="form-group col-xs-12">
					<label for="grupo" class="control-label minotaur-label">Grupo <small class="text-red">(*)</small> </label>
					<select class="form-control" ng-model="mp.fData.grupo"
						ng-options="item as item.descripcion for item in mp.fArr.listaGrupos" required></select>

				</div>

				<div class="form-group col-xs-12">
					<label for="password" class="control-label minotaur-label">
						Contraseña <small class="text-red">(*)</small>
					</label>
					<input
						ng-model="mp.fData.pass"
						type="pass"
						name="password"
						id="password"
						class="form-control"
						placeholder="Ingrese una contraseña"
						autocomplete="off"
						required
					>
					<div ng-messages="formUsuario.username.$error" ng-if="formUsuario.username.$dirty"
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
	<button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" ng-disabled="formUsuario.$invalid"
		ng-click="mp.aceptar()"><i class="fa fa-arrow-right"></i> Guardar</button>
</div>