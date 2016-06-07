spi.controller('RequestController', function ($scope, $rootScope, network, Utils, $location, RequestService) {
  if (!$rootScope._m) {
    $rootScope._m = 'request';
  }
  $scope.requestID = Utils.getIdByPath();
  $scope.projectID = '';
  $scope.requestYear = '';

  $scope.financeStatus = '';
  $scope.conceptStatus = '';
  $scope.goalsStatus = '';

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

  $scope.setProjectID = function(projectID){
    $scope.projectID = projectID;
  };
  $scope.setRequestYear = function(requestYear){
    $scope.requestYear = requestYear;
  };

  $scope.submitRequest = function (close) {
    close = close || false;
    var data = RequestService.getProjectData();
    data['finance_plan']    = RequestService.financePlanData();
    data['school_concepts'] = RequestService.getSchoolConceptData();
    data['school_goals']    = RequestService.getSchoolGoalData();
    network.put('request/' + $scope.requestID, data, function(result, response) {
      if(result && close) {
//        location.href = '/requests';
      }
    });
  };

  $scope.block = function () {
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
    location.href = '/requests';
  };

  $scope.userCan = function(type) {

    var results = false;
    var user = network.user.type;
    var status = 'none';
    var request = RequestService.getProjectData();
    if(request) {
      status = request.status_code;
      switch(type) {
        case 'reopen':;
          results = (user == 'a' && (status == 'accept' || status == 'decline'));
          break;
        case 'delete':;
          results = (user == 'a' && status != 'accept' && status != 'decline');
          break;
        case 'changeStatus':;
          results = ((user == 'a' || user == 'p') && status != 'accept' && status != 'decline');
        break;
        case 'save':;
          results = ((user == 'a' || user == 'p' || user == 't') && status != 'accept' && status != 'decline');
          break;
      }
    }
    return results;
  }

});

spi.controller('RequestProjectDataController', function ($scope, network, Utils, $uibModal, SweetAlert, RequestService) {
  $scope.filter = {id: $scope.$parent.requestID};
  $scope.isInsert = !$scope.$parent.requestID;
  $scope.udater = 0;

  $scope.userCan = function(type) {
    var user = network.user.type;
    var results = false;
    if($scope.request) {
      switch(type) {
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

  $scope.getData = function() {
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
          start_date_unix:                response.result.start_date_unix,
          due_date_unix:                  response.result.due_date_unix,
          performer_id:                   response.result.performer_id,
          status_code:                    response.result.status_code
        };

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
          }

        });

      }
    });
  }

  $scope.getData();

  network.get('document_template', {}, function (result, response) {
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
          ids = [$scope.request.id];
          return ids;
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
        $scope.request.start_date_unix = new Date(data.start_date);
        $scope.request.due_date_unix = new Date(data.due_date);

        var start = Utils.getSqlDate(new Date(data.start_date));
        var end   = Utils.getSqlDate(new Date(data.due_date));

        $scope.request.start_date = start;
        $scope.request.due_date = end;
//        network.patch('request', {ids: ids, start_date: start, due_date: end}, function(result) {
//        });
      });


    }
  };

  RequestService.getProjectData = function() {
    return $scope.request;
  };

  $scope.setUpdater = function() {
    $scope.udater = 1;
  };

  window.onfocus = function() {
    if ($scope.udater == 1){
      $scope.getData();
      $scope.udater = 0;
    }
  }

});

spi.controller('RequestFinancePlanController', function ($scope, network, RequestService) {
  //$scope.$parent.requestID
});

spi.controller('RequestSchoolConceptController', function ($scope, network, $timeout, RequestService, $uibModal) {
  // $timeout(function() {
  //   $('.changes-content .heading-changes').click(function(){
  //     $(this).toggleClass('open');
  //     $(this).next().slideToggle();
  //   })
  // });

  $scope.school_concept = {};
  $scope.conceptTab = {};
  $scope.canAccept = ['a','p'].indexOf(network.user.type) !== -1;

  $scope.schoolConcepts = [];
  network.get('request_school_concept', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.schoolConcepts = response.result;
      $scope.setBestStatusByUserType();
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

  $scope.submitForm = function(data, concept, action) {
    switch (action) {
      case 'submit':
        data.status = 'in_progress';
        break;
      case 'reject':
        data.status = 'rejected';
        break;
      case 'accept':
        data.status = 'accepted';
        break;
    }

    network.put('request_school_concept/' + concept.id, data, function(result){
      if(result) {
        concept.status = data.status;
        if(action != 'reject') {
          $scope.school_concept[concept.id].comment = '';
        }
        $scope.setBestStatusByUserType();
      }
    });
  };

  $scope.doCutText = function(newText, oldText, isNew) {
    // TODO: return cut text for history audit
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

spi.controller('RequestSchoolGoalController', function ($scope, network,  RequestService, $window) {

  $scope.userType = network.user.type;
  $scope.schoolGoals = [];
  $scope.activeTab = 0;
  $scope.tabStatus = '';
  $scope.paPriority = {'in_progress': 1, 'rejected': 2, 'unfinished': 3, 'accepted': 4 };
  $scope.taPriority = {'rejected': 1, 'unfinished': 2, 'in_progress': 3, 'accepted': 4 };

  network.get('request_school_goal', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.schoolGoals = response.result;
      $scope.checkSchoolStatus();
    }
  });


  $scope.checkCount = function(group, key, goal){
    if (!('groups' in goal)){goal.groups = {};}
    if (!(group in goal.groups)){
      goal.groups[group] = {};
      goal.groups[group].counter = 0;
    }
    var currentGroup = goal.groups[group];

    if (!(key in currentGroup)){currentGroup[key] = goal[key]}

    switch(goal[key]){
      case '1':
        currentGroup.counter++;
        break;
      case '0':
        if(currentGroup[key] == '1'){currentGroup.counter--;}
        break;
      case '2':
        if(currentGroup[key] == '1'){currentGroup.counter--;}
        break;
    }
    currentGroup[key] = goal[key];
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
          if($scope.paPriority[schools[school].status] < $scope.paPriority[$scope.$parent.goalsStatus] || $scope.$parent.goalsStatus == ''){
            $scope.$parent.setGoalsStatus(schools[school].status);
          }
        }
        break;
      default :
        for (var school in $scope.schoolGoals) {
          var schools = $scope.schoolGoals;
          if($scope.taPriority[schools[school].status] < $scope.taPriority[$scope.$parent.goalsStatus] || $scope.$parent.goalsStatus == ''){
              $scope.$parent.setGoalsStatus(schools[school].status);
            }
        }
      break;
    }
  }

  $scope.activateTab = function(id, index, item){
    $scope.activeTab = id;
    if(!index){angular.element(item).click()}
  }

  $scope.getActivateTab = function(){
    return $scope.activeTab;
  }


  $scope.submitForm = function( school, goal, action ) {
    switch (action) {
      case 'submit':
        goal.status = 'in_progress';
        break;
      case 'declare':
        goal.status = 'rejected';
        break;
      case 'accept':
        goal.status = 'accepted';
        break;
    }

    if ('groups' in goal){delete goal.groups;}
    network.put('request_school_goal/' + goal.id, goal, function(result){
      if(result) {
        $scope.checkSchoolStatus();
      }
    });
  };

  RequestService.getSchoolGoalData = function(){
    var data = {};
    if(angular.isObject($scope.schoolGoals)){
      for (var school in $scope.schoolGoals){
        if(angular.isObject($scope.schoolGoals[school])){
          var goals = $scope.schoolGoals[school].goals;
          for(var goal in goals){
            delete goals[goal].groups;
            data[goals[goal].id]=(goals[goal]);
          }
        }
      }
    }

    return data;
  };


  $scope.readonly = function(goal){
    switch(goal.status){
      case 'unfinished':
        if($scope.userType == 'a' || $scope.userType == 't'){return false;}
        return true;
        break;
      case 'in_progress':
        if($scope.userType == 'a'){return false;}
        return true;
        break;
      case 'rejected':
        if($scope.userType == 'a' || $scope.userType == 't'){return false;}
        return true;
        break;
      case 'accepted':
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



