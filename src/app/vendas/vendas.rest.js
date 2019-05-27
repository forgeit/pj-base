(function () {
	'use strict';

	angular
		.module('app.vendas')
		.factory('vendasRest', dataservice);

	dataservice.$inject = ['$http', '$location', '$q', 'configuracaoREST', '$httpParamSerializer'];

	function dataservice($http, $location, $q, configuracaoREST, $httpParamSerializer) {
		var service = {
			salvar: salvar
		};

		return service;

		function atualizar(id, data) {
			return $http.put(configuracaoREST.url + configuracaoREST.venda + 'atualizar/' + id, data);
		}

		function buscar(data) {	
			return $http.get(configuracaoREST.url + configuracaoREST.venda + data);
		}

		function buscarCombo() {
			return $http.get(configuracaoREST.url + configuracaoREST.venda + 'combo');
		}

		function buscarTodos(data) {
			return $http.get(configuracaoREST.url + configuracaoREST.venda);
		}

		function salvar(data) {
			return $http.post(configuracaoREST.url + configuracaoREST.venda + 'salvar', data);
		}

		function remover(data) {
			return $http.delete(configuracaoREST.url + configuracaoREST.venda + 'excluir/' + data);
		}
	}
})();