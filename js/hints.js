spi.controller('HintsController', function($scope, network, GridService, HintService) {
    $scope.filter = {};

    var grid = GridService();
    $scope.tableParams = grid('hint', $scope.filter);

    $scope.updateGrid = function() {
        grid.reload();
    };

    HintService('hint', function(result) {
         $scope._hint = result;
    });

    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
    };

    $scope.openEdit = function (row) {
        grid.openEditor({data: row, hint: $scope._hint});
    };

    network.get('page', {}, function(result, response){
        if(result) {
            $scope.pages = response.result;
        }
    });


});


spi.controller('ModalEditController', function ($scope, $uibModalInstance, data, network, hint) {
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.hint = {};

    $scope.reloadPosition = function() {
        $scope.positions = [];
        if($scope.hint.page_id) {
            network.get('page_position', {'page_id': $scope.hint.page_id}, function (result, response) {
                if(result) {
                    $scope.positions = angular.merge($scope.positions, response.result);
                }
            });
        }
    };

    if(!$scope.isInsert) {
        $scope.hint = {
            page_id:     data.page_id,
            position_id: data.position_id,
            title:       data.title,
            description: data.description
        };
        $scope.reloadPosition();
    }

    network.get('page', {}, function(result, response){
        if(result) {
            $scope.pages = response.result;
        }
    });

    $scope.fieldError = function(field) {
        return ($scope.submited || $scope.form[field].$touched) && $scope.form[field].$invalid;
    };

    $scope.submitForm = function (formData) {
        $scope.submited = true;
        $scope.form.$setPristine();
        if ($scope.form.$valid) {
            var callback = function (result, response) {
                if(result) {
                    $uibModalInstance.close();
                }
                $scope.submited = false;
            };
            if($scope.isInsert) {
                network.post('hint', formData, callback);
            } else {
                network.put('hint/'+data.id, formData, callback);
            }
        }
    };

    $scope.remove = function() {
        network.delete('hint/'+data.id, function (result) {
            if(result) {
                $uibModalInstance.close();
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

});