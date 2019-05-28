(function () {

	'use strict';

	angular
		.module('app.vendas')
		.controller('VisualizarVenda', VisualizarVenda);

	VisualizarVenda.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', 'vendasRest', 'produtoRest', 'clienteRest', 'vendasRest'];

	function VisualizarVenda(controllerUtils, AuthToken, $rootScope, jwtHelper, dataservice, produtoRest, clienteRest, vendasRest) {
		var vm = this;

		buscarDados();

		function buscarDados() {
			vendasRest.compra(controllerUtils.$routeParams.id).then(success).catch(error);

			function error(response) {
				vm.lista = [];
				controllerUtils.feed(controllerUtils.messageType.ERROR, 'Erro ao carregar os dados');
			}

			function success(response) {
				vm.lista = response.data.data.datatables;
			}
		}

	}

})();