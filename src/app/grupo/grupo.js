(function () {

	'use strict';

	angular
		.module('app.grupo')
		.controller('Grupo', Grupo);

	Grupo.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'grupoRest'];

	function Grupo(controllerUtils, AuthToken, $rootScope, jwtHelper, dataservice) {
		var vm = this;

		vm.atualizar = atualizar;
		vm.grupo = {};
		vm.editar = false;
		vm.salvar = salvar;
		vm.voltar = voltar;

		iniciar();

		function atualizar(formulario) {
			dataservice.atualizar(vm.grupo.id_grupo, vm.grupo).then(success).catch(error);

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao atualizar o grupo.');
			}

			function success(response) {
				controllerUtils.feedMessage(response);

				if (response.data.status == 'true') {
					voltar();
				}
			}
		}

		function carregarGrupo(data) {
			return dataservice.buscar(data).then(success).catch(error);

			function error(response) {
				return controllerUtils.promise.criar(false, {});
			}

			function success(response) {
				return controllerUtils.promise.criar(true, response.data.data.GrupoDTO);
			}
		}

		function editarObjeto() {
			vm.editar = !angular.equals({}, controllerUtils.$routeParams);
			return !angular.equals({}, controllerUtils.$routeParams);
		}

		function inicializarObjetos(values) {			
			if (editarObjeto()) {
				if (values[0].exec) {
					vm.grupo = values[0].objeto;
				} else {
					controllerUtils.feed(controllerUtils.messageType.ERROR, 'Não foi possível carregar os dados do grupo.');
				}
			}
		}

		function iniciar() {
			var promises = [];
			
			if (editarObjeto()) {
				promises.push(carregarGrupo(controllerUtils.$routeParams.id));
			}

			return controllerUtils.ready(promises).then(function (values) {
				inicializarObjetos(values);
			});
		}

		function salvar(formulario) {
			if (formulario.$valid) {
				dataservice.salvar(vm.grupo).then(success).catch(error);
			} else {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Dados inválidos.');
			}

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao registrar o grupo.');
			}

			function success(response) {
				console.log(response);
				controllerUtils.feedMessage(response);

				if (response.data.status == 'true') {
					voltar();
				}
			}
		}

		function voltar() {
			controllerUtils.$location.path('grupo');
		}
	}

})();