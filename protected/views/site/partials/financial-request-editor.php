<div class="panel panel-color panel-primary edit-summary print-financial-request">
    <div class="panel-heading m-b-30 clearfix"> 
      <h3 class="m-0 pull-left" ng-if="!isInsert">Mittelabruf bearbeiten #{{id ? id : financialRequestId}}</h3>
      <h3 class="m-0 pull-left" ng-if="isInsert">Mittelabruf hinzufügen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>
    <div class="row">
      <ng-form name="formFinancialRequest" class="form-horizontal">
        <div class="col-lg-6 row-holder-dl">
          <div class="form-group">
            <label class="col-lg-4 control-label">Jahr</label>
            <div class="col-lg-8">
              <div spi-hint text="_hint.year.text"  title="_hint.year.title" class="has-hint"></div>
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('year')}">
                <ui-select required ng-disabled="!rights.fields || !isInsert" on-select="onSelectYear();getProjects($item.year)" ng-model="year" name="year">
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
            <label class="col-lg-4 control-label">Projekte</label>
            <div class="col-lg-8">
              <div spi-hint text="_hint.project_code.text"  title="_hint.project_code.title" class="has-hint"></div>
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('project_code')}">
                <ui-select on-select="onSelectProject($item, $model, 2);
                           updateRates($item);updateBankDetails(selectProjectDetails.performer_id, selectProjectDetails.request_id, $item);
                           updatePerformerUsers(selectProjectDetails.performer_id);"
                           required ng-disabled="!requests || !isInsert"
                           ng-model="financialRequest.request_id" name="project_code" required >
                  <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                    {{$select.selected.code}}
                  </ui-select-match>
                  <ui-select-choices repeat="item.id as item in requests | filter: $select.search | orderBy: 'fullName'">
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
            <ng-show ng-show="selectProjectDetails.performer_name">
              <dt>Träger:</dt>
              <dd class="financial-request">{{selectProjectDetails.performer_name}}</dd>
            </ng-show>       
          </dl>
          <hr />
          <div class="m-b-15">
            <h5>Ansprechperson für Rückfragen</span></h5>
            <div spi-hint text="_hint.representative_user.text"  title="_hint.representative_user.title" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('representative_user')}">
              <ui-select ng-disabled="!financialRequest.request_id || !rights.fields" required on-select="onSelectUser($item, $model, 2)" ng-model="financialRequest.representative_user_id" name="representative_user"> 
                <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">{{$select.selected.name}}</ui-select-match>
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
          <h5 >Bankverbindung</span></h5>
          <div class="form-group">
            <label class="col-lg-3 control-label">IBAN</label>
            <div class="col-lg-9">    
              <div spi-hint text="_hint.bank_account.text"  title="_hint.bank_account.title" class="has-hint"></div>
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('bankverbindung')}">
                <ui-select ng-disabled="!financialRequest.request_id || !rights.fields" required name = "bankverbindung" class="type-document" on-select="updateIBAN($item)" ng-model="financialRequest.bank_account_id">
                  <ui-select-match allow-clear="true" placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">{{$select.selected.iban}}</ui-select-match>
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
          <dl class="custom-dl" ng-if="IBAN.contact_person || IBAN.bank_name || IBAN.description">
            <dt ng-show="IBAN.contact_person">Kontoinhaber: </dt>
            <dd ng-show="IBAN.contact_person" class="dd-margin">{{IBAN.contact_person}}</dd>
            <dt ng-show="user.type == 'a' || user.type == 'p'">Kreditor:</dt>
            <dd ng-show="user.type == 'a' || user.type == 'p'" class="dd-margin">{{IBAN.bank_name ? IBAN.bank_name : '-'}}</dd>
            <dt ng-show="IBAN.description">Beschreibung:</dt>
            <dd ng-show="IBAN.description" class="financial-request">{{IBAN.description}}</dd>
          </dl>
          <h5 ng-if="rights.receipt" >Bestätigung der Zahlung/ Änderung</h5>
          <div class="form-group" ng-if="rights.receipt">
            <label class="col-lg-5 control-label">Zahlungsdatum</label>
            <div class="col-lg-7">
              <div spi-hint text="_hint.payment_date.text"  title="_hint.payment_date.title" class="has-hint"></div>
              <div class="input-group"  ng-class="{'wrap-line error': fieldError('payment_date')}">
                <input  uib-datepicker-popup="dd.MM.yyyy" is-open="popup_payment_date.opened" datepicker-options="dateOptions"
                        ng-model="paymentDate" ng-change="setValue(paymentDate)" type="text" id="payment_date" ng-required="financialRequest.status == 2 && (user.type == 'a' || user.type == 'p')"
                        class="form-control datepicker" placeholder="Alle Daten" name="payment_date" ng-disabled="!isInsert && financialRequest.status != 2">
                <span class="input-group-addon" ng-click="popup_payment_date.opened = true"><i class="glyphicon glyphicon-calendar"></i></span>
              </div>
              <span ng-class="{hide: !fieldError('payment_date')}" class="hide">
                <br>
                <label class="error">Zahlungsdatum erforderlich</label>
              </span>
            </div>
          </div>
        </div>
        <div class="col-lg-6 border-side">
          <div class="form-group">
            <label class="col-lg-4 control-label">Belegdatum</label>
            <div class="col-lg-8">
                <div spi-hint text="_hint.receipt_date.text"  title="_hint.receipt_date.title" class="has-hint"></div>
                <div class="input-group" ng-class="{'wrap-line error': fieldError('receipt_date')}">
                  <input uib-datepicker-popup="dd.MM.yyyy" is-open="popup_receipt_date.opened" datepicker-options="dateOptions"
                         ng-model="receiptDate" type="text" id="receipt_date" ng-disabled="!rights.fields" ng-change="updateRates(project)"
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
            <label class="col-lg-4 control-label">Beleg-Typ</label>
            <div class="col-lg-8">
                <div spi-hint text="_hint.payment_type.text"  title="_hint.payment_type.title" class="has-hint"></div>
                <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('payment_type')}">
                  <ui-select required on-select="updateTemplates(financialRequest.payment_type_id);updateCost(financialRequest.payment_type_id, financialRequest.request_id);"
                             ng-model="financialRequest.payment_type_id"  name="payment_type" ng-disabled="!rights.fields || !financialRequest.request_id">
                    <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                    <ui-select-choices repeat="item.id as item in paymentTypes | filter: $select.search | orderBy: 'id'">
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
            <label class="col-lg-4 p-t-0 control-label">Formular wählen</label>
            <div class="col-lg-8">
                <div spi-hint text="_hint.payment_template.text"  title="_hint.payment_template.title" class="has-hint"></div>
                <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('payment_template')}">
                  <ui-select required class="type-document" ng-model="financialRequest.document_template_id" name="payment_template" ng-disabled="!financialRequest.payment_type_id || !rights.fields">
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
          <div class="form-group" ng-if="financialRequest.payment_type_id == 1">
            <label class="col-lg-4 control-label">Rate</label>
            <div class="col-lg-8">
              <div spi-hint text="_hint.rate.text"  title="_hint.rate.title" class="has-hint"></div>
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('rate')}">
                <ui-select ng-required="financialRequest.payment_type_id == 1" ng-model="financialRequest.rate_id" name="rate" ng-disabled="!selectProjectDetails || !rights.fields" 
                           on-select="updateCost(financialRequest.payment_type_id, financialRequest.request_id);">
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
            <div class="col-lg-5" ng-class="{'wrap-line error': fieldError('request_cost') || error || formFinancialRequest.request_cost.$error.pattern}">
              <input ng-pattern="/\d+[\,\.]?\d*/" required ng-change="checkCost(financialRequest.request_cost, financialRequest.payment_type_id)" class="form-control" type="text" ng-model="financialRequest.request_cost" ng-disabled="!rights.fields" name="request_cost">
            </div>
            <div class="col-lg-1 p-0  m-t-5">
              <span class="symbol">€</span>
            </div>
            <div class="col-lg-2" >
                <div spi-hint text="_hint.request_cost.text"  title="_hint.request_cost.title" class="has-hint"></div>
                <button ng-if="financialRequest.status == 1 || isInsert" ng-disabled="!financialRequest.request_id" class="btn custom-btn refresh-summ pull-right" ng-click="refreshSumm()" title="Refresh Betrag">
							  <i class="fa fa-rotate-left"></i>
						  </button>
            </div>
            <div class="col-lg-8 m-t-5 pull-right">
              <span ng-class="{hide: !fieldError('request_cost')}" class="hide">
                <label ng-show="fieldError('request_cost')" class="error">Betrag erforderlich</label>                
              </span>
              <span ng-class="{hide: !error}" class="hide">
                <label ng-show="error" class="error">Nur kleinere Raten erlaubt </label>         
              </span>
              <span ng-class="{hide: !formFinancialRequest.request_cost.$error.pattern}" class="hide">
                <label ng-show="formFinancialRequest.request_cost.$error.pattern" class="error">Nur Ziffern erlauben</label>            
              </span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-4 control-label">Bemerkung</label>
            <div class="col-lg-8">
              <div spi-hint text="_hint.description.text"  title="_hint.description.title" class="has-hint"></div>
              <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('description')}">
                <textarea ng-required="(checkCostError(request_cost, financialRequest.request_cost) && isInsert) || financialRequest.payment_type_id != 1" name="description" class="form-control" ng-model="financialRequest.description" ng-disabled="!rights.fields"></textarea>
                <span ng-if="fieldError('description')" class="glyphicon glyphicon-remove form-control-feedback"></span>
              </div>
            </div>
          </div>            
          <span ng-class="{hide: !fieldError('description')}" class="hide margin-textarea">
            <label class="error">Bemerkung erforderlich</label>
          </span>
          <button class="custom-btn btn w-lg pull-right print_btn" ng-if="rights.print" ng-click="print()">
            <i class="ion-printer"></i> 
            <span class="text-capitalize">Drucken</span>
          </button>
        </div>
      </div>
      <hr />
      <div class="form-group group-btn row m-t-30">
        <div class="col-lg-6 text-left">
          <a class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning" ng-if="rights.delete" ng-click="remove()"><i class="fa fa-trash-o"></i></a>
<!--          <button class="btn btn-icon btn-danger btn-lg" data-dismiss="modal" ng-click="accept();">Mittelabrufe buchen</button>-->
        </div>
        <div class="col-lg-6 text-right">
          <button class="btn w-lg cancel-btn btn-lg" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn btn-lg" ng-if="rights.save" ng-click="submitFormFinancialRequest()">Speichern</button>
        </div>
      </div>
    </ng-form>
  </div>