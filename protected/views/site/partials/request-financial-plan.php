<div class="tab-pane" ng-controller="RequestFinancePlanController">
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
              <ng-show ng-show="selectFinanceResult.title">
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
              <select class="form-control">
                <option>IBAN: DE64100708480511733803a</option>
              </select>
            </div>
            <dl class="custom-dl">
              <dt>Kontoinhaber:</dt>
              <dd>Mr Werner Munk</dd>
              <dt>Kreditor:</dt>
              <dd>3148800</dd>
              <dt>Beschreibung:</dt>
              <dd>tandem BQG</dd>
            </dl>
          </div>
          <div class="col-lg-4">
            <div class="clearfix box-recalculate">
              <div class="col-lg-12 text-center form-custom-box ">
                <div class="sum total-sum">
                  <strong>Beantragte Fördermittel</strong>
                  <span>€ 71300,00</span>
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
            <button class="btn w-xs pull-right">Neue Person hinzufügen</button>
          </div>
        </div>
        <div id="accordion-account" class="panel-group panel-group-joined row">
          <div class="panel panel-default row">
            <div class="panel-heading">
              <a class="collapsed" href="#account" data-parent="#accordion-account" data-toggle="collapse">
                <strong>Mr Werner Munk
                  <button class="no-btn" title="Entfernen">
                    <i class="ion-close-round"></i>
                  </button>
                </strong>
                <span class="sum">
                  <strong>Summe AN-Brutto mit Zusatzversorgung</strong>
                  <span>€ 7000,00</span>
                </span>
                <span class="sum">
                  <strong>Summe AG-Anteil nur SV und Umlagen</strong>
                  <span>€ 7000,00</span>
                </span>
                <span class="sum total-sum">
                  <strong>Anrechenbare Personalkosten</strong>
                  <span>€ 14000,00</span>
                </span>
              </a>
            </div>
            <div class="panel-collapse collapse" id="account">
              <div class="panel-body">
                <div class="row m-b-30">
                  <label class="col-lg-1 control-label">Umlage 1</label>
                  <div class="btn-group btn-toggle col-lg-2 control-label">
                    <button class="btn btn-sm btn-default">JA</button>
                    <button class="btn btn-sm active">NEIN</button>
                  </div>
                </div>
                <div class="row row-holder-dl">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <select class="form-control">
                        <option>Mr Werner Munk</option>
                      </select>
                    </div>
                    <dl class="custom-dl">
                      <dt>Titel:</dt>
                      <dd>Some title</dd>
                      <dt>Telefon:</dt>
                      <dd>(030) 2888 496</dd>
                      <dt>Email:</dt>
                      <dd><a target="_blank" href="mailto:admin@warenform.de">admin@warenform.de</a></dd>
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
                        <select class="form-control">
                          <option>E9</option>
                          <option>E8</option>
                          <option>E7</option>
                          <option>E6</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltstufe</label>
                      <div class="col-lg-9">
                        <select class="form-control">
                          <option>Entgeltstufe 1 (TV-L Berlin)</option>
                          <option>Entgeltstufe 2 (TV-L Berlin)</option>
                          <option>Entgeltstufe 3 (TV-L Berlin)</option>
                          <option>Entgeltstufe 4 (TV-L Berlin)</option>
                          <option>Entgeltstufe 5 (TV-L Berlin, max. E9)</option>
                          <option>Entgeltstufe 6 (TV-L Berlin, max. E8)</option>
                          <option>indiv. Entgeltstufe 1 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 2 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 3 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 4 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 5 + (TVÜ-L Berlin, max. E9)</option>
                          <option>indiv. Entgeltstufe 6 + (TVÜ-L Berlin)</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Sonstiges</label>
                      <div class="col-lg-9">
                        <input class="form-control" type="text" value="Tragen Sie den Text hier ein">
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
                          <input class="form-control" type="text" value="7000.00">
                        </div>
                        <div class="col-lg-1 p-0">
                          <span class="symbol">€</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Geplante Monate im Projekt</label>
                        <div class="col-lg-4">
                          <select class="form-control">
                            <option>12</option>
                            <option>11</option>
                            <option>10</option>
                            <option>9</option>
                            <option>8</option>
                            <option>7</option>
                            <option>6</option>
                            <option>5</option>
                            <option>4</option>
                            <option>3</option>
                            <option>2</option>
                            <option>1</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Arbeitsstunden pro Woche</label>
                        <div class="col-lg-4">
                          <input class="form-control" type="text" value="40">
                        </div>
                        <div class="col-lg-1 p-0"><span class="symbol">Std.</span></div>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="col-lg-12 form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-4 control-label ">Zusatzversorgung (VWL)
                            <button data-trigger="focus" aria-describedby="popover332715" data-original-title="" type="button" class="has-hint btn btn-question" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                              <i class="fa fa-question"></i>
                            </button>
                          </label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button class="btn btn-sm active">JA</button>
                            <button class="btn btn-sm btn-default">NEIN</button>
                          </div>
                          <div class="has-input">
                            <div class="col-lg-2">
                              <input class="form-control" type="text" value="100">
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
                            <button class="btn btn-sm btn-default">JA</button>
                            <button class="btn btn-sm active">NEIN</button>
                          </div>
                          <div class="has-input" style="display:none">
                            <div class="col-lg-2">
                              <input class="form-control" type="text">
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
                            <button class="btn btn-sm btn-default">JA</button>
                            <button class="btn btn-sm active">NEIN</button>
                          </div>
                          <div class="has-input" style="display:none">
                            <div class="col-lg-2">
                              <input class="form-control" type="text">
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
          <div class="panel panel-default row">
            <div class="panel-heading">
              <a class="collapsed" href="#account2" data-parent="#accordion-account" data-toggle="collapse">
                <strong>Mr Frank Kiepert-Petersen
                  <button class="no-btn" title="Entfernen">
                    <i class="ion-close-round"></i>
                  </button>
                </strong>
                <span class="sum">
                  <strong>Summe AN-Brutto mit Zusatzversorgung</strong>
                  <span>€ 6200,00</span>
                </span>
                <span class="sum">
                  <strong>Summe AG-Anteil nur SV und Umlagen</strong>
                  <span>€ 4100,00</span>
                </span>
                <span class="sum total-sum">
                  <strong>Anrechenbare Personalkosten</strong>
                  <span>€ 10300,00</span>
                </span>
              </a>
            </div>
            <div class="panel-collapse collapse" id="account2">
              <div class="panel-body">
                <div class="row m-b-30">
                  <label class="col-lg-1 control-label">Umlage 1</label>
                  <div class="btn-group btn-toggle col-lg-2 control-label">
                    <button class="btn btn-sm btn-default">JA</button>
                    <button class="btn btn-sm active">NEIN</button>
                  </div>
                </div>
                <div class="row row-holder-dl">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <select class="form-control">
                        <option>Mr Werner Munk</option>
                      </select>
                    </div>
                    <dl class="custom-dl">
                      <dt>Titel:</dt>
                      <dd>Some title</dd>
                      <dt>Telefon:</dt>
                      <dd>(030) 2888 496</dd>
                      <dt>Email:</dt>
                      <dd><a target="_blank" href="mailto:admin@warenform.de">admin@warenform.de</a></dd>
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
                        <select class="form-control">
                          <option>E9</option>
                          <option>E8</option>
                          <option>E7</option>
                          <option>E6</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltstufe</label>
                      <div class="col-lg-9">
                        <select class="form-control">
                          <option>Entgeltstufe 1 (TV-L Berlin)</option>
                          <option>Entgeltstufe 2 (TV-L Berlin)</option>
                          <option>Entgeltstufe 3 (TV-L Berlin)</option>
                          <option>Entgeltstufe 4 (TV-L Berlin)</option>
                          <option>Entgeltstufe 5 (TV-L Berlin, max. E9)</option>
                          <option>Entgeltstufe 6 (TV-L Berlin, max. E8)</option>
                          <option>indiv. Entgeltstufe 1 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 2 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 3 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 4 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 5 + (TVÜ-L Berlin, max. E9)</option>
                          <option>indiv. Entgeltstufe 6 + (TVÜ-L Berlin)</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Sonstiges</label>
                      <div class="col-lg-9">
                        <input class="form-control" type="text" value="Tragen Sie den Text hier ein">
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
                          <input class="form-control" type="text" value="6200.00">
                        </div>
                        <div class="col-lg-1 p-0">
                          <span class="symbol">€</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Geplante Monate im Projekt</label>
                        <div class="col-lg-4">
                          <select class="form-control">
                            <option>12</option>
                            <option>11</option>
                            <option>10</option>
                            <option>9</option>
                            <option>8</option>
                            <option>7</option>
                            <option>6</option>
                            <option>5</option>
                            <option>4</option>
                            <option>3</option>
                            <option>2</option>
                            <option>1</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Arbeitsstunden pro Woche</label>
                        <div class="col-lg-4">
                          <input class="form-control" type="text" value="40">
                        </div>
                        <div class="col-lg-1 p-0"><span class="symbol">Std.</span></div>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="col-lg-12 form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-4 control-label ">Zusatzversorgung (VWL)
                            <button data-trigger="focus" aria-describedby="popover332715" data-original-title="" type="button" class="has-hint btn btn-question" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                              <i class="fa fa-question"></i>
                            </button>
                          </label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button class="btn btn-sm active">JA</button>
                            <button class="btn btn-sm btn-default">NEIN</button>
                          </div>
                          <div class="has-input">
                            <div class="col-lg-2">
                              <input class="form-control" type="text" value="100">
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
                            <button class="btn btn-sm btn-default">JA</button>
                            <button class="btn btn-sm active">NEIN</button>
                          </div>
                          <div class="has-input" style="display:none">
                            <div class="col-lg-2">
                              <input class="form-control" type="text">
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
                            <button class="btn btn-sm btn-default">JA</button>
                            <button class="btn btn-sm active">NEIN</button>
                          </div>
                          <div class="has-input" style="display:none">
                            <div class="col-lg-2">
                              <input class="form-control" type="text">
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
          <div class="panel panel-default row">
            <div class="panel-heading">
              <a class="collapsed" href="#account3" data-parent="#accordion-account" data-toggle="collapse">
                <strong>Mr Markus Prill
                  <button class="no-btn" title="Entfernen">
                    <i class="ion-close-round"></i>
                  </button>
                </strong>
                <span class="sum">
                  <strong>Summe AN-Brutto mit Zusatzversorgung</strong>
                  <span>€ 5000,00</span>
                </span>
                <span class="sum">
                  <strong>Summe AG-Anteil nur SV und Umlagen</strong>
                  <span>€ 4000,00</span>
                </span>
                <span class="sum total-sum">
                  <strong>Anrechenbare Personalkosten</strong>
                  <span>€ 9000,00</span>
                </span>
              </a>
            </div>
            <div class="panel-collapse collapse" id="account3">
              <div class="panel-body">
                <div class="row m-b-30">
                  <label class="col-lg-1 control-label">Umlage 1</label>
                  <div class="btn-group btn-toggle col-lg-2 control-label">
                    <button class="btn btn-sm btn-default">JA</button>
                    <button class="btn btn-sm active">NEIN</button>
                  </div>
                </div>
                <div class="row row-holder-dl">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <select class="form-control">
                        <option>Mr Werner Munk</option>
                      </select>
                    </div>
                    <dl class="custom-dl">
                      <dt>Titel:</dt>
                      <dd>Some title</dd>
                      <dt>Telefon:</dt>
                      <dd>(030) 2888 496</dd>
                      <dt>Email:</dt>
                      <dd><a target="_blank" href="mailto:admin@warenform.de">admin@warenform.de</a></dd>
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
                        <select class="form-control">
                          <option>E9</option>
                          <option>E8</option>
                          <option>E7</option>
                          <option>E6</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Entgeltstufe</label>
                      <div class="col-lg-9">
                        <select class="form-control">
                          <option>Entgeltstufe 1 (TV-L Berlin)</option>
                          <option>Entgeltstufe 2 (TV-L Berlin)</option>
                          <option>Entgeltstufe 3 (TV-L Berlin)</option>
                          <option>Entgeltstufe 4 (TV-L Berlin)</option>
                          <option>Entgeltstufe 5 (TV-L Berlin, max. E9)</option>
                          <option>Entgeltstufe 6 (TV-L Berlin, max. E8)</option>
                          <option>indiv. Entgeltstufe 1 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 2 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 3 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 4 + (TVÜ-L Berlin)</option>
                          <option>indiv. Entgeltstufe 5 + (TVÜ-L Berlin, max. E9)</option>
                          <option>indiv. Entgeltstufe 6 + (TVÜ-L Berlin)</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group clearfix">
                      <label class="col-lg-3 control-label">Sonstiges</label>
                      <div class="col-lg-9">
                        <input class="form-control" type="text" value="Tragen Sie den Text hier ein">
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
                          <input class="form-control" type="text" value="5000.00">
                        </div>
                        <div class="col-lg-1 p-0">
                          <span class="symbol">€</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Geplante Monate im Projekt</label>
                        <div class="col-lg-4">
                          <select class="form-control">
                            <option>12</option>
                            <option>11</option>
                            <option>10</option>
                            <option>9</option>
                            <option>8</option>
                            <option>7</option>
                            <option>6</option>
                            <option>5</option>
                            <option>4</option>
                            <option>3</option>
                            <option>2</option>
                            <option>1</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-7 control-label p-l-0">Arbeitsstunden pro Woche</label>
                        <div class="col-lg-4">
                          <input class="form-control" type="text" value="40">
                        </div>
                        <div class="col-lg-1 p-0"><span class="symbol">Std.</span></div>
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <div class="col-lg-12 form-horizontal">
                        <div class="form-group">
                          <label class="col-lg-4 control-label ">Zusatzversorgung (VWL)
                            <button data-trigger="focus" aria-describedby="popover332715" data-original-title="" type="button" class="has-hint btn btn-question" data-container="body" title="" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
                              <i class="fa fa-question"></i>
                            </button>
                          </label>
                          <div class="btn-group btn-toggle col-lg-2 control-label">
                            <button class="btn btn-sm active">JA</button>
                            <button class="btn btn-sm btn-default">NEIN</button>
                          </div>
                          <div class="has-input">
                            <div class="col-lg-2">
                              <input class="form-control" type="text" value="100">
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
                            <button class="btn btn-sm btn-default">JA</button>
                            <button class="btn btn-sm active">NEIN</button>
                          </div>
                          <div class="has-input" style="display:none">
                            <div class="col-lg-2">
                              <input class="form-control" type="text">
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
                            <button class="btn btn-sm btn-default">JA</button>
                            <button class="btn btn-sm active">NEIN</button>
                          </div>
                          <div class="has-input" style="display:none">
                            <div class="col-lg-2">
                              <input class="form-control" type="text">
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
          <h4>Pestalozzi-Sshule (06S01)</h4>
          <hr>
          <div class="form-group clearfix school-row">
            <div class="col-lg-2 custom-school-row">
              <div class="sum rate-ico clearfix">
                <strong>Stellenanteil</strong>
                <div class="col-lg-9 p-l-0 m-t-10">
                  <input type="text" value="1" class="form-control">
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-lg-offset-1">
              <span class="sum calendar-ico clearfix">
                <strong>Monat</strong>
                <div class="col-lg-9 p-l-0 m-t-10">
                  <input type="text" value="9" class="form-control">
                </div>
              </span>
            </div>
            <div class="col-lg-3 col-lg-offset-1 custom-school-row">
              <span class="sum clearfix">
                <strong>Fortbildungskosten</strong>
                <span>€2250,00</span>
              </span>
            </div>
            <div class="col-lg-2 col-lg-offset-1">
              <span class="sum">
                <strong>Regiekosten</strong>
                <span>€ 11500,00</span>
              </span>
            </div>
          </div>
          <h4>Theodor-Haubach-Schule (IIS) (07K04)</h4>
          <hr>
          <div class="form-group clearfix school-row">
            <div class="col-lg-2 custom-school-row">
              <div class="sum rate-ico clearfix">
                <strong>Stellenanteil</strong>
                <div class="col-lg-9 p-l-0 m-t-10">
                  <input type="text" value="0.5" class="form-control">
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-lg-offset-1">
              <span class="sum calendar-ico clearfix">
                <strong>Monat</strong>
                <div class="col-lg-9 p-l-0 m-t-10">
                  <input type="text" value="9" class="form-control">
                </div>
              </span>
            </div>
            <div class="col-lg-3 col-lg-offset-1 custom-school-row">
              <span class="sum clearfix">
                <strong>Fortbildungskosten</strong>
                <span>€1125,00</span>
              </span>
            </div>
            <div class="col-lg-2 col-lg-offset-1">
              <span class="sum">
                <strong>Regiekosten</strong>
                <span>€ 11500,00</span>
              </span>
            </div>
          </div>
          <h4>Sshule am Rathaus (ISS) (11K06)</h4>
          <hr>
          <div class="form-group clearfix school-row">
            <div class="col-lg-2 custom-school-row">
              <div class="sum rate-ico clearfix">
                <strong>Stellenanteil</strong>
                <div class="col-lg-9 p-l-0 m-t-10">
                  <input type="text" value="0.75" class="form-control">
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-lg-offset-1">
              <span class="sum calendar-ico clearfix">
                <strong>Monat</strong>
                <div class="col-lg-9 p-l-0 m-t-10">
                  <input type="text" value="9" class="form-control">
                </div>
              </span>
            </div>
            <div class="col-lg-3 col-lg-offset-1 custom-school-row">
              <span class="sum clearfix">
                <strong>Fortbildungskosten</strong>
                <span>€1125,00</span>
              </span>
            </div>
            <div class="col-lg-2 col-lg-offset-1">
              <span class="sum">
                <strong>Regiekosten</strong>
                <span>€ 10500,00</span>
              </span>
            </div>
          </div>
        </div>
        <div class="m-b-30">
          <div class="row m-b-15">
            <h3 class="panel-title title-custom col-lg-6">
              Berufsgenossenschaftsbeiträge
            </h3>
            <div class="col-lg-6 btn-row">
              <button class="btn w-xs pull-right">Berufsgenossenschaft hinzufügen</button>
            </div>
          </div>

          <hr />
          <div class="row form-horizontal m-b-15">
            <label class="col-lg-1 control-label">
              Name
            </label>
            <div class="col-lg-7">
              <input class="form-control" type="text" value="Name von Berufsgenossenschaft 1">
            </div>
            <label class="col-lg-1 control-label">
              Beitrag
            </label>
            <div class="col-lg-2">
              <input class="form-control" type="text" value="1800,00">
            </div>
            <div class="col-lg-1 p-0 custom-col-1 m-t-5">
              <span class="symbol">€</span>
            </div>
            <div class="col-lg-1 custom-col-1 m-t-5">
              <button class="no-btn" title="Entfernen">
                <i class="ion-close-round"></i>
              </button>
            </div>
          </div>
          <div class="row form-horizontal">
            <label class="col-lg-1 control-label">
              Name
            </label>
            <div class="col-lg-7">
              <input class="form-control" type="text" value="Name von Berufsgenossenschaft 2">
            </div>
            <label class="col-lg-1 control-label">
              Beitrag
            </label>
            <div class="col-lg-2">
              <input class="form-control" type="text" value="1800,00">
            </div>
            <div class="col-lg-1 p-0 custom-col-1 m-t-5">
              <span class="symbol">€</span>
            </div>
            <div class="col-lg-1 custom-col-1 m-t-5">
              <button class="no-btn" title="Entfernen">
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
                    <input class="form-control" type="text" value="Namen Sonstiger Einkommensquellen">
                  </div>
                  <label class="col-lg-1 control-label custom-width-label">
                    Betrag
                  </label>
                  <div class="col-lg-2">
                    <input class="form-control" type="text" value="7500,00">
                  </div>
                  <span class="symbol m-t-5">€</span>
                </div>

              </div>
            </div>
            <div class="holder-total clearfix">
              <div class="col-lg-2 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Personalkosten</strong>
                  <span>€ 33300,00</span>
                </div>
              </div>
              <div class="col-lg-2 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Fortbildungskosten</strong>
                  <span>€ 4500,00</span>
                </div>
              </div>
              <div class="col-lg-2 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Regiekosten</strong>
                  <span>€ 33500,00</span>
                </div>
              </div>
              <div class="col-lg-3 p-r-0">
                <div class="sum money-plus-ico">
                  <strong>Berufsgenossenschaftsbeiträge</strong>
                  <span>€ 7500,00</span>
                </div>
              </div>
              <div class="col-lg-3 p-r-0 custom-col">
                <div class="sum money-minus-ico">
                  <strong>Sonstige Einnahmen</strong>
                  <span>€ 7500,00</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 pull-right">
              <div class="clearfix box-recalculate">
                <div class="col-lg-12 text-center form-custom-box ">
                  <div class="sum total-sum">
                    <strong>Beantragte Fördermittel</strong>
                    <span>€ 71300,00</span>
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
