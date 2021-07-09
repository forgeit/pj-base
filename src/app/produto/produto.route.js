(function () {

	'use strict';

	angular
		.module('app')
		.config(routes);

	routes.$inject = ['$routeProvider', '$locationProvider'];

	function routes($routeProvider, $locationProvider) {
		$routeProvider
			.when('/novo-produto', {
				templateUrl: 'src/app/produto/produto.html',
				controller: 'Produto',
				controllerAs: 'vm',
				titulo: 'Novo Produto',
				cabecalho: {
					h1: 'Novo Produto',
					breadcrumbs: [
						{
							nome: 'Produto',
							link: '/',
							ativo: true
						}
					]
				}
			})
			.when('/novo-produto/:id', {
				templateUrl: 'src/app/produto/produto.html',
				controller: 'Produto',
				controllerAs: 'vm',
				titulo: 'Novo Produto',
				cabecalho: {
					h1: 'Novo Produto',
					breadcrumbs: [
						{
							nome: 'Produto',
							link: '/',
							ativo: true
						}
					]
				}
			})
			.when('/produto', {
				templateUrl: 'src/app/produto/produto-lista.html',
				controller: 'ProdutoLista',
				controllerAs: 'vm',
				titulo: 'Produto',
				cabecalho: {
					h1: 'Produto',
					breadcrumbs: [
						{
							nome: 'Produto',
							link: '/',
							ativo: true
						}
					]
				}
			});
	}

})();