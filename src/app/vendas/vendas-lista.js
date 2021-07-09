(function () {

	'use strict';

	angular
	.module('app.produto')
	.controller('VendasLista', VendasLista);

	VendasLista.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'tabelaUtils', 'vendasRest', '$scope', '$timeout', '$http'];

	function VendasLista(controllerUtils, AuthToken, $rootScope, jwtHelper, tabelaUtils, dataservice, $scope, $timeout, $http) {
		var vm = this;

		var vm = this;
		vm.tabela = {};
		vm.instancia = {};
		vm.irParaPagamento = irParaPagamento;
		vm.imprimirCupom = imprimirCupom;

		iniciar();

		function imprimirCupom(id)  {
			dataservice.reimprimirVenda(id).then(success).catch(error);

			function error(response) {
				console.log(response);
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Erro ao reiprimir o cupom.');
			}

			function success(response) {
		
				$http.post('http://192.168.100.111/cupom/index.php', response.data.data.datatables);
				
			}
		}

		function irParaPagamento(venda, cliente) {
			$('#modalVerVenda').modal('hide');
			$timeout(function () {
				controllerUtils.$location.path('compra/' + venda + '/' + cliente);
			}, 500);
		}

		function iniciar() {
			montarTabela();
		}

		function montarTabela() {
			criarOpcoesTabela();

			function carregarObjeto(aData) {

				dataservice.visualizarVenda(aData.id_venda).then(success).catch(error);

				function error() {
					controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao carregar os dados da venda.');
				}

				function success(response) {
					vm.venda = response.data.data.datatables;
					$('#modalVerVenda').modal('show');
				}
			}

			function criarColunasTabela() {
				vm.tabela.colunas = tabelaUtils.criarColunas([
						['id_venda', 'Código'], 
						['data_hora_venda', 'Data'], 
						['cliente', 'Cliente'], 
						['forma_pagamento', 'Forma Pagamento'], 
						['valor_total', 'Valor'], 
						['valor_entrada', 'Valor de Entrada'], 
						['id_venda', 'Ações', tabelaUtils.criarBotaoPadrao]
				]);
			}

			function criarOpcoesTabela() {
				vm.tabela.opcoes = tabelaUtils.criarTabela(ajax, vm, remover, 'data', carregarObjeto);
				criarColunasTabela();

				function ajax(data, callback, settings) {
					dataservice.buscarTodos(tabelaUtils.criarParametrosGet(data)).then(success).catch(error);

					function error(response) {
						controllerUtils.feed(controllerUtils.messageType.ERROR, 'Ocorreu um erro ao carregar a lista.');
					}

					function success(response) {
						callback(controllerUtils.getData(response, 'datatables'));
					}
				}
			}

			function remover(aData) {
				dataservice.remover(aData.id_produto).then(success).catch(error);

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