spi.controller('HintsController', function($scope, network, GridService) {

    var grid = GridService();
    $scope.tableParams = grid('hint', {}, {});

    $scope.updateGrid = function() {
        grid.reload();
    };

    $scope.openEdit = function (row) {
        grid.openEditor({data: row});
    };


    network.get('page', {}, function(result, response){
        if(result) {
            $scope.pages = response.result;
        }
    });


});


spi.controller('ModalEditController', function ($scope, $uibModalInstance, data, network, GridService) {
    $scope.isInsert = !data.id;

    if(!$scope.isInsert) {
        $scope.userTypeId = data.id
        $scope.default = +data.default;
        $scope.relation_name = data.relation_name;
        $scope.user_type = {name: data.name};
    } else {
        network.get('relation', {}, function(result, response){
            if(result) {
                $scope.relations = response;
                $scope.user_type = {type: 'a'};
            }
        });
    }


    var grid = GridService();
    network.get('page', {right: 1, type_id: data.id}, function(result, response){
        if(result) {
            $scope.tableParams = grid(response.result, {}, {sorting: {page_name: 'asc'}, count: response.result.length});
            $scope.user_right = [];
            for(var k in response.result) {
                $scope.user_right.push({
                    id: response.result[k].right_id,
                    type_id: data.id,
                    page_id: response.result[k].id,
                    can_view: response.result[k].can_view,
                    can_edit: response.result[k].can_edit
                });
            }
        }
    });

    $scope.fieldError = function(field) {
        return ($scope.submited || $scope.form[field].$touched) && $scope.form[field].$invalid || ($scope.error && $scope.error[field] != undefined && $scope.form[field].$pristine);
    };

    $scope.submitForm = function () {
        $scope.errors = [];
        $scope.submited = true;
        $scope.form.$setPristine();
        if ($scope.form.$valid) {
            var callback = function (result, response) {
                if(result) {
                    $uibModalInstance.close();
                } else {
                    setError(response.system_code);
                }
                $scope.submited = false;
            };
            if(!$scope.default) {
                $scope.user_type.rights = $scope.user_right;
            }
            if($scope.isInsert) {
                network.post('user_type', $scope.user_type, callback);

            } else {
                network.put('user_type/'+data.id, $scope.user_type, callback);
            }
        }
    };

    $scope.remove = function(id) {
        network.delete('user_type/'+id, function (result) {
            if(result) {
                $uibModalInstance.close();
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

    function setError(code) {
        var result = false;
        switch (code) {
            case 'ERR_DUPLICATED_NAME':
                result = {name: {dublicate: true}};
                break;
        }
        $scope.error = result;
    }
});