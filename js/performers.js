spi.controller('PerformerController', function ($scope, $rootScope, network, GridService, HintService) {
  $rootScope._m = 'performer';
  $scope.filter = {};
  $scope.checks = [{id: 1, name: 'Checked'}, {id: 0, name: 'Not checked'}];

  var grid = GridService();
  $scope.tableParams = grid('performer', $scope.filter, {sorting: {name: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
  };

  HintService('performer', function (result) {
    $scope._hint = result;
  });

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };

  $scope.openEdit = function (row, modeView) {
    grid.openEditor({
      data: row,
      hint: $scope._hint,
      modeView: !!modeView,
      size: 'width-full',
      controller: 'EditPerformerController'
    });
  };

  $scope.canCreate = function () {
    return $rootScope.canEdit() && network.user['type'] != 't';
  };

  $scope.canEdit = function(id) {
    return $rootScope.canEdit() || id == network.user.relation_id;
  };

});


spi.controller('EditPerformerController', function ($scope, $rootScope, filterFilter, $anchorScroll, $location, modeView, $uibModalInstance, data, network, hint, Utils, Notification, SweetAlert) {
  $scope.isInsert = !data.id;
  $scope.performerId = data.id;
  $scope.formBank = [];
  $scope.bank_details = [];
  $scope._hint = hint;
  $scope.modeView = modeView;
  $scope.isFinansist = network.user.type == 'a' || (network.user.type == 't' && parseInt(network.user.is_finansist));
  $scope.tabs = [{active: true}];

  $scope.canEditPerformer = function() {
    return $rootScope.canEdit() || data.id == network.user.relation_id;
  };

  if (!$scope.isInsert) {
    $scope.documents = [];
    $scope.performer = {
      name: data.name,
      short_name: data.short_name,
      address: data.address,
      plz: data.plz,
      city: data.city,
      phone: data.phone,
      email: data.email,
      homepage: data.homepage,
      company_overview: data.company_overview,
      diversity: data.diversity,
      further_education: data.further_education,
      quality_standards: data.quality_standards,
      comment: data.comment,
      is_checked: data.is_checked,
      representative_user_id: data.representative_user_id,
      application_processing_user_id: data.application_processing_user_id,
      budget_processing_user_id: data.budget_processing_user_id,
    };
    getUsers();
    if ($scope.isFinansist) {
      getBankDetails();
    }
    if($scope.canView() && $scope.isFinansist) {
      getDocuments();
      $scope.qqSetting = {
        model: 'performer_document',
        customHeaders:{Authorization: network.token},
        params: {id: data.id},
        buttonText: 'Dokumente hinzufügen',
        onCompile: function (id, fileName, responseJSON) {
          if (responseJSON.result) {
            Notification.success({title: 'File upload success!', message: responseJSON.message});
            getDocuments();
          } else {
            Notification.error({title: 'File upload fail!', message: responseJSON.message});
          }
        }
      }
    }
  } else {
    $scope.performer = {is_checked: 0};
  }


  function getUsers() {
    network.get('user', {filter: 1, is_active: 1, relation_id: data.id, type: 't'}, function (result, response) {
      if (result) {
        $scope.users = response.result;
        $scope.financeUsers = filterFilter(response.result, {is_finansist: "1"});
        if (data.is_checked) {
          $scope.checkedBy = data.checked_name;
          $scope.checkedDate = data.checked_date_formatted;
        }
        if (data.representative_user_id) {
          $scope.representativeUser = Utils.getRowById($scope.users, data.representative_user_id);
        }
        if (data.application_processing_user_id) {
          $scope.applicationProcessingUser = Utils.getRowById($scope.users, data.application_processing_user_id);
        }
        if (data.budget_processing_user_id) {
          $scope.budgetProcessingUser = Utils.getRowById($scope.users, data.budget_processing_user_id);
        }
      }
    });
  }

  function getBankDetails() {
    network.get('bank_details', {performer_id: data.id}, function (result, response) {
      if (result) {
        $scope.showBankDetails = true;
        $scope.bank_details = response.result;
      }
    });
  }

  function getDocuments() {
    network.get('performer_document', {performer_id: data.id}, function (result, response) {
      if (result) {
        $scope.documents = response.result;
      }
    });
  }

  $scope.addBankForm = function() {
    $scope.bank_details.unshift({
      performer_id: data.id,
    });
    $location.hash('formBank0');
    $anchorScroll();
  };

  $scope.changeRepresentativeUser = function (userId) {
    $scope.representativeUser = Utils.getRowById($scope.users, userId);
  };

  $scope.changeApplicationProcessingUser = function (userId) {
    $scope.applicationProcessingUser = Utils.getRowById($scope.users, userId);
  };

  $scope.changeBudgetProcessingUser = function (userId) {
    $scope.budgetProcessingUser = Utils.getRowById($scope.users, userId);
  };

  $scope.fieldError = function (innerForm, field) {
    var form = innerForm ? $scope.form[innerForm] : $scope.form;
    if (!form || !form[field]) return false;
    return ($scope.submited || form[field].$touched) && form[field].$invalid  || ($scope.error && $scope.error[field] != undefined && form[field].$pristine);
  };

  $scope.submitFormPerformer = function () {
    $scope.error = false;
    $scope.submited = true;
    $scope.form.formPerformer.$setPristine();
    if ($scope.form.formPerformer.$valid) {
      var callback = function (result, response) {
        if (result) {
          $uibModalInstance.close();
        } else {
          $scope.error = getError(response.system_code);
        }
        $scope.submited = false;
      };
      if ($scope.isInsert) {
        network.post('performer', $scope.performer, callback);
      } else {
        network.put('performer/' + data.id, $scope.performer, callback);
      }
    } else {
      $scope.tabs[0].active = true;
    }
  };

  $scope.saveBankDetails = function (formData, index) {
    $scope.submited = true;
    var form = $scope.form['formBank'+index];
    form.$setPristine();
    if (form.$valid) {
      delete formData['$$hashKey'];
      if (!formData.id) {
        network.post('bank_details', angular.merge(formData, {performer_id: data.id}), function (result, response) {
          if (result) {
            $scope.bank_details[index].id = response.id;
            $scope.submited = false;
          }
        });
      } else {
        network.put('bank_details/' + formData.id, formData);
        $scope.submited = false;
      }
    }
  };

  $scope.removeBankDetails = function (bank, index) {
    if(bank.id) {
      network.delete('bank_details/' + bank.id, function (result) {
        if (result) {
          $scope.bank_details.splice(index, 1);
        }
      });
    } else {
      $scope.bank_details.splice(index, 1);
    }
  };

  $scope.removeDocument = function (docId) {
    SweetAlert.swal({
        title: "Sind Sie sicher?",
        text: "Diese Datei wird nicht wiedererstellt!",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "ABBRECHEN",
        confirmButtonText: "JA, LÖSCHEN!",
        closeOnConfirm: false
      },
      function (isConfirm) {
        if (isConfirm) {
          network.delete('performer_document/' + docId, function (result, response) {
            SweetAlert.swal("Gelöscht!", "Ihre Datrei ist erfolgreich gelöscht!", "success");
            getDocuments();
          }, false);
        }
      }
    );
  };

  $scope.remove = function () {
    Utils.doConfirm(function() {
      network.delete('performer/' + data.id, function (result) {
        if (result) {
          $uibModalInstance.close();
        }
      });
    });
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };


  $scope.types = [{id: 0, name: 'Performer'}, {id: 1, name: 'Performer (F)'}];

  $scope.canEditBankInfo = function() {
    return network.user['type'] == 't' ? $rootScope.canEdit('bank_details') && parseInt(network.user.is_finansist) : $rootScope.canEdit();
  };



  $scope.canDelete = function() {
    return $rootScope.canEdit() && !(network.user['type'] == 'a' && network.userIsPA);
  };

  function getError(code) {
    var result = false;
    switch (code) {
      case 'ERR_DUPLICATED':
        result = {name: {dublicate: true}};
        break;
      case 'ERR_DUPLICATED_SHORT_NAME':
        result = {short_name: {dublicate: true}};
        break;
    }
    return result;
  }

});