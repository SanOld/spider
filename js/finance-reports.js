spi.controller('FinanceReportController', function($scope, $rootScope, network, GridService, localStorageService, $uibModal, Utils, SweetAlert, $timeout) {
    $rootScope._m = 'finance_report';
    var d = new Date;
    $scope.defaulFilter = {};
    $scope.years = [];
    $scope.filter = localStorageService.get('finReportFilter', $scope.filter ) || angular.copy($scope.defaulFilter);
    if(!$scope.filter == $scope.defaulFilter ){
      localStorageService.set('finReportFilter', $scope.filter);
    }
    if(network.user.type == 't' && network.user.is_finansist == 0){
      window.location = '/';
    };
    $rootScope.printed = 0;
    $scope.user = network.user;
    
    var grid = GridService();
    $scope.tableParams = grid('finance_report', $scope.filter);
    
    $scope.updateGrid = function() {      
      $scope.setFilter();
      grid.reload();
    };
    
    $scope.checkboxes = {
      checked: false,
      items: {}
    };
    
    $scope.paramsForExport = {
      fileName: 'Finanzberichtliste.csv',
      model: 'finance_report',
      tables: {
        table1: {
          columns: {
            'year'           : 'Jahr',
            'cost_type'      : 'Kostenart',
            'code'           : 'Belegnummer',
            'payment_date'   : 'Zahlungsdatum',
            'report_cost'    : 'Betrag',
            'payer'          : 'Zahler/Empfänger',
            'base'           : 'Grund der Zahlung'
          }
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
       localStorageService.set('finReportFilter', $scope.filter );
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
      $scope.filter.payment_date = year + '-' + month + '-' + day;
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
    
    network.get('finance_report_type', {}, function (result, response) {
      if(result) {
        $scope.reportTypes = response.result;
      };
    });    
       
    network.get('finance_report', {list: 'project'}, function (result, response) {
      if(result) {
        $scope.projects = response.result;
      };
    });    
    
    network.get('finance_report', {list: 'year'}, function (result, response) {
      if(response.result && response.result.length > 0) {
        for(var i = 0; i < response.result.length; i++){
          $scope.years.push(response.result[i].year);
        };          
      };
    });
    
    network.get('performer', {}, function (result, response) {
      if(result) {
        $scope.performers = response.result;
      };
    });
    
    network.get('finance_report_status', {}, function (result, response) {
      if (result) {
        $scope.statuses = response.result;
      };
    });
    
    
    if(network.user.type == 't'){
      network.get('school', {filter: 1, reports: 1}, function (result, response) {
        if (result) {
          $scope.schools = response.result;
        };
      }); 
    };
      
    $scope.canEdit = function(row) {
      if(!row.status) {
        return $rootScope.canEdit();
      } else {
        switch (network.user.type){
          case 't':
            return row.status == 1 || row.status == 2; 
          case 'p':
          case 'a':
            return row.status;
        };
      };
    };
    
    $scope.changeStatus = function(status){
      $scope.report = {};
      var ids = getSelectedIds();
      if (ids.length) {
        switch (status){
          case 'accept':
            $scope.report.status_id = 3;
            $scope.report.status_id_pa = 3;
            $scope.report.status_message = 'accepted';
          break;
          case 'decline':
            $scope.report.status_id = 2;
            $scope.report.status_id_pa = 4;          
            $scope.report.status_message = 'rejected';
          break;
        };
        var failCodes = [];
        var rightCodes = [];
        for(var i = 0; i < ids.length; i++) {
          var row = Utils.getRowById($scope.tableParams.data, ids[i]);
          if(status == 'accept'){
            if(row.status_code != 'in_progress' && row.status_code != 'open') {
              failCodes.push(row.project_code);
            }else{
              rightCodes.push(row.code);
            }; 
          }else{
            if(row.status_code != 'in_progress') {
              failCodes.push(row.project_code);
            }else{
              rightCodes.push(row.code);
            }; 
          }
        };
        if(failCodes.length) {
          SweetAlert.swal({
            title: "Fehler",
            text: "Belege (" + failCodes.join(', ') + ") können nicht aktualisiert sein",
            type: "error",
            confirmButtonText: "OK"
          });
          return false;
        }else{
          if(status == 'decline'){
            var modalInstance = $uibModal.open({
              animation: true,
              templateUrl: 'declineReport.html',
              controller: 'DeclineReportController',
              size: 'custom-width-finance-report-duration',
              resolve: {
                ids: function () {
                  return rightCodes;
                }                
              }
            });
            modalInstance.result.then(function (report) {
              $scope.report.comment = report.comment;
              network.patch('finance_report', angular.extend({ids: ids}, $scope.report), function(result) {
                if(result) {
                  grid.reload();
                  $scope.checkboxes.items = {};
                };
              });
            });
          }else{                
            SweetAlert.swal({
              title: "Sicher?",
              text: "Belege können nicht mehr geändert werden!",
              type: "warning",
              confirmButtonText: "OK!",
              showCancelButton: true,
              cancelButtonText: "ABBRECHEN",
              closeOnConfirm: true
            }, function(isConfirm){
              if(isConfirm){
                network.patch('finance_report', angular.extend({ids: ids}, $scope.report), function(result) {
                  if(result) {
                    grid.reload();
                    $scope.checkboxes.items = {};
                  };
                });
              }
            })
          };
        };
      };
    };   
    
    $scope.openEdit = function (row, modeView) {
      grid.openEditor({
        data: row,
        hint: $scope._hint,
        modeView: !!modeView,
        controller: 'EditFinanceReportController'
      }, function(){
        $timeout(function(){  
          grid.reload();
        });
      });
    };
        
});

spi.controller('EditFinanceReportController', function ($scope, modeView, $uibModalInstance, data, network, hint, Utils, SweetAlert, $uibModal, $timeout) {
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.modeView = modeView;
    $scope.user = network.user;
    var project_code = data.code ? data.code.split('/') : '';
    $scope.project_code = project_code[0] || '';
    $scope.financeReportId = data.id;
    $scope.financeReport = {};
    $scope.receiptDate = '';
    $scope.paymentDate = '';
    $scope.error = false;
    $scope.statusMessage = data.status_message;
    $scope.reportStatus = data.status_code;
    $scope.reportComment = data.comment || '';
    $scope.formChanged = false;
    
    $scope.getProjects = function (year, change) {
      $scope.year = year;
      if(change){
        delete $scope.financeReport.request_id;
        delete $scope.project_code;
      };
      network.get('request', {status_id: 5,'year' : year}, function(result, response){
        if(result) {
          $scope.requests = response.result;
        };
      });
    };
    
    $scope.paymentMethodSelect = function(report_type_id){
      network.get('payment_method_type', {report_type_id:report_type_id}, function (result, response) {
        if(result) {
          $scope.paymentMethodTypes = response.result;
        };
      }); 
    };
    
    if(!$scope.isInsert) {
      var cost = String(data.report_cost);
      cost = cost.replace('.',',');
      var chargeable_cost = String(data.chargeable_cost);
      chargeable_cost = chargeable_cost.replace('.',',');
      $scope.financeReport = {
        code: project_code[1],
        request_id: data.request_id,
        report_type_id: data.report_type_id,
        cost_type_id: data.cost_type_id,
        report_cost: cost,
        payer: data.payer,
        base: data.base,
        reference: data.reference,
        payment_method_id: data.payment_method_id,
        chargeable_cost: chargeable_cost,
        reasoning: data.reasoning,
        comment: data.comment
      };
      $scope.getProjects(data.year);
      $scope.receiptDate = new Date (data.receipt_date);
      $scope.paymentDate = new Date (data.payment_date);
      $scope.paymentMethodSelect(data.report_type_id);
      $scope.year = data.year;
    }else{
      $scope.receiptDate = new Date ();
    };
    
    $scope.getDate = function (date) {
      var result = '';
      if(date != '0000-00-00'){
        result = new Date(date);
      };
      return result;
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
    
    $scope.getProjectCode = function(project_code){
      $scope.project_code = project_code;
    };
    
    $scope.submitFormFinanceReport = function(){
      $scope.submited = true;
      $scope.formFinanceReport.$setPristine();
      $timeout(function(){
        if ($scope.formFinanceReport.$valid && !$scope.error) {
          var callback = function (result, response) {
            if (result) {
              if($scope.isInsert && $scope.user.type == 't'){
                $scope.financeReportId = $scope.financeReportId ? $scope.financeReportId : response.id;
                $scope.reportStatus = 'open';
                var report_cost = Number($scope.financeReport.report_cost.replace(',','.')).toFixed(2);
                $scope.financeReport.report_cost = String(report_cost).replace('.',',');
                $scope.isInsert = false;
                $scope.formChanged = true;
              }else{
                $uibModalInstance.close();
              };
            };
            $scope.submited = false;
          };
          delete $scope.financeReport.status_code;
          $scope.financeReport.payment_date = $scope.dateFormat($scope.paymentDate);
          $scope.financeReport.receipt_date = $scope.dateFormat($scope.receiptDate);        
          $scope.financeReport.project_code = $scope.project_code;
          if($scope.isInsert) {
            network.post('finance_report', $scope.financeReport, callback);
          } else {
            if($scope.formChanged || ($scope.user.type == 't' && !$scope.financeReport.is_chargeable)){
              $scope.financeReport.chargeable_cost = $scope.financeReport.report_cost;
            };
            var id = data.id ? data.id : $scope.financeReportId;
            network.put('finance_report/' + id, $scope.financeReport, callback);
          };
        }
      });
    };
    
    $scope.changeStatus = function(status){
      $scope.financeReport.project_code = $scope.project_code;
      switch (status){
        case 'accept':
          delete $scope.financeReport.status_code;
          $scope.financeReport.status_id = 3;
          $scope.financeReport.status_id_pa = 3;
          $scope.financeReport.status_message = 'accepted';
          delete $scope.financeReport.comment;
        break;
        case 'decline':
          delete $scope.financeReport.status_code;
          $scope.financeReport.status_id = 2;
          $scope.financeReport.status_id_pa = 4;          
          $scope.financeReport.status_message = 'rejected';  
        break;
        case 'check':
          delete $scope.financeReport.status_code;
          $scope.financeReport.status_id = 4;
          $scope.financeReport.status_id_pa = 2;          
          $scope.financeReport.status_message = 'in_progress';
        break;
      };
      var id = data.id ? data.id : $scope.financeReportId;
      network.put('finance_report/' + id, $scope.financeReport, function (result, response) {
        if(result){
          $uibModalInstance.close();
        };               
      });
    };
    
    
    network.get('request', {status_id: 5, group: 1}, function(result, response){
      if(result) {
        $scope.years = response.result;
      };
    });
    
    network.get('finance_report_type', {}, function (result, response) {
      if(result) {
        $scope.reportTypes = response.result;
      };
    });
    
    network.get('finance_cost_type', {}, function (result, response) {
      if(result) {
        $scope.costTypes = response.result;
      };
    });
    
    $scope.checkReportCode = function(code){
      if($scope.isInsert){
        network.get('finance_report', {code:code}, function (result, response) {
          if(response.result && response.result.length) {
            $scope.error = true;
          }else{
            $scope.error = false;
          };
        });
      };
      return true;
    };
    
    $scope.checkChargeableCost = function(chargeable_cost, report_cost){
      if(chargeable_cost && report_cost && ($scope.user.type == 'a' || $scope.user.type == 'p')){        
        var chargeable = Number(chargeable_cost.replace(',','.'));
        var report = Number(report_cost.replace(',','.'));
        if(chargeable.toFixed(2) != report.toFixed(2)){
          $scope.financeReport.is_chargeable = 1;
          return true;
        }else{
          $scope.financeReport.is_chargeable = 0;
          return false;
        };
      }
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
    
//    $scope.checkTrainingCost = function(request_id, cost_type_id){
//      if(cost_type_id == ){
//        
//      }
//      var request = Utils.getRowById($scope.requests, request_id);
//      network.get('finance_report', {request_id:request_id, }, function (result, response) {
//        if(result) {
//          i
//        }
//      });
//    };
    
    $scope.fieldError = function(field) {
        var form = $scope.formFinanceReport;
        return form[field] && ($scope.submited || form[field].$touched) && (form[field].$invalid);
    };

    $scope.$on('modal.closing', function(event, reason, closed) {
      Utils.modalClosing($scope.formFinancialRequest, $uibModalInstance, event, reason);
    });

    $scope.cancel = function () {
      Utils.modalClosing($scope.formFinancialRequest, $uibModalInstance);
    };

});

spi.controller('DeclineReportController', function ($scope, ids, $uibModalInstance, network) {
  $scope.report = {
    comment: ''
  };
  
  $scope.rightCodes = ids.join(', ');
  
  $scope.submit = function (){
    $uibModalInstance.close($scope.report);    
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
  
});