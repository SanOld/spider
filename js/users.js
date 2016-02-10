spi.controller('UserController', function($scope, network, GridService, HintService) {
    $scope.filter = {is_active: 1};

    $scope.statuses = [
        {id: 1, name: 'Aktiv'},
        {id: 0, name: 'Deaktivieren'}
    ];

    network.get('user_type', {}, function (result, response) {
        if(result) {
            $scope.userTypes = response.result;
        }
    });

    HintService('user', function(result) {
        $scope._hint = result;
    });

    var grid = GridService();
    $scope.tableParams = grid('user', $scope.filter, {sorting: {name: 'asc'}});

    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
    };

    $scope.updateGrid = function() {
        grid.reload();
    };

    $scope.openEdit = function (row) {
        grid.openEditor({
            data: row,
            hint: $scope._hint,
            controller: 'ModalEditUserController',
            template: 'editUserTemplate.html'
        });
    };

});


