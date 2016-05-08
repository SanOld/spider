<?php
$this->pageTitle = 'Audit | ' . Yii::app()->name;
$this->breadcrumbs = array('Audit');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/audit.js"></script>

<div ng-controller="AuditController" ng-cloak class="wraper container-fluid audit-page">
  <div class="row">
    <div class="container center-block">
      <div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h1 class="panel-title col-lg-6">Audit</h1>

          <div class="pull-right heading-box-print">
            <a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
          </div>
        </div>
        <div id="tab-history" class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="row datafilter">
                <form action="#">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>Suche nach Namen</label>
                      <input ng-change="updateGrid()" ng-model="filter.user_name" class="form-control" type="text" placeholder="Eingegeben"/>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <div class="form-group">
                        <label>Choose section</label>
                        <ui-select ng-change="updateGrid()" class="type-user" ng-model="filter.table_name">
                            <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                            <ui-select-choices repeat="item.table_name as item in tables | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                            </ui-select-choices>
                        </ui-select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <label>Date</label>
                    <div class="input-group">
                      <input uib-datepicker-popup="dd.MM.yyyy" is-open="popup.opened" datepicker-options="dateOptions"
                             ng-change="updateGrid()" ng-model="filter.date" type="text" id="audit-date" class="form-control datepicker" placeholder="All dates">
                      <span class="input-group-addon" ng-click="popup.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <div class="form-group">
                        <label>Typ</label>
                        <ui-select ng-change="updateGrid()" class="type-user" ng-model="filter.event_type">
                            <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                            <ui-select-choices repeat="item.code as item in types | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                            </ui-select-choices>
                        </ui-select>
                       </div>
                    </div>
                  </div>

                  <div class="col-lg-2 reset-btn-width">
                    <button ng-click="resetFilter()" class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                  </div>
                </form>
              </div>

<!--              <table id="datatable" ng-cloak ng-table="tableParams"
                     class="table dataTable table-hover table-bordered table-edit">
                <tr ng-repeat="row in $data">
                  <td data-title="'operation'" sortable="'operation_name'">{{row.operation_name}}</td>
                  <td data-title="'Darw'" sortable="'event_date'">{{row.date_formated}}</td>
                  <td data-title="'User'" sortable="'user_name'">{{row.user_name}}</td>
                </tr>
              </table>
              -->
              
              <table id="datatable" ng-table="tableParams" class="table-bordered">
                <colgroup>
                  <col width="60%" />
                  <col width="20%" />
                  <col width="20%" />
                </colgroup>
                <tr class="ng-table-group thead" ng-repeat-start="group in $groups" ng-class="{'open':group.data[0].showDetails, 'delete': group.data[0].event_type == 'DEL', 'insert':  group.data[0].event_type == 'INS'}">
                  <td>
                    <strong>{{group.data[0].operation_name}}</strong>
                    <span>Bearbeitet {{group.data[0].user_name}} am {{group.data[0].date_formated}}</span> 
                  </td>
                  <td>
                    <span class="after">Früher</span>
                  </td>
                  <td>
                    <span class="before">Nachher</span>
                    <a href="" ng-click="group.$hideRows = !group.$hideRows">
                      <i class="ion-chevron-down arrow-box"></i>
                    </a>
                  </td>
                </tr>
                <tr ng-hide="group.$hideRows" ng-repeat="field in group.data[0].data" ng-repeat-end>
                  <td sortable="'column_name'" data-title="'Country'">
                    {{field.column_name}}
                  </td>
                  <td sortable="'old_value'" data-title="'Früher'" >
                    {{field.old_value}}
                  </td>
                  <td sortable="'new_value'" data-title="'Nachher'">
                    {{field.new_value}}
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

