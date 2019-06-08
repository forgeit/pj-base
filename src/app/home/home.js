(function () {

	'use strict';

	angular
		.module('app.home')
		.controller('Home', Home);

	Home.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper', '$http'];

	function Home(controllerUtils, AuthToken, $rootScope, jwtHelper, $http) {
		var vm = this;
	}	

})();