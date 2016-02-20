<?php

$this->pageTitle = 'Benutzerliste | ' . Yii::app()->name;
$this->breadcrumbs = array('Benutzerliste');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

<div ng-controller="UserController" class="wraper container-fluid" ng-cloak>
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main title="_hint.header.title" text="_hint.header.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Benutzerliste</h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
						<button class="btn w-lg custom-btn" ng-click="openEdit()">Benutzer hinzufügen</button>
					</div>
				</div>
				<div class="panel-body edit-user">
					<div class="row">
						<div class="col-lg-12">
							<div class="row datafilter">
								<form class="class-form">
									<div class="col-lg-3 add2">
										<div class="form-group">
											<label>Suche nach Namen, Benutzernamen oder Email</label>
											<input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Stichwort eingegeben">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label>Benutzer-Typ</label>
											<ui-select ng-change="updateGrid()" ng-model="filter.type_id">
												<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
												<ui-select-choices repeat="item.id as item in userTypes | filter: $select.search">
													<span ng-bind-html="item.name | highlight: $select.search"></span>
												</ui-select-choices>
											</ui-select>
										</div>
									</div>
									<div class="col-lg-4 add">
										<div class="form-group">
											<label>Organisation</label>
											<input ng-change="updateGrid()" type="text" ng-model="filter.relation_name" placeholder="Organisationsname eingeben" class="search-relation form-control">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label>Status</label>
											<ui-select ng-change="updateGrid()" ng-model="filter.is_active">
												<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
												<ui-select-choices repeat="item.id as item in statuses | filter: $select.search">
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
							<?php require_once(__DIR__.'/partials/users-table.php'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
