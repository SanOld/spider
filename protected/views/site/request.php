<?php
$this->pageTitle = 'Anträge | ' . Yii::app()->name;
$this->breadcrumbs = array('Anträge');
?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/diff_match_patch.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/request.js"></script>

<div class="wraper container-fluid" ng-controller="RequestController">
	<div class="row">
		<div class="container center-block request-edit-page">
			<div class="panel panel-default" ng-cloak>
				<div class="panel-heading heading-noborder clearfix">
                  <h1 class="panel-title col-lg-6">Antrag {{requestYear}} <span ng-show="projectID">({{projectID}})</span></h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
					</div>
				</div>



				<uib-tabset class="panel-body request-order-nav" active="tabActive">
					<uib-tab class="project" index="'project-data'" select="setTab('project-data')" heading="Projektdaten">
						<div id="project" class="tab-pane active" ng-controller="RequestProjectDataController">
							<div class="panel-group panel-group-joined m-0">
								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="row">
											<div class="col-lg-8 heading-title">
												<h2 class="panel-title">
													Projekt <strong>{{data.code}}</strong>
												</h2>
												<!--												<p>Gesellschaft für Sport und Jugendsozialarbeit gGmbH (GSJ)</p>-->
											</div>
											<div class="col-lg-4">
												<div class="heading-date">
													<strong>Beginn und Ende der Maßnahme:</strong>
													<div class="holder-head-date custom-dl  m-t-10">
														<i class="fa fa-calendar"></i>
														<div class="wrap-data">
															<div>
																<span>Beginn:</span>
																<em>{{request.start_date_unix | date : 'dd.MM.yyyy'}}</em>
															</div>
															<div>
																<span>Ende:</span>
																<em>{{request.due_date_unix | date : 'dd.MM.yyyy'}} </em>
															</div>
														</div>
														<div class="btn-row">
															<button class="btn m-t-5" ng-click="setBulkDuration()">Dauer ändern</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="panel-body">
										<div class="row">
											<div class="col-lg-12">
												<h3 class="panel-title">
													Träger
                          <span class="btn-row m-l-15">
                            <a class="btn" href="performers#id={{data.performer_id}}" target="_blank" ng-click="setUpdater()" >Bearbeiten</a>
                          </span>
												</h3>
												<hr/>
												<ng-show ng-show="data.performer_id">
													<strong>{{data.performer_name}}</strong>
                                                    <i ng-if="+data.performer_is_checked" class="ion-checkmark"></i>
													<div class="row m-t-20 m-b-30 row-holder-dl">
														<div class="col-lg-12 m-b-0">
															<dl class="custom-dl">
																<ng-show ng-show="data.performer_contact">
																	<dt>Ansprechpartner(in):</dt>
																	<dd>{{data.performer_contact}}</dd>
																</ng-show>
																<ng-show ng-show="data.performer_contact_function">
																	<dt>Funktion:</dt>
																	<dd>{{data.performer_contact_function}}</dd>
																</ng-show>
															</dl>
														</div>
														<div class="col-lg-6">
															<dl class="custom-dl">
																<ng-show ng-show="data.performer_address">
																	<dt>Adresse:</dt>
																	<dd>{{data.performer_address}}</dd>
																</ng-show>
																<ng-show ng-show="data.performer_plz">
																	<dt>PLZ:</dt>
																	<dd>{{data.performer_plz}}</dd>
																</ng-show>
																<ng-show ng-show="data.performer_city">
																	<dt>Stadt:</dt>
																	<dd>{{data.performer_city}}</dd>
																</ng-show>
																<ng-show ng-show="data.performer_homepage">
																	<dt>Webseite:</dt>
																	<dd><a target="_blank" href="http://{{data.performer_homepage}}">{{data.performer_homepage}}</a></dd>
																</ng-show>
															</dl>
														</div>
														<div class="col-lg-5">
															<dl class="custom-dl">
																<ng-show ng-show="data.performer_phone">
																	<dt>Telefon:</dt>
																	<dd>{{data.performer_phone}}</dd>
																</ng-show>
																<ng-show ng-show="data.performer_fax">
																	<dt>Fax:</dt>
																	<dd>{{data.performer_fax}}</dd>
																</ng-show>
																<ng-show ng-show="data.performer_email">
																	<dt>Email:</dt>
																	<dd><a href="mailto:them@stiftungs-spi.de">{{data.performer_email}}</a></dd>
																</ng-show>
															</dl>
														</div>
													</div>
												</ng-show>
											</div>
										</div>
										<h3 class="panel-title m-b-15">
											Schule{{data.schools.length > 1?'n':''}}
										</h3>
										<div id="accordion-project" class="panel-group panel-group-joined">

											<div ng-repeat="school in data.schools" class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a class="collapse ng-binding collapsed" href="#_{{school.id}}_" data-parent="#accordion-project" data-toggle="collapse">
															{{school.name}}
														</a>
													</h4>
												</div>
												<div class="panel-collapse collapse" id="_{{school.id}}_">
													<div class="panel-body">
														<div class="row m-b-30 row-holder-dl">
															<div class="col-lg-12">
																<div class="btn-row m-b-15">
																	<a class="btn" href="schools#id={{school.id}}" target="_blank" ng-click="setUpdater()"  >Bearbeiten</a>
																</div>
																<dl class="custom-dl">
																	<ng-show ng-show="school.user_name">
																		<dt>Ansprechpartner(in):</dt>
																		<dd>{{school.user_name}}</dd>
																	</ng-show>
																	<ng-show ng-show="school.user_function">
																		<dt>Funktion:</dt>
																		<dd>{{school.user_function}}</dd>
																	</ng-show>
																</dl>
															</div>
															<div class="col-lg-5">
																<dl class="custom-dl">
																	<ng-show ng-show="school.address">
																		<dt>Adresse:</dt>
																		<dd>{{school.address}}</dd>
																	</ng-show>
																	<ng-show ng-show="school.plz">
																		<dt>PLZ:</dt>
																		<dd>{{school.plz}}</dd>
																	</ng-show>
																	<ng-show ng-show="school.city">
																		<dt>Stadt:</dt>
																		<dd>{{school.city}}</dd>
																	</ng-show>
																	<ng-show ng-show="school.homepage">
																		<dt>Webseite:</dt>
																		<dd><a target="_blank" href="http://{{school.homepage}}">{{school.homepage}}</a></dd>
																	</ng-show>
																</dl>
															</div>
															<div class="col-lg-4">
																<dl class="custom-dl">
																	<ng-show ng-show="school.phone">
																		<dt>Telefon:</dt>
																		<dd>{{school.phone}}</dd>
																	</ng-show>
																	<ng-show ng-show="school.fax">
																		<dt>Fax:</dt>
																		<dd>{{school.fax}}</dd>
																	</ng-show>
																	<ng-show ng-show="school.email">
																		<dt>Email:</dt>
																		<dd><a href="mailto:{{school.email}}">{{school.email}}</a></dd>
																	</ng-show>
																</dl>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>

										<div class="row holder-three-blocks m-b-30">
											<div class="col-lg-4">
												<h4 class="panel-title m-b-10">
													Ansprechperson für Rückfragen zum Antrag
												</h4>
												<div class="form-group">
													<ui-select   on-select="onSelectCallback($item, $model, 1)" class="type-document" ng-model="request.request_user_id">
														<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
														<ui-select-choices repeat="item.id as item in  performerUsers | filter: $select.search | orderBy: 'name'">
															<span ng-bind-html="item.name | highlight: $select.search"></span>
														</ui-select-choices>
													</ui-select>
												</div>
												<dl class="custom-dl" ng-show="selectRequestResult">
													<ng-show ng-show="selectRequestResult.function">
														<dt>Funktion:</dt>
														<dd>{{selectRequestResult.function}}</dd>
													</ng-show>
													<ng-show ng-show="selectRequestResult.title">
														<dt>Anrede:</dt>
														<dd>{{selectRequestResult.gender}}</dd>
													</ng-show>
													<ng-show ng-show="selectRequestResult.phone">
														<dt>Telefon:</dt>
														<dd>{{selectRequestResult.phone}}</dd>
													</ng-show>
													<ng-show ng-show="selectRequestResult.email">
														<dt>Email:</dt>
														<dd><a class="visible-lg-block" href="mailto:{{selectRequestResult.email}}">{{selectRequestResult.email}}</a></dd>
													</ng-show>
												</dl>
											</div>

											<div class="col-lg-4">
												<h4 class="panel-title m-b-10">
													Ansprechperson für Rückfragen zum Konzept
												</h4>
												<div class="form-group">
													<ui-select   on-select="onSelectCallback($item, $model, 2)" class="type-document" ng-model="request.concept_user_id">
														<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
														<ui-select-choices repeat="item.id as item in  performerUsers | filter: $select.search | orderBy: 'name'">
															<span ng-bind-html="item.name | highlight: $select.search"></span>
														</ui-select-choices>
													</ui-select>
												</div>
												<dl class="custom-dl" ng-show="selectConceptResult">
													<ng-show ng-show="selectConceptResult.function">
														<dt>Funktion:</dt>
														<dd>{{selectConceptResult.function}}</dd>
													</ng-show>
													<ng-show ng-show="selectConceptResult.title">
														<dt>Anrede:</dt>
														<dd>{{selectConceptResult.gender}}</dd>
													</ng-show>
													<ng-show ng-show="selectConceptResult.phone">
														<dt>Telefon:</dt>
														<dd>{{selectConceptResult.phone}}</dd>
													</ng-show>
													<ng-show ng-show="selectConceptResult.email">
														<dt>Email:</dt>
														<dd><a class="visible-lg-block" href="mailto:{{selectConceptResult.email}}">{{selectConceptResult.email}}</a></dd>
													</ng-show>
												</dl>
											</div>

											<div class="col-lg-4">
												<h4 class="panel-title m-b-10">
													Ansprechperson für Rückfragen zum Finanzplan
												</h4>
												<div class="form-group">
													<ui-select   on-select="onSelectCallback($item, $model, 3)" class="type-document" ng-model="request.finance_user_id">
														<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
														<ui-select-choices repeat="item.id as item in  performerUsers | filter: $select.search | orderBy: 'name'">
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
										</div>



										<h3 class="panel-title">
											Angaben zum Jugendamt
                      <span class="btn-row m-l-15">
                        <a class="btn" href="districts#id={{data.district_id}}" target="_blank" ng-click="setUpdater()" >Bearbeiten</a>
                      </span>
										</h3>
										<hr/>
										<div class="row row-holder-dl" ng-show="data.district_id">
											<div class="col-lg-12 m-b-10">
												<dl class="custom-dl">
													<ng-show ng-show="data.district_name">
														<dt>Bezirk:</dt>
														<dd><strong>{{data.district_name}}</strong></dd>
													</ng-show>
													<ng-show ng-show="data.district_contact">
														<dt>Ansprechpartner(in):</dt>
														<dd><strong>{{data.district_contact}}</strong></dd>
													</ng-show>
												</dl>
											</div>
											<div class="col-lg-5">
												<dl class="custom-dl">
													<ng-show ng-show="data.district_address">
														<dt>Adresse:</dt>
														<dd>{{data.district_address}}</dd>
													</ng-show>
													<ng-show ng-show="data.district_plz">
														<dt>PLZ:</dt>
														<dd>{{data.district_plz}}</dd>
													</ng-show>
													<ng-show ng-show="data.district_city">
														<dt>Stadt:</dt>
														<dd>{{data.district_city}}</dd>
													</ng-show>
												</dl>
											</div>
											<div class="col-lg-4">
												<dl class="custom-dl">
													<ng-show ng-show="data.district_phone">
														<dt>Telefon:</dt>
														<dd>{{data.district_phone}}</dd>
													</ng-show>
													<ng-show ng-show="data.district_fax">
														<dt>Fax:</dt>
														<dd>{{data.district_fax}}</dd>
													</ng-show>
													<ng-show ng-show="data.district_email">
														<dt>Email:</dt>
														<dd><a href="mailto:{{data.district_email}}">{{data.district_email}}</a></dd>
													</ng-show>
												</dl>
											</div>
										</div>
									</div>
									<hr/>
									<div class="row">
										<div class="col-lg-12">
											<h4 class="m-t-0">Zusätzliche Information</h4>
											<textarea placeholder="Tragen Sie den Text hier ein" ng-model="request.additional_info" class="form-control"></textarea>
										</div>
									</div>
									<hr />
									<div class="row">
										<div class="col-lg-4 form-horizontal">
											<h4>Druck-Template wählen</h4>
											<div class="form-group">
												<label class="col-lg-4 control-label">Zielvereinbarung:</label>
												<div class="col-lg-8">
													<ui-select ng-change="" class="type-document" ng-model="request.doc_target_agreement_id">
														<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
														<ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search | filter:{type_code:'goal_agreement'} | orderBy: 'name'">
															<span ng-bind-html="item.name | highlight: $select.search"></span>
														</ui-select-choices>
													</ui-select>
												</div>


											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">Antrag:</label>
												<div class="col-lg-8">
													<ui-select ng-change="" class="type-document" ng-model="request.doc_request_id">
														<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
														<ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search | filter:{type_code:'request'} | orderBy: 'name'">
															<span ng-bind-html="item.name | highlight: $select.search"></span>
														</ui-select-choices>
													</ui-select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 control-label">Fördervertrag:</label>
												<div class="col-lg-8">
													<ui-select ng-change="" class="type-document" ng-model="request.doc_financing_agreement_id">
														<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
														<ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search | filter:{type_code:'funding_agreement'} | orderBy: 'name'">
															<span ng-bind-html="item.name | highlight: $select.search"></span>
														</ui-select-choices>
													</ui-select>
												</div>
											</div>
										</div>
										<div class="col-lg-8">
											<h4>Auflage</h4>
											<textarea class="form-control custom-height-textarea" placeholder="Tragen Sie den Text hier ein" ng-model="request.senat_additional_info" class="form-control"></textarea>
										</div>
									</div>
								</div>
							</div>

						</div>
					</uib-tab>
					<uib-tab class="finance" index="'finance-plan'" select="setTab('finance-plan')" heading="Finanzplan">
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
													<select class="form-control">
														<option>Mr Werner Munk</option>
													</select>
												</div>
												<dl class="custom-dl">
													<dt>Funktion:</dt>
													<dd>Manager</dd>
													<dt>Titel:</dt>
													<dd>Some title</dd>
													<dt>Telefon:</dt>
													<dd>(030) 2888 496</dd>
													<dt>Email:</dt>
													<dd><a target="_blank" href="mailto:admin@warenform.de">admin@warenform.de</a></dd>
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
					</uib-tab>
					<uib-tab class="concepts" index="'school-concepts'" select="setTab('school-concepts')" heading="Konzept">
						<div class="tab-pane" ng-controller="RequestSchoolConceptController">
							<div class="panel-group panel-group-joined" id="accordion-concepts">
								<div class="panel panel-default" ng-repeat="schoolConcept in schoolConcepts">
									<div class="panel-heading" ng-init="conceptTab[schoolConcept.id] = 'data'">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-concepts" href="#collapse-{{::schoolConcept.id}}" ng-class="{collapsed: schoolConcepts.length > 1}" class="collapse">
												{{::schoolConcept.school_name}} ({{::schoolConcept.school_number}})
												<span class="notice">
													<span class="color-notice {{schoolConcept.status}}-row"></span>
												</span>
												<div class="btn-group btn-toggle pull-right tabs-toggle">
													<button ng-click="conceptTab[schoolConcept.id] = 'data'; $event.preventDefault(); $event.stopPropagation();" ng-class="conceptTab[schoolConcept.id] == 'data' ? 'active' : 'btn-default'" class="btn btn-sm">DATEN</button>
													<button ng-click="conceptTab[schoolConcept.id] = 'history'; $event.preventDefault(); $event.stopPropagation();" ng-class="conceptTab[schoolConcept.id] == 'history' ? 'active' : 'btn-default'" class="btn btn-sm">VERLAUF</button>
												</div>
											</a>
										</h4>
									</div>
									<div id="collapse-{{::schoolConcept.id}}" class="panel-collapse collapse" ng-class="{in: schoolConcepts.length == 1}">
										<div class="panel-body">
											<div ng-class="{current: conceptTab[schoolConcept.id] == 'data'}" id="tab-data-{{::schoolConcept.id}}" class="block-concept current">
												<div class="alert alert-danger" ng-if="schoolConcept.status == 'rejected' && schoolConcept.comment" ng-bind="schoolConcept.comment"></div>
												<ng-form disable-all="schoolConcept.status == 'accepted'">
													<div class="form-group">
														<label>Situation an der Schule</label>
														<div spi-hint text="_hint.school_concept_situation" class="has-hint"></div>
														<div class="wrap-hint">
															<textarea ng-init="school_concept[schoolConcept.id].situation = schoolConcept.situation" class="form-control custom-height" ng-model="school_concept[schoolConcept.id].situation" placeholder="Tragen Sie den Text hier ein" ng-readonly="canAccept || schoolConcept.status == 'in_progress' || schoolConcept.status == 'accepted'"></textarea>
														</div>
													</div>
													<div class="form-group">
														<label>Angebote der Jugendsozialarbeit an der Schule</label>
														<div spi-hint text="_hint.school_concept_offers_youth_social_work" class="has-hint"></div>
														<div class="wrap-hint">
															<textarea ng-init="school_concept[schoolConcept.id].offers_youth_social_work = schoolConcept.offers_youth_social_work" class="form-control custom-height" ng-model="school_concept[schoolConcept.id].offers_youth_social_work" placeholder="Tragen Sie den Text hier ein" ng-readonly="canAccept || schoolConcept.status == 'in_progress' || schoolConcept.status == 'accepted'"></textarea>
														</div>
													</div>
													<hr />
													<div class="row" ng-if="schoolConcept.status != 'accepted'">
														<div class="col-lg-10">
															<span ng-if="canAccept && schoolConcept.status != 'rejected'">
																<h4 class="m-t-0">Prüfnotiz</h4>
																<textarea ng-init="school_concept[schoolConcept.id].comment = schoolConcept.comment" placeholder="Tragen Sie den Text hier ein" ng-model="school_concept[schoolConcept.id].comment" class="form-control comments"></textarea>
															</span>
														</div>
														<div class="col-lg-2" ng-if="canAccept">
															<div class="m-t-30 text-right pull-right">
																<button ng-hide="schoolConcept.status == 'accepted'" class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'accept')">AKZEPTIEREN</button>
																<button ng-hide="schoolConcept.status == 'rejected'" ng-class="{disabled: !school_concept[schoolConcept.id].comment}" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'reject')" class="btn w-lg btn-lg btn-danger">ABLEHNEN</button>
															</div>
														</div>
														<div class="col-lg-2" ng-if="!canAccept && schoolConcept.status != 'in_progress' && schoolConcept.status != 'accepted'">
															<div class="text-right pull-right">
																<button class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'submit')">SUBMIT</button>
															</div>
														</div>
													</div>
												</ng-form>
											</div>
											<div ng-class="{current: conceptTab[schoolConcept.id] == 'history'}" id="tab-history-{{::schoolConcept.id}}" class="tab-history block-concept">
												<div ng-repeat-start="history in schoolConcept.histories" ng-if="::history.changes" class="changes-content">
													<div class="heading-changes" ng-click="history.isCollapsed = !history.isCollapsed" data-toggle="collapse" ng-class="{open: history.isCollapsed}">
														Inhaltsveränderungen
														<i class="ion-chevron-down arrow-box"></i>
													</div>
													<div class="content-changes" uib-collapse="!history.isCollapsed">
														<div class="thead">
															<div class="col-lg-4">
																<strong>Veränderungen</strong>
																<span>Bearbeitet von {{::history.user_name}} am {{::history.date}}</span>
															</div>
															<div class="col-lg-4">
																Früher
															</div>
															<div class="col-lg-4">
																Nachher
															</div>
														</div>
														<div class="row-holder">
															<div ng-repeat="change in history.changes" class="custom-row">
																<div class="col-lg-4 ">
																	<strong ng-bind="::change.name"></strong>
																	<div class="btn-row m-t-10">
																		<button class="btn w-xs" ng-click="openComparePopup(history, change)">
																			<span>Vergleichen</span>
																			<i class="ion-arrow-swap"></i>
																		</button>
																	</div>
																</div>
																<div class="col-lg-4" ng-bind="::change.old"></div>
																<div class="col-lg-4" ng-bind="::change.new"></div>
															</div>
														</div>
													</div>
												</div>
												<div ng-repeat-end class="alert alert-{{history.status_code}}">
													<strong class="status-history" ng-bind="::history.status_name">Genehmigt</strong>
													<span class="check-history">Überpüft von {{::history.user_name}} {{::history.date}}</span>
													<p ng-bind="::history.comment"></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</uib-tab>
					<uib-tab class="schools-goals" index="'schools-goals'" select="setTab('schools-goals')" heading="Entwicklungsziele">

						<div class="tab-pane" ng-controller="RequestSchoolGoalController">
              <span class="notice">
                <span ng-class="{'open': tabStatus == 'g', 'inprogress-row': tabStatus == 'r', 'decline-row-red': tabStatus == 'd', 'acceptable-row': tabStatus == 'a'}" class="color-notice"></span>
              </span>
              <div id="accordion-order" class="panel-group panel-group-joined">

								<div ng-repeat="school in schoolGoals track by $index" class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-order" href="#collapse_{{$index}}"  class="collapse ng-binding collapsed" aria-expanded="false">
												{{school.school_name}} ({{school.school_number}})
												<span class="notice">
													<span ng-class="{'open': school.status == 'g', 'inprogress-row': school.status == 'r', 'decline-row-red': school.status == 'd', 'acceptable-row': school.status == 'a'}" class="color-notice"></span>
												</span>
											</a>
										</h4>
									</div>
									<div id="collapse_{{$index}}" class="panel-collapse collapse"  >
										<div class="panel-body">
											<div class="tabs-vertical-env">
												<ul class="nav tabs-vertical" >

                          <li  ng-repeat="goal in school.goals" ng-click="activateTab(goal.id) "  ng-class="getActivateTab() == goal.id ? 'active' : '' " >
                            <a  data-toggle="tab" href="#goal-{{::goal.id}}">{{::goal.name}}<span ng-if="goal.option == 1">(optional)</span></a>
                          </li>

												</ul>

												<div class="tab-content" >
													<div ng-repeat="goal in school.goals"  disable-all="readonly(goal)"  id="goal_{{goal.id}}" class="tab-pane "  ng-class="getActivateTab() == goal.id ? 'active' : ''" >

														<div ng-hide="goal.status == 'g'" class="alert" ng-class="{'alert-warning': goal.status == 'r', 'alert-danger': goal.status == 'd', 'alert-success': goal.status == 'a'}" ng-bind="goal.notice">
															<strong ng-if="goal.status == 'r'">Bereit zu überprüfen</strong>
														</div>

														<h4>{{::goal.name}}</h4>
                            <textarea  ng-model="goal.description" class="form-control" placeholder="Tragen Sie den Text hier ein here"></textarea>
														<h4>Angebote für Schüler/innen und Eltern</h4>
                            <span  ng-if="goal.offer_field_count > 3" >
                                <label  class="error">Bitte wählen Sie nach Möglichkeit nicht mehr als drei Schwerpunktziele aus</label>
                            </span>
														<div class="holder-radio">
															<div class="p-0 text-center">
																<div class="row">
																	<span class="col-lg-2">Schwerpunktziel {{goal.offer_field_count}}</span>
																	<span class="col-lg-1">Weiteres Ziel</span>
																	<span class="col-lg-1">kein Ziel</span>
																</div>
																<div class="row">
                                  <div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.capacity" ng-change="addGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.capacity" ng-change="delGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.capacity" ng-change="delGoalsCount(goal, 'offer')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Verbesserung der (vorberuflichen) Handlungskompetenzen</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.transition" ng-change="addGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.transition" ng-change="delGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.transition" ng-change="delGoalsCount(goal, 'offer')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Verbesserung aller Übergänge in Schule (Kita-GS-Sek I-Sek II) und in Ausbildung</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.reintegration" ng-change="addGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.reintegration" ng-change="delGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.reintegration" ng-change="delGoalsCount(goal, 'offer')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Abbau von Schuldistanz; Reintegration in den schulischen Alltag</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.social_skill" ng-change="addGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.social_skill" ng-change="delGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.social_skill" ng-change="delGoalsCount(goal, 'offer')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Stärkung der sozialen Kompetenzen und des Selbstvertrauens</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.prevantion_violence" ng-change="addGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.prevantion_violence" ng-change="delGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.prevantion_violence" ng-change="delGoalsCount(goal, 'offer')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Gewaltprävention und -intervention</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.health" ng-change="addGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.health" ng-change="delGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.health" ng-change="delGoalsCount(goal, 'offer')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Gesundheitsförderung </p>
																</div>
																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.sport" ng-change="addGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.sport" ng-change="delGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.sport" ng-change="delGoalsCount(goal, 'offer')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Förderung sportlicher, kultureller und sportlicher Interessen</p>
																</div>
																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.parent_skill" ng-change="addGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.parent_skill" ng-change="delGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.parent_skill" ng-change="delGoalsCount(goal, 'offer')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Einbindung der Eltern und Stärkung der Erziehungskompetenzen</p>
																</div>
																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.other_goal" ng-change="addGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.other_goal" ng-change="delGoalsCount(goal, 'offer')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.other_goal" ng-change="delGoalsCount(goal, 'offer')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Sonstiges (Bezug in extra Textfeld benennen)</p>
																</div>
																<div class="col-lg-8 pull-right textarea-box">
																	<textarea placeholder="Tragen Sie den Text hier ein" ng-model="goal.other_description" class="form-control"></textarea>
																</div>
															</div>
														</div>
														<h4 class="m-t-40">Interne / Externe Vernetzung</h4>
                            <span  ng-if="goal.net_field_count > 3" >
                                <label  class="error">Bitte wählen Sie nach Möglichkeit nicht mehr als drei Schwerpunktziele aus</label>
                            </span>
														<div class="holder-radio">
															<div class="p-0 text-center">
																<div class="row">
																	<span class="col-lg-2">Schwerpunktziel {{goal.net_field_count}}</span>
																	<span class="col-lg-1">Weiteres Ziel</span>
																	<span class="col-lg-1">kein Ziel</span>
																</div>
																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.cooperation" ng-change="addGoalsCount(goal, 'net')" >
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.cooperation" ng-change="delGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.cooperation" ng-change="delGoalsCount(goal, 'net')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Zusammenarbeit im Tandem oder Tridem</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.participation" ng-change="addGoalsCount(goal, 'net')" >
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.participation" ng-change="delGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.participation" ng-change="delGoalsCount(goal, 'net')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Mitarbeit in schulischen Gremien, Treffen mit Schulleitung, Mitwirkung in AGs</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.social_area" ng-change="addGoalsCount(goal, 'net')" >
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.social_area" ng-change="delGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.social_area" ng-change="delGoalsCount(goal, 'net')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Öffnung der Schule in den Sozialraum</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.third_part" ng-change="addGoalsCount(goal, 'net')" >
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.third_part" ng-change="delGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.third_part" ng-change="delGoalsCount(goal, 'net')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Einbindung des Sozialraums bzw. Angebote Dritter in die Schule</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.regional" ng-change="addGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.regional" ng-change="delGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.regional" ng-change="delGoalsCount(goal, 'net')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Mitarbeit in regionalen Arbeitsgemeinschaften / Netzwerken</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.concept" ng-change="addGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.concept" ng-change="delGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.concept" ng-change="delGoalsCount(goal, 'net')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Gemeinsame Handlungs- und Bildungskonzepte </p>
																</div>
                                <div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.net_other_goal" ng-change="addGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.net_other_goal" ng-change="delGoalsCount(goal, 'net')">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.net_other_goal" ng-change="delGoalsCount(goal, 'net')" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Sonstiges (Bezug in extra Textfeld benennen)</p>
																</div>
																<div class="col-lg-8 pull-right textarea-box" ng-show="goal.net_other_goal > 0">
																	<textarea ng-model="goal.network_text" placeholder="Tragen Sie den Text hier ein"  class="form-control"></textarea>
																</div>
															</div>
														</div>
														<h4 class="m-t-40">Umsetzung</h4>
														<textarea ng-model="goal.implementation" class="form-control" placeholder="Tragen Sie den Text hier ein"></textarea>
														<h4 class="m-t-40">Indikatoren und Zielwerte</h4>
														<p class="">Formulierung von Indikatoren und Zielwerten zur Messung der Zielerreichung</p>
														<div class="form-horizontal m-t-15">
															<div class="form-group">
																<label class="col-lg-1 control-label">
																	1.
																</label>
																<div class="col-lg-11">
																	<input type="text" ng-model="goal.indicator_1" value="" class="form-control">
																</div>
															</div>
															<div class="form-group">
																<label class="col-lg-1 control-label">
																	2.
																</label>
																<div class="col-lg-11">
																	<input type="text" ng-model="goal.indicator_2" value="" class="form-control">
																</div>
															</div>
															<div class="form-group">
																<label class="col-lg-1 control-label">
																	3.
																</label>
																<div class="col-lg-11">
																	<input type="text" ng-model="goal.indicator_3" value="" class="form-control">
																</div>
															</div>
															<div class="form-group">
																<label class="col-lg-1 control-label">
																	4.
																</label>
																<div class="col-lg-11">
																	<input type="text" ng-model="goal.indicator_4" value="" class="form-control">
																</div>
															</div>
															<div class="form-group">
																<label class="col-lg-1 control-label">
																	5.
																</label>
																<div class="col-lg-11">
																	<input type="text" ng-model="goal.indicator_5" value="" class="form-control">
																</div>
															</div>
														</div>
														<hr />
														<div class="row">
															<div ng-hide=" (userType != 'a' && userType != 'p') || goal.status == 'a' " class="col-lg-9">
																<h4 class="m-t-0">Prüfnotiz</h4>
																<textarea  ng-model="goal.notice" placeholder="Tragen Sie den Text hier ein" class="form-control"></textarea>
															</div>

															<div class="col-lg-3">
																<div class="m-t-30 text-right pull-right">
                                  <button ng-hide="userType != 't' || goal.status == 'a' || goal.status == 'r'" class="btn w-lg btn-lg custom-btn m-b-10" ng-click="submitForm( school, goal, 'submit')">SENDEN</button>
																  <button ng-hide="goal.status == 'a' || (userType != 'a' && userType != 'p') " class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm( school, goal, 'accept')">AKZEPTIEREN</button>
                                  <button ng-hide="goal.status == 'd' || goal.status == 'a' || (userType != 'a' && userType != 'p') " ng-class="{disabled: !goal.notice}" ng-click="submitForm( school, goal, 'declare')" class="btn w-lg btn-lg btn-danger">ABLEHNEN</button>
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
					</uib-tab>
				</uib-tabset>
				<br>
				<div class="form-group group-btn row">
					<div class="col-lg-6 text-left">
						<button ng-click="remove()" class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"><i class="fa fa-trash-o"></i></button>
						<button class="btn w-lg btn-info btn-lg">
							<i class="fa fa-rotate-left"></i>
							<span>Neu eröffnen</span>
						</button>
						<button class="btn w-lg btn-info btn-lg">Förderfähig</button>
						<button class="btn w-lg btn-info btn-lg">Genehmigt</button>
					</div>
					<div class="col-lg-6 text-right">
						<button class="btn w-lg cancel-btn btn-lg" ng-click="cancel()">Abbrechen</button>
						<button class="btn w-lg custom-btn btn-lg" ng-click="submitRequest()">Speichern</button>
						<button class="btn w-lg custom-btn btn-lg" ng-click="submitRequest(true)" title="Speichern und zurück zur liste">Anwenden</button>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


<script type="text/ng-template" id="setDuration.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left">Dauer ändern</h3>
			<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body text-center">
			<div class="form-group">
				<ng-form>
					<div class="holder-datepicker text-right">
						<div class="col-lg-2 p-0">
							<label>Beginn</label>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_start_date_is_open = !dp_start_date_is_open" ng-model="form.start_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_start_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar" ng-click="dp_start_date_is_open = !dp_start_date_is_open"></i></span>
							</div>
						</div>
						<div class="col-lg-2 p-0">
							<label>Ende</label>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_due_date_is_open = !dp_due_date_is_open" ng-model="form.due_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_due_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar" ng-click="dp_due_date_is_open = !dp_due_date_is_open"></i></span>
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


<script type="text/ng-template" id="conceptCompareTemplate.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left">Vergleichen</h3>
			<button ng-click="cancel()" type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body">
			<div class="heading-compare">
				<strong>Veränderungen</strong>
				<span>Bearbeitet von {{::history.user_name}} am {{::history.date}}</span>
				<p>Bereich: <strong ng-bind="::history.name"></strong></p>
			</div>
			<hr />
			<div class="row compare-box" ng-bind-html="::compareText"></div>
			<hr />
		</div>
		<div class="row">
			<div class="form-group group-btn">
				<div class="col-lg-12">
					<button ng-click="cancel()" class="btn w-lg custom-btn pull-right" data-dismiss="modal">SCHLIEßEN</button>
				</div>
			</div>
		</div>
	</div>
</script>
