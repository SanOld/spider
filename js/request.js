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
    RequestService.setRequestCode($scope.requestYear + ' (' + $scope.projectID + ')');
  };
  $scope.setRequestYear = function(requestYear){
    $scope.requestYear = requestYear;
    RequestService.setRequestCode($scope.requestYear + ' (' + $scope.projectID + ')');
  };

  $scope.submitRequest = function (close) {
    close = close || false;
    var data = RequestService.getProjectData();
    data['finance_plan']    = RequestService.financePlanData();
    data['school_concepts'] = RequestService.getSchoolConceptData();
    data['school_goals']    = RequestService.getSchoolGoalData();
    network.put('request/' + $scope.requestID, data, function(result, response) {
      if(result && close) {
       location.href = '/requests';
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

spi.controller('RequestProjectDataController', function ($scope, network, Utils, $uibModal, SweetAlert, RequestService, localStorageService) {
  $scope.filter = {id: $scope.$parent.requestID};
  $scope.isInsert = !$scope.$parent.requestID;
  $scope.udater = 0;
  localStorageService.set('dataChanged', 0);

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
            $scope.data['users'] = $scope.performerUsers;
            RequestService.initAll($scope.data);
          }

        });

      }
    });
  }

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

  window.onfocus = function() {
    if (localStorageService.get('dataChanged') === '1'){
      $scope.updateData();
      localStorageService.set('dataChanged', 0);
    }
  }

});

spi.controller('RequestFinancePlanController', function ($scope, network, RequestService, Utils) {
  $scope.users = [];
  RequestService.initFinancePlan = function(data){
    $scope.users = data.users;
    $scope.data = data;
    $scope.selectFinanceResult = Utils.getRowById($scope.users, data.finance_user_id);

    network.get('bank_details', {performer_id: data.performer_id}, function (result, response) {
      if (result) {
        $scope.bank_details = response.result;
      }
    });

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
});

spi.controller('RequestSchoolConceptController', function ($scope, network, $timeout, RequestService, $uibModal) {
  // TODO: Open history changes. Need do it into css.
  $timeout(function() {
    angular.element('.changes-content .heading-changes').click(function(){
      angular.element(this).toggleClass('open');
      angular.element(this).next().slideToggle();
    })
  });

  $scope.school_concept = {};
  $scope.conceptTab = {};
  $scope.canAccept = ['a','p'].indexOf(network.user.type) !== -1;
  $scope.canFormEdit = ['a','t'].indexOf(network.user.type) !== -1;

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
        if(!data.situation || !data.offers_youth_social_work) return false;
        break;
      case 'reject':
        data.status = 'rejected';
        if(!data.comment) return false;
        break;
      case 'accept':
        data.status = 'accepted';
        break;
    }

    network.put('request_school_concept/' + concept.id, data, function(result){
      if(result) {
        concept.status = data.status;
        if(data.status != 'rejected') {
          $scope.school_concept[concept.id].comment = '';
        } else {
          concept.comment = data.comment;
        }
        $scope.setBestStatusByUserType();
      }
    });
  };

  $scope.doCutText = function(newText, oldText, isNew) {
    var diffMatch = new diff_match_patch();
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

spi.controller('RequestSchoolGoalController', function ($scope, network,  RequestService, $window) {

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

    switch (action) {
      case 'submit':
        if(!$scope.error){
          goal.status = 'in_progress';
          submitRequest(goal);
        } else {
          $scope.showError();
        }
        break;
      case 'declare':
        if (!goal.notice){
          return false;
        }
        submitRequest(goal);
        goal.status = 'rejected';

        break;
      case 'accept':
        submitRequest(goal);
        goal.status = 'accepted';
        break;
    }

    submitRequest = function(){
        if ('groups' in goal){delete goal.groups;}
          network.put('request_school_goal/' + goal.id, goal, function(result){
            if(result) {
              $scope.checkSchoolStatus();
            }
        });
      }
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
        if( $scope.userType == 'a' || $scope.userType == 't'){return false;}
        return true;
        break;
      case 'in_progress':
        if( $scope.userType == 'a' ){return false;}
        return true;
        break;
      case 'rejected':
        if( $scope.userType == 'a' || $scope.userType == 't'){return false;}
        return true;
        break;
      case 'accepted':
        return true;
      break;
    }
  }

  $scope.fieldError = function (field) {
    if(field == undefined || field == ''){
    $scope.error = true;
    return true;
    }
    return false;
  }
  $scope.groupError = function(group){
    if(group.counter == undefined || group.counter == 0){
      group.error = '1';
      $scope.error = true;
      return true;
    } else {
      group.error = '0';
      return false;
    }

  }
  $scope.showError = function(){
    return $scope.errorShow = true;
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



