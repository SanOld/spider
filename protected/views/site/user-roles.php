<?php

$this->pageTitle = 'Benutzerrollen | ' . Yii::app()->name;
$this->breadcrumbs = array('Benutzerrollen');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/user-roles.js"></script>

<div ng-controller="UserRolesController" class="wraper container-fluid" ng-cloak>
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading heading-noborder clearfix">
					<h1 class="panel-title col-lg-6">Benutzerrollen</h1>
					<div class="pull-right heading-box-print">
						<button class="btn w-lg custom-btn" ng-if="canEdit()" ng-click="openEdit()">Benutzerrollen hinzufügen</button>
					</div>
				</div>
				<div class="panel-body roles-edit">
					<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
						<tr ng-repeat="row in $data">
							<td data-title="'Benutzerrollen'" sortable="'name'">{{row.name}}</td>
							<td data-title="'Akteur-Typ'">{{row.relation_name}}</td>
              <td data-title="'Browser / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                <a class="btn center-block edit-btn" ng-click="openEdit(row, !canEdit())">
                  <i class="ion-eye"  ng-if="!canEdit()"></i>
                  <i class="ion-edit" ng-if="canEdit()"></i>
                </a>
              </td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/ng-template" id="editTemplate.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 ng-if="isInsert" class="m-0 pull-left">Benutzerrollen hinzufügen</h3>
      <h3 ng-if="!isInsert" class="m-0 pull-left">Benutzerrollen editieren</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body table-modal">
      <form novalidate name="form" id="user_right_form" disable-all="!canEdit() || modeView">
        <div class="form-group custom-field row clearfix">
          <div class="form-group col-lg-6">
            <label>Benutzerrollen</label>
            <div spi-hint text="_hint.name" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('user_type_name')}">
              <input class="form-control" placeholder="Benutzerdefinierter Typ" name="user_type_name" ng-model="user_type.name" type="text" value="" ng-minlength="2" ng-maxlength="255" required>
              <span ng-class="{hide: !fieldError('user_type_name')}" class="hide">
                <label ng-show="form.user_type_name.$error.required" class="error">Benutzerrollen ist erforderlich</label>
                <label ng-show="form.user_type_name.$error.minlength" class="error">Benutzerrollen ist zu kurz</label>
                <label ng-show="form.user_type_name.$error.maxlength" class="error">Benutzerrollen ist zu lang</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
          <div class="form-group col-lg-6">
            <label class="m-b-10">Akteur-Typ</label>
            <div>
              <span ng-if="!isInsert" ng-bind="relation_name"></span>
              <span spi-hint text="_hint.type" class="{{isInsert ? 'has-hint' : ''}}"></span>
              <div ng-if="isInsert" class="wrap-hint">
                <select  name="user_type_type" ng-model="user_type.type" class="type-user form-control" ng-options="r.type as r.name for r in relations"></select>
              </div>
            </div>
          </div>
        </div>

        <table id="datatable-edit-roles" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered">
          <tr ng-repeat="row in $data">
            <td ng-if="0">
              <input ng-if="!isInsert" type="hidden" ng-model="user_right[$index].id">
              <input ng-if="isInsert" type="hidden" ng-model="user_right[$index].type_id">
              <input ng-if="isInsert" type="hidden" ng-model="user_right[$index].page_id">
            </td>
            <td data-title="'Seite'" sortable="'name'">{{row.name}}</td>
            <td data-title="'Content'" header-class="'text-center'" class="text-center">
              <label class="cr-styled" ng-if="user_right[$index].is_real_page != '0'">
                <input type="checkbox" ng-model="user_right[$index].can_show" ng-init="user_right[$index].can_show = user_right[$index].code == 'dashboard' ? '1' : user_right[$index].can_show" ng-true-value="'1'" ng-false-value="'0'" ng-disabled="default || user_right[$index].code == 'dashboard'">
                <i class="fa"></i>
              </label>
            </td>
            <td data-title="'Browser'" header-class="'text-center'" class="text-center">
              <label class="cr-styled">
                <input type="checkbox" ng-model="user_right[$index].can_view" ng-init="user_right[$index].can_view = user_right[$index].code == 'dashboard' ? '1' : user_right[$index].can_view" ng-model="user_right[$index].can_view" ng-true-value="'1'" ng-false-value="'0'" ng-disabled="default || user_right[$index].code == 'dashboard'">
                <i class="fa"></i>
              </label>
            </td>
            <td data-title="'Editieren'" header-class="'text-center'" class="text-center">
              <label class="cr-styled">
                <input type="checkbox" ng-model="user_right[$index].can_edit" ng-true-value="'1'" ng-false-value="'0'" ng-disabled="default">
                <i class="fa"></i>
              </label>
            </td>
          </tr>
        </table>

        <div class="row p-t-10">
          <div class="form-group group-btn p-t-10">
            <div class="col-lg-2" ng-if="canEdit() && !isInsert && !default && !modeView">
              <button ng-click="remove(userTypeId)" class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa fa-trash-o"></i></button>
            </div>
            <div class="col-lg-6 text-right pull-right">
              <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
              <button class="btn w-lg custom-btn" ng-if="canEdit() && !modeView" ng-click="submitForm()">Speichern</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</script>