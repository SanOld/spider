<?php
$this->pageTitle = 'Finanzübersicht | ' . Yii::app()->name;
$this->breadcrumbs = array('Finanzen','Finanzübersicht');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/summary.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

			<div ng-controller="SummaryController"  class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
            <div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Finanzübersicht</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
                  <button class="custom-btn btn w-xs" export-to-csv ng-click="">csv Export</button>
								</div>
							</div>
							<div class="panel-body summary-user request-edit">
								<div class="row">
									<div class="col-lg-12">
										<div class="row datafilter">
											<form>
												<div class="col-lg-2">
													<div class="form-group">
														<label>Suche nach Kennziffer</label>
														<input ng-change="updateGrid()" type="search" ng-model="filter.code" class="form-control popup-input" placeholder="Kennziffer eingegeben">
													</div>
												</div>
												<div class="col-lg-2">
													<div class="form-group">
														<label>Träger</label>
														<ui-select ng-change="updateGrid()" ng-model="filter.performer_id">
                              <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.short_name}}</ui-select-match>
                              <ui-select-choices repeat="item.id as item in performers | filter: $select.search">
                                <span ng-bind="item.short_name"></span>
                              </ui-select-choices>
                            </ui-select>
													</div>
												</div>
												<div class="col-lg-2">
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
												<div class="col-lg-2">
													<div class="form-group">
														<div class="form-group">
															<label>Fördertopf</label>
															<ui-select ng-change="updateGrid()" ng-model="filter.project_type_id">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in projectTypes | filter: $select.search | orderBy: 'name'">
                                  <span ng-bind="item.name"></span>
                                </ui-select-choices>
                              </ui-select>
														</div>
													</div>
												</div>
												<div class="col-lg-2">
													<div class="form-group">
														<label>Jahr</label>
														<ui-select ng-change="updateGrid()" ng-model="filter.year">
                              <ui-select-match placeholder="Alles anzeigen">{{$select.selected.year}}</ui-select-match>
                              <ui-select-choices repeat="item.year as item in years | filter: $select.search | orderBy: year">
                                <span ng-bind="item.year"></span>
                              </ui-select-choices>                      
                            </ui-select>
													</div>
												</div>
												<div class="col-lg-2 reset-btn-width">
                          <button ng-click="resetFilter()" class="btn pull-right w-lg custom-reset"> <i class="fa fa-rotate-left"></i>
                            <span>Filter zurücksetzen</span>
                          </button>
                        </div>
											</form>
										</div>
                      
                    <table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit table-summary">
                      <tr ng-repeat="row in $data">
                        <td id="checkbox" header="'headerCheckbox.html'">
                          <label class="cr-styled">
                            <input type="checkbox" ng-model="checkboxes.items[row.id]">
                            <i class="fa"></i>
                          </label>
                        </td>
                        <td data-title="'Kennz.'" sortable="'project_code'">{{row.project_code}}</td>
                        <td data-title="user.type != 't' ? 'Träger' : 'Schule(n)'" sortable="user.type != 't' ? 'performer_name' : 'school_name'">
                          <div class="holder-school">
                            <a ng-if="user.type != 't'" href="/performers#id={{row.performer_id}}" target="_blank">{{row.performer_name}}</a>
                              <i ng-if="user.type != 't' && +row.performer_is_checked" class="success fa fa-check-circle" aria-hidden="true"></i>
                            <a ng-if="user.type == 't'" href="/schools#id={{school.id}}" ng-repeat="school in row.schools" class="school-td" target="_blank">{{school.name}}</a>
                          </div>
                        </td>
                        <td data-title="'Topf'" sortable="'programm'">{{row.programm == "Bonusprogramm" ? row.type : row.programm }}</td>
                        <td data-title="'Jahr'" sortable="'year'">{{row.year}}</td>
                        <td class="holder-actual" data-title="'Förders.'" sortable="'total_cost'">{{row.total_cost | number:2}} €</td>
                        <td class="holder-actual" data-title="'Änderung'" sortable="'changes'">{{row.changes | number:2}} €</td>
                        <td class="holder-actual" title="aktuelle Fördersumme" data-title="'aktuelle Förders.'" sortable="'end_fill'">{{row.actual | number:2}} €</td>
                        <td class="holder-actual" data-title="'Ausgezahlt'" sortable="'payed'">{{row.payed | number:2}} €</td>
                        <td class="holder-report" data-title="'F-Berichte'" sortable="'finance_report'">{{row.finance_report | number:2}} €</td>
                        <td class="holder-actual" data-title="'Verblieben'" sortable="'remained'">{{row.remained | number:2}} €</td>
                        <td data-title="'Mittelabrufe / Finanzberichte'" class="dt-edit">
                          <a title="Mittelabrufe" ng-click="link('financial-request', row)" class="btn requsted-btn">
                            <span></span>
                          </a>
                          <a title="Finanzbericht" ng-click="link('finance-report', row)" class="btn requsted-btn" href="/finance-report">
                            <span></span>
                          </a>
                        </td>
                        <td data-title="'VN'">
                            <a title="Drucken" ng-click="printDocuments(row)" ng-disabled="user.type != 'a' && user.type != 't' && user.type != 'p'" class="btn document"><i class="ion-printer"></i></a>
                        </td>
                      </tr>
                      <tr ng-if="!$data.length"><td class="no-result" colspan="13">Keine Ergebnisse</td></tr>
                    </table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div>
    
		<script type="text/ng-template" id="headerCheckbox.html">
      <label class="cr-styled">
        <input type="checkbox" ng-model="checkboxes.checked" ng-click="headerChecked(checkboxes.checked)">
        <i class="fa"></i>
      </label>
    </script>
    
    <script type="text/ng-template" id="printSummaryDocuments.html">
    <div class="panel panel-color panel-primary">
      <div class="panel-heading clearfix">
        <h3 class="m-0 pull-left">Dokumente drucken - {{::code}}</h3>
        <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
      </div>
      <div class="panel-body">
        <h3 class="m-b-30 text-center">Dokumente zum Druck</h3>
        <div ng-repeat="template in templates" class="doc-print">
          <div class="holder-doc-print">
            <span class="name-doc">{{template.type_name}}:</span>
            <p>{{template.name}}</p>
          </div>
          <div class="btn-row">
            <button class="btn w-xs" data-target="#modal-1" data-toggle="modal" ng-click="printDoc(template)">
              <span>Drucken</span>
              <i class="ion-printer"></i>
            </button>
          </div>
        </div>

      </div>
      <div class="row p-t-10 text-center">
        <div class="form-group group-btn m-t-20">
          <div class="col-lg-12">
            <button class="btn w-lg cancel-btn" ng-click="cancel()">ABBRECHEN</button>
          </div>
        </div>
      </div>
    </div>
  </script>
  
  <script type="text/ng-template" id="showTemplate.html">
    <?php include(Yii::app()->getBasePath().'/views/site/partials/document-template.php'); ?>
  </script>