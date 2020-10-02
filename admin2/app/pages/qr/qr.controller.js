(function () {
	'use strict';

	angular
		.module('minotaur')
		.controller('QrController', QrController)
		.service('QrServices', QrServices);

	/** @ngInject */
	function QrController(
		$scope,
		$uibModal,
		$timeout,
		$location,
		filterFilter,
		uiGridConstants,
		$document,
		alertify,
		QrServices,
		pinesNotifications
	) {
		var vm = this;
		$timeout(function () {
			vm.rutaCI = angular.patchURLCI;
			vm.direccionCarta = angular.patchURLCI + 'c/' + $scope.fSessionCI.nombre_negocio;

		}, 1000);
	}

	function QrServices($http, $q, handle) {
		return ({
			sMostrarQr: sMostrarQr
		});

		function sMostrarQr(pDatos) {
			var datos = pDatos || {};
			var request = $http({
				method: 'post',
				url: angular.patchURLCI + 'Inicio/qr',
				data: datos
			});
			return (request.then(handle.success, handle.error));
		}

	}
})();