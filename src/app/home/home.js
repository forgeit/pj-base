(function () {

	'use strict';

	angular
		.module('app.home')
		.controller('Home', Home);

	Home.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', '$http', 'vendasRest'];

	function Home(controllerUtils, AuthToken, $rootScope, jwtHelper, $http, vendasRest) {
		var vm = this;

		buscarDadosHome();

		function buscarDadosHome() {
			vendasRest.buscarDadosHome().then(success).catch(error);

			function error(response) {
				if (vm.dados)
					delete vm.dados;
			}

			function success(response) {
				vm.dados = response.data.data;
			}
		}


	}	

})();