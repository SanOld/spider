spi.controller('RequestController', function ($scope, $rootScope, network, Utils,Notification, $location, RequestService, SweetAlert, $timeout, $uibModal) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  $scope.requestID = Utils.getIdByPath();
  $scope.projectID = '';
  $scope.requestYear = '';
  $scope.user_type = network.user.type;
  $scope.banToReopen = false;
  $scope.financeStatus = '';
  $scope.conceptStatus = '';
  $scope.goalsStatus = '';
  $scope.isFinansist = ['a', 'p', 'g'].indexOf(network.user.type) !== -1 || (network.user.type == 't' && +network.user.is_finansist);
  $scope.is_bonus_project = true;
  $scope.initall = false;
  $scope.isChangedFinanceForm = false;
  $scope.isChangedConceptForm = false;
  $scope.isChangedGoalsForm = false;
  $scope.isPreviousRequest = false;
  
  $scope.tabs = ($scope.isFinansist || $scope.user_type == 's' ) ? ['project-data', 'finance-plan', 'school-concepts', 'schools-goals'] : ['project-data', 'school-concepts', 'schools-goals'];
  var hash = $location.hash();
  if(hash && $scope.tabs.indexOf(hash) !== -1) {
    $scope.tabActive = $location.hash();
  }

  $scope.setTab = function(name) {
    $location.hash(name);

     //turn on next or back button
     $scope.next = false; 
     $scope.back = false;
     if($scope.tabs.indexOf(name) != 0){
       $scope.back = true;
     }
     if($scope.tabs.indexOf(name) != ($scope.tabs.length-1)){
       $scope.next = true;
     }
  };

  $scope.toTab = function(value){
    var name = $location.hash();
    var index = $scope.tabs.indexOf(name);
    var newname = $scope.tabs[index + value];
    $location.hash(newname);
    $scope.tabActive = $location.hash();
  }
  
  $scope.setFinanceStatus = function(financeStatus){
    $scope.financeStatus = financeStatus;
  };
  $scope.setConceptStatus = function(conceptStatus){
    $scope.conceptStatus = conceptStatus;
  };
  $scope.setGoalsStatus = function(goalsStatus){
    $scope.goalsStatus = goalsStatus;
  };


  $scope.setBonusProject = function(is_bonus_project){
    $scope.is_bonus_project = is_bonus_project;
    if($scope.user_type == 's' && is_bonus_project && hash == 'finance-plan'){
      $location.hash('finance-plan');
      $timeout(function(){
        $scope.tabActive = $location.hash();
      });      
    }
  }
  $scope.setProjectID = function(projectID){
    $scope.projectID = projectID;
    RequestService.setRequestCode($scope.requestYear + ' (' + $scope.projectID + ')');
  };
  $scope.setRequestYear = function(requestYear){
    $scope.requestYear = requestYear;
    RequestService.setRequestCode($scope.requestYear + ' (' + $scope.projectID + ')');
  };

  $scope.checkIfReadyToSend = function(request_data) {
    var goalErors     = RequestService.hasErrorsGoalsForm();   //array[array]
    var conceptErors  = RequestService.hasErrorsConceptForm(); //boolean
    var financeErors  = RequestService.hasErrorsFinanceForm(); //array[]
    var projectUserError = request_data.concept_user_id == '' || !request_data.concept_user_id ? true : false;
    var completed = '';
    if(network.user.is_finansist == '1' || network.user.type == 'p'){      
      if(!financeErors.length && ($scope.financeStatus != 'accepted' && $scope.financeStatus != 'in_progress')){
        completed += 'Finanzplan, ';
      }else if(financeErors.length){
        RequestService.setErrorsFinanceForm(true);
      }
    }
    if(!conceptErors && ($scope.conceptStatus != 'accepted' && $scope.conceptStatus != 'in_progress')){
      completed += 'Konzept, ';
    }else if(conceptErors){
      RequestService.setErrorsConceptForm();
    }
    if(!goalErors.length && ($scope.goalsStatus != 'accepted' && $scope.goalsStatus != 'in_progress')){
      completed += 'Entwicklungsziele, ';
    }else if(goalErors.length){
      RequestService.setErrorsGoalsForm(true);
    };
    if(projectUserError){
      RequestService.setErrorsProjectForm();
    };
    if(completed.length && network.user.type == 't'){
      completed = completed.substring(0, completed.length - 2);
      Notification.info({title: 'Antragsteile sind fertig ausgefüllt:', message: completed});
    }
  };
  
  $scope.submitRequest = function (changeStatus, formsToSend, reset) {
    changeStatus = changeStatus || false;
    reset = reset || false;

    if(!changeStatus && !reset){
      if(!RequestService.isChangedProjectForm() && !RequestService.isChangedFinanceForm() && !RequestService.isChangedConceptForm() && !RequestService.isChangedGoalsForm()){
         return true;
      }
    };
    
    var data = RequestService.getProjectData();
    var finPlan = RequestService.financePlanData();
    if (finPlan != undefined){
      data = angular.extend(data, finPlan.request);
      delete finPlan.request;      
      data['finance_plan']    = finPlan;
    };
    data['school_concepts'] = RequestService.getSchoolConceptData();
    data['school_goals']    = RequestService.getSchoolGoalData();
    
    if(!reset){
      var data_save = angular.copy(data);
      if(formsToSend && formsToSend.length){
        data_save.status_id = 3;
        if(formsToSend.indexOf('finance') != -1){
          data_save['status_finance'] = 'in_progress';
          if(!RequestService.isChangedFinanceForm() && (data.status_finance =='accepted' || data.status_finance =='in_progress')){
            delete data_save['finance_plan'];
            var index = formsToSend.indexOf('finance');
            delete formsToSend[index];
          }
        }else{
          delete data_save['finance_plan'];
        }    
        if(formsToSend.indexOf('concept') != -1){
          var object_length = 0;
          for(var item in  data_save['school_concepts']){
            if(data_save['school_concepts'][item].status == 'accepted' || data_save['school_concepts'][item].status == 'in_progress'){
              delete data_save['school_concepts'][item];
            }else{
              object_length += 1;
              if(!RequestService.isChangedConceptForm()){
                delete data_save['school_concepts'][item];
                data_save['school_concepts'][item] = { status : 'in_progress'};
              }else{
                data_save['school_concepts'][item].status = 'in_progress';
              }
            }
          };
          if(!object_length){
            delete data_save['school_concepts'];
            var index = formsToSend.indexOf('concept');
            delete formsToSend[index];
          }
        }else{
          delete data_save['school_concepts'];
        }
        if(formsToSend.indexOf('goal') != -1){
          var object_length = 0;
          for(var item in data_save['school_goals']){
            if(data_save['school_goals'][item].status == 'accepted' || data_save['school_goals'][item].status == 'in_progress'){
              delete data_save['school_goals'][item];
            }else{
              if(!RequestService.getSchoolGoalData()){
                if(data_save['school_goals'][item].is_active == '1'){
                  delete data_save['school_goals'][item];
                  data_save['school_goals'][item] = { status : 'in_progress'};
                  object_length += 1;
                }else{
                  delete data_save['school_goals'][item];
                };
              }else{
                if(data_save['school_goals'][item].is_active == '1'){
                  data_save['school_goals'][item].status = 'in_progress';
                  object_length += 1;
                };
              }
            };
          };
          if(!object_length){
            delete data_save['school_goals'];
            var index = formsToSend.indexOf('goal');
            delete formsToSend[index];
          }
        }else{
          delete data_save['school_goals'];      
        };
      }else{
        if(!RequestService.isChangedFinanceForm()){
          delete data_save['finance_plan'];
        };      
        if(!RequestService.isChangedConceptForm()){      
          delete data_save['school_concepts'];
        };
        if(!RequestService.isChangedGoalsForm()){
          delete data_save['school_goals'];
        };      
        RequestService.setChangedProjectForm();
        RequestService.setChangedFinanceForm();
        RequestService.setChangedConceptForm();
        RequestService.setChangedGoalsForm();
      }
      data = data_save;
    }else{
      var data_reset = {
        status_id      : 3,
        status_id_ta   : 6,
        status_finance : data['status_finance'],
        school_concepts: data['school_concepts'],
        school_goals   : data['school_goals']
      };
      if(data['status_finance'] != 'unfinished' && data['status_finance'] != 'rejected'){
        data_reset['status_finance'] = 'in_progress';
      }
      angular.forEach(data['school_concepts'], function(val, key) {
        delete data_reset['school_concepts'][key];
        if(val.status != 'unfinished' && val.status != 'rejected'){
          data_reset['school_concepts'][key] = {
            status: 'in_progress'
          };
        }else{
          data_reset['school_concepts'][key] = {
            status: val.status
          };
        };
      });
      angular.forEach(data['school_goals'], function(val, key) {
        delete data_reset['school_goals'][key];
        if(val.status != 'unfinished' && val.status != 'rejected' && val.is_active == '1'){
          data_reset['school_goals'][key] = {
            status: 'in_progress'
          };
        }else{
          data_reset['school_goals'][key] = {
            status: val.status
          };
        }
      });

      $scope.financeStatus  = $scope.financeStatus != 'unfinished' ? 'in_progress' : $scope.financeStatus;
      $scope.conceptStatus  = $scope.conceptStatus != 'unfinished' ? 'in_progress' : $scope.conceptStatus;
      $scope.goalsStatus    = $scope.goalsStatus != 'unfinished' ? 'in_progress' : $scope.goalsStatus;
      RequestService.setStatusFinanceForm($scope.financeStatus);
      RequestService.setStatusConceptForm($scope.conceptStatus, 'reset');
      RequestService.setStatusGoalForm($scope.goalsStatus, 'reset');
      data = data_reset;
    };
    var financeErors  = angular.copy(RequestService.hasErrorsFinanceForm());
    if(financeErors){
      financeErors = $scope.unique(financeErors);
    };
    if(!financeErors || financeErors.indexOf("Stellenanteil") == -1){
      network.put('request/' + $scope.requestID, data, function(result, response) {
        if(result) {
          if(!reset && !formsToSend){
            $scope.checkIfReadyToSend(data);
          };
          RequestService.afterSave();
          console.log(data.year);
          if(changeStatus && data.status_id == 5){
            network.post('finance_report', {overhead_cost: true, request_id: data.id, request_year: $scope.requestYear}, function(result, response) {});
          };            
        };
      });
    }else{
      SweetAlert.swal({
        title: "Fehler",
        text: "Field(s) Stellenanteil kann nicht null sein.",
        type: "error",
        confirmButtonText: "OK"
      });
    };   
  };

  $scope.block = function ()  {
    Utils.doDeactivateConfirm(function() {
      network.put('request/' + $scope.requestID,{'status_id':2}, function (result) {
        if (result) {
          Utils.deactivateSuccess(function(){            
            location.href = '/requests';
          });
        }
      });
    });
  };
  
  $scope.remove = function () {
    Utils.doConfirm(function() {
      network.delete('request/' + $scope.requestID, function (result) {
        if (result) {
          Utils.deleteSuccess();
          history.back();
        }
      });
    });
  };
  $scope.cancel = function () {
    if(RequestService.isChangedProjectForm() || RequestService.isChangedFinanceForm() || RequestService.isChangedConceptForm() || RequestService.isChangedGoalsForm()){
       Utils.modalClosing($scope.form, '', '', '', '/requests');
    } else {
      location.href = '/requests'; 
    }  
  };

  RequestService.canEdit = function () {
    var result = true;
    var request = RequestService.getProjectData();
    if(request){
      var result1 = (['2','4','5'].indexOf(request.status_id) === -1);
      var result2 = (['a','p','t'].indexOf($scope.user_type) !== -1);
      result = result1 && result2;
    }
      

    return result;
  }
  RequestService.sendMSG = function(callback){

    SweetAlert.swal({
      title: "Sind Sie sicher, dass Sie diesen Teile des Antrags zur Prüfung übermitteln möchten?",
      text: "Wenn Sie den Antragsteil noch nicht übermitteln wollen, verwenden Sie die Speichern Schaltfläche, um den aktuellen Bearbeitungsstand zu sichern.",
      type: "warning",
      confirmButtonText: "Ja, senden",
      showCancelButton: true,
      cancelButtonText: "Abbrechen",
      closeOnConfirm: true,
      closeOnCancel: true
    }, function(isConfirm){
      if(isConfirm) {
        callback();
      }
    });

  };
  RequestService.acceptMSG = function(callback){
    callback = callback || function(){};
     SweetAlert.swal({
      title: "Ist die Prüfung abgeschlossen?",
      text: "",
      type: "warning",
      confirmButtonText: "Ja, senden",
      showCancelButton: true,
      cancelButtonText: "Abbrechen",
      closeOnConfirm: true,
      closeOnCancel: true
    }, function(isConfirm){
      if(isConfirm) {
        callback();
      } 
    });

  };

  $scope.canEdit  = function (){
    return  RequestService.canEdit();
  }

  $scope.userCan = function(type) {

    var results = false;
    var user = network.user.type;
    var is_finansist = network.user.is_finansist;
    var status = 'none';
    var status_id;
    var request = RequestService.getProjectData();
    var concept = RequestService.getSchoolConceptData();
    var goals = RequestService.getSchoolGoalData();     
    var finPlan = RequestService.financePlanData();
    var show_button_reopen = false;
    for(var item in concept){
      if(concept[item].status == 'accepted'){
        show_button_reopen = true;
        break;
      };
    };
    if(finPlan){
      if(finPlan.request.status_finance == 'accepted'){
        show_button_reopen = true;
      };
    }
    for(var item in goals){
      if(goals[item].status == 'accepted'){
        show_button_reopen = true;
        break;
      };
    };
    
    if(request) {
      status = request.status_code;
      status_id = request.status_id;

      switch(type) {
        case 'reopen':;
          results = (user == 'a' && ((status == 'accept' || status == 'decline' || status == 'acceptable') || show_button_reopen));
          break;
        case 'delete':;
          results = (user == 'a' && status != 'accept' && status != 'decline');
          break;
        case 'changeStatus_print':;
          results = ((user == 'a' || user == 'p') &&  status != 'accept' && status != 'decline'  && status != 'acceptable' );
        break;
        case 'changeStatus_lock':;
          results = ((user == 'a' || user == 'p') && status == 'acceptable' );
        break;
        case 'save':;
          results = ((user == 'a' || user == 'p' || user == 't') && status != 'accept' && status != 'decline');
          break;
        case 'send':;
          results = (((($scope.financeStatus == 'unfinished' || $scope.financeStatus == 'rejected') && is_finansist == '1')   
                    ||($scope.conceptStatus == 'unfinished' || $scope.conceptStatus == 'rejected')   
                    ||($scope.goalsStatus == 'unfinished'   || $scope.goalsStatus == 'rejected')  ) && user == 't' && status != 'decline');
          break;
        case 'copyData':;
          results = ((user == 't') &&  status != 'accept' && status != 'decline'  && status != 'acceptable' && $scope.isPreviousRequest
                    && $scope.conceptStatus != 'in_progress' && $scope.conceptStatus != 'accepted'
                    && $scope.goalsStatus != 'in_progress' && $scope.goalsStatus != 'accepted');
          break;
      } 

    }

    return results;
  };
  
  $scope.unique = function(arr){
    var equal = false;
    var array = arr;
    var reg = /.+[0-9]/;
    array.forEach(function(item, i, arr){
      if(item.match(reg)){
        equal = true;
        array[i] = item.split('-');
        array[i] = array[i][0];
      };
    });
    if(equal){
      var result = [];
      nextInput:
      for (var i = 0; i < arr.length; i++) {
        var str = arr[i];
        for (var j = 0; j < result.length; j++) {
          if (result[j] == str) continue nextInput; 
        }
        result.push(str);
      }
      return result;
    }else{
      return arr;
    }  
  };

  $scope.doErrorIncompleteFields = function(fields) {
    var arr_fields = angular.copy(fields);
    if(arr_fields){      
      arr_fields = $scope.unique(arr_fields);      
    };
    
    var text = '';
    if(arr_fields) {
      text = "\n\n" + arr_fields.join("\n")
    }
    SweetAlert.swal({
      html:true,
      title: "Fehler",
      text: "Bitte füllen Sie alle Felder aus"+text,
      type: "error",
      confirmButtonText: "OK"
    });
    return false;
  };

  $scope.doErrorIncompleteField = function(field) {
    SweetAlert.swal({
      title: "Fehler",
      text: "Bitte füllen " + field,
      type: "error",
      confirmButtonText: "OK"
    });
    return false;
  }

  $scope.setBulkStatus = function(statusId) {


    var data = RequestService.getFullProjectData();
    var request_data = RequestService.getProjectData();
    var projectUserError = request_data.concept_user_id == '' || !request_data.concept_user_id ? true : false;
    
    var required = {
                  'doc_target_agreement_id': 'Druck-Template: Zielvereinbarung'
                , 'doc_request_id': 'Druck-Template: Antrag'
                , 'doc_financing_agreement_id': 'Druck-Template: Fördervertrag'
                , 'finance_user_id': 'Ansprechperson für Rückfragen zum Finanzplan'
                , 'concept_user_id': 'Ansprechperson für Rückfragen zum Konzept'
                , 'start_date': 'Beginn:'
                , 'due_date': 'Ende:'
    };


    var failFields = [];
    if(statusId == 4 || statusId == 5){

      for(var key in required){
        if(!request_data[key]){
          failFields.push(required[key]);
        }
      }
    }

    var failCodes = [];
    switch (statusId) {
    case 5:
      if(request_data.status_id < 4){
        failCodes.push(data.code);
      }
      break;
    case 4:
      var partStatus = ($scope.conceptStatus != 'accepted' || $scope.financeStatus != 'accepted' || $scope.goalsStatus != 'accepted');
      if(partStatus && request_data.status_id != '2') {
        failCodes.push(data.code);
      }
      break;
    }

      if(failFields.length) {
        SweetAlert.swal({
          title: "Fehler",
          text: "Der Antrag ist nicht vollständig. Bitte ergänzen: \n "+failFields.join(',\n '),
          type: "error",
          confirmButtonText: "OK"
        }, function(isConfirm){
          if(isConfirm && projectUserError) {
            RequestService.setErrorsProjectForm();
          };
        });
        return false;
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

      SweetAlert.swal({
        title: "Sind Sie sicher?",
        text: "Möchten SIe den Status des Antrags wirklich ändern?",
        type: "warning",
        confirmButtonText: "JA",
        showCancelButton: true,
        cancelButtonText: "NEIN",
        closeOnConfirm: true
      }, function(isConfirm){
        if(isConfirm) {
          request_data.status_code = 'in_progress';
          var oldStatus = request_data.status_id;
          request_data.status_id = statusId;
          switch(statusId){
            case 3:;
              request_data.status_code = 'in_progress';
              request_data.status_id = statusId;
              if(oldStatus == 5 || oldStatus == 4){
                network.get('user_lock', {request_id: request_data['id']},function(result, response){
                  if(result){
                    for(var key in response.result){
                      network.delete('user_lock/'+response.result[key]['id']);
                    }
                  }
                });
              };
              $scope.submitRequest(true,[], true);
              return true;
              break;
            case 4:;
              request_data.status_code = 'acceptable';
              request_data.status_id = statusId;
              request_data.status_id_ta = statusId;
              break;
            case 5:;
              request_data.status_code = 'accept';
              request_data.status_id = statusId;
              request_data.status_id_ta = statusId;
              break;
          }

          $scope.submitRequest(true);

        }
      });
    

  };

  $scope.checkPreviousRequest = function(){
    var params = {
       project_code: $scope.projectID
      , year: ($scope.requestYear-1)
    };
    network.get('request', params, function(result, response) {
      if(result && response['result'].length > 0) {
        $scope.isPreviousRequest = true;
      }
    });
  }

  $scope.copyData = function(){
    if($scope.isPreviousRequest){
        SweetAlert.swal({
          html:true,
          title: "Daten vom Vorjahr übernehmen",
          text: "Konzept und Entwicklungsziele\n\
            werden aus dem Antrag (" + ($scope.requestYear-1) +") " + $scope.projectID + " kopiert.\n\
            Die vorhandenen Daten werden übergeschrieben",
          type: "warning",
          confirmButtonText: "OK",
          showCancelButton: true,
          cancelButtonText: "ABBRECHEN",
        },function(isConfirm){
          if (isConfirm) {
            var params = {
              request_id: $scope.requestID
              , project_code: $scope.projectID
              , year: ($scope.requestYear-1)
              , copyDataConceptGoal: true
            }
            network.post('request', params, function(result) {
              if(result) {
                 $timeout(function(){
                 RequestService.updateSchoolConcept();
                 RequestService.updateSchoolGoal();
               });
              }
            });
          }
        });
      }
  };
  
  $scope.sendToAccept = function() {
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: 'sendToAccept.html',
      controller: 'SendToAcceptController',
      size: 'custom-width-request-send-duration'
    });
    modalInstance.result.then(function (formsToSend) {
      if(formsToSend && formsToSend.length){
        if(formsToSend.indexOf('finance') != -1){
          $scope.setFinanceStatus('in_progress');
          RequestService.setStatusFinanceForm('in_progress');
        };
        if(formsToSend.indexOf('concept') != -1){
          $scope.setConceptStatus('in_progress');
          RequestService.setStatusConceptForm('in_progress', 'accept');
        };
        if(formsToSend.indexOf('goal') != -1){
          $scope.setGoalsStatus('in_progress');
          RequestService.setStatusGoalForm('in_progress', 'accept');
        };
      };
    });
  };
    
  $scope.checkIfCanNewOpen = function (){
    if($scope.userCan('reopen')){
      network.get('project', {request_id: $scope.requestID}, function(result, response){
        if(response.result[0].is_old == '1') {
          $scope.banToReopen = true;
        };
      });
      network.get('financial_request', {request_id: $scope.requestID}, function(result, response){
        if(response.result.length) {
          $scope.banToReopen = true;
        };
      });
    }
  };
  $timeout(function(){    
    $scope.checkIfCanNewOpen();
  });
  
    
  $scope.$on('sendToAccept', function(event,status, pages){
      $scope.submitRequest(status, pages);
    });
});

spi.controller('RequestProjectDataController', function ($scope, network, Utils, $uibModal, SweetAlert, RequestService, localStorageService, $timeout) {
  $scope.filter = {id: $scope.$parent.requestID};
  $scope.isInsert = !$scope.$parent.requestID;
  $scope.udater = 0;
  localStorageService.set('dataChanged', 0);
  $scope.add_project_user = false;
  $scope.dublicate = false;
  $scope.required = false;
  $scope.userLoading = false;
  $scope.canFormEdit = ['a','p'].indexOf(network.user.type) !== -1;
  $scope.user_type = network.user.type;
  $scope.concept_user_error = false;
  $scope.addNewConceptUser = function(){      
    $scope.dublicate = false;
    $scope.required = false;
    if(!$scope.add_project_user){
      $scope.add_project_user = true;
      $timeout(function(){       
        angular.element('#project_user').focus();   
      });
    }else{
      $scope.add_project_user = false;
      $scope.new_project_user = ""; 
    }      
  }
    
  $scope.length_schools = function(schools){
    var length = 0;
    for (var i in schools) {
      if (schools.hasOwnProperty(i)) {
        length ++;
      };
    };
    return length;
  };

  $scope.canEdit  = function (){
    return  RequestService.canEdit();
  }
  
  $scope.escape = function(event){
    if(event.which == 27){
      $scope.addNewConceptUser();     
    };  
  }  
  
  $scope.submitToAddUser = function(event, new_project_user){
    $scope.required = false;  
    $scope.dublicate = false; 
    if(event.which == 13 || event.type == 'click'){
      if(!new_project_user){
        $scope.required = true;  
      }else{
        $scope.userLoading = true; 
        var name = new_project_user.split(/[\s,\.]+/);      
        if(name.length > 2){
          var last_name = "";
          for(var i = 1; i < name.length; i++){
            last_name = last_name + " " + name[i];  
          };  
        }else{
          var last_name = name[1] || "";  
        };
        $scope.performerUsers.forEach(function(item, i, arr){
          if(item.first_name.toUpperCase() == name[0].toUpperCase() && item.last_name.toUpperCase() == last_name.toUpperCase()){
            $scope.dublicate = true;          
            $scope.userLoading = false;
          }  
        });  
        if(!$scope.dublicate){
          $scope.new_concept_user = {
            first_name: name[0],
            last_name: last_name,
            sex: 3,
            is_virtual: 1,
            type_id: 3,
            email: $scope.user.email,
            type: 't',
            password: '',
            relation_id: $scope.request.performer_id
          };
          var callback = function (result, response) {
            if (result) {
              $scope.request.concept_user_id = response.id;
              $scope.getPerformerUsers();   
              $scope.new_project_user = "";              
              $scope.add_project_user = false;
              $scope.userLoading = false;
            } else {
              $scope.error = getError(response.system_code);
              $scope.userLoading = false;
            }         
          };
          network.post('user', $scope.new_concept_user, callback); 
        }  
      };      
    };  
  }  
  
  $scope.userCan = function(type) {
    var user = network.user.type;
    var results = false;
    if($scope.request) {
      switch(type)  {
        case 'dates':;
        case 'templates':;
          results = ((user == 'a' || user == 'p') && $scope.request.status_code != 'accept' && $scope.request.status_code != 'decline');
          break;
        case 'additional_info':
          results = ((user == 'a' ||  user == 't') && $scope.request.status_code != 'accept' && $scope.request.status_code != 'decline' && $scope.request.status_code != 'acceptable');
        case 'users':;
          results = ((user == 'a' || user == 'p' || user == 't') && $scope.request.status_code != 'accept' && $scope.request.status_code != 'decline' && $scope.request.status_code != 'acceptable');
          break;
        case 'senat_additional_info':;
          results = ((user == 'a' || user == 'p') && $scope.request.status_code != 'accept' && $scope.request.status_code != 'decline' && $scope.request.status_code != 'acceptable');
          break;
      }
    }
    return results;
  }

  $scope.getDate = function (date) {
    var result = '';
    if(date){
      result = new Date(date);
    }
    return result;
  }

  $scope.getData = function() {
    network.get('request', $scope.filter, function (result, response) {
      if (result) {
        if(response.result.performer_homepage && !response.result.performer_homepage.match('^http[s]?')){
          response.result.performer_homepage = 'http://' + response.result.performer_homepage;
        };
        for(var school in response.result.schools){
          if(response.result.schools[school].homepage && !response.result.schools[school].homepage.match('^http[s]?')){
            response.result.schools[school].homepage = 'http://' + response.result.schools[school].homepage;
          };
        };
        if(response.result.district_homepage && !response.result.district_homepage.match('^http[s]?')){
          response.result.district_homepage = 'http://' + response.result.district_homepage;
        };
        $scope.data = response.result;

        $scope.$parent.setProjectID($scope.data.code);
        $scope.$parent.setRequestYear($scope.data.year);
        $scope.$parent.setBonusProject($scope.data.is_bonus_project);
        $scope.$parent.checkPreviousRequest();
       
        $scope.request = {
          id:                             response.result.id,
          doc_target_agreement_id:        response.result.doc_target_agreement_id,
          doc_request_id:                 response.result.doc_request_id,
          doc_financing_agreement_id:     response.result.doc_financing_agreement_id,
          request_user_id:                response.result.request_user_id != 0 ? response.result.request_user_id : '',
          concept_user_id:                response.result.concept_user_id != 0 ? response.result.concept_user_id : '',
          finance_user_id:                response.result.finance_user_id != 0 ? response.result.finance_user_id : '',
          additional_info:                response.result.additional_info,
          senat_additional_info:          response.result.senat_additional_info,
          start_date:                     response.result.start_date,
          due_date:                       response.result.due_date,
          end_fill:                       response.result.end_fill,
          last_change:                    response.result.last_change,
          performer_id:                   response.result.performer_id,
          status_code:                    response.result.status_code,
          status_id:                      response.result.status_id
        };
        
        if(response.result.status_id == '5' || response.result.status_id == '4'){
        
         network.get('User', {type: 't', relation_id: $scope.request.performer_id}, function (result, response) {
            if (result) {
              $scope.performerUsers = response.result;
              for (var key in $scope.performerUsers){
                if($scope.performerUsers[key].sex == 1){$scope.performerUsers[key].gender = 'Herr'}
                if($scope.performerUsers[key].sex == 2){$scope.performerUsers[key].gender = 'Frau'}
              }
              $scope.selectRequestResult = Utils.getRowById(response.result, $scope.request.request_user_id);
              $scope.selectConceptResult = Utils.getRowById(response.result, $scope.request.concept_user_id);
              $scope.selectFinanceResult = Utils.getRowById(response.result, $scope.request.finance_user_id);

              network.get('user_lock', {type: 't', relation_id: $scope.request.performer_id, request_id: $scope.request.id}, function (result, response) {
                      if (result) {
                        $scope.performerUsersLock = response.result;

                        //To Do change data
                        for (var i = 0; i < $scope.performerUsers.length; i++) {
                          for (var y = 0; y < $scope.performerUsersLock.length; y++) {
                            delete $scope.performerUsersLock[y]['id'];
                            if( $scope.performerUsers[i]['id'] == $scope.performerUsersLock[y]['user_id'] ){
                                for(var key in $scope.performerUsersLock[y]){
                                  if($scope.performerUsers[i][key] != undefined){
                                    $scope.performerUsers[i][key] = $scope.performerUsersLock[y][key];
                                  }
                                }
                            }
                          }
                        }

                        $scope.data['users'] = $scope.performerUsers;
                        RequestService.initAll($scope.data);
                      } else {
                        $scope.data['users'] = $scope.performerUsers;
                        RequestService.initAll($scope.data);
                      }
                    });
            }
          });


        } else {
          $scope.getPerformerUsers();
        }
        $timeout(function(){
          if($scope.length_schools($scope.data.schools) == 1){
            var id = 0;
            for(var item in $scope.data.schools){
              id = item;
            };
            $('._' + id + '_').trigger('click');
          }  
        });     
      }
    });
  }
  $scope.getPerformerUsers = function(){
       network.get('User', {type: 't', relation_id: $scope.request.performer_id}, function (result, response) {
          if (result) {
            $scope.performerUsers = response.result;
            for (var key in $scope.performerUsers){
              if($scope.performerUsers[key].sex == 1){$scope.performerUsers[key].gender = 'Herr'}
              if($scope.performerUsers[key].sex == 2){$scope.performerUsers[key].gender = 'Frau'}
            }
            $scope.selectRequestResult = Utils.getRowById(response.result, $scope.request.request_user_id);
            $scope.selectConceptResult = Utils.getRowById(response.result, $scope.request.concept_user_id);
            $scope.selectFinanceResult = Utils.getRowById(response.result, $scope.request.finance_user_id);
            $scope.data['users'] = $scope.performerUsers;
            RequestService.initAll($scope.data);
          }
        });         
    };
  $scope.updateData = function() {
    network.get('request', $scope.filter, function (result, response) {
      if (result) {
        $scope.newData = response.result;

        $scope.data.performer_name =              $scope.newData.performer_name
        $scope.data.performer_is_checked =        $scope.newData.performer_is_checked
        $scope.data.performer_checked_by =        $scope.newData.performer_checked_by
        $scope.data.performer_contact =           $scope.newData.performer_contact
        $scope.data.performer_contact_function =  $scope.newData.performer_contact_function
        $scope.data.performer_address =           $scope.newData.performer_address
        $scope.data.performer_plz =               $scope.newData.performer_plz
        $scope.data.performer_city =              $scope.newData.performer_city
        $scope.data.performer_homepage =          $scope.newData.performer_homepage
        $scope.data.performer_phone =             $scope.newData.performer_phone
        $scope.data.performer_fax =               $scope.newData.performer_fax
        $scope.data.performer_email =             $scope.newData.performer_email

        $scope.data.schools =            $scope.newData.schools

        $scope.data.district_name =     $scope.newData.district_name
        $scope.data.district_contact =  $scope.newData.district_contact
        $scope.data.district_address =  $scope.newData.district_address
        $scope.data.district_plz =      $scope.newData.district_plz
        $scope.data.district_city =     $scope.newData.district_city
        $scope.data.district_phone =    $scope.newData.district_phone
        $scope.data.district_fax =      $scope.newData.district_fax
        $scope.data.district_email =    $scope.newData.district_email

      }
    });
  }

  $scope.getData();

  network.get('document_template', {}, function (result, response) {
    if (result) {
      $scope.documentTypes = response.result;
    }
  });

  RequestService.updateFinansistPD = function(id){
    $scope.request.finance_user_id = id;
    $scope.selectFinanceResult = Utils.getRowById($scope.performerUsers, $scope.request.finance_user_id);
  }

  $scope.onSelectCallback = function (item, model, type){
    switch (type){
      case 1:
        $scope.selectRequestResult = item ;
        break;
      case 2:
        $scope.selectConceptResult = item ;
        break;
      case 3:
        $scope.selectFinanceResult = item ;
        RequestService.updateFinansistFP($scope.request.finance_user_id)
        break;
    }
  };

  $scope.setBulkDuration = function() {

    var ids = [];
    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: 'setDuration.html',
      controller: 'ModalDurationController',
      size: 'custom-width-request-duration',
      resolve: {
        ids: function () {
          ids = [$scope.request.id];
          return ids;
        },
        start_date: function () {
          return $scope.request.start_date;
        },
        due_date: function () {
          return $scope.request.due_date;
        },
        end_fill: function () {
          return $scope.request.end_fill;
        }
      }
    });

    if ($scope.request.id) {
      modalInstance.result.then(function (data) {

        var start = isNaN(data.start_date) ? '' : Utils.getSqlDate(new Date(data.start_date));
        var end = isNaN(data.due_date) ? '' : Utils.getSqlDate(new Date(data.due_date)) ;

        $scope.request.start_date = start;
        $scope.request.due_date = end;

        $scope.submitRequest(true);
      });

    }
  };

  $scope.setEndFillDate = function() {

    var modalInstance = $uibModal.open({
      animation: true,
      templateUrl: 'setEndFill.html',
      controller: 'ModalEndFillController',
      size: 'custom-width-request-duration',
      resolve: {
        ids: function () {
          ids = [$scope.request.id];
          return ids;
        },
        start_date: function () {
          return $scope.request.start_date;
        },
        due_date: function () {
          return $scope.request.due_date;
        },
        end_fill: function () {
          return $scope.request.end_fill;
        }
      }
    });

    if ($scope.request.id) {
      modalInstance.result.then(function (data) {

        var end_fill = isNaN(data.end_fill) ? '' : Utils.getSqlDate(new Date(data.end_fill));

        $scope.request.end_fill = end_fill;

        $scope.submitRequest(true);

      });
    }
  };
  
  $scope.checkProjectError = function(){
    RequestService.setErrorsProjectForm();
  };

  RequestService.getProjectData = function() {
    return $scope.request;
  };

  RequestService.getFullProjectData = function() {
    return $scope.data;
  };

  window.onfocus = function() {
    if (localStorageService.get('dataChanged') === '1'){
      $scope.updateData();
      localStorageService.set('dataChanged', 0);
    }
  }

  RequestService.isChangedProjectForm = function(){
    return $scope.projectData.$dirty;
  }
  
  RequestService.setErrorsProjectForm = function(){
    if(!$scope.request.concept_user_id){
      return $scope.concept_user_error = true;
    }
    return $scope.concept_user_error = false;    
  }

  RequestService.setChangedProjectForm = function(){
    $scope.projectData.$setPristine();
  }
  
  RequestService.getChangedProjectFields = function(){
    var changed_fields = [];
    for(var field in $scope.projectData){
      if(!field.match(/^\$.+/)){
        if($scope.projectData[field].$dirty){
          changed_fields.push(field);
        };
      };
    };
    return changed_fields;
  };

});

spi.controller('RequestFinancePlanController', function ($scope, network, RequestService, Utils, $timeout) {
  $scope.users = [];
  $scope.IBAN = {};
  $scope.request_users = [{}]; //create one user by default
  $scope.prof_associations = [{}]; //create one association by default
  $scope.financeSchools = [];
  $scope.add_finance_user = false;
  $scope.add_employee_user = false;
  $scope.dublicate = [false];
  $scope.required = [false];  
  $scope.userLoading = false;
  $scope.errorShow = false;
  $scope.errorArray = [];

  $scope.canAccept = ['a','p'].indexOf(network.user.type) !== -1;
  $scope.canFormEdit = ['a','t'].indexOf(network.user.type) !== -1;
  $scope.comment = '';

  $scope.canEdit  = function (){
    return  RequestService.canEdit();
  }
  
  $scope.canAcceptEarly = function(status) {
    return !(network.user.type == 'p' && status != 'in_progress');
  };

  $scope.escapeFinanceUser = function(event){
    if(event.which == 27 ){      
      $scope.addNewFinanceUser();        
    };
  } 
  
  $scope.escapeEmployeeUser = function(event, idx){
    if(event.which == 27 ){
      $scope.addNewEmployeeUser(idx);             
    };  
  }
  
  $scope.addNewFinanceUser = function(){
    $scope.dublicate['finance'] = false;
    $scope.required['finance'] = false;
    if(!$scope.add_finance_user){
      $scope.add_finance_user = true;
      $timeout(function(){       
        angular.element('#finance_user').focus();   
      });
    }else{
      $scope.add_finance_user = false;      
      $scope.new_fina_user = "";
    }      
  }
  $scope.addNewEmployeeUser = function(idx){
      $scope.dublicate['employee'] = false;
      $scope.required['employee'] = false;
      if(!$scope.add_employee_user){
        $scope.add_employee_user = true;
        $timeout(function(){       
          angular.element('#employee_user').focus();   
        });
      }else{
        $scope.add_employee_user = false;     
        $scope.request_users[idx].new_user_name = "";
      }              
  }
  $scope.getPerformerUsers = function(callback){
    network.get('User', {type: 't', relation_id: $scope.data.performer_id}, function (result, response) {
      if (result) {        
        $scope.users = response.result;
        $scope.updateUserSelect();
        $scope.selectFinanceResult = Utils.getRowById(response.result, $scope.data.finance_user_id);
        callback = callback || function(){};
        callback();
      }
    });         
  };
    
  $scope.getEmployeeUsers = function(id,emploee, callback){
    network.get('User', {type: 't', relation_id: $scope.data.performer_id}, function (result, response) {
      if (result) {
        $scope.users = response.result;
        emploee.user = Utils.getRowById($scope.users, id);
        $scope.employeeOnSelect(emploee.user, emploee); 
        callback = callback || function(){};
        callback();
      }
    });         
  };
  
  $scope.submitToAddUser = function(event, new_finance_user){    
    $scope.dublicate['finance'] = false;
    $scope.required['finance'] = false;
    if(event.which == 13 || event.type == 'click'){
      if(!new_finance_user){
        $scope.required['finance'] = true;
      }else{
        $scope.userLoading = true;  
        var name = new_finance_user.split(/[\s,\.]+/);      
        if(name.length > 2){
          var last_name = "";
          for(var i = 1; i < name.length; i++){
          last_name = last_name + " " + name[i];  
          };  
        }else{
          var last_name = name[1] || "";  
        };
        $scope.users.forEach(function(item, i, arr){
          if(item.first_name.toUpperCase() == name[0].toUpperCase() && item.last_name.toUpperCase() == last_name.toUpperCase()){
            $scope.dublicate['finance'] = true;
            $scope.userLoading = false;
          }
        });             
        if(!$scope.dublicate['finance']){     
          $scope.new_finance_user = {
            first_name: name[0],
            last_name: last_name,
            sex: 3,
            is_virtual: 1,
            is_finansist: 1,
            type_id: 3,
            email: network.user.email,
            type: 't',
            password: '',
            relation_id: $scope.data.performer_id
        };
        var callback = function (result, response) {
          if (result) {
            $scope.data.finance_user_id = response.id;
            $scope.getPerformerUsers(function(){});
            $scope.add_finance_user = false; 
            $scope.new_fina_user = "";
            $scope.userLoading = false;
          } else {
            $scope.error = getError(response.system_code);
            $scope.userLoading = false;
          }         
        };
          network.post('user', $scope.new_finance_user, callback);         
        }
      }   
    }
  }
  
  $scope.submitToAddUserEmpl = function(event, new_user, idx){
    $scope.collapsingUser = idx;
    $scope.dublicate['employee'] = false;
    $scope.required['employee'] = false;
    if(event.which == 13 || event.type == 'click'){
      if(!new_user){
        $scope.required['employee'] = true;
      }else{        
        $scope.userLoading = true;  
        var name = new_user.split(/[\s,\.]+/);      
        if(name.length > 2){
          var last_name = "";
          for(var i = 1; i < name.length; i++){
            last_name = last_name + " " + name[i];  
          };  
        }else{
          var last_name = name[1] || "";  
        };
        $scope.users.forEach(function(item, i, arr){
          if(item.first_name.toUpperCase() == name[0].toUpperCase() && item.last_name.toUpperCase() == last_name.toUpperCase()){
            $scope.dublicate['employee'] = true;               
            $scope.userLoading = false;
          }  
        });  
        if(!$scope.dublicate['employee']){      
          $scope.new_employee_user = {
            first_name: name[0],
            last_name: last_name,
            sex: 3,
            is_virtual: 1,
            type_id: 3,
            email: network.user.email,
            type: 't',
            password: '',
            relation_id: $scope.data.performer_id
          };     
          var callback = function (result, response) {
            if (result) {
              $scope.getEmployeeUsers(response.id, $scope.request_users[idx], function(){
                $scope.request_users[idx].user_id = response.id;
              });
              $scope.request_users[idx].new_user_name = "";               
              $scope.add_employee_user = false;             
              $scope.userLoading = false;
            } else {
              $scope.error = getError(response.system_code);              
              $scope.userLoading = false;
            }         
          };
          network.post('user', $scope.new_employee_user, callback);
         }  
      }      
    }    
  }
  var usersById = {};

  RequestService.afterSave = function(callback){
    var callback = callback || function(){};
    $scope.updateFinPlanUsers('submit');
    $scope.updateFinPlanProfAssociation();
    callback();
  };
  RequestService.financePlanData = function(){
    var data = {};
    data.request =  { 'revenue_description':    $scope.data.revenue_description
                    , 'revenue_sum':            $scope.data.revenue_sum
                    , 'emoloyees_cost':         $scope.emoloyeesCost
                    , 'training_cost':          $scope.training_cost
                    , 'overhead_cost':          $scope.overhead_cost
                    , 'prof_association_cost':  $scope.prof_association_cost
                    , 'total_cost':             $scope.total_cost
                    , 'bank_details_id':        $scope.data.bank_details_id
                    , 'status_finance':         $scope.data.status_finance
                    , 'is_umlage':              $scope.data.is_umlage
                    , 'finance_user_id':        $scope.data.finance_user_id
                    , 'finance_comment':        $scope.data.comment
                    };
    data.users = $scope.request_users;
    data.prof_associations = $scope.prof_associations;
    data.schools = $scope.financeSchools;
    var finPlan = angular.copy(data);
    angular.forEach(finPlan.users, function(val, key) {
      val.add_cost = val.addCost;
      val.full_cost = val.fullCost;
      delete val.user;
      delete val.addCost;
      delete val.fullCost;
      delete val.name;
      delete val.sex;
      delete val.group_name;
      delete val.remuneration_name;
    });
    angular.forEach(finPlan.schools, function(val, key) {
      delete val.school_name;
      delete val.school_number;
    });
    return finPlan;
  };

  $scope.fieldsError2 = function (model, modelName){

    var name = modelName;
    var result = (model == '' || model == 0 || model == '0' || model == '0,00' || model == undefined);

    var index = $scope.errorArray.indexOf(name);

    if(result && index==-1 && name != undefined ){
      $scope.errorArray.push(name);
    } else if(!result && index != -1) {
      $scope.errorArray.splice(index,1);
    }
    return result;
 }

  $scope.submitForm = function(status) {

    callback = function(){
        data['status_finance'] = status;
        network.put('request/'+$scope.$parent.requestID, data, function(result, response) {
          if(result) {
            $scope.data.status_finance = status;
            $scope.data.finance_comment = status == 'accepted' ? '' : $scope.data.comment;
            $scope.$parent.setFinanceStatus(status);
            RequestService.afterSave(
              function(){
                $timeout(function(){
                  if (network.user.type == 'a') {
                    $scope.$parent.submitRequest();
                  };
                });
              }
            );            
          }
        });
    }
    
    if(['in_progress', 'accepted', 'rejected'].indexOf(status) === -1) return false;
    var data = {};
    switch (status) {
      case 'accepted':
        if($scope.data.comment && $scope.data.comment.length && $scope.data.status_finance != 'rejected') return false;
        $scope.errorShow = true;
        if($scope.errorArray.length){
          return $scope.$parent.doErrorIncompleteFields($scope.errorArray);
        } else {
          $scope.errorShow = false;          
          RequestService.acceptMSG(callback);
        }
        break;
      case 'in_progress':

        var finPlan = RequestService.financePlanData();
        delete finPlan.request;
        data.finance_user_id = $scope.data.finance_user_id;
        data.bank_details_id = $scope.data.bank_details_id;
        data.revenue_description = $scope.data.revenue_description;
        data.revenue_sum = $scope.data.revenue_sum;
        data.finance_plan = finPlan;

        $scope.errorShow = true;
        if($scope.errorArray.length){
          return $scope.$parent.doErrorIncompleteFields($scope.errorArray);
        } else {
          $scope.errorShow = false;          
          RequestService.sendMSG(callback);
        }
        break;
      case 'rejected':
        if(!$scope.data.comment) return false;
        data.finance_comment = $scope.data.comment;
        RequestService.acceptMSG(callback);
        break;
    }
  };

  RequestService.initFinancePlan = function(data){
    $scope.users = data.users;
    $scope.updateUserSelect();
    $scope.data = data;
    $scope.data.is_umlage = $scope.data.is_umlage*1;
    if ($scope.data.finance_user_id == "0") {
      $scope.data.finance_user_id = '';
    }
    if ($scope.data.bank_details_id == "0") {
      $scope.data.bank_details_id = '';
    }
    if ($scope.data.revenue_sum != undefined ) {
      $scope.numValidate2(data,'revenue_sum');
      $scope.numValidate(data,'revenue_sum');
    }
    $scope.$parent.setFinanceStatus(data.status_finance);
    $scope.selectFinanceResult = Utils.getRowById($scope.users, data.finance_user_id);
    $scope.data.comment = data.finance_comment;
    angular.forEach($scope.users, function(val, key) {
      usersById[val.id] = val;
    });

    network.get('bank_details', {performer_id: data.performer_id, request_id: $scope.$parent.requestID}, function (result, response) {
      if (result) {
        $scope.bank_details = response.result;
        angular.forEach($scope.bank_details, function(val, key) {
          if(val.id == $scope.data.bank_details_id) {
            $scope.updateIBAN(val);
            return false;
          }
        });

      }
    });

    $scope.updateFinPlanUsers();

  }
  
  $scope.updateFinPlanUsers = function(submit) {
    var submit = submit || false;
    network.get('request_user', {request_id: $scope.$parent.requestID}, function (result, response) {
      if (result && !submit) {
        $scope.request_users = response.result;
        if(response.count == '0') {
          $scope.request_users = [{}];
        } else {
          usersById=[];
          angular.forEach($scope.users, function(val, key) {
            usersById[val.id] = val;
          });
          angular.forEach($scope.request_users, function(val, key) {
            $scope.calculateEmployee(val);
            val.user = usersById[val.user_id];
          });
          $timeout(function(){
            $scope.updateUserSelect();
          })
        }
      }
    });
  }
  $scope.updateFinPlanProfAssociation = function() {
    network.get('request_prof_association', {request_id: $scope.$parent.requestID}, function (result, response) {
      if (result) {
        $scope.prof_associations = response.result;
        if(response.count == '0') {
          $scope.prof_associations = [{}];
        }
      }
    });
  }

  network.get('request_school_finance', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.schools_data = response.result;
      $scope.financeSchools = response.result;
      $scope.updateResultCost();
    }
  });

  network.get('remuneration_level', {}, function (result, response) {
    if (result) {
      $scope.remuneration_level = response.result;
    }
  });

  $scope.updateFinPlanProfAssociation();
  
  network.get('request_financial_group', {}, function (result, response) {
    if (result) {
      $scope.request_financial_group = response.result;
    }
  });


  var forValidate = {'cost_per_month_brutto':1,'hours_per_week':4, 'annual_bonus':1, 'additional_provision_vwl':1, 'supplementary_pension':1}
  var toNum = {'have_annual_bonus':1, 'have_additional_provision_vwl':1, 'have_supplementary_pension':1}

  function num(val) {
    val = val || 0;
    val += '';
    return val.split(',').join('.')*1
  }

  $scope.undelitetdCount = function(list){
    var cnt = 0;
    $.each(list, function(){
      if(!this.is_deleted){
        cnt++;
      }
    })
    return cnt;
  }

  $scope.calculateAllEmployees = function(emploes){
    $.each(emploes, function(){
      $scope.calculateEmployee(this);
    });
  }
  $scope.calculateEmployee = function(empl, button, name){    
    var other_field = typeof button == 'undefined' ? true : button;
    var index = name ? $scope.errorArray.indexOf(name) : false;
    if(!other_field && index != -1){
      $scope.errorArray.splice(index,1);
    }
    for(var key in forValidate) {
      if(key == 'hours_per_week'){
        $scope.numValidate(empl,key,forValidate[key]);
      }else{
        $scope.numValidate(empl,key);
      }
    }
    for(var key in toNum) {
      empl[key] = num(empl[key]);
    }

    var umlage = $scope.data.is_umlage===1?0.25:0.21;
    var mc = num(empl.month_count);
    var changed_empl = angular.copy(empl);
    for(var key in changed_empl){
      if(typeof changed_empl[key] == 'string' && changed_empl[key].indexOf('.') != -1 && changed_empl[key].indexOf(',') != -1){
        changed_empl[key] = changed_empl[key].split('.');
        changed_empl[key] = changed_empl[key][0] + changed_empl[key][1];
      };
    }
    empl.brutto = num(changed_empl.cost_per_month_brutto) * mc
                + num(changed_empl.annual_bonus) * changed_empl.have_annual_bonus
                + num(changed_empl.additional_provision_vwl) * mc * num(changed_empl.have_additional_provision_vwl)
                + num(changed_empl.supplementary_pension) * mc * num(changed_empl.have_supplementary_pension);
    //empl.brutto = Math.ceil(empl.brutto/100)*100; // Результат округлять вверх до 100 евро. Например: 1201 = 1300

    var summ  = num(changed_empl.cost_per_month_brutto) * mc
              + num(changed_empl.annual_bonus) * changed_empl.have_annual_bonus
              + num(changed_empl.supplementary_pension) * mc * changed_empl.have_additional_provision_vwl;
    empl.addCost = summ * umlage;
    //empl.addCost = Math.ceil(empl.addCost/100)*100;
    empl.fullCost = empl.brutto + empl.addCost;
    $scope.updateResultCost();
  }
  $scope.updateResultCost = function(){
    $scope.emoloyeesCost = 0;
    $scope.training_cost = 0;
    $scope.overhead_cost = 0;
    $scope.prof_association_cost = 0;
    angular.forEach($scope.request_users, function(empl, key) {
      if(!empl.is_deleted) {
        $scope.emoloyeesCost += num(empl.fullCost);
      }
    });
    $scope.emoloyeesCost = Math.ceil(($scope.emoloyeesCost)/100)*100;
    
    angular.forEach($scope.financeSchools, function(sch, key) {      
      var training_cost = angular.copy(sch.training_cost);
      if(typeof sch.training_cost == 'string' && sch.training_cost.indexOf('.') != -1 && sch.training_cost.indexOf(',') != -1){
        training_cost = training_cost.split('.');
        training_cost = training_cost[0] + training_cost[1];
      };      
      var overhead_cost = angular.copy(sch.overhead_cost);        
      if(typeof sch.overhead_cost == 'string' && sch.overhead_cost.indexOf('.') != -1 && sch.overhead_cost.indexOf(',') != -1){
        overhead_cost = overhead_cost.split('.');
        overhead_cost = overhead_cost[0] + overhead_cost[1];
      };
      $scope.training_cost += num(training_cost);
      $scope.overhead_cost += num(overhead_cost);
    });
    angular.forEach($scope.prof_associations, function(ps, key) {
      if(!ps.is_deleted) {
      var prof_associations = angular.copy(ps.sum);        
      if(typeof ps.sum == 'string' && ps.sum.indexOf('.') != -1 && ps.sum.indexOf(',') != -1){
        prof_associations = prof_associations.split('.');
        prof_associations = prof_associations[0] + prof_associations[1];
      };
       $scope.prof_association_cost += num(prof_associations);
      }
    });
    $scope.prof_association_cost = num($scope.prof_association_cost);
    var revenue_sum = angular.copy($scope.data.revenue_sum);        
    if(typeof $scope.data.revenue_sum == 'string' && $scope.data.revenue_sum.indexOf('.') != -1 && $scope.data.revenue_sum.indexOf(',') != -1){
      revenue_sum = revenue_sum.split('.');
      revenue_sum = revenue_sum[0] + revenue_sum[1];
    };    
    $scope.revenue_sum = num(revenue_sum);
    $scope.total_cost = $scope.emoloyeesCost + Math.ceil($scope.training_cost + $scope.overhead_cost + $scope.prof_association_cost - $scope.revenue_sum);

  }
  $scope.updateTrainingCost = function(school){
    var definer = 0;
    school.training_cost = 1800 * (school.month_count/12);
    $scope.numValidate(school.training_cost);
    if(num(school.rate) == 0){
      definer = 0.5;
      school.overhead_cost = 3000 * definer * school.month_count/12;
    }else if(num(school.rate) % 1 == 0){
      definer = num(school.rate);
      school.overhead_cost = 3000 * definer * school.month_count/12;
    }else if(num(school.rate) % 1 <= 0.5){
      definer = Math.floor(num(school.rate)) + 0.5;
      school.overhead_cost = 3000 * definer * school.month_count/12;
    }else {
      definer = Math.round(num(school.rate));
      school.overhead_cost = 3000 * definer * school.month_count/12;
    }
    $scope.numValidate(school.overhead_cost);
    $scope.updateResultCost();
  }
  
  $scope.numValidate2 = function(obj, key,cnt){
    cnt = cnt || 2;
    if(obj != undefined) {
      if(!obj[key]) {
        obj[key] = 0;
      } else {
        obj[key] = obj[key].split('.').join(',');
      }
    }
    
  }
  $scope.numValidate = function(obj, key,cnt){
    cnt = cnt || 2;
    if(!obj[key]) {
      obj[key] = 0;
    } else {
      if(obj[key].indexOf('.') != -1 && obj[key].indexOf(',') != -1){
        obj[key] = obj[key].split('.');
        obj[key] = obj[key][0] + obj[key][1];
      };
      obj[key] = obj[key].split('.').join(',');
      obj[key] = obj[key].split(/[^0-9\,]/).join('');
      var r = new RegExp('([0-9]+)([\,]{0,1})([0-9]{0,'+cnt+'})[0-9]*', 'i');
      var m = obj[key].match(r);
      try{
        if(m[1][0]=='0' && m[1].length>1){
          m[1] = m[1].substring(1,m[1].length);
        }
        if(m[1].length > 3 && m[2] && m[3]){
          var substr_end = m[1].substring(m[1].length-3,m[1].length);
          var substr_start = m[1].substring(0,m[1].length-3);
          m[1] = substr_start + '.' + substr_end;
        };
        obj[key] = m[1]+m[2]+m[3];
      } catch(e) {
        obj[key] = '';
      }
    }
  }
  $scope.maxLength = function(obj, key, length){
    length = length || 50;

    
    if(!obj[key]) {
      obj[key] = '';
    } else {
        var r = new RegExp('.{' + length + '}','i');
        var m = obj[key].match(r);
      try{
        if(m != null){
          obj[key] = m[0];
        } 
      } catch(e) {
        obj[key] = '';
      }
    }

  }
  $scope.maxValue = function(obj, key, value){
    if(!obj[key]) {
      obj[key] = '';
    } else {
      if (obj[key] > value){
        obj[key] = value;
      }
    }

  }
  $scope.deleteEmployee = function(idx){
      if($scope.request_users[idx].id) {
        $scope.request_users[idx].is_deleted = true;
        $scope.request_users[idx].user_id = 0;
      } else {
        $scope.request_users.splice(idx, 1);
      }
      $scope.updateUserSelect();
      $scope.updateResultCost();
      $scope.financePlanForm.$dirty = true;
      $scope.errorArray = [];
  }
  $scope.deleteProfAssociation = function(idx){
      if($scope.prof_associations[idx].id) {
        $scope.prof_associations[idx].is_deleted = true;
      } else {
        $scope.prof_associations.splice(idx, 1);
      }
      $scope.updateResultCost();
      $scope.financePlanForm.$dirty = true;
      $scope.errorArray = [];
  }


  RequestService.updateFinansistFP = function(id){
    $scope.data.finance_user_id = id;
    $scope.selectFinanceResult = Utils.getRowById($scope.users, $scope.data.finance_user_id);
  }

  $scope.onSelectCallback = function (item, model, type){
    switch (type){
      case 3:
        $scope.selectFinanceResult = item ;
        RequestService.updateFinansistPD($scope.data.finance_user_id)
        break;
    }
  }
  $scope.updateIBAN = function (item){
    $scope.IBAN = item;
  }
  $scope.updateUserSelect = function (){
    var idx = {};
    angular.forEach($scope.request_users, function(empl, key) {
      empl.user_id = empl.user_id != '0'?empl.user_id:'';
      idx[empl.user_id] = true;
    });
    angular.forEach($scope.users, function(empl, key) {
      empl.is_selected = idx[empl.id]?1:0;
      
    });
  }
  $scope.employeeOnSelect = function (item, employee){
    $scope.updateUserSelect();
    employee.user = item;
  }
  
  RequestService.hasErrorsFinanceForm = function(){      
    return $scope.errorArray;
  };  
  
  RequestService.setErrorsFinanceForm = function(value){      
    $scope.errorShow = value;
  };
  
  RequestService.setStatusFinanceForm = function(status){
    $scope.data.status_finance = status;
  };
  
  RequestService.isChangedFinanceForm = function(){
    return $scope.financePlanForm.$dirty;
  }
  
  RequestService.setChangedFinanceForm = function(){
    $scope.financePlanForm.$setPristine();
  }
});

spi.controller('RequestSchoolConceptController', function ($scope, network, $timeout, RequestService, Utils, $uibModal) {
  $scope.school_concept = {};
  $scope.conceptTab = {};
  $scope.canAccept = ['a','p'].indexOf(network.user.type) !== -1;
  $scope.canFormEdit = ['a','t'].indexOf(network.user.type) !== -1;
  $scope.fullscreen = false;
  $scope.equal = true;
  $scope.conceptShowErrors = false;

  $scope.canEdit  = function (){
    return  RequestService.canEdit();
  }

  $scope.canAcceptEarly = function(status) {
    return !(network.user.type == 'p' && status != 'in_progress');
  };

  $scope.schoolConcepts = [];
  
  $scope.length_concepts = function(concepts){
    var length = 0;
    for (var i in concepts) {
      if (concepts.hasOwnProperty(i)) {
        length ++;
      };
    };
    return length;
  };
  
  $scope.requestSchoolConcept = function(){
    network.get('request_school_concept', {request_id: $scope.$parent.requestID}, function (result, response) {
      if (result) {
        
        id = 0;
        $scope.conceptTab = [];
        $scope.school_concept = {};
        for(var elem in response.result){
          var id = response.result[elem].id;
          $scope.conceptTab[id] = 'data';
          $scope.school_concept[id]={};
          $scope.school_concept[id]['situation'] = response.result[elem].situation;
          $scope.school_concept[id]['offers_youth_social_work'] = response.result[elem].offers_youth_social_work;
          $scope.school_concept[id]['comment'] =  response.result[elem].comment;
        };
        
        $scope.schoolConcepts = response.result;
        $scope.setBestStatusByUserType();
        $timeout(function() {
          angular.element('.changes-content .heading-changes').on('click', function(){
            angular.element(this).toggleClass('open');
            angular.element(this).next().slideToggle();
          })
        });
        $timeout(function(){
          if($scope.length_concepts($scope.schoolConcepts) == 1){
            var id = 0;
            for(var item in $scope.schoolConcepts){
              id = $scope.schoolConcepts[item].id;
            };
            $('.collapse-' + id).trigger('click');
          }
        });
      }
    });
  }

  $scope.requestSchoolConcept();

  $scope.setBestStatusByUserType = function() {
    var bestStatus = 'unfinished';
    var statuses = [];
    var priorities = $scope.canAccept ? ['in_progress', 'rejected', 'unfinished', 'accepted'] : ['rejected', 'unfinished', 'in_progress', 'accepted'];

    for(var item in $scope.schoolConcepts) {
      statuses.push($scope.schoolConcepts[item].status);
    }
    for(var j=0; j<priorities.length; j++) {
      if(statuses.indexOf(priorities[j]) !== -1) {
        bestStatus = priorities[j];
        break;
      }
    }
    $scope.$parent.setConceptStatus(bestStatus);
  };
  $scope.textOnFocus = function(school_id, num, status){
    angular.element('#area-' + school_id + '-' + num ).addClass('animate');
    $scope.fullscreen = true;
    $scope.textareaClass = 'area-' + num;
    $scope.isTextareaShow = true;
    $scope.canSave = !(!$scope.canFormEdit || (status == 'in_progress' && !$scope.canAccept) || status == 'accepted');
    $timeout(function(){       
        angular.element('#area-' + school_id + '-' + num ).focus();
    });
  };
  $scope.exit = function(school_concept_id, school_id, num, id, type){
    var number = num.split('-');
    $scope.school_concept[id][type] = $scope.schoolConcepts[school_id].oldValue;
    $scope.fullscreen = false;
    $scope.isTextareaShow = false; 
    $scope.textareaClass = '';    
    angular.element('#' + number[0] + '-' + school_concept_id + '-' + number[1]).removeClass('animate');
  };  
  $scope.checkTextarea = function(index, newValue){
    if(newValue != $scope.schoolConcepts[index].oldValue){
      $scope.equal = false;       
      return true;
    }
  };
  RequestService.getSchoolConceptData = function() {
    var school_concept = angular.copy($scope.school_concept);
    for(var item in school_concept){
      var row = {};
      for(var i in $scope.schoolConcepts){
        if($scope.schoolConcepts[i].id == item) row = $scope.schoolConcepts[i];
      };
      school_concept[item].status = row.status;
    };
    return school_concept;
  };

  $scope.submitForm = function(data, concept, action, index) {
    var status = '';
      callback = function(){
        data.status = status;
        network.put('request_school_concept/' + concept.id, data, function(result){
          if(result) {
            concept.status = data.status;
            concept.comment = data.status == 'accepted' ? '' : data.comment;
            $scope.setBestStatusByUserType();

            $scope.requestSchoolConcept();
          }
        });
      }

    
      switch (action) {
        case 'submit':
          if($scope.conceptForm['schoolForm'+index].$invalid) return $scope.$parent.doErrorIncompleteFields();
          status = 'in_progress';

          RequestService.sendMSG(callback);
          break;
        case 'reject':
          status = 'rejected';
          if(!data.comment) return false;

          RequestService.acceptMSG(callback);
          break;
        case 'accept':
          if(data.comment && data.comment.length && concept.status != 'rejected') return false;
          if($scope.conceptForm['schoolForm'+index].$invalid) return $scope.$parent.doErrorIncompleteFields();
          status = 'accepted';

          RequestService.acceptMSG(callback);
          break;
      }

  };

  $scope.doCutText = function(newText, oldText, isNew) {
    var diffMatch = new diff_match_patch();
    if(!oldText){ oldText = ''; }
    if(!newText){ newText = ''; }
    var diffs = diffMatch.diff_main(oldText, newText);

    var fullLength = 120;
    var beforeLength = 20;
    var afterLength = fullLength - beforeLength;

    var text  = {add: '', del: ''};
    var pos   = {add: 0, del: 0};
    var check = {add: false, del: false};

    for(var i=0; i<diffs.length; i++) {
      if(check.add && check.del) break;
      switch(diffs[i][0]) {
        case 0:
          text.add += diffs[i][1];
          text.del += diffs[i][1];
          break;
        case 1:
          if(!check.add) {
            pos.add = text.add.length;
            check.add = true;
          }
          text.add += diffs[i][1];
          break;
        case -1:
          if(!check.del) {
            pos.del = text.del.length;
            check.del = true;
          }
          text.del += diffs[i][1];
          break;
      }
    }
    var result = '';
    var position = isNew && check.add ? pos.add : pos.del;
    text = isNew ? newText : oldText;

    if(!position) {
      result = text.slice(0, fullLength) + (text.length > fullLength ? ' ...' : '');
    } else {
      if(position > beforeLength) {
        result = '... ' + text.slice(position-beforeLength, position+afterLength);
      } else {
        result = text.slice(0, position) + text.slice(position, position+afterLength);
      }
      result += text.length > position+afterLength ? ' ...' : '';
    }
    return result;

  };

  $scope.saveText = function (school_concept_id, data, name, num, school_id ) {
    var number = num.split('-');
    if($scope.checkTextarea(school_id, data[name])){
      if(data[name] != undefined) {
        var params = {};
        params[name] = data[name];
        network.put('request_school_concept/' + school_concept_id, params);
      }
    };    
    $scope.isTextareaShow = false;     
    $scope.fullscreen = false;
    $scope.textareaClass = '';    
    angular.element( '#' + number[0] + '-' + school_concept_id + '-' + number[1] ).removeClass('animate');
  };

  $scope.openComparePopup = function(history, change) {
    $uibModal.open({
      animation: true,
      templateUrl: 'conceptCompareTemplate.html',
      controller: 'СonceptCompareController',
      size: 'width-full',
      resolve: {
        history: function () {
          return {
            user_name: history.user_name,
            date: history.date,
            name: change.name,
            old:  change.old,
            new:  change.new
          };
        }
      }
    });
  }
  
  RequestService.hasErrorsConceptForm = function(){      
    return $scope.conceptForm.$invalid;
  };

  RequestService.setErrorsConceptForm = function(){
    $scope.conceptShowErrors = true;
  };

  $scope.fieldError = function(index, field) {
    var form = $scope.conceptForm['schoolForm'+index];
    return form[field] && form[field].$invalid;
  };
  
  RequestService.setStatusConceptForm = function(status, action){
    for(var item in $scope.schoolConcepts){
      if(action == 'reset' && $scope.schoolConcepts[item].status != 'unfinished' && $scope.schoolConcepts[item].status != 'rejected'){
        $scope.schoolConcepts[item].status = status;
      };
      if(action == 'accept'){
        $scope.schoolConcepts[item].status = status;
      };
    };
  };

  RequestService.isChangedConceptForm = function(){
    return $scope.conceptForm.$dirty;
  }

  RequestService.setChangedConceptForm = function(){
    $scope.conceptForm.$setPristine();
  }

  RequestService.updateSchoolConcept = function(){
     $scope.requestSchoolConcept();
  }
 
});

spi.controller('СonceptCompareController', function($scope, history, $uibModalInstance) {
  var diffMatch = new diff_match_patch();
  var diffs = diffMatch.diff_main(history.old, history.new);
  diffMatch.diff_cleanupSemantic(diffs);
  $scope.compareText = diffMatch.diff_prettyHtml(diffs).replace(/&para;/g,'');

  $scope.history = history;

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});

spi.controller('RequestSchoolGoalController', function ($scope, network,  RequestService, SweetAlert, $timeout) {
  $scope.userType = network.user.type;
  $scope.schoolGoals = [];
  $scope.activeTab = 0;
  $scope.tabStatus = '';
  $scope.paPriority = {'in_progress': 1, 'rejected': 2, 'unfinished': 3, 'accepted': 4 };
  $scope.taPriority = {'rejected': 1, 'unfinished': 2, 'in_progress': 3, 'accepted': 4 };
  $scope.errorShow = false;
  $scope.error = false;
  $scope.count = [];
  $scope.deleted = [];
  $scope.requestSchoolGoal = function(){
    network.get('request_school_goal', {request_id: $scope.$parent.requestID}, function (result, response) {
      if (result) {
        $scope.schoolGoals = response.result;
        $scope.checkSchoolStatus();
        for (var school in $scope.schoolGoals) {
          $scope.count[school] = 0;
          var schools = $scope.schoolGoals;
          for (var goal in schools[school].goals) {
            $scope.schoolGoals[school].goals[goal].newNotice = $scope.schoolGoals[school].goals[goal].notice;
            $scope.schoolGoals[school].goals[goal].errors = {};
            var goals = schools[school].goals;
            if(goals[goal].is_active == 1){
              ++$scope.count[school];
              $scope.schoolGoals[school].counter = $scope.count[school];  //count active fields
            }
          }
        }
      }
    });
  }
  
  $scope.countTop = function(otherId){
    var link = $('#goals-div-' + otherId);
    var offset = link.offset();
    var top = offset.top;
    return top;
  };
  
  $scope.scrollUp = function(school_number){
    var index = 0;
    var i = 0;
    for(var item in $scope.schoolGoals){
      if($scope.schoolGoals[item].school_number == school_number){
        index = i;
      };
      ++i;
    };
    var link = $('#goals-div-' + index);
    var offset = link.offset();
    var top = offset.top;
    var scrollTop = $(window).scrollTop();
    if(scrollTop > top){
      $(window).scrollTop(top);
    };
  };
  
  $scope.getScrollIndex = function(scrollTop){ 
    var collapseItems = $('#schools-goals .in');
    if(collapseItems.length){
      var collapseItemsIds = [];
      for(var i=0;i<collapseItems.length; i++){
        if(collapseItems[i]){
          var id = collapseItems[i].id;
          id = id.split('_');
          id = id[1];
          collapseItemsIds[id] = collapseItems[i];
          collapseItemsIds[id].position = i;
        };
      };
      var collapseId = $('#schools-goals .in').attr('id');
      if(collapseId && collapseItems.length == 1){
        var onScrollIndex = collapseId.split('_');
        onScrollIndex = onScrollIndex[1];
        return onScrollIndex;
      };
      if(collapseId && collapseItems.length > 1){
        var newIndex = Number($scope.onScrollIndex);
        var position = collapseItemsIds[$scope.onScrollIndex].position;
        var newPosition = String(position + 1);
        if(collapseItems[position + 1]){
          for(var i=0;i<collapseItemsIds.length; i++){
            if(collapseItemsIds[i] && String(collapseItemsIds[i].position) == newPosition){
              newIndex = i;
            };
          };
        };
        var top = $scope.countTop(newIndex);
        if(scrollTop > top){
          return newIndex;
        }else{        
          if(collapseItems[position - 1]){
            var otherId2 = Number($scope.onScrollIndex) - 1;
            var newPosition = String(position - 1);
            for(var i=0;i<collapseItemsIds.length; i++){
              if(collapseItemsIds[i] && String(collapseItemsIds[i].position) == newPosition){
                otherId2 = i;
              };
            };
            var top2 = $scope.countTop(otherId2);
            var link2 = $('#goals-div-' + otherId2);
            var max_stop = $('#page').height() - (($('#page').height() - link2.height() - top2)) - $('#goals-list-' + otherId2).height();
            if(scrollTop < max_stop){
              $('#goals-list-' + $scope.onScrollIndex).removeClass('position-fixed');
              $('#goals-button-' + $scope.onScrollIndex).removeClass('position-fixed-button');
              return otherId2;
            }else{
              return $scope.onScrollIndex;
            }
          }else{
            return $scope.onScrollIndex;
          };
        }
      };
    }    
  };
  
  $(window).scroll(function(){
    var scrollTop = $(window).scrollTop();
    $scope.onScrollIndex = $scope.getScrollIndex(scrollTop);
    if($scope.onScrollIndex != undefined){
      var link = $('#goals-div-' + $scope.onScrollIndex);
      var offset = link.offset();
      var top = offset.top;
      var max_stop = $('#page').height() - (($('#page').height() - link.height() - top)) - $('#goals-list-' + $scope.onScrollIndex).height();
      if(scrollTop > top && scrollTop < max_stop){
        $('#goals-list-' + $scope.onScrollIndex).addClass('position-fixed');
        $('#goals-button-' + $scope.onScrollIndex).addClass('position-fixed-button');
      }
      if(scrollTop > max_stop){
        $('#goals-list-' + $scope.onScrollIndex).removeClass('position-fixed');
        $('#goals-button-' + $scope.onScrollIndex).removeClass('position-fixed-button');
      };
      if(scrollTop < top){
        $('#goals-list-' + $scope.onScrollIndex).removeClass('position-fixed');
        $('#goals-button-' + $scope.onScrollIndex).removeClass('position-fixed-button');
      };
    }
  });
  
  $('#clear-position-fixed').click(function(){
    $('.position-fixed').removeClass('position-fixed');
  });

  $scope.requestSchoolGoal();
  
  $scope.canGoalsEdit = function(){
    switch(network.user.type){
      case 'p':
        return false;
        break;
      case 'a':
      case 't':
        if(($scope.$parent.goalsStatus == 'unfinished'|| $scope.$parent.goalsStatus == 'rejected') && $scope.canEdit()){
          return true;
        }; 
        return false;
        break;
    };
  };

  $scope.canEdit  = function (){
    return  RequestService.canEdit();
  }
  
  $scope.deleteGoal = function(id){
    for (var school in $scope.schoolGoals) {
      var schools = $scope.schoolGoals;
      $scope.deleted[school] = [];
      for (var goal in schools[school].goals) {                   
        var goals = schools[school].goals;
        if(goals[goal].id == id){
          goals[goal].is_active = 0;
          $scope.goalsForm.$dirty = true;
          --$scope.count[school];
          $scope.deleted[school].unshift(id);
          $scope.schoolGoals[school].counter = $scope.count[school];
        }
      }
    }
  }
  
  $scope.addGoal = function (school_goals){
    $scope.goalsForm.$dirty = true;
    var school_id = school_goals[1].school_id;
    ++$scope.count[school_id];
    $scope.schoolGoals[school_id].counter = $scope.count[school_id];
    top:
    for (var goal in $scope.schoolGoals[school_id].goals) {
      var goals = $scope.schoolGoals[school_id].goals;
      if($scope.deleted[school_id]){
        for(var i = 0; i < $scope.deleted[school_id].length; i++){          
          if(goals[goal].id == $scope.deleted[school_id][i] && $scope.count[school_id] < 6){    
            delete $scope.deleted[school_id][i];
            goals[goal].is_active = 1;
            break top;
          }
        }
      }
      if(goals[goal].is_active == 0 && $scope.count[school_id] < 6){
        for(var element in $scope.schoolGoals[school_id].goals[goal]){                      
          if(element == 'errors'){
            for(var el in $scope.schoolGoals[school_id].goals[goal][element]){
              $scope.schoolGoals[school_id].goals[goal][element][el] = true;                               
            }              
          }else if(element != 'id' && element != 'request_id' && element != 'school_id' && element != 'goal_number' && element != 'option' && element != 'name' && element != 'status' && element != 'goals'){
            if($scope.schoolGoals[school_id].goals[goal][element] && $scope.schoolGoals[school_id].goals[goal][element] != '' && isNaN($scope.schoolGoals[school_id].goals[goal][element]*1)){
              $scope.schoolGoals[school_id].goals[goal][element] = '';
            }
            if($scope.schoolGoals[school_id].goals[goal][element] && $scope.schoolGoals[school_id].goals[goal][element] != 0 && !isNaN($scope.schoolGoals[school_id].goals[goal][element]*1)){                 
              $scope.schoolGoals[school_id].goals[goal][element] = '0';
            }
          }
        };
        $scope.schoolGoals[school_id].goals[goal].is_active = 1;
        break;
      }
    }     
  }
  
  $scope.checkCount = function(goal, goals){
    if (!('errors' in goal)){
      goal.errors = {};
    }
    var total_count = 0;
    for(var i in goals){ 
      if(goals[i].value == '1'){
        ++total_count;
      };
    };
    goal.total_count = total_count;
    if(total_count > 2 || total_count < 1){      
      goal.errors.total_count = total_count;
    }else{
      delete goal.errors.total_count;
    }
  }

  $scope.checkSchoolStatus = function(){
    switch($scope.userType){
      case 'a':
      case 'p':
        for (var school in $scope.schoolGoals) {
          var schools = $scope.schoolGoals;
          var tempSchoolStatus = '';
          for (var goal in schools[school].goals) {            
            var goals = schools[school].goals;
            if(!(goals[goal].is_active == '0')){
              if($scope.paPriority[goals[goal].status] < $scope.paPriority[tempSchoolStatus] || tempSchoolStatus == ''){
                tempSchoolStatus = goals[goal].status;
              }
            }
          }
          schools[school].status = tempSchoolStatus;
        }
        break;
      default :
        for (var school in $scope.schoolGoals) {
          var schools = $scope.schoolGoals;
          var tempSchoolStatus = '';
          for (var goal in schools[school].goals) {
            var goals = schools[school].goals;
            if(!(goals[goal].is_active == '0')){
              if($scope.taPriority[goals[goal].status] < $scope.taPriority[tempSchoolStatus] || tempSchoolStatus == ''){
                tempSchoolStatus = goals[goal].status;
              }
            }
          }
          schools[school].status = tempSchoolStatus;
        }
      break;
    }
    $scope.checkTabStatus();
  }

  $scope.checkTabStatus = function(){
    switch($scope.userType){
      case 'a':
      case 'p':
        var tempTabStatus = '';
        for (var school in $scope.schoolGoals) {
          var schools = $scope.schoolGoals;
          if($scope.paPriority[schools[school].status] < $scope.paPriority[tempTabStatus] || tempTabStatus == ''){
            tempTabStatus = schools[school].status;
          }
        }
        $scope.$parent.setGoalsStatus(tempTabStatus);
        break;
      default :
        var tempTabStatus = '';
        for (var school in $scope.schoolGoals) {
          var schools = $scope.schoolGoals;
          if($scope.taPriority[schools[school].status] < $scope.taPriority[tempTabStatus] || tempTabStatus == ''){
            tempTabStatus = schools[school].status;
          }
        }
        $scope.$parent.setGoalsStatus(tempTabStatus);
        break;
    }
  }

  $scope.activateTab = function(goals, index, item){
    var id = goals[1].id;
    $scope.activeTab = id;
    $timeout(function () {      
      $('.goal_' + id).trigger('click');
    });
  }

  $scope.getActivateTab = function(){    
    return $scope.activeTab;
  }

  $scope.submitForm = function( goal, action ) {
      submitRequest = function(){
        var sendGoal = angular.copy(goal);
        if ('errors' in sendGoal){delete sendGoal.errors;}
        if ('total_count' in sendGoal){delete sendGoal.total_count;}
        if ('showError' in sendGoal){delete sendGoal.showError;}
        if ('newNotice' in sendGoal){delete sendGoal.newNotice;}
        network.put('request_school_goal/' + sendGoal.id, sendGoal, function(result){
            if(result) {
              $scope.checkSchoolStatus();
            }
        });
      }
      isEmptyObject = function(obj) {
        for (var i in obj) {
            return false;
        }
        return true;
      }

      callback = function(){
        goal.showError = false;
        goal.status = $scope.tempStatus;
        submitRequest(goal);
      }

      switch (action) {
        case 'submit':
          if(isEmptyObject(goal.errors) && (goal.total_count < 3 || !goal.total_count)){
            $scope.tempStatus = 'in_progress';
            RequestService.sendMSG(callback);
          } else {
            goal.showError = true;
            $scope.$parent.doErrorIncompleteFields();
          }
          break;
        case 'declare':
          goal.notice = goal.newNotice;
          if (!goal.notice){
            $scope.$parent.doErrorIncompleteField('Prüfnotiz');
            return false;
          }
          $scope.tempStatus = 'rejected';
          RequestService.acceptMSG(callback);
          break;
        case 'accept':
          if (goal.newNotice && goal.newNotice.length && goal.status != 'rejected') return false;
          if(isEmptyObject(goal.errors) && (goal.total_count < 3 || !goal.total_count)){
            goal.notice = goal.newNotice;
            $scope.tempStatus = 'accepted';
            RequestService.acceptMSG(callback);
          } else {
            goal.showError = true;
            $scope.$parent.doErrorIncompleteFields();
          }
          break;
      }

  };

  RequestService.getSchoolGoalData = function(){
    var data = {};
    if(angular.isObject($scope.schoolGoals)){
      for (var school in $scope.schoolGoals){
        if(angular.isObject($scope.schoolGoals[school])){
          var goals = angular.copy($scope.schoolGoals[school].goals);
          for(var goal in goals){
            delete goals[goal].errors;
            delete goals[goal].showError;
            goals[goal].notice = goals[goal].newNotice;
            delete goals[goal].newNotice;
            data[goals[goal].id]=(goals[goal]);
          }
        }
      }
    }
    $scope.deleted = [];
    return data;
  };

  $scope.permissions={
                      allFields:  {
                                    unfinished:   {'a' : 1, 'p' : 0, 't': 1, 'default': 0 },
                                    in_progress:  {'a' : 1, 'p' : 0, 't': 0, 'default': 0 },
                                    rejected:     {'a' : 1, 'p' : 0, 't': 1, 'default': 0 },
                                    accepted:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    default:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 }
                                  },
                      textNotice: {
                                    unfinished:   {'a' : 1, 'p' : 0, 't': 0, 'default': 0 },
                                    in_progress:  {'a' : 1, 'p' : 1, 't': 0, 'default': 0 },
                                    rejected:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    accepted:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    default:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 }
                                  },
                      btnSenden:  {
                                    unfinished:   {'a' : 0, 'p' : 0, 't': 1, 'default': 0 },
                                    in_progress:  {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    rejected:     {'a' : 0, 'p' : 0, 't': 1, 'default': 0 },
                                    accepted:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    default:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 }
                                  },
                      btnAccept:  {
                                    unfinished:   {'a' : 1, 'p' : 0, 't': 0, 'default': 0 },
                                    in_progress:  {'a' : 1, 'p' : 1, 't': 0, 'default': 0 },
                                    rejected:     {'a' : 1, 'p' : 0, 't': 0, 'default': 0 },
                                    accepted:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    default:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 }
                                  },
                      btnReject:  {
                                    unfinished:   {'a' : 1, 'p' : 0, 't': 0, 'default': 0 },
                                    in_progress:  {'a' : 1, 'p' : 1, 't': 0, 'default': 0 },
                                    rejected:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    accepted:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    default:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 }
                                  },
                        default:  {
                                    unfinished:   {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    in_progress:  {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    rejected:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    accepted:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
                                    default:      {'a' : 0, 'p' : 0, 't': 0, 'default': 0 }
                                  }
  };

  $scope.userCan = function(field, status) {
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

    var status =  status  || 'default';
    if(!(field in $scope.permissions)){
      field = 'default';
    }

    var results = $scope.permissions[field][status][userType];
    return results;
  }

  $scope.fieldError = function (goal, field, school, additional) {
    if(additional){
      for(var i in goal.goals){
        if(goal.goals[i].value == '0' && goal.goals[i].is_with_desc == '1'){
          goal.goals[i].description = '';
          delete goal.errors[field];
          return false;
        }
        if(goal.goals[i].is_with_desc == '1' && (goal.goals[i].description  == undefined || goal.goals[i].description  == '') && goal.goals[i].value != '0'){
          goal.errors[field] = true;
          return true;
        }
        if(goal.goals[i].is_with_desc == '1' && goal.goals[i].description  != undefined && goal.goals[i].description  != '' && goal.goals[i].value != '0'){
          delete goal.errors[field];
          return false;
        }
      };
    }
    if(goal[field] == undefined || goal[field] == ''){
      goal.errors[field] = true;
      return true;
    } else {
      delete goal.errors[field];
      return false;
    }
  }
  
  RequestService.hasErrorsGoalsForm = function(){      
    var errors = [];
    for(var item in $scope.schoolGoals){
      for(var i in $scope.schoolGoals[item].goals){
        if(Object.keys($scope.schoolGoals[item].goals[i].errors).length && $scope.schoolGoals[item].goals[i].is_active == '1'){          
          errors[i] = $scope.schoolGoals[item].goals[i].errors;
        };
      };        
    };    
    return errors;
  };
  
  RequestService.setErrorsGoalsForm = function(value){ 
    for(var item in $scope.schoolGoals){
      for(var i in $scope.schoolGoals[item].goals){
        if(Object.keys($scope.schoolGoals[item].goals[i].errors).length && $scope.schoolGoals[item].goals[i].is_active == '1'){          
          $scope.schoolGoals[item].goals[i].showError = value;
        };
      };        
    };
  };
  
  RequestService.setStatusGoalForm = function(status, action){
    for(var item in $scope.schoolGoals){
      $scope.schoolGoals[item].status = status;
      for(var i in $scope.schoolGoals[item].goals){
        if($scope.schoolGoals[item].goals[i].status != 'unfinished' && $scope.schoolGoals[item].goals[i].status != 'rejected' && action == 'reset'){          
          $scope.schoolGoals[item].goals[i].status = status;
        };
        if(action == 'accept' && $scope.schoolGoals[item].goals[i].status != 'accepted'){
          $scope.schoolGoals[item].goals[i].status = status;
        };
      };
    };
  };

  RequestService.isChangedGoalsForm = function(){
    return $scope.goalsForm.$dirty;
  }

  RequestService.setChangedGoalsForm = function(){
    $scope.goalsForm.$setPristine();
  }

  RequestService.updateSchoolGoal = function(){
     $scope.requestSchoolGoal();
  }

});

spi.controller('ModalDurationController', function ($scope, start_date, due_date, end_fill, ids,  $uibModalInstance, network,$timeout) {
//  $scope.countElements = ids.length;
  
  network.get('request', {id: ids[0]},function(result, response){
    if(result){
      $scope.request_date = new Date(response.result.year,'0','1');
      $scope.request_year = response.result.year;
      $timeout(function(){
        $scope.dateOptions = {
          startingDay: 1,
          showButtonBar: 0,
          showWeeks: 0,
          initDate: $scope.request_date
        };
      });  
    }
  });
  
  $scope.form={
    start_date: Date.parse(start_date),
    due_date: Date.parse(due_date),
    end_fill: Date.parse(end_fill)
  };
  
  $scope.checkYear = function(){
    if($scope.form.start_date && new Date($scope.form.start_date).getFullYear() != $scope.request_year){
      return true;
    };    
    if($scope.form.due_date && new Date($scope.form.due_date).getFullYear() != $scope.request_year){
      return true;
    }; 
    return false;
  };

  
  $scope.ok = function () {
    $uibModalInstance.close($scope.form);
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});

spi.controller('ModalEndFillController', function ($scope, start_date, due_date, end_fill, $uibModalInstance, ids, network, $timeout) {

  network.get('request', {id: ids[0]},function(result, response){
    if(result){
      $scope.request_date = new Date(response.result.year,'0','1');
      $scope.request_year = response.result.year-1;
      $timeout(function(){
        $scope.dateOptions = {
          startingDay: 1,
          showButtonBar: 0,
          showWeeks: 0,
          initDate: $scope.request_date
        };
      });  
    }
  });

  $scope.form={
    start_date: Date.parse(start_date),
    due_date: Date.parse(due_date),
    end_fill: Date.parse(end_fill)
  };

   $scope.checkYear = function(){
    if($scope.form.end_fill && new Date($scope.form.end_fill).getFullYear() != $scope.request_year){
      return true;
    };
    return false;
  };

  $scope.ok = function () {
    $uibModalInstance.close($scope.form);
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});

spi.controller('SendToAcceptController', function ($scope, $rootScope, $uibModalInstance, network, RequestService, SweetAlert, Utils) {  
  $scope.user = network.user;
  $scope.checkboxes = {
    'finance' : $scope.user.is_finasist == 1 ? true : false,
    'concept' : true,
    'goal'    : true
  };
  $scope.errors = '';
  var projectData   = RequestService.getProjectData();  
  var projectUserError = projectData.concept_user_id == '' || !projectData.concept_user_id ? true : false;
  var goalErors     = RequestService.hasErrorsGoalsForm();   //array[array]
  var conceptErors  = RequestService.hasErrorsConceptForm(); //boolean
  var financeErors  = RequestService.hasErrorsFinanceForm(); //array[]
  
  $scope.doErrorIncompleteFields = function(formsToSend) {
    formsToSend.forEach(function(item, i, arr){
      if(item == 'finance' && financeErors.length){
        $scope.errors += 'Finanzplan\n';
      }else if(item == 'concept' && conceptErors){
        $scope.errors += 'Konzept\n';
      }else if(item == 'goal' && goalErors.length){
        $scope.errors += 'Entwicklungsziele\n';
      }
    });
    if(projectUserError && formsToSend.indexOf('concept') != -1 && formsToSend.indexOf('goal') != -1){
      $scope.errors += 'Projektdaten\n';
    };
    SweetAlert.swal({
      html:true,
      title: "Die Antragsteile können nur vollständig ausgefüllt übermittelt werden!",
      text: "Bitte überprüfen Sie folgende Antragsteile:\n" + $scope.errors,
      type: "error",
      confirmButtonText: "OK"
    },function(isConfirm){
       if(isConfirm){         
         RequestService.setErrorsFinanceForm(true);
         RequestService.setErrorsGoalsForm(true);
         RequestService.setErrorsConceptForm();
         RequestService.setErrorsProjectForm();
         $uibModalInstance.close();
       }
    });
    return false;
  };
  
  $scope.doSuccessFields = function(callback) {
    SweetAlert.swal({
      html:true,
      title: "Die ausgewählten Antragsteile wurden zur Prüfung übermittelt.",
      type: "warning",
      confirmButtonText: "OK"
    },function(isConfirm){
       if(isConfirm){
         callback();
         $uibModalInstance.close($scope.formsToSend);
       }
    });
  };
      
  $scope.fieldError = function(field) {
    var form = $scope.setDocumentTemplate;
    return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
  };
  
  $scope.send = function (){
    if((!$scope.checkboxes.concept && $scope.checkboxes.goal) || ($scope.checkboxes.concept && !$scope.checkboxes.goal)){
      SweetAlert.swal({
        html:true,
        title: "Die Antragsteile Konzept und Entwicklungsziele können nur zusammen gesendet werden.",
        type: "warning",
        confirmButtonText: "OK"
      });
    }else if(!$scope.checkboxes.concept && !$scope.checkboxes.goal && !$scope.checkboxes.finance){
      SweetAlert.swal({
        html:true,
        title: "Bitte wählen Sie Antragsteile.",
        type: "warning",
        confirmButtonText: "OK"
      });
    }else{
      $scope.formsToSend = [];
      for(var checkbox in $scope.checkboxes){
        if($scope.checkboxes[checkbox]){
          $scope.formsToSend.push(checkbox);
        };
      };

      var condition = true;
      $scope.formsToSend.forEach(function(item, i, arr){
        if((item == 'finance' && financeErors.length) || (item == 'concept' && conceptErors) || (item == 'goal' && goalErors.length)){
          condition = false;
        };
      });
      if($scope.formsToSend.indexOf('goal') != -1 && $scope.formsToSend.indexOf('concept') != -1 && projectUserError){
        condition = false;
      };

      if(!condition){
        return $scope.doErrorIncompleteFields($scope.formsToSend);
      }else{
        $scope.doSuccessFields( function(){
          $rootScope.$broadcast('sendToAccept', true, $scope.formsToSend)
        });
      };
    };    
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };
});

