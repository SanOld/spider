spi.controller('RequestController', function ($scope, $rootScope, network, Utils, $location) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  $scope.requestID = Utils.getIdByPath();

  var hash = $location.hash();
  if(hash && ['project-data', 'finance-plan', 'school-concepts', 'schools-goals'].indexOf(hash) !== -1) {
    $scope.tabActive = $location.hash();
  }
  $scope.setTab = function(name) {
    $location.hash(name);
  };

});

spi.controller('RequestProjectDataController', function ($scope, network) {
  //$scope.$parent.requestID
});

spi.controller('RequestFinancePlanController', function ($scope, network) {
  //$scope.$parent.requestID
});

spi.controller('RequestSchoolConceptController', function ($scope, network) {
  //$scope.$parent.requestID
});

spi.controller('RequestSchoolGoalController', function ($scope, network) {
  //$scope.$parent.requestID
});



