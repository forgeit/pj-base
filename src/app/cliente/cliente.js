(function () {

	'use strict';

	angular
		.module('app.cliente')
		.controller('Cliente', Cliente);

	Cliente.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'clienteRest'];

	function Cliente(controllerUtils, AuthToken, $rootScope, jwtHelper, dataservice) {
		var vm = this;

		vm.atualizar = atualizar;
		vm.cliente = {};
		vm.editar = false;
		vm.salvar = salvar;
		vm.voltar = voltar;

		iniciar();

		function atualizar(formulario) {
			dataservice.atualizar(vm.cliente.id_cliente, vm.cliente).then(success).catch(error);

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao atualizar o cliente.');
			}

			function success(response) {
				controllerUtils.feedMessage(response);

				if (response.data.status == 'true') {
					voltar();
				}
			}
		}

		function carregarCliente(data) {
			return dataservice.buscar(data).then(success).catch(error);

			function error(response) {
				return controllerUtils.promise.criar(false, {});
			}

			function success(response) {
				return controllerUtils.promise.criar(true, response.data.data.ClienteDTO);
			}
		}

		function editarObjeto() {
			vm.editar = !angular.equals({}, controllerUtils.$routeParams);
			return !angular.equals({}, controllerUtils.$routeParams);
		}

		function inicializarObjetos(values) {			
			if (editarObjeto()) {
				if (values[0].exec) {
					vm.cliente = values[0].objeto;
				} else {
					controllerUtils.feed(controllerUtils.messageType.ERROR, 'Não foi possível carregar os dados do cliente.');
				}
			}
		}

		function iniciar() {
			var promises = [];
			
			if (editarObjeto()) {
				promises.push(carregarCliente(controllerUtils.$routeParams.id));
			}

			return controllerUtils.ready(promises).then(function (values) {
				inicializarObjetos(values);
			});
		}

		function salvar(formulario) {
			if (formulario.$valid) {
				dataservice.salvar(vm.cliente).then(success).catch(error);
			} else {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Dados inválidos.');
			}

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao registrar o cliente.');
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
			controllerUtils.$location.path('cliente');
		}
	}

})();