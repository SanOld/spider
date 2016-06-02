spi.controller('RequestController', function ($scope, $rootScope, network, Utils, $location, RequestService) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  $scope.requestID = Utils.getIdByPath();
  $scope.projectID = '';
  $scope.requestYear = '';

  var hash = $location.hash();
  if(hash && ['project-data', 'finance-plan', 'school-concepts', 'schools-goals'].indexOf(hash) !== -1) {
    $scope.tabActive = $location.hash();
  }
  $scope.setTab = function(name) {
    $location.hash(name);
  };

  $scope.setProjectID = function(projectID){
    $scope.projectID = projectID;
  };
  $scope.setRequestYear = function(requestYear){
    $scope.requestYear = requestYear;
  };

  $scope.submitRequest = function () {
    var data = RequestService.getProjectData();
    data['finance_plan']    = RequestService.financePlanData();
    data['school_concepts'] = RequestService.getSchoolConceptData();
    data['school_goals']    = RequestService.getSchoolGoalData();
    network.put('request/' + $scope.requestID, data, function(result, response) {
      if(result) {
        console.log('ToDo'); // mb redirect to /requests ?
      }
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
    location.href = '/requests';
  };

});

spi.controller('RequestProjectDataController', function ($scope, network, Utils, $uibModal, SweetAlert, RequestService) {
  $scope.filter = {id: $scope.$parent.requestID};
  $scope.isInsert = !$scope.$parent.requestID;
  network.get('request', $scope.filter, function (result, response) {
    if (result) {
      $scope.data = response.result;

      $scope.$parent.setProjectID($scope.data.code);
      $scope.$parent.setRequestYear($scope.data.year);

      $scope.request = {
        id:                             response.result.id,
        doc_target_agreement_id:        response.result.doc_target_agreement_id,
        doc_request_id:                 response.result.doc_request_id,
        doc_financing_agreement_id:     response.result.doc_financing_agreement_id,
        request_user_id:                response.result.request_user_id,
        concept_user_id:                response.result.concept_user_id,
        finance_user_id:                response.result.finance_user_id,
        additional_info:                response.result.additional_info,
        senat_additional_info:          response.result.senat_additional_info,
        start_date:                     response.result.start_date,
        due_date:                       response.result.due_date,
        performer_id:                   response.result.performer_id
      };

      network.get('User', {type: 't', relation_id: $scope.request.performer_id}, function (result, response) {
        if (result) {
          $scope.performerUsers = response.result;
          $scope.selectRequestResult = Utils.getRowById(response.result, $scope.request.request_user_id);
          $scope.selectConceptResult = Utils.getRowById(response.result, $scope.request.concept_user_id);
          $scope.selectFinanceResult = Utils.getRowById(response.result, $scope.request.finance_user_id);
        }
      });

    }
  });


  network.get('document_template_type', {filter: 1}, function (result, response) {
    if (result) {
      $scope.documentTypes = response.result;
    }
  });

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
          return [$scope.request.id];
        },
        start_date: function () {
          return $scope.request.start_date;
        },
        due_date: function () {
          return $scope.request.due_date;
        }

      }
    });

    if ($scope.request.id) {
      modalInstance.result.then(function (data) {
        var start = Utils.getSqlDate(new Date(data.start_date));
        var end   = Utils.getSqlDate(new Date(data.due_date));
        network.patch('request', {ids: ids, start_date: start, due_date: end}, function(result) {
          $scope.request.start_date = start;
          $scope.request.due_date = end;
        });
      });


    }
  };

  RequestService.getProjectData = function() {
    return $scope.request;
  };

});

spi.controller('RequestFinancePlanController', function ($scope, network, RequestService) {
  //$scope.$parent.requestID
});

spi.controller('RequestSchoolConceptController', function ($scope, network, $timeout, RequestService, $uibModal) {
  $timeout(function() {
    angular.element('#accordion-concepts .btn-toggle').click(function(){
      return false;
    });
  });

  $scope.school_concept = {};
  $scope.conceptTab = {};

  $scope.schoolConcepts = [];
  network.get('request_school_concept', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.schoolConcepts = response.result;
    }
  });

  RequestService.getSchoolConceptData = function() {
    return $scope.school_concept;
  };


  $scope.submitForm = function(data, concept, action) {
    switch (action) {
      case 'submit':
        data.status = 'r';
        break;
      case 'declare':
        data.status = 'd';
        break;
      case 'accept':
        data.status = 'a';
        break;
    }

    network.put('request_school_concept/' + concept.id, data, function(result){
      if(result) {
        concept.status = data.status;
      }
    });
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

spi.controller('СonceptCompareController', function($scope, history) {
  $scope.history = history;
});

spi.controller('RequestSchoolGoalController', function ($scope, network,  RequestService, $timeout) {

  $scope.userType = network.user.type;
  $scope.schoolGoals = [];
  $scope.activeTab = 0;
  $scope.tabStatus = '';
  $scope.paPriority = {r: 1, d: 2, g: 3, a: 4 };
  $scope.taPriority = {d: 1, g: 2, r: 3, a: 4 };

  network.get('request_school_goal', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.schoolGoals = response.result;
      $scope.checkSchoolStatus();
    }
  });


  $scope.addGoalsCount = function(goal, type){
    switch(type){
      case 'net':
        goal.net_field_count = +goal.net_field_count + 1;
        break;
      case 'offer':
        goal.offer_field_count = +goal.offer_field_count + 1;
        break;
    }

  }

  $scope.delGoalsCount = function(goal, type){
    switch(type){
      case 'net':
        if(goal.net_field_count > 0){goal.net_field_count = +goal.net_field_count - 1;}
        break;
      case 'offer':
        if(goal.offer_field_count > 0){goal.offer_field_count = +goal.offer_field_count - 1;}
        break;
    }

  }

  $scope.checkSchoolStatus = function(){
    switch($scope.userType){
      case 'a':
      case 'p':
        for (var school in $scope.schoolGoals) {
          var schools = $scope.schoolGoals;
          for (var goal in schools[school].goals) {
            var goals = schools[school].goals;
            if($scope.paPriority[goals[goal].status] < $scope.paPriority[schools[school].status] || schools[school].status == ''){
              schools[school].status = goals[goal].status;
            }
          }
        }
        break;
      default :
        for (var school in $scope.schoolGoals) {
          var schools = $scope.schoolGoals
          for (var goal in schools[school].goals) {
            var goals = schools[school].goals;
            if($scope.taPriority[goals[goal].status] < $scope.taPriority[schools[school].status] || schools[school].status == ''){
              schools[school].status = goals[goal].status;
            }
          }
        }
      break;
    }

    $scope.checkTabStatus();
  }


  $scope.checkTabStatus = function(){
    switch($scope.userType){
      case 'a':
      case 'p':
        for (var school in $scope.schoolGoals) {
          var schools = $scope.schoolGoals;
          if($scope.paPriority[schools[school].status] < $scope.paPriority[$scope.tabStatus] || $scope.tabStatus == ''){
            $scope.tabStatus = schools[school].status;
          }
        }
        break;
      default :
        for (var school in $scope.schoolGoals) {
          var schools = $scope.schoolGoals;
          if($scope.taPriority[schools[school].status] < $scope.taPriority[$scope.tabStatus] || $scope.tabStatus == ''){
              $scope.tabStatus = schools[school].status;
            }
        }
      break;
    }
  }

  $scope.activateTab = function(id){
    $scope.activeTab = id;
  }

  $scope.getActivateTab = function(){
    return $scope.activeTab;
  }

  $scope.submitForm = function( school, goal, action ) {
    switch (action) {
      case 'submit':
        goal.status = 'r';
        break;
      case 'declare':
        goal.status = 'd';
        break;
      case 'accept':
        goal.status = 'a';
        break;
    }

    network.put('request_school_goal/' + goal.id, goal, function(result){
      if(result) {
        $scope.checkSchoolStatus();
      }
    });
  };

  $scope.readonly = function(goal){
    switch(goal.status){
      case 'g':
        if($scope.userType == 'a' || $scope.userType == 't'){return false;}
        return true;
        break;
      case 'r':
        if($scope.userType == 'a'){return false;}
        return true;
        break;
      case 'd':
        if($scope.userType == 'a' || $scope.userType == 't'){return false;}
        return true;
        break;
      case 'a':
        return true;
      break;
    }

  }
});

spi.controller('ModalDurationController', function ($scope, start_date, due_date,  $uibModalInstance) {
//  $scope.countElements = ids.length;

  $scope.form={
    start_date: Date.parse(start_date),
    due_date: Date.parse(due_date)
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



