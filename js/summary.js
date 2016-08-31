spi.controller('SummaryController', function($scope, $rootScope, network, GridService, localStorageService, $uibModal, Utils, SweetAlert, $timeout) {
    $rootScope._m = 'financial_request';
    var d = new Date;
    $scope.defaulFilter = {};
    $scope.years = [];
    $scope.filter = localStorageService.get('summaryFilter', $scope.filter ) || angular.copy($scope.defaulFilter);
    if(!$scope.filter == $scope.defaulFilter ){
      localStorageService.set('summaryFilter', $scope.filter );
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
    
    $scope.setFilter = function(){
       localStorageService.set('summaryFilter', $scope.filter );
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
    network.get('summary', {list: 'year'}, function (result, response) {
      if (result) {
        $scope.years = response.result;
      };
    });
    
    $scope.link = function(link, row){
      var filter = {
        project_id: row.project_id,
        year: row.year
      };
      localStorageService.set('finRequestsFilter', filter);
      window.location = '/' + link;
    };

});
