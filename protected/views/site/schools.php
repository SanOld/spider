<?php
$this->pageTitle = 'Schule | ' . Yii::app()->name;
$this->breadcrumbs = array('Schule');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/schools.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

<div ng-controller="SchoolController" ng-cloak class="wraper container-fluid">
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Schule</h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
            <button class="custom-btn btn w-xs" export-to-csv ng-click="">csv Export</button>
						<button <?php $this->demo(); ?>  class="btn w-lg custom-btn" ng-if="canEdit() && canByType(['a'])" ng-click="openEdit()">Schule hinzufügen</button>
					</div>
				</div>
				<div class="panel-body schoole-user">
					<div class="row">
						<div class="col-lg-12">
							<div class="row datafilter">
								<form class="class-form">
									<div class="col-lg-5">
										<div class="form-group">
											<label>Suche nach Namen, Schul-Nr., Adresse oder Schulleitung</label>
											<input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Eingegeben">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label>Schultyp</label>
											<ui-select ng-change="updateGrid()" class="type-user" ng-model="filter.type_id">
												<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
												<ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search | orderBy: 'name'">
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
												<ui-select-choices repeat="item.id as item in districts | filter: $select.search | orderBy: 'name'">
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

              <?php include(Yii::app()->getBasePath().'/views/site/partials/schools-table.php'); ?>               
                
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- End Row -->
</div>

<?php include(Yii::app()->getBasePath().'/views/site/partials/school-editor.php'); ?>
