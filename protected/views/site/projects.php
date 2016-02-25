<?php

$this->pageTitle = 'Projekte | ' . Yii::app()->name;
$this->breadcrumbs = array('Projekte');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/projects.js"></script>

<div ng-controller="ProjectController" class="wraper container-fluid" ng-cloak>
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main title="_hint.header.title" text="_hint.header.text"></div>
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
                                            <select class="type-user form-control">
                                                <option>Alles anzeigen</option>
                                            </select>
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
                                <td data-title="'Bearbeiten'" ng-if="canEdit()" header-class="'dt-edit'" class="dt-edit">
                                  <a class="btn center-block edit-btn" ng-click="openEdit(row)">
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
