(function() {
	'use strict';

	angular
		.module('minotaur')
		.controller('CartaDemoController', CartaDemoController)
		.service('CartaDemoServices', CartaDemoServices);

	/** @ngInject */
	function CartaDemoController($scope, uiGridConstants, $uibModal, CartaDemoServices) {
		var vm = this;
		vm.fData = {};

		// GRILLA PRINCIPAL
		var paginationOptions = {
			pageNumber: 1,
			firstRow: 0,
			pageSize: 10,
			sort: uiGridConstants.DESC,
			sortName: null,
			search: null
		};
		vm.mySelectionGrid = [];
		vm.gridOptions = {
			paginationPageSizes: [10, 50, 100, 500, 1000],
			paginationPageSize: 10,
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
			{ field: 'idempresa', name: 'idempresa', displayName: 'ID', width: 80, enableFiltering: false, sort: { direction: uiGridConstants.DESC } },
			{ field: 'razon_social', name: 'razon_social', displayName: 'NOMBRE CARTA' },
			{ field: 'modelo_carta', name: 'modelo_carta', displayName: 'MODELO', width: 120 },
			{ field: 'color', name: 'color', displayName: 'COLOR', width: 150, },

			{
				field: 'accion', name: 'accion', displayName: 'ACCIONES', width: 130, enableFiltering: false, enableColumnMenu: false,
				cellTemplate: '<label class="btn btn-primary" ng-click="grid.appScope.btnEditar(row);$event.stopPropagation();" tooltip-placement="left" uib-tooltip="EDITAR"> <i class="fa fa-edit"></i> </label>' +
					'<label class="btn btn-warning" ng-click="grid.appScope.btnCategorias(row);$event.stopPropagation();" tooltip-placement="left" uib-tooltip="CATEGORIAS"> <i class="fa fa-coffee"></i> </label>' +
					'<label class="btn btn-success" ng-click="grid.appScope.btnProductos(row);$event.stopPropagation();"> <i class="fa fa-coffee" tooltip-placement="left" uib-tooltip="PRODUCTOS!"></i></label>'

			},

		];

		vm.getPaginationServerSide = function () {
			vm.datosGrid = {
				paginate: paginationOptions
			};
			CartaDemoServices.sListarCartasDemo(vm.datosGrid).then(function (rpta) {
				vm.gridOptions.data = rpta.datos;
				vm.gridOptions.totalItems = rpta.paginate.totalRows;
				vm.mySelectionGrid = [];
			});
		}
		vm.getPaginationServerSide();

		vm.btnCategorias = function(row){
			$uibModal.open({
				templateUrl: 'app/pages/configuracion/categorias_formview.php',
				controllerAs: 'mp',
				size: 'lg',
				backdropClass: 'splash splash-2 splash-info splash-ef-12',
				windowClass: 'splash splash-2 splash-ef-12',
				backdrop: 'static',
				keyboard: false,
				controller: function ($scope, $uibModalInstance) {
					var vm = this;
					vm.temporal = {}
					vm.fData = row.entity;
					console.log('row', row.entity);
					vm.modalTitle = 'Categorias del ' + vm.fData.razon_social;

					vm.gridOptions = {};
					vm.gridOptions.data = [];


					vm.agregarCat = function(){
						console.log('TEMPORAL', vm.temporal);
					}
					vm.cancel = function () {
						$uibModalInstance.dismiss('cancel');
					};

				}


			})
		}

	}

	function CartaDemoServices($http, $q, handle) {
		return({
			sListarCartasDemo: sListarCartasDemo
		});

		function sListarCartasDemo(pDatos) {
			var datos = pDatos || {}
			var request = $http({
				method: "post",
				url: angular.patchURLCI + "Empresa/listar_cartas_demo",
				data: datos
			});
			return(request.then(handle.success, handle.error));
		}
	}
  })();