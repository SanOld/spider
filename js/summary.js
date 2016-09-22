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
    
    $scope.paramsForExport = {
      fileName: 'Finanzübersichtliste.csv',
      model: 'summary',
      tables: {
        table1: {
          columns: {
            'project_code'   : 'Kennziffer',
            'performer_name' : 'Träger',
            'schools'        : 'Schule(n)',
            'programm'       : 'Topf',
            'year'           : 'Jahr',
            'total_cost'     : 'Fördersumme',
            'changes'        : 'Änderung',
            'actual'         : 'aktuelle Fördersumme',
            'payed'          : 'Ausgezahlt',
            'null'           : 'F-Berichte',
            'remained'       : 'Verblieben'
          },
          schools: 'name'
        }
      },
      param: $scope.filter,
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
      var filter_name = link == 'financial-request' ? 'finRequestsFilter' : 'finReportFilter';
      var filter = {
        project_id: row.project_id,
        year: row.year
      };
      localStorageService.set(filter_name, filter);
      window.location = '/' + link;
    };
    
    $scope.printDocuments = function(row) {
      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: 'printSummaryDocuments.html',
        controller: 'SummaryPrintDocumentsController',
        size: 'custom-width',
        resolve: {
          row: function () {
            return row;
          },
          user: function () {
            return $scope.user;
          }
        }
      });
      modalInstance.result.then(function (template) {
       $uibModal.open({
          animation: true,
          templateUrl: 'showTemplate.html',
          controller: 'ShowDocumentTemplatesController',
          size: 'width-full',
          resolve: {
            data: function () {
              return template;
            },
            row: function () {
              return row;
            }
          }
        });
      });
    };

});

spi.controller('SummaryPrintDocumentsController', function ($scope,user, row, $uibModalInstance, network) {
  $scope.row = row;
  $scope.code = row.code;
  $scope.user = user;
  var ids = []
  network.get('document_template_type', {code:'spending_report'}, function (result, response) {
    if (result) {
      var type_id = response.result[0].id;
      console.log(type_id );
      network.get('document_template', {type_id:type_id}, function (result, response) {
        if (result) {
          for(var i = 0; i < response.result.length;i++ ) {
            ids.push(response.result[i].id)
          }
          if(ids.length) {
            network.get('document_template', {'ids[]': ids, 'prepare': 1, 'request_id': row.request_id }, function (result, response) {
              if (result) {
                $scope.templates = response.result;
                console.log($scope.templates);
              };
            });
          }
        }
      });
    }
  });

  $scope.printDoc = function(template){
    $uibModalInstance.close(template,  $scope.printed);
  }

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});

spi.controller('ShowDocumentTemplatesController', function ($scope, $timeout, $uibModalInstance, data, $sce, $rootScope) {
  $scope.isInsert = !data.id;

  $scope.filter = {};

  $scope.trustAsHtml = function(string) {
    return $sce.trustAsHtml(string);
  };

  if (!$scope.isInsert) {
    $scope.document = {
      text: data.text,
      name: data.name
    };
  } else {
    $scope.document = {
      text: ''
    };
  }
  
  $scope.print = function(){
    $rootScope.printed = 1;
    $timeout(function() {
      window.print();
      $rootScope.printed = 0;
    });
  };

  $scope.cancel = function () {
    $uibModalInstance.close($scope.request);
  };

  $rootScope.printed = 1;
  $timeout(function() {
      window.print();
      $rootScope.printed = 0;
  });

});
