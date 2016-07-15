spi.controller('PerformerController', function ($scope, $rootScope, network, GridService) {
  $rootScope._m = 'performer';
  $scope.filter = {};
  $scope.checks = [{id: 1, name: 'Überprüft'}, {id: 0, name: 'Nicht überprüft'}];
  $scope.isPerformer = network.user.type == 't';

  var grid = GridService();
  $scope.tableParams = grid('performer', $scope.filter, {sorting: {name: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
  };

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

  try {
    var id = /id=(\d+)/.exec(location.hash)[1];
    if(location.pathname.indexOf('performers') != -1 && id) {
      network.get('performer', {'id': id}, function (result, response) {
        if (result && response.result.length) {
          $scope.openEdit(response.result[0], !$scope.canEdit(id))
        }
      });
    }
  } catch(e) {}

  $scope.canCreate = function () {
    return $rootScope.canEdit() && network.user['type'] != 't';
  };

  $scope.canEdit = function(id) {
    return $rootScope.canEdit() || network.user.type == 'p' || (id == network.user.relation_id && network.user.type == 't');
  };

  $scope.isOwn = function(id) {
    return id == network.user.relation_id;
  };

});


spi.controller('EditPerformerController', function ($scope, $rootScope, filterFilter, $anchorScroll, $location, modeView, $uibModalInstance, data, network, hint, Utils, Notification, SweetAlert, $timeout, localStorageService) {
  $scope.isInsert = !data.id;
  $scope.performerId = data.id;
  $scope.formBank = [];
  $scope.bank_details = [];
  $scope._hint = hint;
  $scope.modeView = modeView;
  $scope.isFinansist = network.user.type == 'a' || network.user.type == 'p' || (network.user.type == 't' && parseInt(network.user.is_finansist));
  $scope.tabActive = 0;
  $scope.user_type = network.user.type;
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
      fax: data.fax,
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
            //Notification.success({title: 'File upload success!', message: responseJSON.message});
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
        if (data.is_checked) {
          $scope.checkedBy = data.checked_name;
          $scope.checkedDate = data.checked_date_formatted;
        }
        if (data.representative_user_id) {
          $scope.representativeUser = Utils.getRowById($scope.users, data.representative_user_id);
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
    if($scope.bank_details.length == 10 ){
       SweetAlert.swal({
         title: "",
         text: "Es ist möglich nur zehn Konten hinzufügen!",
         type: "warning",
         confirmButtonText: "OK",
         closeOnConfirm: true
       });
     }else{
       $scope.bank_details.unshift({
         performer_id: data.id,
       });
       $location.hash('formBank0');
       $anchorScroll();
     }
  };

  $scope.changeRepresentativeUser = function (userId) {
    $scope.representativeUser = Utils.getRowById($scope.users, userId);
  };

  $scope.fieldError = function (innerForm, field) {
    var form = innerForm ? $scope.form[innerForm] : $scope.form;
    if (!form || !form[field]) return false;
    return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid  || ($scope.error && $scope.error[field] != undefined && form[field].$pristine);
  };

  $scope.submitFormPerformer = function () {
    var formBankValid = true;
    $scope.submited = true;

    for(var i=0; i<$scope.bank_details.length; i++) {
      var form = $scope.form['formBank'+i];
      form.$setPristine();
      if (form.$invalid) {
        $scope.tabActive = 0;
        $location.hash('formBank'+i);
        $timeout(function() {
          $anchorScroll();
        });
        formBankValid = false;
        break;
      }
    }


    if(formBankValid) {
      for(var i=0; i<$scope.bank_details.length; i++) {
        $scope.saveBankDetails($scope.bank_details[i], i, true);
      }
      savePerformer();
    }

    function savePerformer() {
      $scope.error = false;
      $scope.submited = true;
      $scope.form.formPerformer.$setPristine();
      if ($scope.form.formPerformer.$valid) {
        var callback = function (result, response) {
          if (result) {
            $uibModalInstance.close();
            localStorageService.set('dataChanged', 1);
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
        $scope.tabActive = 0;
      }
    }
  };

  $scope.saveBankDetails = function (formData, index, bulk, callback) {
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
          if(callback) {
            callback(result, index);
          }
        });
      } else {
        network.put('bank_details/' + formData.id, formData, function(result, response) {
          if (result) {
            $scope.submited = false;
          }
          if(callback) {
            callback(result, index);
          }
        }, !bulk);
      }
    } else {
      $scope.tabActive = 0;
      $location.hash('formBank'+index);
      $timeout(function() {
        $anchorScroll();
      });
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
          });
        }
      }
    );
  };

  $scope.remove = function () {
    Utils.doConfirm(function() {
      network.delete('performer/' + data.id, function (result) {
        if (result) {
          Utils.deleteSuccess();
          $uibModalInstance.close();
        }
      });
    });
  };

  $scope.$on('modal.closing', function(event, reason, closed) {
    Utils.modalClosing($scope.form, $uibModalInstance, event, reason);    
  });

  $scope.cancel = function () {
    Utils.modalClosing($scope.form, $uibModalInstance);
  };

  $scope.types = [{id: 0, name: 'Performer'}, {id: 1, name: 'Performer (F)'}];

  $scope.canEditBankInfo = function() {
    return network.user['type'] == 't' ? $rootScope.canEdit('bank_details') && parseInt(network.user.is_finansist) : $rootScope.canEdit();
  };

  $scope.canDelete = function() {
    return $rootScope.canEdit() && network.user['type'] == 'a';
  };
//  $scope.canByType = function(types) {
//    return types.indexOf(network.user.type) != -1;
//  }
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

  $scope.saveText = function (name) {
    if($scope.performer[name] != undefined) {
      var params = {};
      params[name] = $scope.performer[name];
      network.put('performer/' + data.id, params);
    }
  };

});