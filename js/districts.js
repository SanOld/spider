spi.controller('DistrictController', function ($scope, $rootScope, network, GridService) {
  $rootScope._m = 'district';
  $scope.filter = {};

  var grid = GridService();
  $scope.tableParams = grid('district', $scope.filter, {sorting: {name: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
  };

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };

  try {
    var id = /id=(\d+)/.exec(location.hash)[1];
    if(location.pathname.indexOf('districts') != -1 && id) {

      network.get('district', {'id': id}, function (result, response) {
        if (result && response.result.length) {
          $scope.openEdit(response.result[0], !$scope.canEdit(id))
        }
      });

    }
  } catch(e) {}

  $scope.openEdit = function (row, modeView) {
    grid.openEditor({
      data: row,
      hint: $scope._hint,
      modeView: !!modeView,
      size: 'width-full',
      controller: 'EditDistrictController'
    });
  };

  $scope.canEdit = function(id) {
    return $rootScope.canEdit() || (id == network.user.relation_id && network.user.type == 'd');
  }
});


spi.controller('EditDistrictController', function ($scope, $uibModalInstance, modeView, $rootScope, data, network, hint, Utils, localStorageService) {
  $scope.isInsert = !data.id;
  $scope._hint = hint;
  $scope.modeView = modeView;
  $scope.district = {};

  if (!$scope.isInsert) {
    $scope.districtId = data.id;
    $scope.district = {
      name: data.name,
      address: data.address,
      plz: data.plz,
      city: data.city,
      phone: data.phone,
      fax: data.fax,
      email: data.email,
      homepage: data.homepage,
      contact_id: data.contact_id
    };
    getUsers();
  }

  function getUsers() {
    network.get('user', {filter: 1, is_active: 1, relation_id: data.id, type: 'd'}, function (result, response) {
      if (result) {
        $scope.users = response.result;
        if (data.contact_id) {
          $scope.contactUser = Utils.getRowById($scope.users, data.contact_id);
        }
      }
    });
  }

  $scope.changeContactUser = function (userId) {
    $scope.contactUser = Utils.getRowById($scope.users, userId);
  };

  $scope.fieldError = function (field) {
    var form = $scope.form.formDistrict;
    return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid || ($scope.error && $scope.error[field] != undefined && form[field].$pristine);
  };

  $scope.submitFormDistrict = function () {
    $scope.error = false;
    $scope.submited = true;
    $scope.form.formDistrict.$setPristine();
    if ($scope.form.formDistrict.$valid) {
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
        network.post('district', $scope.district, callback);
      } else {
        network.put('district/' + data.id, $scope.district, callback);
      }
    }
  };


  $scope.remove = function () {
    Utils.doConfirm(function() {
      network.delete('district/' + data.id, function (result) {
        if (result) {
          Utils.deleteSuccess();
          $uibModalInstance.close();
        }
      });
    });
  };

  $scope.$on('modal.closing', function(event, reason, closed) {
    Utils.modalClosing($scope.form.formDistrict, $uibModalInstance, event, reason);
  });

  $scope.cancel = function () {
    Utils.modalClosing($scope.form.formDistrict, $uibModalInstance);
  };

  function getError(code) {
    var result = false;
    switch (code) {
      case 'ERR_DUPLICATED':
        result = {name: {dublicate: true}};
        break;
    }
    return result;
  }

  $scope.canEditDistrict = function() {
    return $rootScope.canEdit() || data.id == network.user.relation_id;
  }
  $scope.canByType = function(types) {
    return types.indexOf(network.user.type) != -1;
  }

});