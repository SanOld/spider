spi.controller('DistrictController', function ($scope, $rootScope, network, GridService, HintService) {
  $rootScope._m = 'district';
  $scope.filter = {};

  var grid = GridService();
  $scope.tableParams = grid('district', $scope.filter, {sorting: {name: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
  };

  HintService('district', function (result) {
    $scope._hint = result;
  });

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };

  $scope.openEdit = function (row) {
    grid.openEditor({data: row, hint: $scope._hint, size: 'width-full', controller: 'EditDistrictController'});
  };


});


spi.controller('EditDistrictController', function ($scope, $uibModalInstance, data, network, hint, Utils) {
  $scope.isInsert = !data.id;
  $scope._hint = hint;
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
    network.get('user', {filter: 1, is_active: 1}, function (result, response) {
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
    return ($scope.submited || form[field].$touched) && form[field].$invalid;
  };

  $scope.submitFormDistrict = function () {
    $scope.submited = true;
    $scope.form.formDistrict.$setPristine();
    if ($scope.form.formDistrict.$valid) {
      var callback = function (result, response) {
        if (result) {
          $uibModalInstance.close();
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
    network.delete('district/' + data.id, function (result) {
      if (result) {
        $uibModalInstance.close();
      }
    });
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});