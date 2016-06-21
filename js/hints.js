spi.controller('HintsController', function ($scope, $rootScope, network, GridService) {
  $rootScope._m = 'hint';
  $scope.filter = {};

  var grid = GridService();
  $scope.tableParams = grid('hint', $scope.filter);

  $scope.updateGrid = function () {
    grid.reload();
  };

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };

  $scope.openEdit = function (row, modeView) {
    grid.openEditor({
      data: row,
      modeView: !!modeView,
      hint: $scope._hint,
      controller: 'EditHintController'
    }, function(result) {
      if(result) {
        $scope.updateGrid();
        $scope.$parent.setHints();
      }
    });
  };

  network.get('page', {filter: 1}, function (result, response) {
    if (result) {
      $scope.pages = response.result;
    }
  });

});


spi.controller('EditHintController', function ($scope, $uibModalInstance, data, modeView, network, hint, Utils) {
  $scope.isInsert = !data.id;
  $scope._hint = hint;
  $scope.hint = {};
  $scope.showTitle = false;
  $scope.modeView = modeView;

  function reloadPosition() {
    $scope.positions = [];
    if ($scope.hint.page_id) {
      network.get('page_position', {
        filter: 1,
        page_id: $scope.hint.page_id
      }, function (result, response) {
        if (result) {
          $scope.positions = response.result;
        }
      });
    }
  }

  $scope.changePage = function () {
    $scope.hint.position_id = undefined;
    $scope.hint.title = $scope.hint.description = '';
    $scope.form.$setUntouched();
    $scope.changePosition();
    reloadPosition();
  };

  $scope.changePosition = function (id) {
    if(!id) {
      return false;
    }
    $scope.showTitle = Utils.getRowById($scope.positions, id, 'code') == 'header';
    network.get('hint', {position_id: id}, function(result, response) {
      if(result && response.result.length) {
        $scope.hint.title = response.result[0].title;
        $scope.hint.description = response.result[0].description;
        data.id = response.result[0].id;
      } else {
        delete data.id;
      }
    });
  };

  if (!$scope.isInsert) {

    $scope.page_name = data.page_name;
    $scope.position_name = data.position_name;
    $scope.showTitle = data.position_code == 'header';
    $scope.hint = {
      title: data.title,
      description: data.description
    };
    reloadPosition();
  } else {
    network.get('page', {filter: 1}, function (result, response) {
      if (result) {
        $scope.pages = response.result;
      }
    });
  }

  $scope.fieldError = function (field) {
    return $scope.form[field] && ($scope.submited || $scope.form[field].$touched) && $scope.form[field].$invalid;
  };

  $scope.submitForm = function (formData) {
    $scope.submited = true;
    $scope.form.$setPristine();
    if ($scope.form.$valid) {
      var callback = function (result, response) {
        if (result) {
          $uibModalInstance.close();
        }
        $scope.submited = false;
      };
      if (!data.id) {
        network.post('hint', formData, callback);
      } else {
        network.put('hint/' + data.id, formData, callback);
      }
    }
  };

  $scope.remove = function () {
    Utils.doConfirm(function() {
      network.delete('hint/' + data.id, function (result) {
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

});