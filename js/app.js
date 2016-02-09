var spi = angular.module('spi',['ngSanitize', 'ui.select', 'LocalStorageModule', 'ngTable', 'ui.bootstrap', 'ui.mask']);

spi.run(function(ngTableDefaults, $templateCache) {
    ngTableDefaults.params.count = 10;
    ngTableDefaults.settings.counts = [10, 25, 50, 100];
    $templateCache.put('ng-table/header.html', '<tr><th title="{{column.headerTitle(this)}}" ng-repeat="column in $columns" class="{{column.class(this)}}" ng-class="{\'sorting\': column.sortable(this), \'sorting_asc\': column.sortable(this) && tableParams.sorting()[column.sortable(this)]==\'asc\', \'sorting_desc\': column.sortable(this) && tableParams.sorting()[column.sortable(this)]==\'desc\'}" ng-click="tableParams.sorting(column.sortable(this), params.sorting()[column.sortable(this)]==\'asc\' ? \'desc\' : \'asc\')" ng-if="column.show(this)">{{column.title(this)}}</th></tr>');
    $templateCache.put('ng-table/pager.html', '<div ng-init="countModel = params.count()" class="ng-cloak wrap-paging clearfix" ng-if="params.data.length && pages.length"> <div class="dataTables_info" id="datatable_info">{{params.page()}} bis {{pages.length ? pages.length - 2 : 1}} Einträge aus {{params.total()}} anzeigen</div> <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate"> <ul ng-if="pages.length" class="pagination"> <li class="paginate_button" ng-class="{\'disabled\': !page.active && !page.current, \'active\': page.current}" ng-repeat="page in pages" ng-switch="page.type"> <a ng-switch-when="prev" ng-click="params.page(page.number)" href="">Zurück</a> <a ng-switch-when="first" ng-click="params.page(page.number)" href=""> <span ng-bind="page.number"></span> </a> <a ng-switch-when="page" ng-click="params.page(page.number)" href=""> <span ng-bind="page.number"></span> </a> <a ng-switch-when="more" ng-click="params.page(page.number)" href="">&#8230;</a> <a ng-switch-when="last" ng-click="params.page(page.number)" href=""> <span ng-bind="page.number"></span> </a> <a ng-switch-when="next" ng-click="params.page(page.number)" href="">Weiter</a> </li> </ul> </div> <div ng-if="params.settings().counts.length" class="dataTables_length" id="datatable_length"> <label> <select name="datatable_length" ng-model="countModel" ng-change="params.count(countModel)" class="form-control input-sm" ng-options="count for count in params.settings().counts"> </select>  Objekte pro Seite </label></div></div>');
    $templateCache.put("uib/template/popover/popover.html",'<div class="popover {{placement}}" ng-class="{ in: isOpen(), fade: animation() }"> <div class="arrow" style="left: 50%;"></div><i ng-click="$parent.isOpen = false" class="ion-close-round"></i><div class="popover-content" ng-bind="content"></div>');
});

spi.config(function($uibTooltipProvider) {
    $uibTooltipProvider.options({trigger: 'focus', placement: 'top', appendToBody: 'true'})
});


spi.service('configs', function () {
    var $configs = this;

    $configs.getServisePath = function(){
        return ((location+'').match(/http\:\/\/([^\/]+)/)[0])+'/api/';
    };
    $configs.getAuthPath = function(){
        return ((location+'').match(/http\:\/\/([^\/]+)/)[0])+'/api/login';
    };
    $configs.getSitePath = function(){
        return ((location+'').match(/http\:\/\/([^\/]+)/)[0])+'';
    };
    $configs.getDomain = function(){
        var domain = ((location+'').match(/http\:\/\/([^\/]+)/)[1])+'';
        var path = domain.split('.');
        var start = path.length-2;
        start = start < 0 ? 0 : start;
        account = path.splice(start,path.length).join('.');
        return account;
    };
    $configs.getAccount = function(){
        var domain = ((location+'').match(/http\:\/\/([^\/]+)/)[1])+'';
        var path = domain.split('.');
        var account = '';
        if(path.length > 2) {
            account = path.splice(0,path.length-2).join('.');
        }
        return account;
    }
});

spi.directive("passwordVerify", function() {
    return {
        require: "ngModel",
        scope: {
            passwordVerify: '='
        },
        link: function(scope, element, attrs, ctrl) {
            scope.$watch(function() {
                var combined;
                if (scope.passwordVerify || ctrl.$viewValue) {
                    combined = scope.passwordVerify + '_' + ctrl.$viewValue;
                }
                return combined;
            }, function(value) {
                if (value) {
                    ctrl.$parsers.unshift(function(viewValue) {
                        var origin = scope.passwordVerify;
                        if (origin !== viewValue) {
                            ctrl.$setValidity("passwordVerify", false);
                            return undefined;
                        } else {
                            ctrl.$setValidity("passwordVerify", true);
                            return viewValue;
                        }
                    });
                }
            });
        }
    };
});


spi.service("GridService", function(network, NgTableParams, $uibModal) {
    return function() {
        var tableParams;
        var defaultFilter = {};
        var filter = {};

        function getData(path, params, filter, callback){
            filter['limit'] = params.count();
            filter['page'] = params.page();
            var sort = params.sorting();
            if(Object.keys(sort).length) {
                filter['order'] = Object.keys(sort)[0];
                filter['direction'] = sort[filter['order']];
            }
            network.get(path, angular.copy(filter), function(result, response){
                if(result) {
                    callback(response);
                }
            });
        }

        function filterEquals() {
            var trueFilter = {};
            var except = ['page', 'limit', 'order', 'direction'];
            for (var k in filter) {
                if(except.indexOf(k) === -1) {
                    trueFilter[k] = filter[k];
                }
            }
            return angular.equals(defaultFilter, trueFilter);
        }

        function grid(data, defFilter, params) {
            filter = defFilter || {};
            params = params || {};
            defaultFilter = angular.copy(filter);
            var dataset = typeof(data) === 'object' ? {dataset: data} : {
                getData: function($defer, params) {
                    getData(data, params, filter, function(response) {
                        tableParams.total(response.count);
                        $defer.resolve(response.result);
                    });
                }
            };
            tableParams = new NgTableParams(params, dataset);
            return tableParams;
        }
        grid.reload = function() {
            tableParams.page(1);
            tableParams.reload();
        };
        grid.resetFilter = function() {
            if(!filterEquals()) {
                filter = angular.copy(defaultFilter);
                grid.reload();
            }
            return filter;
        };
        grid.openEditor = function(params, callback) {
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: params.template || 'editTemplate.html',
                controller: params.controller || 'ModalEditController',
                size: params.size || 'lg',
                resolve: {
                    data: function () {
                        return params.data || {};
                    }
                }
            });

            modalInstance.result.then(function () {
                callback ? callback() : tableParams.reload();
            });
        };
        return grid;
    }
});

spi.filter('tel', function () {
    return function (tel) {
        if (!tel) { return ''; }

        var value = tel.toString().trim().replace(/^\+/, '');

        if (value.match(/[^0-9]/)) {
            return tel;
        }

        var country, city, number;

        switch (value.length) {
            case 10: // +1PPP####### -> C (PPP) ###-####
                country = 1;
                city = value.slice(0, 3);
                number = value.slice(3);
                break;

            case 11: // +CPPP####### -> CCC (PP) ###-####
                country = value[0];
                city = value.slice(1, 4);
                number = value.slice(4);
                break;

            case 12: // +CCCPP####### -> CCC (PP) ###-####
                country = value.slice(0, 3);
                city = value.slice(3, 5);
                number = value.slice(5);
                break;

            default:
                return tel;
        }

        if (country == 1) {
            country = "";
        }

        number = number.slice(0, 3) + '-' + number.slice(3);

        return (country + " (" + city + ") " + number).trim();
    };
});



