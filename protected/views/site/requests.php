<?php
$this->
        pageTitle = 'Anträge | ' . Yii::app()->name;
$this->breadcrumbs = array('Anträge');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/requests.js"></script>

<div ng-controller="RequestController" class="wraper container-fluid"  ng-cloak>
  <div class="row">
    <div class="container center-block">
      <div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
      <div class="panel panel-default">        
        <div class="panel-heading clearfix">
          <h1 class="panel-title col-lg-6">Anträge</h1>
          <div class="pull-right heading-box-print">
            <a href="javascript:window.print()" title="Drucken">
              Drucken <i class="ion-printer"></i>
            </a>
            <button class="custom-btn btn w-xs" export-to-csv ng-click="">csv Export</button>
            <button <?php $this->demo();?> ng-if="canByType(['a'])" ng-click="addRequest()" class="btn w-lg custom-btn" data-modal="">Antrag hinzufügen</button>
          </div>
        </div>
        <div class="panel-body request-edit">
          <div class="row datafilter">
            <form>
              <div class="col-lg-2">
                <div class="form-group" ng-hide="user.type  == 't'">
                  <label>Träger</label>
                  <ui-select ng-change="updateGrid()" ng-model="filter.performer_id">
                    <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.short_name}}</ui-select-match>
                    <ui-select-choices repeat="item.id as item in performers | filter: $select.search">
                      <span ng-bind="item.short_name"></span>
                    </ui-select-choices>
                  </ui-select>
                </div>  
                <div class="form-group" ng-show="user.type  == 't'">  
                  <label>Schule</label>  
                  <ui-select ng-change="updateGrid()" ng-model="filter.school_id">
                    <ui-select-match allow-clear="true" placeholder="Schule eingegeben">{{$select.selected.name}}</ui-select-match>
                    <ui-select-choices repeat="item.id as item in schools | filter: $select.search | orderBy: 'code'">
                      <span ng-bind="item.name"></span>
                    </ui-select-choices>
                  </ui-select>
                </div>
              </div>
              <div class="col-lg-2">
                <div class="form-group">
                  <div class="form-group">
                    <label>Kennziffer</label>
                    <input ng-change="updateGrid()" type="search" ng-model="filter.code" class="form-control popup-input" placeholder="Kennziffer eingegeben" ng-hide="user.type  == 't'">
                    <ui-select ng-change="updateGrid()" ng-model="filter.code">
                      <ui-select-match allow-clear="true" placeholder="Kennziffer eingegeben">{{$select.selected.code}}</ui-select-match>
                      <ui-select-choices repeat="item.code as item in requests | filter: $select.search | orderBy: 'code'">
                        <span ng-bind="item.code"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 custom-lg-1">
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
              <div class="col-lg-1 custom-lg-1">
                <div class="form-group">
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
              </div>
              <div class="col-lg-1">
                <div class="form-group">
                  <div class="form-group">
                    <label>Jahr</label>
                    <ui-select ng-change="updateGrid()" ng-model="filter.year">
                      <ui-select-match>{{$select.selected}}</ui-select-match>
                      <ui-select-choices repeat="item as item in years | filter: $select.search | orderBy: item">
                        <span ng-bind="item"></span>
                      </ui-select-choices>                      
                    </ui-select>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 custom-lg-1">
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
              <div class="col-lg-2 reset-btn-width">
                <button ng-click="resetFilter()" class="btn pull-right w-lg custom-reset"> <i class="fa fa-rotate-left"></i>
                  <span>Filter zurücksetzen</span>
                </button>
              </div>
            </form>
          </div>            
          <div class="row m-t-10 m-b-10 no-print">
            <div class="col-lg-12">
              <span>Prüfstatus filtern</span>
            </div>                  
          </div>
          <div class="custom-checkbox row m-b-10 no-print">              
            <div class="col-lg-8">
              <div class="col-lg-2" ng-repeat="item in part_statuses">
                <span title="Finanzplan" ng-if="isFinansist || user.type == 's'">
                    <input  type="checkbox" name="name_{{item}}+ 'finance'" ng-model="checks[item]['finance']" 
                           ng-change="deleteStatus(item + '_finance', checks[item]['finance']);updateGrid();" id="{{item}}_finance">
                    <label  class="cell-finplan {{item}} status-icon" for='{{item}}_finance'><i class="fa fa-check-circle bg-color"></i></label>
                </span>
                <span title="Konzept">
                    <input type="checkbox" name="name_{{item}}+ '_concept'" ng-model="checks[item]['concept']" 
                           ng-change="deleteStatus(item + '_concept', checks[item]['concept']);updateGrid();" id="{{item}}_concept">
                    <label class="cell-concept {{item}} status-icon" for='{{item}}_concept'><i class="fa fa-check-circle bg-color"></i></label>
                </span>
                <span title="Entwicklungsziele">
                  <input type="checkbox" name="name_{{item}}+ '_goal'" ng-model="checks[item]['goal']" 
                           ng-change="deleteStatus(item + '_goal', checks[item]['goal']);updateGrid();" id="{{item}}_goal">
                  <label class="cell-school {{item}} status-icon" for='{{item}}_goal'><i class="fa fa-check-circle "></i></label>
                </span>
              </div>
            </div>
            <div class="col-lg-2 p-r-0">
                <button class="btn pull-right w-lg custom-reset" ng-click="allSelect(true)">
                  <i class="fa fa-check-circle"></i></i>
                  <span>Alles auswählen</span>
                </button>
              </div>
               <div class="col-lg-2 p-l-0">
                <button class="btn pull-right w-lg custom-reset" ng-click="allSelect(false)"> <i class="fa ion-close-circled "></i>
                  <span>Alles abwählen</span>
                </button>
              </div>
          </div>
          <div class="row">
            <div class="col-lg-12">

              <table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit table-requests">
                <tr ng-repeat="row in $data" ng-class="row.status_code == 'in_progress' && (user.type == 's' || user.type == 'd' || user.type == 'g') ?
                                                       'wait-row' : row.status_code + '-row'">
                  <td header="'headerCheckbox.html'">
                    <label class="cr-styled">
                      <input type="checkbox" ng-model="checkboxes.items[row.id]">
                      <i class="fa"></i>
                    </label>
                  </td>
                  <td data-title="'Kennz.'" sortable="'code'">{{row.code}}</td>
                  <td data-title="user.type != 't' ? 'Träger / Profil' : 'Schule(n)'" sortable="user.type != 't' ? 'performer_name' : 'school_name'">
                    <!--<span class="performer-icon" ng-class="{'unchecked':row.performer_is_checked != '1'}">{{row.performer_name}}</span>-->
                   <div class="holder-school">
                    <a ng-if="user.type != 't'" href="/performers#id={{row.performer_id}}" target="_blank">{{row.performer_name}}</a>
                    <i ng-if="user.type != 't' && +row.performer_is_checked" class="success fa fa-check-circle" aria-hidden="true" title="Profil überprüft"></i>
                    <a ng-if="user.type == 't'" href="/schools#id={{school.id}}" ng-repeat="school in row.ordered_schools" class="school-td" target="_blank">{{school.name}}</a>
                   </div>
                  </td>
                  <td data-title="'Programm'" sortable="'programm'">{{row.programm}}</td>
                  <td data-title="'Jahr'" sortable="'year'">{{row.year}}</td>
                  <td data-title="'Status'" sortable="'status_name'">
                      {{(row.status_code == 'in_progress' && user.type == 't')                       ? 'Antrag bearbeiten'              : 
                        (row.status_code == 'acceptable'  && (user.type == 'p' || user.type == 'a')) ? 'Antrag förderfähig'              :
                        (row.status_code == 'acceptable'  && user.type == 't')                       ? 'Förderfähig – Antrag drucken' :
                        (row.status_code == 'accept'      && user.type == 't')                       ? 'Genehmigt – Fördervertrag drucken' :
                        (row.status_code == 'wait'        && (user.type == 'a' || user.type == 'p')) ? 'Zur Korrektur übermittelt' :
                         row.status_name}}
                  </td>
                  <td data-title="'Prüfstatus'">
                    <div class="col-lg-4 p-0">
                      <a ng-if="isFinansist || (row.is_bonus_project == '1' && user.type == 's')" class="request-button edit-btn" href="/request/{{row.id}}#finance-plan" title="Finanzplan">
                        <span class="cell-finplan status-icon" ng-class="row.status_finance"></span>
                      </a>
                    </div>
                    <div class="col-lg-4 p-0">
                      <a class="request-button edit-btn" href="/request/{{row.id}}#school-concepts" title="Konzept">
                        <span class="cell-concept status-icon" ng-class="row.status_concept"></span>
                      </a>
                    </div>
                    <div  class="col-lg-4 p-0">
                      <a class="request-button edit-btn" href="/request/{{row.id}}#schools-goals" title="Entwicklungsziele">
                        <span class="cell-school status-icon" ng-class="row.status_goal"></span>
                      </a>
                    </div>
                  </td>
                  <td data-title="'Abgabe'" sortable="'end_fill'">{{getDate(row.end_fill) | date : 'dd.MM.yyyy'}}</td>
                  <td data-title="'Letzte Änd.'" sortable="'last_change'">{{getDate(row.last_change) | date : 'dd.MM.yyyy'}}</td>
                  <td data-title="'Ansicht / Bearbeiten'" ng-click="setFilter()">
                    <a ng-click="printDocuments(row)"  ng-class=" {disabled: !userCan( 'btnPrintDocument', row.status_code, row.status_goal)} " class="btn document" href="" title="Drucken"><i class="ion-printer"></i></a>
                    <a ng-if="canEdit(row)" class="btn edit-btn" href="/request/{{row.id}}"  title="Bearbeiten">
                      <i class="ion-edit"></i>
                    </a>
                    <a ng-if="!canEdit(row)" class="btn edit-btn"  href="/request/{{row.id}}" title="Aussicht">
                      <i class="ion-eye"></i>
                    </a>
                  </td>
                </tr>
                <tr ng-if="!$data.length"><td class="no-result" colspan="10">Keine Ergebnisse</td></tr>
              </table>

              <div class="btn-row m-t-15 clearfix" ng-if="canEdit() && canByType(['a','p'])">
                <div class="col-lg-7">
                  <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="chooseDocuments()">Druck-Template wählen</button>
                  <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="setBulkDuration()">Laufzeit festlegen</button>
                  <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="setBulkStatus(4)">Förderfähig</button>
                  <button class="btn m-b-5" ng-disabled="!existsSelected()" ng-click="setBulkStatus(5)">Genehmigung</button>
                </div>
                <div class="col-lg-3">
                  <button class="btn m-b-5" ng-click="export()">Daten exportieren</button>
                </div> 
                <div class="col-lg-2">
                  <button class="btn m-b-5"  ng-disabled="!existsSelected()" ng-click="copyRequest()" disabled>Folgeantrag hinzufügen</button>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix">
            <div class="notice {{status.code == 'decline' ? 'decline-div' : ''}}" ng-repeat="status in statuses | filter:{virtual: 0}">
              <span class="color-notice" ng-class="status.code+'-row'"></span>
              {{status.name}}
            </div>
            <div class="">
              <span class="table-requests"><i class="success fa fa-check-circle" aria-hidden="true"></i>Profil überprüft</span>               
            </div>
          </div>
          <div class="clearfix square-legend">
            <div class="notice">
              <div class="legends">
                <span class="cell-finplan unfinished status-icon" ng-if="isFinansist || user.type == 's'"></span>
                <span class="cell-concept unfinished status-icon"></span>
                <span class="cell-school unfinished status-icon"></span>
              </div>
              Ungeprüft
            </div>
            <div class="notice">
              <div class="legends">
                <span class="cell-finplan in_progress status-icon" ng-if="isFinansist || user.type == 's'"></span>
                <span class="cell-concept in_progress status-icon"></span>
                <span class="cell-school in_progress status-icon"></span>
              </div>
              Zur Prüfung übermittelt
            </div>
            <div class="notice">
              <div class="legends">
                <span class="cell-finplan accepted status-icon" ng-if="isFinansist || user.type == 's'"></span>
                <span class="cell-concept accepted status-icon"></span>
                <span class="cell-school accepted status-icon"></span>
              </div>
              Geprüft{{user.type == 't' ? ' – Zielvereinbarung drucken' : ''}} 
            </div>
            <div class="notice">
              <div class="legends">
                <span class="cell-finplan rejected status-icon" ng-if="isFinansist || user.type == 's'"></span>
                <span class="cell-concept rejected status-icon"></span>
                <span class="cell-school rejected status-icon"></span>
              </div>
              Anmerkung
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Row -->
</div>

<script type="text/ng-template" id="headerCheckbox.html">
  <label class="cr-styled">
    <input type="checkbox" ng-model="checkboxes.checked" ng-click="headerChecked(checkboxes.checked)">
    <i class="fa"></i>
  </label>
</script>

<script type="text/ng-template" id="printDocuments.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Dokumente drucken - {{::code}}</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body">
      <h3 class="m-b-30 text-center">Dokumente zum Druck wählen</h3>
      <div ng-repeat="template in templates" class="doc-print" ng-hide="!userCan || (user.type == 't' && user.is_finansist != '1' && template.type_name != 'Zielvereinbarung') ">
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

<script type="text/ng-template" id="chooseDocuments.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Druck-Template wählen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body text-center">
      <h3 class="m-b-30">Vertragsvorlage für {{::countElements}} Elemente auswählen</h3>
      <div class="col-lg-12 text-left">
        <div class="form-group">
          <label>Zielvereinbarung</label>
          <ui-select ng-disabled="!$select.items.length" ng-change="updateGrid()" ng-model="form.doc_target_agreement_id">
            <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Nicht ausgewählt)'}}">{{$select.selected.name}}</ui-select-match>
            <ui-select-choices repeat="item.id as item in goal_agreements | filter: $select.search | orderBy: 'name'">
              <span ng-bind="item.name"></span>
            </ui-select-choices>
          </ui-select>
        </div>
        <div class="form-group">
          <label>Antrag</label>
          <ui-select ng-disabled="!$select.items.length" ng-change="updateGrid()" ng-model="form.doc_request_id">
            <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Nicht ausgewählt)'}}">{{$select.selected.name}}</ui-select-match>
            <ui-select-choices repeat="item.id as item in request_agreements | filter: $select.search | orderBy: 'name'">
              <span ng-bind="item.name"></span>
            </ui-select-choices>
          </ui-select>
        </div>
        <div class="form-group">
          <label>Fördervertrag</label>
          <ui-select ng-disabled="!$select.items.length" ng-change="updateGrid()" ng-model="form.doc_financing_agreement_id">
            <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Nicht ausgewählt)'}}">{{$select.selected.name}}</ui-select-match>
            <ui-select-choices repeat="item.id as item in funding_agreements | filter: $select.search | orderBy: 'name'">
              <span ng-bind="item.name"></span>
            </ui-select-choices>
          </ui-select>
        </div>
      </div>
    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" ng-click="ok()">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="copyRequest.html">
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

<script type="text/ng-template" id="setDuration.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Laufzeit festlegen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body text-center">
      <h3 class="m-b-30">Geben Sie die Zeitdauer für die {{::countElements}} Elemente ein</h3>
      <div class="form-group">
        <ng-form name="form">
          <div class="holder-datepicker text-right">
            <div class="col-lg-6 set-duration">
              <div class="col-lg-6 p-0">
                <label>Beginn</label>
              </div>
              <div class="col-lg-6 p-0 m-b-30">
                <div class="input-group">
                  <input type="text" ng-click="dp_start_date_is_open = !dp_start_date_is_open" ng-model="form.start_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_start_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" placeholder="dd.mm.yyyy">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
              <div class="col-lg-6 p-0">
                <label>Ende</label>
              </div>
              <div class="col-lg-6 p-0 ">
                <div class="input-group">
                  <input type="text" ng-click="dp_due_date_is_open = !dp_due_date_is_open" ng-model="form.due_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_due_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" placeholder="dd.mm.yyyy">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
              </div>
            </div>
            <div class="col-lg-6 m-t-30">
                <div class="col-lg-6 p-0">
                  <label>Abgabedatum</label>
                </div>
                <div class="col-lg-6 p-0">
                  <div class="input-group">
                    <input type="text" ng-click="dp_end_fill_is_open = !dp_end_fill_is_open" ng-model="form.end_fill" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_end_fill_is_open" datepicker-options="dateOptions" required class="form-control datepicker" placeholder="dd.mm.yyyy">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  </div>
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
          <button class="btn w-lg custom-btn" ng-click="ok()" ng-disabled="form.due_date < form.start_date">Speichern</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="createRequest.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Antrag hinzufügen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="panel-body text-center">
      <div class="row text-left">
        <ng-form  name="createRequest">
        <div class="form-group col-lg-6">
          <label>Jahr</label>
          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('year')}">
            <div class="input-group">
              <input required type="text" ng-change="search($select.search, 'year')" ng-click="dp_year_date_is_open = !dp_year_date_is_open" ng-model="year" uib-datepicker-popup="yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_year_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" name="year" >
              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar" ng-click="dp_year_date_is_open = !dp_year_date_is_open"></i></span>
            </div>
            <span ng-class="{hide: !fieldError('year')}" class="hide">
              <label ng-show="createRequest.year.$error.required" class="error">Jahr erforderlich</label>
              <span class="glyphicon glyphicon-remove form-control-feedback" style="right: 38px;"></span>
            </span>
          </div>
        </div>
        <div class="form-group col-lg-6">
          <label>Projekt</label>
          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('selected_project')}">
            <ui-select required class="type-document" ng-model="request.project_id" name="selected_project">
              <ui-select-match placeholder="Kennziffer eingegeben">{{$select.selected.code}}</ui-select-match>
              <ui-select-choices repeat="item.id as item in projects | filter: $select.search" refresh-delay="0" refresh="search($select.search)" >
                <span ng-bind-html="item.code | highlight: $select.search"></span>
              </ui-select-choices>
            </ui-select>
            <span ng-class="{hide: !fieldError('selected_project')}" class="hide">
              <label ng-show="createRequest.selected_project.$error.required" class="error">Projekt erforderlich</label>
              <span class="glyphicon glyphicon-remove form-control-feedback"></span>
            </span>
          </div>
        </div>
        </ng-form >
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

<script type="text/ng-template" id="exportData.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix"> 
      <h3 class="m-0 pull-left">Daten exportieren</h3>
      <button type="button" class="close" ng-click="cancel()" aria-hidden="true"><i class="ion-close-round "></i></button>
    </div> 
    <div class="panel-body">
      <h3 class="m-b-30 text-center">Daten aus Anträgen exportieren:</h3>
      <div ng-repeat="template in templates" class="doc-print">
        <div class="holder-doc-print">
          <span class="name-doc">{{template.type_name}}:</span>
          <p>{{template.name}}</p>
        </div>
        <div class="btn-row">
          <button ng-disabled="!button_single(template)" class="btn w-xs export-button" data-target="#modal-1" data-toggle="modal" export-to-csv ng-click="checkCheckbox(template)">
            <span>csv Export</span>
            <i class="ion-printer"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="row p-t-10 text-center">
      <div class="form-group group-btn m-t-20">
        <div class="col-lg-12">
          <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
        </div>
      </div>
    </div>
  </div>
</script>

<script type="text/ng-template" id="showTemplate.html">
  <?php include(Yii::app()->getBasePath().'/views/site/partials/document-template.php'); ?>
</script>