spi.controller('FinanceSourceController', function($scope, $rootScope, network, GridService, HintService) {
    $rootScope._m = 'finance_source';
    $scope.filter = {};

    var grid = GridService();
    $scope.tableParams = grid('finance_source', $scope.filter, {sorting: {'programm': 'asc'}});

    $scope.updateGrid = function() {
        grid.reload();
    };

    HintService('finance_source', function(result) {
         $scope._hint = result;
    });

    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
    };

    $scope.openEdit = function (row) {
        grid.openEditor({data: row, hint: $scope._hint, size: 'width-full', controller: 'EditFinanceSourceController'});
    };


});


spi.controller('EditFinanceSourceController', function ($scope, $uibModalInstance, data, network, hint, Utils) {
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.finances = {};
    $scope.types = Utils.getFinanceTypes();


    if(!$scope.isInsert) {
        $scope.finance = {
            finance_source_type: data.finance_source_type,
            programm: data.programm,
            description: data.description
        };
        getFinances();
    }

    function getFinances() {
        network.get('finance_source', {is_active: 1}, function(result, response){
            if(result) {
                $scope.finances = response.result;
            }
        });
    }

    

    $scope.fieldError = function(field) {
        var form = $scope.formFinances;
        return ($scope.submited || form[field].$touched) && form[field].$invalid;
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
        } else {
            $scope.tabs[0].active = true;
        }
    };


    $scope.remove = function() {
      Utils.doConfirm(function() {
        network.delete('finance_source/'+data.id, function (result) {
            if(result) {
                $uibModalInstance.close();
            }
        });
      });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

});