(function() {
  'use strict';

  angular
    .module('minotaur')
    .config(routerConfig);

  /** @ngInject */
  function routerConfig($stateProvider, $urlRouterProvider) {
    $stateProvider
      //dashboard
      .state('dashboard', {
        url: '/app/dashboard',
        templateUrl: 'app/pages/dashboard/dashboard.html',
        controller: 'DashboardController',
        controllerAs: 'ds'
      })
      //app core pages (errors, login,signup)
      .state('pages', {
        url: '/app/pages',
        template: '<div ui-view></div>'
      })
      //login
      .state('pages.login', {
        url: '/login',
        templateUrl: 'app/pages/pages-login/pages-login.html',
        controller: 'LoginController',
        controllerAs: 'ctrl',
        parent: 'pages',
        specialClass: 'core'
      })
      //empresa
      .state('empresa', {
        url: '/app/empresa',
        templateUrl: 'app/pages/empresa/empresa.html',
        controller: 'EmpresaController',
        controllerAs: 'emp'
      })
      //planes
      .state('plan', {
        url: '/app/plan',
        templateUrl: 'app/pages/plan/plan.html',
        controller: 'PlanController as vm'
      })

      //categorias
      .state('categoria', {
        url: '/app/categoria',
        templateUrl: 'app/pages/categoria/categoria.html',
        controller: 'CategoriaController as vm'
      })
      //productos
      .state('producto', {
        url: '/app/producto',
        templateUrl: 'app/pages/producto/producto.html',
        controller: 'ProductoController as vm'
      })
      //alergenos
      .state('alergeno', {
        url: '/app/alergeno',
        templateUrl: 'app/pages/alergeno/alergeno.html',
        controller: 'AlergenoController as vm'
      })
      //qr
      .state('qr', {
        url: '/app/qr',
        templateUrl: 'app/pages/qr/qr.html',
        controller: 'QrController as vm'
      })
      //usuario
      .state('usuario', {
        url: '/app/usuario',
        templateUrl: 'app/pages/usuario/usuario.html',
        controller: 'UsuarioController as vm'
      })
      // configuracion
      .state('sys-configuracion', {
        url: '/app/sys-configuracion',
        templateUrl: 'app/pages/configuracion/sys-configuracion.html',
        controller: 'ConfiguracionController as vm'
      });

    $urlRouterProvider.otherwise('/app/dashboard');


  }

})();
