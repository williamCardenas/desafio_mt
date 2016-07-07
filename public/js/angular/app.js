var portifolioApp = angular.module('portifolioApp', []);

portifolioApp.controller('portifolioController', function BannerListController($scope) {
	$scope.banners = [
		{
			name: 'Nexus S',
			image: 'img/banner1.png'
		},{
			name: 'Nexus S',
			image: 'img/banner1.png'
		},{
			name: 'Nexus S',
			image: 'img/banner1.png'
		}
	];
});
