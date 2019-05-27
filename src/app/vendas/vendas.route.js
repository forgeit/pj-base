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
			});
	}

})();