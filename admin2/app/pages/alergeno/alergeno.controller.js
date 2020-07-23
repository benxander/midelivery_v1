(function () {
	'use strict';

	angular
		.module('minotaur')
		.controller('AlergenoController', AlergenoController)
		.service('AlergenoServices', AlergenoServices);

	/** @ngInject */
	function AlergenoController(
		$scope,
		$uibModal,
		$timeout,
		$location,
		filterFilter,
		uiGridConstants,
		$document,
		alertify,
		AlergenoServices,
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
			rowHeight: 45,
			appScopeProvider: vm
		}
		vm.gridOptions.columnDefs = [
			{ field: 'idalergeno', name: 'idalergeno', displayName: 'ID', width: 80, enableFiltering: false, sort: { direction: uiGridConstants.DESC } },
			{ field: 'icono', name: 'icono', displayName: 'ICONO', width: 80, enableFiltering: false, cellTemplate: '<img src="{{COL_FIELD}}" width="40px">' },
			{ field: 'nombre', name: 'nombre', displayName: 'NOMBRE DEL ALERGENO', minWidth: 100,  },
			{ field: 'descripcion', name: 'descripcion', displayName: 'DESCRIPCION', minWidth: 120,  },

			{
				field: 'accion', name: 'accion', displayName: 'ACCION', width: 80, enableFiltering: false,
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
					'idalergeno': grid.columns[1].filters[0].term,
					'nombre': grid.columns[2].filters[0].term,

				};
				vm.getPaginationServerSide();
			});
		}

		paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
		vm.getPaginationServerSide = function () {
			vm.datosGrid = {
				paginate: paginationOptions
			};
			AlergenoServices.sListarAlergenos(vm.datosGrid).then(function (rpta) {
				vm.gridOptions.data = rpta.datos;
				vm.gridOptions.totalItems = rpta.paginate.totalRows;
				vm.mySelectionGrid = [];
			});
		}
		vm.getPaginationServerSide();


	}

	function AlergenoServices($http, $q, handle) {
		return ({
			sListarAlergenos: sListarAlergenos
		});

		function sListarAlergenos(pDatos) {
			var datos = pDatos || {};
			var request = $http({
				method: 'post',
				url: angular.patchURLCI + 'Alergeno/listar_alergenos',
				data: datos
			});
			return (request.then(handle.success, handle.error));
		}
	}
})();