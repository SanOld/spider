spi.controller('RequestController', function ($scope, $rootScope, network, GridService, Utils, SweetAlert, $uibModal, configs, localStorageService) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  $rootScope.printed = 0;
  var d = new Date;
  $scope.defaulFilter = {year: d.getFullYear(), status_id: '1,3,4,5'}
  $scope.filter = localStorageService.get('requestsFilter', $scope.filter ) || angular.copy($scope.defaulFilter);
  if(!$scope.filter == $scope.defaulFilter ){
    localStorageService.set('requestsFilter', $scope.filter );
  }
  $scope.filter.statuses = '';
  $scope.userType = network.user.type;
  $scope.checks = {
    'unfinished'  : {'finance':true,'concept':true,'goal':true},
    'in_progress' : {'finance':true,'concept':true,'goal':true},
    'accepted'    : {'finance':true,'concept':true,'goal':true},
    'rejected'    : {'finance':true,'concept':true,'goal':true}
  };
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
  $scope.allSelect = function(satus){
    angular.forEach($scope.checks, function (item, i, arr) {
      angular.forEach(item, function (item2, i2, arr2) {
        $scope.checks[i][i2] = satus;
      });
    });
    delete $scope.filter.statuses;
    grid.reload();
  };
  
  $scope.part_statuses = ['unfinished', 'in_progress', 'accepted', 'rejected'];
  
  $scope.deleteStatus = function(type, value){
    if(!$scope.filter.statuses){
      $scope.filter.statuses = '';
    };
    if(value){
      $scope.filter.statuses += type + ',';
    }else{
      var statuses = $scope.filter.statuses.split(',');
      for(var i = 0; i < statuses.length; i++){
        if(statuses[i] == type){
          statuses.splice(i, 1);
          break;
        };
      };
      statuses.splice((statuses.length - 1), 1);
      if(statuses.length){
        $scope.filter.statuses = statuses.join(',');
        $scope.filter.statuses += ',';
      }else{
        delete $scope.filter.statuses;
      };
    };    
  };

  network.get('performer', {}, function (result, response) {
      if(result) {
          $scope.performers = response.result;
      }
  });

  if(network.user.type == 't'){
    network.get('school', {filter: 1, requests: 1}, function (result, response) {
      if (result) {
        $scope.schools = response.result;
      }
    }); 
  } 
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
  
  network.get('request', {group_codes:1}, function (result, response) {
    if(result) {
      $scope.requests = response.result;
    }
  });

 $scope.getYears = function(){
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
 };
 $scope.getYears();

  network.get('request_status', {}, function (result, response) {
    if (result) {
      $scope.statuses = response.result;
      for(var i = 0; i < $scope.statuses.length; i++){
        if($scope.statuses[i].code == 'in_progress' && $scope.user.type == 't'){
          $scope.statuses[i].name = 'Antrag bearbeiten';
        }else if($scope.statuses[i].code == 'acceptable' && ($scope.user.type == 'p' || $scope.user.type == 'a')){
          $scope.statuses[i].name = 'Antrag förderfähig';
        }else if($scope.statuses[i].code == 'acceptable' && $scope.user.type == 't'){
          $scope.statuses[i].name = 'Förderfähig – Antrag drucken';
        }else if($scope.statuses[i].code == 'accept' && $scope.user.type == 't'){
          $scope.statuses[i].name = 'Genehmigt – Fördervertrag drucken';
        }else if($scope.statuses[i].code == 'wait' && ($scope.user.type == 'p' || $scope.user.type == 'a')){
          $scope.statuses[i].name = 'Zur Korrektur übermittelt';
        };
      };
      $scope.statuses.push($scope.statuses[2]);  //change order of icons to not to do changes to all pages
      delete $scope.statuses[2];
      if($scope.userType == 's' || $scope.userType == 'd' || $scope.userType == 'g'){
        delete $scope.statuses[3];
      };
      $scope.status_finance = 'r';
    }
  });

  var grid = GridService();
  $scope.tableParams = grid('request', $scope.filter);

  $scope.paramsForExport = {
    fileName: 'Antragsliste.csv',      
    model: 'request',
    tables: {
      table1: {
        columns: {
          'code'           : 'Kennziffer',
          'performer_name' : 'Träger',
          'schools'        : 'Schule(n)',
          'programm'       : 'Programm',
          'year'           : 'Jahr',
          'status_name'    : 'Status',
          'end_fill'       : 'Abgabe',
          'last_change'    : 'Lezte Äaderung',
          'status_finance' : 'Finanzplan Status',
          'status_concept' : 'Konzept Status',
          'status_goal'    : 'Entwicklungszielen Status'
        },
        schools: 'name'
      }
    },
    param: $scope.filter,
  };
  
  $scope.resetFilter = function () {
    $scope.filter = angular.copy($scope.defaulFilter);
    $scope.setFilter();
    grid.resetFilter($scope.filter);
  };

  $scope.updateGrid = function () {
    $scope.setFilter();
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
      if($scope.checkboxes.items[k] && Utils.getRowById($scope.tableParams.data, k)) {
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
          text: "Anfragen "+failCodes.join(', ')+" können nicht aktualisiert sein",
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
        var sendData = {};
        var flag = false;
        sendData.ids = ids;

        if(data.start_date){
          sendData.start_date = Utils.getSqlDate(data.start_date);
          flag = true;
        }
        if(data.due_date){
          sendData.due_date = Utils.getSqlDate(data.due_date);
          flag = true;
        }
        if(data.end_fill){
          sendData.end_fill = Utils.getSqlDate(data.end_fill);
          flag = true;
        }
        
        if(flag){
          network.patch('request', sendData, function(result) {
            if(result) {
              grid.reload();
            }
          });
        } else {
          SweetAlert.swal({
            title: "Fehler",
            text: "Sie müssen mindestens ein Feld auswählen",
            type: "error",
            confirmButtonText: "OK"
          });
        }
      });


    }
  };

  $scope.copyRequest = function() {
    var ids = getSelectedIds();
    if (ids.length) {
      

    var selectedCodes = [];
    var selectedProjectIds = [];
    var objSelectedCodes = {};
      for(var i=0; i<ids.length; i++) {
        var row = Utils.getRowById($scope.tableParams.data, ids[i]);
        selectedCodes.push(row.code);
        selectedProjectIds.push(row.project_id);

        objSelectedCodes[row.code] = [];
        objSelectedCodes[row.code]['code'] = row.code;
        objSelectedCodes[row.code]['id'] = row.id;
      }

      var modalInstance = $uibModal.open({
        animation: true,
        templateUrl: 'copyRequest.html',
        controller: 'ModalCopyRequestController',
        size: 'custom-width-request-duration',
        resolve: {
          ids: function () {
            return ids;
          },
          year: function () {
            return row.year;
          },
          selectedCodes: function () {
            return selectedCodes;
          }
        }
      });

      modalInstance.result.then(function (data) {

        //TO DO - проверка на существование проекта

        network.get('request', {project_ids: selectedProjectIds.join(','), year: data.year, project_is_old: '1'}, function(result, response) {
          if(result && response.result.length > 0) {
            var failCodes = [];
            var objFailCodes = {};

            for(var row in response.result){
              var code  = response.result[row]['code'];
              var id  = response.result[row]['id'];

              failCodes.push(code);
              objFailCodes[code] = [];
              objFailCodes[code]['code'] = code;
              objFailCodes[code]['id'] = id;
            }
            var text = {plural : [], singular: []};
            text['plural'][1] = 'Anträge';
            text['plural'][2] = 'können nicht eröffnen sein.';
            text['plural'][3] = 'werden hinzufügen.';

            text['singular'][1] = 'Antrag';
            text['singular'][2] = 'kann nicht eröffnen sein. Antrag für dieses Projekt schon existiert.';
            text['singular'][3] = 'wird hinzufügen.';

            if (failCodes.length == 1){
              var text_cancel = text['singular'];
            } else {
              var text_cancel = text['plural'];
            }


            if(failCodes.length == selectedCodes.length){
              SweetAlert.swal({
                title: "Fehler",
                text: text_cancel[1] + " "+failCodes.join(', ')+" " +  text_cancel[2],
                type: "warning",
                confirmButtonText: "OK"
              });
            } else {
              var diffCodes = [];
              var newIds = [];
              diffCodes = selectedCodes.filter(function(item, i, arr){
                if (objFailCodes[item]){
                  return false;
                }
                newIds.push(objSelectedCodes[item]['id']);
                return true;
              })

              if (diffCodes.length == 1){
                var text_ok = text['singular'];
              } else {
                var text_ok = text['plural'];
              }

              SweetAlert.swal({
                title: "Fehler",
                text: text_cancel[1] + " " + failCodes.join(', ') + " " +  text_cancel[2]
                     +"\n"
                     +text_ok[1] + " " + diffCodes.join(', ') + " " +  text_ok[3],
                type: "warning",
                showConfirmButton: true,
                confirmButtonText: "Speichern",
                showCancelButton: true,
                cancelButtonText: "Abbrechen",
                closeOnConfirm: true,
                closeOnCancel: true
              },
              function(isConfirm){
                if (isConfirm) {
                  network.post('request', {ids: newIds, copy: true, year: data.year}, function(result) {
                    if(result) {
                      grid.reload();
                    }
                  });
                }
              });
            }
          } else {
            network.post('request', {ids: ids, copy: true, year: data.year}, function(result) {
              if(result) {
                $scope.getYears();
                grid.reload();
              }
            });
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
          title: "Hinweis",
          text: "Die Anfrage für "+failCodes.join(', ')+" kann nicht durchgeführt werden.\n\
          Förderfähige und genehmigte Anträge können nicht verändert werden.",
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
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: 'printDocuments.html',
      controller: 'ModalPrintDocumentsController',
      size: 'custom-width',
      resolve: {
        row: function () {
          return row;
        },
        userCan: function () {
          return $scope.userCan('btnPrintDocument', row.status_code );
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

  $scope.setBulkStatus = function(statusId) {
  var required = [
              'doc_target_agreement_id',
              'doc_request_id',
              'doc_financing_agreement_id',
              'finance_user_id',
              'concept_user_id',
              'start_date',
              'due_date'
            ];


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

        for(var field in required){
          if(row[required[field]] == '' || row[required[field]] == '0' || row[required[field]] == undefined ){
            failCodes.push(row.code);
            break;
          }
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
                                      $scope.setFilter();
                                      window.location = ' /request/' + response.id;
                                    }
                                  }
                                );
      });

    }
  };

  $scope.setFilter = function(){
     localStorageService.set('requestsFilter', $scope.filter );
  }

  $scope.permissions={
                      btnPrintDocument: {
                                          open:         {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                          in_progress:  {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                          decline:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                          acceptable:   {'a' : 1, 'p' : 1, 't': 1, 'default': 0 },
                                          accept:       {'a' : 1, 'p' : 1, 't': 1, 'default': 0 },
                                          default:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 }
                                        },
                              default:  {
                                          open:         {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                          in_progress:  {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                          decline:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                          acceptable:   {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                          accept:       {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                          default:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 }
                                        }
                      }

  $scope.userCan = function( field, status_code ){
    var status = status_code  || 'default';
    var userType='';
    switch($scope.userType){
      case 'a':;
      case 'p':;
      case 't':
        userType = $scope.userType;
        break;
      default:
        userType = 'default';
    }

    
    if(!(field in $scope.permissions)){
      field = 'default';
    }

    var result = $scope.permissions[field][status][userType];
    return result;

  }

  $scope.getDate = function (date) {
    var result = '';
    if(date){
      result = new Date(date);
    }
    return result;
  }

    window.onfocus = function() {
    if (localStorageService.get('dataChanged') === '1'){
      grid.reload();
      localStorageService.set('dataChanged', 0);
    }
  }
  
  $scope.export = function() {
    var ids = getSelectedIds();
      $uibModal.open({
        animation: true,
        templateUrl: 'exportData.html',
        controller: 'ExportDataController',
        size: 'custom-width-request-send-duration',
        resolve: {
          ids: function () {
            return ids;
          }
        }
      });
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

spi.controller('ModalCopyRequestController', function ($scope, ids, year,  selectedCodes, $uibModalInstance) {
  var d = new Date();
  $scope.year = new Date(d.setFullYear(+year + 1));
  $scope.countElements = ids.length;
  if (selectedCodes.length > 0) {
    $scope.selectedElements = selectedCodes.join(', ');
  }
  

  $scope.dateOptions = {
    datepickerMode: 'year',
    minMode: 'year',
    yearRows: 1,
    yearColumns: 5,
    minDate:  new Date()//(Default: null) - Defines the minimum available date. Requires a Javascript Date object.
  };

  $scope.fieldError = function(field) {
      var form = $scope.copyRequest;
      return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
  };

  $scope.ok = function () {
    $scope.copyRequest.$setPristine();
    if ($scope.copyRequest.$valid) {

      $uibModalInstance.close({year:  $scope.year.getFullYear()});
      $uibModalInstance.dismiss('cancel');
    }
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});

spi.controller('ModalPrintDocumentsController', function ($scope,user, row,  userCan, $uibModalInstance, network) {
  $scope.row = row;
  $scope.userCan = userCan;
  $scope.code = row.code;
  $scope.user = user;
  var ids = [];
  var docs = [row.doc_target_agreement_id, row.doc_request_id, row.doc_financing_agreement_id];
  for(var i=0; i<docs.length; i++) {
    if(docs[i]) ids.push(docs[i])
  }

  if(ids.length) {
    network.get('document_template', {'ids[]': ids, 'prepare': 1, 'request_id': row.id }, function (result, response) {
      if (result) {
        $scope.templates = response.result;
      }
    });
  }

  $scope.printDoc = function(template){
//    console.log(template.text);
    $uibModalInstance.close(template,  $scope.printed);
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

  $scope.search = function(value, year){
    if(year == 'year'){      
      $scope.request.project_id = '';
      $scope.projects = '';
    }       
    if(value.length >= 2){
      $scope.getProjects(value);  
    }else{
      $scope.projects = '';
    }
  } 
  
  $scope.getProjects = function(value) {
    $scope.request.year = $scope.year.getFullYear();
    if($scope.request.year) {
      network.get('project', {list: 'unused_project', year: $scope.request.year, value: value}, function (result, response) {
        if (result) {
          $scope.request.project_id = '';
          $scope.projects = response.result;          
        }
      });
    }
  };


  $scope.fieldError = function(field) {
      var form = $scope.createRequest;
      return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
  };

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

spi.controller('ExportDataController', function ($scope, $timeout, network, $uibModalInstance, $sce, $rootScope, ids, localStorageService, SweetAlert) {
  $scope.filter = localStorageService.get('requestsFilter', $scope.filter );  
  $scope.checkbox = {
    'projectData'   : false,
    'financeSingle' : false,
    'financeSumm'   : false
  };
  
  $scope.checkCheckbox = function(){
    $scope.count = 0;
    for(var box in $scope.checkbox){
      if($scope.checkbox[box]){
        $scope.count++;
      };
    };
    if($scope.count > 1){
      SweetAlert.swal({
        html:true,
        title: "",
        text: "Wählen Sie bitte ein Datei.",
        type: "warning",
        confirmButtonText: "OK"
      });
    };
    if($scope.checkbox.financeSingle){
      if(!ids.length){
        SweetAlert.swal({
          html:true,
          title: "",
          text: "Wählen Sie bitte ein Antrag um Financeplan(einzeln) zu exportiren.",
          type: "warning",
          confirmButtonText: "OK"
        },function(isConfirm){
           if(isConfirm){         
              $scope.checkbox.financeSingle = false;
           };
        });
      }
      if(ids.length > 1){
        SweetAlert.swal({
          html:true,
          title: "",
          text: "Wählen Sie bitte nur ein Antrag um Financeplan(einzeln) zu exportiren.",
          type: "warning",
          confirmButtonText: "OK"
        },function(isConfirm){
           if(isConfirm){         
              $scope.checkbox.financeSingle = false;
           }
        });
      }
    }
    
  };
  $scope.checkCheckbox();
  
  $scope.paramsForExport = {};
  
  delete $scope.filter.limit;
   
  $scope.correctDatas = function(data){
    //count schools
    for(var i in data){
      var schools = 0;
      for(var k in data[i].schools){
        schools += 1;
      };
      data[i].schools = schools;
    };
    for(var i in data){
      //count data
      var duration = 0;
      if(data[i].start_date && data[i].due_date){
        var month_start = data[i].start_date.substring(5,7);
        var month_end = data[i].due_date.substring(5,7);
        duration = Number(month_end) - Number(month_start);
      };
      data[i].duration = duration;      
      //count material costs
      var material_costs = 0;
      material_costs = Number(data[i].training_cost) + Number(data[i].overhead_cost) + Number(data[i].prof_association_cost);
      data[i].material_costs = material_costs;
    };
    //count rate
    network.get('request_school_finance', {}, function (result, response) {
      if(result){
        for(var p in data){          
          var rate_count = 0;
          for(var f in response.result){            
            if(response.result[f].request_id == data[p].id){
              rate_count += Number(response.result[f].rate);
            };
          };
          data[p].rate_count = rate_count;
        };
        network.get('project', {}, function (result, response) {
          if(result){
            for(var p in data){
              for(var f in response.result){
                if(response.result[f].id == data[p].project_id){              
                  data[p].project_type = response.result[f].type_name;
                };
              };
            };
            $scope.paramsForExport['financeSumm'] = {
              fileName: 'Financeplan(Summen).csv',
              model: 'request',
              tables: {
                table1: {
                  columns: {
                    'code'           : 'Projekt-Kennziffer',
                    'performer_name' : 'Trägername',
                    'project_type'   : 'Fördertopf',
                    'duration'       : 'Monate',
                    'schools'        : 'Anzahl Schulen',
                    'rate_count'     : 'Stellenanteil',
                    'total_cost'     : 'Fördersumme',
                    'emoloyees_cost' : 'Personalkosten',
                    'material_cost'  : 'Ausgaben: Sachkosten',
                    'training_cost'  : 'Fortbildung',
                    'overhead_cost'  : 'Regiekosten',
                    'prof_association_cost': 'Berufsgenossenschaft',
                    'revenue_sum'    : 'Einnahmen',
                  },
                  data: data
                }
              },
              param: $scope.filter,
              data: data
            };
          };
        });
      };
    });    
  };
  
  network.get('request', $scope.filter, function (result, response) {
    if(result){
      $scope.correctDatas(response.result);
    };
  });
  
  $scope.exportFinanceSingle = function(request_id){
    var data = [];
    network.get('request', {id:request_id}, function (result, response) {
      if(result){
        data[0] = response.result;
        data[0].is_umlage = response.result.is_umlage == 1 ? 'ja' : 'nein';
        data[0].duration  = response.result.start_date + " - " + response.result.due_date;
        network.get('request_user', {request_id: request_id}, function (result, response) {
          if(result){
            data.users = response.result;
            network.get('request_user', {request_id: request_id}, function (result, response) {
              if(result){
                data.users = response.result;
                network.get('request_school_finance', {request_id: request_id}, function (result, response) {
                  if(result){
                    data.schools = [];
                    var counter = 0;
                    for(var school in response.result){
                      data.schools[counter] = response.result[school];
                      data.schools[counter].count = '1';
                      counter++;
                    };
                    $scope.paramsForExport['financeSingle'] = {
                      fileName: 'Financeplan(einzeln).csv',
                      model: 'request',
                      tables: {
                        table1: {
                          columns: {
                            'code'              : 'Kennziffer',
                            'performer_name'    : 'Träger',
                            'duration'          : 'Förderzeitraum',
                            'is_umlage'         : 'Umlage 1',
                            'null-1'            : '',
                            'total_cost'        : 'Summe Fördervertrag',
                            'revenue_cost'      : 'Summe sonstige Einnahmen',
                            'null-2'            : '',
                            'null-3'            : '',
                            'null-4'            : '',
                            'null-5'            : ''
                          },
                          data: data
                        },
                        table2:{
                          columns: {
                            'sex'               : 'Anrede',
                            'name'              : 'Name',
                            'group_name'        : 'Entgeltgruppe',
                            'remuneration_name' : 'Entgeltstufe',
                            'month_count'       : 'Geplante Monate im Projekt',
                            'other'             : 'sonstige Information',
                            'hours_per_week'    : 'Arbeitsstunden / Woche',
                            'null'              : 'Summe Ausgaben',
                            'brutto'            : 'AN-Brutto',
                            'add_cost'          : 'AG-SV und Umlagen',
                            'full_cost'         : 'Personalkosten'
                          },
                          data: data.users
                        },
                        table3:{
                          columns: {
                            'school_name'   : 'Schule',
                            'rate'          : 'Stellenanteil',
                            'month_count'   : 'Monate',
                            'count'         : 'Anzahl Schulen',
                            'overhead_cost' : 'Regiekosten',
                            'training_cost' : 'Fortbildungskosten',
                            'null'          : 'BG-Beitrag',
                            'null-1'        : '',
                            'null-2'        : '',
                            'null-3'        : '',
                            'null-4'        : ''
                          },
                          data: data.schools
                        },
                      },                      
                      param: $scope.filter,
                    };
                  };
                });
              };
            });
          };
        });
      };
    });
  };
  
  $timeout(function(){
    $scope.exportFinanceSingle(ids[0]);
  });

  $scope.cancel = function () {
    $uibModalInstance.close();
  };

});