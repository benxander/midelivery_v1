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
      //carta
      .state('carta', {
        url: '/app/carta',
        templateUrl: 'app/pages/carta/carta.html',
        controller: 'CartaController as vm'
      })

      //secciones
      .state('seccion', {
        url: '/app/seccion',
        templateUrl: 'app/pages/seccion/seccion.html',
        controller: 'SeccionController as vm'
      })
      //alergenos
      .state('alergeno', {
        url: '/app/alergeno',
        templateUrl: 'app/pages/alergeno/alergeno.html',
        controller: 'AlergenoController as vm'
      })
      //informe empresarial
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
