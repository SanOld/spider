spi.controller('DashboardController', function ($scope, $rootScope, network, GridService, HintService) {
  $rootScope._m = 'dashboard';

  HintService('dashboard', function (result) {
    $scope._hint = result;
  });

});
