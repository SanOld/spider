spi.controller('ProjectController', function($scope, $rootScope, network, GridService) {
    if(!$rootScope._m) {
        $rootScope._m = 'project';
    }
    $scope.filter = {};
    
    if ($scope.page) {
      $scope.filter['performer_id'] = $scope.performerId;
    }

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
    network.get('project_type', {}, function (result, response) {
        if(result) {
            $scope.projectTypes = response.result;
        }
    });
    
    network.get('school', {}, function (result, response) {
        if(result) {
            $scope.schools = response.result;
        }
    });
  
    var grid = GridService();
    $scope.tableParams = grid('project', $scope.filter, {sorting: {code: 'asc'}});

    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
    };

    $scope.updateGrid = function() {
        grid.reload();
    };

    $scope.openEdit = function (row, modeView) {
      console.log(row);
        grid.openEditor({
          data: row,
          hint: $scope._hint,
          modeView: !!modeView,
          controller: 'ProjectEditController',
          template: 'editProjectTemplate.html'
        });
    };

});

spi.controller('ProjectEditController', function ($scope, $uibModalInstance, modeView, data, network, hint, $timeout, Utils, SweetAlert) {
    $scope.isInsert = !data.id;
    $scope.schoolError = false;
    $scope.newCode = 0;
    $scope._hint = hint;
    $scope.modeView = modeView;
//    $scope.projectSchools = [];
    $scope.projectSchoolsID = {};
    $scope.schoolTypeCode = '';
    
    $timeout(function () {
        $scope.$digest();
    },500);
    
    if(!$scope.isInsert) {
        $scope.project = {
            code: data.code,
            rate: data.rate,
            school_type_id: data.school_type_id,
            type_id: data.type_id,
            is_old: data.is_old,
            schools: [],
            school: {},
            performer_id: data.performer_id,
            district_id: data.district_id,
        };
        $.each(data.schools, function(){
          $scope.projectSchoolsID[this.id] = 1;
        })
//          $scope.projectSchools = data.schools;
        
        //selected
        
        getProjects();
    } else {
      $scope.project = {schools:[]};
      network.get('project', {'get_next_id':1}, function(result, response){
          if(result) {
            $scope.newCode = response.next_id < 1000?('00'+(response.next_id)).slice(-3):response.next_id;
          }
      });
    }
    $scope.schoolTypesId = {};
    network.get('school_type', {}, function (result, response) {
        if(result) {
            $scope.schoolTypes = response.result;
            angular.forEach(response.result, function(val){
              val['fullName'] = '('+val.code.toUpperCase()+') '+val.name;
              $scope.schoolTypesId[val.id] = val;
            })
            if($scope.project.school_type_id) {
              $scope.schoolTypeCode = $scope.schoolTypesId[$scope.project.school_type_id].code;
            }
        }
    });
    
    network.get('project_type', {}, function (result, response) {
        if(result) {
            $scope.projectTypes = response.result;
        }
    });
    
    network.get('performer', {}, function (result, response) {
        if(result) {
            $scope.performers = response.result;
        }
    });
    
    
    
    $scope.getDistricts = function() {
      var params = {};
      delete $scope.project.district_id;
      if($scope.project.school_type_id && $scope.schoolTypeCode != 'z') {
        params['school_type_id'] = $scope.project.school_type_id;
      }
      network.get('district', params, function (result, response) {
          if(result) {
              $scope.districts = response.result;
          }
      });
    }
    $scope.getDistricts();
    
    
    function getProjects() {
        network.get('project', {}, function(result, response){
            if(result) {
              $scope.projects = response.result;
            }
        });
    }
    
    $scope.checkRate = function (project) {
      if(project.rate) {
        project.rate = project.rate.split('.').join(',');
        project.rate = project.rate.split(/[^0-9\,]/).join('');
        var m = project.rate.match(/([0-9]+)([\,]{0,1})([0-9]{0,2})[0-9]*/);
        try{
          project.rate = m[1]+m[2]+m[3];
        } catch(e) {
          project.rate = '';
        }
      }
    };

    $scope.fieldError = function(field) {
        var form = $scope.formProjects;
        return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid;
    };
    $scope.placeholderFN = function(items) {
        return items.lengt && false ? '(keine Items sind verfügbar)' :'(Bitte wählen Sie)'; // ??? not working
    };
    $scope.updateCode = function() {
      try {
        var isBonus = $scope.project.type_id == '3'?'B':'';
        $scope.project.code = isBonus + $scope.schoolTypesId[$scope.project.school_type_id].code.toUpperCase() + $scope.newCode;
        $scope.schoolTypeCode = $scope.schoolTypesId[$scope.project.school_type_id].code;
      } catch(e){}
    };
    $scope.updateSchools = function(isInit) {
      isInit = isInit || false;
        var schoolParams = {};
        
        delete $scope.project.school;
        delete $scope.project.schools;
        $scope.schools = [];

//        if(!($scope.project.school_type_id && ($scope.project.type_id == '3' || $scope.project.district_id))) {
//          return;
//        }
        
//        if($scope.project.type_id == '3') {
//          delete $scope.project.district_id;
//        }
        
        if($scope.project.school_type_id && $scope.schoolTypeCode != 'z') {
          schoolParams['type_id'] = $scope.project.school_type_id;
        }
        if($scope.project.district_id) {
          schoolParams['district_id'] = $scope.project.district_id;
        }
        network.get('school', schoolParams, function (result, response) {
            if(result) {
              $timeout(function(){
                
                $scope.schools = response.result;
                if(isInit) {
                  var schools = [];
                  $scope.project.school = $scope.schools[0];
                  $.each($scope.schools, function(){
                    if($scope.projectSchoolsID[this.id]) {
                      schools.push(this);
                    }
                  })
                  if(schools.length) {
                    $scope.project.schools = schools;
                  }
                }
              })
//                $scope.project.schools = $scope.projectSchools
//                $scope.projectSchools = [];
                
            }
        });
//        $scope.project.schools = [];
    };
    
    $scope.updateSchools(true);

    $scope.submitFormProjects = function () {
      console.log($scope.project);
        $scope.submited = true;
        $scope.formProjects.$setPristine();
        if ($scope.formProjects.$valid) {
            var callback = function (result, response) {
                if (result) {
                    $uibModalInstance.close();
                }
                $scope.submited = false;
            };
            
            
            if($scope.schoolTypeCode != 's') {
              $scope.project.schools = [$scope.project.school];
              delete $scope.project.school;
            }
            
            if(!$scope.project.schools.length && $scope.schoolTypeCode != 'z') {
//              if($scope.schoolTypeCode != 's') {
//                SweetAlert.swal({
//                  title: "Школа не выбрана",
//                  text: "Для проекта этого типа должны быть указана хотябы одна школа",
//                  type: "warning",
//                  confirmButtonText: "ОК",
//                  closeOnConfirm: true
//                });
//              } else {
//                SweetAlert.swal({
//                  title: "Школа не выбрана",
//                  text: "Для проекта этого типа должны быть указана школа",
//                  type: "warning",
//                  confirmButtonText: "ОК",
//                  closeOnConfirm: true
//                });
//              }
              $scope.schoolError = true;
              return false;
            }
            
            if ($scope.isInsert) {
                network.post('project', $scope.project, callback);
            } else {
              
              
              if($scope.project.performer_id != data.performer_id ||
                !$scope.idCompare(data.schools, $scope.project.schools)) {
          
                $.each($scope.project.schools, function(key, val){
                  if(typeof val == 'object') {
                    val = val.id
                  }
                })
                var newCode = $scope.project.code.split('/');
                newCode = newCode[0]+'/'+(newCode[1]?newCode[1]+1:2);
                console.log($scope.project);
                SweetAlert.swal({
                  title: "Projekt bearbeiten?",
                  text: "Nächstes projekt wird erstellt "+newCode,
                  type: "warning",
                  confirmButtonText: "Ja, erstellen!",
                  showCancelButton: true,
                  cancelButtonText: "ABBRECHEN",
                  closeOnConfirm: true
                }, function(isConfirm){
                  if(isConfirm) {
                    network.put('project/' + data.id, $scope.project, callback);
                  }
                });
              }
            }
        } else {
//            $scope.tabs[0].active = true;
        }
    };


    $scope.remove = function() {
      Utils.doConfirm(function() {
        network.delete('project/'+data.id, function (result) {
            if(result) {
              Utils.deleteSuccess();
              $uibModalInstance.close();
            }
        });
      });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
    $scope.idCompare = function (aobj, bobj) {
      var a = [];
      var b = [];
      $.each(aobj, function(){
        a.push(this.id);
      })
      $.each(bobj, function(){
        b.push(this.id);
      })
      return $(a).not(b).length === 0 && $(b).not(a).length === 0
    };
    
    $scope.canByType = function(types) {
      return types.indexOf(network.user.type) != -1;
    }

});


