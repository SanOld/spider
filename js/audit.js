spi.controller('AuditController', function ($scope, $rootScope, network, GridService) {
  $rootScope._m = 'audit';
  $scope.filter = {};
  $scope.customData = [];
  $scope.types = [{'code': 'INS', 'name': 'Hinzugefügt'},
                  {'code': 'UPD', 'name': 'Bearbeitet'},
                  {'code': 'DEL', 'name': 'Gelöscht'}];
  var grid = GridService();
  
  $scope.dateFormat = function(date){    
    var day = date.getDate();
    if(day < 10){
      day = "0" + day;
    };
    var month = date.getMonth() + 1;
    if(month < 10){
      month = "0" + month;
    };
    var year = date.getFullYear(); 
    $scope.filter.event_date = year + '-' + month + '-' + day;
  };
  
  
  network.get('request', {list: 'year'}, function (result, response) {
    if (result) {
      $scope.years = response.result;
//      if($scope.years.length > 0){
//        $scope.defaulFilter = {year: $scope.years[0], status_id: '1,3,4,5'};
        
//        if($scope.years.indexOf($scope.filter.year) == -1){
//           $scope.filter.year = $scope.years[0];
////           $scope.setFilter();
////           grid.reload();
//        }
//      }
    }
  });
  
  $scope.tableParams = grid('audit', $scope.filter, {group: "id", sorting: {event_date: 'desc'}});

  $scope.updateGrid = function () {
    //$scope.year.getFullYear()
    grid.reload();
  };
  
  network.get('page', {'order':'name'}, function (result, response) {
      if(result) {
        var key = -1;
        $.each(response.result, function(k,val){
          if(val.name == 'Audit') {
            key = k;
            return false;
          }
        });
        
        if(result != -1) {
          response.result.splice(key,1)
        }
        $scope.tables = response.result;
      }
  });
  
  $scope.yearOptions = {
    datepickerMode: 'year',
    minMode: 'year',
    yearRows: 1,
    yearColumns: 5,
//    minDate:  new Date()//(Default: null) - Defines the minimum available date. Requires a Javascript Date object.
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
  

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };
  
//  $scope.updateGrid();
  
});
