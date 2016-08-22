spi.controller('DashboardController', function ($scope, $rootScope, network) {
  $rootScope._m = 'dashboard';
  $scope.user = network.user;
});