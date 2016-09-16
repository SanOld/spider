spi.controller('FinancialRequestController', function($scope, $rootScope, network, GridService, localStorageService, $uibModal, Utils, SweetAlert, $timeout) {
    $rootScope._m = 'financial_request';
    var d = new Date;
    $scope.defaulFilter = {};
    $scope.years = [];
    $scope.filter = localStorageService.get('finRequestsFilter', $scope.filter ) || angular.copy($scope.defaulFilter);
    if(!$scope.filter == $scope.defaulFilter ){
      localStorageService.set('finRequestsFilter', $scope.filter);
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
    $scope.project = {};
    $scope.checkboxes = {
      checked: false,
      items: {}
    };
    
    $scope.paramsForExport = {
      fileName: 'Mittelabrufliste.csv',
      model: 'financial_request',
      tables: {
        table1: {
          columns: {
            'project_code'   : 'Kennziffer',
            'year'           : 'Jahr',
            'rate'           : 'Rate',
            'performer_name' : 'Träger',
            'schools'        : 'Schule(n)',
            'kreditor'       : 'Kreditor',
            'payment_name'   : 'Beleg Typ',
            'receipt_date'   : 'Beleg -Datum',
            'request_cost'   : 'Betrag',
            'payment_date'   : 'Zahl. -Datum',
          },
          schools: 'name',
          replace: ['rate','is_partial_rate']
        }
      },
      param: $scope.filter,
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
       localStorageService.set('finRequestsFilter', $scope.filter );
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
          $scope.filter.year = $scope.years[0];
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
    
    $scope.updateProject = function(id, year){
      delete $scope.project;
      if(!id){
        return;
      };
      network.get('financial_request', {'project_id': id ? id : '', 'year': year ? year : '', list: 'summary'}, function (result, response) {
        if(result) {
          if(response.result.length && response.result[0].actual){
            $timeout(function(){
              $scope.project = {
                'project_code': response.result[0].project_code,
                'start_date'  : response.result[0].start_date,
                'due_date'    : response.result[0].due_date,
                'total_cost'  : response.result[0].total_cost,
                'changes'     : response.result[0].changes,
                'spending'    : response.result[0].spending,
                'remained'    : response.result[0].remained,
                'payed'       : response.result[0].payed,
                'actual'      : response.result[0].actual
              };
            })
          }else{
            if(!id || !year){
              return;
            };
            network.get('request', {'project_id': id ? id : '', 'year': year ? year : '', status_id: 5}, function (result, response) {
              if(response.result.length) {
                $scope.project = {
                  'project_code': response.result[0].code,
                  'start_date'  : response.result[0].start_date,
                  'due_date'    : response.result[0].due_date,
                  'total_cost'  : response.result[0].total_cost,
                  'changes'     : 0,
                  'spending'    : 0,
                  'remained'    : response.result[0].total_cost,
                  'payed'       : 0,
                  'actual'      : response.result[0].total_cost
                };
              }
            });
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
              $scope.updateProject($scope.filter.project_id, $scope.filter.year);
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
              $scope.updateProject($scope.filter.project_id, $scope.filter.year);
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
                request.status_id = 4;
                request.status_id_pa = 2;
                network.put('financial_request/' + request.id, request, function (result2, response2) {
                  $uibModal.open({
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
                  grid.reload();
                  $scope.updateProject($scope.filter.project_id, $scope.filter.year);
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
    $scope.pair_remember = true;
    $scope.months = {
      m01  : {pair:0,rate:1},   // month_number : is_even for creating pairs
      m02  : {pair:1,rate:1},
      m03  : {pair:0,rate:2},
      m04  : {pair:1,rate:2},
      m05  : {pair:0,rate:3},
      m06  : {pair:1,rate:3},
      m07  : {pair:0,rate:4},
      m08  : {pair:1,rate:4},
      m09  : {pair:0,rate:5},
      m10  : {pair:1,rate:5},
      m11  : {pair:0,rate:6},
      m12  : {pair:1,rate:6}
    };
    $scope.rate_dates = {
      1  : '01-01',   // month_number : is_even for creating pairs
      2  : '03-01',
      3  : '05-01',
      4  : '07-01',
      5  : '09-01',
      6  : '11-01'
    };
    
    
    $scope.getRates = function(rate_id, data){
      network.get('rate', {rate_id: rate_id}, function (result, response) {
        if(result) {
          if(!$scope.isInsert && data.is_partial_rate){
            response.result[0].name = data.is_partial_rate;
          };
          $scope.rates = response.result;
        };
      });
    };
    
    $scope.getProjects = function (year) {
      $scope.year = year;
      if($scope.isInsert){
        delete $scope.financialRequest.request_id;
        delete $scope.selectProjectDetails;
      };
      network.get('request', {status_id: 5,'year' : year}, function(result, response){
        if(result) {
          $scope.requests = response.result;          
          for (var i = 0; i < response.result.length; i++) {
            if (response.result[i].project_id == data.project_id) {
              $scope.selectProjectDetails = response.result[i];
            };
          };
          if(!$scope.isInsert){
            $scope.updateBankDetails(data.performer_id, data.request_id, Utils.getRowById($scope.requests, data.request_id));   
          };   
        };
      });
    };
    
    $scope.updateRates = function (project) {
      delete $scope.financialRequest.rate_id;
      $scope.project = project;
      var month = 'm' + project.start_date.substring(5,7);
      var receipt_rate = 'm' + $scope.dateFormat($scope.receiptDate).substring(5,7);
      var pair = true;
      $scope.pair_remember = true;
      $scope.rate = 0;
      for(var item in $scope.months){
        if(month == item){
          $scope.rate = $scope.months[item].rate;
          if($scope.months[item].pair == 1){
            pair = false;
            $scope.pair_remember = false;
          }
        };
        if(receipt_rate == item){
          receipt_rate = $scope.months[item].rate;
        };
      };
      $scope.getRates($scope.rate);
      $timeout(function(){    
        $scope.updatedRates = [];
        $scope.getPaymentTypes();
        var last_rate_id = 0;
        var first_rate_id = 0;
        network.get('financial_request', {request_id: project.id, payment_type_id: 1}, function (result, response) {
          if(response.result.length) {
            $scope.financialRequests = response.result;
            last_rate_id = response.result[response.result.length - 1].rate_id;
            first_rate_id = response.result[0].rate_id;
            pair = true;
          }else{
            $timeout(function(){
              var receiptDate = $scope.receiptDate;
              receiptDate.setMonth(receiptDate.getMonth() + 2);
              if(receiptDate >= new Date(project.start_date)){
                $scope.financialRequest.rate_id = $scope.rate;
              }else{
                delete $scope.rates;
              }
            });          
            var rates = [];            
            if(!pair){
              for(var i in $scope.rates){
                if($scope.rates[i].id == $scope.rate){
                  rates[0] = $scope.rates[i];
                  rates[0].name = rates[0].name.substring(4,7);
                  $scope.financialRequest.is_partial_rate = rates[0].name;
                  $scope.rates = rates;
                  return;
                };
              };
            };
            return;    
          };
          network.get('rate', {}, function (result, response) {
            if(result) {
              $scope.rates = response.result;
              for(var i = 0; i < $scope.rates.length; i++){
                if($scope.rates[i].id == last_rate_id && last_rate_id != 6){
                  $scope.updatedRates.push($scope.rates[i+1]);
                  break;
                };
                var current = false;
                for(var k = 0; k < $scope.financialRequests.length; k++){
                  if($scope.financialRequests[k].rate_id == $scope.rates[i].id){
                    current = true;
                    break;
                  }
                }
                if(($scope.rates[i].id > receipt_rate && !current) || (first_rate_id > $scope.rate && $scope.rates[i].id == $scope.rate)){             
                  if($scope.rates[i].id == $scope.rate && !$scope.pair_remember){
                    $scope.rates[i].name = $scope.rates[i].name.substring(4,7);
                  };
                  if($scope.rates[i] > $scope.rate){                    
                    $scope.updatedRates.push($scope.rates[i]);
                  }
                }
              };
              if(!$scope.updatedRates.length && last_rate_id == 6){
                delete $scope.paymentTypes[0];
              }
              var receiptDate = $scope.receiptDate;
              var year = project.start_date.substring(0,4);
              receiptDate.setMonth(receiptDate.getMonth() + 2);
              $scope.updatedRates.forEach(function(item, i, arr){
                var day = year + '-' + $scope.rate_dates[item.id];
                var rateDate = new Date(day);              
                var diff = receiptDate - rateDate;
                diff = Math.ceil(diff / (1000 * 3600 * 24 * 30));
                if(diff < 2 || (receipt_rate + 1 < item['id'] && $scope.receiptDate < project.start_date)){
                  delete $scope.updatedRates[i];
                };
              });
              if($scope.updatedRates.length == 1 && $scope.updatedRates[0]){
                $scope.financialRequest.rate_id = $scope.updatedRates[0].id;
              }; 
              $scope.rates = $scope.updatedRates;
            };
          });
        });
      });
    };
    
    $scope.countRequestCost = function (request_id){
      if(!$scope.isInsert){
        var month = 'm' + data.start_date.substring(5,7);
        for(var item in $scope.months){
          if(month == item){
            $scope.rate = $scope.months[item].rate;
          };
        };
      };      
      var summary = {};
      var cost = 0;
      var number_of_rates = 6 - Number($scope.rate) + 1;
      network.get('financial_request', {request_id: request_id, year: $scope.year, list: 'summary'}, function(result, response){
        if(response.result.length) {
          summary = {
            'total_cost'  : Number(response.result[0].total_cost),
            'changes'     : Number(response.result[0].changes || 0),
            'actual'      : Number(response.result[0].actual || response.result[0].total_cost)
          };
          var is_partial = false;
          var item_id = 0;
          response.result.forEach(function(item, i, arr){
            if(item.rate_id == $scope.rate){
              item_id = i;
              is_partial = true;
            };
          });
          if(is_partial){
            summary['actual'] = summary['actual'] - Number(response.result[item_id].request_cost);
            number_of_rates = number_of_rates - 1;
          };
          cost = summary['actual'] / number_of_rates ;
        }else{
          cost = Number($scope.selectProjectDetails.total_cost) / number_of_rates;
        };
        if($scope.financialRequest.is_partial_rate){
          cost = cost / 2;
        };
        $scope.request_cost = cost.toFixed(2);
        cost = String(cost.toFixed(2));
        cost = cost.replace('.',',');
        if($scope.isInsert){
          $scope.financialRequest.request_cost = cost;
        };
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
      var cost = String(data.request_cost);
      cost = cost.replace('.',',');
      $scope.financialRequest = {
        representative_user_id: data.representative_user_id,
        bank_account_id: data.bank_account_id,
        payment_type_id: data.payment_type_id,
        document_template_id: data.document_template_id,
        rate_id: data.rate_id,
        request_cost: cost,
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
      $scope.countRequestCost(data.request_id);      
      $scope.getRates(data.rate_id, data);
    }else{
      $scope.receiptDate = new Date ();
    };
    $scope.getPaymentTypes();
    
    $scope.setValue = function(value){
      if(value){
        $scope.financialRequest.payment_date = value;
      };
    };
        
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
    
    if(!$scope.isInsert){
    network.get('document_template', {payment_id: data.payment_type_id}, function (result, response) {
      if(result) {
        $scope.paymentTemplates = response.result;
      };
    });
    };
    
    function getPerformerUsers (request_id){
      network.get('user', {type: 't', relation_id: request_id}, function (result, response) {
        if (result) {
          $scope.performerUsers = response.result;
          $scope.selectRepresentativeUser = Utils.getRowById(response.result, $scope.financialRequest.representative_user_id);            
        };
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
      var cost = String($scope.request_cost);
      cost = cost.replace('.',',');
      $scope.financialRequest.request_cost =  cost;
    };
    
    $scope.updateTemplates = function(payment_id){
      delete $scope.financialRequest.document_template_id;
      delete $scope.financialRequest.request_cost;
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
    
    $scope.onSelectYear = function (){
      delete $scope.financialRequest.bank_account_id;
      delete $scope.IBAN;
    };
    
    $scope.updateIBAN = function (item){
      $scope.IBAN = item;
    };
    
    $scope.updateBankDetails = function(performer_id, request_id, request){
      $timeout(function(){
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
      });      
    };
    
    $scope.checkCost = function (request_cost, payment_type) {
      if(payment_type == 1 && request_cost){
        $scope.error = false;
        var cost = request_cost.replace(',','.');
        if(Number(cost) > Number($scope.request_cost)){
          $scope.error = true;
        };
      };
    };
    
    $scope.checkCostError = function (request_cost, fin_request_cost) {      
      if(fin_request_cost){
        var fin_cost = fin_request_cost.replace(',','.');
      };
      if(Number(fin_cost) != Number(request_cost)){
        return true;
      }else{
        return false;
      };
    };
    
    $scope.fieldError = function(field) {
        var form = $scope.formFinancialRequest;
        return form[field] && ($scope.submited || form[field].$touched) && (form[field].$invalid || form[field].$error.pattern);
    };
    
    $scope.submitFormFinancialRequest = function () {
      $scope.submited = true;
      $scope.formFinancialRequest.$setPristine();
      var request_cost = $scope.financialRequest.request_cost;
      if ($scope.formFinancialRequest.$valid && !$scope.error) {
        var callback = function (result, response) {
          if (result) {
            if(network.user.type != 't'){
              $uibModalInstance.close();
            }else{
              $scope.financialRequestId = $scope.financialRequestId ? $scope.financialRequestId : response.id;
              $scope.financialRequest.status = 1;
              $scope.rights.print = 1;
              $scope.isInsert = false;
              $scope.financialRequest.request_cost = request_cost;
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
        if($scope.rate == $scope.financialRequest.rate_id && !$scope.pair_remember){
          $scope.financialRequest.is_partial_rate = Utils.getRowById($scope.rates, $scope.rate).name;
        };
        if($scope.checkCostError($scope.request_cost, $scope.financialRequest.request_cost)){
          $scope.financialRequest.request_cost = Number($scope.financialRequest.request_cost.replace(',','.'));
        }else{     
          $scope.financialRequest.request_cost = $scope.request_cost;
        }
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
                delete $scope.financialRequest.status;
                $scope.financialRequest.status_id = 4;
                $scope.financialRequest.status_id_pa = 2;
                network.put('financial_request/' + $scope.financialRequestId, $scope.financialRequest, function (result2, response2) {
                  if(result2){
                    $uibModal.open({
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