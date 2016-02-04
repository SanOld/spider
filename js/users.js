spi.controller('UserController', function($scope, network, GridService) {
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
        grid.openEditor({
            data: row,
            controller: 'ModalEditUserController',
            template: 'editUserTemplate.html'
        });
    };

});


