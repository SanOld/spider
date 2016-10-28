spi.directive("spiHintMain", function () {
  return {
    restrict: 'A',
    scope: {
      header: '=',
      text: '='
    },
    template: '<div ng-if="header && text" class="hint-details alert alert-info m-0 clearfix"  ng-init="isCollapsed = 1"> <div class="heading-alert"> <strong ng-bind="header"></strong> <span ng-click="isCollapsed = !isCollapsed" class="show-link pull-right"> <span ng-show="isCollapsed">Zeigen</span> <span ng-hide="isCollapsed">Ausblenden</span> <span class="caret" ng-class="{\'open\': !isCollapsed}"></span> </span> </div> <div uib-collapse="isCollapsed"> <p ng-bind-html="text | nl2br"></p> </div> </div>'
  };
});

spi.directive("spiHint", function () {
  return {
    restrict: 'A',
    scope: {
      title: '=',
      text: '=',
      class: '@'
    },
    template: '<button ng-if="text" uib-popover="{{text}}" popover-title="{{title}}" class="btn btn-question {{class}}" type="button"> <i class="fa fa-question"></i> </button>'
  };
});

spi.directive("qqFileUpload", function (Notification) {
  return {
    restrict: 'A',
    scope: {
      setting: '='
    },
    template: '<div class="btn w-sw custom-color pull-right csv-import-btn" id="file-uploader"></div>',
    link: function (scope, element, attrs, ctrl) {
      var uploader = new qq.FileUploader({
        element: document.getElementById('file-uploader'),
        action: '/api/upload-file/' + scope.setting.model + '/' + (scope.setting.params ? '?' + $.param(scope.setting.params) : ''),
        uploadButtonText: scope.setting.buttonText || '',
        customHeaders: scope.setting.customHeaders || {},
        sizeLimit: scope.setting.sizeLimit || 10520000,
        allowedExtensions: scope.setting.allowedExtensions || ['doc', 'docx', 'pdf', 'csv'],
        messages: {
          typeError: "Unfortunately the file(s) you selected weren't the type we were expecting. Only {extensions} files are allowed",
          sizeError: "{file} is too large, maximum file size is {sizeLimit}",
          minSizeError: "{file} is too small, minimum file size is {minSizeLimit}",
          emptyError: "{file} is empty, please select files again without it",
          onLeave: "The files are being uploaded, if you leave now the upload will be cancelled"
        },
        showMessage: function (message) {
          Notification.error({title: 'File upload error', message: message});
        },
        onComplete: (scope.setting.onCompile) || function (id, fileName, responseJSON) {
          Notification.success(responseJSON.message);
        },
        onUpload: scope.setting.onUpload || function (id, fileName, xhr) {
        },
        onProgress: scope.setting.onProgress || function (id, fileName, loaded, total) {
        },
        onError: scope.setting.onError || function (id, fileName, xhr) {
          Notification.error(responseJSON.message);
        }
      });
    }
  };
});

spi.directive('disableAll', function ($timeout) {
  return {
    restrict: 'A',
    link: function (scope, element, attrs) {
      var _disableElements = ['input', 'button[uib-btn-radio]', 'textarea', 'select', '.select2'];
      var _skipClasses = ['cancel-btn', 'document-link', 'btn-question', 'fa-question', 'fa-info-circle'];

      scope.$watch(attrs.disableAll, function (isDisabled) {
        if(isDisabled) {
          $timeout(function() {
            disable(element[0], isDisabled);
          });
        }
      });

      var disable = function(element) {
        angular.element(element).addClass('disable-all');
        // element.addEventListener('click', preventDefault, true);
        for(var i = 0; i < _disableElements.length; i++) {
          disableElements(angular.element(element).find(_disableElements[i]), _disableElements[i] == 'textarea');
        }
      };

      var preventDefault = function(event) {
        for (var i = 0; i < event.target.classList.length; i++) {
          if(_skipClasses.indexOf(event.target.classList[i]) !== -1){
            return true;
          }
        }
        event.stopPropagation();
        event.preventDefault();
        return false;
      };

      var disableElements = function(elements, readonly) {
        var len = elements.length;
        for (var i = 0; i < len; i++) {
          var shouldDisable = true;
          for (var j = 0; j < elements[i].classList.length; j++) {
            if(_skipClasses.indexOf(elements[i].classList[i]) !== -1){
              shouldDisable = false;
              break;
            }
          }
          if (shouldDisable && elements[i].disabled === false) {
            if(readonly) {
              elements[i].readOnly = true;
            } else {
              elements[i].disabled = true;
            }
            elements[i].disabledIf = true;
          }
        }
      };

    }
  }
});

spi.directive("spiOnFocusLarge", function () {
  return {
    restrict: 'A',
    scope: {
      spiSave: '=',
      spiCancel: '=',
      callback: '&spiCallback',
      ngModel: '='
    },
    link: function (scope, element, attr) {
      var defaultText = element.val();
      element.bind('focus',function () {
        defaultText = element.val();
        element.addClass('animate');
      });
      scope.$watch('spiSave', function(val) {
        if(element.hasClass('animate')) {
          element.removeClass('animate');
          defaultText = element.val();
          scope.callback();
        }
      });
      scope.$watch('spiCancel', function(val) {
        if(element.hasClass('animate')) {
          scope.ngModel = defaultText;
          element.removeClass('animate');
        }
      });
    }
  };
});

spi.filter('nl2br', ['$sce', function ($sce) {
  return function (text) {
    return text ? $sce.trustAsHtml(text.replace(/\n/g, '<br/>')) : '';
  };
}]);
  
spi.directive('exportToCsv',['network','$timeout', function(network, $timeout){
    //1. paramsForExport object can contain properties data, model, param
    //2. if you want to export some data from the scope, you should use just data property of paramsForExport object
    //3. else, if you want to get some data from the database, you should use model && param properties of paramsForExport object
    //4. for two-dimensional array e.x. schools you should add parametr to paramsForExport object with the name of this array (e.x.schools)
    // and with the value that contains name of field you want to add to csv file
    //5. for three-dimensional array for audit page you should add 'recirsive' array parametr to paramsForExport object
    // and add to that array names of columns you want to repeat
    //6. if column for yet doesn't has data for export, you shoul set 'null' name of column
  	return {
    	restrict: 'A',
    	link: function (scope, element, attrs) {
        function addClick (string, paramsForExport) {
          var button = $('<a/>', {
            style:'display:none',
            href:'data:application/octet-stream;base64,' + btoa(string),
            download: paramsForExport.fileName
          });
          button.appendTo('body')
          button[0].click();
          button.remove();
        };
        function length (schools){
          var length = false;
          for (var i in schools) {
            if (schools.hasOwnProperty(i)) {
              if (typeof schools[i] == 'object') {
                length = true;
                return length;
              }else{                
                return length;
              };
            };
          };
        };
        element.bind('click', function(e){
          var paramsForExport = scope.paramsForExport;          
          if(scope.checkbox){            
            for(var box in scope.checkbox){
              if(scope.checkbox[box]){
                paramsForExport = scope.paramsForExport[box];
              };
            };
          };
          var reg_date = /[0-9]{4}-[0-9]{2}-[0-9]{2}/;
          var reg_number = /[0-9]+\.[0-9]+/;
          if(paramsForExport.model == 'audit'){
            paramsForExport.param.limit = 40;
          }else{
            if(paramsForExport.param){
              delete paramsForExport.param.limit;
            };
          };
          var csvString = '';
          network.get(paramsForExport.model, scope.filter, function (result, response) {
            if (result) {
              for(var table in paramsForExport.tables){
                if(paramsForExport.tables[table].data){
                  response.result = paramsForExport.tables[table].data;
                };                
                //add columns to the top
                for(var column in paramsForExport.tables[table].columns){
                  csvString += paramsForExport.tables[table].columns[column] + ",";
                };
                var counter = 0;                
                //add data to the csv file                
                if(!paramsForExport.tables[table].no_data){
                  for(var i = 0; i < response.result.length; i++ ){
                    csvString = csvString.substring(0,csvString.length - 1);            
                    csvString = csvString + "\n";
                    a:
                    for(var columns in paramsForExport.tables[table].columns){
                      b:
                      //recursive repeat of data for audit
                      if(paramsForExport.tables[table].recursive && paramsForExport.tables[table].recursive.indexOf(columns) != -1){
                        if(response.result[i].data[counter][columns]){
                          csvString += response.result[i].data[counter][columns] + ",";
                        }else{
                          csvString += ",";
                        }                        
                        if(paramsForExport.tables[table].recursive.indexOf(columns) == paramsForExport.tables[table].recursive.length - 1){
                          if(response.result[i].data.length == counter +1){
                            counter = 0;
                          }else{
                            counter++;
                            i --;                      
                          };
                          break a;
                        }else{
                          break b;
                        }
                      };
                      c:
                      //simple export data
                      for(var column in response.result[i]){
                        if(columns.match(/null/) && !paramsForExport.tables[table].enter){
                          csvString += ',';
                          break c;
                        }else{
                          var column_reg = new RegExp(column + '.+');
                          if(columns == column || columns.match(column_reg)){
                            if(response.result[i][column]){
                              if(typeof response.result[i][column] == 'object'){
                                if(columns != column && !length(response.result[i][column])){
                                  if(response.result[i][column][paramsForExport.tables[table][columns]]){
                                    csvString += '"' + response.result[i][column][paramsForExport.tables[table][columns]] + '"' + ',' ;
                                  }else{
                                    csvString += ',';
                                  }
                                }else{
                                  var count = 0;
                                  var csvObjectString = '';
                                  for(var k in response.result[i][column]){
                                    count += 1;
                                    if(response.result[i][column][k][paramsForExport.tables[table][columns]]){                                    
                                      csvObjectString += count + ". " + response.result[i][column][k][paramsForExport.tables[table][columns]] + " ";
                                    }else{
                                      csvObjectString += count + ". " + " - " + " ";
                                    }                                  
                                  };
                                  csvString += '"' + csvObjectString + '"' + ',';
                                }
                              }else{
                                //numbers in format 1000,00
                                if(typeof response.result[i][column] === 'number' || response.result[i][column].match(reg_number)){
                                  var cost = String(response.result[i][column]).replace(/\./gi, ",");
//                                  csvString += '"' + cost + '"' + ',' ;
                                  if(paramsForExport.tables[table].concat && paramsForExport.tables[table].concat == column){
                                    csvString += '"' + cost + " ";
                                  } else {
                                    csvString += '"' + cost + '"' + ',' ;
                                  }
                                }else if(response.result[i][column].match(reg_date)){
                                  //data in format 09-09-2018
                                  var date = '';
                                  if(response.result[i][column].length > 11){                                    
                                    date = response.result[i][column].substring(11);
                                  }
                                  var day = response.result[i][column].substring(8,10);
                                  var month = response.result[i][column].substring(5,7);
                                  var year = response.result[i][column].substring(0,4);
                                  if(paramsForExport.tables[table].concat && paramsForExport.tables[table].concat == column){
                                    csvString += '"' + day + '-' + month + '-' + year + " " + date + " ";
                                  }else{
                                    csvString += '"' + day + '-' + month + '-' + year + " " + date + '"' + ',' ;
                                  }
                                }else{
                                  if(paramsForExport.tables[table].replace && paramsForExport.tables[table].replace[0] == column && response.result[i][paramsForExport.tables[table].replace[1]]){
                                    column = paramsForExport.tables[table].replace[1];
                                  };
                                  if(response.result[i][column] && response.result[i][column].indexOf('"') != -1){
                                    response.result[i][column] = response.result[i][column].replace(/"/g,"'");
                                  };
                                  if(paramsForExport.tables[table].concat && paramsForExport.tables[table].concat == column){
                                    csvString += '"' + response.result[i][column] + " ";
                                  }else{
                                    csvString += '"' + response.result[i][column] + '"' + ',' ;
                                  }
                                };
                              };                                                
                            }else{                          
                              csvString += " ," ;
                            }
                            break c;
                          }
                        }
                      }
                    }
                  }
                  if(!paramsForExport.tables[table].enter){                    
                    csvString = csvString + "\n";                    
                    csvString = csvString + "\n";  
                  };
                };
              };
            };              
            csvString = csvString.substring(0, csvString.length - 1);
            //console.log('csvString:',csvString)
            addClick(csvString, paramsForExport);
            if(scope.checkbox){
              for(var box in scope.checkbox){
                if(scope.checkbox[box]){
                  scope.checkbox[box] = false;;
                };
              };
            };
          });
        });
    	}
  	};
	}]);
