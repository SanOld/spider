spi.controller('UserRolesController', function($scope, network, GridService) {

    var grid = GridService();

    network.get('user_type', {}, function(result, response){
        if(result) {
            $scope.tableParams = grid(response.result, {}, {sorting: {name: 'asc'}, count: response.result.length});
        }
    });

    $scope.updateGrid = function() {
        grid.reload();
    };

    $scope.openEdit = function (row) {
        grid.openEditor({data: row});
    };

});


spi.controller('ModalEditController', function ($scope, $uibModalInstance, data, network, GridService) {
    $scope.isInsert = !data.id;
    $scope.default = data.default;

    var grid = GridService();
    network.get('page', {right: 1, type_id: data.id}, function(result, response){
        if(result) {
            $scope.tableParams = grid(response.result, {}, {sorting: {page_name: 'asc'}, count: response.result.length});
        }
    });

    $scope.fieldError = function(field) {
        return ($scope.submited || $scope.form[field].$touched) && $scope.form[field].$invalid;
    };

    $scope.submitForm = function (formData) {
        $scope.errors = [];
        $scope.submited = true;
        if ($scope.form.$valid) {
            delete formData['password_repeat'];
            var callback = function (result, response) {
                if(result) {
                    $uibModalInstance.close();
                } else {
                    $scope.errors = response.message;
                }
                $scope.submited = false;
            };
            if($scope.isInsert) {
                network.post('user', formData, callback);
            } else {
                network.put('user/'+data.id, formData, callback);
            }
        }
    };

    $scope.remove = function(id) {
        network.delete('user/'+id, function (result) {
            if(result) {
                $uibModalInstance.close();
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});