(function () {

	'use strict';

	angular
		.module('app.vendas')
		.controller('VisualizarVenda', VisualizarVenda);

	VisualizarVenda.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'vendasRest', 'produtoRest', 'clienteRest', 'vendasRest', '$window', '$http'];

	function VisualizarVenda(controllerUtils, AuthToken, $rootScope, jwtHelper, dataservice, produtoRest, clienteRest, vendasRest, $window, $http) {
		var vm = this;

		vm.voltar = voltar;
		vm.pagar = pagar;
		vm.removerPagamento = removerPagamento;

		buscarDados();

		function pagar(objeto) {
			vendasRest.pagar(objeto.id_crediario).then(success).catch(error);

			function error(response) {
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao efetuar o pagamento.');
			}

			function success(response) {
				controllerUtils.feedMessage(response);

				if (response.data.status == 'true') {
					buscarDadosImpressao(objeto.id_crediario);
					buscarDados();
				}
			}
		}

		function buscarDadosImpressao(crediario) {
			vendasRest.buscarDadosImpressao(controllerUtils.$routeParams.id, crediario).then(success).catch(error);

			function error(response) {
				console.log(response);
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Erro ao efetuar a impressão do cupom.');
			}

			function success(response) {
				var dados = { 
					dataParcela: response.data.data.datatables.data_parcela,
					paga: response.data.data.datatables.paga,
					pendente: response.data.data.datatables.pendente
				};

				$http.post('http://localhost/cupom/imprimir-recibo-parcela.php', dados);
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