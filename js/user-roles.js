spi.controller('UserRolesController', function($scope, network, GridService) {
    $scope.filter = {is_active: 1};

    $scope.userTypes = [
        {id: 1, name: 'Admin'},
        {id: 2, name: 'PA'},
        {id: 3, name: 'TA'},
        {id: 4, name: 'School'},
        {id: 5, name: 'District'},
        {id: 6, name: 'Senat'}
    ];

    $scope.statuses = [
        {id: 1, name: 'Aktiv'},
        {id: 0, name: 'Deaktivieren'}
    ];

    //network.get('user_type', {}, function (result, response) {
    //    if(result) {
    //        $scope.userTypes = response.result;
    //    }
    //});

    var grid = GridService();
    $scope.tableParams = grid('user', $scope.filter, {sorting: {name: 'asc'}});

    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
    };

    $scope.updateGrid = function() {
        grid.reload();
    };

    $scope.openEdit = function (row) {
        grid.openEditor({data: row});
    };

});


spi.controller('ModalEditController', function ($scope, $uibModalInstance, data, network) {
    $scope.isInsert = true;
    $scope.user = {
        is_active: 1,
        is_finansist: 0,
        sex: 1
    };

    if(data.id) {
        $scope.isInsert = false;
        $scope.type_name = data.type_name;
        $scope.relation_name = data.relation_name;
        $scope.user = {
            is_active: parseInt(data.is_active),
            is_finansist: parseInt(data.is_finansist),
            sex: parseInt(data.sex),
            title: data.title,
            first_name: data.first_name,
            last_name: data.last_name,
            login: data.login,
            email: data.email,
            phone: data.phone

        };
    }

    $scope.userTypes = [
        {id: 1, name: 'Admin'},
        {id: 2, name: 'PA'},
        {id: 3, name: 'TA'},
        {id: 4, name: 'School'},
        {id: 5, name: 'District'},
        {id: 6, name: 'Senat'}
    ];

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