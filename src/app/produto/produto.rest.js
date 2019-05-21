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
			buscarTodos: buscarTodos,
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

		function buscarTodos(data) {
			return $http.get(configuracaoREST.url + configuracaoREST.produto);
		}

		function salvar(data) {
			return $http.post(configuracaoREST.url + configuracaoREST.produto + 'salvar', data);
		}

		function remover(data) {
			return $http.delete(configuracaoREST.url + configuracaoREST.produto + 'excluir/' + data);
		}
	}
})();