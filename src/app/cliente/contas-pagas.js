(function () {

	'use strict';

	angular
	.module('app.cliente')
	.controller('ContasPagas', ContasPagas);

	ContasPagas.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'tabelaUtils', 'vendasRest', '$scope'];

	function ContasPagas(controllerUtils, AuthToken, $rootScope, jwtHelper, tabelaUtils, dataservice, $scope) {
		var vm = this;

		var vm = this;
		vm.tabela = {};
		vm.instancia = {};

		iniciar();

		function iniciar() {
			montarTabela();
		}

		function montarTabela() {
			criarOpcoesTabela();

			function carregarObjeto(aData) {
				controllerUtils.$location.path('compra/' + aData.id_venda + '/' + controllerUtils.$routeParams.id);
				$scope.$apply();
			}

			function criarColunasTabela() {
				vm.tabela.colunas = tabelaUtils.criarColunas([
					[ 'data_hora', 'Data' ],
					[ 'valor_total', 'Valor' ],
					[ 'forma_pagamento', 'Nº Parcelas' ],
					[ 'total_pendente', 'Pendente' ],
					['id_venda', 'Ações', tabelaUtils.criarBotaoPadrao]]);
			}

			function criarOpcoesTabela() {
				vm.tabela.opcoes = tabelaUtils.criarTabela(ajax, vm, remover, 'data', carregarObjeto);
				vm.tabela.opcoes.withPaginationType('simple');
				criarColunasTabela();

				function ajax(data, callback, settings) {
					dataservice.buscarContasPagasCliente(controllerUtils.$routeParams.id).then(success).catch(error);

					function error(response) {
						controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao carregar a lista.');
					}

					function success(response) {
						callback(controllerUtils.getData(response, 'datatables'));
					}
				}
			}

			function remover(aData) {
				dataservice.remover(aData.id_venda).then(success).catch(error);

				function error(response) {
					controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao remover.');
				}

				function success(response) {
					controllerUtils.feedMessage(response);
					if (response.data.status == 'true') {
						tabelaUtils.recarregarDados(vm.instancia);
					}
				}
			}
		}
	}

})();