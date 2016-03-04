spi.controller('UserController', function ($scope, $rootScope, network, GridService, HintService, Utils) {
  if (!$rootScope._m) {
    $rootScope._m = 'user';
  }
  $scope.filter = {is_active: 1};

  if ($scope.page) {
    $scope.filter['type'] = $scope.page; // t - performer, d - district, s - school
    $scope.filter['relation_id'] = $scope.relationId;
  }

  $scope.statuses = [
    {id: 1, name: 'Aktiv'},
    {id: 0, name: 'Deaktivieren'}
  ];

  network.get('user_type', angular.merge({filter: 1}, $scope.filter['type'] ? {type: $scope.filter['type']} : {}), function (result, response) {
    if (result) {
      $scope.userTypes = response.result;

      var rowTA = null;
      for (var i = 0; i < $scope.userTypes.length; i++) {
        if ($scope.userTypes[i].type == 't') {
          rowTA = $scope.userTypes[i];
          break;
        }
      }
      if(rowTA) {
        $scope.userTypes.push({id: rowTA.id+'_1', name: rowTA.name + ' (F)', 'type': rowTA.type});
        rowTA.id += '_0'
      }
    }
  });

  HintService('user', function (result) {
    $scope._hint = result;
  });

  var grid = GridService();
  $scope.tableParams = grid('user', $scope.filter, {sorting: {name: 'asc'}});

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };

  $scope.updateGrid = function () {
    var rowType = Utils.getRowById($scope.userTypes, $scope.filter.type_id);
    if(rowType.type == 't') {
      $scope.filter.is_finansist = rowType.id.split('_')[1];
    } else {
      delete $scope.filter.is_finansist;
    }
    grid.reload();
  };

  $scope.openEdit = function (row) {
    grid.openEditor({
      data: row,
      hint: $scope._hint,
      controller: 'UserEditController',
      template: 'editUserTemplate.html'
    });
  };

  $scope.canCreate = function () {
    return $rootScope.canEdit() && network.user.type == 'a' && !network.userIsSENAT;
  };

});


