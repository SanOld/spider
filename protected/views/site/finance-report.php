<?php
$this->pageTitle = 'Finanzbericht | ' . Yii::app()->name;
$this->breadcrumbs = array('Finanzen','Finanzbericht');
?>		
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/finance-reports.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

			<div ng-controller="FinanceReportController" ng-cloak class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
            <div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
						<div class="panel panel-default finance-report">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Finanzbericht</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
                  <button class="custom-btn btn w-xs" export-to-csv ng-click="">csv Export</button>
									<button class="custom-btn btn w-xs" ng-if="user.type == 'a' || user.type == 'p' || user.type == 't'">csv Import</button>
									<button class="btn w-lg custom-btn" ng-click="openEdit()" 
                          ng-if="user.type == 'a' || user.type == 'p' || user.type == 't'" >Beleg hinzufügen</button>
								</div>
							</div>
							<div class="panel-body finacing-edit request-edit">
								<div id="reports" class="active">
									<div class="row datafilter m-b-30">
										<form>
											<div class='clearfix'>
                        <div class="col-lg-2 p-r-0">
                          <div class="form-group">
                            <label>Suche nach Projekt</label>
                            <ui-select  ng-change="updateGrid()" ng-model="filter.project_id">
                              <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.project_code}}</ui-select-match>
                              <ui-select-choices repeat="item.project_id as item in projects | filter: $select.search | orderBy: 'project_code'">
                                <span ng-bind="item.project_code"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
                        </div>
                        <div class="col-lg-2 p-r-0">
                          <div class="form-group">
                            <div class="form-group">
                              <label>Beleg Typ</label>
                              <ui-select ng-change="updateGrid()" ng-model="filter.report_type_id">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.description}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in reportTypes | filter: $select.search | orderBy: 'description'">
                                  <span ng-bind-html="item.description | highlight: $select.search"></span>
                                </ui-select-choices>
                              </ui-select>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-2 p-r-0">
                          <div class="form-group">
                            <div class="form-group">
                              <label>Jahr</label>
                              <ui-select on-select="updateProject(filter.project_id, filter.year, filter.school_id, filter.performer_id)" ng-change="updateGrid()" ng-model="filter.year">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected}}</ui-select-match>
                                <ui-select-choices repeat="item as item in years | filter: $select.search | orderBy: 'item'">
                                  <span ng-bind="item"></span>
                                </ui-select-choices>
                              </ui-select>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-2 p-r-0">
                          <div class="form-group">
                            <div class="form-group">
                              <label>Status</label>
                              <ui-select ng-change="updateGrid()" ng-model="filter.status_id">
                                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                                <ui-select-choices repeat="item.id as item in statuses | filter: $select.search | orderBy: 'id'">
                                  <span ng-bind="item.name"></span>
                                </ui-select-choices>
                              </ui-select>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-2 p-r-0">
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
                        <div class="col-lg-2 p-r-0 reset-btn-width">
                          <button ng-click="resetFilter()" class="btn pull-right w-lg custom-reset"> <i class="fa fa-rotate-left"></i>
                            <span>Filter zurücksetzen</span>
                          </button>
                        </div>
                      </div>
                      <div class='clearfix'>
                        <div class="col-lg-4 p-r-0">
                          <div class="form-group" ng-hide="user.type  == 't'">
                            <label>Träger</label>
                            <ui-select on-select="updateProject(filter.project_id, filter.year, filter.school_id, filter.performer_id)" ng-change="updateGrid()" ng-model="filter.performer_id">
                              <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.short_name}}</ui-select-match>
                              <ui-select-choices repeat="item.id as item in performers | filter: $select.search">
                                <span ng-bind="item.short_name"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>  
                          <div class="form-group" ng-show="user.type  == 't'">  
                            <label>Schule</label>  
                            <ui-select on-select="updateProject(filter.project_id, filter.year, filter.school_id, filter.performer_id)" ng-change="updateGrid()" ng-model="filter.school_id">
                              <ui-select-match allow-clear="true" placeholder="Schule eingegeben">{{$select.selected.name}}</ui-select-match>
                              <ui-select-choices repeat="item.id as item in schools | filter: $select.search | orderBy: 'code'">
                                <span ng-bind="item.name"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
                        </div>                        
                        <div class="col-lg-4">
                          <label>Zahlungsdatum</label>
                          <div class="input-group">
                            <input uib-datepicker-popup="dd.MM.yyyy" is-open="popup_payment_date.opened" datepicker-options="dateOptions"
                                   ng-change="dateFormat(filter.date);updateGrid();" 
                                   ng-model="filter.date" type="text" id="payment_date" class="form-control datepicker" placeholder="Alle Daten">
                            <span class="input-group-addon" ng-click="popup_payment_date.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
                          </div>
                        </div>
                      </div>
										</form>
									</div>
									<div class="row">
										<div class="col-lg-12">
                      <table id="datatable" ng-cloak ng-table="tableParams"  class="table dataTable table-hover table-bordered table-edit table-reports">
                        <tr ng-repeat="row in $data" ng-class="row.status_code+'-row'">
                          <td header="'headerCheckbox.html'">
                            <label class="cr-styled">
                              <input type="checkbox" ng-model="checkboxes.items[row.id]">
                              <i class="fa"></i>
                            </label>
                          </td>
                          <td data-title="'Jahr'" sortable="'year'">{{row.year}}</td>
                          <td data-title="'Kostenart'" sortable="'cost_type'">{{row.cost_type}}</td>
                          <td data-title="'Belegnr.'" sortable="'code'">{{row.code}}</td>
                          <td data-title="'Zahlungsdatum'" sortable="'payment_date'">{{getDate(row.payment_date) | date: "dd.MM.yyyy" }}</td>
                          <td data-title="'Betrag'" sortable="'report_cost'">{{row.is_chargeable == '1' ? row.chargeable_cost : row.report_cost | number:2 }} €
                            <button ng-if="row.is_chargeable == '1'" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="Anrechenbarer Betrag" data-container="body" 
                                    class="btn id-request information-circled pull-right" type="button" data-original-title="" aria-describedby="popover332715" 
                                    data-trigger="focus" ng-click="openEdit(row, !canEdit(row))">
														  <i class="ion-information-circled"></i>
													  </button>
                          </td>
                          <td data-title="'Zahler/Empfänger'" sortable="'payer'">{{row.payer}}</td>
                          <td data-title="'Grund der Zahlung'" sortable="'base'">{{row.base}}</td>
                          <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                              <a ng-if="canEdit(row)" ng-click="openEdit(row, !canEdit(row))" class="btn center-block edit-btn" title="Bearbeiten">
                                <i class="ion-edit"></i>
                              </a>
                              <a ng-if="!canEdit(row)" ng-click="openEdit(row, !canEdit(row))" class="btn center-block edit-btn" title="Ansicht">
                                <i class="ion-eye"></i>
                              </a>
                          </td>
                        </tr>
                        <tr ng-if="!$data.length"><td class="no-result" colspan="9" >Keine Ergebnisse</td></tr>
                      </table>
                      <div class="btn-row m-t-15 clearfix">
                        <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="changeStatus('accept')" ng-if="user.type == 'a' || user.type == 'p'">Sachlich richtig</button>
                        <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="changeStatus('decline')" ng-if="user.type == 'a' || user.type == 'p'">Anmerkung</button>
                        <button class="btn m-b-5 pull-right" ng-disabled="!existsSelected()" ng-click="changeStatus('senden')" ng-if="user.type == 't'">Belege senden</button>
                      </div>
										</div>
									</div>
                  <div class="clearfix">
                    <div class="notice" ng-repeat="status in statuses ">
                      <span class="color-notice" ng-class="status.code+'-row'"></span>
                      {{status.name}}
                    </div>
                    <div class="notice m-l-100">
                      <i class="ion-information-circled information-font-size"></i>
                      Anrechenbarer Betrag
                    </div>
                  </div>
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

	<script type="text/ng-template" id="editTemplate.html">
    <?php include(Yii::app()->getBasePath().'/views/site/partials/finance-report-editor.php'); ?>
  </script>
  
  <script type="text/ng-template" id="declineReport.html">
    <div class="panel panel-color panel-primary">
      <div class="panel-heading clearfix"> 
        <h3 class="m-0 pull-left">Anmerkung aktualizieren</h3>
        <button type="button" class="close" ng-click="cancel()" aria-hidden="true"><i class="ion-close-round "></i></button>
      </div> 
      <div class="panel-body text-center">
        <ng-form name="declineReport">
          <h3 class="m-b-30">Prüfnotiz hinzufügen für Belege {{rightCodes}}</h3>
          <div class="col-lg-12 text-left">
            <div class="form-group">
              <div class="input-group">
                <textarea ng-model="report.comment" name="comment" class="form-control custom-height-textarea2 finance-report-textarea-decline"
                  placeholder="Tragen Sie den Text hier ein"></textarea>
              </div>
            </div>
          </div>
        </ng-form>
      </div>
      <div class="row p-t-10 text-center">
        <div class="form-group group-btn m-t-20">
          <div class="col-lg-12">
            <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
            <button class="btn w-lg custom-btn" ng-click="submit()" ng-disabled="!report.comment">Speichern</button>
          </div>
        </div>
      </div>
    </div>
  </script>