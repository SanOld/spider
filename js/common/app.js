var spi = angular.module('spi', [
    'ngSanitize',
    'ui.select',
    'LocalStorageModule',
    'ngTable',
    'ui.bootstrap',
    'ui.mask',
    'ngAnimate',
    'ui-notification'
]);

spi.run(function(ngTableDefaults, $templateCache) {
    ngTableDefaults.params.count = 10;
    ngTableDefaults.settings.counts = [10, 25, 50, 100];
    $templateCache.put('ng-table/header.html', '<tr><th title="{{column.headerTitle(this)}}" ng-repeat="column in $columns" class="{{column.class(this)}}" ng-class="{\'sorting\': column.sortable(this), \'sorting_asc\': column.sortable(this) && tableParams.sorting()[column.sortable(this)]==\'asc\', \'sorting_desc\': column.sortable(this) && tableParams.sorting()[column.sortable(this)]==\'desc\'}" ng-click="column.sortable(this) && tableParams.sorting(column.sortable(this), params.sorting()[column.sortable(this)]==\'asc\' ? \'desc\' : \'asc\')" ng-if="column.show(this)" ng-init="template=column.headerTemplateURL(this)">{{column.title(this)}}<div ng-if="template" ng-include="template"></div></th></tr>');
    $templateCache.put('ng-table/pager.html', '<div ng-init="countModel = params.count()" class="ng-cloak wrap-paging clearfix" ng-if="params.data.length && pages.length"> <div class="dataTables_info" id="datatable_info">{{params.page()}} bis {{pages.length ? pages.length - 2 : 1}} Einträge aus {{params.total()}} anzeigen</div> <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate"> <ul ng-if="pages.length" class="pagination"> <li class="paginate_button" ng-class="{\'disabled\': !page.active && !page.current, \'active\': page.current}" ng-repeat="page in pages" ng-switch="page.type"> <a ng-switch-when="prev" ng-click="params.page(page.number)" href="">Zurück</a> <a ng-switch-when="first" ng-click="params.page(page.number)" href=""> <span ng-bind="page.number"></span> </a> <a ng-switch-when="page" ng-click="params.page(page.number)" href=""> <span ng-bind="page.number"></span> </a> <a ng-switch-when="more" ng-click="params.page(page.number)" href="">&#8230;</a> <a ng-switch-when="last" ng-click="params.page(page.number)" href=""> <span ng-bind="page.number"></span> </a> <a ng-switch-when="next" ng-click="params.page(page.number)" href="">Weiter</a> </li> </ul> </div> <div ng-if="params.settings().counts.length" class="dataTables_length" id="datatable_length"> <label> <select name="datatable_length" ng-model="countModel" ng-change="params.count(countModel)" class="form-control input-sm" ng-options="count for count in params.settings().counts"> </select>  Objekte pro Seite </label></div></div>');
    $templateCache.put("uib/template/popover/popover.html",'<div class="popover {{placement}}" ng-class="{ in: isOpen(), fade: animation() }"> <div class="arrow" style="left: 50%;"></div><i ng-click="$parent.isOpen = false" class="ion-close-round"></i><div class="popover-content" ng-bind="content"></div>');
    $templateCache.put("angular-ui-notification.html",'<div class=\"ui-notification\"><div class="image"><i class="fa" ng-class="{\'fa-check\': t == \'s\', \'fa-exclamation\': t == \'e\', \'fa-question\': t == \'i\', \'fa-warning\': t == \'w\', \'ion-ios7-information \': t == \'p\'}"></i></div><div class="text-wrapper"><div class="title" ng-show=\"title\" ng-bind-html=\"title\"></div><div class="text" ng-bind-html=\"message\"></div></div></div>');
    $templateCache.put("uib/template/tabs/tabset.html",
        "<div>\n" +
        "  <div class=\"row\"><ul class=\"row nav nav-{{type || 'tabs'}}\" ng-class=\"{'nav-stacked': vertical, 'nav-justified': justified}\" ng-transclude></ul></div>\n" +
        "  <div class=\"tab-content\">\n" +
        "    <div class=\"tab-pane\" \n" +
        "         ng-repeat=\"tab in tabs\" \n" +
        "         ng-class=\"{active: tab.active}\"\n" +
        "         uib-tab-content-transclude=\"tab\">\n" +
        "    </div>\n" +
        "  </div>\n" +
        "</div>\n" +
        "");
});

spi.config(function($uibTooltipProvider, NotificationProvider, uiSelectConfig) {
    $uibTooltipProvider.options({trigger: 'focus', placement: 'top', appendToBody: 'true'});
    NotificationProvider.setOptions({
        delay: 5000,
        startTop: 10,
        startRight: 10,
        verticalSpacing: 3,
        horizontalSpacing: 3,
        positionX: 'right',
        positionY: 'top'
    });
    uiSelectConfig.theme = 'select2';
    uiSelectConfig.appendToBody = true;
});
