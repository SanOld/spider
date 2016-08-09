spi.controller('ProjectController', function($scope, $rootScope, network, GridService) {
    if(!$rootScope._m) {
        $rootScope._m = 'project';
    }
    $scope.filter = {};
    
    function getProjects() {
      network.get('project', {}, function (result, response) {
        if (result) {
          $scope.projects = response.result;          
        }
      });
    };
    getProjects();
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
            schools: data.schools[0].id ? data.schools : [],
//            schools: data.school_type_id == 1 ? data.schools : [],
//            school: data.school_type_id != 1 ? data.schools[0] : {},
            performer_id: data.performer_id,
            district_id: data.district_id == null ? 0 : data.district_id,
            programm_id: data.programm_id,
            status_id: data.status_id
        };
        $.each(data.schools, function(){
          $scope.projectSchoolsID[this.id] = 1;
        })
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
      if(!isInit && $scope.isInsert) {
        delete $scope.project.district_id;
      }      
      if($scope.project.school_type_id && $scope.project.school_type_id != 6) {
        params['school_type_id'] = $scope.project.school_type_id;
      }
      network.get('district', params, function (result, response) {
          if(result){
            if($scope.project.school_type_id == 5 || !result){
              response.result.unshift({'name':"--Kein Bezirk--", 'id': 0});
            }           
            $scope.districts = response.result; 
          } 
      });
    }
    $scope.getDistricts(true);
    
    
    $scope.getProgramms = function(isInit) {     
      var params = {};
      if(!isInit && $scope.isInsert) {
       delete $scope.project.programm_id;
      }
      params['project_type_id'] = $scope.project.type_id;
      network.get('finance_source', params, function (result, response) {
       if(result) {          
         $scope.programms = response.result;  
         if($scope.programms.length < 2 && $scope.isInsert){
           $scope.project.programm_id = $scope.programms[0].id;
           $scope.updateCode();
         }
       }
     });                
    }
    $scope.getProgramms(true);
    
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
      return items.length && false ? '(keine Items sind verfügbar)' :'(Bitte auswählen)'; 
    };
    $scope.getNewCode = function(){
      var project_type = '';
      $scope.programms.forEach(function(item, i, arr){
        if(item.id == $scope.project.programm_id && item.prefix){
          project_type = item.prefix;  
        }
      });
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
      if($scope.isInsert){
        //delete $scope.project.school;
        delete $scope.project.schools;  
      }        
      $scope.schools = [];
      if(!$scope.project.school_type_id && !$scope.project.district_id) {
        return;
      }
      if($scope.project.school_type_id) {
        schoolParams['type_id'] = $scope.project.school_type_id;
      }
      if($scope.project.district_id) {
        schoolParams['district_id'] = $scope.project.district_id;
      }
      network.get('school', schoolParams, function (result, response) {
        if(result && response.result[0] != 0) {
          $timeout(function(){                
            $scope.schools = response.result;
            if(isInit && $scope.isInsert ) {
              var schools = [];
             //$scope.project.school = $scope.schools[0];
              $.each($scope.schools, function(){
                if($scope.projectSchoolsID[this.id]) {
                  schools.push(this);                      
                }
              })
              if(schools.length) {
                $scope.project.schools = schools;
              }
            }                
          });
        };
      });
    };
    
    $scope.updateSchools(true);
    
    $scope.checkIfChanged = function(project, data){
      var similar = true;
      if(typeof project.schools[0] != 'object' ){
        for(var i = 0; i < project.schools.length; i++ ){
          similar = true;  
          for(var k = 0; k < data.schools.length; k++ ){
            if(data.schools[k] && project.schools[i] && project.schools[i] == data.schools[k].id){
              similar = true; 
              break;
            }else{
              similar = false;  
            };   
          }
          if(!similar){
            break;  
          }
        } 
        if(project.schools.length != data.schools.length){
          similar = false;   
        };
      }          
      return similar;
    };
    
    $scope.banToDelete = function (){
      SweetAlert.swal({
        title: "",
        text: "Löschen Sie den Antrag zuerst damit diese Operation durchzuführen.",
        type: "warning",
        confirmButtonText: "OK",
        closeOnConfirm: true
      }, function(isConfirm){
          if(isConfirm){
            $uibModalInstance.close();
          }   
       });
    };
    
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
//        if($scope.schoolTypeCode != 's') {
//          $copyScopeProject.schools = [$copyScopeProject.school];
//        }
        if (!$scope.formProjects.$valid){
            $copyScopeProject.invalid = true;
        };  
        if($scope.schoolTypeCode == 'z') {
          $copyScopeProject.schools = [0];
        }
//        delete $copyScopeProject.school; 
        if((!$copyScopeProject.schools || !$copyScopeProject.schools.length) && $scope.schoolTypeCode != 'z') {
          $scope.schoolError = "schools";
          return false;
        }
        if(!$copyScopeProject.district_id){
          delete $copyScopeProject.district_id;  
        };
        if ($scope.isInsert) {            
            var prefix = "";
            $scope.programms.forEach(function(item, i, arr){
              if(item.prefix){
                prefix = prefix + item.prefix;  
              }
            });
            var sch_types = "";
            $scope.schoolTypes.forEach(function(item, i, arr){
              if(item.code){
                sch_types = sch_types + item.code;  
              }
            });
            var reg = new RegExp('['+ prefix +']??['+ sch_types +']{1}[0-9]+/?[0-9]*?','i');
            if(!$scope.project.code.match(reg)){ 
              $copyScopeProject['real_code'] = null;
            }else{
              var reg = new RegExp('^['+ prefix + sch_types +']{1,2}','i');    
              var result = $scope.project.code.match(reg); 
              $copyScopeProject['real_code'] = result[0].slice(0,1) == 'B' && result[0].length > 1 ? result[0].slice(1) : result[0];
            };
            if($scope.project.code != this.getNewCode() && $scope.project.code.slice(-3) != '001'){          
              $scope.is_manual = 1;
            }else{
              $scope.is_manual = 0;  
            };        
            $copyScopeProject['is_manual'] = $scope.is_manual == 1 ? '1' : '0'; 
            network.post('project', $copyScopeProject, callback);              
        } else {
          var similar = $scope.checkIfChanged($copyScopeProject, data);
          if($copyScopeProject.performer_id != data.performer_id || !similar) {          
            $copyScopeProject.schools.forEach(function(item, i, arr){
              if(typeof item == 'object'){
                $copyScopeProject.schools[i] = item.id;
              };
            });
            var newCode = $copyScopeProject.code.split('/');
            newCode = newCode[0] + '/' + (newCode[1] ? +newCode[1] + 1 : 2);
            if(!$scope.project.status_id || $scope.project.status_id == 2){
              SweetAlert.swal({
                  title: "Projekt bearbeiten?",
                  text: "Nächstes Projekt wird erstellt " + newCode,
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
              $scope.banToDelete();
            }          
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
      if($scope.project.status_id){
        if($scope.project.status_id == 2){
          $scope.project.is_old = 1;
          network.put('project/' + data.id, $scope.project, function(){                  
            Utils.deactivateSuccess(function(){              
              $uibModalInstance.close();
            });
          });
        }else{
          $scope.banToDelete();
        }
      }else{            
        Utils.doConfirm(function() {
          network.delete('project/'+data.id, function (result) {
            if(result) {
              Utils.deleteSuccess();
              $uibModalInstance.close();
            }
          });                         
        });
      }
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


