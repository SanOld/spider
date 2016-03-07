spi.controller('main', function ($scope, $rootScope, network, GridService, localStorageService, $timeout) {
  $scope._r = localStorageService.get('rights');

  $scope.canShow = function (model) {
    model = model || $rootScope._m;
    return !model || !$scope._r[model] ? 1 : $scope._r[model].show;
  };

  $rootScope.canView = function (model) {
    model = model || $rootScope._m;
    return !model || !$scope._r[model] ? 1 : $scope._r[model].view;
  };

  $rootScope.canEdit = function (model) {
    model = model || $rootScope._m;
    return !model || !$scope._r[model] ? 1 : $scope._r[model].edit;
  };

  $timeout(function() {
    if($rootScope._m && $rootScope._m != 'dashboard' && $scope._r[$rootScope._m] && !$scope._r[$rootScope._m].show) {
      window.location = '/dashboard';
    }
  });

  $scope.isLogin = network.isLogined();
  if ($scope.isLogin) {
    $scope.user = network.user;
  } else {
    window.location = '/'
  }

  $scope.logout = function () {
    network.logout();
  };
  network.onLogout = function () {
    window.location = '/'
  };

  $scope.openEdit = function () {
    GridService().openEditor({
      data: $scope.user,
      controller: 'UserEditController',
      template: 'editUserTemplate.html'
    }, function () {
      $scope.user = network.user;
    });

  };

});

spi.controller('UserEditController', function ($scope, $rootScope, $uibModalInstance, data, network, localStorageService, hint, HintService, Utils, Notification) {
  $scope.model = 'user';
  $scope.isInsert = true;
  $scope.user = {
    is_active: 1,
    is_finansist: 0,
    sex: 1
  };

  if (!hint) {
    HintService($scope.model, function (result) {
      $scope._hint = result;
    });
  } else {
    $scope._hint = hint;
  }

  if (data.id) {
    $scope.isInsert = false;
    $scope.userId = data.id;
    $scope.type_name = data.type_name;
    $scope.relation_name = data.relation_name;
    $scope.user = {
      is_active: +data.is_active,
      is_finansist: +data.is_finansist,
      sex: +data.sex,
      title: data.title,
      function: data.function,
      first_name: data.first_name,
      last_name: data.last_name,
      login: data.login,
      email: data.email,
      phone: data.phone,
      type_id: data.type_id
    };
    $scope.isCurrentUser = network.user.id == data.id;
    $scope.isPerformer = data.type == 't';
  }
  if (!data.id || $scope.isPerformer) {
    network.get('user_type', angular.merge({filter: 1}, $scope.isPerformer ? {type: 't'} : {}), function (result, response) {
      if (result) {
        $scope.userTypes = response.result;
      }
    });
  }

  $scope.reloadRelation = function () {
    $scope.relations = [];
    var type = Utils.getRowById($scope.userTypes, $scope.user.type_id);
    $scope.isRelation = type && type.relation_code;
    $scope.isPerformer = type && type.type == 't';
    if ($scope.isRelation) {
      $scope.isRelation = true;
      network.get(type.relation_code, {filter: 1}, function (result, response) {
        if (result) {
          $scope.relations = response.result;
        }
      });
    }
  };

  $scope.fieldError = function (field) {
    return (($scope.submited || $scope.form[field].$touched) && $scope.form[field].$invalid) || ($scope.error && $scope.error[field] != undefined && $scope.form[field].$pristine);
  };

  $scope.submitForm = function (formData) {
    $scope.error = false;
    $scope.submited = true;
    $scope.form.$setPristine();
    if ($scope.form.$valid) {
      var callback = function (result, response) {
        if (result) {
          if ($scope.isCurrentUser) {
            network.reconnect(function () {
              $uibModalInstance.close();
            });
          } else {
            $uibModalInstance.close();
          }
        } else {
          $scope.error = getError(response.system_code);
        }
        $scope.submited = false;
      };
      if ($scope.isInsert) {
        network.post($scope.model, formData, callback);
      } else {
        network.put($scope.model + '/' + data.id, formData, callback);
      }
    } else {
      console.log('not valid');
    }
  };

  $scope.remove = function (id) {
    Utils.doConfirm(function() {
      network.delete('user/' + id, function (result) {
        if (result) {
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
        result = {login: {dublicate: true}};
        break;
      case 'ERR_DUPLICATED_EMAIL':
        result = {email: {dublicate: true}};
        break;
      case 'ERR_CURRENT_PASSWORD':
        result = {old_password: {error: true}};
        break;
    }
    return result;
  }

  $scope.canDelete = function() {
    return $rootScope.canEdit() && !network.userIsPA;
  };

  $scope.canEdit = function() {
    return $scope.isCurrentUser || ($rootScope.canEdit() && !(network.userIsPA && data.type_id == 1));
  };


});