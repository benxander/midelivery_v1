(function() {
  'use strict';
  angular
    .module('minotaur')
    .controller('UsuarioController', UsuarioController)
    .service('UsuarioServices', UsuarioServices);

  /** @ngInject */
  function UsuarioController(
    $scope,
    $uibModal,
    uiGridConstants,
    pinesNotifications,
    UsuarioServices
  ) {
    var vm = this;

    vm.fArr = {};

    // Lista grupos
    UsuarioServices.sListarGrupoCbo().then(function(rpta){
      vm.fArr.listaGrupos = rpta.datos;
    });

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
      { field: 'idusuario', name: 'idusuario', displayName: 'ID', width: 80, enableFiltering: false, sort: { direction: uiGridConstants.DESC } },
      { field: 'username', name: 'username', displayName: 'NOMBRE DE USUARIO' },
      { field: 'grupo', name: 'grupo', displayName: 'GRUPO DE USUARIO', width: 150 },
      { field: 'ultimo_inicio_sesion', name: 'ultimo_inicio_sesion', displayName: 'ULT INICIO SESION', width: 130 },

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
          'idusuario': grid.columns[1].filters[0].term,
          'username': grid.columns[2].filters[0].term,
          'descripcion_gr': grid.columns[3].filters[0].term,

        };
        vm.getPaginationServerSide();
      });
    }

    paginationOptions.sortName = vm.gridOptions.columnDefs[0].name;
    vm.getPaginationServerSide = function () {
      vm.datosGrid = {
        paginate: paginationOptions
      };
      UsuarioServices.sListarUsuarios(vm.datosGrid).then(function (rpta) {
        vm.gridOptions.data = rpta.datos;
        vm.gridOptions.totalItems = rpta.paginate.totalRows;
        vm.mySelectionGrid = [];
      });
    }
    vm.getPaginationServerSide();
    // mantenimiento
    vm.btnNuevo = function () {
      var modalInstance = $uibModal.open({
        templateUrl: 'app/pages/usuario/usuario_formview.php',
        controllerAs: 'mp',
        size: 'md',
        backdropClass: 'splash splash-2 splash-ef-14',
        windowClass: 'splash splash-2 splash-ef-14',
        /*backdropClass: 'splash splash-ef-14',
        windowClass: 'splash splash-ef-14',*/
        // controller: 'ModalInstanceController',
        controller: function ($scope, $uibModalInstance, arrToModal) {
          var vm = this;
          vm.fData = {};
          vm.modoEdicion = false;
          vm.getPaginationServerSide = arrToModal.getPaginationServerSide;
          vm.fArr = arrToModal.fArr;
          console.log('vm.fArr', vm.fArr);
          vm.fData.grupo = vm.fArr.listaGrupos[0];

          vm.modalTitle = 'Registro de Usuarios';
          // BOTONES
          vm.aceptar = function () {
            UsuarioServices.sRegistrarUsuario(vm.fData).then(function (rpta) {
              if (rpta.flag == 1) {
                $uibModalInstance.close(vm.fData);
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
            $uibModalInstance.dismiss('cancel');
          };
        },
        resolve: {
          arrToModal: function () {
            return {
              getPaginationServerSide: vm.getPaginationServerSide,
              fArr: vm.fArr
            }
          }
        }
      });
    }
  }
  function UsuarioServices($http, $q, handle) {
    return({
        sListarUsuarios: sListarUsuarios,
        sRegistrarUsuario: sRegistrarUsuario,
        sEditarUsuario: sEditarUsuario,
        sAnularUsuario: sAnularUsuario,
        sListaUsuarioAutocomplete: sListaUsuarioAutocomplete,
        sMostrarUsuarioID: sMostrarUsuarioID,
        sCambiarClave: sCambiarClave,
        sActualizarIntroNoMostrar: sActualizarIntroNoMostrar,
        sListarGrupoCbo: sListarGrupoCbo
    });
    function sListarUsuarios(pDatos) {
      var datos = pDatos || {};
      var request = $http({
            method : "post",
        url: angular.patchURLCI + "Usuario/listar_usuarios",
            data : datos
      });
      return (request.then( handle.success,handle.error ));
    }
    function sRegistrarUsuario(datos) {
      var request = $http({
            method : "post",
            url : angular.patchURLCI+"Usuario/registrar_usuario",
            data : datos
      });
      return (request.then(handle.success,handle.error));
    }
    function sEditarUsuario(datos) {
      var request = $http({
            method : "post",
            url : angular.patchURLCI+"Usuario/editar_usuario",
            data : datos
      });
      return (request.then(handle.success,handle.error));
    }
    function sAnularUsuario(datos) {
      var request = $http({
            method : "post",
            url : angular.patchURLCI+"Usuario/anular_usuario",
            data : datos
      });
      return (request.then(handle.success,handle.error));
    }
    function sListaUsuarioAutocomplete(datos) {
      var request = $http({
            method : "post",
            url : angular.patchURLCI+"Usuario/lista_usuario_autocomplete",
            data : datos
      });
      return (request.then(handle.success,handle.error));
    }
    function sMostrarUsuarioID(datos) {
      var request = $http({
            method : "post",
            url : angular.patchURLCI+"Usuario/mostrar_usuario_id",
            data : datos
      });
      return (request.then(handle.success,handle.error));
    }
    function sCambiarClave(datos) {
      var request = $http({
            method : "post",
            url : angular.patchURLCI+"Usuario/cambiar_clave",
            data : datos
      });
      return (request.then(handle.success,handle.error));
    }
    function sActualizarIntroNoMostrar() {
      var request = $http({
            method : "post",
            url : angular.patchURLCI+"Usuario/actualizar_intro_no_mostrar"
      });
      return (request.then(handle.success,handle.error));
    }
    function sListarGrupoCbo() {
      var request = $http({
            method : "post",
            url : angular.patchURLCI+"Usuario/listar_grupo_cbo"
      });
      return (request.then(handle.success,handle.error));
    }
  }
})();