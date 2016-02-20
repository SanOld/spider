spi.controller('UserController', function($scope, $rootScope, network, GridService, HintService) {
    if(!$rootScope._m) {
        $rootScope._m = 'user';
    }
    $scope.filter = {is_active: 1};
    if($scope.page && $scope.page == 'performer') {
        $scope.filter['type'] = 't';
    }
    $scope.statuses = [
        {id: 1, name: 'Aktiv'},
        {id: 0, name: 'Deaktivieren'}
    ];

    network.get('user_type', $scope.filter['type'] ? {type: $scope.filter['type'] } : {}, function (result, response) {
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
            controller: 'UserEditController',
            template: 'editUserTemplate.html'
        });
    };

});


