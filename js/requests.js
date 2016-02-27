spi.controller('RequestController', function ($scope, $rootScope, network, GridService, HintService) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  var d = new Date;
  $scope.filter = {year: d.getFullYear()};

  $scope.financeTypes = [{id: 'l', name: 'LM'}, {id: 'b', name: 'BP'}];
  $scope.checkboxes = {
    checked: false,
    items: {}
  };

  $scope.headerChecked = function (value) {
    angular.forEach($scope.tableParams.data, function (item) {
      $scope.checkboxes.items[item.id] = value;
    });
  };

  network.get('performer', {filter: 1}, function (result, response) {
    if (result) {
      $scope.performers = response.result;
    }
  });

  network.get('finance_source', {}, function (result, response) {
    if (result) {
      $scope.programs = response.result;
    }
  });

  network.get('request', {list: 'year'}, function (result, response) {
    if (result) {
      $scope.years = response.result;
    }
  });

  network.get('request_status', {}, function (result, response) {
    if (result) {
      $scope.statuses = response.result;
    }
  });

  HintService('request', function (result) {
    $scope._hint = result;
  });

  var grid = GridService();
  $scope.tableParams = grid('request', $scope.filter);

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };

  $scope.updateGrid = function () {
    grid.reload();
  };

});


