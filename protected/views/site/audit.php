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
            <button class="custom-btn btn w-xs" export-to-csv ng-click="">csv Export</button>
          </div>
        </div>
        <div id="tab-history" class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <form>
                <div class="row datafilter">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>Suche nach Benutzer oder ID</label>
                      <input ng-change="updateGrid()" ng-model="filter.user_name" class="form-control" type="text" placeholder="Eingegeben"/>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <div class="form-group">
                        <label>Seite</label>
                        <ui-select ng-change="updateGrid()" class="type-user" ng-model="filter.table_name">
                            <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                            <ui-select-choices repeat="item.code as item in tables | filter: $select.search | orderBy: 'name'">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                            </ui-select-choices>
                        </ui-select>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <label>Datum</label>
                    <div class="input-group">
                      <input uib-datepicker-popup="dd.MM.yyyy" is-open="popup.opened" datepicker-options="dateOptions"
                             ng-change="dateFormat(filter.date);updateGrid();" ng-model="filter.date" type="text" id="audit-date" class="form-control datepicker" placeholder="Alle Daten">
                      <span class="input-group-addon" ng-click="popup.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <div class="form-group">
                        <label>Typ</label>
                        <ui-select ng-change="updateGrid()" class="type-user" ng-model="filter.event_type">
                            <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                            <ui-select-choices repeat="item.code as item in types | filter: $select.search | orderBy: 'name'">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                            </ui-select-choices>
                        </ui-select>
                       </div>
                    </div>
                  </div>

                  <div class="col-lg-2 reset-btn-width">
                    <button ng-click="resetFilter()" class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                  </div>
                </div>
                <div class="row datafilter-1" ng-show="filter.table_name == 'request'">
                  <div class="col-lg-2">
                    <div class="form-group">
                      <div class="form-group">
                        <label>Kennziffer</label>
                        <input ng-change="updateGrid()" ng-model="filter.request_code" class="form-control" type="text" placeholder="Kennziffer eingegeben"/>
                       </div>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <label>Jahr</label>
                    <ui-select ng-change="updateGrid()" ng-model="filter.request_year">
                      <ui-select-match allow-clear="true">{{$select.selected}}</ui-select-match>
                      <ui-select-choices repeat="item as item in years | filter: $select.search | orderBy: item">
                        <span ng-bind="item"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>
                </div>
                <div class="row datafilter-1" ng-show="filter.table_name == 'performer'">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="form-group">
                        <label>Suche nach Träger oder E-Mail</label>
                        <input ng-change="updateGrid()" ng-model="filter.performer_name" class="form-control" type="text" placeholder="Eingegeben"/>
                       </div>
                    </div>
                  </div>
                  
                </div>
              </form>

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
                  <col width="40%" />
                  <col width="30%" />
                  <col width="30%" />
                </colgroup>
                <tr ng-click="group.$hideRows = !group.$hideRows" class="ng-table-group thead" ng-repeat-start="group in $groups" ng-class="{'open':group.$hideRows, 'delete': group.data[0].event_type == 'DEL', 'insert':  group.data[0].event_type == 'INS'}">
                  <td>
                    <div class="row-title">
                      <strong>#{{group.data[0].record_id}}</strong> 
                      <spna>- {{group.data[0].table_name}}</spna> 
                      <strong style="float: right;" ng-show="group.data[0].main_code">{{group.data[0].main_code}}</strong>
                    </div>
                    <strong>{{group.data[0].operation_name}}</strong>
                    <span>von {{group.data[0].user_name}} am {{group.data[0].date_formated}}</span> 
                    <span>{{group.data[0].goal_number}}</span> 
                  </td>
                  <td>
                    <span class="after">Vorher</span>
                  </td>
                  <td>
                    <span class="before">Nachher</span>
                    <a href="">
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
                    {{field.column_name == 'goal_id' ? field.new_value + ' (' + group.data[0].goals[field.new_value] + ')' : field.new_value}}
                  </td>
                </tr>
                <tr ng-show="!$groups.length"><td class="no-result" colspan="3">Keine Ergebnisse</td></tr>
              </table>
              <div class="clearfix">
                <div class="notice" ng-repeat="type in types">
                  <span class="color-notice" ng-class="{'thead delete': type.code == 'DEL', 'acceptable-row':type.code == 'INS'}"></span>
                  {{type.name}}
                </div>
              </div>
            </div>              
          </div>          
        </div>
      </div>
    </div>
  </div>
</div>

