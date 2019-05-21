(function () {

	'use strict';

	angular
		.module('app.home')
		.controller('Home', Home);

	Home.$inject = ['controllerUtils', 'AuthToken', '$rootScope', 'jwtHelper'];

	function Home(controllerUtils, AuthToken, $rootScope, jwtHelper) {
		var vm = this;
	}

})();