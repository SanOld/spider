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
                    <div class="col-lg-{{canByType(['d','s','t']) ? '2' : '1 custom-pr-3'}}">
                      <div class="form-group">
                        <label>Kennziffer</label>
                        <input ng-change="updateGrid()" type="search" ng-model="filter.code" class="form-control popup-input" placeholder="Kennziffer eingegeben" ng-hide="user.type  == 't'">
                        <ui-select ng-change="updateGrid()" ng-model="filter.code">
                          <ui-select-match allow-clear="true" placeholder="Kennziffer eingegeben">{{$select.selected.code}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in projects | filter: $select.search | orderBy: 'code'">
                            <span ng-bind="item.code"></span>
                          </ui-select-choices>
                        </ui-select>                    
                      </div>
                    </div>
                    <div class="col-lg-{{canByType(['d','s','t']) ? 2 : '1 custom-pr-2'}}">
                      <div class="form-group">
                        <div class="form-group">
                          <label>Fördertopf</label>
                          <ui-select ng-change="updateGrid()" ng-model="filter.type_id">
                            <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                            <ui-select-choices repeat="item.id as item in projectTypes | filter: $select.search | orderBy: 'name'">
                              <span ng-bind="item.name"></span>
                            </ui-select-choices>
                          </ui-select>
                        </div>
                      </div>
                    </div>                    
                    <div class="col-lg-{{canByType(['d','s','t'])? '2' : '1 custom-lg-1'}}">
                        <div class="form-group">
                            <label>Schultyp</label>
                            <ui-select ng-change="updateGrid()" ng-model="filter.school_type_id">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search | orderBy: 'name'">
                                    <span ng-bind="item.full_name"></span>
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                    <div class="col-lg-{{canByType(['d','s','t'])? '2' : '1 custom-lg-1'}}" ng-if="!canByType(['d'])">
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
                    <div class="col-lg-{{canByType(['d','s','t'])? '2' : '1 custom-pr-3'}}" ng-if="!canByType(['s'])">
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
                    <div class="col-lg-{{canByType(['s']) ? '2' : '1 custom-pr-4'}}" ng-if="!canByType(['t'])">
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
              <div class="btn-row m-t-15 clearfix" ng-if="canByType(['a'])">
                  <button <?php $this->demo();?> ng-disabled="!existsSelected()" ng-click="addRequest()" class="btn w-lg custom-btn" data-modal="">Antrag hinzufügen</button>
              </div>
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

<script type="text/ng-template" id="createRequest.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Anfrage hinzufügen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>

    <div class="panel-body text-center">
      <h3 class="m-b-30">Geben Sie die Jahr für die {{::countElements}} Elemente auswählen</h3>
      <ng-form name="copyRequest">
      <div class="col-lg-12 text-left">
        <div class="form-group">
          <label>Jahr</label>
          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('year')}">
            <div class="input-group">
              <input required type="text" ng-change="search($select.search, 'year')" ng-click="dp_year_date_is_open = !dp_year_date_is_open" ng-model="year" uib-datepicker-popup="yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_year_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" name="year" >
              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar" ng-click="dp_year_date_is_open = !dp_year_date_is_open"></i></span>
            </div>
            <span ng-class="{hide: !fieldError('year')}" class="hide">
              <label ng-show="copyRequest.year.$error.required" class="error">Jahr erforderlich</label>
              <span class="glyphicon glyphicon-remove form-control-feedback" style="right: 38px;"></span>
            </span>
          </div>
        </div>
        <div class="form-group">
          <label>Kennziffer</label>
          <li class="list-group-item">{{::selectedElements}}</li>
        </div>
      </div>
      </ng-form>
    </div>

    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" ng-click="ok()" ng-disabled="form.$invalid || form.due_date < form.start_date">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</script>

