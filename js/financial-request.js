spi.controller('FinancialRequestController', function($scope, $rootScope, network, GridService, localStorageService) {
    $rootScope._m = 'financial_request';
    $scope.filter = {};
    
    var grid = GridService();
    $scope.tableParams = grid('financial_request', $scope.filter);
    
    $scope.updateGrid = function() {
        grid.reload();
    };
    
    $scope.checkboxes = {
      checked: false,
      items: {}
    };
    
    $scope.headerChecked = function (value) {
      angular.forEach($scope.tableParams.data, function (item) {
        $scope.checkboxes.items[item.id] = value;
      });
    };
    
    $scope.getDate = function (date) {
      var result = '';
      if(date != '0000-00-00'){
        result = new Date(date);
      }
      return result;
    }
    
    $scope.setFilter = function(){
       localStorageService.set('requestsFilter', $scope.filter );
    }
  
    $scope.dateFormat = function(date, date_type){    
      var day = date.getDate();
      if(day < 10){
        day = "0" + day;
      };
      var month = date.getMonth() + 1;
      if(month < 10){
        month = "0" + month;
      };
      var year = date.getFullYear();
      if(date_type == 'payment_date'){        
        $scope.filter.payment_date = year + '-' + month + '-' + day;
      }else{
        $scope.filter.receipt_date = year + '-' + month + '-' + day;
      }
    };
    
    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
        delete $scope.project;
    };
    
    network.get('project_type', {}, function (result, response) {
      if(result) {
        $scope.projectTypes = response.result;
      }
    });
    
    network.get('financial_request', {list: 'project'}, function (result, response) {
      if(result) {
        $scope.projects = response.result;
      }
    });
    
    network.get('financial_request', {list: 'year'}, function (result, response) {
      if(result) {
        $scope.years = response.result;   
        var d = new Date;    
        $scope.filter.year = d.getFullYear();
        if($scope.years.indexOf($scope.filter.year) == -1){
           $scope.filter.year = $scope.years[0].year;
           $scope.setFilter();
           grid.reload();
        }
      }
    });
    
    network.get('payment_type', {}, function (result, response) {
      if(result) {
        $scope.paymentTypes = response.result;
      }
    }); 
  
    network.get('performer', {}, function (result, response) {
        if(result) {
            $scope.performers = response.result;
        }
    });
    
    network.get('financial_request_status', {}, function (result, response) {
      if (result) {
        $scope.statuses = response.result;
      }
    });
    
    $scope.updateSummary = function (project){
      var total_cost = project[0].total_cost.split('.');
      $scope.summary = {
        'project_code': project[0].project_code,
        'start_date'  : project[0].start_date,
        'due_date'    : project[0].due_date,
        'total_cost'  : total_cost[0],
        'changes'     : 0,
        'spending'    : 0,
        'remained'    : 0,
        'payed'       : 0,
        'actual'      : 0
      };
      for(var i = 0; i < project.length; i++){
        if(project[i].status_id == 3){
          $scope.summary['payed'] += Number(project[i].request_cost);
        }else{          
          if(project[i].payment_type_id == 2){
            $scope.summary['changes'] -= Number(project[i].request_cost);
          }
          if(project[i].payment_type_id == 3){
            $scope.summary['changes'] += Number(project[i].request_cost);
          }
          if(project[i].payment_type_id == 1){
            $scope.summary['spending'] += Number(project[i].request_cost);
          }
        }
      }
      $scope.summary['actual'] = $scope.summary['total_cost'] - $scope.summary['changes'];
      $scope.summary['remained'] = $scope.summary['actual'] - $scope.summary['payed'];
      return $scope.summary;
    };
    
    $scope.updateProject = function(id, year){
      delete $scope.summary;
      delete $scope.project;
      network.get('financial_request', {'project_id': id ? id : '', 'year': year ? year : ''}, function (result, response) {
        if(response.result.length) {
          if(response.result.length == 1){
            $scope.project = $scope.updateSummary(response.result);
          }else{
            var result = true;
            for(var item = 1; item < response.result.length; item++){
              if(response.result[item].project_id != response.result[item - 1].project_id){
                result = false;
              }
            }
            if(result){
              $scope.project = $scope.updateSummary(response.result);
            }
          }
        }
      });
    };
    
    $scope.canEdit = function(status) {
      if(!status) {
        return $rootScope.canEdit();
      } else {
        switch (network.user.type){
          case 't':
            if(status != 1){
              return false;
            }else{
              return true;
            } 
          case 'p':
          case 'a':
            if(status != 2){
              return false;
            }else{
              return true;
            } 
          default:
            return false;
        }
      }
    };
    
    $scope.openEdit = function (row, modeView) {
        grid.openEditor({
          data: row,
          hint: $scope._hint,
          modeView: !!modeView,
          controller: 'EditFinancialRequestController'
        });
    };


});


spi.controller('EditFinancialRequestController', function ($scope, modeView, $uibModalInstance, data, network, hint, Utils, SweetAlert) {
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.modeView = modeView;
    $scope.financial_request = {};
    $scope.user = network.user;
    $scope.IBAN = {};
    $scope.payment_template_id = '';
    $scope.project_id = data.project_id ? data.project_id : '';
    $scope.receipt_date = '';
    $scope.payment_date = '';
    
    $scope.getPaymentTemplate = function(payment_template_id){
      network.get('document_template', {id: payment_template_id}, function (result, response) {
        if(result) {
          $scope.payment_template_id = payment_template_id;
          $scope.paymentTemplates = response.result;
        }
      });
    };
    
    if(!$scope.isInsert) {
      $scope.financial_request = {
        representative_user_id: data.representative_user_id,
        bank_account_id: data.bank_account_id,
        payment_type_id: data.payment_type_id,
        rate_id: data.rate_id,
        request_cost: data.request_cost,
        description: data.description,
        request_id: data.request_id,
        status: data.status
      };
      
      $scope.receipt_date = new Date (data.receipt_date);
      $scope.payment_date = data.status == 2 && network.user.type == 'p' ? '' : data.payment_date ;
      
      $scope.getPaymentTemplate(data.payment_template_id);
      getPerformerUsers(data.request_id);
      
    }else{
      $scope.receipt_date = new Date ();
    }
    
    getProjects();
    
    network.get('performer', {}, function (result, response) {
      if(result) {
        $scope.performers = response.result;
      }
    });

    network.get('payment_type', {}, function (result, response) {
      if(result) {
        $scope.paymentTypes = response.result;
      }
    });
    
    network.get('document_template', {id: $scope.financial_request.payment_template_id}, function (result, response) {
      if(result) {
        $scope.paymentTemplates = response.result;
      }
    });
    
    network.get('rate', {}, function (result, response) {
      if(result) {
        $scope.rates = response.result;
      }
    });
    
    $scope.canEdit = function (){
      if(!$scope.isInsert && $scope.financial_request.status != 1){
        return false;
      }else{
        return true;
      } 
    };
    
    function getProjects () {
      network.get('request', {status_id: 5}, function(result, response){
        if(result) {
          $scope.projects = response.result;
          for (var i = 0; i < response.result.length; i++) {
            if (response.result[i].project_id == $scope.project_id) {
              $scope.selectProjectDetails = response.result[i];
            }
          };
          $scope.updateBankDetails(data.performer_id, data.request_id);
        }
      });
    }    
    
    $scope.dateFormat = function(date, date_type){    
      var day = date.getDate();
      if(day < 10){
        day = "0" + day;
      };
      var month = date.getMonth() + 1;
      if(month < 10){
        month = "0" + month;
      };
      var year = date.getFullYear();
      if(date_type == 'payment_date'){        
        $scope.financial_request.payment_date = year + '-' + month + '-' + day;
      }else{
        $scope.financial_request.receipt_date = year + '-' + month + '-' + day;
      }
    };
    
    function getPerformerUsers (request_id){
      network.get('user', {type: 't', relation_id: request_id}, function (result, response) {
        if (result) {
          $scope.performerUsers = response.result;
          $scope.selectRepresentativeUser = Utils.getRowById(response.result, $scope.financial_request.representative_user_id);            
        }
      });         
    };
    
    $scope.updatePerformerUsers = function (request_id){
      delete $scope.financial_request.representative_user_id;
      getPerformerUsers(request_id);
    };
    
    $scope.onSelectUser = function (item, model, type){
      $scope.selectRepresentativeUser = item;      
    };
    
    $scope.onSelectProject = function (item, model, type){
      $scope.selectProjectDetails = item;
      delete $scope.IBAN;
      delete $scope.financial_request.bank_account_id;
    };
    
    $scope.updateIBAN = function (item){
      $scope.IBAN = item;
    }
    
    $scope.updateBankDetails = function(performer_id, request_id){
      network.get('bank_details', {performer_id: performer_id, request_id: request_id}, function (result, response) {
        if (result) {
          $scope.bank_details = response.result;
          angular.forEach($scope.bank_details, function(val, key) {
            if(val.id == $scope.financial_request.bank_account_id) {
              $scope.updateIBAN(val);
              return false;
            }
          });

        }
      });
    }
        
    $scope.fieldError = function(field) {
        var form = $scope.formFinancialRequest;
        return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
    };
    
    $scope.getRequestID = function (item){
      $scope.financial_request.request_id = item.id;
    };
    
    $scope.submitFormFinancialRequest = function () {
      $scope.submited = true;
      $scope.formFinancialRequest.$setPristine();
      if ($scope.formFinancialRequest.$valid) {
        var callback = function (result, response) {
            if (result) {
              $uibModalInstance.close();
            }
            $scope.submited = false;
        };
        if(network.user.type == 'p'){
          $scope.financial_request.payment_date = $scope.payment_date;
          $scope.dateFormat($scope.financial_request.payment_date, 'payment_date');
        }else{
          $scope.financial_request.payment_date = '000-00-00';
        }
        $scope.financial_request.receipt_date = $scope.receipt_date;
        $scope.dateFormat($scope.financial_request.receipt_date, 'receipt_date');
        if($scope.financial_request.status == 2){
          $scope.financial_request.status_id = 3;
          $scope.financial_request.status_id_pa = 3;
        }
        $scope.financial_request.status_id = 1;
        $scope.financial_request.status_id_pa = 1;
        if ($scope.isInsert) {
            network.post('financial_request', $scope.financial_request, callback);
        } else {
            network.put('financial_request/' + data.id, $scope.financial_request, callback);
        }
      }
    };

//    $scope.accept = function (){
//      SweetAlert.swal({
//          title: "Mittelabruf akzeptieren?",
//          text: "Diese Aktion wird nicht wiederhergestellt!",
//          type: "warning",
//          confirmButtonText: "Ja, akzeptieren!",
//          showCancelButton: true,
//          cancelButtonText: "ABBRECHEN",
//          closeOnConfirm: true
//        }, function(isConfirm){
//          if(isConfirm) {
//            $scope.dateFormat($scope.financial_request.receipt_date, 'receipt_date');
//            $scope.dateFormat($scope.financial_request.payment_date, 'payment_date');
//            $scope.financial_request.status_id = 3;
//            $scope.financial_request.status_id_pa = 3;
//            network.put('financial_request/' + data.id, $scope.financial_request, function (result, response) {
//              if (result) {
//                $uibModalInstance.close();
//              }
//            });
//          }
//      });
//    };


    $scope.print = function (){
      SweetAlert.swal({
          title: "Sicher?",
          text: "Mittelabruf kann nicht mehr geändert werden!",
          type: "warning",
          confirmButtonText: "Ja, drucken!",
          showCancelButton: true,
          cancelButtonText: "ABBRECHEN",
          closeOnConfirm: true
        }, function(isConfirm){
          if(isConfirm) {
            $scope.financial_request.status_id = 4;
            $scope.financial_request.status_id_pa = 2;
            network.put('financial_request/' + data.id, $scope.financial_request, function (result, response) {
              if (result) {
                $uibModalInstance.close();
              }
            });
          }
      });
    };
    
    $scope.remove = function() {
      Utils.doConfirm(function() {
        network.delete('financial_request/'+data.id, function (result) {
            if(result) {
              Utils.deleteSuccess();
              $uibModalInstance.close();
            }
        });
      });
    };

    $scope.$on('modal.closing', function(event, reason, closed) {
      Utils.modalClosing($scope.formFinancialRequest, $uibModalInstance, event, reason);
    });

    $scope.cancel = function () {
      Utils.modalClosing($scope.formFinancialRequest, $uibModalInstance);
    };

});