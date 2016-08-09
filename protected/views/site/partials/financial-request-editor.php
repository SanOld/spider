<div class="panel panel-color panel-primary edit-summary">
    <div class="panel-heading m-b-30 clearfix"> 
      <h3 class="m-0 pull-left" ng-if="!isInsert">Mittelabruf bearbeiten {{financial_request.project_code}} / 16-000092</h3>
      <h3 class="m-0 pull-left" ng-if="isInsert">Mittelabruf hinzufügen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="row">
      <ng-form name="formFinancialRequest" class="form-horizontal">
        <div class="col-lg-6 row-holder-dl">
          <div class="form-group">
            <label class="col-lg-4 control-label">Projekte</label>
            <div class="col-lg-8">
              <div spi-hint text="_hint.school_type_id" class="has-hint"></div>
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('project_code')}">
                <ui-select on-select="onSelectProject($item, $model, 2);
                           updateBankDetails(selectProjectDetails.performer_id, selectProjectDetails.request_id);
                           updatePerformerUsers(selectProjectDetails.request_id);
                           getRequestID($item);" required ng-disabled="!canEdit()"
                           ng-model="project_id" name="project_code" required >
                  <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                    {{$select.selected.code}}
                  </ui-select-match>
                  <ui-select-choices repeat="item.project_id as item in projects | filter: $select.search | orderBy: 'fullName'">
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
          <dl ng-show="selectProjectDetails" class="custom-dl">
            <ng-show ng-show="selectProjectDetails.year">
              <dt>Haushaltsjahr:</dt>
              <dd>{{selectProjectDetails.year}}</dd>
            </ng-show>
            <ng-show ng-show="selectProjectDetails.performer_name">
              <dt>Träger:</dt>
              <dd class="financial-request">{{selectProjectDetails.performer_name}}</dd>
            </ng-show>       
          </dl>
          <hr />
          <div class="m-b-15">
            <h5>Ansprechperson für Rückfragen<span spi-hint text="_hint.project_data_concept_user_id" class="has-hint"></span></h5>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('representative_user')}">
              <ui-select ng-disabled="!financial_request.request_id || !canEdit()" required on-select="onSelectUser($item, $model, 2)" ng-model="financial_request.representative_user_id" name="representative_user"> 
                <ui-select-match allow-clear="true" placeholder="Bitte auswählen">{{$select.selected.name}}</ui-select-match>
                <ui-select-choices repeat="item.id as item in  performerUsers | filter: $select.search | orderBy: 'name'">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('representative_user')}" class="hide">
                  <label class="error">Ansprechperson erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
          <dl ng-show="selectRepresentativeUser" class="custom-dl">
              <dt ng-show="selectRepresentativeUser.phone">Telefon:</dt>
              <dd ng-show="selectRepresentativeUser.phone" class="dd-margin">{{selectRepresentativeUser.phone}}</dd>
              <dt ng-show="selectRepresentativeUser.email">E-Mail:</dt>
              <dd ng-show="selectRepresentativeUser.email" class="dd-margin"><a class="visible-lg-block" href="mailto:{{selectRepresentativeUser.email}}">{{selectRepresentativeUser.email}}</a></dd>
          </dl>
          <hr />
          <h5 >Bankverbindung<span spi-hint text="_hint.project_data_concept_user_id" class="has-hint"></span></h5>
          <div class="form-group">
            <label class="col-lg-3 control-label">IBAN<span spi-hint text="_hint.fin_plan_bank_details_id" class="has-hint"></label>
            <div class="col-lg-9">
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('bankverbindung')}">
                <ui-select ng-disabled="!financial_request.representative_user_id || !canEdit()" required name = "bankverbindung" class="type-document" on-select="updateIBAN($item)" ng-model="financial_request.bank_account_id">
                  <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.iban}}</ui-select-match>
                  <ui-select-choices repeat="item.id as item in bank_details | filter: $select.search | orderBy: 'iban'">
                    <span ng-bind-html="item.iban | highlight: $select.search"></span>
                  </ui-select-choices>
                </ui-select>
                <span ng-class="{hide: !fieldError('bankverbindung')}" class="hide">
                  <label class="error">IBAN erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                </span>
              </div>
            </div>
          </div>
          <dl class="custom-dl">
            <dt ng-show="IBAN.contact_person">Kontoinhaber: </dt>
            <dd ng-show="IBAN.contact_person" class="dd-margin">{{IBAN.contact_person}}</dd>
            <dt ng-show="IBAN.bank_name && (user.type == 'a' || user.type == 'p') ">Kreditor:</dt>
            <dd ng-show="IBAN.bank_name && (user.type == 'a' || user.type == 'p') " class="dd-margin">{{IBAN.bank_name}}</dd>
            <dt ng-show="IBAN.description">Beschreibung:</dt>
            <dd ng-show="IBAN.description" class="financial-request">{{IBAN.description}}</dd>
          </dl>
          <h5 ng-if="user.type == 'a' || user.type == 'p'" >Bestätigung der Zahlung/ Änderung</h5>
          <div class="form-group" ng-if="user.type == 'a' || user.type == 'p' ">
            <label class="col-lg-5 control-label">Zahlungsdatum</label>
            <div class="col-lg-7">
              <div class="input-group">
                <input  uib-datepicker-popup="dd.MM.yyyy" is-open="popup_payment_date.opened" datepicker-options="dateOptions"
                        ng-model="payment_date" type="text" id="payment_date"
                        class="form-control datepicker" placeholder="Alle Daten" name="payment_date">
                <span class="input-group-addon" ng-click="popup_payment_date.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
                {{payment_date}}
              <br>
            </div>
          </div>
        </div>
        <div class="col-lg-6 border-side">
          <div class="form-group">
            <label class="col-lg-4 control-label">Belegdatum</label>
            <div class="col-lg-8">
                <div class="input-group" ng-class="{'wrap-line error': fieldError('receipt_date')}">
                  <input uib-datepicker-popup="dd.MM.yyyy" is-open="popup_receipt_date.opened" datepicker-options="dateOptions"
                         ng-model="receipt_date" type="text" id="receipt_date" ng-disabled="!canEdit()"
                         class="form-control datepicker" placeholder="Alle Daten" required name="receipt_date">
                  <span class="input-group-addon" ng-click="popup_receipt_date.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
                <span ng-class="{hide: !fieldError('receipt_date')}" class="hide">
                <br>
                  <label class="error">Belegdatum erforderlich</label>
                </span>
              </div>
            </div>
          <div class="form-group">
            <label class="col-lg-4 control-label">Beleg-Typ<span spi-hint text="_hint.fin_plan_bank_details_id" class="has-hint"></label>
            <div class="col-lg-8">
                <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('payment_type')}">
                  <ui-select ng-change="updateGrid()" required on-select="getPaymentTemplate($item.payment_template_id);" 
                             ng-model="financial_request.payment_type_id"  name="payment_type" ng-disabled="!canEdit()">
                    <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                    <ui-select-choices repeat="item.id as item in paymentTypes | filter: $select.search | orderBy: 'name'">
                      <span ng-bind-html="item.name | highlight: $select.search"></span>
                    </ui-select-choices>
                  </ui-select>
                  <span ng-class="{hide: !fieldError('payment_type')}" class="hide">
                    <label class="error">Beleg-Typ erforderlich</label>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                  </span>
                </div>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-4 p-t-0 control-label">Druck Template wählen<span spi-hint text="_hint.fin_plan_bank_details_id" class="has-hint"></label>
            <div class="col-lg-8">
                <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('payment_template')}">
                  <ui-select required class="type-document" ng-model="payment_template_id" name="payment_template" ng-disabled="!financial_request.payment_type_id || !canEdit()">
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
          <div class="form-group">
            <label class="col-lg-4 control-label">Rate<span spi-hint text="_hint.fin_plan_bank_details_id" class="has-hint"></label>
            <div class="col-lg-8">
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('rate')}">
                <ui-select required ng-model="financial_request.rate_id" name="rate" ng-disabled="!canEdit()">
                  <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                  <ui-select-choices repeat="item.id as item in rates | filter: $select.search | orderBy: 'id'">
                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                  </ui-select-choices>
                </ui-select>
                <span ng-class="{hide: !fieldError('rate')}" class="hide">
                  <label class="error">Rate erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-4 control-label">Betrag</label>
            <div class="col-lg-7" ng-class="{'wrap-line error': fieldError('request_cost')}">
              <input required class="form-control" type="text" ng-model="financial_request.request_cost" ng-disabled="!canEdit()" name="request_cost">
              <span ng-class="{hide: !fieldError('request_cost')}" class="hide">
                <label class="error">Betrag erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
            <div class="col-lg-1 p-0  m-t-5">
              <span class="symbol">€</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-4 control-label">Bemerkung</label>
            <div class="col-lg-8">
              <textarea class="form-control" ng-model="financial_request.description" ng-disabled="!canEdit()"></textarea>
            </div>
          </div>
          <button class="custom-btn btn w-lg pull-right print_btn" ng-if="user.type == 't' && canEdit()" ng-click="print()">
            <i class="ion-printer"></i> 
            <span class="text-capitalize">Drucken</span>
          </button>
        </div>
      </div>
      <hr />
      <div class="form-group group-btn row m-t-30">
        <div class="col-lg-6 text-left">
          <a class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"  ng-click="remove()"><i class="fa fa-trash-o"></i></a>
<!--          <button class="btn btn-icon btn-danger btn-lg" data-dismiss="modal" ng-click="accept();">Mittelabrufe buchen</button>-->
        </div>
        <div class="col-lg-6 text-right">
          <button class="btn w-lg cancel-btn btn-lg" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn btn-lg" ng-click="submitFormFinancialRequest()">Speichern</button>
        </div>
      </div>
    </ng-form>
  </div>