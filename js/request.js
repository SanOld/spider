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
    var finPlan = RequestService.financePlanData();
    data = angular.extend(data, finPlan.request);
    delete finPlan.request;
    data['finance_plan']    = finPlan;
    data['school_concepts'] = RequestService.getSchoolConceptData();
    data['school_goals']    = RequestService.getSchoolGoalData();
    console.log('SaveRequestDebug',data)
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
          end_fill:                       response.result.end_fill,
          last_change:                    response.result.last_change,
          start_date_unix:                response.result.start_date_unix,
          due_date_unix:                  response.result.due_date_unix,
          end_fill_unix:                  response.result.end_fill_unix,
          last_change_unix:               response.result.last_change_unix,
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
        },
        end_fill: function () {
          return $scope.request.end_fill;
        }
      }
    });

    if ($scope.request.id) {
      modalInstance.result.then(function (data) {
        $scope.request.start_date_unix = isNaN(data.start_date) ? '' : new Date(data.start_date);
        $scope.request.due_date_unix = isNaN(data.due_date) ? '' : new Date(data.due_date) ;

        var start = isNaN(data.start_date) ? '' : Utils.getSqlDate(new Date(data.start_date));
        var end = isNaN(data.due_date) ? '' : Utils.getSqlDate(new Date(data.due_date)) ;

        $scope.request.start_date = start;
        $scope.request.due_date = end;
//        network.patch('request', {ids: ids, start_date: start, due_date: end}, function(result) {
//        });
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

        $scope.request.end_fill_unix = isNaN(data.end_fill) ? '' : new Date(data.end_fill);
        var end_fill = isNaN(data.end_fill) ? '' : Utils.getSqlDate(new Date(data.end_fill));

        $scope.request.end_fill = end_fill;
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

spi.controller('RequestFinancePlanController', function ($scope, network, RequestService, Utils, $timeout) {
  $scope.users = [];

  $scope.IBAN = {};
  $scope.request_users = [{}]; //create one user by default
  $scope.prof_associations = [{}]; //create one association by default
  $scope.financeSchools = [];

  var usersById = {};

  RequestService.financePlanData = function(){
    var data = {};
    data.request =  { 'revenue_description':    $scope.revenue_description
                    , 'revenue_sum':            $scope.revenue_sum
                    , 'emoloyees_cost':         $scope.emoloyeesCost
                    , 'training_cost':          $scope.training_cost
                    , 'overhead_cost':          $scope.overhead_cost
                    , 'prof_association_cost':  $scope.prof_association_cost
                    , 'total_cost':             $scope.total_cost

                    , 'bank_details_id':        $scope.data.bank_details_id
                    }
    data.users = $scope.request_users;
    data.prof_associations = $scope.prof_associations;
    data.schools = $scope.financeSchools;
    var finPlan = angular.copy(data);
    angular.forEach(finPlan.users, function(val, key) {
      val.add_cost = val.addCost
      val.full_cost = val.fullCost
      delete val.user;
      delete val.addCost;
      delete val.fullCost;
    });
    angular.forEach(finPlan.schools, function(val, key) {
      delete val.school_name;
      delete val.school_number;
    });
    return finPlan;
  }

  RequestService.initFinancePlan = function(data){
    $scope.users = data.users;
    $scope.updateUserSelect();
    $scope.data = data;
    $scope.selectFinanceResult = Utils.getRowById($scope.users, data.finance_user_id);

    angular.forEach($scope.users, function(val, key) {
      usersById[val.id] = val;
    });

    network.get('bank_details', {performer_id: data.performer_id}, function (result, response) {
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

  $scope.calculateEmployee = function(empl){
    for(var key in forValidate) {
      $scope.numValidate(empl,key);
    }
    for(var key in toNum) {
      empl[key] = (empl[key] || 0)*1;
    }

    var umlage = empl.is_umlage?0.25:0.21;
    var mc = (empl.month_count || 0) *1;
    empl.brutto = empl.cost_per_month_brutto * mc
                + empl.annual_bonus * empl.have_annual_bonus
                + empl.additional_provision_vwl * mc * empl.have_additional_provision_vwl
                + empl.supplementary_pension * (mc + empl.have_annual_bonus) * empl.have_supplementary_pension;
    empl.brutto = Math.ceil(empl.brutto/100)*100; // Результат округлять вверх до 100 евро. Например: 1201 = 1300

    var summ  = empl.cost_per_month_brutto * mc
              + empl.annual_bonus * empl.have_annual_bonus
              + empl.additional_provision_vwl * mc * empl.have_additional_provision_vwl;
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
        $scope.emoloyeesCost += (empl.fullCost || 0)*1;
      }
    });
    angular.forEach($scope.financeSchools, function(sch, key) {
      $scope.training_cost += (sch.training_cost || 0)*1;
      $scope.overhead_cost += (sch.overhead_cost || 0)*1;
    });
    angular.forEach($scope.prof_associations, function(ps, key) {
      if(!ps.is_deleted) {
        $scope.prof_association_cost += (ps.sum || 0)*1;
      }
    });
    $scope.prof_association_cost = $scope.prof_association_cost || 0;
    $scope.revenue_sum = ($scope.revenue_sum || 0)*1;
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
  $scope.numValidate = function(obj, key,cnt){
    cnt = cnt || 2;
    if(!obj[key]) {
      obj[key] = 0;
    } else {
      obj[key] = obj[key].split(',').join('.');
      obj[key] = obj[key].split(/[^0-9\.]/).join('');
      var r = new RegExp('([0-9]+)([\.]{0,1})([0-9]{0,'+cnt+'})[0-9]*', 'i');
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
    console.log(item);
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
//    console.log(item);
    $scope.updateUserSelect();
    employee.user = item;
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
        }
        break;
      case 'declare':
        if (!goal.notice){
          return false;
        }
        goal.status = 'rejected';
        submitRequest(goal);

        break;
      case 'accept':
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



