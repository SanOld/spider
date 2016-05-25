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
                                <form action="#" class="class-form">
                                    <div class="col-lg-{{canByType(['d','s','t'])?5:3}} col-width-type">
                                        <div class="form-group">
                                            <label>Suche nach Kennziffer</label>
                                            <input ng-change="updateGrid()" ng-model="filter.code" type="search" class="form-control" placeholder="Stichwort eingegeben">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-width-type">
                                        <div class="form-group">
                                            <label>Typ</label>
<!--                                            <select class="type-user form-control">
                                                <option>Alles anzeigen</option>
                                            </select>-->
                                            <ui-select ng-change="updateGrid()" ng-model="filter.school_type_id">
                                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                                <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search">
                                                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                                                </ui-select-choices>
                                            </ui-select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-width-type" ng-if="!canByType(['d'])">
                                        <div class="form-group">
                                            <label>Bezirk</label>
<!--                                            <select class="type-user form-control">
                                                <option>Alles anzeigen</option>
                                            </select>-->
                                            <ui-select ng-change="updateGrid()" ng-model="filter.district_id">
                                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                                <ui-select-choices repeat="item.id as item in districts | filter: $select.search">
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
                                                <ui-select-choices repeat="item.id as item in schools | filter: $select.search">
                                                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                                                </ui-select-choices>
                                            </ui-select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2" ng-if="!canByType(['t'])">
                                        <div class="form-group">
                                            <label>Träger</label>
                                            <ui-select ng-change="updateGrid()" ng-model="filter.performer_id">
                                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                                <ui-select-choices repeat="item.id as item in performers | filter: $select.search">
                                                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                                                </ui-select-choices>
                                            </ui-select>
<!--                                            <select class="type-user form-control">
                                                <option>Alles anzeigen</option>
                                            </select>-->
                                        </div>
                                    </div>
                                    <div class="col-lg-2 reset-btn-width">
                                        <button class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                                    </div>
                                </form>
<!--								<form class="class-form">
									<div class="col-lg-3 add2">
										<div class="form-group">
											<label>Suche nach Namen, Benutzernamen oder Email</label>
											<input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Stichwort eingegeben">
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
								</form>-->
							</div>
							<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
                              <tr ng-repeat="row in $data" >
                                <td data-title="'Kennziffer'" sortable="'code'">{{row.code}}</td>
                                <td data-title="'Schule'" >
                                  <a href="/schools#id={{school.id}}" ng-repeat="school in row.schools">{{school.name}}</a><br/>
                                </td>
                                <td data-title="'Träger'" sortable="'performer_name'"><a href="/performers#id={{row.performer_id}}">{{row.performer_name}}</a></td>
                                <td data-title="'Bezirk'" sortable="'district_name'"><a href="/districts#id={{row.district_id}}">{{row.district_name}}</a></td>
                                <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                                  <a class="btn center-block edit-btn" ng-click="openEdit(row, !canEdit(row.id)) || row.is_old != 0">
                                    <i class="ion-eye"  ng-if="!canEdit(row.id) || row.is_old != 0"></i>
                                    <i class="ion-edit" ng-if="canEdit(row.id) && row.is_old == 0"></i>
                                  </a>
                                </td>
                              </tr>
                            </table>
                            <div class="notice">
                              <span class="color-notice"></span>
                              Deaktivierte Benutzer
                            </div>
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
          <h3 class="m-0 pull-left" ng-if="!isInsert">Projekt bearbeiten</h3>
          <h3 class="m-0 pull-left" ng-if="isInsert">Projekt hinzufügen</h3>
          <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
      </div>
      <div class="panel-body">
          <ng-form name="formProjects" class="form-horizontal">
              <div class="row">
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label">Kennziffer</label>
                      <div class="col-lg-4">
                          <div spi-hint text="_hint.code" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('code')}">
                            <input name="code" ng-model="project.code" class="form-control" type="text" value="" required ng-disabled="!isInsert">
                            <span ng-class="{hide: !fieldError('code')}" class="hide">
                                <label ng-show="formFinances.code.$error.required" class="error">Code is
                                  required</label>
                                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                      </div>
                      <label class="col-lg-2 control-label">Rate</label>
                      <div class="col-lg-4">
                          <div spi-hint text="_hint.rate" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('rate')}">
                            <input name="rate" ng-model="project.rate" class="form-control" type="text" value="" required ng-change="checkRate(project)" ng-disabled="!isInsert">
                            <span ng-class="{hide: !fieldError('rate')}" class="hide">
                                <label ng-show="formFinances.rate.$error.required" class="error">Rate is
                                  required</label>
                                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                      </div>
                  </div>
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label">Project Type</label>
                      <div class="col-lg-4">
                        <div spi-hint text="_hint.project_type_id" class="has-hint"></div>
                        <div class="wrap-hint">
                          <ui-select ng-disabled="!$select.items.length || !isInsert" ng-model="project.type_id"
                                     name="type_id" required on-select="updateCode();">
                            <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Bitte wählen Sie)'}}">
                              {{$select.selected.name}}
                            </ui-select-match>
                            <ui-select-choices repeat="item.id as item in projectTypes | filter: $select.search">
                              <span ng-bind-html="item.name | highlight: $select.search"></span>
                            </ui-select-choices>
                          </ui-select>
                        </div>
                      </div>
                      <label class="col-lg-2 control-label">Schultyp</label>
                      <div class="col-lg-4">
                        <div spi-hint text="_hint.school_type_id" class="has-hint"></div>
                        <div class="wrap-hint">
                          <ui-select ng-disabled="!$select.items.length || !isInsert" ng-model="project.school_type_id"
                                     name="school_type_id" required on-select="updateSchools();updateCode();">
                            <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Bitte wählen Sie)'}}">
                              {{$select.selected.fullName}}
                            </ui-select-match>
                            <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search">
                              <span ng-bind-html="item.fullName | highlight: $select.search"></span>
                            </ui-select-choices>
                          </ui-select>
                        </div>
                      </div>
                  </div>
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label p-r-0">Träger</label>
                      <div class="col-lg-10">
                        <div spi-hint text="_hint.performer_id" class="has-hint"></div>
                        <div class="wrap-hint">
                          <ui-select ng-disabled="!$select.items.length || project.is_old==1" ng-model="project.performer_id"
                                     name="performer_id" required>
                            <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Bitte wählen Sie)'}}">
                              {{$select.selected.name}}
                            </ui-select-match>
                            <ui-select-choices repeat="item.id as item in performers | filter: $select.search">
                              <span ng-bind-html="item.name | highlight: $select.search"></span>
                            </ui-select-choices>
                          </ui-select>
                        </div>
                      </div>
                  </div>
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label">Bezirk</label>
                      <div class="col-lg-10">
                          <div spi-hint text="_hint.district_id" class="has-hint"></div>
                          <div class="wrap-hint">
                            <ui-select ng-disabled="!$select.items.length || !isInsert" ng-model="project.district_id"
                                       name="district_id" required on-select="updateSchools()">
                              <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Bitte wählen Sie)'}}">
                                {{$select.selected.name}}
                              </ui-select-match>
                              <ui-select-choices repeat="item.id as item in districts | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
                      </div>
                  </div>
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label">Schule</label>
                      <div class="col-lg-10">
                          <div spi-hint text="_hint.schools" class="has-hint"></div>
                  
                          <div class="wrap-hint" ng-class="{'select2-empty-list':!schools.length}">
                            <ui-select ng-disabled="project.is_old==1 || !schools.length" multiple ng-model="project.schools"
                                       name="schools" required>
                              <ui-select-match placeholder="{{placeholderFN($select.items)}}">
                                {{$item.name}}
                              </ui-select-match>
                              <ui-select-choices repeat="item.id as item in schools | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
                  
                      </div>
                  </div>

              </div>
              <div class="form-group group-btn m-t-15">
                  <div class="col-lg-2">
                      <a class="btn btn-icon btn-danger btn-lg sweet-4" ng-click="remove()"><i class="fa fa-trash-o"></i></a>
                  </div>
                  <div class="col-lg-10 text-right pull-right">
                      <button class="btn w-lg cancel-btn" data-dismiss="modal" ng-click="cancel()">Abbrechen</button>
                      <button class="btn w-lg custom-btn" data-dismiss="modal" ng-click="submitFormProjects()">Speichern</button>
                  </div>
              </div>
          </ng-form>
      </div>
  </div>
</script>