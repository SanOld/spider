<?php

$this->pageTitle = 'Benutzerrollen | ' . Yii::app()->name;
$this->breadcrumbs = array('Benutzerrollen');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/user-roles.js"></script>

<div ng-controller="UserRolesController" class="wraper container-fluid" >
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main title="_hint._main.title" text="_hint._main.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading heading-noborder clearfix">
					<h1 class="panel-title col-lg-6">Benutzerrollen</h1>
					<div class="pull-right heading-box-print">
						<button class="btn w-lg custom-btn" ng-click="openEdit()">Benutzer-Typ hinzufügen</button>
					</div>
				</div>
				<div class="panel-body roles-edit">
					<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
						<tr ng-repeat="row in $data">
							<td data-title="'Benutzer-Typ'" sortable="'name'">{{row.name}}</td>
							<td data-title="'Organisationstyp'">{{row.relation_name}}</td>
							<td data-title="'Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
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


<script type="text/ng-template" id="editTemplate.html">
			<div class="panel panel-color panel-primary">
				<div class="panel-heading clearfix">
          <h3 ng-if="isInsert" class="m-0 pull-left">Benutzer-Typ hinzufügen</h3>
          <h3 ng-if="!isInsert" class="m-0 pull-left">Benutzerrollen editieren</h3>
					<h3 class="m-0 pull-left">Benutzerrollen editieren</h3>
					<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
				</div>
				<div class="panel-body table-modal">
          <form novalidate name="form">
					<div class="form-group custom-field row clearfix">
						<div class="form-group col-lg-6">
							<label>Benutzer-Typ</label>
							<div ng-class="{'wrap-line error': fieldError('user_type_name')}">
              	<input class="form-control" placeholder="Benutzerdefinierter Typ" name="user_type_name" ng-model="user_type.name" type="text" value="" ng-minlength="2" ng-maxlength="255" required>
								<span ng-show="fieldError('user_type_name')">
									<label ng-show="form.user_type_name.$error.required" class="error">Type name is required.</label>
									<label ng-show="form.user_type_name.$error.minlength" class="error">Type name is too short.</label>
									<label ng-show="form.user_type_name.$error.maxlength" class="error">Type name is too long.</label>
									<span class="glyphicon glyphicon-remove form-control-feedback"></span>
								</span>
							</div>
            </div>
						<div class="form-group col-lg-6">
							<label>Organisationstyp</label>
							<select ng-if="isInsert" name="user_type_type" ng-model="user_type.type" class="type-user form-control" ng-options="r.id as r.name for r in relations"></select>
              <div ng-if="!isInsert" ng-bind="relation_name"></div>
						</div>
					</div>

          <table id="datatable-edit-roles" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered text-center">
            <tr ng-repeat="row in $data">
              <td ng-if="0">
                <input ng-if="!isInsert" type="hidden" ng-model="user_right[$index].id">
                <input ng-if="isInsert" type="hidden" ng-model="user_right[$index].type_id">
                <input ng-if="isInsert" type="hidden" ng-model="user_right[$index].page_id">
              </td>
              <td data-title="'Seite'" sortable="'name'">{{row.name}}</td>
              <td data-title="'Ansicht'" header-class="'text-center'">
                <label class="cr-styled">
                  <input type="checkbox" ng-model="user_right[$index].can_view" ng-true-value="'1'" ng-false-value="'0'" ng-disabled="default">
                  <i class="fa"></i>
                </label>
              </td>
              <td data-title="'Bearbeitung'" header-class="'text-center'">
                <label class="cr-styled">
                  <input type="checkbox" ng-model="user_right[$index].can_edit" ng-true-value="'1'" ng-false-value="'0'" ng-disabled="default">
                  <i class="fa"></i>
                </label>
              </td>
            </tr>
          </table>

					<div class="row p-t-10">
						<div class="form-group group-btn p-t-10">
							<div class="col-lg-2" ng-if="!isInsert && !default">
								<button ng-click="remove(userTypeId)" class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa fa-trash-o"></i></button>
							</div>
							<div class="col-lg-6 text-right pull-right">
								<button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
								<button class="btn w-lg custom-btn" ng-click="submitForm()">Speichern</button>
							</div>
						</div>
					</div>
          </form>
				</div>
			</div>
</script>