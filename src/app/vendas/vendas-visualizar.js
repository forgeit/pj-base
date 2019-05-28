(function () {

	'use strict';

	angular
		.module('app.vendas')
		.controller('VisualizarVenda', VisualizarVenda);

	VisualizarVenda.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'vendasRest', 'produtoRest', 'clienteRest', 'vendasRest', '$window'];

	function VisualizarVenda(controllerUtils, AuthToken, $rootScope, jwtHelper, dataservice, produtoRest, clienteRest, vendasRest, $window) {
		var vm = this;

		vm.voltar = voltar;
		vm.pagar = pagar;
		vm.removerPagamento = removerPagamento;

		buscarDados();

		function pagar(id) {
			vendasRest.pagar(id).then(success).catch(error);

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao efetuar o pagamento.');
			}

			function success(response) {
				controllerUtils.feedMessage(response);

				if (response.data.status == 'true') {
					buscarDados();
				}
			}
		}

		function removerPagamento(id) {
			vendasRest.removerPagamento(id).then(success).catch(error);

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao efetuar o pagamento.');
			}

			function success(response) {
				controllerUtils.feedMessage(response);

				if (response.data.status == 'true') {
					buscarDados();
				}
			}
		}

		function buscarDados() {
			vendasRest.compra(controllerUtils.$routeParams.id).then(success).catch(error);

			function error(response) {
				vm.lista = [];
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Erro ao carregar os dados');
			}

			function success(response) {
				vm.lista = response.data.data.datatables;
			}
		}

		function voltar() {
			controllerUtils.$location.path('novo-cliente/' + controllerUtils.$routeParams.cliente);
		}

	}

})();