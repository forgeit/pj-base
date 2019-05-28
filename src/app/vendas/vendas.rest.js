(function () {
	'use strict';

	angular
		.module('app.vendas')
		.factory('vendasRest', dataservice);

	dataservice.$inject = ['$http', '$location', '$q', 'configuracaoREST', '$httpParamSerializer'];

	function dataservice($http, $location, $q, configuracaoREST, $httpParamSerializer) {
		var service = {
			salvar: salvar,
			compra: compra,
			buscarContasPendentesCliente: buscarContasPendentesCliente,
			buscarContasPagasCliente: buscarContasPagasCliente
		};

		return service;

		function atualizar(id, data) {
			return $http.put(configuracaoREST.url + configuracaoREST.venda + 'atualizar/' + id, data);
		}

		function compra(data) {	
			return $http.get(configuracaoREST.url + configuracaoREST.venda + 'compra/' + data);
		}

		function buscarCombo() {
			return $http.get(configuracaoREST.url + configuracaoREST.venda + 'combo');
		}

		function buscarContasPendentesCliente(id) {
			return $http.get(configuracaoREST.url + configuracaoREST.venda + 'buscarContasPendentesCliente/' + id);
		}

		function buscarContasPagasCliente(id) {
			return $http.get(configuracaoREST.url + configuracaoREST.venda + 'buscarContasPagasCliente/' + id);
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