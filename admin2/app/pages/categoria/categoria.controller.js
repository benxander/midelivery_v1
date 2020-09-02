(function () {
	'use strict';

	angular
		.module('minotaur')
		.controller('CategoriaController', CategoriaController)
		.service('CategoriaServices', CategoriaServices);

	/** @ngInject */
	function CategoriaController(
		$scope,
		$uibModal,
		uiGridConstants,
		SweetAlert,
		CategoriaServices,
		pinesNotifications
	) {
		var vm = this;

		vm.fArr = {};

		// Grilla principal
		var paginationOptions = {
			pageNumber: 1,
			firstRow: 0,
			pageSize: 50,
			sort: uiGridConstants.DESC,
			sortName: null,
			search: null
		}
		vm.mySelectionGrid = [];
		vm.gridOptions = {
			paginationPageSizes: [50, 100, 500, 1000],
			paginationPageSize: 50,
			enableFiltering: true,
			enableSorting: true,
			useExternalPagination: true,
			useExternalSorting: true,
			useExternalFiltering: true,
			enableRowSelection: true,
			enableRowHeaderSelection: false,
			enableFullRowSelection: true,
			multiSelect: false,
			appScopeProvider: vm
		}
		vm.gridOptions.columnDefs = [
			{ field: 'idcategoria', name: 'idcategoria', displayName: 'ID', width: 80, enableFiltering: false, sort: { direction: uiGridConstants.DESC }},
			{ field: 'descripcion_cat', name: 'descripcion_cat', displayName: 'NOMBRE DE CATEGORIA' },

			{
				field: 'accion', name: 'accion', displayName: 'ACCIONES', width: 120, enableFiltering: false, enableColumnMenu: false,
				cellTemplate: '<label class="btn text-primary" ng-click="grid.appScope.btnEditar(row);$event.stopPropagation();" tooltip-placement="left" uib-tooltip="EDITAR"> <i class="fa fa-edit"></i> </label>' +
					'<label class="btn text-red" ng-click="grid.appScope.btnAnular(row);$event.stopPropagation();"> <i class="fa fa-trash" tooltip-placement="left" uib-tooltip="ELIMINAR!"></i> </label>'
			},

		];
		vm.gridOptions.onRegisterApi = function (gridApi) {
			vm.gridApi = gridApi;
			gridApi.selection.on.rowSelectionChanged($scope, function (row) {
				vm.mySelectionGrid = gridApi.selection.getSelectedRows();
			});
			gridApi.pagination.on.paginationChanged($scope, function (newPage, pageSize) {
				paginationOptions.pageNumber = newPage;
				paginationOptions.pageSize = pageSize;
				paginationOptions.firstRow = (paginationOptions.pageNumber - 1) * paginationOptions.pageSize;
				vm.getPaginationServerSide();
			});
			vm.gridApi.core.on.filterChanged($scope, function (grid, searchColumns) {
				var grid = this.grid;
				paginationOptions.search = true;
				paginationOptions.searchColumn = {
					'idcategoria': grid.columns[1].filters[0].term,
					'descripcion_cat': grid.columns[2].filters[0].term,

				};
				vm.getPaginationServerSide();
			});
		}

		paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
		vm.getPaginationServerSide = function () {
			vm.datosGrid = {
				paginate: paginationOptions
			};
			CategoriaServices.sListarCategorias(vm.datosGrid).then(function (rpta) {
				vm.gridOptions.data = rpta.datos;
				vm.gridOptions.totalItems = rpta.paginate.totalRows;
				vm.mySelectionGrid = [];
			});
		}
		vm.getPaginationServerSide();
		// mantenimiento
		vm.btnNuevo = function () {
			$uibModal.open({
				templateUrl: 'app/pages/categoria/categoria_formview.php',
				controllerAs: 'mp',
				size: 'md',
				backdropClass: 'splash splash-2 splash-info splash-ef-12',
				windowClass: 'splash splash-2 splash-ef-12',
				backdrop: 'static',
				keyboard: true,
				controller: function ($scope, $uibModalInstance, arrToModal) {
					var vm = this;
					vm.fData = {};
					vm.getPaginationServerSide = arrToModal.getPaginationServerSide;

					vm.modalTitle = 'Registro de Categorias';
					// BOTONES
					vm.aceptar = function () {
						CategoriaServices.sRegistrarCategoria(vm.fData).then(function (rpta) {
							if (rpta.flag == 1) {
								$uibModalInstance.close();
								vm.getPaginationServerSide();
								var pTitle = 'OK!';
								var pType = 'success';
							} else if (rpta.flag == 0) {
								var pTitle = 'Advertencia!';
								var pType = 'warning';
							} else {
								alert('Ocurrió un error');
							}
							pinesNotifications.notify({ title: pTitle, text: rpta.message, type: pType, delay: 3000 });
						});
					};
					vm.cancel = function () {
						$uibModalInstance.close();
					};
				},
				resolve: {
					arrToModal: function () {
						return {
							getPaginationServerSide: vm.getPaginationServerSide,
						}
					}
				}
			});
		}
		vm.btnEditar = function (row) {
			$uibModal.open({
				templateUrl: 'app/pages/categoria/categoria_formview.php',
				controllerAs: 'mp',
				size: 'md',
				backdropClass: 'splash splash-2 splash-info splash-ef-12',
				windowClass: 'splash splash-2 splash-ef-12',
				backdrop: 'static',
				keyboard: true,
				controller: function ($scope, $uibModalInstance, arrToModal) {
					var vm = this;
					vm.fData = angular.copy(row.entity);
					vm.getPaginationServerSide = arrToModal.getPaginationServerSide;

					vm.modalTitle = 'Edición de Categorias';
					// BOTONES
					vm.aceptar = function () {
						CategoriaServices.sEditarCategoria(vm.fData).then(function (rpta) {
							if (rpta.flag == 1) {
								$uibModalInstance.close();
								vm.getPaginationServerSide();
								var pTitle = 'OK!';
								var pType = 'success';
							} else if (rpta.flag == 0) {
								var pTitle = 'Advertencia!';
								var pType = 'warning';
							} else {
								alert('Ocurrió un error');
							}
							pinesNotifications.notify({ title: pTitle, text: rpta.message, type: pType, delay: 3000 });
						});
					};
					vm.cancel = function () {
						$uibModalInstance.close();
					};
				},
				resolve: {
					arrToModal: function () {
						return {
							getPaginationServerSide: vm.getPaginationServerSide,
						}
					}
				}
			});
		}

		vm.btnAnular = function (row) {
			SweetAlert.swal(
				{
					title: "Confirmación?",
					text: "¿Realmente desea eliminar la categoria?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#038dcc",
					// confirmButtonText: "Si, Generar!",
					// cancelButtonText: "No, Cancelar!",
					closeOnConfirm: true,
					closeOnCancel: false
				},
				function (isConfirm) {
					if (isConfirm) {
						vm.anularCategoria(row.entity);
					} else {
						SweetAlert.swal("Cancelado", "La operación ha sido cancelada", "error");
					}
				});
		}
		vm.anularCategoria = function (row) {
			CategoriaServices.sAnularCategoria(row).then(function (rpta) {
				if (rpta.flag == 1) {
					vm.getPaginationServerSide();
					var pTitle = 'OK!';
					var pType = 'success';
				} else if (rpta.flag == 0) {
					var pTitle = 'Advertencia!';
					var pType = 'warning';
				} else {
					alert('Ocurrió un error');
				}
				pinesNotifications.notify({ title: pTitle, text: rpta.message, type: pType, delay: 3000 });
			});
		}

	}

	function CategoriaServices($http, $q, handle){
		return({
			sListarCategorias: sListarCategorias,
			sRegistrarCategoria: sRegistrarCategoria,
			sEditarCategoria: sEditarCategoria,
			sAnularCategoria: sAnularCategoria,
		});

		function sListarCategorias(pDatos) {
			var datos = pDatos || {};
			var request = $http({
				method: 'post',
				url: angular.patchURLCI + 'Categoria/listar_categorias',
				data: datos
			});
			return (request.then(handle.success, handle.error));
		}
		function sRegistrarCategoria(pDatos) {
			var datos = pDatos || {};
			var request = $http({
				method: 'post',
				url: angular.patchURLCI + 'Categoria/registrar_categoria',
				data: datos
			});
			return (request.then(handle.success, handle.error));
		}
		function sEditarCategoria(pDatos) {
			var datos = pDatos || {};
			var request = $http({
				method: 'post',
				url: angular.patchURLCI + 'Categoria/editar_categoria',
				data: datos
			});
			return (request.then(handle.success, handle.error));
		}
		function sAnularCategoria(pDatos) {
			var datos = pDatos || {};
			var request = $http({
				method: 'post',
				url: angular.patchURLCI + 'Categoria/anular_categoria',
				data: datos
			});
			return (request.then(handle.success, handle.error));
		}
	}
})();