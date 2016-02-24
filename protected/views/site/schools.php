<?php
$this->pageTitle = 'Schule | ' . Yii::app()->name;
$this->breadcrumbs = array('Schule');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/schools.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

<div ng-controller="SchoolController" ng-cloak class="wraper container-fluid">
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main title="_hint.header.title" text="_hint.header.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Schule</h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
						<button class="btn w-lg custom-btn" ng-if="canEdit()" ng-click="openEdit()">Schule hinzufügen</button>
					</div>
				</div>
				<div class="panel-body schoole-user">
					<div class="row">
						<div class="col-lg-12">
							<div class="row datafilter">
								<form class="class-form">
									<div class="col-lg-5">
										<div class="form-group">
											<label>Suche nach Namen, Nummer, Adresse oder Ansprechpartner(in)</label>
											<input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Eingegeben">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label>Schultyp</label>
											<ui-select ng-change="updateGrid()" class="type-user" ng-model="filter.type_id">
												<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
												<ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search">
													<span ng-bind-html="item.name | highlight: $select.search"></span>
												</ui-select-choices>
											</ui-select>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<label>Bezirk</label>
											<ui-select ng-change="updateGrid()" class="type-user" ng-model="filter.district_id">
												<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
												<ui-select-choices repeat="item.id as item in districts | filter: $select.search">
													<span ng-bind-html="item.name | highlight: $select.search"></span>
												</ui-select-choices>
											</ui-select>
										</div>
									</div>
									<div class="col-lg-2 reset-btn-width">
										<button ng-click="resetFilter()" class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
									</div>
								</form>
							</div>

							<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
								<tr ng-repeat="row in $data">
									<td data-title="'Nummer'" sortable="'number'">{{row.number}}</td>
									<td data-title="'Name'" sortable="'name'">{{row.name}}</td>
									<td data-title="'Schultyp'" sortable="'type_name'">{{row.type_name}}</td>
									<td data-title="'Bezirk'" sortable="'district_name'">{{row.district_name}}</td>
									<td data-title="'Adresse'" sortable="'address'">{{row.address}}</td>
									<td data-title="'Ansprechpartner(in)'" sortable="'contact_user_name'">{{row.contact_user_name}}</td>
									<td data-title="'Telefon'" sortable="'phone'">{{row.phone | tel}}</td>
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
	</div> <!-- End Row -->
</div>

<?php include(Yii::app()->getBasePath().'/views/site/partials/school-editor.php'); ?>
