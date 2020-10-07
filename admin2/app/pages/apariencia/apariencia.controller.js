(function () {
	'use strict';

	angular
		.module('minotaur')
		.controller('AparienciaController', AparienciaController)
		.service('AparienciaServices', AparienciaServices);

	/** @ngInject */
	function AparienciaController(
		$scope,
		$uibModal,
		$timeout
	) {
		var vm = this;

		vm.listaColores = [
			{
				idcolor: 1,
				nombre: 'Rojo',
				hexa: '#EB1B29'
			},
			{
				idcolor: 2,
				nombre: 'Anaranjado',
				hexa: '#F6781E'
			},
			{
				idcolor: 3,
				nombre: 'Anaranjado2',
				hexa: '#FA9C14'
			},
			{
				idcolor: 4,
				nombre: 'Amarillo',
				hexa: '#FDDB03'
			},
			{
				idcolor: 5,
				nombre: 'Verde Lima',
				hexa: '#AFDB24'
			},
			{
				idcolor: 6,
				nombre: 'Verde',
				hexa: '#40BB4F'
			},
			{
				idcolor: 7,
				nombre: 'Verde2',
				hexa: '#01A870'
			},
			{
				idcolor: 8,
				nombre: 'Azul',
				hexa: '#1679CB'
			},
			{
				idcolor: 9,
				nombre: 'Lila',
				hexa: '#525CB3'
			},
			{
				idcolor: 10,
				nombre: 'Morado',
				hexa: '#7A2995'
			},
			{
				idcolor: 11,
				nombre: 'Fucsia',
				hexa: '#C91091'
			},
		]



	}

	function AparienciaServices($http, $q, handle) {
		return ({
			sCargarColores: sCargarColores
		});

		function sCargarColores(pDatos) {
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