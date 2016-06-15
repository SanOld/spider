spi.controller('RequestController', function ($scope, $rootScope, network, GridService, Utils, SweetAlert, $uibModal, configs) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  var d = new Date;
  $scope.filter = {year: d.getFullYear(), status_id: '1,3,4,5'};

  $scope.checkboxes = {
    checked: false,
    items: {}
  };
  $scope.isFinansist = ['a', 'p', 'g'].indexOf(network.user.type) !== -1 || (network.user.type == 't' && +network.user.is_finansist);

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

  network.get('school_type', {}, function (result, response) {
    if (result) {
      $scope.schoolTypes = response.result;
    }
  });

  network.get('project_type', {}, function (result, response) {
    if(result) {
      $scope.projectTypes = response.result;
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
      $scope.status_finance = 'r';
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

  $scope.canEdit = function(row) {
    if(!row) {
      return $rootScope.canEdit();
    } else {
      return  (network.user.type == 'a' || (row.status_code != 'decline' && row.status_code != 'accept')) && $rootScope.canEdit();
    }
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
      var failCodes = [];
      for(var i=0; i<ids.length; i++) {
        var row = Utils.getRowById($scope.tableParams.data, ids[i]);
        if(['acceptable', 'accept'].indexOf(row.status_code) !== -1) {
          failCodes.push(row.code)
        }
      }
      if(failCodes.length) {
        SweetAlert.swal({
          title: "Fehler",
          text: "Anfragen "+failCodes.join(', ')+" können nicht aktualisiert dein",
          type: "error",
          confirmButtonText: "OK"
        });
        return false;
      }
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

  $scope.chooseDocuments = function() {
    var ids = getSelectedIds();
    if (ids.length) {
      var failCodes = [];
      for(var i=0; i<ids.length; i++) {
        var row = Utils.getRowById($scope.tableParams.data, ids[i]);
        if(['acceptable', 'accept'].indexOf(row.status_code) !== -1) {
          failCodes.push(row.code)
        }
      }
      if(failCodes.length) {
        SweetAlert.swal({
          title: "Fehler",
          text: "Anfragen "+failCodes.join(', ')+" können nicht aktualisiert dein",
          type: "error",
          confirmButtonText: "OK"
        });
        return false;
      }
      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: 'chooseDocuments.html',
        controller: 'ModalChooseDocumentsController',
        size: 'custom-width',
        resolve: {
          ids: function () {
            return ids;
          }
        }
      });

      modalInstance.result.then(function (form) {
        network.patch('request', angular.extend({ids: ids}, form), function(result) {
          if(result) {
            grid.reload();
          }
        });
      });

    }
  };

  $scope.printDocuments = function(row) {
    $uibModal.open({
      animation: true,
      templateUrl: 'printDocuments.html',
      controller: 'ModalPrintDocumentsController',
      size: 'custom-width',
      resolve: {
        row: function () {
          return row;
        }
      }
    });
  };

  $scope.setBulkStatus = function(statusId) {
    var ids = getSelectedIds();
    if(ids.length) {
      var failCodes = [];
      for(var i=0; i<ids.length; i++) {
        var row = Utils.getRowById($scope.tableParams.data, ids[i]);
        if(statusId == 5 && row.status_id < 4 || statusId < row.status_id) {
          failCodes.push(row.code);
        } else if(row.status_concept != 'accepted' || row.status_finance != 'accepted' || row.status_goal != 'accepted') {
          failCodes.push(row.code);
        }
      }
      if(failCodes.length) {
        SweetAlert.swal({
          title: "Fehler",
          text: "Anfragen "+failCodes.join(', ')+" können nicht aktualisiert dein",
          type: "error",
          confirmButtonText: "OK"
        });
        return false;
      }
      SweetAlert.swal({
        title: "Massenänderung der Anfragen",
        text: "Möchten Sie wirklich eine "+ids.length+" "+ids.length == 1 ? 'Anfrage' : 'Anfragen'+"?",
        type: "warning",
        confirmButtonText: "JA",
        showCancelButton: true,
        cancelButtonText: "NEIN",
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
        templateUrl: 'createRequest.html',
        controller: 'ModalRequestAddController',
        size: 'custom-width-request-duration',
        resolve: {
          ids: function () {
            return ids;
          }
        }
      });

      modalInstance.result.then(function (data) {
        network.post('request', { project_id: data.project_id
                                , year: data.year}
                                , function(result, response) {
                                    if(result) {
                                      window.location = ' /request/' + response.id;
                                    }
                                  }
                                );
      });

    }
  };

});


spi.controller('ModalChooseDocumentsController', function ($scope, ids, $uibModalInstance, network) {
  $scope.countElements = ids.length;
  $scope.form = {};
  $scope.goal_agreements    = [];
  $scope.request_agreements = [];
  $scope.funding_agreements = [];

  network.get('document_template', {type_codes: ['goal_agreement', 'request_agreement', 'funding_agreement']}, function (result, response) {
    if (result) {
      for(var i=0; i<response.result.length; i++) {
        switch(response.result[i].type_code) {
          case 'goal_agreement':
            $scope.goal_agreements.push(response.result[i]);
            break;
          case 'request_agreement':
            $scope.request_agreements.push(response.result[i]);
            break;
          case 'funding_agreement':
            $scope.funding_agreements.push(response.result[i]);
            break;
        }
      }
    }
  });

  $scope.ok = function () {
    $uibModalInstance.close($scope.form);
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
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

spi.controller('ModalPrintDocumentsController', function ($scope, row, $uibModalInstance, network) {
  $scope.code = row.code;

  var ids = [];
  var docs = [row.doc_target_agreement_id, row.doc_request_id, row.doc_financing_agreement_id];
  for(var i=0; i<docs.length; i++) {
    if(docs[i]) ids.push(docs[i])
  }

  if(ids.length) {
    network.get('document_template', {'ids[]': ids}, function (result, response) {
      if (result) {
        $scope.templates = response.result;
      }
    });
  }

  $scope.printDoc = function(template){
    console.log(template.text);
    //$uibModalInstance.close($scope.templates);
    $uibModalInstance.dismiss('cancel');
  }

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});



spi.controller('ModalRequestAddController', function ($scope, $uibModalInstance, network) {
  var d = new Date();
  $scope.year = new Date(d.setFullYear(d.getFullYear() + 1));
  $scope.request = {};
  $scope.dateOptions = {
    datepickerMode: 'year',
    minMode: 'year',
    yearRows: 1,
    yearColumns: 5,
    minDate:  new Date()//(Default: null) - Defines the minimum available date. Requires a Javascript Date object.
  };

  $scope.getProjects = function() {
    $scope.request.year = $scope.year.getFullYear();
    if($scope.request.year) {
      network.get('project', {list: 'unused_project', year: $scope.request.year}, function (result, response) {
        if (result) {
          $scope.projects = response.result;
        }
      });
    }
  };


  $scope.fieldError = function(field) {
      var form = $scope.createRequest;
      return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
  };


  $scope.getProjects();

  $scope.ok = function () {
    $scope.createRequest.$setPristine();
    if ($scope.createRequest.$valid) {
      $uibModalInstance.close($scope.request);
      $uibModalInstance.dismiss('cancel');
    }
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});
