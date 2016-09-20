<div class="panel panel-color panel-primary">
  <div class="panel-heading m-b-30 clearfix"> 
    <h3 class="m-0 pull-left" ng-if="!isInsert">Beleg bearbeiten #{{financeReportId}}</h3>
    <h3 class="m-0 pull-left" ng-if="isInsert">Beleg hinzufügen</h3>
    <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
  </div>
  <div class="row">
    <div ng-if="reportComment || statusMessage" class="alert" ng-class="{'alert-danger': statusMessage == 'rejected', 'alert-success': statusMessage == 'accepted', 'alert-warning': statusMessage == 'in_progress'}">
      <div ng-switch="statusMessage">
        <strong ng-switch-when="rejected">Anmerkung</strong>
        <strong ng-switch-when="accepted">Sachlich richtig</strong>
        <strong ng-switch-when="in_progress">Zur Prüfung übermittelt</strong>
      </div>
      <div ng-if="reportComment && (statusMessage == 'rejected' || statusMessage == 'in_progress')" ng-bind="reportComment"></div>
    </div>
    <ng-form name="formFinanceReport" class="form-horizontal" disable-all="{{statusMessage == 'accepted' || reportStatus == 'wait' || (user.type != 't' && user.type != 'a' && user.type != 'p')}}">
      <div class="col-lg-6">
         <div class="form-group">
          <label class="col-lg-5 control-label">Jahr</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.year.text"  title="_hint.year.title" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('year')}">
                <ui-select required ng-model="year" name="year" on-select="getProjects(year, 'change');" 
                           ng-disabled="statusMessage == 'accepted' || reportStatus == 'wait' || (user.type != 't' && user.type != 'a' && user.type != 'p')">
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">{{$select.selected.year}}</ui-select-match>
                <ui-select-choices repeat="item.year as item in years | filter: $select.search | orderBy: 'year'">
                  <span ng-bind="item.year"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('year')}" class="hide">
                <label class="error">Jahr erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-5 control-label">Kennziffer</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.project_code.text"  title="_hint.project_code.title" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('project_code')}">
              <ui-select required ng-model="financeReport.request_id" name="project_code" required on-select="getProjectCode($item.code);" 
                         ng-disabled="statusMessage == 'accepted' || reportStatus == 'wait' || (user.type != 't' && user.type != 'a' && user.type != 'p')">
                <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                  {{$select.selected.code}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in requests | filter: $select.search | orderBy: 'code'">
                  <span ng-bind-html="item.code | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('project_code')}" class="hide">
                <label class="error">Projekte erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-5 control-label">Beleg-Typ</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.report_type.text"  title="_hint.report_type.title" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('report_type')}">
              <ui-select required ng-model="financeReport.report_type_id" name="report_type" on-select="paymentMethodSelect(financeReport.report_type_id);" 
                         ng-disabled="statusMessage == 'accepted' || reportStatus == 'wait' || (user.type != 't' && user.type != 'a' && user.type != 'p')">
                <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                  {{$select.selected.description}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in reportTypes | filter: $select.search | orderBy: 'description'">
                  <span ng-bind-html="item.description | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('report_type')}" class="hide">
                <label class="error">Beleg-Typ erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-5 control-label">Kostenart</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.project_code.text"  title="_hint.cost_type.title" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('cost_type')}">
              <ui-select required ng-model="financeReport.cost_type_id" name="cost_type"
                         ng-disabled="statusMessage == 'accepted' || reportStatus == 'wait' || (user.type != 't' && user.type != 'a' && user.type != 'p')">
                <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                  {{$select.selected.description}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in costTypes | filter: $select.search | orderBy: 'description'">
                  <span ng-bind-html="item.description | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('cost_type')}" class="hide">
                <label class="error">Kostenart erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group" ng-show="financeReport.request_id">
          <label class="col-lg-5 control-label">Belegnummer</label>
          <div class="col-lg-7">
              <div class="row">
            <div class="col-lg-4 m-b-10">
              <label class="control-label text-nowrap">{{project_code + ' /'}}</label>
            </div>
            <div class="col-lg-8 span-fix" ng-class="{'wrap-line error': fieldError('code') || error}">
              <input ng-change="checkReportCode(project_code + '/' + financeReport.code)" required class="form-control" type="text" ng-model="financeReport.code" name="code">
              <span ng-class="{hide: !fieldError('code')}" class="hide block">
                 <label class="error" ng-if="fieldError('code')">Belegnummer erforderlich</label>
                 <span class="glyphicon glyphicon-remove form-control-feedback"></span>
               </span>
               <span ng-class="{hide: !error}" class="hide block">
                 <label class="error" ng-if="error">Diese Belegnummer existiert bereits</label>
                 <span class="glyphicon glyphicon-remove form-control-feedback"></span>
               </span>
            </div>
              </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-5 control-label">Belegdatum</label>
          <div class="col-lg-7">
              <div spi-hint text="_hint.receipt_date.text"  title="_hint.receipt_date.title" class="has-hint"></div>
              <div class="input-group" ng-class="{'wrap-line error': fieldError('receipt_date')}">
                <input uib-datepicker-popup="dd.MM.yyyy" is-open="popup_receipt_date.opened" datepicker-options="dateOptions"
                       ng-model="receiptDate" type="text" id="receipt_date"  
                       class="form-control datepicker" placeholder="Alle Daten" required name="receipt_date">
                <span class="input-group-addon" ng-click="popup_receipt_date.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
              <span ng-class="{hide: !fieldError('receipt_date')}" class="hide">
                <br>
                <label class="error">Belegdatum erforderlich</label>
              </span>
          </div>
        </div>
       <div class="form-group" >
          <label class="col-lg-5 control-label">Zahlungsdatum</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.payment_date.text"  title="_hint.payment_date.title" class="has-hint"></div>
            <div class="input-group"  ng-class="{'wrap-line error': fieldError('payment_date')}">
              <input  uib-datepicker-popup="dd.MM.yyyy" is-open="popup_payment_date.opened" datepicker-options="dateOptions"
                      ng-model="paymentDate" ng-change="setValue(paymentDate)" type="text" id="payment_date"
                      class="form-control datepicker" placeholder="Alle Daten" required name="payment_date">
              <span class="input-group-addon" ng-click="popup_payment_date.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
            <span ng-class="{hide: !fieldError('payment_date')}" class="hide">
              <br>
              <label class="error">Zahlungsdatum erforderlich</label>
            </span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-5 control-label">Zahlungsweise</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.project_code.text"  title="_hint.cost_type.title" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('payment_method')}">
              <ui-select required ng-model="financeReport.payment_method_id" name="payment_method" 
                         ng-disabled="!financeReport.report_type_id || statusMessage == 'accepted' || reportStatus == 'wait' || (user.type != 't' && user.type != 'a' && user.type != 'p')">
                <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                  {{$select.selected.description}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in paymentMethodTypes | filter: $select.search | orderBy: 'description'">
                  <span ng-bind-html="item.description | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('payment_method')}" class="hide">
                <label class="error">Zahlungsweise erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="form-group">
          <label class="col-lg-5 control-label">Betrag</label>
          <div class="col-lg-6" ng-class="{'wrap-line error': fieldError('report_cost') || formFinanceReport.report_cost.$error.pattern}">
            <input ng-pattern="/\d+[\,\.]?\d*/" class="form-control finance-report-input"
            type="text" ng-model="financeReport.report_cost" name="report_cost" required>
            <span ng-class="{hide: !fieldError('report_cost')}" class="hide">
              <label class="error" ng-if="fieldError('report_cost') && !formFinanceReport.report_cost.$error.pattern">Betrag erforderlich</label>
            </span>
            <span ng-class="{hide: !formFinanceReport.report_cost.$error.pattern}" class="hide">
              <label class="error" ng-if="formFinanceReport.report_cost.$error.pattern">Nur Ziffern erlauben</label>
            </span>
          </div>
          <div class="col-lg-1 m-t-5 p-0">
            <span class="symbol">€</span>
          </div>
          
        </div>
        <div class="form-group">
          <label class="col-lg-5 control-label">Empfänger</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.first_name.text"  title="_hint.first_name.title"  class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('payer')}">
              <input required class="form-control" type="text" ng-model="financeReport.payer" name="payer">
              <span ng-class="{hide: !fieldError('payer')}" class="hide">
                <label class="error">Empfänger erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>          
        </div>
        <div class="form-group">
          <label class="col-lg-5 control-label">Grund der Zahlung</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.base.text"  title="_hint.base.title" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('base')}">
              <textarea  name="base" class="form-control textarea-min-height" ng-model="financeReport.base" required></textarea>
              <span ng-class="{hide: !fieldError('base')}" class="hide">
                <label class="error">Grund der Zahlung erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-5 control-label">Bemerkung</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.reference.text"  title="_hint.reference.title" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('reference')}">
              <textarea  name="reference" class="form-control textarea-min-height" ng-model="financeReport.reference"></textarea>
            </div>
          </div>
        </div>
        <div class="form-group m-t-20">
          <label class="col-lg-5 control-label p-r-0">Anrechenbarer Betrag</label>
          <div class="col-lg-6" ng-class="{'wrap-line error': fieldError('chargeable_cost') || formFinanceReport.chargeable_cost.$error.pattern}">
              <input ng-disabled="user.type == 't'" ng-pattern="/\d+[\,\.]?\d*/" class="form-control finance-report-input"
                     type="text" ng-model="financeReport.chargeable_cost" name="chargeable_cost">
          </div>
          <div class="col-lg-1 p-0  m-t-5 ">
            <span class="symbol">€</span>
          </div>
          <div class="m-t-5 pull-right">
            <span ng-class="{hide: !formFinanceReport.chargeable_cost.$error.pattern}" class="hide">
              <label ng-show="formFinanceReport.chargeable_cost.$error.pattern" class="error">Nur Ziffern erlauben</label>            
            </span>
          </div>
        </div> 
        <div class="form-group">
          <label class="col-lg-5 control-label">Begründung</label>
          <div class="col-lg-7">
            <div spi-hint text="_hint.reasoning.text"  title="_hint.reasoning.title" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('reasoning')}">
              <textarea ng-disabled="user.type == 't'" name="reasoning" class="form-control textarea-min-height" ng-model="financeReport.reasoning" 
                        ng-required="checkChargeableCost(financeReport.chargeable_cost,financeReport.report_cost)"></textarea>
                <span ng-class="{hide: !fieldError('reasoning')}" class="hide">
                  <label class="error">Begründung erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr />
    <div class="row m-t-30">
      <div class="col-lg-9" ng-if="user.type != 't' && statusMessage == 'in_progress'" >
        <h4 class="m-t-0">Prüfnotiz</h4>
        <textarea ng-model="financeReport.comment" class="form-control custom-height-textarea2 finance-report-textarea" placeholder="Tragen Sie den Text hier ein"></textarea>
      </div>
      <div class="col-lg-3 m-t-30 pull-right">
        <div class="group-btn" >
          <button class="btn w-lg btn-lg custom-btn pull-right" ng-if="user.type == 't' && (statusMessage == 'rejected' || reportStatus == 'open')" title="Beleg zur Prüfung übermitteln" ng-click="changeStatus('check')">SENDEN</button>
          <button class="btn w-lg btn-lg btn-success pull-right" ng-click="changeStatus('accept')" ng-if="user.type != 't' && statusMessage == 'in_progress'">AKZEPTIEREN</button>
          <button class="btn w-lg btn-lg btn-danger m-t-10 pull-right" ng-disabled="!financeReport.comment" ng-click="changeStatus('decline')" ng-if="user.type != 't' && statusMessage == 'in_progress'"> ANMERKUNG</button>
        </div>
      </div>
    </div>
    <div class="form-group group-btn row m-t-30">
      <div class="col-lg-5 text-left" >
        <a class="btn btn-icon btn-danger btn-lg sweet-4" 
           ng-if="(user.type == 'a' || user.type == 'p') || (user.type == 't' && reportStatus != 'wait' && statusMessage != 'accepted')"
           id="sa-warning"><i class="fa fa-trash-o"></i></a>
      </div>
      <div class="col-lg-7 text-right">
        <button class="btn w-lg cancel-btn btn-lg" ng-click="cancel()">Abbrechen</button>
        <button class="btn w-lg custom-btn btn-lg" ng-click="submitFormFinanceReport()" 
                ng-if="reportStatus != 'acceptable' && reportStatus != 'wait' || (user.type != 't' && user.type != 'a' && user.type != 'p')">Speichern</button>
      </div>
    </div>
  </ng-form>
</div>