spi.controller('RequestController', function ($scope, $rootScope, network, GridService, Utils, SweetAlert, $uibModal) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  var d = new Date;
  $scope.filter = {year: d.getFullYear()};

  $scope.financeTypes = Utils.getFinanceTypes();
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
      $scope.status_finance='r';
    }
  });

  var grid = GridService();
  $scope.tableParams = grid('request', $scope.filter);

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };

  $scope.updateGrid = function () {
    grid.reload();
  };

  $scope.existsSelected = function() {
    return !!getSelectedIds().length;
  };

  function getSelectedIds() {
    var ids = [];
    for(var k in $scope.checkboxes.items) {
      if($scope.checkboxes.items[k]) {
        ids.push(k);
      }
    }
    return ids;
  }

  $scope.setBulkDuration = function() {
    var ids = getSelectedIds();
    if (ids.length) {
      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: 'setDuration.html',
        controller: 'ModalDurationController',
        size: 'custom-width-request-duration',
        resolve: {
          ids: function () {
            return ids;
          }
        }
      });

      modalInstance.result.then(function (data) {
        network.patch('request', {ids: ids, start_date: Utils.getSqlDate(data.start_date), due_date: Utils.getSqlDate(data.due_date)}, function(result) {
          if(result) {
            grid.reload();
          }
        });
      });


    }
  };

  $scope.setBulkStatus = function(statusId) {
    var ids = getSelectedIds();
    if(ids.length) {
      SweetAlert.swal({
        title: "Bulk update rows",
        text: "Do you want really update "+ids.length+" rows?",
        type: "warning",
        confirmButtonText: "Yes",
        showCancelButton: true,
        cancelButtonText: "No",
        closeOnConfirm: true
      }, function(isConfirm){
        if(isConfirm) {
          network.patch('request', {ids: ids, status_id: statusId}, function(result) {
            if(result) {
              grid.reload();
            }
          });
        }
      });
    }



  };

  $scope.addRequest = function() {
    var ids = [1];
    if (ids.length) {
      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: 'setRequest.html',
        controller: 'ModalRequestAddController',
        size: 'custom-width-request-duration',
        resolve: {
          ids: function () {
            return ids;
          }
        }
      });

      modalInstance.result.then(function (data) {
        network.post('request', { project_id: data.id
                                , performer_id: data.performer_id
                                , year: data.year}
                                , function(result, response) {
                                    if(result) {
                                      console.log(response.id);
                                      window.location = ' /request/' + response.id;
                                    }
                                  }
                                );
      });

    }
  };



});


spi.controller('ModalDurationController', function ($scope, ids, $uibModalInstance) {
  $scope.countElements = ids.length;

  $scope.dateOptions = {
    startingDay: 1,
    showButtonBar: 0,
    showWeeks: 0
  };


  $scope.ok = function () {
    $uibModalInstance.close($scope.form);
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});



spi.controller('ModalRequestAddController', function ($scope, $uibModalInstance, network) {

  $scope.year = new Date();
  $scope.selectedYear = $scope.year.getFullYear();

  $scope.dateOptions = {
    datepickerMode: 'year',
    minMode: 'year',
    yearRows: 1,
    yearColumns: 3,
    dateFormat: 'yy'
    //    maxDate: (Default: null) - Defines the maximum available date. Requires a Javascript Date object.
    //    minDate:  (Default: null) - Defines the minimum available date. Requires a Javascript Date object.
  };

  $scope.getProjects = function() {
    $scope.selectedYear = $scope.year.getFullYear();
    network.get('project', {list: 'unused_project', year: $scope.selectedYear}, function (result, response) {
      if (result) {
        $scope.projects = response.result;
        if($scope.projects.length > 0){
          $scope.projects.selected_project = $scope.projects[0].id;
        }
      }
    });
  };

  $scope.getProjects();

  $scope.ok = function () {

    for (var item  in $scope.projects) {
      if ($scope.projects[item].id == $scope.projects.selected_project){
        $scope.projects[item].year = $scope.selectedYear;
        var data = $scope.projects[item] ;
      }
    }

    $uibModalInstance.close(data);
    $uibModalInstance.dismiss('cancel');

  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});
