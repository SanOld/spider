spi.service('configs', function () {
  var $configs = this;

  $configs.getServisePath = function () {
    return ((location + '').match(/http\:\/\/([^\/]+)/)[0]) + '/api/';
  };
  $configs.getAuthPath = function () {
    return ((location + '').match(/http\:\/\/([^\/]+)/)[0]) + '/api/login';
  };
  $configs.getSitePath = function () {
    return ((location + '').match(/http\:\/\/([^\/]+)/)[0]) + '';
  };
  $configs.getDomain = function () {
    var domain = ((location + '').match(/http\:\/\/([^\/]+)/)[1]) + '';
    var path = domain.split('.');
    var start = path.length - 2;
    start = start < 0 ? 0 : start;
    account = path.splice(start, path.length).join('.');
    return account;
  };
  $configs.getAccount = function () {
    var domain = ((location + '').match(/http\:\/\/([^\/]+)/)[1]) + '';
    var path = domain.split('.');
    var account = '';
    if (path.length > 2) {
      account = path.splice(0, path.length - 2).join('.');
    }
    return account;
  }
});

spi.service("GridService", function (network, NgTableParams, $uibModal, Notification,$timeout) {
  return function () {
    var tableParams;
    var defaultFilter = {};
    var filter = {};
    var model = '';

    function getData(path, params, filter, callback) {
      model = path;
      filter['limit'] = params.count();
      filter['page'] = params.page();
      var sort = params.sorting();
      if (Object.keys(sort).length) {
        filter['order'] = Object.keys(sort)[0];
        filter['direction'] = sort[filter['order']];
      }
      network.get(model, angular.copy(filter), function (result, response) {
        if (result) {
          callback(response);
        }
      });
    }

    function filterEquals() {
      var trueFilter = {};
      var except = ['page', 'limit', 'order', 'direction'];
      for (var k in filter) {
        if (except.indexOf(k) === -1) {
          trueFilter[k] = filter[k];
        }
      }
      return angular.equals({}, trueFilter);
    }

    function grid(data, defFilter, params) {
      filter = defFilter || {};
      params = params || {};
      defaultFilter = angular.copy(filter);
      var dataset = typeof(data) === 'object' ? {dataset: data} : {
        getData: function ($defer, params) {
          getData(data, params, filter, function (response) {
            params.total(response.count);
            $defer.resolve(response.result);
          });
        }
      };
      dataset.groupOptions = {isExpanded: false, defaultSort: 'desc'}
      tableParams = new NgTableParams(params, dataset);
      return tableParams;
    }

    grid.reload = function () {
      tableParams.page(1);
      tableParams.reload();
    };
    grid.resetFilter = function () {
      if (!filterEquals()) {
        filter = {};
        grid.reload();
      }
      return filter;
    };
    grid.openEditor = function (params, callback) {
      model = params.model || model;
      if(model && params.data && params.data.id) {
        network.get(model, {id: params.data.id}, function(result, response) {
          if(result && response.result.length) {
            params.data = response.result[0];
            openModal(params, callback);
          } else {
            Notification.error({title: 'The row not found!', message: 'Please update page.'});
          }
        });
      } else {
        openModal(params, callback);
      }

      function openModal(params, callback) {
        var modalInstance = $uibModal.open({
          animation: true,
          templateUrl: params.template || 'editTemplate.html',
          controller: params.controller || 'ModalEditController',
          size: params.size || 'lg',
          resolve: {
            data: function () {
              return params.data || {};
            },
            hint: function () {
              return params.hint;
            },
            modeView: function () {
              return params.modeView;
            }
          }
        });

        modalInstance.result.then(function () {
          callback ? callback(true) : tableParams.reload();
        }, function() {
          if(callback) {
            callback(false)
          }
        });

      }



    };
    return grid;
  }
});

spi.service("HintService", function (network) {
  return function (code, callback) {
    network.get('hint', {filter: 1, page_code: code}, function (result, response) {
      if (result) {
        var hints = {};
        for (var i = 0; i < response.result.length; i++) {
          hints[response.result[i].position_code] = response.result[i].position_code == 'header' ?
          {title: response.result[i].title, text: response.result[i].description} : response.result[i].description;
        }
        callback(hints);
      }
    });
  };
});


spi.factory('Utils', function (SweetAlert) {
  return {
    getRowById: function (items, id, field) {
      for (var i = 0; i < items.length; i++) {
        if (items[i].id == id) {
          if (field && items[i][field] != undefined) {
            return items[i][field];
          }
          return items[i];
        }
      }
      return false;
    },
    getFinanceTypes: function () {
      return [{id: 'l', name: 'LM'}, {id: 'b', name: 'BP'}];
    },
    getSqlDate: function(d) {
      return d.getFullYear()+'-'+((d.getMonth()+1) < 10 ? '0'+(d.getMonth()+1) : d.getMonth()+1)+'-'+(d.getDate() < 10 ? '0'+d.getDate() : d.getDate());
    },
    doConfirm: function(callback) {
      SweetAlert.swal({
        title: "Sind Sie sicher?",
        text: "Diese Datei wird nicht weidererstellt!",
        type: "warning",
        confirmButtonText: "JA, LÖSCHEN!",
        showCancelButton: true,
        cancelButtonText: "ABBRECHEN",
        closeOnConfirm: false
      }, function(isConfirm){
        if(isConfirm) {
          callback();
        }
      });
    },
    deleteSuccess: function() {
      SweetAlert.swal("Gelöscht!", "Ihre Datrei ist erfolgreich gelöscht!", "success");
    }
  };
});

spi.factory('SweetAlert', ['$rootScope', function ($rootScope) {

  var swal = window.swal;

  //public methods
  var self = {

    swal: function (arg1, arg2, arg3) {
      $rootScope.$evalAsync(function () {
        if (typeof(arg2) === 'function') {
          swal(arg1, function (isConfirm) {
            $rootScope.$evalAsync(function () {
              arg2(isConfirm);
            });
          }, arg3);
        } else {
          swal(arg1, arg2, arg3);
        }
      });
    },
    success: function (title, message) {
      $rootScope.$evalAsync(function () {
        swal(title, message, 'success');
      });
    },
    error: function (title, message) {
      $rootScope.$evalAsync(function () {
        swal(title, message, 'error');
      });
    },
    warning: function (title, message) {
      $rootScope.$evalAsync(function () {
        swal(title, message, 'warning');
      });
    },
    info: function (title, message) {
      $rootScope.$evalAsync(function () {
        swal(title, message, 'info');
      });
    },
    showInputError: function (message) {
      $rootScope.$evalAsync(function () {
        swal.showInputError(message);
      });
    },
    close: function () {
      $rootScope.$evalAsync(function () {
        swal.close();
      });
    }
  };

  return self;
}]);