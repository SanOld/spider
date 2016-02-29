spi.controller('ProjectController', function($scope, $rootScope, network, GridService, HintService) {
    if(!$rootScope._m) {
        $rootScope._m = 'project';
    }
    $scope.filter = {};

    network.get('performer', {}, function (result, response) {
        if(result) {
            $scope.performers = response.result;
        }
    });
    network.get('district', {}, function (result, response) {
        if(result) {
            $scope.districts = response.result;
        }
    });
    network.get('school-type', {}, function (result, response) {
        if(result) {
            $scope.schoolTypes = response.result;
        }
    });
    network.get('school', {}, function (result, response) {
        if(result) {
            $scope.schools = response.result;
        }
    });
    
    HintService('project', function(result) {
        $scope._hint = result;
    });

    var grid = GridService();
    $scope.tableParams = grid('project', $scope.filter, {sorting: {code: 'asc'}});

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
            controller: 'ProjectEditController',
            template: 'editProjectTemplate.html'
        });
    };

});


