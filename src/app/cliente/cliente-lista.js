(function () {

	'use strict';

	angular
	.module('app.cliente')
	.controller('ClienteLista', ClienteLista);

	ClienteLista.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'tabelaUtils', 'clienteRest', '$scope'];

	function ClienteLista(controllerUtils, AuthToken, $rootScope, jwtHelper, tabelaUtils, dataservice, $scope) {
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
				controllerUtils.$location.path('novo-cliente/' + aData.id_cliente);
				$scope.$apply();
			}

			function criarColunasTabela() {
				vm.tabela.colunas = tabelaUtils.criarColunas([
					['nome', 'Nome'], 
					['email', 'E-mail'], 
					['telefone', 'Celular'], 
					['cpf_cnpj', 'CPF/CNPJ'], 
					['id_cliente', 'Ações', tabelaUtils.criarBotaoPadrao]
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
				dataservice.remover(aData.id_cliente).then(success).catch(error);

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