(function () {

	'use strict';

	angular
	.module('app.grupo')
	.controller('GrupoLista', GrupoLista);

	GrupoLista.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'tabelaUtils', 'grupoRest', '$scope'];

	function GrupoLista(controllerUtils, AuthToken, $rootScope, jwtHelper, tabelaUtils, dataservice, $scope) {
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
				controllerUtils.$location.path('novo-grupo/' + aData.id_grupo);
				$scope.$apply();
			}

			function criarColunasTabela() {
				vm.tabela.colunas = tabelaUtils.criarColunas([
					['descricao', 'Descrição'], 
					['id_grupo', 'Ações', tabelaUtils.criarBotaoPadrao]
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
				dataservice.remover(aData.id_grupo).then(success).catch(error);

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