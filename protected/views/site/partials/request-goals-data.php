
  <div class="tab-pane" id="schools-goals" class="schools-goals" ng-controller="RequestSchoolGoalController">
    <div id="accordion-order" class="panel-group panel-group-joined">
    <form name="goalsForm" novalidate>
      <div ng-repeat="school in schoolGoals" class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a ng-if="school.school_name" data-toggle="collapse" data-parent="#accordion-order" href="#collapse_{{$index}}"  class="collapse ng-binding " ng-class="!($first && $first == $last) ? 'collapsed' : ''" aria-expanded="{{!($first && $first == $last)}}">
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
              <div class="nav tabs-vertical" id="goals-div-{{$index}}">
                  <ul id="goals-list-{{$index}}" class="nav">
                    <li ng-repeat="goal in school.goals" ng-class="getActivateTab() == goal.id ? 'active' : '' "  class="{{$index == 0 ? 'active' : ''}}" >
                      <button  class="goals" ng-click="activateTab(school.goals);deleteGoal(goal.id);" ng-if="goal.option == 1 && goal.is_active == 1 && userCan('allFields', goal.status)">
                        <i class="ion-close-round"></i>
                      </button>
                      <a ng-click="scrollUp(school.school_number)" class="goal_{{goal.id}}" data-toggle="tab" href="#goal_{{::goal.id}}" ng-if="goal.is_active == 1">
                      <span class="notice">
                        <span  class="color-notice {{goal.status}}-row"></span>
                      </span>
                      Entwicklungziel {{goal.goal_number}}<span ng-if="goal.option == 1"> (optional)</span></a>
                    </li>
                  <button id="goals-button-{{$index}}" ng-if="canGoalsEdit();" class="btn button-new-goal-width" ng-click="addGoal(school.goals)" ng-hide="school.counter >= 5">Weiteres Entwicklungsziel hinzufügen</button>
                  </ul>
              </div>

              <div class="tab-content" >
                <div ng-repeat="goal in school.goals" id="goal_{{goal.id}}" class="tab-pane {{$index == 0 ? 'active' : ''}}" >
                  <div>
                    <div ng-hide="goal.status == 'unfinished'" class="alert-{{goal.status}} alert" >
                      <strong ng-if="goal.status == 'in_progress'">Zur Prüfung übermittelt
                        <br/>
                        {{goal.notice}}
                      </strong>
                      <strong ng-if="goal.status == 'accepted'">Geprüft</strong>
                      <strong ng-if="goal.status == 'rejected'">Anmerkung der Programmagentur
                        <br/>
                        {{goal.notice}}
                      </strong>
                    </div>
                    <label class="control-label">
                        <h4> Entwicklungziel {{::goal.goal_number}}</h4> <span spi-hint text="_hint.goals_goal.text" title="_hint.goals_goal.title" class="has-hint"></span>
                    </label>
                    <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal, 'description') && goal.showError)}">
                        <textarea ng-disabled="!userCan('allFields', goal.status)"  required ng-model="goal.description" name="description" class="form-control" placeholder="Tragen Sie den Text hier ein" ></textarea>

                      <span ng-class="{hide: !(fieldError(goal, 'description')  && goal.showError)}" class="hide">
                        <label  class="error">Feld ist erforderlich</label>
                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                      </span>
                      <br>
                    </div>
                    <span  ng-if="goal.total_count > 2" >                        
                      <br>
                      <label  class="error">Bitte wählen Sie nicht mehr als zwei Schwerpunktziele aus. Formulieren Sie bei Bedarf unter "sonstiges" ein eigenes Ziel.</label>
                    </span>
                    <label class="control-label">
                      <h4>Programmschwerpunkte</h4>
                      <span spi-hint text="_hint.goals_groupOffer.text"  title="_hint.goals_groupOffer.title" class="has-hint"></span>
                    </label>
                    <div class="holder-radio">
                      <div class="p-0 text-center">
                        <div class="row">
                          <span class="col-lg-2">Schwerpunktziel</span>
                          <span class="col-lg-1">Weiteres Ziel</span>
                          <span class="col-lg-1">kein Ziel</span>
                        </div>
                        <div ng-repeat="single_goal in goal.goals">
                          <div class="row" ng-init="checkCount(goal, goal.goals)">
                            <div class="label-holder col-lg-2">
                              <label class="cr-styled">
                                <input ng-disabled="!userCan('allFields', goal.status)" type="radio" value="1" ng-model="single_goal.value" ng-change="checkCount(goal, goal.goals)">
                                <i class="fa" ng-class="{'err': goal.errors.total_count < 1 && goal.showError}"></i>
                              </label>
                            </div>
                            <div class="label-holder col-lg-1">
                              <label class="cr-styled">
                                <input ng-disabled="!userCan('allFields', goal.status)" type="radio" value="2" ng-model="single_goal.value" ng-change="checkCount(goal, goal.goals)">
                                <i class="fa"></i>
                              </label>
                            </div>
                            <div class="label-holder col-lg-1">
                              <label class="cr-styled">
                                <input ng-disabled="!userCan('allFields', goal.status)" type="radio" value="0" ng-model="single_goal.value" ng-change="checkCount(goal, goal.goals)" checked="">
                                <i class="fa"></i>
                              </label>
                            </div>
                            <p class="col-lg-8">{{single_goal.name}}</p>
                          </div>
                          <div class="col-lg-8 pull-right textarea-box" ng-show="single_goal.is_with_desc == '1' && single_goal.value > 0">
                            <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal, 'single_description',school, 'additional') && goal.showError)}">
                              <textarea ng-disabled="!userCan('allFields', goal.status)" placeholder="Tragen Sie den Text hier ein" ng-model="single_goal.description" class="form-control"></textarea>
                              <span ng-class="{hide: !(fieldError(goal, 'single_description',school, 'additional')  && goal.showError)}" class="hide">
                                <label class="error">Feld ist erforderlich</label>
                                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                              </span>
                              <br>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="wrap-hint" ng-class="{'wrap-line error': (goal.total_count < 1 && goal.showError)}">
                        <span ng-class="{hide: !(goal.total_count < 1 && goal.showError)}" class="hide">
                          <label  class="error">Wählen Sie ein Schwerpunktziel</label>
                        </span>
                      </div>
                    </div>
                    <label class="control-label">
                      <h4>Umsetzung</h4>
                      <span spi-hint text="_hint.implementation.text" title="_hint.implementation.title" class="has-hint"></span>
                    </label>
                    <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal, 'implementation') && goal.showError)}">
                      <textarea ng-disabled="!userCan('allFields', goal.status)" required ng-model="goal.implementation" class="form-control" placeholder="Tragen Sie den Text hier ein"></textarea>

                      <span ng-class="{hide: !(fieldError(goal, 'implementation')  && goal.showError)}" class="hide">
                        <label  class="error">Feld ist erforderlich</label>
                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                      </span>
                      <br>
                    </div>
                    <label class="control-label">
                      <h4>Indikatoren und Zielwerte</h4>
                      <span spi-hint text="_hint.indicators.text" title="_hint.indicators.title" class="has-hint"></span>
                    </label>                    
                    <p class="">Formulierung von Indikatoren und Zielwerten zur Messung der Zielerreichung</p>
                    <div class="form-horizontal m-t-15">
                      <div class="form-group">
                        <label class="col-lg-1 control-label">
                          1.
                        </label>
                        <div class="col-lg-11">
                          <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal, 'indicator_1') && goal.showError)}">
                            <input ng-disabled="!userCan('allFields', goal.status)" type="text" required ng-model="goal.indicator_1" value="" class="form-control">

                            <span ng-class="{hide: !(fieldError(goal, 'indicator_1')  && goal.showError)}" class="hide">
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
                          <div class="wrap-hint" ng-class="{'wrap-line error': (fieldError(goal, 'indicator_2') && goal.showError)}">
                            <input ng-disabled="!userCan('allFields', goal.status)" type="text" required ng-model="goal.indicator_2" value="" class="form-control">

                            <span ng-class="{hide: !(fieldError(goal, 'indicator_2')  && goal.showError)}" class="hide">
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
                          <div class="wrap-hint">
                            <input ng-disabled="!userCan('allFields', goal.status)" type="text" ng-model="goal.indicator_3" value="" class="form-control">
                            <br>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-1 control-label">
                          4.
                        </label>
                        <div class="col-lg-11">
                          <div class="wrap-hint">
                            <input ng-disabled="!userCan('allFields', goal.status)" type="text" ng-model="goal.indicator_4" value="" class="form-control">
                            <br>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-1 control-label">
                          5.
                        </label>
                        <div class="col-lg-11">
                          <div class="wrap-hint">
                            <input ng-disabled="!userCan('allFields', goal.status)" type="text" ng-model="goal.indicator_5" value="" class="form-control">
                            <br>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr />
                    <div class="row">
                    <div ng-show=" userCan('textNotice', goal.status) " class="col-lg-9 ">
                      <h4 class="m-t-0">Prüfnotiz</h4>
                      <textarea ng-disabled="!userCan('allFields', goal.status) && !userCan('textNotice', goal.status)"  ng-model="goal.newNotice" placeholder="Tragen Sie den Text hier ein" class="form-control"></textarea>
                    </div>

                    <div class="col-lg-3 text-right pull-right" >

                      <div class="m-t-30 text-right pull-right">
<!--                        <button ng-show=" userCan('btnSenden', goal.status) && canEdit()" class="btn w-lg btn-lg custom-btn m-b-10" ng-click="submitForm( goal, 'submit')" title="Antragsteil zur Prüfung übermitteln">SENDEN</button>-->
                        <button ng-show=" userCan('btnAccept', goal.status) && canEdit()"  class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm( goal, 'accept')">AKZEPTIEREN</button>
                        <button ng-show=" userCan('btnReject', goal.status) && canEdit()" ng-class="{disabled: !goal.newNotice}" ng-click="submitForm( goal, 'declare')" class="btn w-lg btn-lg btn-danger">ANMERKUNG</button>
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
      
   </form>
  </div>
</div>

