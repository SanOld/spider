spi.controller('PerformerController', function($scope, network, GridService, HintService) {
    $scope.$parent._m = 'performer';
    $scope.filter = {is_checked: 1};
    $scope.checks = [{id: 1, name: 'Checked'}, {id: 0, name: 'Not checked'}];

    var grid = GridService();
    $scope.tableParams = grid($scope.$parent._m, $scope.filter, {sorting: {name: 'asc'}});

    $scope.updateGrid = function() {
        grid.reload();
    };

    HintService($scope.$parent._m, function(result) {
         $scope._hint = result;
    });

    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
    };

    $scope.openEdit = function (row) {
        grid.openEditor({data: row, hint: $scope._hint, size: 'width-full'});
    };


});


spi.controller('ModalEditController', function ($scope, $uibModalInstance, data, network, hint, Utils) {

});