spi.controller('RequestController', function ($scope, $rootScope, network, Utils) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  var requestId = Utils.getIdByPath();
  console.log(requestId);
});




