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
    network.get('school_type', {}, function (result, response) {
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
            template: 'editTemplate.html'
        });
    };

});

spi.controller('ProjectEditController', function ($scope, $uibModalInstance, data, network, hint, $timeout) {
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.finance_source_type = {};
    
    $timeout(function () {
        $scope.$digest();
    },500);
    
    if(!$scope.isInsert) {
        $scope.project = {
            code: data.code,
            school_type_id: data.school_type_id,
            finance_source_type: data.finance_source_type,
            finance_programm_id: data.finance_programm_id,
            performer_id: data.performer_id,
            district_id: data.district_id,
        };
        getProjects();
    } else {
      $scope.project = {schools:[]};
      console.log('get project')
      network.get('project', {'get_last_id':1}, function(result, response){
          if(result) {
            console.log(result)
              //$scope.projects = response.result;
          }
      });
    }
    
    network.get('school_type', {}, function (result, response) {
        if(result) {
            $scope.schoolTypes = response.result;
        }
    });
    
    network.get('finance_source', {}, function (result, response) {
        if(result) {
            $scope.programms = response.result;
            angular.forEach($scope.programms, function(val){
              $scope.finance_source_type[val.id] = val.finance_source_type == 'l'?'LM':'BP';
            })
            console.log($scope.finance_source_type);
        }
    });
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
    
    
    function getProjects() {
        network.get('project', {}, function(result, response){
            if(result) {
                $scope.projects = response.result;
            }
        });
    }

    $scope.fieldError = function(field) {
        var form = $scope.formProjects;
        return ($scope.submited || form[field].$touched) && form[field].$invalid;
    };
    $scope.updateSchools = function() {
        var schoolParams = {};
        if($scope.project.school_type_id) {
          schoolParams['type_id'] = $scope.project.school_type_id;
        }
        if($scope.project.district_id) {
          schoolParams['district_id'] = $scope.project.district_id;
        }
        network.get('school', schoolParams, function (result, response) {
            if(result) {
                $scope.schools = response.result;
            }
        });
        $scope.project.schools = [];
    };
    
    $scope.updateSchools();

    $scope.submitFormProjects = function () {
        $scope.submited = true;
        $scope.formProjects.$setPristine();
        if ($scope.formProjects.$valid) {
            var callback = function (result, response) {
                if (result) {
                    $uibModalInstance.close();
                }
                $scope.submited = false;
            };
            if ($scope.isInsert) {
                network.post('project', $scope.project, callback);
            } else {
                network.put('project/' + data.id, $scope.project, callback);
            }
        } else {
            $scope.tabs[0].active = true;
        }
    };


    $scope.remove = function() {
        network.delete('project/'+data.id, function (result) {
            if(result) {
                $uibModalInstance.close();
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

});


