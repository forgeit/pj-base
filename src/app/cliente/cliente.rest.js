(function () {
	'use strict';

	angular
		.module('app.cliente')
		.factory('clienteRest', dataservice);

	dataservice.$inject = ['$http', '$location', '$q', 'configuracaoREST', '$httpParamSerializer'];

	function dataservice($http, $location, $q, configuracaoREST, $httpParamSerializer) {
		var service = {
			atualizar: atualizar,
			buscar: buscar,
			buscarTodos: buscarTodos,
			buscarTodosClientes: buscarTodosClientes,
			salvar: salvar,
			remover: remover
		};

		return service;

		function atualizar(id, data) {
			return $http.put(configuracaoREST.url + configuracaoREST.cliente + 'atualizar/' + id, data);
		}

		function buscar(data) {	
			return $http.get(configuracaoREST.url + configuracaoREST.cliente + data);
		}

		function buscarTodos(data) {
			return $http.get(configuracaoREST.url + configuracaoREST.cliente);
		}

		function buscarTodosClientes(data) {
			return $http.get(configuracaoREST.url + configuracaoREST.cliente + 'buscarTodosClientes');
		}

		function salvar(data) {
			return $http.post(configuracaoREST.url + configuracaoREST.cliente + 'salvar', data);
		}

		function remover(data) {
			return $http.delete(configuracaoREST.url + configuracaoREST.cliente + 'excluir/' + data);
		}
	}
})();