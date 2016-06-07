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
                      <?php include(Yii::app()->getBasePath().'/views/site/partials/request-project-data.php'); ?>
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
					<uib-tab class="concepts {{conceptStatus}}" index="'school-concepts'" select="setTab('school-concepts')" heading="Konzept">
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
												<div ng-if="schoolConcept.histories.length" class="btn-group btn-toggle pull-right tabs-toggle">
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
																<div class="col-lg-4" ng-bind="::change.old | limitTo: 120"></div>
																<div class="col-lg-4" ng-bind="::change.new | limitTo: 120"></div>
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
					<uib-tab  class="schools-goals {{goalsStatus}}"  index="'schools-goals'" select="setTab('schools-goals')" heading="Entwicklungsziele {{goalsStatus}}">

						<div class="tab-pane" ng-controller="RequestSchoolGoalController">
              <div id="accordion-order" class="panel-group panel-group-joined">

								<div ng-repeat="school in schoolGoals track by $index" class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-order" href="#collapse_{{$index}}"  class="collapse ng-binding " ng-class="$index > 0 ? 'collapsed' : ''" aria-expanded="{{$index > 0}}">
												{{school.school_name}} ({{school.school_number}}) {{school.status}}
												<span class="notice">
													<span  class="color-notice {{school.status}}-row"></span>
												</span>
											</a>
										</h4>
									</div>

									<div id="collapse_{{$index}}" class="panel-collapse" ng-class="$index > 0 ? 'collapse' : 'collapse in'"  >
										<div class="panel-body">
											<div class="tabs-vertical-env">
												<ul class="nav tabs-vertical" >

                          <li  ng-repeat="goal in school.goals" ng-click="activateTab(goal.id) "  ng-class="getActivateTab() == goal.id ? 'active' : '' "  class="{{$index == 0 ? 'active' : ''}}" >
                            <a  data-toggle="tab" href="#goal_{{::goal.id}}" >{{::goal.name}}<span ng-if="goal.option == 1">(optional)</span></a>
                          </li>

												</ul>
<!---->
												<div class="tab-content" >
													<div ng-repeat="goal in school.goals"  disable-all="readonly(goal)"  id="goal_{{goal.id}}" class="tab-pane {{$index == 0 ? 'active' : ''}}" >

														<div ng-hide="goal.status == 'unfinished'" class="alert" ng-class="{{goal.status}}" ng-bind="goal.notice">
															<strong ng-if="goal.status == 'in_progress'">Bereit zu überprüfen</strong>
														</div>

														<h4>{{::goal.name}}</h4>
                            <textarea  ng-model="goal.description" class="form-control" placeholder="Tragen Sie den Text hier ein here"></textarea>
														<h4>Angebote für Schüler/innen und Eltern</h4>
                            <span  ng-if="goal.groups.groupOffer.counter > 3" >
                                <label  class="error">Bitte wählen Sie nach Möglichkeit nicht mehr als drei Schwerpunktziele aus</label>
                            </span>
														<div class="holder-radio">
															<div class="p-0 text-center">
																<div class="row">
																	<span class="col-lg-2">Schwerpunktziel</span>
																	<span class="col-lg-1">Weiteres Ziel</span>
																	<span class="col-lg-1">kein Ziel</span>
																</div>
																<div class="row">
                                  <div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.capacity" ng-change="checkCount('groupOffer', 'capacity', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.capacity" ng-change="checkCount('groupOffer', 'capacity', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.capacity" ng-change="checkCount('groupOffer', 'capacity', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Verbesserung der (vorberuflichen) Handlungskompetenzen</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.transition" ng-change="checkCount('groupOffer', 'transition', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.transition" ng-change="checkCount('groupOffer', 'transition', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.transition" ng-change="checkCount('groupOffer', 'transition', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Verbesserung aller Übergänge in Schule (Kita-GS-Sek I-Sek II) und in Ausbildung</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.reintegration" ng-change="checkCount('groupOffer', 'reintegration', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.reintegration" ng-change="checkCount('groupOffer', 'reintegration', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.reintegration" ng-change="checkCount('groupOffer', 'reintegration', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Abbau von Schuldistanz; Reintegration in den schulischen Alltag</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.social_skill" ng-change="checkCount('groupOffer', 'social_skill', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.social_skill" ng-change="checkCount('groupOffer', 'social_skill', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.social_skill" ng-change="checkCount('groupOffer', 'social_skill', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Stärkung der sozialen Kompetenzen und des Selbstvertrauens</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.prevantion_violence" ng-change="checkCount('groupOffer', 'prevantion_violence', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.prevantion_violence" ng-change="checkCount('groupOffer', 'prevantion_violence', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.prevantion_violence" ng-change="checkCount('groupOffer', 'prevantion_violence', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Gewaltprävention und -intervention</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.health" ng-change="checkCount('groupOffer', 'health', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.health" ng-change="checkCount('groupOffer', 'health', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.health" ng-change="checkCount('groupOffer', 'health', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Gesundheitsförderung </p>
																</div>
																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.sport" ng-change="checkCount('groupOffer', 'sport', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.sport" ng-change="checkCount('groupOffer', 'sport', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.sport" ng-change="checkCount('groupOffer', 'sport', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Förderung sportlicher, kultureller und sportlicher Interessen</p>
																</div>
																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.parent_skill" ng-change="checkCount('groupOffer', 'parent_skill', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.parent_skill" ng-change="checkCount('groupOffer', 'parent_skill', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.parent_skill" ng-change="checkCount('groupOffer', 'parent_skill', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Einbindung der Eltern und Stärkung der Erziehungskompetenzen</p>
																</div>
																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.other_goal" ng-change="checkCount('groupOffer', 'other_goal', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.other_goal" ng-change="checkCount('groupOffer', 'other_goal', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.other_goal" ng-change="checkCount('groupOffer', 'other_goal', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Sonstiges (Bezug in extra Textfeld benennen)</p>
																</div>
																<div class="col-lg-8 pull-right textarea-box" ng-show="goal.other_goal > 0">
																	<textarea placeholder="Tragen Sie den Text hier ein" ng-model="goal.other_description" class="form-control"></textarea>
																</div>
															</div>
														</div>
														<h4 class="m-t-40">Interne / Externe Vernetzung</h4>
                            <span  ng-if="goal.groups.groupNet.counter > 3" >
                                <label  class="error">Bitte wählen Sie nach Möglichkeit nicht mehr als drei Schwerpunktziele aus</label>
                            </span>
                            <div class="holder-radio">
															<div class="p-0 text-center">
																<div class="row">
																	<span class="col-lg-2">Schwerpunktziel </span>
																	<span class="col-lg-1">Weiteres Ziel</span>
																	<span class="col-lg-1">kein Ziel</span>
																</div>
																<div class="row" >
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.cooperation" ng-change="checkCount('groupNet', 'cooperation', goal)" >
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.cooperation" ng-change="checkCount('groupNet', 'cooperation', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.cooperation"  ng-change="checkCount('groupNet', 'cooperation', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Zusammenarbeit im Tandem oder Tridem</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.participation" ng-change="checkCount('groupNet', 'participation', goal)" >
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.participation" ng-change="checkCount('groupNet', 'participation', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.participation" ng-change="checkCount('groupNet', 'participation', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Mitarbeit in schulischen Gremien, Treffen mit Schulleitung, Mitwirkung in AGs</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.social_area" ng-change="checkCount('groupNet', 'social_area', goal)" >
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.social_area" ng-change="checkCount('groupNet', 'social_area', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.social_area" ng-change="checkCount('groupNet', 'social_area', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Öffnung der Schule in den Sozialraum</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.third_part" ng-change="checkCount('groupNet', 'third_part', goal)" >
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.third_part" ng-change="checkCount('groupNet', 'third_part', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.third_part" ng-change="checkCount('groupNet', 'third_part', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Einbindung des Sozialraums bzw. Angebote Dritter in die Schule</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.regional" ng-change="checkCount('groupNet', 'regional', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.regional" ng-change="checkCount('groupNet', 'regional', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.regional" ng-change="checkCount('groupNet', 'regional', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Mitarbeit in regionalen Arbeitsgemeinschaften / Netzwerken</p>
																</div>

																<div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.concept" ng-change="checkCount('groupNet', 'concept', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.concept" ng-change="checkCount('groupNet', 'concept', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.concept" ng-change="checkCount('groupNet', 'concept', goal)" checked="">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
																	<p class="col-lg-8">Gemeinsame Handlungs- und Bildungskonzepte </p>
																</div>
                                <div class="row">
																	<div class="label-holder col-lg-2">
                                    <label class="cr-styled">
                                      <input type="radio" value="1" ng-model="goal.net_other_goal" ng-change="checkCount('groupNet', 'net_other_goal', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="2" ng-model="goal.net_other_goal" ng-change="checkCount('groupNet', 'net_other_goal', goal)">
                                      <i class="fa"></i>
                                    </label>
                                  </div>
                                  <div class="label-holder col-lg-1">
                                    <label class="cr-styled">
                                      <input type="radio" value="0" ng-model="goal.net_other_goal" ng-change="checkCount('groupNet', 'net_other_goal', goal)" checked="">
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
															<div ng-hide=" (userType != 'a' && userType != 'p') || goal.status == 'accepted' " class="col-lg-9">
																<h4 class="m-t-0">Prüfnotiz</h4>
																<textarea  ng-model="goal.notice" placeholder="Tragen Sie den Text hier ein" class="form-control"></textarea>
															</div>

															<div class="col-lg-3">

																<div class="m-t-30 text-right pull-right">
                                  <button ng-hide="userType != 't' || goal.status == 'a' || goal.status == 'in_progress'" class="btn w-lg btn-lg custom-btn m-b-10" ng-click="submitForm( school, goal, 'submit')">SENDEN</button>
																  <button ng-hide="goal.status == 'accepted' || (userType != 'a' && userType != 'p') " class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm( school, goal, 'accept')">AKZEPTIEREN</button>
                                  <button ng-hide="goal.status == 'rejected' || goal.status == 'accepted' || (userType != 'a' && userType != 'p') " ng-class="{disabled: !goal.notice}" ng-click="submitForm( school, goal, 'declare')" class="btn w-lg btn-lg btn-danger">ABLEHNEN</button>
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
						<button ng-show="userCan('delete')" ng-click="block()" class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"><i class="fa fa-trash-o"></i></button>
						<button ng-show="userCan('reopen')" class="btn w-lg btn-info btn-lg">
							<i class="fa fa-rotate-left"></i>
							<span>Neu eröffnen</span>
						</button>
						<button ng-show="userCan('changeStatus')" class="btn w-lg btn-info btn-lg">Förderfähig</button>
						<button ng-show="userCan('changeStatus')" class="btn w-lg btn-info btn-lg">Genehmigt</button>
					</div>
					<div class="col-lg-6 text-right">
						<button class="btn w-lg cancel-btn btn-lg" ng-click="cancel()">Abbrechen</button>
						<button ng-show="userCan('save')" class="btn w-lg custom-btn btn-lg" ng-click="submitRequest()">Speichern</button>
						<button ng-show="userCan('save')" class="btn w-lg custom-btn btn-lg" ng-click="submitRequest(true)" title="Speichern und zurück zur liste">Anwenden</button>
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
								<span class="input-group-addon" ng-click="dp_start_date_is_open = !dp_start_date_is_open"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
						<div class="col-lg-2 p-0">
							<label>Ende</label>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_due_date_is_open = !dp_due_date_is_open" ng-model="form.due_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_due_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon" ng-click="dp_due_date_is_open = !dp_due_date_is_open"><i class="glyphicon glyphicon-calendar"></i></span>
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
