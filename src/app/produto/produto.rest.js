(function () {
	'use strict';

	angular
		.module('app.produto')
		.factory('produtoRest', dataservice);

	dataservice.$inject = ['$http', '$location', '$q', 'configuracaoREST', '$httpParamSerializer'];

	function dataservice($http, $location, $q, configuracaoREST, $httpParamSerializer) {
		var service = {
			atualizar: atualizar,
			buscar: buscar,
			buscarCodigo: buscarCodigo,
			buscarTodos: buscarTodos,
			buscarTodosProdutos: buscarTodosProdutos,
			salvar: salvar,
			remover: remover
		};

		return service;

		function atualizar(id, data) {
			return $http.put(configuracaoREST.url + configuracaoREST.produto + 'atualizar/' + id, data);
		}

		function buscar(data) {	
			return $http.get(configuracaoREST.url + configuracaoREST.produto + data);
		}

		function buscarCodigo() {	
			return $http.get(configuracaoREST.url + configuracaoREST.produto + 'buscarCodigo');
		}

		function buscarTodos(data) {
			return $http.get(configuracaoREST.url + configuracaoREST.produto);
		}

		function buscarTodosProdutos(data) {
			return $http.get(configuracaoREST.url + configuracaoREST.produto + 'buscarTodosProdutos');
		}

		function salvar(data) {
			return $http.post(configuracaoREST.url + configuracaoREST.produto + 'salvar', data);
		}

		function remover(data) {
			return $http.delete(configuracaoREST.url + configuracaoREST.produto + 'excluir/' + data);
		}
	}
})();