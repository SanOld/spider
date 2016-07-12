<?php

$this->pageTitle = 'Projekte | ' . Yii::app()->name;
$this->breadcrumbs = array('Projekte');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/projects.js"></script>

<div ng-controller="ProjectController" class="wraper container-fluid" ng-cloak>
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Projekte</h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
						<button class="btn w-lg custom-btn" ng-if="canEdit() && canByType(['a'])" ng-click="openEdit()">Projekt hinzufügen</button>
					</div>
				</div>
				<div class="panel-body edit-project">
					<div class="row">
						<div class="col-lg-12">
							<div class="row datafilter">
                <form action="javascript:;" class="class-form">
                    <div class="col-lg-1 custom-lg-1">
                        <div class="form-group">
                            <label>Suche nach Kennziffer</label>
                            <input ng-change="updateGrid()" ng-model="filter.code" type="search" class="form-control" placeholder="Stichwort eingegeben">
                        </div>
                    </div>
                    <div class="col-lg-1">
                      <div class="form-group">
                        <div class="form-group">
                          <label>Topf</label>
                          <ui-select ng-change="updateGrid()" ng-model="filter.real_code">
                            <ui-select-match allow-clear="true"  placeholder="Alles anzeigen">{{$select.selected.code}}</ui-select-match>
                            <ui-select-choices repeat="item.code as item in realCodes | filter: $select.search | orderBy: code">
                              <span ng-bind-html="item.code | highlight: $select.search"></span>
                            </ui-select-choices>                      
                          </ui-select>
                        </div>
                      </div>
                    </div>                    
                    <div class="col-lg-1 custom-lg-1">
                        <div class="form-group">
                            <label>Typ</label>
<!--                                            <select class="type-user form-control">
                                <option>Alles anzeigen</option>
                            </select>-->
                            <ui-select ng-change="updateGrid()" ng-model="filter.school_type_id">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search | orderBy: 'name'">
                                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="col-lg-1 custom-lg-1" ng-if="!canByType(['d'])">
                        <div class="form-group">
                            <label>Bezirk</label>
<!--                                            <select class="type-user form-control">
                                <option>Alles anzeigen</option>
                            </select>-->
                            <ui-select ng-change="updateGrid()" ng-model="filter.district_id">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in districts | filter: $select.search | orderBy: 'name'">
                                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="col-lg-2" ng-if="!canByType(['s'])">
                        <div class="form-group">
                            <label>Schule</label>
<!--                                            <select class="type-user form-control">
                                <option>Alles anzeigen</option>
                            </select>-->
                            <ui-select ng-change="updateGrid()" ng-model="filter.school_id">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in schools | filter: $select.search | orderBy: 'name'">
                                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="col-lg-2" ng-if="!canByType(['t'])">
                        <div class="form-group">
                            <label>Träger</label>
                            <ui-select ng-change="updateGrid()" ng-model="filter.performer_id">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.short_name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in performers | filter: $select.search | orderBy: 'name'">
                                    <span ng-bind-html="item.short_name | highlight: $select.search"></span>
                                </ui-select-choices>
                            </ui-select>
<!--                                            <select class="type-user form-control">
                                <option>Alles anzeigen</option>
                            </select>-->
                        </div>
                    </div>
                    <div class="col-lg-2 reset-btn-width">
                        <button ng-click="resetFilter()" class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                    </div>
                </form>
							</div>
							<?php include(Yii::app()->getBasePath().'/views/site/partials/project-table.php'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/ng-template" id="editProjectTemplate.html">
  <?php include(Yii::app()->getBasePath().'/views/site/partials/project-editor.php'); ?>
</script>