<div class="panel panel-color panel-primary">
  <div class="panel-heading clearfix">
    <h3 class="m-0 pull-left" ng-if="isInsert">Agentur hinzufügen</h3>
    <h3 class="m-0 pull-left" ng-if="!isInsert && !modeView">Trägerdaten - {{performer.name}}</h3>
    <h3 class="m-0 pull-left" ng-if="!isInsert && modeView">Trägerdaten - {{performer.name}}</h3>
    <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
  </div>

  <form novalidate name="form">
    <uib-tabset active="tabActive">
      <uib-tab index="0" heading="Stammdaten" active="tabs[0].active" ng-click="tabs[0].active = true">
        <div ng-class="isInsert ? 'row' : 'holder-tab'">
          <div ng-class="isInsert || !isFinansist ? 'col-lg-12' : 'col-lg-8'">
            <h3 class="subheading">Allgemeine Information</h3>
            <hr>
            <ng-form name="formPerformer" class="form-horizontal" disable-all="!canEditPerformer() || modeView">
              <div class="address-row">
                <div class="form-group">
                  <label class="col-lg-2 control-label">Name</label>
                  <div class="col-lg-10">
                    <div spi-hint text="_hint.short_name" class="has-hint"></div>
                    <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('formPerformer', 'short_name')}">
                      <input class="form-control" name="short_name" ng-model="performer.short_name" type="text" value="" required ng-disabled="!canEdit()"/>
                      <span ng-class="{hide: !fieldError('formPerformer', 'short_name')}" class="hide">
                        <label ng-show="form.formPerformer.short_name.$error.required" class="error">Name ist erforderlich</label>
                        <label ng-show="error.short_name.dublicate" class="error">Dieser Name existiert bereits</label>
                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-2 control-label">Kurzname</label>
                  <div class="col-lg-10">
                    <div spi-hint text="_hint.name" class="has-hint"></div>
                    <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('formPerformer', 'name')}">
                      <input class="form-control" name="name" ng-model="performer.name" type="text" value="" required ng-disabled="!canEdit()">
                      <span ng-class="{hide: !fieldError('formPerformer', 'name')}" class="hide">
                        <label ng-show="formPerformer.name.$error.required" class="error">Kurzname ist erforderlich</label>
                        <label ng-show="error.name.dublicate" class="error">This Kurzname already exists</label>
                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row address-row">
                <div class="col-lg-6">
                  <div class="form-group" ng-if="!(modeView && !performer.address)">
                    <label class="col-lg-4 control-label">Adresse</label>
                    <div class="col-lg-8">
                      <div spi-hint text="_hint.address" class="has-hint"></div>
                      <div class="wrap-hint">
                        <textarea name="address" ng-model="performer.address" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" ng-if="!(modeView && !performer.plz)">
                    <label class="col-lg-4 control-label">PLZ</label>
                    <div class="col-lg-8">
                      <div spi-hint text="_hint.plz" class="has-hint"></div>
                      <div class="wrap-hint">
                        <input class="form-control" name="plz" ng-model="performer.plz" type="text" value=""/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" ng-if="!(modeView && !performer.city)">
                    <label class="col-lg-4 control-label">Stadt</label>
                    <div class="col-lg-8">
                      <div spi-hint text="_hint.city" class="has-hint"></div>
                      <div class="wrap-hint">
                        <input class="form-control" name="city" ng-model="performer.city" type="text" value=""/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-5 col-lg-offset-1">
                  <div class="form-group" ng-if="!(modeView && !performer.phone)">
                    <label class="col-lg-3 control-label">Telefon</label>
                    <div class="col-lg-9">
                      <div spi-hint text="_hint.phone" class="has-hint"></div>
                      <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('formPerformer', 'phone')}">
                        <input name="phone" ng-model="performer.phone" type="text" value="" class="form-control" ng-pattern="/^[^A-Za-z]*$/">
                        <span ng-class="{hide: !fieldError('formPerformer', 'phone')}" class="hide">
                          <label ng-show="form.formPerformer.phone.$error.pattern" class="error">Telefon must not contain letters</label>
                          <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" ng-if="!(modeView && !performer.fax)">
                    <label class="col-lg-3 control-label">Fax</label>
                    <div class="col-lg-9">
                      <div spi-hint text="_hint.fax" class="has-hint"></div>
                      <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('formPerformer', 'fax')}">
                        <input class="form-control" name="fax" ng-model="performer.fax" type="text" value="" ng-pattern="/^[^A-Za-z]*$/" />
                        <span ng-class="{hide: !fieldError('formPerformer', 'fax')}" class="hide">
                          <label ng-show="form.formPerformer.fax.$error.pattern" class="error">Fax must not contain letters</label>
                          <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" ng-if="!(modeView && !performer.email)">
                    <label class="col-lg-3 control-label">Email</label>
                    <div class="col-lg-9">
                      <div spi-hint text="_hint.email" class="has-hint"></div>
                      <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('formPerformer', 'email')}">
                        <input class="form-control" name="email" ng-model="performer.email" type="email" value=""/>
                        <span ng-class="{hide: !fieldError('formPerformer', 'email')}" class="hide">
                          <label ng-show="form.formPerformer.email.$error.email" class="error">Geben Sie eine gültige E-Mail</label>
                          <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" ng-if="!(modeView && !performer.homepage)">
                    <label class="col-lg-3 control-label">Webseite</label>
                    <div class="col-lg-9">
                      <div spi-hint text="_hint.homepage" class="has-hint"></div>
                      <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('formPerformer', 'homepage')}">
                        <input class="form-control" name="homepage" ng-model="performer.homepage" type="text" ng-pattern="/^((https?|ftp)\:\/\/)?([a-zA-Z0-9]{1})((\.[a-zA-Z0-9-])|([a-zA-Z0-9-]))*\.([a-zA-Z]{2,6})(\/?)$/" value=""/>
                        <span ng-class="{hide: !fieldError('formPerformer', 'homepage')}" class="hide">
                          <label ng-show="form.formPerformer.homepage.$error.pattern" class="error">Geben Sie eine gültige Website</label>
                          <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr/>
              <div class="row holder-three-blocks" ng-if="!isInsert">
                <div class="col-lg-6">
                  <h4>Ansprechpartner(in)</h4>
                  <span ng-if="(!canEdit() && !isFinansist) || modeView" ng-bind="representativeUser.name || '-'"></span>
                  <span spi-hint text="_hint.representative_user_id" class="{{(canEdit() || isFinansist) && !modeView ? 'has-hint' : ''}}"></span>
                  <div class="wrap-hint" ng-if="(canEdit() || isFinansist) && !modeView">
                    <ui-select ng-disabled="!$select.items.length" ng-change="changeRepresentativeUser(performer.representative_user_id)" ng-model="performer.representative_user_id" name="representative_user_id">
                      <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' :'(Nicht ausgewählt)'}}">{{$select.selected.name}}</ui-select-match>
                      <ui-select-choices repeat="item.id as item in users | filter: $select.search">
                        <span ng-bind-html="item.name | highlight: $select.search"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>

                </div>
                <div class="col-lg-5 col-lg-offset-1 holder-has-email">
                  <dl ng-if="representativeUser">
                    <dt>Funktion</dt>
                    <dd ng-bind="representativeUser.function || '-'"></dd>
                    <dt>Titel</dt>
                    <dd ng-bind="representativeUser.title || '-'"></dd>
                    <dt>Telefon</dt>
                    <dd ng-bind="(representativeUser.phone) || '-'"></dd>
                    <dt>Email</dt>
                    <dd class="truncate-email"><span ng-bind="representativeUser.email || '-'"></span><i uib-tooltip="{{representativeUser.email}}" tooltip-trigger="outsideClick" class="fa fa-info-circle"></i></dd>
                  </dl>
                </div>
              </div>
            </ng-form>
          </div>
          <div class="col-lg-4" ng-if="!isInsert && isFinansist">
            <div class="heading-button clearfix m-b-15">
              <h3 class="subheading pull-left">Bankverbindungen</h3>
              <button ng-if="!modeView && (!bank_details.length || bank_details[0].id)" ng-click="addBankForm()" class="btn w-md custom-btn pull-right" type="button">Neu</button>
            </div>
            <div class="holder-bank-details" ng-class="{'has-few-block': bank_details.length > 1}">
              <div class="form-custom-box bank-details" ng-repeat="bank in bank_details">
                <ng-form id="formBank{{$index}}" name="formBank{{$index}}" class="form-horizontal" disable-all="!canEditBankInfo() || modeView">
                  <div class="heading-bank clearfix m-b-15">
                    <h4 class="pull-left">Bankverbindungen</h4>
                    <!-- <button class="btn btn-icon btn-danger btn-sm pull-right"><i class="fa fa-trash-o"></i></button> -->
                  </div>
                  <div class="form-group">
                    <label class="col-lg-5 p-r-0 control-label">Kontoinhaber</label>
                    <div class="col-lg-7">
                      <div spi-hint text="_hint.contact_person" class="has-hint"></div>
                      <div class="wrap-hint">
                        <input class="form-control" name="contact_person" ng-model="bank.contact_person" type="text" value=""/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-5 p-r-0 control-label">IBAN</label>
                    <div class="col-lg-7">
                      <div spi-hint text="_hint.iban" class="has-hint"></div>
                      <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('formBank{{$index}}', 'iban')}">
                        <input class="form-control" name="iban" ng-iban="DE" ng-model="bank.iban" type="text" value="" ng-required="1" maxlength="34"/>
                        <span ng-class="{hide: !fieldError('formBank{{$index}}', 'iban')}" class="hide">
                          <label ng-show="form.formBank{{$index}}.iban.$error.required" class="error">IBAN ist erforderlich</label>
                          <label ng-show="form.formBank{{$index}}.iban.$error.iban" class="error">IBAN scheint nicht wirklich zu sein.</label>
                          <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-5 p-r-0 control-label">Kreditor</label>
                    <div class="col-lg-7">
                      <div spi-hint text="_hint.bank_name" class="has-hint"></div>
                      <div class="wrap-hint">
                        <input class="form-control" type="text" name="bank_name" ng-model="bank.bank_name" value=""/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-5 p-r-0 control-label">Konto</label>
                    <div class="col-lg-7">
                      <div spi-hint text="_hint.outer_id" class="has-hint"></div>
                      <div class="wrap-hint">
                        <input class="form-control" type="text" name="outer_id" ng-model="bank.outer_id" value=""/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-5 p-r-0 control-label">Beschreibung</label>
                    <div class="col-lg-7">
                      <div spi-hint text="_hint.description" class="has-hint"></div>
                      <div class="wrap-hint">
                        <textarea name="description" ng-model="bank.description" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix" ng-if="!modeView">
                    <button class="btn pull-right w-sm custom-btn" ng-if="canEditBankInfo()" ng-click="saveBankDetails(bank, $index)">Hinzufügen</button>
                    <button class="btn pull-right w-sm cancel-btn" ng-if="canEditBankInfo()" ng-click="removeBankDetails(bank, $index)">Löschen</button>
                  </div>
                </ng-form>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="group-btn clearfix m-t-20">
          <div class="pull-left" ng-if="!isInsert && canDelete() && !modeView">
            <button ng-click="remove()" class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"><i class="fa fa-trash-o"></i></button>
          </div>
          <div class="pull-right">
            <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
            <button class="btn w-lg custom-btn" ng-if="canEditPerformer() && !modeView" ng-click="submitFormPerformer()">Speichern</button>
          </div>
        </div>
      </uib-tab>

      <uib-tab index="1" heading="Profil" active="tabs[1].active" ng-click="tabs[1].active = true">
        <div class="holder-tab" id="profile">
          <div class="panel-body">
            <span disable-all="!canEditPerformer() || modeView">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Selbstdarstellung</label>
                  <div class="holder-textarea">
                    <div spi-hint text="_hint.company_overview" class="has-hint"></div>
                    <div class="wrap-hint">
                      <textarea ng-focus="isTextareaShow = true" spi-on-focus-large spi-save="textareaSave" spi-cancel="textareaHide" spi-callback="saveText('company_overview')" name="company_overview" ng-model="performer.company_overview" class="form-control animate-textarea textarea-1" placeholder="Tragen Sie den Text hier ein"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Diversity: GM, CM, Inklusion</label>
                  <div class="holder-textarea">
                    <div spi-hint text="_hint.diversity" class="has-hint"></div>
                    <div class="wrap-hint">
                      <textarea ng-focus="isTextareaShow = true" spi-on-focus-large spi-save="textareaSave" spi-cancel="textareaHide" spi-callback="saveText('diversity')" name="diversity" ng-model="performer.diversity" class="form-control animate-textarea textarea-2" placeholder="Tragen Sie den Text hier ein"></textarea>
                    </div>
                  </div>
                </div>
                <div class="clearfix m-t-40" ng-if="!isInsert && isFinansist">
                  <div class="heading pull-left">
                    <h3 class="m-0">Dokumente</h3>
                    <label>Sie können PDF- und DOC-Dateien hochladen<br/> (10 Mb Größenbeschränkung)</label>
                  </div>
                  <div ng-if="documents.length < 5 && canEditPerformer()" qq-file-upload setting="qqSetting"></div>
                </div>
                <div class="form-custom-box clearfix m-0 upload-box" ng-if="!isInsert && documents.length">
                  <ul class="list-unstyled">
                    <li ng-repeat="doc in documents"><i class="ion-document-text "></i><a target="_blank" class="document-link" href="{{doc.href}}" ng-bind="doc.name"></a><a class="sweet-4" ng-click="removeDocument(doc.id)" href=""><i ng-if="canEditPerformer()" class="ion-close"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6 clearfix">
                <div class="form-group">
                  <label>Fortbildung</label>
                  <div class="holder-textarea">
                    <div spi-hint text="_hint.further_education" class="has-hint"></div>
                    <div class="wrap-hint">
                      <textarea ng-focus="isTextareaShow = true" spi-on-focus-large spi-save="textareaSave" spi-cancel="textareaHide" spi-callback="saveText('further_education')" name="further_education" ng-model="performer.further_education" class="form-control animate-textarea textarea-3" placeholder="Tragen Sie den Text hier ein"></textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Qualitätsstandards</label>
                  <div class="holder-textarea">
                    <div spi-hint text="_hint.quality_standards" class="has-hint"></div>
                    <div class="wrap-hint">
                      <textarea ng-focus="isTextareaShow = true" spi-on-focus-large spi-save="textareaSave" spi-cancel="textareaHide" spi-callback="saveText('quality_standards')" name="quality_standards" ng-model="performer.quality_standards" class="form-control animate-textarea textarea-4" placeholder="Tragen Sie den Text hier ein"></textarea>
                    </div>
                  </div>
                </div>
                <div class="clearfix m-t-40" ng-if="canEdit()">
                  <h3 class="m-0">Interner Vermerk</h3>
                  <label>Sie können eine Nachricht für PA hinterlassen </label>
                </div>
                <div class="form-group" ng-if="canEdit()">
                  <div spi-hint text="_hint.comment" class="has-hint"></div>
                  <div class="wrap-hint">
                    <textarea name="comment" ng-model="performer.comment" class="form-control custom-height" placeholder="Tragen Sie den Text hier ein"></textarea>
                  </div>
                </div>
                <div class="form-custom-box clearfix m-0" ng-if="canEdit()">
                  <div class="pull-left">
                    <label class="control-label">Information ist überprüft und korrekt</label><br/>
                    <span class="checked-person" ng-if="checkedBy">Überpüft von {{checkedBy}} {{checkedDate}}</span>
                  </div>
                  <div class="pull-right m-t-10">
                    <span ng-if="modeView" ng-bind="performer.is_checked == 1 ? 'JA' : 'NEIN'"></span>
                    <div class="btn-group btn-toggle" ng-if="!modeView">
                      <button class="btn btn-sm" ng-class="performer.is_checked == 1 ? 'active' : 'btn-default'" ng-model="performer.is_checked" uib-btn-radio="1">JA</button>
                      <button class="btn btn-sm" ng-class="performer.is_checked == 0 ? 'active' : 'btn-default'" ng-model="performer.is_checked" uib-btn-radio="0">NEIN</button>
                    </div>
                  </div>
                </div>
              </div>
            </span>
          </div>
        </div>
        <div class="clearfix" ng-show="isTextareaShow"><div class="col-lg-4 col-lg-offset-8 text-right button-textarea">
            <button class="btn w-lg ng-scope" ng-click="textareaHide = !textareaHide; isTextareaShow = false">Löschen</button>
            <button class="btn w-lg cancel-btn custom-btn" ng-click="textareaSave = !textareaSave; isTextareaShow = false">Hinzufügen</button>
          </div>
        </div>
        <hr>
        <div class="group-btn clearfix m-t-20">
          <div class="pull-left" ng-if="!isInsert && canDelete() && !modeView">
            <button ng-click="remove()" class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa fa-trash-o"></i></button>
          </div>
          <div class="pull-right">
            <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
            <button class="btn w-lg custom-btn" ng-if="canEditPerformer() && !modeView" ng-click="submitFormPerformer()">Speichern</button>
          </div>
        </div>
      </uib-tab>
      <uib-tab index="2" heading="Benutzer" ng-if="!isInsert" ng-init="page = 't'; relationId = performerId" ng-if="canView('user')">
        <div class="holder-tab" ng-controller="UserController">
          <div class="panel-body edit-user agency-tab-user">
            <div>
              <div class="col-lg-12">
                <div class="row datafilter">
                  <ng-form class="class-form">
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label>Suche nach Name, Benutzername oder Email</label>
                        <input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Stichwort eingegeben">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label>Benutzerrollen</label>
                        <ui-select ng-change="updateGrid()" ng-model="filter.type_id" theme="select2">
                          <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in userTypes | filter: $select.search">
                            <span ng-bind-html="item.name | highlight: $select.search"></span>
                          </ui-select-choices>
                        </ui-select>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label>Status</label>
                        <ui-select append-to-body="true" ng-change="updateGrid()" class="" ng-model="filter.is_active" theme="select2">
                          <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in statuses | filter: $select.search">
                            <span ng-bind-html="item.name | highlight: $select.search"></span>
                          </ui-select-choices>
                        </ui-select>
                      </div>
                    </div>
                    <div class="col-lg-2 reset-btn-width">
                      <button ng-click="resetFilter()" class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                    </div>
                  </ng-form>
                </div>
                <?php include(Yii::app()->getBasePath() . '/views/site/partials/users-table.php'); ?>
              </div>
            </div>
          </div>
        </div>
      </uib-tab>

      <uib-tab index="3" heading="Projekte" ng-if="!isInsert" ng-init="page = 't'; performerId = performerId">
        <div class="holder-tab" ng-controller="ProjectController">
          <div class="holder-tab">
            <div class="panel-body edit-user">
              <div class="col-lg-12">
                <div class="row datafilter">
                  <form action="#" class="class-form">
                    <div class="col-lg-{{canByType(['d','s','t'])?5:3}}">
                      <div class="form-group">
                        <label>Suche nach Kennziffer</label>
                        <input ng-change="updateGrid()" ng-model="filter.code" type="search" class="form-control" placeholder="Stichwort eingegeben">
                      </div>
                    </div>
                    <div class="col-lg-2 col-width-type">
                      <div class="form-group">
                        <label>Typ</label>
<!--                                            <select class="type-user form-control">
                            <option>Alles anzeigen</option>
                        </select>-->
                        <ui-select ng-change="updateGrid()" ng-model="filter.school_type_id">
                          <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search">
                            <span ng-bind-html="item.name | highlight: $select.search"></span>
                          </ui-select-choices>
                        </ui-select>
                      </div>
                    </div>
                    <div class="col-lg-2 col-width-type" ng-if="!canByType(['d'])">
                      <div class="form-group">
                        <label>Bezirk</label>
<!--                                            <select class="type-user form-control">
                            <option>Alles anzeigen</option>
                        </select>-->
                        <ui-select ng-change="updateGrid()" ng-model="filter.district_id">
                          <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in districts | filter: $select.search">
                            <span ng-bind-html="item.name | highlight: $select.search"></span>
                          </ui-select-choices>
                        </ui-select>
                      </div>
                    </div>
                    <div class="col-lg-2" ng-if="!canByType(['s'])">
                      <div class="form-group">
                        <label>Schule</label>
<!--                                            <select class="type-user form-control">
                            <option>Alles anzeigen</option>
                        </select>-->
                        <ui-select ng-change="updateGrid()" ng-model="filter.school_id">
                          <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in schools | filter: $select.search">
                            <span ng-bind-html="item.name | highlight: $select.search"></span>
                          </ui-select-choices>
                        </ui-select>
                      </div>
                    </div>
<!--                    <div class="col-lg-2" ng-if="!canByType(['t'])">
                      <div class="form-group">
                        <label>Träger</label>
                        <ui-select ng-change="updateGrid()" ng-model="filter.performer_id">
                          <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in performers | filter: $select.search">
                            <span ng-bind-html="item.name | highlight: $select.search"></span>
                          </ui-select-choices>
                        </ui-select>
                                            <select class="type-user form-control">
                            <option>Alles anzeigen</option>
                        </select>
                      </div>
                    </div>-->
                    <div class="col-lg-2 reset-btn-width">
                      <button class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                    </div>
                  </form>
                </div>

                <?php include(Yii::app()->getBasePath().'/views/site/partials/project-table.php'); ?>
                <script type="text/ng-template" id="editProjectTemplate.html">
                  <?php include(Yii::app()->getBasePath().'/views/site/partials/project-editor.php'); ?>
                </script>
                
              </div>
            </div>
          </div>
        </div>
      </uib-tab>

    </uib-tabset>
  </form>
</div>