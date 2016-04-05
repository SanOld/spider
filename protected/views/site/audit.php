<?php
$this->pageTitle = 'Audit | ' . Yii::app()->name;
$this->breadcrumbs = array('Audit');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/audit.js"></script>

<div ng-controller="AuditController" ng-cloak class="wraper container-fluid audit-page">
  <div class="row">
    <div class="container center-block">
      <div spi-hint-main title="_hint.header.title" text="_hint.header.text"></div>
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h1 class="panel-title col-lg-6">Audit</h1>

          <div class="pull-right heading-box-print">
            <a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
          </div>
        </div>
        <div class="panel-body">
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
              <div class="row">
                <div id="tab-history" class="col-lg-12">
                  <div class="changes-content">
                    <div class="heading-changes">
                      {{section}}
                    </div>
                    <div class="content-changes" ng-repeat="row in customData.result">
                      <div class="thead" ng-class="{'open':row.showDetails, 'delete': row.event_type == 'DEL', 'insert':  row.event_type == 'INS'}">
                        <div class="col-lg-4 p-l-0">
                          <strong>{{row.operation_name}}</strong>
                          <span>Bearbeitet {{row.user_name}} am {{row.date_formated}}</span> 
                        </div>
                        <div class="col-lg-4">
                          <span class="after">Früher</span>
                        </div>
                        <div class="col-lg-4">
                          <span class="before">Nachher</span>
                        </div>
                        <i ng-click="row.showDetails = !row.showDetails" class="ion-chevron-down arrow-box"></i>
                      </div>
                      <div class="row-holder" ng-show="row.showDetails">
                        <div class="custom-row" ng-repeat="field in row.data">
                          <div class="col-lg-4 p-l-0">
                            <strong>{{field.column_name}}</strong>
                          </div>
                          <div class="col-lg-4">
                            <dl class="custom-dl">
                              <dt></dt>
                              <dd>{{field.old_value}}</dd>
                            </dl>
                          </div>
                          <div class="col-lg-4">
                            <dl class="custom-dl">
                              <dt></dt>
                              <dd>{{field.new_value}}</dd>
                            </dl>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
<!--              <table id="datatable" ng-cloak ng-table="tableParams"
                     class="table dataTable table-hover table-bordered table-edit">
                <tr ng-repeat="row in $data">
                  <td data-title="'Name'" sortable="'name'">{{row.name}}</td>
                  <td data-title="'Adresse'" sortable="'address'">{{row.address}}</td>
                  <td data-title="'Ansprechpartner(in)'" sortable="'contact_user_name'">{{row.contact_user_name}}</td>
                  <td data-title="'Telefon'" sortable="'phone'">{{row.phone}}</td>
                  <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                    <a class="btn center-block edit-btn" ng-click="openEdit(row, !canEdit(row.id))">
                      <i class="ion-eye"  ng-if="!canEdit(row.id)"></i>
                      <i class="ion-edit" ng-if="canEdit(row.id)"></i>
                    </a>
                  </td>
                </tr>
              </table>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

