<?php
$this->pageTitle = 'Fördertöpfe | ' . Yii::app()->name;
$this->breadcrumbs = array('Fördertöpfe');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/finance-source.js"></script>

<div ng-controller="FinanceSourceController" ng-cloak class="wraper container-fluid">
  <div class="row">
    <div class="container center-block">
      <div spi-hint-main title="_hint.header.title" text="_hint.header.text"></div>
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h1 class="panel-title col-lg-6">Fördertöpf hinzufügen</h1>

          <div class="pull-right heading-box-print">
            <a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
            <button class="btn w-lg custom-btn" ng-if="canEdit()" ng-click="openEdit()">Schule hinzufügen</button>
          </div>
        </div>
        <div class="panel-body schoole-user">
          <div class="row">
            <div class="col-lg-12">
              <table id="datatable" ng-cloak ng-table="tableParams"
                     class="table dataTable table-hover table-bordered table-edit">
                <tr ng-repeat="row in $data">
                  <td data-title="'Fördertopf'" sortable="'finance_source_type'">{{row.finance_source_type}}</td>
                  <td data-title="'Programm'" sortable="'programm'">{{row.programm}}</td>
                  <td data-title="'Details'" sortable="'description'">{{row.description}}</td>
                  <td data-title="'Bearbeiten'" ng-if="canEdit()" header-class="'dt-edit'" class="dt-edit">
                    <a class="btn center-block edit-btn" ng-click="openEdit(row)">
                      <i class="ion-edit"></i>
                    </a>
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


<script type="text/ng-template" id="editTemplate.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left" ng-if="!isInsert">Fördertöpf bearbeiten</h3>

      <h3 class="m-0 pull-left" ng-if="isInsert">Fördertöpf hinzufügen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body">
      <ng-form name="formFinances" class="form-horizontal">
        <div class="row">
          <div class="m-b-15 clearfix">
            <label class="col-lg-3 control-label">Fördertopf</label>

            <div class="col-lg-9">
              <div spi-hint text="_hint.finance_source_type" class="has-hint"></div>
              <div class="wrap-hint">
                <ui-select ng-disabled="!$select.items.length" ng-model="finance.finance_source_type"
                           name="finance_source_type" required>
                  <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(Please choose)'}}">
                    {{$select.selected.name}}
                  </ui-select-match>
                  <ui-select-choices repeat="item.id as item in types | filter: $select.search">
                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                  </ui-select-choices>
                </ui-select>
              </div>
            </div>
          </div>
          <div class="m-b-15 clearfix">
            <label class="col-lg-3 control-label">Programm</label>

            <div class="col-lg-9">
              <div spi-hint text="_hint.programm" class="has-hint"></div>
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('programm')}">
                <input name="programm" ng-model="finance.programm" class="form-control" type="text" value="" required>
                <span ng-show="fieldError('programm')">
                    <label ng-show="formFinances.programm.$error.required" class="error">Programm is
                      required.</label>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="m-b-15 clearfix">
            <label class="col-lg-3 control-label">Details</label>

            <div class="col-lg-9">
              <div spi-hint text="_hint.description" class="has-hint"></div>
              <div class="wrap-hint">
                <textarea ng-model="finance.description" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group group-btn m-t-15">
          <div class="col-lg-2">
            <a class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa fa-trash-o"></i></a>
          </div>
          <div class="col-lg-10 text-right pull-right">
            <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
            <button class="btn w-lg custom-btn" ng-click="submitFormFinances()">Speichern</button>
          </div>
        </div>
      </ng-form>
    </div>
  </div>
</script>
