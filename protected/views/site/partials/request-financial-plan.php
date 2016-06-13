<div id="finance" class="tab-pane" ng-controller="RequestFinancePlanController">
  <div class="panel-group panel-group-joined m-0">
    <div class="panel panel-default">
      <div class="clearfix">
        <h2 class="panel-title title-custom pull-left">
          Finanzplan
        </h2>
      </div>
      <hr />
      <div class="panel-body p-t-0">
        <div class="row row-holder-dl">
          <div class="col-lg-4">
            <div class="form-group">
              <label>Ansprechpartner für Rückfragen zum Finanzplan</label>
              <ui-select   on-select="onSelectCallback($item, $model, 3)" class="type-document" ng-model="data.finance_user_id">
                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                <ui-select-choices repeat="item.id as item in users | filter: $select.search | filter: {is_finansist:1} | orderBy: 'name'">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
            </div>
            <dl class="custom-dl" ng-show="selectFinanceResult">
              <ng-show ng-show="selectFinanceResult.function">
                <dt>Funktion:</dt>
                <dd>{{selectFinanceResult.function}}</dd>
              </ng-show>
              <ng-show ng-show="selectFinanceResult.gender">
                <dt>Anrede:</dt>
                <dd>{{selectFinanceResult.gender}}</dd>
              </ng-show>
              <ng-show ng-show="selectFinanceResult.phone">
                <dt>Telefon:</dt>
                <dd>{{selectFinanceResult.phone}}</dd>
              </ng-show>
              <ng-show ng-show="selectFinanceResult.email">
                <dt>Email:</dt>
                <dd><a class="visible-lg-block" href="mailto:{{selectFinanceResult.email}}">{{selectFinanceResult.email}}</a></dd>
              </ng-show>
            </dl>
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              <label>Bankverbindung</label>
              <ui-select class="type-document" on-select="updateIBAN($item)" ng-model="data.bank_details_id">
                <ui-select-match allow-clear="true" placeholder="Alles anzeigen">IBAN: {{$select.selected.iban}}</ui-select-match>
                <ui-select-choices repeat="item.id as item in bank_details | filter: $select.search | orderBy: 'iban'">
                  <span ng-bind-html="item.iban | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
            </div>
            <dl class="custom-dl">
              <dt ng-show="IBAN.contact_person">Kontoinhaber:</dt>
              <dd ng-show="IBAN.contact_person">{{IBAN.contact_person}}</dd>
              <dt ng-show="IBAN.bank_name">Kreditor:</dt>
              <dd ng-show="IBAN.bank_name">{{IBAN.bank_name}}</dd>
              <dt ng-show="IBAN.description">Beschreibung:</dt>
              <dd ng-show="IBAN.description">{{IBAN.description}}</dd>
            </dl>
          </div>
          <div class="col-lg-4">
            <div class="clearfix box-recalculate">
              <div class="col-lg-12 text-center form-custom-box ">
                <div class="sum total-sum">
                  <strong>Beantragte Fördermittel</strong>
                  <span>€ {{total_cost||0| number:2}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-lg-5 calculate m-b-30 p-r-0 pull-right">
<label class="col-lg-8 control-label text-right ">Recalculation</label>
<div class="btn-group btn-toggle col-lg-4 control-label">
<button class="btn btn-sm btn-default">JA</button>
<button class="btn btn-sm active">NEIN</button>
</div>
</div> -->
        </div>
        <div class="row m-b-15 m-t-30">
          <div class="col-lg-6">
            <h3 class="panel-title title-custom">
              Ausgaben: Personalkosten
            </h3>
          </div>
          <div class="col-lg-6 btn-row">
            <button class="btn w-xs pull-right" ng-click="request_users.push({})">Neue Person hinzufügen</button>
          </div>
        </div>
        <div id="accordion-account" class="panel-group panel-group-joined row">
          <div class="panel panel-default row" ng-if="!emploee.is_deleted" ng-repeat="emploee in request_users">
            <div class="panel-heading">
              <button class="no-btn" title="Entfernen" ng-click="deleteEmployee($index)" ng-hide="request_users.length < 2">
                <i class="ion-close-round"></i>
              </button>
              <a class="collapsed" href="#account{{$index}}" data-parent="#accordion-account" data-toggle="collapse">
                <strong>{{emploee.user.name || 'ALLES ANZEIGEN'}}
                </strong>
                <span class="sum">
                  <strong>Summe AN-Brutto mit Zusatzversorgung</strong>
                  <span>€ {{emploee.brutto || 0}}</span>
                </span>
                <span class="sum">
                  <strong>Summe AG-Anteil nur SV und Umlagen</strong>
                  <span>€ {{emploee.addCost || 0}}</span>
                </span>
                <span class="sum total-sum">
                  <strong>Anrechenbare Personalkosten</strong>
                  <span>€ {{emploee.fullCost || 0}}</span>
                </span>
              </a>
            </div>
            <div class="panel-collapse collapse" id="account{{$index}}">
              <div class="panel-body">
                <div class="row m-b-30">
                  <label class="col-lg-1 control-label">Umlage 1</label>
                  <div class="btn-group btn-toggle col-lg-2 control-label">
                    <button ng-change="calculateEmployee(emploee)" ng-class="emploee.is_umlage == 1 ? 'active' : 'btn-default'" ng-model="emploee.is_umlage" uib-btn-radio="1" class="btn btn-sm">JA</button>
                    <button ng-change="calculateEmployee(emploee)" ng-class="emploee.is_umlage != 1 ? 'active' : 'btn-default'" ng-model="emploee.is_umlage" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                  </div>
                </div>
                <div class="row row-holder-dl">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <ui-select   on-select="employeeOnSelect($item, emploee)" class="type-document" ng-model="emploee.user_id">
                        <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                        <ui-select-choices repeat="item.id as item in users | filter: $select.search | filter: {is_selected:0} | orderBy: 'name'">
                          <span ng-bind-html="item.name | highlight: $select.search"></span>
                        </ui-select-choices>
                      </ui-select>
                    </div>
                    <dl class="custom-dl">
                      <dt ng-show="emploee.user.title">Titel:</dt>
                      <dd ng-show="emploee.user.title">{{emploee.user.title}}</dd>
                      <dt ng-show="emploee.user.phone">Telefon:</dt>
                      <dd ng-show="emploee.user.phone">{{emploee.user.phone}}</dd>
                      <dt ng-show="emploee.user.email">Email:</dt>
                      <dd ng-show="emploee.user.email"><a target="_blank" href="mailto:{{emploee.user.email}}">{{emploee.user.email}}</a></dd>
                    </dl>
                  </div>
                  <div class="col-lg-8">
                    <h4 class="col-lg-12 m-b-30 m-t-0">Vergleichsstellenbewertung entsprechend TV-L Berlin
                      <button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
                        <i class="fa fa-question"></i>
                      </button>
                    </h4>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltgruppe</label>
                      <div class="col-lg-3">
                        <ui-select class="type-document" ng-model="emploee.group_id">
                          <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in request_financial_group | filter: $select.search | orderBy: 'name'">
                            <span ng-bind-html="item.name | highlight: $select.search"></span>
                          </ui-select-choices>
                        </ui-select>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltstufe</label>
                      <div class="col-lg-9">
                        <ui-select class="type-document" ng-model="emploee.remuneration_level_id">
                          <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in remuneration_level | filter: $select.search | orderBy: 'name'">
                            <span ng-bind-html="item.name | highlight: $select.search"></span>
                          </ui-select-choices>
                        </ui-select>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Sonstiges</label>
                      <div class="col-lg-9">
                        <input class="form-control" ng-model="emploee.other" type="text" placeholder="Tragen Sie den Text hier ein">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clearfix">
                  <h4>Ausgaben</h4>
                  <hr />
                  <div class="clearfix costs-box">
                    <div class="col-lg-4 form-horizontal">
                      <div class="form-group">
                        <label class="col-lg-6 control-label p-l-0">Kosten pro Monat (AN-Brutto)
                          <button data-trigger="focus" aria-describedby="popover332715" data-original-title="" type="button" class="has-hint btn btn-question" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                            <i class="fa fa-question"></i>
                          </button></label>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-4">
                          <input ng-change="calculateEmployee(emploee)" ng-model="emploee.cost_per_month_brutto" class="form-control" type="text">
                        </div>
                        <div class="col-lg-1 p-0">
                          <span class="symbol">€</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Geplante Monate im Projekt</label>
                        <div class="col-lg-4">
                          <select class="form-control" ng-model="emploee.month_count" ng-change="calculateEmployee(emploee)">
                            <option value="12">12</option>
                            <option value="11">11</option>
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Arbeitsstunden pro Woche</label>
                        <div class="col-lg-4">
                          <input ng-change="numValidate(emploee,'hours_per_week', 4)" class="form-control" type="text" ng-model="emploee.hours_per_week">
                        </div>
                        <div class="col-lg-1 p-0"><span class="symbol">Std.</span></div>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="col-lg-12 form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-4 control-label ">Jahressonderzahlungen
                            <button data-trigger="focus" aria-describedby="popover332715" data-original-title="" type="button" class="has-hint btn btn-question" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                              <i class="fa fa-question"></i>
                            </button>
                          </label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button ng-change="calculateEmployee(emploee)" ng-class="emploee.have_annual_bonus != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_annual_bonus" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_annual_bonus">
                            <div class="col-lg-2">
                              <input ng-change="calculateEmployee(emploee)" ng-required="emploee.have_annual_bonus == 1" class="form-control" ng-model="emploee.annual_bonus" type="text">
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Jahr</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-4 control-label">Zusatzversorgung (VWL)
                            <button data-trigger="focus" aria-describedby="popover332715" data-original-title="" type="button" class="has-hint btn btn-question" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                              <i class="fa fa-question"></i>
                            </button>
                          </label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button ng-change="calculateEmployee(emploee)" ng-class="emploee.have_additional_provision_vwl != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_additional_provision_vwl" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input"  ng-show="emploee.have_additional_provision_vwl">
                            <div class="col-lg-2">
                              <input ng-change="calculateEmployee(emploee)" ng-required="emploee.have_additional_provision_vwl == 1" class="form-control" type="text" ng-model="emploee.additional_provision_vwl">
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Monat</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-4 control-label">Zusatzversorgung (betriebl. Altersversorgung)
                            <button data-trigger="focus" aria-describedby="popover332715" data-original-title="" type="button" class="has-hint btn btn-question" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                              <i class="fa fa-question"></i>
                            </button>
                          </label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension == 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="1" class="btn btn-sm">JA</button>
                            <button ng-change="calculateEmployee(emploee)" ng-class="emploee.have_supplementary_pension != 1 ? 'active' : 'btn-default'" ng-model="emploee.have_supplementary_pension" uib-btn-radio="0" class="btn btn-sm">NEIN</button>
                          </div>
                          <div class="has-input" ng-show="emploee.have_supplementary_pension">
                            <div class="col-lg-2">
                              <input ng-change="calculateEmployee(emploee)" ng-required="emploee.have_supplementary_pension == 1" class="form-control" type="text" ng-model="emploee.supplementary_pension">
                            </div>
                            <div class="col-lg-2 p-0">
                              <span class="symbol">pro Monat</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="m-b-30">
          <h3 class="panel-title title-custom m-b-15">
            Sachkosten
          </h3>
          <div ng-repeat="school in financeSchools">
            <h4>{{school.school_name}} ({{school.school_number}})</h4>
            <hr>
            <div class="form-group clearfix school-row">
              <div class="col-lg-2 custom-school-row">
                <div class="sum rate-ico clearfix">
                  <strong>Stellenanteil</strong>
                  <div class="col-lg-9 p-l-0 m-t-10">
                    <input type="text" class="form-control" ng-change="numValidate(school,'rate'); updateTrainingCost(school)" ng-model="school.rate">
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-lg-offset-1">
                <span class="sum calendar-ico clearfix">
                  <strong>Monat</strong>
                  <div class="col-lg-9 p-l-0 m-t-10">
                    <input type="text" class="form-control" ng-change="numValidate(school,'month_count');" ng-model="school.month_count">
                  </div>
                </span>
              </div>
              <div class="col-lg-3 col-lg-offset-1 custom-school-row">
                <span class="sum clearfix">
                  <strong>Fortbildungskosten</strong>
                  <span ng-hide="school.rate < 1 && school.rate > 0.5">€{{school.training_cost|| 0 | number:2}}</span>
                  <div class="col-lg-9 p-l-0 m-t-10" ng-show="school.rate*1 < 1 && school.rate*1 > 0.5">
                    <input type="text" class="form-control" ng-change="numValidate(school,'training_cost');updateResultCost();" ng-model="school.training_cost">
                  </div>
                </span>
              </div>
              <div class="col-lg-2 col-lg-offset-1">
                <span class="sum clearfix">
                  <strong>Regiekosten</strong>
                  <!--<span>€ 11500,00</span>-->
                  <div class="col-lg-9 p-l-0 m-t-10">
                    <input type="text" class="form-control" ng-change="numValidate(school,'overhead_cost');updateResultCost();" ng-model="school.overhead_cost">
                  </div>
                </span>
              </div>
            </div>
          </div>
          
        </div>
        <div class="m-b-30">
          <div class="row m-b-15">
            <h3 class="panel-title title-custom col-lg-6">
              Berufsgenossenschaftsbeiträge
            </h3>
            <div class="col-lg-6 btn-row">
              <button class="btn w-xs pull-right" ng-click="prof_associations.push({})">Berufsgenossenschaft hinzufügen</button>
            </div>
          </div>

          <hr />
          <div class="row form-horizontal m-b-15" ng-repeat="association in prof_associations" ng-if="!association.is_deleted">
            <label class="col-lg-1 control-label">
              Name
            </label>
            <div class="col-lg-7">
              <input class="form-control" type="text" ng-model="association.name">
            </div>
            <label class="col-lg-1 control-label">
              Beitrag
            </label>
            <div class="col-lg-2">
              <input class="form-control" type="text" ng-model="association.sum" ng-change="updateResultCost();">
            </div>
            <div class="col-lg-1 p-0 custom-col-1 m-t-5">
              <span class="symbol">€</span>
            </div>
            <div class="col-lg-1 custom-col-1 m-t-5" ng-hide="prof_associations.length <= 1">
              <button ng-click="deleteProfAssociation($index)" class="no-btn" title="Entfernen">
                <i class="ion-close-round"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="m-b-30">
          <h3 class="panel-title title-custom">
            Sonstige Einnahmen
          </h3>
          <hr />
          <div class="row">
            <div class="col-lg-12 p-0 m-b-30">
              <div class="form-custom-box p-15 m-b-0 form-horizontal">
                <div class="form-group m-b-0">
                  <label class="col-lg-2 control-label bold-label">
                    Sonstige Einnahmen
                    <button data-trigger="focus" aria-describedby="popover332715" data-original-title="" type="button" class="has-hint btn btn-question shot-fix" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                      <i class="fa fa-question"></i>
                    </button>
                  </label>
                  <div class="col-lg-6">
                    <input class="form-control" type="text" placeholder="Namen Sonstiger Einkommensquellen" ng-model="revenue_description">
                  </div>
                  <label class="col-lg-1 control-label custom-width-label">
                    Betrag
                  </label>
                  <div class="col-lg-2">
                    <input class="form-control" type="text"  ng-model="revenue_sum" ng-change="updateResultCost();">
                  </div>
                  <span class="symbol m-t-5">€</span>
                </div>

              </div>
            </div>
            <div class="holder-total clearfix">
              <div class="col-lg-2 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Personalkosten</strong>
                  <span>€ {{emoloyeesCost||0| number:2}}</span>
                </div>
              </div>
              <div class="col-lg-2 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Fortbildungskosten</strong>
                  <span>€ {{training_cost||0| number:2}}</span>
                </div>
              </div>
              <div class="col-lg-2 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Regiekosten</strong>
                  <span>€ {{overhead_cost||0| number:2}}</span>
                </div>
              </div>
              <div class="col-lg-3 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Berufsgenossenschaftsbeiträge</strong>
                  <span>€ {{prof_association_cost||0| number:2}}</span>
                </div>
              </div>
              <div class="col-lg-3 p-r-0 custom-col">
                <div class="sum money-minus-ico">
                  <strong>Sonstige Einnahmen</strong>
                  <span>€ {{revenue_sum||0| number:2}}</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 pull-right">
              <div class="clearfix box-recalculate">
                <div class="col-lg-12 text-center form-custom-box ">
                  <div class="sum total-sum">
                    <strong>Beantragte Fördermittel</strong>
                    <span>€ {{total_cost||0| number:2}}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr />
        </div>
        <div class="row">
          <div class="col-lg-10">
            <h4 class="m-t-0">Prüfnotiz</h4>
            <textarea placeholder="Tragen Sie den Text hier ein" class="form-control"></textarea>
          </div>

          <div class="col-lg-2">
            <div class="m-t-30 text-right pull-right">
              <button class="btn w-lg btn-lg btn-success m-b-10">AKZEPTIEREN</button>
              <button class="btn w-lg btn-lg btn-danger">ABLEHNEN</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
