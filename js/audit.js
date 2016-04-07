spi.controller('AuditController', function ($scope, $rootScope, network, GridService, HintService) {
  $rootScope._m = 'audit';
  $scope.filter = {};
  $scope.customData = [];
  $scope.types = [{'code': 'INS', 'name': 'Added'},
                  {'code': 'UPD', 'name': 'Changed'},
                  {'code': 'DEL', 'name': 'Deleted'}];
  var grid = GridService();
  $scope.tableParams = grid('audit', $scope.filter, {group: "id", sorting: {event_date: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
  };

//  $scope.updateGrid = function () {
////    $scope.filter['limit'] = params.count();
////    $scope.filter['page'] = params.page();
//    $scope.filter['order'] = 'event_date';
//    var params = angular.copy($scope.filter);
//    try {
//      params['event_date'] =  params['date'].ymd();
//    } catch(e){}
//    delete params['date'];
//    network.get('audit', params, function (result, response) {
//      if (result) {
//        $scope.customData = response;
//      }
//    });
//    network.get('AuditTables', {}, function (result, response) {
//      if (result) {
//        $scope.tables = response.result;
//      }
//    });
//  };

  HintService('audit', function (result) {
    $scope._hint = result;
  });

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };
  
//  $scope.updateGrid();
  
});
