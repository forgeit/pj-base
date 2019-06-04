(function () {

	'use strict';

	angular
		.module('app')
		.config(routes);

	routes.$inject = ['$routeProvider', '$locationProvider'];

	function routes($routeProvider, $locationProvider) {
		$routeProvider
			.when('/vendas', {
				templateUrl: 'src/app/vendas/vendas.html',
				controller: 'Vendas',
				controllerAs: 'vm',
				titulo: 'Tela de Vendas',
				cabecalho: {
					h1: 'Tela de Vendas',
					breadcrumbs: [
						{
							nome: 'Vendas',
							link: '/',
							ativo: true
						}
					]
				}
			})
			.when('/todas-vendas', {
				templateUrl: 'src/app/vendas/vendas-lista.html',
				controller: 'VendasLista',
				controllerAs: 'vm',
				titulo: 'Vendas Efetuadas',
				cabecalho: {
					h1: 'Vendas Efetuadas',
					breadcrumbs: [
						{
							nome: 'Vendas',
							link: '/',
							ativo: true
						}
					]
				}
			})
			.when('/compra/:id/:cliente', {
				templateUrl: 'src/app/vendas/vendas-visualizar.html',
				controller: 'VisualizarVenda',
				controllerAs: 'vm',
				titulo: 'Visualizar Venda',
				cabecalho: {
					h1: 'Visualizar Venda',
					breadcrumbs: [
						{
							nome: 'Vendas',
							link: '/',
							ativo: true
						}
					]
				}
			});
	}

})();