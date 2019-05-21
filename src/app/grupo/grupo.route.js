(function () {

	'use strict';

	angular
		.module('app')
		.config(routes);

	routes.$inject = ['$routeProvider', '$locationProvider'];

	function routes($routeProvider, $locationProvider) {
		$routeProvider
			.when('/novo-grupo', {
				templateUrl: 'src/app/grupo/grupo.html',
				controller: 'Grupo',
				controllerAs: 'vm',
				titulo: 'Novo Grupo',
				cabecalho: {
					h1: 'Novo Grupo',
					breadcrumbs: [
						{
							nome: 'Grupo',
							link: '/',
							ativo: true
						}
					]
				}
			})
			.when('/novo-grupo/:id', {
				templateUrl: 'src/app/grupo/grupo.html',
				controller: 'Grupo',
				controllerAs: 'vm',
				titulo: 'Novo Grupo',
				cabecalho: {
					h1: 'Novo Grupo',
					breadcrumbs: [
						{
							nome: 'Grupo',
							link: '/',
							ativo: true
						}
					]
				}
			})
			.when('/grupo', {
				templateUrl: 'src/app/grupo/grupo-lista.html',
				controller: 'GrupoLista',
				controllerAs: 'vm',
				titulo: 'Grupo',
				cabecalho: {
					h1: 'Grupo',
					breadcrumbs: [
						{
							nome: 'Grupo',
							link: '/',
							ativo: true
						}
					]
				}
			});
	}

})();