spi.controller('SchoolController', function($scope, $rootScope, network, GridService, HintService) {
    $rootScope._m = 'school';
    $scope.filter = {};

    var grid = GridService();
    $scope.tableParams = grid('school', $scope.filter, {sorting: {number: 'asc'}});

    $scope.updateGrid = function() {
        grid.reload();
    };

    HintService('school', function(result) {
         $scope._hint = result;
    });

    network.get('school_type', {}, function (result, response) {
        if(result) {
            $scope.schoolTypes = response.result;
        }
    });

    network.get('district', {}, function (result, response) {
        if(result) {
            $scope.districts = response.result;
        }
    });

    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
    };

    $scope.openEdit = function (row) {
        grid.openEditor({data: row, hint: $scope._hint, size: 'width-full', controller: 'EditSchoolController'});
    };


});


spi.controller('EditSchoolController', function ($scope, $uibModalInstance, data, network, hint, Utils) {
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.tabs = [{active: true}];
    $scope.school = {};


    if(!$scope.isInsert) {
        $scope.school = {
            name: data.name,
            district_id: data.district_id,
            address: data.address,
            plz: data.plz,
            city: data.city,
            number: data.number,
            type_id: data.type_id,
            phone: data.phone,
            fax: data.fax,
            email: data.email,
            homepage: data.homepage,
            contact_id: data.contact_id,
        };
        getUsers();
    }

    network.get('school_type', {}, function (result, response) {
        if(result) {
            $scope.schoolTypes = response.result;
        }
    });

    network.get('district', {}, function (result, response) {
        if(result) {
            $scope.districts = response.result;
        }
    });

    function getUsers() {
        network.get('user', {is_active: 1}, function(result, response){
            if(result) {
                $scope.users = response.result;
                if(data.contact_id) {
                    $scope.contactUser = Utils.getRowById($scope.users, data.contact_id);
                }
            }
        });
    }

    $scope.changeContactUser = function(userId) {
        $scope.contactUser = Utils.getRowById($scope.users, userId);
    };

    $scope.fieldError = function(field) {
        var form = $scope.form.formSchool;
        return ($scope.submited || form[field].$touched) && form[field].$invalid;
    };

    $scope.submitFormSchool = function () {
        $scope.submited = true;
        $scope.form.formSchool.$setPristine();
        if ($scope.form.formSchool.$valid) {
            var callback = function (result, response) {
                if (result) {
                    $uibModalInstance.close();
                }
                $scope.submited = false;
            };
            if ($scope.isInsert) {
                network.post('school', $scope.school, callback);
            } else {
                network.put('school/' + data.id, $scope.school, callback);
            }
        } else {
            $scope.tabs[0].active = true;
        }
    };


    $scope.remove = function() {
        network.delete('school/'+data.id, function (result) {
            if(result) {
                $uibModalInstance.close();
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

});