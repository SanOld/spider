
  <div class="tab-pane" ng-controller="RequestSchoolGoalController">
    <div id="accordion-order" class="panel-group panel-group-joined">

      <div ng-repeat="school in schoolGoals" class="panel panel-default">
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
                    <strong ng-if="goal.status == 'accepted'">Genehmigt</strong>
                    <strong ng-if="goal.status == 'rejected'">Ablehnen
                      <br/>
                      {{goal.notice}}
                    </strong>
                  </div>

                  <h4>{{::goal.name}}</h4>
                  <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal.description) && errorShow)}">
                    <textarea  ng-model="goal.description" name="description" class="form-control" placeholder="Tragen Sie den Text hier ein here" ></textarea>

                    <span ng-class="{hide: !(fieldError(goal.description)  && errorShow)}" class="hide">
                      <label  class="error">Feld ist erforderlich</label>
                      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    </span>
                    <br>
                  </div>


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

                      <div class="row" ng-init="checkCount('groupOffer', 'capacity', goal, 1)" >
                        <div class="label-holder col-lg-2">
                          <label class="cr-styled">
                            <input type="radio" value="1" ng-model="goal.capacity" ng-change="checkCount('groupOffer', 'capacity', goal)">
                            <i class="fa"  ng-class="{'err': goal.groups.groupOffer.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupOffer.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupOffer.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupOffer.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupOffer.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupOffer.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupOffer.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupOffer.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupOffer.error === '1'  && errorShow}"></i>
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
                  <div class="wrap-hint" ng-class="{'wrap-line error': (groupError(goal.groups.groupOffer) && errorShow)}">

                    <span ng-class="{hide: !(groupError(goal.groups.groupOffer) && errorShow)}" class="hide">
                      <label  class="error">Wählen Sie Ziel</label>
                      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    </span>

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
                          <label class="cr-styled" >
                            <input type="radio" value="1" ng-model="goal.cooperation" ng-change="checkCount('groupNet', 'cooperation', goal)" >
                            <i class="fa" ng-class="{'err': goal.groups.groupNet.error === '1'  && errorShow}" ></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupNet.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupNet.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupNet.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupNet.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupNet.error === '1'  && errorShow}"></i>
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
                            <i class="fa" ng-class="{'err': goal.groups.groupNet.error === '1'  && errorShow}"></i>
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
                  <div class="wrap-hint" ng-class="{'wrap-line error': (groupError(goal.groups.groupNet) && errorShow)}">
                    <span ng-class="{hide: !(groupError(goal.groups.groupNet) && errorShow)}" class="hide">
                      <label  class="error">Wählen Sie Ziel</label>
                      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    </span>
                    <br>
                  </div>


                  <h4 class="m-t-40">Umsetzung</h4>

                  <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal.implementation) && errorShow)}">
                    <textarea ng-model="goal.implementation" class="form-control" placeholder="Tragen Sie den Text hier ein"></textarea>

                    <span ng-class="{hide: !(fieldError(goal.implementation)  && errorShow)}" class="hide">
                      <label  class="error">Feld ist erforderlich</label>
                      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    </span>
                    <br>
                  </div>
                  <h4 class="m-t-40">Indikatoren und Zielwerte</h4>
                  <p class="">Formulierung von Indikatoren und Zielwerten zur Messung der Zielerreichung</p>
                  <div class="form-horizontal m-t-15">
                    <div class="form-group">
                      <label class="col-lg-1 control-label">
                        1.
                      </label>
                      <div class="col-lg-11">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal.indicator_1) && errorShow)}">
                          <input type="text" ng-model="goal.indicator_1" value="" class="form-control">

                          <span ng-class="{hide: !(fieldError(goal.indicator_1)  && errorShow)}" class="hide">
                            <label  class="error">Feld ist erforderlich</label>
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                          </span>
                          <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-1 control-label">
                        2.
                      </label>
                      <div class="col-lg-11">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal.indicator_2) && errorShow)}">
                          <input type="text" ng-model="goal.indicator_2" value="" class="form-control">

                          <span ng-class="{hide: !(fieldError(goal.indicator_2)  && errorShow)}" class="hide">
                            <label  class="error">Feld ist erforderlich</label>
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                          </span>
                          <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-1 control-label">
                        3.
                      </label>
                      <div class="col-lg-11">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal.indicator_3) && errorShow)}">
                          <input type="text" ng-model="goal.indicator_3" value="" class="form-control">

                          <span ng-class="{hide: !(fieldError(goal.indicator_3)  && errorShow)}" class="hide">
                            <label  class="error">Feld ist erforderlich</label>
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                          </span>
                          <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-1 control-label">
                        4.
                      </label>
                      <div class="col-lg-11">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal.indicator_4) && errorShow)}">
                          <input type="text" ng-model="goal.indicator_4" value="" class="form-control">

                          <span ng-class="{hide: !(fieldError(goal.indicator_4)  && errorShow)}" class="hide">
                            <label  class="error">Feld ist erforderlich</label>
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                          </span>
                          <br>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-1 control-label">
                        5.
                      </label>
                      <div class="col-lg-11">
                        <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal.indicator_5) && errorShow)}">
                          <input type="text" ng-model="goal.indicator_5" value="" class="form-control">

                          <span ng-class="{hide: !(fieldError(goal.indicator_5)  && errorShow)}" class="hide">
                            <label  class="error">Feld ist erforderlich</label>
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                          </span>
                          <br>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr />
                  </div>
                  <div class="row">
                    <div ng-hide=" (userType != 'a' && userType != 'p') || goal.status == 'accepted' || goal.status == 'rejected' " class="col-lg-9">
                      <h4 class="m-t-0">Prüfnotiz</h4>
                      <textarea  ng-model="goal.notice" placeholder="Tragen Sie den Text hier ein" class="form-control"></textarea>
                    </div>

                    <div class="col-lg-3 text-right pull-right" >

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

