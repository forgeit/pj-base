(function () {

	'use strict';

	angular
		.module('app.produto')
		.controller('Produto', Produto);

	Produto.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'produtoRest', 'grupoRest'];

	function Produto(controllerUtils, AuthToken, $rootScope, jwtHelper, dataservice, grupoRest) {
		var vm = this;

		vm.atualizar = atualizar;
		vm.produto = {};
		vm.editar = false;
		vm.salvar = salvar;
		vm.voltar = voltar;
		vm.grupoLista = [];

		iniciar();

		function atualizar(formulario) {
			dataservice.atualizar(vm.produto.id_produto, vm.produto).then(success).catch(error);

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao atualizar o produto.');
			}

			function success(response) {
				controllerUtils.feedMessage(response);

				if (response.data.status == 'true') {
					voltar();
				}
			}
		}

		function carregarProduto(data) {
			return dataservice.buscar(data).then(success).catch(error);

			function error(response) {
				return controllerUtils.promise.criar(false, {});
			}

			function success(response) {
				return controllerUtils.promise.criar(true, response.data.data.ProdutoDTO);
			}
		}

		function buscarComboGrupo() {
			return grupoRest.buscarCombo().then(success).catch(error);

			function error(response) {
				return controllerUtils.promise.criar(false, {});
			}

			function success(response) {
				return controllerUtils.promise.criar(true, response.data.data);
			}
		}

		function buscarCodigo() {
			return dataservice.buscarCodigo().then(success).catch(error);

			function error(response) {
				return controllerUtils.promise.criar(false, {});
			}

			function success(response) {
				return controllerUtils.promise.criar(true, response.data.data.id);
			}
		}

		function editarObjeto() {
			vm.editar = !angular.equals({}, controllerUtils.$routeParams);
			return !angular.equals({}, controllerUtils.$routeParams);
		}

		function inicializarObjetos(values) {
			if (values[0].exec) {
				vm.grupoLista = values[0].objeto;
			} else {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao carregar a lista de grupos.');
			}

			if (editarObjeto()) {
				if (values[1].exec) {
					vm.produto = values[1].objeto;
				} else {
					controllerUtils.feed(controllerUtils.messageType.ERROR, 'Não foi possível carregar os dados do produto.');
				}
			} else {
				if (values[1].exec) {
					vm.produto.codigo = values[1].objeto;
				} else {
					controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao carregar o último código.');
				}
			}
		}

		function iniciar() {
			var promises = [];

			promises.push(buscarComboGrupo());
			
			if (editarObjeto()) {
				promises.push(carregarProduto(controllerUtils.$routeParams.id));
			} else {
				promises.push(buscarCodigo());
			}

			return controllerUtils.ready(promises).then(function (values) {
				inicializarObjetos(values);
			});
		}

		function salvar(formulario) {
			if (formulario.$valid) {
				dataservice.salvar(vm.produto).then(success).catch(error);
			} else {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Dados inválidos.');
			}

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao registrar o produto.');
			}

			function success(response) {
				controllerUtils.feedMessage(response);

				if (response.data.status == 'true') {
					voltar();
				}
			}
		}

		function voltar() {
			controllerUtils.$location.path('produto');
		}
	}

})();