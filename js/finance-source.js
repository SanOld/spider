spi.controller('FinanceSourceController', function($scope, $rootScope, network, GridService) {
    $rootScope._m = 'finance_source';
    $scope.filter = {};

    var grid = GridService();
    $scope.tableParams = grid('finance_source', $scope.filter, {sorting: {'programm': 'asc'}});

    $scope.updateGrid = function() {
        grid.reload();
    };
    
    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
    };

    $scope.openEdit = function (row, modeView) {
        grid.openEditor({
          data: row,
          hint: $scope._hint,
          modeView: !!modeView,
          size: 'width-full',
          controller: 'EditFinanceSourceController'
        });
    };


});


spi.controller('EditFinanceSourceController', function ($scope, modeView, $uibModalInstance, data, network, hint, Utils) {
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.modeView = modeView;
    $scope.finances = {};
//    $scope.types = Utils.getFinanceTypes();
    network.get('project_type', {}, function (result, response) {
      if(result) {
          $scope.types = response.result;
      }
    });


    if(!$scope.isInsert) {
        $scope.finance = {
            project_type_id: data.project_type_id,
            programm: data.programm,
            description: data.description
        };
        getFinances();
    }
//
    function getFinances() {
        network.get('finance_source', {is_active: 1}, function(result, response){
            if(result) {
                $scope.finances = response.result;
                $scope.sourceTypeName = Utils.getRowById($scope.finances, data.project_type_id, 'type_name');
            }
        });
    }

    

    $scope.fieldError = function(field) {
        var form = $scope.formFinances;
        return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
    };

    $scope.submitFormFinances = function () {
        $scope.submited = true;
        $scope.formFinances.$setPristine();
        if ($scope.formFinances.$valid) {
            var callback = function (result, response) {
                if (result) {
                    $uibModalInstance.close();
                }
                $scope.submited = false;
            };
            if ($scope.isInsert) {
                network.post('finance_source', $scope.finance, callback);
            } else {
                network.put('finance_source/' + data.id, $scope.finance, callback);
            }
        }
    };


    $scope.remove = function() {
      Utils.doConfirm(function() {
        network.delete('finance_source/'+data.id, function (result) {
            if(result) {
              Utils.deleteSuccess();
              $uibModalInstance.close();
            }
        });
      });
    };

    $scope.$on('modal.closing', function(event, reason, closed) {
      Utils.modalClosing($scope.formFinances, $uibModalInstance, event, reason);
    });

    $scope.cancel = function () {
      Utils.modalClosing($scope.formFinances, $uibModalInstance);
    };

});