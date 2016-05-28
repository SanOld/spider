<?php

$this->pageTitle = 'Anträge | ' . Yii::app()->name;
$this->breadcrumbs = array('Anträge');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/requests.js"></script>

<div ng-controller="RequestController" class="wraper container-fluid" ng-cloak>
	<div class="row">
		<div class="container center-block">
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Anträge</h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()" title="Drucken">Drucken <i class="ion-printer"></i></a>
						<button <?php $this->demo(); ?> ng-click="addRequest()" class="btn w-lg custom-btn" data-modal="">Antrag hinzufügen</button>
					</div>
				</div>
				<div class="panel-body request-edit">
					<div class="row datafilter">
						<form>
							<div class="col-lg-3 col1">
								<div class="form-group">
									<label>Träger</label>
									<ui-select ng-change="updateGrid()" ng-model="filter.performer_id">
										<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
										<ui-select-choices repeat="item.id as item in performers | filter: $select.search">
											<span ng-bind="item.name"></span>
										</ui-select-choices>
									</ui-select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<div class="form-group">
										<label>Fördertopf</label>
										<ui-select ng-change="updateGrid()" ng-model="filter.finance_type">
											<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
											<ui-select-choices ui-disable-choice="true" repeat="item.id as item in financeTypes | filter: $select.search">
												<span ng-bind="item.name"></span>
											</ui-select-choices>
										</ui-select>
									</div>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<div class="form-group">
										<label>Programm</label>
										<ui-select ng-change="updateGrid()" ng-model="filter.program_id">
											<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.programm}}</ui-select-match>
											<ui-select-choices ui-disable-choice="true" repeat="item.id as item in programs | filter: $select.search">
												<span ng-bind="item.programm"></span>
											</ui-select-choices>
										</ui-select>
									</div>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="form-group">
									<div class="form-group">
										<label>Jahr</label>
										<ui-select ng-change="updateGrid()" ng-model="filter.year">
											<ui-select-match>{{$select.selected}}</ui-select-match>
											<ui-select-choices repeat="item as item in years | filter: $select.search">
												<span ng-bind="item"></span>
											</ui-select-choices>
										</ui-select>
									</div>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<div class="form-group">
										<label>Status</label>
										<ui-select ng-change="updateGrid()" ng-model="filter.status_id">
											<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
											<ui-select-choices repeat="item.id as item in statuses | filter: $select.search">
												<span ng-bind="item.name"></span>
											</ui-select-choices>
										</ui-select>
									</div>
								</div>
							</div>
							<div class="col-lg-2 reset-btn-width">
								<button ng-click="resetFilter()" class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
							</div>
						</form>
					</div>
<!--					<div class="overview">-->
<!--						<h2>Statusüberblick</h2>-->
<!--						<div class="box-overview">-->
<!--							<a href="#">-->
<!--								<span>In Bearbeitung</span>-->
<!--								<strong>253</strong>-->
<!--							</a>-->
<!--						</div>-->
<!--						<div class="box-overview">-->
<!--							<a href="#">-->
<!--								<span>Empfangen</span>-->
<!--								<strong>2</strong>-->
<!--							</a>-->
<!--						</div>-->
<!--						<div class="box-overview">-->
<!--							<a href="#">-->
<!--								<span>Zurücksendet</span>-->
<!--								<strong>0</strong>-->
<!--							</a>-->
<!--						</div>-->
<!--						<div class="box-overview">-->
<!--							<a href="#">-->
<!--								<span>Berechtigt</span>-->
<!--								<strong>0</strong>-->
<!--							</a>-->
<!--						</div>-->
<!--						<div class="box-overview">-->
<!--							<a href="#">-->
<!--								<span>Genehmigt</span>-->
<!--								<strong>3</strong>-->
<!--							</a>-->
<!--						</div>-->
<!--						<div class="box-overview">-->
<!--							<a href="#">-->
<!--								<span>Ge­samt­zahl</span>-->
<!--								<strong>258</strong>-->
<!--							</a>-->
<!--						</div>-->
<!--					</div>-->
					<div class="row">
						<div class="col-lg-12">

							<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
								<tr ng-repeat="row in $data" ng-class="{'accept-row': row.status_code == 'a', 'acceptable-row': row.status_code == 'b', 'inprogress-row': row.status_code == 'p', 'decline-row':  row.status_code == 'd'}">
									<td header="'headerCheckbox.html'">
										<label class="cr-styled">
											<input type="checkbox" ng-model="checkboxes.items[row.id]">
											<i class="fa"></i>
										</label>
									</td>
									<td data-title="'Kennziffer'" sortable="'code'">{{row.code}}</td>
									<td data-title="'Träger'" sortable="'performer_name'">{{row.performer_name}}</td>
									<td data-title="'Programm'" sortable="'programm'">{{row.programm}}</td>
									<td data-title="'Jahr'" sortable="'year'">{{row.year}}</td>
									<td data-title="'Status'" sortable="'status_name'">{{row.status_name}}</td>
									<td data-title="'Prüfstatus'">
                    <div class="col-lg-4">
                      <a class="request-button edit-btn" target="_blank" href="/request/{{row.id}}#finance-plan" title="Finanzplan">
                        <span ng-show = "row.status_finance == 'a'" class="cell-finplan"></span>
                        <span ng-show = "row.status_finance == 'r'" class="cell-finplan select"></span>
                        <span ng-show = "row.status_finance == 'd'" class="cell-finplan select-decline"></span>
                      </a>
                    </div>
                    <div class="col-lg-4">
                      <a class="request-button edit-btn" target="_blank" href="/request/{{row.id}}#school-concepts" title="Schulkonzept">
                        <span ng-show = "row.status_concept == 'a'" class="cell-finplan"></span>
                        <span ng-show = "row.status_concept == 'r'" class="cell-finplan select"></span>
                        <span ng-show = "row.status_concept == 'd'" class="cell-finplan select-decline"></span>
                      </a>
                    </div>
                    <div  class="col-lg-4">
                      <a class="request-button edit-btn" target="_blank" href="/request/{{row.id}}#schools-goals" title="Entwicklungsziele">
                        <span ng-show = "row.status_goal == 'a'" class="cell-finplan"></span>
                        <span ng-show = "row.status_goal == 'r'" class="cell-finplan select"></span>
                        <span ng-show = "row.status_goal == 'd'" class="cell-finplan select-decline"></span>
                      </a>
                    </div>
                  </td>
									<td data-title="'Abgabe'" sortable="'due_date'">{{row.due_date_unix | date : 'dd.MM.yyyy'}}</td>
									<td data-title="'Letzte Änd.'" sortable="'last_change'">{{row.last_change_unix | date : 'dd.MM.yyyy'}}</td>
									<td data-title="'Ansicht / Bearbeiten'">
										<a ng-if="row.status_code == 'a' || row.status_code == 'b'" class="btn document" href="" ng-click="openPrint(row)" title="Drucken"><i class="ion-printer"></i></a>
										<a ng-if="canEdit()" class="btn edit-btn" href="/request/{{row.id}}" title="Bearbeiten">
											<i class="ion-edit"></i>
										</a>
									</td>
								</tr>
							</table>

							<div class="btn-row m-t-15 clearfix" ng-if="canEdit()">
								<button class="btn m-b-5" ng-disabled="!existsSelected()" onclick="alert('ToDo')">Druck-Template wählen</button>
								<button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="setBulkDuration()">Laufzeit festlegen</button>
								<button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="setBulkStatus(4)">Förderfähig</button>
								<button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="setBulkStatus(5)">Genehmigung</button>
								<button class="btn m-b-5 pull-right" ng-disabled="!existsSelected()" onclick="alert('ToDo')">Folgeantrag hinzufügen</button>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="notice" ng-repeat="status in statuses">
							<span class="color-notice" ng-class="{'open': status.code == 'o', 'decline-row': status.code == 'd', 'inprogress-row': status.code == 'p', 'acceptable-row': status.code == 'b', 'accept-row': status.code == 'a'}"></span>
							{{status.name}}
						</div>
					</div>
					<div class="clearfix square-legend">
						<div class="notice">
							<div class="legends">
								<span class="cell-finplan select"></span>
								<span class="cell-concept select"></span>
								<span class="cell-school select"></span>
							</div>
							In Bearbeitung
						</div>
						<div class="notice">
							<div class="legends">
								<span class="cell-finplan"></span>
								<span class="cell-concept"></span>
								<span class="cell-school"></span>
							</div>
							Förderfähig
						</div>
						<div class="notice">
							<div class="legends">
								<span class="cell-finplan select-decline"></span>
								<span class="cell-concept select-decline"></span>
								<span class="cell-school select-decline"></span>
							</div>
							Abgelehnt
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- End Row -->
</div>


<script type="text/ng-template" id="headerCheckbox.html">
	<label class="cr-styled">
		<input type="checkbox" ng-model="checkboxes.checked" ng-click="headerChecked(checkboxes.checked)">
		<i class="fa"></i>
	</label>
</script>


<script type="text/ng-template" id="setDuration.html">
    <div class="panel panel-color panel-primary">
      <div class="panel-heading clearfix">
        <h3 class="m-0 pull-left">Laufzeit festlegen</h3>
        <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
      </div>
      <div class="panel-body text-center">
        <h3 class="m-b-30">Geben Sie die Zeitdauer für die {{countElements}} Elemente ein</h3>
        <div class="form-group">
          <ng-form name="form">
          <div class="holder-datepicker text-right">
            <div class="col-lg-3 p-0">
              <label>Anfangsdatum</label>
            </div>
            <div class="col-lg-3 p-0">
              <div class="input-group">
                <input type="text" ng-click="dp_start_date_is_open = !dp_start_date_is_open" ng-model="form.start_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_start_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" placeholder="dd.mm.yyyy">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
            </div>
            <div class="col-lg-3 p-0">
              <label>Fälligkeitstermin</label>
            </div>
            <div class="col-lg-3 p-0">
              <div class="input-group">
                <input type="text" ng-click="dp_due_date_is_open = !dp_due_date_is_open" ng-model="form.due_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_due_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" placeholder="dd.mm.yyyy">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
            </div>
          </div>
          </ng-form>
        </div>
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


<script type="text/ng-template" id="setRequest.html">
    <div class="panel panel-color panel-primary">
      <div class="panel-heading clearfix">
        <h3 class="m-0 pull-left">Window title</h3>
        <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
      </div>
      <div class="panel-body text-center">
        <h3 class="m-b-30">Header</h3>
        <div class="form-group">
          <ng-form name="form">
            <label class="col-lg-2 control-label label-type">Project</label>
            <div class="col-lg-10">
              <div spi-hint text="_hint.request_add" class="has-hint"></div>
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('name')}">
                <ui-select  class="type-document" ng-model="project.id">
                  <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                  <ui-select-choices repeat="item.id as item in  projects | filter: $select.search">
                      <span ng-bind-html="item.code | highlight: $select.search"></span>
                  </ui-select-choices>
                </ui-select>
              </div>
            </div> 
          </ng-form>
        </div>
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

