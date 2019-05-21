(function () {
	'use strict';

	angular
		.module('app.grupo')
		.factory('grupoRest', dataservice);

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
			return $http.put(configuracaoREST.url + configuracaoREST.grupo + 'atualizar/' + id, data);
		}

		function buscar(data) {	
			return $http.get(configuracaoREST.url + configuracaoREST.grupo + data);
		}

		function buscarTodos(data) {
			return $http.get(configuracaoREST.url + configuracaoREST.grupo);
		}

		function salvar(data) {
			return $http.post(configuracaoREST.url + configuracaoREST.grupo + 'salvar', data);
		}

		function remover(data) {
			return $http.delete(configuracaoREST.url + configuracaoREST.grupo + 'excluir/' + data);
		}
	}
})();