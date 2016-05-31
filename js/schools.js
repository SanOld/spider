spi.controller('SchoolController', function ($scope, $rootScope, network, GridService) {
  $rootScope._m = 'school';
  $scope.filter = {};

  if ($scope.page) {
    switch ($scope.page) {
      case 'district':
        $scope.filter['district_id'] = $scope.districtId;
        break;
    }
  }

  var grid = GridService();
  $scope.tableParams = grid('school', $scope.filter, {sorting: {number: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
  };

  network.get('school_type', {filter: 1}, function (result, response) {
    if (result) {
      $scope.schoolTypes = response.result;
    }
  });

  if (!$scope.page || $scope.page != 'district') {
    network.get('district', {filter: 1}, function (result, response) {
      if (result) {
        $scope.districts = response.result;
      }
    });
  }


  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };

  try {
    var id = /id=(\d+)/.exec(location.hash)[1];
    if(id) {
      
    network.get('school', {'id': id}, function (result, response) {
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
      controller: 'EditSchoolController',
      template: 'EditSchoolTemplate.html'
    });
  };

  $scope.canEdit = function(id) {
    return $rootScope.canEdit() || id == network.user.relation_id;
  }


});


spi.controller('EditSchoolController', function ($scope, $rootScope, modeView, $uibModalInstance, data, network, hint, Utils) {
  $scope.isInsert = !data.id;
  $scope._hint = hint;
  $scope.school = {};
  $scope.modeView = modeView;
  var next_id = 1;

  if (!$scope.isInsert) {
    $scope.schoolId = data.id;
    $scope.school = {
      name: data.name,
      district_id: data.district_id,
      address: data.address,
      plz: data.plz,
      city: data.city,
      number: data.number,
      type_id: data.type_id,
      phone: data.phone,
      fax: data.fax,
      email: data.email,
      homepage: data.homepage,
      contact_id: data.contact_id
    };
    getUsers();
  } else {
    network.get('school', {get_next_id: 1}, function (result, response) {
      if (result) {
        next_id = response.next_id;
      }
    });
  }

  $scope.setNumber = function (typeId) {
    if ($scope.isInsert) {
      $scope.school.number = Utils.getRowById($scope.schoolTypes, typeId, 'code') + next_id;
    }
  };

  network.get('school_type', {filter: 1}, function (result, response) {
    if (result) {
      $scope.schoolTypes = response.result;
      if($scope.school.type_id) {
        $scope.schoolName = Utils.getRowById($scope.schoolTypes, $scope.school.type_id, 'name');
      }
    }
  });

  network.get('district', {filter: 1}, function (result, response) {
    if (result) {
      $scope.districts = response.result;
      if($scope.school.district_id) {
        $scope.districtName = Utils.getRowById($scope.districts, $scope.school.district_id, 'name');
      }
    }
  });

  function getUsers() {
    network.get('user', {is_active: 1, fitler: 1, relation_id: data.id, type: 's'}, function (result, response) {
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
    var form = $scope.form.formSchool;
    return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid || ($scope.error && $scope.error[field] != undefined && form[field].$pristine);
  };

  $scope.submitFormSchool = function () {
    $scope.error = false;
    $scope.submited = true;
    $scope.form.formSchool.$setPristine();
    if ($scope.form.formSchool.$valid) {
      var callback = function (result, response) {
        if (result) {
          $uibModalInstance.close();
        } else {
          $scope.error = getError(response.system_code);
        }
        $scope.submited = false;
      };
      if ($scope.isInsert) {
        network.post('school', $scope.school, callback);
      } else {
        network.put('school/' + data.id, $scope.school, callback);
      }
    }
  };


  $scope.remove = function () {
    Utils.doConfirm(function() {
      network.delete('school/' + data.id, function (result) {
        if (result) {
          Utils.deleteSuccess();
          $uibModalInstance.close();
        }
      });
    });
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
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

  $scope.canEditSchool = function() {
    return $rootScope.canEdit() || data.id == network.user.relation_id;
  }
  $scope.canByType = function(types) {
    return types.indexOf(network.user.type) != -1;
  }

});