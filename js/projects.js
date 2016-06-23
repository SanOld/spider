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
            $scope.newCode = response.next_id;
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
    
    
    
    $scope.getDistricts = function(isInit) {
      var params = {};
      if(!isInit) {
        delete $scope.project.district_id;
      }
      if($scope.project.school_type_id && $scope.schoolTypeCode != 'z') {
        params['school_type_id'] = $scope.project.school_type_id;
      }
      network.get('district', params, function (result, response) {
          if(result) {
              $scope.districts = response.result;
          }
      });
    }
    $scope.getDistricts(true);
    
    
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
        var m = project.rate.match(/([0-9]+)([\,]{0,1})([0-9]{0,3})[0-9]*/);
        try{
          project.rate = m[1]+m[2]+m[3];
        } catch(e) {
          project.rate = '';
        }
      }
    };

    $scope.fieldError = function(field) {
        var form = $scope.formProjects;
        return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid || ($scope.error && $scope.error[field] != undefined && form[field].$pristine) || ($scope.schoolError == field && form[field].$pristine);
    };
    $scope.placeholderFN = function(items) {
        return items.length && false ? '(keine Items sind verfügbar)' :'(Bitte wählen Sie)'; 
    };
    $scope.getNewCode = function(){
        var project_type = $scope.project.type_id == '3'?'B':'';
        var school_type = project_type + $scope.schoolTypesId[$scope.project.school_type_id].code.toUpperCase();
               
        for(key in $scope.newCode){
          if(school_type == $scope.newCode[key].code[0].toUpperCase()){
            var code = school_type + $scope.newCode[key].next_code[0];                   
          };
        };
        
        if(!code){
            code = school_type + "001";  
        };
        return code;
    };
    $scope.updateCode = function() {
      try {        
          $scope.project.code = this.getNewCode();
          $scope.schoolTypeCode = $scope.schoolTypesId[$scope.project.school_type_id].code;  
      } catch(e){}
    };
    $scope.updateSchools = function(isInit) {
      isInit = isInit || false;
        var schoolParams = {};
        
        delete $scope.project.school;
        delete $scope.project.schools;
        $scope.schools = [];

        if(!$scope.project.school_type_id || !$scope.project.district_id) {
          return;
        }
        
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
        $scope.submited = true;
        $scope.error = false;        
        $scope.schoolError = false;
        $scope.formProjects.$setPristine();        
        var callback = function (result, response) {
            if (result) {
                $uibModalInstance.close();
                $scope.submited = false;
            }else{
                $scope.error = getError(response);
                $scope.submited = true;
            }
        };                
        var $copyScopeProject = angular.copy($scope.project); 
        
        if($scope.schoolTypeCode != 's') {
          $copyScopeProject.schools = [$copyScopeProject.school];
        };
        
        if (!$scope.formProjects.$valid){
            $copyScopeProject.invalid = true;
        };         
        
        delete $copyScopeProject.school; 
        if((!$copyScopeProject.schools || !$copyScopeProject.schools.length) && $scope.schoolTypeCode != 'z') {
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
          $scope.schoolError = "schools";
          return false;
        }            
        if ($scope.isInsert) {
            if(!$scope.project.code.match(/B??[BGKSYZ]{1}[0-9]+\\?[0-9]*?/)){
              $copyScopeProject['real_code'] = null;
            }else{
              var result = $scope.project.code.match(/B??[BGKSYZ]{1}/);  
              $copyScopeProject['real_code'] = result[0].length > 1 ? result[0].splice(2) : result[0];  
            };            
            if($scope.project.code != this.getNewCode()){          
              $scope.is_manual = 1;
            }else{
              $scope.is_manual = 0;  
            };        
            $copyScopeProject['is_manual'] = $scope.is_manual == 1 ? '1' : '0';                
            
            network.post('project', $copyScopeProject, callback);              
        } else {            

          if($copyScopeProject.performer_id != data.performer_id || $scope.formProjects.$ditry || $copyScopeProject.schools != data.schools ) {          
            $.each($copyScopeProject.schools, function(key, val){
              if(typeof val == 'object') {
                val = val.id
              }
            })
            var newCode = $copyScopeProject.code.split('\\');
            newCode = newCode[0] + '\\' + (newCode[1] ? +newCode[1] + 1 : 2);
            SweetAlert.swal({
              title: "Projekt bearbeiten?",
              text: "Nächstes projekt wird erstellt " + newCode,
              type: "warning",
              confirmButtonText: "Ja, erstellen!",
              showCancelButton: true,
              cancelButtonText: "ABBRECHEN",
              closeOnConfirm: true
            }, function(isConfirm){
              if(isConfirm) {
                network.put('project/' + data.id, $copyScopeProject, callback);
              }
            });
          }else{
              $uibModalInstance.close();
          }
        } 
    };

    function getError(response) {
        var result = false;
        switch (response.system_code) {
          case 'ERR_DUPLICATED':
              result = {code: {dublicate: true}};
        }
        return result;
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

    $scope.$on('modal.closing', function(event, reason, closed) {
      Utils.modalClosing($scope.formProjects, $uibModalInstance, event, reason);
    });

    $scope.cancel = function () {
      Utils.modalClosing($scope.formProjects, $uibModalInstance);
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


