(function () {

	'use strict';

	angular
		.module('app')
		.config(routes);

	routes.$inject = ['$routeProvider', '$locationProvider'];

	function routes($routeProvider, $locationProvider) {
		$routeProvider
			.when('/novo-cliente', {
				templateUrl: 'src/app/cliente/cliente.html',
				controller: 'Cliente',
				controllerAs: 'vm',
				titulo: 'Novo Cliente',
				cabecalho: {
					h1: 'Novo Cliente',
					breadcrumbs: [
						{
							nome: 'Cliente',
							link: '/',
							ativo: true
						}
					]
				}
			})
			.when('/novo-cliente/:id', {
				templateUrl: 'src/app/cliente/cliente.html',
				controller: 'Cliente',
				controllerAs: 'vm',
				titulo: 'Novo Cliente',
				cabecalho: {
					h1: 'Novo Cliente',
					breadcrumbs: [
						{
							nome: 'Cliente',
							link: '/',
							ativo: true
						}
					]
				}
			})
			.when('/cliente', {
				templateUrl: 'src/app/cliente/cliente-lista.html',
				controller: 'ClienteLista',
				controllerAs: 'vm',
				titulo: 'Cliente',
				cabecalho: {
					h1: 'Cliente',
					breadcrumbs: [
						{
							nome: 'Cliente',
							link: '/',
							ativo: true
						}
					]
				}
			});
	}

})();