<?php

$this->pageTitle = 'Benutzerrollen | ' . Yii::app()->name;
$this->breadcrumbs = array('Benutzerrollen');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/user-roles.js"></script>

<div ng-controller="UserRolesController" class="wraper container-fluid" >
	<div class="row">
		<div class="container center-block">
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
							<td data-title="'Organisationstyp'" sortable="'relation_name'">{{row.relation_name}}</td>
							<td data-title="'Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
								<a class="btn center-block" ng-click="openEdit(row)">
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
					<div class="form-group custom-field row clearfix">
						<div class="form-group col-lg-6">
							<label>Benutzer-Typ</label>
							<input class="form-control" type="text" placeholder="Benutzerdefinierter Typ">
						</div>
						<div class="form-group col-lg-6">
							<label>Organisationstyp</label>
							<select class="type-user form-control">
								<option>Keine Verbindung</option>
								<option>Bezirk</option>
								<option>Schule</option>
								<option>Träger</option>
							</select>
						</div>
					</div>

          <table id="datatable-edit-roles" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered text-center">
            <tr ng-repeat="row in $data">
              <td data-title="'Seite'" sortable="'name'">{{row.name}}</td>
              <td data-title="'Ansicht'" header-class="'text-center'">
                <label class="cr-styled">
                  <input type="checkbox" checked="">
                  <i class="fa"></i>
                </label>
              </td>
              <td data-title="'Bearbeitung'" header-class="'text-center'">
                <label class="cr-styled">
                  <input type="checkbox" checked="">
                  <i class="fa"></i>
                </label>
              </td>
            </tr>
          </table>

					<div class="row p-t-10">
						<div class="form-group group-btn p-t-10">
							<div class="col-lg-2" ng-if="!isInsert && !default">
								<button class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa  fa-trash-o"></i></button>
							</div>
							<div class="col-lg-6 text-right pull-right">
								<button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
								<button class="btn w-lg custom-btn" ng-click="submitForm(user)">Speichern</button>
							</div>
						</div>
					</div>
				</div>
			</div>
</script>
<!--End Edit user role -->
