<?php

$this->pageTitle = 'Hintsmodul | ' . Yii::app()->name;
$this->breadcrumbs = array('Hintsmodul');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/hints.js"></script>

<div ng-controller="HintsController" class="wraper container-fluid" >
	<div class="row">
		<div class="container center-block">
			<div class="hint-details alert alert-info m-0 clearfix">
				<div class="heading-alert">
					<strong>Lorem ipsum dolor sit amet</strong>
									<span class="show-link pull-right">
										Zeigen <span class="caret"></span>
									</span>
				</div>
				<div class="content-alert">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Hintsmodul</h1>
					<div class="pull-right heading-box-print">
						<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Neuen Hint hinzufügen</button>
					</div>
				</div>
				<div class="panel-body hint-edit">
					<div class="row datafilter">
						<form action="#">
							<div class="col-lg-5">
								<div class="form-group">
									<label>Seite</label>
									<ui-select ng-change="updateGrid()" ng-model="filter.page_id" theme="select2">
										<ui-select-match allow-clear="true" placeholder="View all">{{$select.selected.name}}</ui-select-match>
										<ui-select-choices repeat="item.id as item in pages | filter: $select.search">
											<span ng-bind-html="item.name | highlight: $select.search"></span>
										</ui-select-choices>
									</ui-select>
								</div>
							</div>
							<div class="col-lg-5">
								<div class="form-group">
									<label>Position</label>
									<input ng-change="updateGrid()" type="search" ng-model="filter.position" class="form-control" placeholder="Position eingeben">
								</div>
							</div>
							<div class="col-lg-2">
								<button class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
							</div>
						</form>
					</div>

					<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
						<tr ng-repeat="row in $data">
							<td data-title="'Seite'" sortable="'page_name'">{{row.page_name}}</td>
							<td data-title="'Position'" sortable="'position_name'">{{row.position_name}}</td>
							<td data-title="'Hilfetext'">{{row.title}}</td>
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
	</div> <!-- End Row -->
</div>



<!--Edit user role -->
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
<!--End Edit user role -->
