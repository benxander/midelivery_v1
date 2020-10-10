(function () {
	'use strict';

	angular
		.module('minotaur')
		.controller('AparienciaController', AparienciaController)
		.service('AparienciaServices', AparienciaServices);

	/** @ngInject */
	function AparienciaController(
		$scope,
		pinesNotifications,
		AparienciaServices
	) {
		var vm = this;
		vm.fData = {};

		// Lista de colores
		AparienciaServices.sCargarColores().then(function (rpta) {
			vm.listaColores = rpta.datos;
		});


		vm.btnGuardar = function(){
			console.log('modelo ', vm.fData.modelo);
			console.log('color ', vm.fData.idcolor);
			AparienciaServices.sGuardarApariencia(vm.fData).then(function (rpta) {
				if (rpta.flag == 1) {
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

	function AparienciaServices($http, $q, handle) {
		return ({
			sCargarColores: sCargarColores,
			sGuardarApariencia: sGuardarApariencia,
		});

		function sCargarColores(pDatos) {
			var datos = pDatos || {};
			var request = $http({
				method: 'post',
				url: angular.patchURLCI + 'Empresa/cargar_colores',
				data: datos
			});
			return (request.then(handle.success, handle.error));
		}
		function sGuardarApariencia(pDatos) {
			var datos = pDatos || {};
			var request = $http({
				method: 'post',
				url: angular.patchURLCI + 'Empresa/guardar_apariencia',
				data: datos
			});
			return (request.then(handle.success, handle.error));
		}

	}
})();