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
						<button class="btn w-lg custom-btn" ng-if="canEdit()" ng-click="openEdit()">Projekt hinzufügen</button>
					</div>
				</div>
				<div class="panel-body edit-project">
					<div class="row">
						<div class="col-lg-12">
							<div class="row datafilter">
                                <form action="#" class="class-form">
                                    <div class="col-lg-3 col-width-type">
                                        <div class="form-group">
                                            <label>Suche nach Kennziffer</label>
                                            <input type="search" class="form-control" placeholder="Stichwort eingegeben">
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
                                    <div class="col-lg-2 col-width-type">
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
                                    <div class="col-lg-2">
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
                                    <div class="col-lg-2">
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
                                  <a href="#" ng-repeat="school in row">{{school.name}}</a><br/>
                                </td>
                                <td data-title="'Träger'" sortable="'performer_name'"><a href="#">{{row.performer_name}}</a></td>
                                <td data-title="'Bezirk'" sortable="'district_name'">{{row.district_name}}</td>
                                <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                                  <a class="btn pull-left edit-btn" ng-click="openEdit(row, 1)">
                                    <i class="ion-eye"></i>
                                  </a>
                                  <a class="btn pull-right edit-btn" ng-click="openEdit(row)">
                                    <i class="ion-edit"></i>
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
                            <input name="code" ng-model="project.code" class="form-control" type="text" value="" required>
                            <span ng-show="fieldError('code')">
                                <label ng-show="formFinances.code.$error.required" class="error">Code is
                                  required</label>
                                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                      </div>
                      <label class="col-lg-2 control-label">Schultyp</label>
                      <div class="col-lg-4">
                        <div spi-hint text="_hint.school_type_id" class="has-hint"></div>
                        <div class="wrap-hint">
                          <ui-select ng-disabled="!$select.items.length" ng-model="project.school_type_id"
                                     name="school_type_id" required on-select="updateSchools();updateCode();">
                            <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(Please choose)'}}">
                              {{$select.selected.fullName}}
                            </ui-select-match>
                            <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search">
                              <span ng-bind-html="item.fullName | highlight: $select.search"></span>
                            </ui-select-choices>
                          </ui-select>
                        </div>
<!--                          <select class="form-control">
                              <option>S (Förderschulen)</option>
                          </select>-->
                      </div>
                  </div>
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label">Programm</label>
                      <div class="col-lg-10">
                        <div spi-hint text="_hint.school_type_id" class="has-hint"></div>
                        <div class="wrap-hint">
                          <ui-select ng-disabled="!$select.items.length" ng-model="project.finance_programm_id"
                                     name="finance_programm_id" required>
                            <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(Please choose)'}}">
                              {{$select.selected.programm}}
                            </ui-select-match>
                            <ui-select-choices repeat="item.id as item in programms | filter: $select.search">
                              <span ng-bind-html="item.programm | highlight: $select.search"></span>
                            </ui-select-choices>
                          </ui-select>
                        </div>
<!--                          <select class="form-control">
                              <option>Schulsozialarbeit</option>
                              <option>Zusatzprogramm A</option>
                              <option>Zusatzprogramm B</option>
                              <option>Bonusprogramm</option>
                          </select>-->
                      </div>
                  </div>
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label">Fördertopf</label>
                      <div class="col-lg-10">
                        <div spi-hint text="_hint.code" class="has-hint"></div>
                        <div class="wrap-hint">
                          <input name="code" ng-model1="project.finance_source_type" ng-value="finance_source_type[project.finance_programm_id]" class="form-control" type="text" value="" disabled="disabled">
                        </div>
<!--                          <select class="form-control">
                              <option>LM</option>
                              <option>BP</option>
                          </select>-->
                      </div>
                  </div>
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label p-r-0">Träger</label>
                      <div class="col-lg-10">
                        <div spi-hint text="_hint.performer_id" class="has-hint"></div>
                        <div class="wrap-hint">
                          <ui-select ng-disabled="!$select.items.length" ng-model="project.performer_id"
                                     name="performer_id" required>
                            <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(Please choose)'}}">
                              {{$select.selected.name}}
                            </ui-select-match>
                            <ui-select-choices repeat="item.id as item in performers | filter: $select.search">
                              <span ng-bind-html="item.name | highlight: $select.search"></span>
                            </ui-select-choices>
                          </ui-select>
                        </div>
<!--                          <select class="form-control">
                              <option>Stadtteilzentrum Steglitz e.V.</option>
                              <option>Arbeit und Bildung e.V.</option>
                          </select>-->
                      </div>
                  </div>
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label">Bezirk</label>
                      <div class="col-lg-10">
                          <div spi-hint text="_hint.district_id" class="has-hint"></div>
                          <div class="wrap-hint">
                            <ui-select ng-disabled="!$select.items.length" ng-model="project.district_id"
                                       name="district_id" required on-select="updateSchools()">
                              <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(Please choose)'}}">
                                {{$select.selected.name}}
                              </ui-select-match>
                              <ui-select-choices repeat="item.id as item in districts | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
<!--                          <select class="form-control">
                              <option>Bezirk Neukolln</option>
                          </select>-->
                      </div>
                  </div>
                  <div class="m-b-15 clearfix">
                      <label class="col-lg-2 control-label">Schule</label>
                      <div class="col-lg-10">
                          <div spi-hint text="_hint.schools" class="has-hint"></div>
                  
                          <div class="wrap-hint">
                            <ui-select multiple ng-disabled="!$select.items.length" ng-model="project.schools"
                                       name="schools" required>
                              <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(Please choose)'}}">
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