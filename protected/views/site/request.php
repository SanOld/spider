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
					<uib-tab class="finance" index="'finance-plan'" select="setTab('finance-plan')" heading="Finanzplan">
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
															<textarea ng-init="school_concept[schoolConcept.id].situation = schoolConcept.situation" class="form-control custom-height" ng-model="school_concept[schoolConcept.id].situation" placeholder="Tragen Sie den Text hier ein" ng-disabled="!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted'"></textarea>
														</div>
													</div>
													<div class="form-group">
														<label>Angebote der Jugendsozialarbeit an der Schule</label>
														<div spi-hint text="_hint.school_concept_offers_youth_social_work" class="has-hint"></div>
														<div class="wrap-hint">
															<textarea ng-init="school_concept[schoolConcept.id].offers_youth_social_work = schoolConcept.offers_youth_social_work" class="form-control custom-height" ng-model="school_concept[schoolConcept.id].offers_youth_social_work" placeholder="Tragen Sie den Text hier ein" ng-disabled="!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted'"></textarea>
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
														<div class="col-lg-2" ng-if="canFormEdit && schoolConcept.status != 'in_progress' && schoolConcept.status != 'accepted'">
															<div class="text-right pull-right">
																<button class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'submit')">SUBMIT</button>
															</div>
														</div>
													</div>
												</ng-form>
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
					<uib-tab  class="schools-goals {{goalsStatus}}"  index="'schools-goals'" select="setTab('schools-goals')" heading="Entwicklungsziele">

						<div class="tab-pane" ng-controller="RequestSchoolGoalController">
              <div id="accordion-order" class="panel-group panel-group-joined">

								<div ng-repeat="school in schoolGoals track by $index" class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-order" href="#collapse_{{$index}}"  class="collapse ng-binding " ng-class="!($first && $first == $last) ? 'collapsed' : ''" aria-expanded="{{!($first && $first == $last)}}">
												{{school.school_name}} ({{school.school_number}})
												<span class="notice">
													<span  class="color-notice {{school.status}}-row"></span>
												</span>
											</a>
										</h4>
									</div>

									<div id="collapse_{{$index}}" class="panel-collapse" ng-class="!($first && $first == $last) ? 'collapse' : 'collapse in'"  >
										<div class="panel-body">
											<div class="tabs-vertical-env">
												<ul class="nav tabs-vertical" >

                          <li  ng-repeat="goal in school.goals" ng-click="activateTab(goal.id) "  ng-class="getActivateTab() == goal.id ? 'active' : '' "  class="{{$index == 0 ? 'active' : ''}}" >
                            <a  data-toggle="tab" href="#goal_{{::goal.id}}" >
                              <span class="notice">
                                <span  class="color-notice {{goal.status}}-row"></span>
                              </span>
                              {{::goal.name}}<span ng-if="goal.option == 1">(optional)</span></a>
                          </li>

												</ul>
												<div class="tab-content" >
													<div ng-repeat="goal in school.goals"    id="goal_{{goal.id}}" class="tab-pane {{$index == 0 ? 'active' : ''}}" >
                            <div disable-all="readonly(goal)">
														<div ng-hide="goal.status == 'unfinished'" class="alert-{{goal.status}}" >
															<strong ng-if="goal.status == 'in_progress'">Bereit zu überprüfen</strong>
                              <strong ng-if="goal.status == 'accepted'">Akzeptiert</strong>
                              <strong ng-if="goal.status == 'rejected'">Abgelehnt
                                <br/>
                                {{goal.notice}}
                              </strong>
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
                                <!--init="{{checkCount('groupOffer', 'capacity', goal, 1)}}"-->
																<div class="row" ng-init="checkCount('groupOffer', 'capacity', goal, 1)" >
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

																<div class="row" ng-init="checkCount('groupOffer', 'transition', goal, 1)">
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

																<div class="row" ng-init="checkCount('groupOffer', 'reintegration', goal, 1)">
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

																<div class="row" ng-init="checkCount('groupOffer', 'social_skill', goal, 1)">
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

																<div class="row" ng-init="checkCount('groupOffer', 'prevantion_violence', goal, 1)">
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

																<div class="row" ng-init="checkCount('groupOffer', 'health', goal, 1)">
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
																<div class="row" ng-init="checkCount('groupOffer', 'sport', goal, 1)">
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
																<div class="row" ng-init="checkCount('groupOffer', 'parent_skill', goal, 1)">
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
																<div class="row" ng-init="checkCount('groupOffer', 'other_goal', goal, 1)">
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
																<div class="row" ng-init="checkCount('groupNet', 'cooperation', goal, 1)">
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

																<div class="row" ng-init="checkCount('groupNet', 'participation', goal, 1)">
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

																<div class="row" ng-init="checkCount('groupNet', 'social_area', goal, 1)">
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

																<div class="row" ng-init="checkCount('groupNet', 'third_part', goal, 1)">
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

																<div class="row" ng-init="checkCount('groupNet', 'regional', goal, 1)">
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

																<div class="row" ng-init="checkCount('groupNet', 'concept', goal, 1)">
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
                                <div class="row" ng-init="checkCount('groupNet', 'net_other_goal', goal, 1)">
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
                            </div>
														<div class="row">
															<div ng-hide=" (userType != 'a' && userType != 'p') || goal.status == 'accepted' " class="col-lg-9">
																<h4 class="m-t-0">Prüfnotiz</h4>
																<textarea  ng-model="goal.notice" placeholder="Tragen Sie den Text hier ein" class="form-control"></textarea>
															</div>

															<div class="col-lg-3">

																<div class="m-t-30 text-right pull-right">
                                  <button ng-hide="userType != 't' || goal.status == 'accepted' || goal.status == 'in_progress'" class="btn w-lg btn-lg custom-btn m-b-10" ng-click="submitForm( goal, 'submit')">SENDEN</button>
																  <button ng-hide="goal.status == 'accepted' || (userType != 'a' && userType != 'p') " class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm( goal, 'accept')">AKZEPTIEREN</button>
                                  <button ng-hide="goal.status == 'rejected' || goal.status == 'accepted' || (userType != 'a' && userType != 'p') " ng-class="{disabled: !goal.notice}" ng-click="submitForm( goal, 'declare')" class="btn w-lg btn-lg btn-danger">ABLEHNEN</button>
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
