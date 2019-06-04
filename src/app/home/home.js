(function () {

	'use strict';

	angular
		.module('app.home')
		.controller('Home', Home);

	Home.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', '$http'];

	function Home(controllerUtils, AuthToken, $rootScope, jwtHelper, $http) {
		var vm = this;

		// var teste = { 
		// 		dataParcela: "28/05/2019",
		// 		paga: 2,
		// 		pendente: 5
		// 	};

		// $http.post('http://localhost/jenti/imprimir-recibo-parcela.php', teste);

	}	

})();