spi.controller('RequestController', function ($scope, $rootScope, network, Utils, $location, RequestService, SweetAlert) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  $scope.requestID = Utils.getIdByPath();
  $scope.projectID = '';
  $scope.requestYear = '';

  $scope.financeStatus = '';
  $scope.conceptStatus = '';
  $scope.goalsStatus = '';
  $scope.isFinansist = ['a', 'p', 'g'].indexOf(network.user.type) !== -1 || (network.user.type == 't' && +network.user.is_finansist);

  var hash = $location.hash();
  if(hash && ['project-data', 'finance-plan', 'school-concepts', 'schools-goals'].indexOf(hash) !== -1) {
    $scope.tabActive = $location.hash();
  }
  $scope.setTab = function(name) {
    $location.hash(name);
  };

  $scope.setFinanceStatus = function(financeStatus){
    $scope.financeStatus = financeStatus;
  };
  $scope.setConceptStatus = function(conceptStatus){
    $scope.conceptStatus = conceptStatus;
  };
  $scope.setGoalsStatus = function(goalsStatus){
    $scope.goalsStatus = goalsStatus;
  };

  $scope.updateRights = function(is_bonus_project){
    $scope.isFinansist = ['a', 'p', 'g'].indexOf(network.user.type) !== -1 || (network.user.type == 't' && +network.user.is_finansist) || (is_bonus_project == '1' && network.user.type == 's');
  };
  $scope.setProjectID = function(projectID){
    $scope.projectID = projectID;
    RequestService.setRequestCode($scope.requestYear + ' (' + $scope.projectID + ')');
  };
  $scope.setRequestYear = function(requestYear){
    $scope.requestYear = requestYear;
    RequestService.setRequestCode($scope.requestYear + ' (' + $scope.projectID + ')');
  };

  $scope.submitRequest = function (close) {
    close = close || false;
    var data = RequestService.getProjectData();
    var finPlan = RequestService.financePlanData();
    data = angular.extend(data, finPlan.request);
    delete finPlan.request;
    data['finance_plan']    = finPlan;
    data['school_concepts'] = RequestService.getSchoolConceptData();
    data['school_goals']    = RequestService.getSchoolGoalData();
    network.put('request/' + $scope.requestID, data, function(result, response) {
      if(result && close) {
       location.href = '/requests';
      }
    });
  };

  $scope.block = function ()  {
    Utils.doConfirm(function() {
      network.put('request/' + $scope.requestID,{'status_id':2}, function (result) {
        if (result) {
          Utils.deleteSuccess();
          location.href = '/requests';
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
    Utils.modalClosing($scope.form, '', '', '', '/requests');
  };

  $scope.userCan = function(type) {

    var results = false;
    var user = network.user.type;
    var status = 'none';
    var status_id;
    var request = RequestService.getProjectData();
    if(request) {
      status = request.status_code;
      status_id = request.status_id;

      switch(type) {
        case 'reopen':;
          results = (user == 'a' && (status == 'accept' || status == 'decline' || status == 'acceptable') );
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
      }
    }
    return results;
  };

  $scope.doErrorIncompleteFields = function() {
    SweetAlert.swal({
      title: "Fehler",
      text: "Bitte füllen Sie alle Felder aus",
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
    
    var required = [
                    'doc_target_agreement_id',
                    'doc_request_id',
                    'doc_financing_agreement_id',
                    'finance_user_id',
                    'concept_user_id',
                    'start_date',
                    'due_date'
                  ];


    var failFields = [];
    if(statusId == 4 || statusId == 5){
      required.forEach(function(item, i, required) {
        if(!request_data[item]){
          failFields.push(item);
        }
      });
    }

      var failCodes = [];
        if(statusId == 5 && request_data.status_id < 4 ) {
          failCodes.push(data.code);
        } else if($scope.conceptStatus != 'accepted' || $scope.financeStatus != 'accepted' || $scope.goalsStatus != 'accepted') {
          failCodes.push(data.code);
        }


      if(failFields.length) {
        SweetAlert.swal({
          title: "Fehler",
          text: "Field(s): \n "+failFields.join(',\n ')+"\n Sie müssen füllen",
          type: "error",
          confirmButtonText: "OK"
        });
        return false;
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
        text: "Möchten Sie wirklich eine Anfrage",
        type: "warning",
        confirmButtonText: "JA",
        showCancelButton: true,
        cancelButtonText: "NEIN",
        closeOnConfirm: true
      }, function(isConfirm){
        if(isConfirm) {
          request_data.status_code = 'in_progress';
          request_data.status_id = statusId;
          switch(statusId){
            case 3:;
              request_data.status_code = 'in_progress';
              request_data.status_id = statusId;
              network.get('user_lock', {request_id: request_data['id']},function(result, response){
                if(result){
                  for(var key in response.result){
                    network.delete('user_lock/'+response.result[key]['id']+'?request_id='+request_data['id']);
                  }
                }
              });
              break;
            case 4:;
              request_data.status_code = 'acceptable';
              request_data.status_id = statusId;
              break;
            case 5:;
              request_data.status_code = 'accept';
              request_data.status_id = statusId;
              break;
          }

          $scope.submitRequest();

//          network.patch('request', {ids: ids, status_id: statusId}, function(result) {
//            if(result) {
//              request_data.status_code = 'in_progress';
//              request_data.status_id = statusId;
//              $scope.submitRequest();
//            }
//          });
        }
      });
    

  };

});

spi.controller('RequestProjectDataController', function ($scope, network, Utils, $uibModal, SweetAlert, RequestService, localStorageService) {
  $scope.filter = {id: $scope.$parent.requestID};
  $scope.isInsert = !$scope.$parent.requestID;
  $scope.udater = 0;
  localStorageService.set('dataChanged', 0);
  $scope.add_concept_user = false;
  $scope.new_concept_user = "";
  
  $scope.addNewConceptUser = function(){
    if(!$scope.add_concept_user){
      $scope.add_concept_user = true;   
    }else{
      $scope.add_concept_user = false;  
    }      
  }
  
  $scope.submitToAddUser = function(event, new_user){
    if(event.which == 13){ 
      $scope.userLoading = true;  
      $scope.add_concept_user = false;
      var name = new_user.split(' ');
      $scope.new_concept_user = {
        first_name: name[0],
        last_name: name[1],
        sex: 3,
        is_virtual: 1,
        type_id: 3,
        email: $scope.user.email,
        type: 't',
        relation_id: $scope.request.performer_id
      };
      var callback = function (result, response) {
        if (result) {
          $scope.request.concept_user_id = response.id;
          $scope.getPerformerUsers(function(){
            $scope.userLoading = false;
          });   
          $scope.new_user = "";          
        } else {
          $scope.error = getError(response.system_code);
          $scope.userLoading = false; 
        }         
      };
      network.post('user', $scope.new_concept_user, callback);
    };    
  }  
  
  $scope.userCan = function(type) {
    var user = network.user.type;
    var results = false;
    if($scope.request) {
      switch(type)  {
        case 'dates':;
        case 'additional_info':;
        case 'templates':;
          results = ((user == 'a' || user == 'p') && $scope.request.status_code != 'accept' && $scope.request.status_code != 'decline');
          break;
        case 'users':;
          results = ((user == 'a' || user == 'p' || user == 't') && $scope.request.status_code != 'accept' && $scope.request.status_code != 'decline');
          break
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
        $scope.data = response.result;

        $scope.$parent.updateRights($scope.data.is_bonus_project);
        $scope.$parent.setProjectID($scope.data.code);
        $scope.$parent.setRequestYear($scope.data.year);

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
        
        if(response.result.status_id == '5'){
          network.get('user_lock', {type: 't', relation_id: $scope.request.performer_id, request_id: $scope.request.id}, function (result, response) {
                  if (result) {
                    $scope.performerUsers = response.result;
                    for (var key in $scope.performerUsers){
                      $scope.performerUsers[key]['id']=$scope.performerUsers[key]['user_id'];
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
        } else {
          $scope.getPerformerUsers();
        }
        

      }
    });
  }
  $scope.getPerformerUsers = function(callback){
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
            callback = callback || function(){};
            callback();
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

      });
    }
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
  
});

spi.controller('RequestFinancePlanController', function ($scope, network, RequestService, Utils, $timeout) {
  $scope.users = [];
  $scope.IBAN = {};
  $scope.request_users = [{}]; //create one user by default
  $scope.prof_associations = [{}]; //create one association by default
  $scope.financeSchools = [];
  $scope.add_concept_user = false;
  $scope.new_employee_user = "";

  $scope.canAccept = ['a','p'].indexOf(network.user.type) !== -1;
  $scope.canFormEdit = ['a','t'].indexOf(network.user.type) !== -1;
  $scope.comment = '';

  $scope.canAcceptEarly = function(status) {
    return !(network.user.type == 'p' && status != 'in_progress');
  };


  $scope.addNewFinanceUser = function(){
    if(!$scope.add_concept_user){
      $scope.add_concept_user = true;   
    }else{
      $scope.add_concept_user = false;  
    }      
  }
  $scope.getPerformerUsers = function(callback){
       network.get('User', {type: 't', relation_id: $scope.data.performer_id}, function (result, response) {
          if (result) {
            $scope.users = response.result;
            for (var key in $scope.users){
              if($scope.users[key].sex == 1){$scope.users[key].gender = 'Herr'}
              if($scope.users[key].sex == 2){$scope.users[key].gender = 'Frau'}
            }

            $scope.selectFinanceResult = Utils.getRowById(response.result, $scope.data.finance_user_id);
            callback = callback || function(){};
            callback();
          }
        });         
    };
    
  $scope.getEmployeeUsers = function(id,callback){
      callback = callback || function(){};
       network.get('User', {type: 't', relation_id: $scope.data.performer_id}, function (result, response) {
          if (result) {
            $scope.users.push(Utils.getRowById(response.result, id));
            callback = callback || function(){};
            callback();
          }
        });         
    };
  
  $scope.submitToAddUser = function(event, new_user){
    if(event.which == 13){ 
      $scope.userLoading = true;  
      $scope.add_concept_user = false;
      var name = new_user.split(' ');
      $scope.new_finance_user = {
        first_name: name[0],
        last_name: name[1],
        sex: 3,
        is_virtual: 1,
        is_finansist: 1,
        type_id: 3,
        email: network.user.email,
        type: 't',
        relation_id: $scope.data.performer_id
      };
     
      var callback = function (result, response) {
        if (result) {
          RequestService.updateFinansistPD(response.id);
          $scope.data.finance_user_id = response.id;
          $scope.getPerformerUsers(function(){
              $scope.userLoading = false;
          })      
          $scope.new_user = "";          
        } else {
          $scope.error = getError(response.system_code);
          $scope.userLoading = false; 
        }         
      };
      network.post('user', $scope.new_finance_user, callback);
    };    
  }
  
  $scope.submitToAddUserEmpl = function(event, new_user, idx){
    if(event.which == 13){ 
      $scope.userLoading = true;  
      $scope.add_concept_user = false;
      var name = new_user.split(' ');
      $scope.new_employee_user = {
        first_name: name[0],
        last_name: name[1],
        sex: 3,
        is_virtual: 1,
        type_id: 3,
        email: network.user.email,
        type: 't',
        relation_id: $scope.data.performer_id
      };
     
      var callback = function (result, response) {
        if (result) {
          console.log($scope.request_users[idx].user_id, response.id)
          $scope.request_users[idx].user_id = response.id;
          
//          $scope.request_users[0].user = Utils.getRowById($scope.users, 444);
//                $scope.request_users[0].user_id = 444;
          $scope.getEmployeeUsers(response.id, function(){
              $scope.request_users[idx].user = Utils.getRowById($scope.users, response.id);
                $scope.request_users[0].user_id = response.id; 
              $scope.userLoading = false;
//                $scope.request_users[0].user = Utils.getRowById($scope.users, 444);
//                $scope.request_users[0].user_id = 444; 
//              $timeout(function(){
//                $scope.request_users[idx].user = Utils.getRowById($scope.users, response.id);
//                $scope.request_users[0].user_id = response.id; 
//              },5000);
//              
//              $scope.request_users[idx].user_id = response.id;
//              
//              $scope.employeeOnSelect($scope.request_users[idx].user, $scope.request_users[idx]);
//             console.log($scope.request_users[idx]);   
//              
////              $scope.request_users[idx] = 
//              //$scope.userLoading = false;
          })      
//          $scope.new_user_name = "";          
        } else {
          $scope.error = getError(response.system_code);
          $scope.userLoading = false; 
        }         
      };
      network.post('user', $scope.new_employee_user, callback);
    };    
  }
  var usersById = {};

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
    });
    angular.forEach(finPlan.schools, function(val, key) {
      delete val.school_name;
      delete val.school_number;
    });
    return finPlan;
  };

  $scope.submitForm = function(status) {
    if(['in_progress', 'accepted', 'rejected'].indexOf(status) === -1) return false;
    var data = {};
    switch (status) {
      case 'accepted':
        if($scope.financePlanForm.$invalid) return $scope.$parent.doErrorIncompleteFields();
        break;
      case 'in_progress':
        if($scope.financePlanForm.$invalid) return $scope.$parent.doErrorIncompleteFields();
        var finPlan = RequestService.financePlanData();
        delete finPlan.request;
        data.finance_user_id = $scope.data.finance_user_id;
        data.bank_details_id = $scope.data.bank_details_id;
        data.revenue_description = $scope.data.revenue_description;
        data.revenue_sum = $scope.data.revenue_sum;
        data.finance_plan = finPlan;
        break;
      case 'rejected':
        if(!$scope.data.comment) return false;
        data.finance_comment = $scope.data.comment;
        break;
    }
    data['status_finance'] = status;

    network.put('request/'+$scope.$parent.requestID, data, function(result, response) {
      if(result) {
        $scope.data.status_finance = status;
        $scope.data.comment = status == 'accepted' ? '' : $scope.data.finance_comment;
        $scope.$parent.setFinanceStatus(status);
      }
    });
  };

  RequestService.initFinancePlan = function(data){
    $scope.users = data.users;
    $scope.updateUserSelect();
    $scope.data = data;
    if ($scope.data.finance_user_id == "0") {
      $scope.data.finance_user_id = '';
    }
    if ($scope.data.bank_details_id == "0") {
      $scope.data.bank_details_id = '';
    }
    if ($scope.data.revenue_sum != undefined ) {
      $scope.numValidate2(data,'revenue_sum');
    }
    $scope.$parent.setFinanceStatus(data.status_finance);
    $scope.selectFinanceResult = Utils.getRowById($scope.users, data.finance_user_id);

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

    network.get('request_user', {request_id: $scope.$parent.requestID}, function (result, response) {
      if (result) {
        $scope.request_users = response.result;

        if(response.count == '0') {
          $scope.request_users = [{}];
        } else {
          angular.forEach($scope.request_users, function(val, key) {
            $scope.calculateEmployee(val);
            val.user = usersById[val.user_id];
            $timeout(function(){
              $scope.updateUserSelect();
            },100)
          });
        }
      }
    });

  }

  network.get('request_school_finance', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.financeSchools = response.result;
      $scope.updateResultCost();
    }
  });

  network.get('remuneration_level', {}, function (result, response) {
    if (result) {
      $scope.remuneration_level = response.result;
    }
  });
  network.get('request_prof_association', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.prof_associations = response.result;
      if(response.count == '0') {
        $scope.prof_associations = [{}];
      }
    }
  });
  network.get('request_financial_group', {}, function (result, response) {
    if (result) {
      $scope.request_financial_group = response.result;
    }
  });


  var forValidate = {'cost_per_month_brutto':1, 'annual_bonus':1, 'additional_provision_vwl':1, 'supplementary_pension':1}
  var toNum = {'have_annual_bonus':1, 'have_additional_provision_vwl':1, 'have_supplementary_pension':1, 'is_umlage':1}

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

  $scope.calculateEmployee = function(empl){
    for(var key in forValidate) {
      $scope.numValidate(empl,key);
    }
    for(var key in toNum) {
      empl[key] = num(empl[key]);
    }

    var umlage = empl.is_umlage?0.25:0.21;
    var mc = num(empl.month_count);
    empl.brutto = num(empl.cost_per_month_brutto) * mc
                + num(empl.annual_bonus) * empl.have_annual_bonus
                + num(empl.additional_provision_vwl) * mc * num(empl.have_additional_provision_vwl)
                + num(empl.supplementary_pension) * (mc + empl.have_annual_bonus) * num(empl.have_supplementary_pension);
    empl.brutto = Math.ceil(empl.brutto/100)*100; // Результат округлять вверх до 100 евро. Например: 1201 = 1300

    var summ  = num(empl.cost_per_month_brutto) * mc
              + num(empl.annual_bonus) * empl.have_annual_bonus
              + num(empl.additional_provision_vwl) * mc * empl.have_additional_provision_vwl;
    empl.addCost = summ * umlage;
    empl.addCost = Math.ceil(empl.addCost/100)*100;
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
    angular.forEach($scope.financeSchools, function(sch, key) {
      $scope.training_cost += num(sch.training_cost);
      $scope.overhead_cost += num(sch.overhead_cost);
    });
    angular.forEach($scope.prof_associations, function(ps, key) {
      if(!ps.is_deleted) {
        $scope.prof_association_cost += num(ps.sum);
      }
    });
    $scope.prof_association_cost = num($scope.prof_association_cost);
    $scope.revenue_sum = num($scope.data.revenue_sum);
    $scope.total_cost = $scope.emoloyeesCost + $scope.training_cost + $scope.overhead_cost + $scope.prof_association_cost - $scope.revenue_sum;

  }
  $scope.updateTrainingCost = function(school){
    if(school.rate >= 1) {
      school.training_cost = 2250;
//    } else if(school.rate <= 0,5) {
//
    } else {
      school.training_cost = 1125;
    }
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
      obj[key] = obj[key].split('.').join(',');
      obj[key] = obj[key].split(/[^0-9\,]/).join('');
      var r = new RegExp('([0-9]+)([\,]{0,1})([0-9]{0,'+cnt+'})[0-9]*', 'i');
      var m = obj[key].match(r);
      try{
        obj[key] = m[1]+m[2]+m[3];
      } catch(e) {
        obj[key] = '';
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
  }
  $scope.deleteProfAssociation = function(idx){
      if($scope.prof_associations[idx].id) {
        $scope.prof_associations[idx].is_deleted = true;
      } else {
        $scope.prof_associations.splice(idx, 1);
      }
      $scope.updateResultCost();
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
    // console.log(item);
    $scope.IBAN = item;
  }
  $scope.updateUserSelect = function (){
    var idx = {};
    angular.forEach($scope.request_users, function(empl, key) {
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
});

spi.controller('RequestSchoolConceptController', function ($scope, network, $timeout, RequestService, $uibModal) {

  $scope.school_concept = {};
  $scope.conceptTab = {};
  $scope.canAccept = ['a','p'].indexOf(network.user.type) !== -1;
  $scope.canFormEdit = ['a','t'].indexOf(network.user.type) !== -1;

  $scope.canAcceptEarly = function(status) {
    return !(network.user.type == 'p' && status != 'in_progress');
  };

  $scope.schoolConcepts = [];
  network.get('request_school_concept', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.schoolConcepts = response.result;
      $scope.setBestStatusByUserType();
      $timeout(function() {
        angular.element('.changes-content .heading-changes').on('click', function(){
          angular.element(this).toggleClass('open');
          angular.element(this).next().slideToggle();
        })
      });
    }
  });

  $scope.setBestStatusByUserType = function() {
    var bestStatus = 'unfinished';
    var statuses = [];
    var priorities = $scope.canAccept ? ['in_progress', 'rejected', 'unfinished', 'accepted'] : ['rejected', 'unfinished', 'in_progress', 'accepted'];

    for(var i=0; i<$scope.schoolConcepts.length; i++) {
      statuses.push($scope.schoolConcepts[i].status);
    }
    for(var j=0; j<priorities.length; j++) {
      if(statuses.indexOf(priorities[j]) !== -1) {
        bestStatus = priorities[j];
        break;
      }
    }
    $scope.$parent.setConceptStatus(bestStatus);
  };

  RequestService.getSchoolConceptData = function() {
    return $scope.school_concept;
  };

  $scope.submitForm = function(data, concept, action, index) {
    switch (action) {
      case 'submit':
        if($scope.conceptForm['schoolForm'+index].$invalid) return $scope.$parent.doErrorIncompleteFields();
        data.status = 'in_progress';
        break;
      case 'reject':
        data.status = 'rejected';
        if(!data.comment) return false;
        break;
      case 'accept':
        if($scope.conceptForm['schoolForm'+index].$invalid) return $scope.$parent.doErrorIncompleteFields();
        data.status = 'accepted';
        break;
    }
    network.put('request_school_concept/' + concept.id, data, function(result){
      if(result) {
        concept.status = data.status;
        concept.comment = data.status == 'accepted' ? '' : data.comment;
        $scope.setBestStatusByUserType();
      }
    });
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

  $scope.saveText = function (conceptId, data, name) {
    if(data[name] != undefined) {
      var params = {};
      params[name] = data[name];
      network.put('request_school_concept/' + conceptId, params);
    }
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

spi.controller('RequestSchoolGoalController', function ($scope, network,  RequestService, SweetAlert) {

  $scope.userType = network.user.type;
  $scope.schoolGoals = [];
  $scope.activeTab = 0;
  $scope.tabStatus = '';
  $scope.paPriority = {'in_progress': 1, 'rejected': 2, 'unfinished': 3, 'accepted': 4 };
  $scope.taPriority = {'rejected': 1, 'unfinished': 2, 'in_progress': 3, 'accepted': 4 };
  $scope.errorShow = false;
  $scope.error = false;
  network.get('request_school_goal', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.schoolGoals = response.result;
      $scope.checkSchoolStatus();
    }
  });


  $scope.checkCount = function(group, key, goal, flag){
    var init = flag || 0;

    if (!('groups' in goal)){
      goal.groups = {};
      goal.errors = {};
    }
    if (!(group in goal.groups)){
      goal.groups[group] = {};
      goal.groups[group].counter = 0;
    }
    var currentGroup = goal.groups[group];

    if (!(key in currentGroup)){
      currentGroup[key] = goal[key];
    }

    if(!init){
      if (goal[key] === '1'){
        currentGroup.counter++;
      } else if(currentGroup[key] === '1') {
        currentGroup.counter--;
      }
    } else {
      if (goal[key] === '1'){
        currentGroup.counter++;
      }
    }

    currentGroup[key] = goal[key];
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
            if(!(goals[goal].status === 'unfinished' && goals[goal].option === '1')){
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
            if(!(goals[goal].status === 'unfinished' && goals[goal].option === '1')){
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

  $scope.activateTab = function(id, index, item){
    $scope.activeTab = id;
//    if(!index){angular.element(item).click()}
  }

  $scope.getActivateTab = function(){
    return $scope.activeTab;
  }

  $scope.submitForm = function( goal, action ) {

    submitRequest = function(){
      var sendGoal = angular.copy(goal);
      if ('groups' in sendGoal){delete sendGoal.groups;}
      if ('errors' in sendGoal){delete sendGoal.errors;}
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


    switch (action) {
      case 'submit':
        if(isEmptyObject(goal.errors)){
          goal.showError = false;
          goal.status = 'in_progress';
          submitRequest(goal);
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
        goal.status = 'rejected';
        submitRequest(goal);

        break;
      case 'accept':
        goal.notice = goal.newNotice;
        goal.status = 'accepted';
        submitRequest(goal);
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
            delete goals[goal].groups;
            delete goals[goal].errors;
            delete goals[goal].showError;
            delete goals[goal].newNotice;
            data[goals[goal].id]=(goals[goal]);
          }
        }
      }
    }

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
                                    rejected:     {'a' : 0, 'p' : 0, 't': 0, 'default': 0 },
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

  $scope.fieldError = function (goal, field, condition) {
    var check = condition || true;
    if(check != '0'){
      if(goal[field] == undefined || goal[field] == ''){
        goal.errors[field] = true;
        return true;
      } else {
        delete goal.errors[field];
        return false;
      }
    } else {
      delete goal.errors[field];
      return false;
    }

  }

  $scope.groupError = function(goal, group){
    if(goal.groups !== undefined && goal.groups[group] !== undefined){
      if(goal.groups[group].counter == undefined || goal.groups[group].counter == 0){
        goal.groups[group].error = true;
        goal.errors[group] = true;
        return true;
      } else {
        goal.groups[group].error = false;
        delete goal.errors[group];
        return false;
      }
    } else {
      goal.errors[group] = true;
      return true;
    }
  }

});

spi.controller('ModalDurationController', function ($scope, start_date, due_date, end_fill,  $uibModalInstance) {
//  $scope.countElements = ids.length;

  $scope.form={
    start_date: Date.parse(start_date),
    due_date: Date.parse(due_date),
    end_fill: Date.parse(end_fill)
  };

  $scope.dateOptions = {
    startingDay: 1,
    showButtonBar: 0,
    showWeeks: 0,
    //initDate: start_date
  };

  $scope.ok = function () {
    $uibModalInstance.close($scope.form);
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});

spi.controller('ModalEndFillController', function ($scope, start_date, due_date, end_fill, $uibModalInstance) {

  $scope.form={
    start_date: Date.parse(start_date),
    due_date: Date.parse(due_date),
    end_fill: Date.parse(end_fill)
  };

  $scope.dateOptions = {
    startingDay: 1,
    showButtonBar: 0,
    showWeeks: 0,
  };

  $scope.ok = function () {
    $uibModalInstance.close($scope.form);
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});



