spi.controller('SummaryController', function($scope, $rootScope, network, GridService, localStorageService, $uibModal, Utils, SweetAlert, $timeout) {
    $rootScope._m = 'financial_request';
    var d = new Date;
    $scope.defaulFilter = {year: d.getFullYear()};
    $scope.years = [];
    $scope.filter = localStorageService.get('requestsFilter', $scope.filter ) || angular.copy($scope.defaulFilter);
    if(!$scope.filter == $scope.defaulFilter ){
      localStorageService.set('requestsFilter', $scope.filter );
    };
    if(network.user.type == 't' && network.user.is_finansist == 0){
      window.location = '/';
    };
    $rootScope.printed = 0;
    $scope.user = network.user;
    
    var grid = GridService();
    $scope.tableParams = grid('summary', $scope.filter);
    
    $scope.updateGrid = function() {      
      $scope.setFilter();
      grid.reload();
    };
    
    $scope.resetFilter = function () {
      $scope.filter = angular.copy($scope.defaulFilter);
      $scope.setFilter();
      grid.resetFilter($scope.filter);
    };
    
    network.get('performer', {}, function (result, response) {
      if(result) {
        $scope.performers = response.result;
      };
    });
    
    network.get('school_type', {}, function (result, response) {
      if (result) {
        $scope.schoolTypes = response.result;
      }
    });
    
    network.get('project_type', {}, function (result, response) {
      if(result) {
        $scope.projectTypes = response.result;
      };
    });
    
    //TODO - need to be changed
    network.get('request', {list: 'year'}, function (result, response) {
      if (result) {
        $scope.years = response.result;
        if($scope.years.length > 0){
          $scope.defaulFilter = {year: $scope.years[0], status_id: '1,3,4,5'};

          if($scope.years.indexOf($scope.filter.year) == -1){
             $scope.filter.year = $scope.years[0];
             $scope.setFilter();
             grid.reload();
          }
        }
      }
    });
    
    
    
    
    

});
