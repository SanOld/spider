<?php
$this->pageTitle = 'Anträge | ' . Yii::app()->name;
$this->breadcrumbs = array('Anträge'=>'/requests', 'Anträg {{request_code}}');
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
					<uib-tab class="finance {{financeStatus}}" index="'finance-plan'" select="setTab('finance-plan')" heading="Finanzplan">
                      <?php include(Yii::app()->getBasePath().'/views/site/partials/request-financial-plan.php'); ?>
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
												<div ng-if="canAccept && schoolConcept.histories.length" class="btn-group btn-toggle pull-right tabs-toggle">
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
                        <div class="concept-form-block">
												<ng-form disable-all="schoolConcept.status == 'accepted'">
													<div class="form-group">
														<label>Situation an der Schule</label>
														<div spi-hint text="_hint.school_concept_situation" class="has-hint"></div>
														<div class="wrap-hint">
															<textarea ng-init="school_concept[schoolConcept.id].situation = schoolConcept.situation" class="form-control custom-height animate-textarea textarea-2" ng-focus="isTextareaShow = true; canSave = !(!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted')" spi-on-focus-large spi-save="textareaSave" spi-cancel="textareaHide" spi-callback="saveText(schoolConcept.id, school_concept[schoolConcept.id], 'situation')" ng-model="school_concept[schoolConcept.id].situation" placeholder="Tragen Sie den Text hier ein" ng-readonly="!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted'"></textarea>
														</div>
													</div>
													<div class="form-group">
														<label>Angebote der Jugendsozialarbeit an der Schule</label>
														<div spi-hint text="_hint.school_concept_offers_youth_social_work" class="has-hint"></div>
														<div class="wrap-hint">
															<textarea ng-init="school_concept[schoolConcept.id].offers_youth_social_work = schoolConcept.offers_youth_social_work" class="form-control custom-height animate-textarea textarea-2" ng-focus="isTextareaShow = true; canSave = !(!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted')" spi-on-focus-large spi-save="textareaSave" spi-cancel="textareaHide" spi-callback="saveText(schoolConcept.id, school_concept[schoolConcept.id], 'offers_youth_social_work')" ng-model="school_concept[schoolConcept.id].offers_youth_social_work" placeholder="Tragen Sie den Text hier ein" ng-readonly="!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted'"></textarea>
														</div>
													</div>
													<hr />
                          <div class="row" ng-show="isTextareaShow">
                            <div class="clearfix"><div class="col-lg-4 col-lg-offset-8 text-right button-textarea">
                                <button class="btn w-lg ng-scope" ng-click="textareaHide = !textareaHide; isTextareaShow = false">Löschen</button>
                                <button class="btn w-lg cancel-btn custom-btn" ng-click="textareaSave = !textareaSave; isTextareaShow = false" ng-show="canSave">Hinzufügen</button>
                              </div>
                            </div>
                          </div>
													<div class="row" ng-if="schoolConcept.status != 'accepted' && canAcceptEarly(schoolConcept.status)">
														<div class="col-lg-10">
															<span ng-if="canAccept && schoolConcept.status != 'rejected'">
																<h4 class="m-t-0">Prüfnotiz</h4>
																<textarea ng-init="school_concept[schoolConcept.id].comment = schoolConcept.comment" placeholder="Tragen Sie den Text hier ein" ng-model="school_concept[schoolConcept.id].comment" class="form-control comments"></textarea>
															</span>
														</div>
														<div class="col-lg-2">
															<div class="m-t-30 text-right pull-right" ng-if="canAccept">
																<button ng-hide="schoolConcept.status == 'accepted'" class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'accept')">AKZEPTIEREN</button>
																<button ng-hide="schoolConcept.status == 'rejected'" ng-class="{disabled: !school_concept[schoolConcept.id].comment}" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'reject')" class="btn w-lg btn-lg btn-danger">ABLEHNEN</button>
															</div>
                              <div class="text-right pull-right" ng-if="canFormEdit && !isTextareaShow && !canAccept && schoolConcept.status != 'in_progress' && schoolConcept.status != 'accepted'">
                                <h4 class="m-t-0"></h4>
                                <button ng-class="{disabled: !school_concept[schoolConcept.id].situation || !school_concept[schoolConcept.id].offers_youth_social_work}" class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'submit')">SENDEN</button>
                              </div>
														</div>
													</div>
												</ng-form>
                        </div>
											</div>
											<div ng-class="{current: conceptTab[schoolConcept.id] == 'history'}" id="tab-history-{{::schoolConcept.id}}" class="tab-history block-concept">
												<div ng-repeat-start="history in schoolConcept.histories" ng-if="::history.changes" class="changes-content">
													<div class="heading-changes" data-toggle="collapse">
														Inhaltsveränderungen
														<i class="ion-chevron-down arrow-box"></i>
													</div>
													<div class="content-changes">
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
																<div class="col-lg-4" ng-bind="doCutText(change.new, change.old)"></div>
																<div class="col-lg-4" ng-bind="doCutText(change.new, change.old, 1)"></div>
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
          <uib-tab class="schools-goals {{goalsStatus}}"  index="'schools-goals'" select="setTab('schools-goals')" heading="Entwicklungsziele">
                      <?php include(Yii::app()->getBasePath().'/views/site/partials/request-goals-data.php'); ?>
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
						<button ng-show="userCan('save')"  class="btn w-lg custom-btn btn-lg" ng-click="submitRequest(true)" title="Speichern und zurück zur liste">Anwenden</button>
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
					<button class="btn w-lg custom-btn" ng-click="ok()" ng-disabled="form.$invalid || form.due_date < form.start_date|| form.start_date > form.end_fill || form.due_date < form.end_fill">Speichern</button>
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
			<div class="row compare-box">
        <div class="col-lg-12" ng-bind-html="::compareText"></div
      </div>
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


<script type="text/ng-template" id="setEndFill.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left">Abgabe</h3>
			<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body text-center">
			<div class="form-group">
				<ng-form>
					<div class="holder-datepicker text-right">
						<div class="col-lg-2 p-0">
							<label>Abgabe</label>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_start_date_is_open = !dp_start_date_is_open" ng-model="form.end_fill" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_start_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon" ng-click="dp_start_date_is_open = !dp_start_date_is_open"><i class="glyphicon glyphicon-calendar"></i></span>
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
					<button class="btn w-lg custom-btn" ng-click="ok()"  ng-disabled="form.$invalid || form.start_date > form.end_fill || form.due_date < form.end_fill">Speichern</button>
				</div>
			</div>
		</div>
	</div>
</script>
