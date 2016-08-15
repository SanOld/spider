<?php
$this->pageTitle = 'Mittelabrufe | ' . Yii::app()->name;
$this->breadcrumbs = array('Finanzen','Mittelabrufe');
?>	
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/financial-requests.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

			<div ng-controller="FinancialRequestController" ng-cloak class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Mittelabrufe</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()" title="Drucken">
                    Drucken <i class="ion-printer"></i>
                  </a>
									<button ng-if="user.type == 'a' || user.type == 'p' || user.type == 't'" class="btn w-lg custom-btn" ng-click="openEdit()">Mittelabruf hinzufügen</button>
								</div>
							</div>
							<div class="panel-body request-edit">
								<div class="row datafilter">
									<form>
                    <div class='clearfix'>
										<div class="col-lg-2 p-r-0">
											<div class="form-group">
												<label>Suche nach Projekt</label>
												<ui-select on-select="updateProject(filter.project_id, filter.year)" ng-change="updateGrid()" ng-model="filter.project_id">
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
													<ui-select ng-change="updateGrid()" ng-model="filter.type_id">
                            <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                            <ui-select-choices repeat="item.id as item in paymentTypes | filter: $select.search | orderBy: 'name'">
                              <span ng-bind-html="item.name | highlight: $select.search"></span>
                            </ui-select-choices>
                          </ui-select>
												</div>
											</div>
										</div>
										<div class="col-lg-2 p-r-0">
											<div class="form-group">
												<div class="form-group">
													<label>Jahr</label>
													<ui-select on-select="updateProject(filter.project_id, filter.year)" ng-change="updateGrid()" ng-model="filter.year">
                            <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.year}}</ui-select-match>
                            <ui-select-choices repeat="item.year as item in years | filter: $select.search | orderBy: 'year'">
                              <span ng-bind="item.year"></span>
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
                            <ui-select-choices repeat="item.id as item in statuses | filter: $select.search | orderBy: 'name'">
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
										<div class="col-lg-4 p-r-0">
											<label>Belegdatum</label>
											<div class="input-group">
                        <input uib-datepicker-popup="dd.MM.yyyy" is-open="popup_receipt_date.opened" datepicker-options="dateOptions"
                               ng-change="dateFormat(filter.date1, 'receipt_date');updateGrid();" 
                               ng-model="filter.date1" type="text" id="receipt_date" class="form-control datepicker" placeholder="Alle Daten">
                        <span class="input-group-addon" ng-click="popup_receipt_date.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
                      </div>
										</div>
										<div class="col-lg-4">
											<label>Zahlungsdatum</label>
											<div class="input-group">
                        <input uib-datepicker-popup="dd.MM.yyyy" is-open="popup_payment_date.opened" datepicker-options="dateOptions"
                               ng-change="dateFormat(filter.date2, 'payment_date');updateGrid();" 
                               ng-model="filter.date2" type="text" id="payment_date" class="form-control datepicker" placeholder="Alle Daten">
                        <span class="input-group-addon" ng-click="popup_payment_date.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
                      </div>
										</div>
                    </div>
									</form>
								</div>
								<div class="overview-finance m-t-20" ng-if="summary">
									<h4>Zusammenfassung der Finanzen für {{summary.project_code}} ({{summary.start_date | date: "dd.MM.yyyy"}} - {{summary.due_date | date: "dd.MM.yyyy"}})</h4>
									<div class="box-finance">
										<span class="sum total">
	                    <strong>Fördersumme</strong>
	                  </span>
									  <span class="sum-size">€ {{summary.total_cost | number:2}}</span>
									</div>
									<div class="box-finance">
										<span class="sum requested">
	                    <strong>Änderungen</strong>
	                  </span>                      
										<span class="sum-size">€ {{summary.changes | number:2}}</span>
									</div>
									<div class="box-finance box-custom-width">
										<span class="sum refund">
	                    <strong>aktuelle Fördersumme</strong>
                    </span>                      
									  <span class="sum-size">€ {{summary.actual | number:2}}</span>
									</div>
									<div class="box-finance">
										<span class="sum income">
	                    <strong>Ausgezahlt</strong>
	                  </span>
										<span class="sum-size">€ {{summary.payed | number:2}}</span>
									</div>
									<div class="box-finance">
										<span class="sum spent">
	                    <strong>Verblieben</strong>
	                  </span>
									 <span class="sum-size">€ {{summary.remained | number:2}}</span>
									</div>
									<div class="box-finance">
										<span class="sum expenditure">
	                    <strong>Finanzbericht</strong>
	                  </span>
										<span class="sum-size">€ {{summary.spending | number:2}}</span>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table id="datatable" ng-cloak ng-table="tableParams"  class="table dataTable table-hover table-bordered table-edit table-requests">
											<tr ng-repeat="row in $data" ng-class="row.status_code+'-row'">
                        <td header="'headerCheckbox.html'">
                          <label class="cr-styled">
                            <input type="checkbox" ng-model="checkboxes.items[row.id]">
                            <i class="fa"></i>
                          </label>
                        </td>
                        <td data-title="'Kennz'" sortable="'project_code'">
                          <a href="/projects#id={{row.project_id}}" target="_blank">{{row.project_code}}</a></td>
                        </td>
                        <td data-title="'Jahr'" sortable="'year'">{{row.year}}</td>
                        <td data-title="'Rate'" sortable="'rate'">{{row.rate}}</td>
                        <td data-title="'Träger'" sortable="'performer_name'">
                          <a href="/performers#id={{row.performer_id}}" target="_blank">{{row.performer_name}}</a></td>
                        <td data-title="'Kreditor'" sortable="'kreditor'">{{row.kreditor}}</td>
                        <td data-title="'Beleg Typ'" sortable="'payment_name'">{{row.payment_name}}</td>
                        <td data-title="'Beleg -Datum'" sortable="'kreditor'">{{getDate(row.receipt_date) | date: "dd.MM.yyyy"}}</td>
                        <td data-title="'Betrag'" sortable="'request_cost'">{{row.request_cost | number:2 }} €</td>
                        <td data-title="'Zahl. -Datum'" sortable="'payment_date'">{{getDate(row.payment_date) | date: "dd.MM.yyyy" }}</td>
                        <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                            <a ng-click="printDocuments(row)" ng-class="{disabled: row.status == 3}" class="btn document" title="Drucken"><i class="ion-printer"></i></a>
                            <a ng-if="canEdit(row)" ng-click="openEdit(row, !canEdit(row))" class="btn edit-btn" title="Bearbeiten">
                              <i class="ion-edit"></i>
                            </a>
                            <a ng-if="!canEdit(row)" ng-click="openEdit(row, !canEdit(row))" class="btn edit-btn" title="Ansicht">
                              <i class="ion-eye"></i>
                            </a>
                        </td>
                      </tr>
                      <tr ng-if="!$data.length"><td class="no-result" colspan="11">Keine Ergebnisse</td></tr>
										</table>
										<div class="btn-row m-t-15 clearfix">
                      <button class="btn m-b-5" ng-if="user.type == 'a' || user.type == 'p'" ng-disabled="!existsSelected()" ng-click="setPaymentDate()">Zahl. Datum hinzufügen</button>
											<button class="btn m-b-5" ng-if="user.type == 'a' || user.type == 'p' || user.type == 't'"ng-disabled="!existsSelected()" ng-click="setDocumentTemplate()" data-toggle="modal">Druck-Template wählen</button>
										</div>
									</div>
								</div>
								<div class="clearfix">
                  <div class="notice" ng-repeat="status in statuses ">
                    <span class="color-notice" ng-class="status.code+'-row'"></span>
                    {{status.name}}
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
  <?php include(Yii::app()->getBasePath().'/views/site/partials/financial-request-editor.php'); ?>
</script>

<script type="text/ng-template" id="setDocumentTemplate.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix"> 
      <h3 class="m-0 pull-left">Druck-Template wählen</h3>
      <button type="button" class="close" ng-click="cancel()" aria-hidden="true"><i class="ion-close-round "></i></button>
    </div> 
    <div class="panel-body text-center">
      <ng-form name="setDocumentTemplate">
        <h3 class="m-b-30">Druck-Template für {{countElements}} Elemente wählen</h3>
        <div class="col-lg-12 text-left">
          <div class="form-group">
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('payment_template')}">
              <ui-select required class="type-document" ng-model="request.document_template_id" name="payment_template">
                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                <ui-select-choices repeat="item.id as item in paymentTemplates | filter: $select.search | orderBy: 'name'">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('payment_template')}" class="hide">
                <label class="error">Druck Template erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
      </ng-form>
    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" ng-click="submit()">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="setPaymentDate.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix"> 
      <h3 class="m-0 pull-left">Zahlungsdatum hinzufügen </h3>
      <button type="button" class="close" ng-click="cancel()" aria-hidden="true"><i class="ion-close-round "></i></button>
    </div> 
    <div class="panel-body text-center">
      <ng-form name="setPaymentDate">
        <h3 class="m-b-30">Zahlungsdatum für {{countElements}} Elemente hinzufügen</h3>
        <div class="col-lg-12 text-left">
          <div class="form-group">
            <div class="input-group" ng-class="{'wrap-line error': fieldError('payment_date')}">
              <input uib-datepicker-popup="dd.MM.yyyy" is-open="popup_payment_date.opened" datepicker-options="dateOptions"
                     type="text" id="payment_date" ng-model="request.payment_date" required
                     class="form-control datepicker" placeholder="Alle Daten" name="payment_date">
              <span class="input-group-addon" ng-click="popup_payment_date.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
            <span ng-class="{hide: !fieldError('payment_date')}" class="hide">
              <br>
              <label class="error">Zahlungsdatum erforderlich</label>
            </span>
          </div>
        </div>
      </ng-form>
    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" ng-click="submit()">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="printDocuments.html">
  <?php include(Yii::app()->getBasePath().'/views/site/partials/document-template.php'); ?>
</script>