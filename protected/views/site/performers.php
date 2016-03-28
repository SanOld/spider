<?php
$this->pageTitle = 'Träger | ' . Yii::app()->name;
$this->breadcrumbs = array('Träger');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/performers.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

<div ng-controller="PerformerController" ng-cloak class="wraper container-fluid">
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main title="_hint.header.title" text="_hint.header.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Träger</h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
						<!--<button class="btn w-lg custom-btn" ng-if="canCreate()" ng-click="openEdit()">Träger hinzufügen</button>-->
					</div>
				</div>
				<div class="panel-body agency-edit">
					<div class="row datafilter">
						<form>
							<div class="col-lg-5">
								<div class="form-group">
									<label>Suche nach Adresse, Ansprechpartner oder Email</label>
									<input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Eingegeben">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<div class="form-group">
										<label>Suche nach Bankverbindung</label>
										<input ng-change="updateGrid()" type="search" ng-model="filter.bank_details" class="form-control" placeholder="Eingegeben">
									</div>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<div class="form-group">
										<label>Überprüft</label>
										<ui-select ng-change="updateGrid()" class="" ng-model="filter.is_checked">
											<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
											<ui-select-choices repeat="item.id as item in checks | filter: $select.search">
												<span ng-bind-html="item.name | highlight: $select.search"></span>
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
					<div class="row">
						<div class="col-lg-12">
							<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
								<tr ng-repeat="row in $data" ng-class="{'disable': !+row.is_checked}">
									<td data-title="'Name'" sortable="'name'">{{row.name}}</td>
									<td data-title="'Adresse'" sortable="'address'">{{row.address}}</td>
									<td data-title="'Ansprechpartner(in)'" sortable="'representative_user'">{{row.representative_user}}</td>
									<td data-title="'Email'" sortable="'email'"><a href="mailto:{{row.email}}">{{row.email}}</a></td>
									<td data-title="'Telefon'" sortable="'phone'">{{row.phone}}</td>
									<td data-title="'Überprüft'" sortable="'is_checked'" class="text-center">
										<i ng-if="+row.is_checked" class="ion-checkmark"></i>
										<span ng-if="!+row.is_checked">-</span>
									</td>
                  <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                    <a class="btn center-block edit-btn" ng-click="openEdit(row, !canEdit(row.id))">
                      <i class="ion-eye"  ng-if="!canEdit(row.id)"></i>
                      <i class="ion-edit" ng-if="canEdit(row.id)"></i>
                    </a>
                  </td>
								</tr>
							</table>
						</div>
					</div>
					<div class="notice">
						<span class="color-notice"></span>
						Nicht überprüfte Agenturen
					</div>
				</div>
			</div>
		</div>
	</div> <!-- End Row -->
</div>


<script type="text/ng-template" id="editTemplate.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left" ng-if="isInsert">Agentur hinzufügen</h3>
			<h3 class="m-0 pull-left" ng-if="!isInsert && !modeView">Trägerdaten - {{performer.name}}</h3>
			<h3 class="m-0 pull-left" ng-if="!isInsert && modeView">Trägerdaten - {{performer.name}}</h3>
			<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
		</div>

			<form novalidate name="form">
			<uib-tabset>
              <uib-tab heading="Stammdaten" active="tabs[0].active" ng-click="tabs[0].active = true">
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
                              <span ng-show="fieldError('formPerformer', 'short_name')">
                                <label ng-show="form.formPerformer.short_name.$error.required" class="error">Name is required</label>
                                <label ng-show="error.short_name.dublicate" class="error">This Name already exists</label>
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
                              <span ng-show="fieldError('formPerformer', 'name')">
                                <label ng-show="formPerformer.name.$error.required" class="error">Kurzname is required</label>
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
                                <span ng-show="fieldError('formPerformer', 'phone')">
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
                                <span ng-show="fieldError('formPerformer', 'fax')">
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
                                <span ng-show="fieldError('formPerformer', 'email')">
                                  <label ng-show="form.formPerformer.email.$error.email" class="error">Enter a valid email</label>
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
                                <input class="form-control" name="homepage" ng-model="performer.homepage" type="text" ng-pattern="/^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$/" value=""/>
                                <span ng-show="fieldError('formPerformer', 'homepage')">
                                  <label ng-show="form.formPerformer.homepage.$error.pattern" class="error">Enter a valid webseite</label>
                                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row holder-three-blocks" ng-if="!isInsert">
                        <div class="col-lg-4">
                          <h4>Vertretungsberechtigte Person</h4>
                          <div spi-hint text="_hint.representative_user_id" class="has-hint"></div>
                          <span ng-if="!canEdit() || modeView" ng-bind="representativeUser.name || '-'"></span>
                          <div class="wrap-hint" ng-if="canEdit() && !modeView">
                            <ui-select ng-disabled="!$select.items.length" ng-change="changeRepresentativeUser(performer.representative_user_id)" ng-model="performer.representative_user_id" name="representative_user_id">
                              <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(No chosen)'}}">{{$select.selected.name}}</ui-select-match>
                              <ui-select-choices repeat="item.id as item in users | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
                          <dl ng-if="representativeUser">
                            <dt>Funktion</dt>
                            <dd ng-bind="representativeUser.function || '-'"></dd>
                            <dt>Titel</dt>
                            <dd ng-bind="representativeUser.title || '-'"></dd>
                            <dt>Telefon</dt>
                            <dd ng-bind="(representativeUser.phone) || '-'"></dd>
                            <dt>Email</dt>
                            <dd ng-bind="representativeUser.email || '-'"></dd>
                          </dl>
                        </div>
                        <div class="col-lg-4">
                          <h4>Ansprechperson für Antragsbearbeitung</h4>
                          <div spi-hint text="_hint.application_processing_user_id" class="has-hint"></div>
                          <span ng-if="!canEdit() || modeView" ng-bind="applicationProcessingUser.name || '-'"></span>
                          <div class="wrap-hint" ng-if="canEdit() && !modeView">
                            <ui-select ng-disabled="!$select.items.length" ng-change="changeApplicationProcessingUser(performer.application_processing_user_id)" ng-model="performer.application_processing_user_id" theme="select2" name="application_processing_user_id">
                              <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(No chosen)'}}">{{$select.selected.name}}</ui-select-match>
                              <ui-select-choices repeat="item.id as item in users | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
                          <dl ng-if="applicationProcessingUser">
                            <dt>Funktion</dt>
                            <dd ng-bind="applicationProcessingUser.function || '-'"></dd>
                            <dt>Titel</dt>
                            <dd ng-bind="applicationProcessingUser.title || '-'"></dd>
                            <dt>Telefon</dt>
                            <dd ng-bind="(applicationProcessingUser.phone) || '-'"></dd>
                            <dt>Email</dt>
                            <dd ng-bind="applicationProcessingUser.email || '-'"></dd>
                          </dl>
                        </div>
                        <div class="col-lg-4">
                          <h4>Ansprechperson für die Finanzplanbearbeitung</h4>
                          <div spi-hint text="_hint.budget_processing_user_id" class="has-hint"></div>
                          <span ng-if="!canEdit() || modeView" ng-bind="budgetProcessingUser.name || '-'"></span>
                          <div class="wrap-hint" ng-if="canEdit() && !modeView">
                            <ui-select ng-disabled="!$select.items.length" ng-change="changeBudgetProcessingUser(performer.budget_processing_user_id)" append-to-body="true" ng-model="performer.budget_processing_user_id" theme="select2" name="budget_processing_user_id">
                              <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(No chosen)'}}">{{$select.selected.name}}</ui-select-match>
                              <ui-select-choices repeat="item.id as item in financeUsers | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
                          <dl ng-if="budgetProcessingUser">
                            <dt>Funktion</dt>
                            <dd ng-bind="budgetProcessingUser.function || '-'"></dd>
                            <dt>Titel</dt>
                            <dd ng-bind="budgetProcessingUser.title || '-'"></dd>
                            <dt>Telefon</dt>
                            <dd ng-bind="(budgetProcessingUser.phone) || '-'"></dd>
                            <dt>Email</dt>
                            <dd ng-bind="budgetProcessingUser.email || '-'"></dd>
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
                                <span ng-show="fieldError('formBank{{$index}}', 'iban')">
                                  <label ng-show="form.formBank{{$index}}.iban.$error.required" class="error">IBAN is required</label>
                                  <label ng-show="form.formBank{{$index}}.iban.$error.iban" class="error">It doesn't seems real IBAN</label>
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

				<uib-tab heading="Profil" active="tabs[1].active" ng-click="tabs[1].active = true">
					<div class="holder-tab">
						<div class="panel-body">
              <span disable-all="!canEditPerformer() || modeView">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Selbstdarstellung</label>
									<div class="holder-textarea">
                    <div spi-hint text="_hint.company_overview" class="has-hint"></div>
                    <div class="wrap-hint">
										  <textarea name="company_overview" ng-model="performer.company_overview" class="form-control animate-textarea textarea-1" placeholder="Tragen Sie den Text hier ein"></textarea>
                    </div>
                  </div>
								</div>
								<div class="form-group">
									<label>Diversity: GM, CM, Inklusion</label>
									<div class="holder-textarea">
                    <div spi-hint text="_hint.diversity" class="has-hint"></div>
                    <div class="wrap-hint">
										  <textarea name="diversity" ng-model="performer.diversity" class="form-control animate-textarea textarea-2" placeholder="Tragen Sie den Text hier ein"></textarea>
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
										  <textarea name="further_education" ng-model="performer.further_education" class="form-control animate-textarea textarea-3" placeholder="Tragen Sie den Text hier ein"></textarea>
									  </div>
									</div>
								</div>
								<div class="form-group">
									<label>Qualitätsstandards</label>
									<div class="holder-textarea">
                    <div spi-hint text="_hint.quality_standards" class="has-hint"></div>
                    <div class="wrap-hint">
										  <textarea name="quality_standards" ng-model="performer.quality_standards" class="form-control animate-textarea textarea-4" placeholder="Tragen Sie den Text hier ein"></textarea>
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
<!--
        <uib-tab heading="Anträge (mockup)" ng-if="!isInsert">
          <div class="holder-tab">
            <div class="holder-tab">
              <div class="panel-body request-edit">
                <div class="datafilter clearfix">
                  <form action="#">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <div class="form-group">
                          <label>Antragstyp</label>
                          <select class="form-control">
                            <option>Alles anzeigen</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <div class="form-group">
                          <label>Jahr</label>
                          <select class="form-control">
                            <option>2015</option>
                            <option>2016</option>
                            <option>2017</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <div class="form-group">
                          <label>Status</label>
                          <select class="form-control">
                            <option>Akzeptabel</option>
                            <option>Öffnen</option>
                            <option>In Progress</option>
                            <option>Akzeptiert</option>
                            <option>Ablehnen </option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="form-group">
                        <div class="form-group">
                          <label>Finanzierung</label>
                          <select class="form-control">
                            <option>Alles anzeigen</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-2 reset-btn-width">
                      <button class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                    </div>
                  </form>
                </div>
                <div>
                  <div class="col-lg-12">
                    <table id="datatable" class="table table-hover table-bordered table-edit">
                      <thead>
                      <tr class="head-top">
                        <th>Kennziffer</th>
                        <th>Jahr</th>
                        <th>Status</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Abgabe</th>
                        <th>Letzte Änd.</th>
                        <th>Ansicht</th>
                      </tr>
                      <tr>
                        <th>Kennziffer</th>
                        <th>Jahr</th>
                        <th>Status</th>
                        <th colspan="3">Beanst.</th>
                        <th>Abgabe</th>
                        <th>Letzte Änd.</th>
                        <th>Ansicht</th>
                      </tr>

                      </thead>

                      <tbody>
                      <tr class="acceptable-row">
                        <td><a href="order.php">K026</a></td>
                        <td>2016</td>
                        <td>Förderfähig</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>
                          <a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="order.php">G053</a></td>
                        <td>2016</td>
                        <td>Unbearbeitet</td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
                            <span class="cell-finplan select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
                            <span class="cell-concept select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
                            <span class="cell-school"></span>
                          </a>
                        </td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>

                        </td>
                      </tr>
                      <tr>
                        <td><a href="order.php">K026</a></td>
                        <td>2016</td>
                        <td>Unbearbeitet</td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
                            <span class="cell-finplan select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
                            <span class="cell-concept select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
                            <span class="cell-school"></span>
                          </a>
                        </td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>

                        </td>
                      </tr>
                      <tr>
                        <td><a href="order.php">G053</a></td>
                        <td>2016</td>
                        <td>Unbearbeitet</td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
                            <span class="cell-finplan select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
                            <span class="cell-concept select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
                            <span class="cell-school"></span>
                          </a>
                        </td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>

                        </td>
                      </tr>
                      <tr class="acceptable-row">
                        <td><a href="order.php">K026</a></td>
                        <td>2016</td>
                        <td>Förderfähig</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>
                          <a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>

                        </td>
                      </tr>
                      <tr class="inprogress-row">
                        <td><a href="order.php">G053</a></td>
                        <td>2016</td>
                        <td>Bitte Bearbeiten</td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
                            <span class="cell-finplan select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
                            <span class="cell-concept select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
                            <span class="cell-school"></span>
                          </a>
                        </td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>

                        </td>
                      </tr>
                      <tr class="acceptable-row">
                        <td><a href="order.php">K026</a></td>
                        <td>2016</td>
                        <td>Förderfähig</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>
                          <a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>

                        </td>
                      </tr>
                      <tr class="accept-row">
                        <td><a href="order.php">K026</a></td>
                        <td>2016</td>
                        <td>Genehmigt</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>
                          <a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>

                        </td>
                      </tr>
                      <tr class="decline-row">
                        <td><a href="order.php">G053</a></td>
                        <td>2016</td>
                        <td>Nur Leserecht</td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
                            <span class="cell-finplan select-decline"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
                            <span class="cell-concept select-decline"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
                            <span class="cell-school select-decline"></span>
                          </a>
                        </td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>

                        </td>
                      </tr>
                      <tr class="accept-row">
                        <td><a href="order.php">K026</a></td>
                        <td>2016</td>
                        <td>Genehmigt</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td>
                          <a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>

                        </td>
                      </tr>
                      <tr class="decline-row">
                        <td><a href="order.php">G053</a></td>
                        <td>2016</td>
                        <td>Nur Leserecht</td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
                            <span class="cell-finplan select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
                            <span class="cell-concept select"></span>
                          </a>
                        </td>
                        <td>
                          <a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
                            <span class="cell-school"></span>
                          </a>
                        </td>
                        <td>13.11.2015</td>
                        <td>15.10.2015</td>
                        <td></td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="clearfix m-b-30">
                  <div class="notice">
                    <span class="color-notice open"></span>
                    Unbearbeitet
                  </div>
                  <div class="notice">
                    <span class="color-notice decline-row"></span>
                    Nur Leserecht
                  </div>
                  <div class="notice">
                    <span class="color-notice inprogress-row"></span>
                    Bitte bearbeiten
                  </div>
                  <div class="notice">
                    <span class="color-notice acceptable-row"></span>
                    Förderfähig
                  </div>
                  <div class="notice">
                    <span class="color-notice accept-row"></span>
                    Genehmigt
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
        </uib-tab>-->

				<uib-tab heading="Benutzer" ng-if="!isInsert" ng-init="page = 't'; relationId = performerId" ng-if="canView('user')">
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
									<?php include(Yii::app()->getBasePath().'/views/site/partials/users-table.php'); ?>
								</div>
							</div>
						</div>
					</div>
				</uib-tab>

        <uib-tab heading="Projekte (mockup)" ng-if="!isInsert">
          <div class="holder-tab">
            <div class="holder-tab">
              <div class="panel-body edit-user">
                <div class="col-lg-12">
                  <div class="row datafilter">
                    <form action="#" class="class-form">
                      <div class="col-lg-3 col-width-type">
                        <div class="form-group">
                          <label>Suche nach Kennziffer</label>
                          <input type="search" class="form-control" placeholder="Eingegeben">
                        </div>
                      </div>
                      <div class="col-lg-2 col-width-type">
                        <div class="form-group">
                          <label>Typ</label>
                          <select class="type-user form-control">
                            <option>Alles anzeigen</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3 col-width-type">
                        <div class="form-group">
                          <label>Bezirk</label>
                          <select class="type-user form-control">
                            <option>Alles anzeigen</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Schule</label>
                          <select class="type-user form-control">
                            <option>Alles anzeigen</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-2 reset-btn-width">
                        <button class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                      </div>
                    </form>
                  </div>

                  <table id="datatable" class="table table-hover table-bordered table-edit" data-page-length="10000">
                    <thead>
                    <tr>
                      <th>Kennziffer</th>
                      <th>Bezirk</th>
                      <th>Schule</th>
                      <th>Bearbeiten</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                      <td><a href="#">B026</a></td>
                      <td class="custom-data"><a href="#">Bezirk Neukolln</a></td>
                      <td><a href="#">Pestalozzi-Schule (06S01)</a></td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="#">B053</a></td>
                      <td class="custom-data"><a href="#">Bezirk Pankow</a></td>
                      <td><a href="#">Pestalozzi-Schule (06S01)</a></td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="#">Z026</a></td>
                      <td><a href="#">Lina Morgenstern</a></td>
                      <td class="custom-data"><a href="#">Lina Morgenstern (02K04)</a></td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="#">G053</a></td>
                      <td><a href="#">Bezirk Neukolln</a></td>
                      <td><a href="#">Solling-Schule (ISS) (07K05)</a></td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="#">B026</a></td>
                      <td class="custom-data"><a href="#">Bezirk Neukolln</a></td>
                      <td><a href="#">Solling-Schule (ISS) (07K05)</td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="#">S053</a></td>
                      <td><a href="#">Bezirk Pankow</a></td>
                      <td><a href="#">Biesalski-Schule (06S02)</a></td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="#">K026</a></td>
                      <td><a href="#">Bezirk Pankow</a></td>
                      <td><a href="#">Biesalski-Schule (06S02)</a></td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="#">Z053</a></td>
                      <td><a href="#">Bezirk Neukolln</a></td>
                      <td class="custom-data"><a href="#">Biesalski-Schule (06S02)</a></td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="#">S053</a></td>
                      <td><a href="#">Bezirk Pankow</a></td>
                      <td><a href="#">Biesalski-Schule (06S02)</a></td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="#">S053</a></td>
                      <td><a href="#">Bezirk Pankow</a></td>
                      <td>
                        <a href="#">Solling-Schule (ISS) (07K05)</a><br/>
                        <a href="#">Pestalozzi-Schule (06S01)</a><br/>
                        <a href="#">Biesalski-Schule (06S02)</a>
                      </td>
                      <td>
                        <a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
                          <i class="ion-edit"></i>
                        </a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </uib-tab>

			</uib-tabset>
			</form>
	</div>
</script>
