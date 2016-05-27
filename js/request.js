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
  network.get('Request', $scope.filter, function (result, response) {
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


  network.get('DocumentTemplateType', {filter: 1}, function (result, response) {
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

spi.controller('RequestSchoolConceptController', function ($scope, network, $timeout, RequestService) {
  $scope.school_concept = {};
  $timeout(function() {
    jQuery('.btn-toggle').click(function(){
      $(this).find(".btn").toggleClass('active');
      $(this).find(".btn").toggleClass('btn-default');
      return false;
    });
    $('.tabs-toggle button').click(function(){
      var tab_id = $(this).attr('data-tab');
      $('.block-concept').removeClass('current');
      $("#"+tab_id).addClass('current');
    });
    $('.changes-content .heading-changes').click(function(){
      $(this).toggleClass('open');
      $(this).next().slideToggle();
    })
  });

  $scope.schoolConcepts = [];
  network.get('request_school_concept', {request_id: $scope.$parent.requestID}, function (result, response) {
    if (result) {
      $scope.schoolConcepts = response.result;
    }
  });

  RequestService.getSchoolConceptData = function() {
    return $scope.school_concept;
  };

  $scope.submitForm = function(data, ID, action) {
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
    network.put('request_school_concept/' + ID, data, function(result, response) {
      console.log(result, response);
    });
  };

});

spi.controller('RequestSchoolGoalController', function ($scope, network, RequestService) {
  //$scope.$parent.requestID
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



