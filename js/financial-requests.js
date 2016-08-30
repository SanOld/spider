spi.controller('FinancialRequestController', function($scope, $rootScope, network, GridService, localStorageService, $uibModal, Utils, SweetAlert, $timeout) {
    $rootScope._m = 'financial_request';
    var d = new Date;
    $scope.defaulFilter = {year: d.getFullYear(), status_id: 3};
    $scope.years = [];
    $scope.filter = localStorageService.get('requestsFilter', $scope.filter ) || angular.copy($scope.defaulFilter);
    if(!$scope.filter == $scope.defaulFilter ){
      localStorageService.set('requestsFilter', $scope.filter );
    }
    if(network.user.type == 't' && network.user.is_finansist == 0){
      window.location = '/';
    };
    $rootScope.printed = 0;
    $scope.user = network.user;
    
    var grid = GridService();
    $scope.tableParams = grid('financial_request', $scope.filter);
    
    $scope.updateGrid = function() {      
      $scope.setFilter();
      grid.reload();
    };
    
    $scope.checkboxes = {
      checked: false,
      items: {}
    };
    
    $scope.existsSelected = function() {
      return !!getSelectedIds().length;
    };
    
    function getSelectedIds() {
      var ids = [];
      for(var k in $scope.checkboxes.items) {
        if($scope.checkboxes.items[k] && Utils.getRowById($scope.tableParams.data, k)) {
          ids.push(k);
        };
      };
      return ids;
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
      };
      return result;
    };
    
    $scope.setFilter = function(){
       localStorageService.set('requestsFilter', $scope.filter );
    };
  
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
      };
    };
    
    $scope.resetFilter = function() {
      $scope.filter = grid.resetFilter();
      delete $scope.project;
    };
    
    network.get('project_type', {}, function (result, response) {
      if(result) {
        $scope.projectTypes = response.result;
      };
    });
    
    network.get('payment_type', {}, function (result, response) {
      if(result) {
        $scope.paymentTypes = response.result;
      };
    }); 
    
    network.get('financial_request_status', {}, function (result, response) {
      if (result) {
        $scope.statuses = response.result;
      };
    });
    
       
    network.get('financial_request', {list: 'project'}, function (result, response) {
      if(result) {
        $scope.projects = response.result;
      };
    });    
    
    network.get('financial_request', {list: 'year'}, function (result, response) {
      if(response.result.length > 0) {
        for(var i = 0; i < response.result.length; i++){
          $scope.years.push(response.result[i].year);
        };
        $scope.defaulFilter = {year: $scope.years[0]};

        if($scope.years.indexOf($scope.filter.year) == -1){
          $scope.filter.year = $scope.years[0].year;
          $scope.setFilter();
          grid.reload();
        };          
      };
    });
    
    network.get('performer', {}, function (result, response) {
      if(result) {
        $scope.performers = response.result;
      };
    });
    
    if(network.user.type == 't'){
      network.get('school', {filter: 1, requests: 1}, function (result, response) {
        if (result) {
          $scope.schools = response.result;
        };
      }); 
    };
    
    $scope.updateSummary = function (project){
      $scope.summary = {
        'project_code': project[0].project_code,
        'start_date'  : project[0].start_date,
        'due_date'    : project[0].due_date,
        'total_cost'  : Number(project[0].total_cost),
        'changes'     : 0,
        'spending'    : 0,
        'remained'    : 0,
        'payed'       : 0,
        'actual'      : 0
      };
      for(var i = 0; i < project.length; i++){
        if(project[i].status_id == 3){          
          if(project[i].payment_type_id == 1){
            $scope.summary['payed'] += Number(project[i].request_cost);
          }else{          
            if(project[i].payment_type_id == 2){
              $scope.summary['changes'] -= Number(project[i].request_cost);
            };
            if(project[i].payment_type_id == 3){
              $scope.summary['changes'] += Number(project[i].request_cost);
            };
  //          if(project[i].payment_type_id == 1){
  //            $scope.summary['spending'] += Number(project[i].request_cost);
  //          }
         }
        };
      };
      $scope.summary['actual'] = Number($scope.summary['total_cost']) + Number($scope.summary['changes']);
      $scope.summary['remained'] = Number($scope.summary['actual']) - Number($scope.summary['payed']);
      return $scope.summary;
    };
    
    $scope.updateProject = function(id, year, school_id, performer_id){
      delete $scope.summary;
      delete $scope.project;
      network.get('financial_request', {'project_id': id ? id : '', 'year': year ? year : '', list: 'summary', school_id: school_id, performer_id: performer_id}, function (result, response) {
        if(response.result.length) {
          if(response.result.length == 1){
            $scope.project = $scope.updateSummary(response.result);
          }else{
            var result = true;
            for(var item = 1; item < response.result.length; item++){
              if(response.result[item].project_id != response.result[item - 1].project_id){
                result = false;
              };
            };
            if(result){
              $scope.project = $scope.updateSummary(response.result);
            };
          };
        };
      });
    };
    $scope.updateProject($scope.filter.project_id, $scope.filter.year);
    
    $scope.canEdit = function(row) {
      if(!row.status) {
        return $rootScope.canEdit();
      } else {
        switch (network.user.type){
          case 't':
            return row.status == 1 || row.status == 2; 
          case 'p':
          case 'a':
            return row.status == 1 || row.status_id_pa == 2;
        };
      };
    };
    
    $scope.openEdit = function (row, modeView) {
      grid.openEditor({
        data: row,
        hint: $scope._hint,
        modeView: !!modeView,
        controller: 'EditFinancialRequestController'
      }, function(){
        $timeout(function(){  
          grid.reload();    
          $scope.updateProject($scope.filter.project_id, $scope.filter.year);
        });
      });
    };

    $scope.setPaymentDate = function() {
      var ids = getSelectedIds();
      if (ids.length) {
        var failCodes = [];
        for(var i = 0; i < ids.length; i++) {
          var row = Utils.getRowById($scope.tableParams.data, ids[i]);
          if(row.status_code != 'in_progress') {
            failCodes.push(row.project_code)
          };
        };
        if(failCodes.length) {
          SweetAlert.swal({
            title: "Fehler",
            text: "Mittelabrufe ohne Signatur (" + failCodes.join(', ') + ") können nicht aktualisiert sein",
            type: "error",
            confirmButtonText: "OK"
          });
          return false;
        };       
        var modalInstance = $uibModal.open({
          animation: true,
          templateUrl: 'setPaymentDate.html',
          controller: 'SetPaymentDateController',
          size: 'custom-width-financial-request-duration',
          resolve: {
            ids: function () {
              return ids;
            }
          }
        });
        modalInstance.result.then(function (request) {
          network.patch('financial_request', angular.extend({ids: ids}, request), function(result) {
            if(result) {
              grid.reload();
              $scope.checkboxes.items = {};
            };
          });
        });
      };
    };
        
    $scope.setDocumentTemplate = function() {
      var ids = getSelectedIds();
      var payment_type = '';
      var failType = false;
      if (ids.length) {
        var failCodes = [];
        for(var i = 0; i < ids.length; i++) {
          var row_cur = Utils.getRowById($scope.tableParams.data, ids[i]);
          payment_type = row_cur.payment_type_id;
          if(i > 0){
            var row_prv = Utils.getRowById($scope.tableParams.data, ids[i-1]);            
            if(row_cur.payment_type_id != row_prv.payment_type_id){
              failType = true;
            };
          };         
          if(row_cur.status_code != 'open') {
            failCodes.push(row_cur.project_code);
          };
        };
        if(failCodes.length) {
          SweetAlert.swal({
            title: "Fehler",
            text: "Mittelabrufe (" + failCodes.join(', ') + ") können nicht aktualisiert sein",
            type: "error",
            confirmButtonText: "OK"
          });
          return false;
        };
        if(failType) {
          SweetAlert.swal({
            title: "Fehler",
            text: "Mittelabrufe den verschiedenen Beleg-Typen können nicht aktualisiert sein",
            type: "error",
            confirmButtonText: "OK"
          });
          return false;
        };
        var modalInstance = $uibModal.open({
          animation: true,
          templateUrl: 'setDocumentTemplate.html',
          controller: 'SetDocumentTemplateController',
          size: 'custom-width-financial-request-duration',
          resolve: {
            ids: function () {
              return ids;
            },
            payment_type: function () {
              return payment_type;
            }
          }
        });
        modalInstance.result.then(function (request) {
          network.patch('financial_request', angular.extend({ids: ids}, request), function(result) {
            if(result) {
              grid.reload();
              $scope.checkboxes.items = {};
            };
          });
        });
      };
    };
  
    $scope.printDocuments = function(row) {
      var request = {
        id: row.id
      };
      if($scope.user.type == 't'){       
        SweetAlert.swal({
          title: "Sicher?",
          text: "Mittelabruf kann nicht mehr geändert werden!",
          type: "warning",
          confirmButtonText: "Ja, drucken!",
          showCancelButton: true,
          cancelButtonText: "ABBRECHEN",
          closeOnConfirm: true
        }, function(isConfirm){
          $timeout(function(){
            network.get('document_template', {id: row.document_template_id, prepare_fin_request: 1, fin_request_id: row.id }, function (result, response) {
              if(result) {
                var modalInstance = $uibModal.open({
                  animation: false,
                  templateUrl: 'printDocuments.html',
                  controller: 'PrintDocumentTemplatesController',
                  size: 'width-full',
                  resolve: {
                    document: function () {
                      return response.result[0];
                    }
                  }
                });
                modalInstance.result.then(function () {
                  request.status_id = 4;
                  request.status_id_pa = 2;
                  network.put('financial_request/' + request.id, request, function (result, response) {
                    grid.reload();
                  });
                });
              };
            });
          });
        }); 
      }else{
        $timeout(function(){
          network.get('document_template', {id: row.document_template_id, prepare_fin_request: 1, fin_request_id: row.id }, function (result, response) {
            if(result) {
              var modalInstance = $uibModal.open({
                animation: false,
                templateUrl: 'printDocuments.html',
                controller: 'PrintDocumentTemplatesController',
                size: 'width-full',
                resolve: {
                  document: function () {
                    return response.result[0];
                  }
                }
              });
            };
          });
        });
      }; 
    };

});

spi.controller('EditFinancialRequestController', function ($scope, modeView, $uibModalInstance, data, network, hint, Utils, SweetAlert, $uibModal, $timeout) {
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.modeView = modeView;
    $scope.financialRequest = {};
    $scope.user = network.user;
    $scope.IBAN = {};
    $scope.receiptDate = '';
    $scope.rights = {};
    $scope.financialRequests = [];
    $scope.financialRequestId = data.id;
    $scope.error = false;    
    
    $scope.getProjects = function (year) {
      $scope.year = year;
      if($scope.isInsert){
        delete $scope.financialRequest.request_id;
        delete $scope.selectProjectDetails;
      };
      network.get('request', {status_id: 5,'year' : year, 'no_rate': 0}, function(result, response){
        if(result) {
          $scope.requests = response.result;          
          for (var i = 0; i < response.result.length; i++) {
            if (response.result[i].project_id == data.project_id) {
              $scope.selectProjectDetails = response.result[i];
            };
          };
          $scope.updateBankDetails(data.performer_id, data.request_id, Utils.getRowById($scope.requests, data.request_id));          
        };
      });
    };
    
    $scope.updateRates = function (item) {
      $scope.updatedRates = [];
      $scope.getPaymentTypes();
      var last_rate_id = 0;
      network.get('financial_request', {request_id: item.id, payment_type_id: 1}, function (result, response) {
        if(response.result.length) {
          $scope.financialRequests = response.result;
          last_rate_id = response.result[response.result.length - 1].rate_id; 
        }else{
          $scope.financialRequest.rate_id = 1;
          return;
        };
        network.get('rate', {}, function (result, response) {
          if(result) {
            $scope.rates = response.result;
            var k = 0;
            for(var i = 0; i < $scope.rates.length; i++){
              if($scope.rates[i].id == last_rate_id && last_rate_id != 6){
                $scope.updatedRates.push($scope.rates[i+1]);
                break;
              };
              if($scope.financialRequests[k].rate_id != $scope.rates[i].id){
                $scope.updatedRates.push($scope.rates[i]);
              }else{
                k++;
              };
            };
            if(!$scope.updatedRates.length && last_rate_id == 6){
              delete $scope.paymentTypes[0];
            }else{              
              if($scope.updatedRates.length == 1){
                $scope.financialRequest.rate_id = $scope.updatedRates[0].id;
              };
            };            
            $scope.rates = $scope.updatedRates;
          };
        });
      });
    };
      
    $scope.getPaymentTypes = function () {
      network.get('payment_type', {}, function (result, response) {
        if(result) {
          $scope.paymentTypes = response.result;
        };
      });
    };
    
    if(!$scope.isInsert) {
      $scope.financialRequest = {
        representative_user_id: data.representative_user_id,
        bank_account_id: data.bank_account_id,
        payment_type_id: data.payment_type_id,
        document_template_id: data.document_template_id,
        rate_id: data.rate_id,
        request_cost: data.request_cost,
        description: data.description,
        request_id: data.request_id,
        status: data.status
      };
      $scope.id = data.id;
      $scope.year = data.year;
      $scope.receiptDate = new Date (data.receipt_date);
      if(data.payment_date){
        $scope.paymentDate = new Date (data.payment_date);
      };
      getPerformerUsers(data.performer_id);
      $scope.getProjects(data.year);
    }else{
      $scope.receiptDate = new Date ();
    };
    $scope.getPaymentTypes();
    
    $scope.setValue = function(value){
      if(value){
        $scope.financialRequest.payment_date = value;
      };
    };
        
    network.get('rate', {rate_id: data.rate_id}, function (result, response) {
      if(result) {
        $scope.rates = response.result;
      };
    });
        
    network.get('request', {status_id: 5, group: 1}, function(result, response){
      if(result) {
        $scope.years = response.result;
      };
    });
    
    network.get('performer', {}, function (result, response) {
      if(result) {
        $scope.performers = response.result;
      };
    });
    
    network.get('document_template', {}, function (result, response) {
      if(result) {
        $scope.paymentTemplates = response.result;
      };
    });
    
    function getPerformerUsers (request_id){
      network.get('user', {type: 't', relation_id: request_id}, function (result, response) {
        if (result) {
          $scope.performerUsers = response.result;
          $scope.selectRepresentativeUser = Utils.getRowById(response.result, $scope.financialRequest.representative_user_id);            
        };
      });         
    };
    
    $scope.countRequestCost = function (request_id){
      var summary = {};
      network.get('financial_request', {request_id: request_id, year: $scope.year}, function(result, response){
        if(response.result.length) {
          summary = {
            'total_cost'  : Number(response.result[0].total_cost),
            'changes'     : 0,
            'actual'      : 0
          };
          for(var i = 0; i < response.result.length; i++){
            if(response.result[i].status_id == 3){
              if(response.result[i].payment_type_id == 1){
              };
              if(response.result[i].payment_type_id == 2){
                summary['changes'] -= Number(response.result[i].request_cost);
              };
              if(response.result[i].payment_type_id == 3){
                summary['changes'] += Number(response.result[i].request_cost);
              };
            };
          };
          summary['actual'] = Number(summary['total_cost']) + Number(summary['changes']);
          summary['actual'] = summary['actual'] / 6 ;
        }else{
          summary['actual'] = Number($scope.selectProjectDetails.total_cost) / 6;
        };
        $scope.financialRequest.request_cost =  $scope.request_cost = summary['actual'].toFixed(2);
      });
    };
    
    $scope.updateCost = function (payment_id, request_id){
      if(payment_id != 1){
        delete $scope.financialRequest.request_cost;
      }else{
        $scope.countRequestCost(request_id);
      };   
    };
    
    $scope.refreshSumm = function (){
      $scope.error = false;
      $scope.financialRequest.request_cost =  $scope.request_cost;
    };
    
    $scope.updateTemplates = function(payment_id){    
      network.get('document_template', {payment_id: payment_id}, function (result, response) {
        if(result) {
          $scope.paymentTemplates = response.result;
          if(response.result.length < 2){
            $scope.financialRequest.document_template_id = response.result[0].id;
          };
        };
      });
    };
    
    $scope.canEdit = function (){
      switch (network.user.type){
        case 't':
          $scope.rights.print = $scope.financialRequest.status == 1 || $scope.financialRequest.status == 4 || $scope.financialRequest.status == 2 ? 1 : 0 ;
          $scope.rights.receipt = 0;
          $scope.rights.delete = $scope.financialRequest.status == 1 ? 1 : 0 ;           
          $scope.rights.fields = $scope.isInsert || $scope.financialRequest.status == 1 ? 1 : 0 ;
          $scope.rights.save = $scope.isInsert || $scope.financialRequest.status == 1 ? 1 : 0 ;
          break;
        case 'p':
        case 'a':
          $scope.rights.print = 0;
          $scope.rights.receipt = $scope.financialRequest.status == 2 ? 1 : 0 ;
          $scope.rights.delete = $scope.financialRequest.status == 1 || $scope.financialRequest.status == 2 ? 1 : 0 ;
          $scope.rights.fields = $scope.isInsert || $scope.financialRequest.status == 1 ? 1 : 0 ;
          $scope.rights.save = $scope.isInsert || $scope.financialRequest.status == 1 || $scope.financialRequest.status == 2 ? 1 : 0 ;
          break;
      };
    };
     
    $scope.canEdit(); 
    
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
      return year + '-' + month + '-' + day;
    };
    
    $scope.updatePerformerUsers = function (performer_id){
      delete $scope.financialRequest.representative_user_id;
      getPerformerUsers(performer_id);
    };
    
    $scope.onSelectUser = function (item, model, type){
      $scope.selectRepresentativeUser = item;      
    };
    
    $scope.onSelectProject = function (item, model, type){
      $scope.selectProjectDetails = item;
      delete $scope.IBAN;
      $scope.financialRequest = {request_id:item.id};
    };
    
    $scope.updateIBAN = function (item){
      $scope.IBAN = item;
    };
    
    $scope.updateBankDetails = function(performer_id, request_id, request){
      network.get('bank_details', {performer_id: performer_id, request_id: request_id}, function (result, response) {
        if (result) {
          $scope.bank_details = response.result;
          var bank_account_id = '';
          if(!$scope.financialRequests.length){  
            bank_account_id = request.bank_details_id;
          }else{
            bank_account_id = $scope.financialRequests[$scope.financialRequests.length - 1].bank_account_id;
          };
          angular.forEach($scope.bank_details, function(val, key) {
            if(val.id == bank_account_id) {
              $scope.financialRequest.bank_account_id = bank_account_id;
              $scope.updateIBAN(val);
              return false;
            };
          }); 
        };
      });
    };
    
    $scope.checkCost = function (request_cost, payment_type) {
      if(payment_type == 1){
        $scope.error = false;
        if(request_cost > Number($scope.request_cost)){
          $scope.error = true;
        };
      };
    };
    
    $scope.fieldError = function(field) {
        var form = $scope.formFinancialRequest;
        return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
    };
    
    $scope.submitFormFinancialRequest = function () {
      $scope.submited = true;
      $scope.formFinancialRequest.$setPristine();
      if ($scope.formFinancialRequest.$valid && !$scope.error) {
        var callback = function (result, response) {
          if (result) {
            if(network.user.type != 't'){
              $uibModalInstance.close();
            }else{
              $scope.financialRequestId = response.id;
              $scope.rights.print = 1;
              $scope.isInsert = false;
            };
          };
          $scope.submited = false;
        };
        if(!$scope.financialRequest.payment_date){
          $scope.financialRequest.payment_date = "0000-00-00";
        };        
        if((network.user.type == 'p' || network.user.type == 'a') && $scope.financialRequest.payment_date != "0000-00-00"){
          $scope.financialRequest.payment_date = $scope.dateFormat($scope.financialRequest.payment_date);
        };        
        $scope.financialRequest.receipt_date = $scope.dateFormat($scope.receiptDate);        
        delete $scope.financialRequest.status;
        $scope.financialRequest.status_id = $scope.financialRequest.status_id_pa = 1;
        if($scope.financialRequest.payment_type_id != 1){
          $scope.financialRequest.rate_id = null;
        };
        if($scope.isInsert) {
          if(network.user.type == 'p' || network.user.type == 'a'){
            $scope.financialRequest.status_id = 2;
            $scope.financialRequest.status_id_pa = 1;
          };
          network.post('financial_request', $scope.financialRequest, callback);
        } else {
          if((network.user.type == 'p' || network.user.type == 'a') && $scope.financialRequest.payment_date != "0000-00-00"){
            $scope.financialRequest.status_id = $scope.financialRequest.status_id_pa = 3;
          };
          var id = data.id ? data.id : $scope.financialRequestId;
          network.put('financial_request/' + id, $scope.financialRequest, callback);
        };
      };
    };
    
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
          $timeout(function(){
            network.get('document_template', {id: data.document_template_id, prepare_fin_request: 1, fin_request_id: data.id}, function (result, response) {
              if(result) {
                var modalInstance = $uibModal.open({
                  animation: false,
                  templateUrl: 'printDocuments.html',
                  controller: 'PrintDocumentTemplatesController',
                  size: 'width-full',
                  resolve: {
                    document: function () {
                      return response.result[0];
                    }
                  }
                });
                modalInstance.result.then(function (template) {
                  delete $scope.financialRequest.status;
                  $scope.financialRequest.status_id = 4;
                  $scope.financialRequest.status_id_pa = 2;
                  network.put('financial_request/' + $scope.financialRequestId, $scope.financialRequest, function (result, response) {
                    $uibModalInstance.close();
                  });
                });
              };
            });
          });
        };
      });
    };
    
    $scope.remove = function() {
      Utils.doConfirm(function() {
        network.delete('financial_request/'+data.id, function (result) {
          if(result) {
            Utils.deleteSuccess();
            $uibModalInstance.close();
          };
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

spi.controller('SetPaymentDateController', function ($scope, ids, $uibModalInstance, network) {
  $scope.financialRequests = ids;
  $scope.countElements = ids.length;
  $scope.request = {
    status_id: 3,    
    status_id_pa: 3  
  };
  
  $scope.fieldError = function(field) {
    var form = $scope.setPaymentDate;
    return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
  };

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
    return year + '-' + month + '-' + day;
  };
  
  $scope.submit = function (){
    $scope.request.payment_date = $scope.dateFormat($scope.request.payment_date);
    $uibModalInstance.close($scope.request);    
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
  
});

spi.controller('SetDocumentTemplateController', function ($scope, ids, payment_type, $uibModalInstance, network) {
  $scope.financialRequests = ids;
  $scope.countElements = ids.length;
  $scope.request = {};
  
  network.get('document_template', {payment_id: payment_type}, function (result, response) {
    if(result) {
      $scope.paymentTemplates = response.result;
    };
  });
      
  $scope.fieldError = function(field) {
    var form = $scope.setDocumentTemplate;
    return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
  };

  $scope.submit = function (){
    $uibModalInstance.close($scope.request);    
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
  
});

spi.controller('PrintDocumentTemplatesController', function ($scope, document,  $timeout, network, $sce, $rootScope, $uibModalInstance) {
 
  $scope.document = {
    text: document.text,
    name: document.name
  };  
   
  $rootScope.printed = 1;
  $timeout(function() {
    window.print();
    $rootScope.printed = 0;
  });
  
  $scope.print = function(){
    $rootScope.printed = 1;
    $timeout(function() {
      window.print();
      $rootScope.printed = 0;
    });
  };
  
  $scope.trustAsHtml = function(string) {
    return $sce.trustAsHtml(string);
  };  

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});