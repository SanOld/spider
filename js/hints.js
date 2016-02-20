spi.controller('HintsController', function($scope, $rootScope, network, GridService, HintService) {
    $rootScope._m = 'hint';
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
        grid.openEditor({data: row, hint: $scope._hint, controller: 'EditHintController'});
    };

    network.get('page', {}, function(result, response){
        if(result) {
            $scope.pages = response.result;
        }
    });


});


spi.controller('EditHintController', function ($scope, $uibModalInstance, data, network, hint, Utils) {
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.hint = {};
    $scope.showTitle = false;

    function reloadPosition() {
        $scope.positions = [];
        if($scope.hint.page_id) {
            network.get('page_position', {page_id: $scope.hint.page_id, except: 'hint'}, function (result, response) {
                if(result) {
                    $scope.positions = response.result;
                }
            });
        }
    }

    $scope.changePage = function() {
        $scope.hint.position_id = undefined;
        $scope.changePosition();
        reloadPosition();
    };

    $scope.changePosition = function(id) {
        $scope.showTitle = id && Utils.getRowById($scope.positions, id, 'code') == 'header';
    };

    if(!$scope.isInsert) {
        $scope.page_name = data.page_name;
        $scope.position_name = data.position_name;
        $scope.showTitle = data.title;
        $scope.hint = {
            title:       data.title,
            description: data.description
        };
        reloadPosition();
    } else {
        network.get('page', {}, function(result, response){
            if(result) {
                $scope.pages = response.result;
            }
        });
    }

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