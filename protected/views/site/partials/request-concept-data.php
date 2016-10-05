<div class="tab-pane" ng-controller="RequestSchoolConceptController">
  <div class="panel-group panel-group-joined" id="accordion-concepts">
    <form name="conceptForm" novalidate >
    <div class="panel panel-default" ng-repeat="schoolConcept in schoolConcepts">
      <div class="panel-heading" >
        <h4 class="panel-title">
          <a ng-if="schoolConcept.school_name" data-toggle="collapse" data-parent="#accordion-concepts" href="#collapse-{{::schoolConcept.id}}" ng-class="{collapsed: schoolConcepts.length > 1}" class="collapse collapse-{{::schoolConcept.id}}">
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
          <ng-form name="schoolForm{{$index}}" disable-all="{{schoolConcept.status == 'accepted' || !canEdit()}}">
          <div ng-class="{current: conceptTab[schoolConcept.id] == 'data'}" id="tab-data-{{::schoolConcept.id}}" class="block-concept current">
            <div ng-if="schoolConcept.status && schoolConcept.status != 'unfinished'" class="alert" ng-class="{'alert-danger': schoolConcept.status == 'rejected', 'alert-success': schoolConcept.status == 'accepted', 'alert-warning': schoolConcept.status == 'in_progress'}">
              <div ng-switch="schoolConcept.status">
                <strong ng-switch-when="rejected">Anmerkung der Programmagentur</strong>
                <strong ng-switch-when="accepted">Geprüft</strong>
                <strong ng-switch-when="in_progress">Zur Prüfung übermittelt</strong>
              </div>
              <div ng-if="schoolConcept.comment && (schoolConcept.status == 'rejected' || schoolConcept.status == 'in_progress')" ng-bind="schoolConcept.comment"></div>
            </div>
            <div class="concept-form-block {{textareaClass}}">
                <div class="wrap-area">
                  <div class="form-group">
                    <label class="control-label">
                      1. Situation an der Schule<span spi-hint text="_hint.school_concept_situation.text"  title="_hint.school_concept_situation.title"  class="has-hint"></span>
                    </label>
                    <div class="wrap-hint"  ng-class="{'wrap-line error': fieldError($index, 'situation') && conceptShowErrors && !fullscreen}">
                      <textarea id="area-{{::schoolConcept.id}}-1" name="situation"
                                  class="form-control custom-height animate-textarea textarea-2" ng-model="school_concept[schoolConcept.id].situation"
                                  placeholder="Tragen Sie den Text hier ein" ng-focus="textareaClass == 'area-1' ? type = 'situation' : type = 'offers_youth_social_work'; schoolConcept.oldValue = school_concept[schoolConcept.id].situation"
                                  ng-readonly="!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted'" required></textarea>                      
                        <div class="btn-row" ng-if="!isTextareaShow && !(!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted')">
                          <button class="btn m-t-2 fullscreen1" ng-class="{'textarea-fullscreen-error': fieldError($index, 'situation') && conceptShowErrors && !fullscreen}"
                                  ng-click="textOnFocus(schoolConcept.id, 1, schoolConcept.status)"> &nbsp;</button>
                        </div>                     
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label">
                      2. Angebote der Jugendsozialarbeit an der Schule<span spi-hint text="_hint.school_concept_offers_youth_social_work.text"  title="_hint.school_concept_offers_youth_social_work.title"  class="has-hint"></span>
                    </label>
                    <div class="wrap-hint"  ng-class="{'wrap-line error': fieldError($index, 'offers_youth_social_work') && conceptShowErrors && !fullscreen}">
                      <textarea id="area-{{::schoolConcept.id}}-2" name="offers_youth_social_work"
                                  class="form-control custom-height animate-textarea textarea-2" ng-model="school_concept[schoolConcept.id].offers_youth_social_work"
                                  placeholder="Tragen Sie den Text hier ein" ng-focus="textareaClass == 'area-1' ? type = 'situation' : type = 'offers_youth_social_work'; schoolConcept.oldValue = school_concept[schoolConcept.id].offers_youth_social_work "
                                  ng-readonly="!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted'" required></textarea>                      
                      <div class="btn-row" ng-if="!isTextareaShow && !(!canFormEdit || (schoolConcept.status == 'in_progress' && !canAccept) || schoolConcept.status == 'accepted')">
                        <button class="btn m-t-2 fullscreen2" ng-class="{'textarea-fullscreen-error': fieldError($index, 'offers_youth_social_work') && conceptShowErrors && !fullscreen}"
                                ng-click="textOnFocus(schoolConcept.id, 2, schoolConcept.status)"> &nbsp;</button>
                      </div>
                    </div>
                  </div>
                </div>
                <hr ng-show="((canFormEdit && schoolConcept.status != 'in_progress') || canAccept) && schoolConcept.status != 'accepted' && canAcceptEarly(schoolConcept.status)">
                <div class="row" ng-show="isTextareaShow">
                  <div class="clearfix"><div class="col-lg-4 col-lg-offset-8 text-right button-textarea">
                      <button class="btn w-lg ng-scope" ng-click="exit(schoolConcept.id, schoolConcept.school_id, textareaClass, schoolConcept.id, type)">Abbrechen</button>
                      <button class="btn w-lg cancel-btn custom-btn" ng-click="saveText(schoolConcept.id, school_concept[schoolConcept.id], type, textareaClass, schoolConcept.school_id)" ng-show="canSave">OK</button>
                    </div>
                  </div>
                </div>
                <div class="row" ng-if="schoolConcept.status != 'accepted' && canAcceptEarly(schoolConcept.status)">
                  <div class="col-lg-10">
                      <span ng-if="canAccept && schoolConcept.status != 'rejected'">
                        <h4 class="m-t-0">Prüfnotiz</h4>
                        <textarea placeholder="Tragen Sie den Text hier ein" ng-model="school_concept[schoolConcept.id].comment" class="form-control comments"></textarea>
                      </span>
                  </div>
                  <div class="col-lg-2">
                    <div class="m-t-30 text-right pull-right" ng-if="canAccept">
                      <button ng-hide="schoolConcept.status == 'accepted' || !canEdit()" class="btn w-lg btn-lg btn-success m-b-10" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'accept', $index)">AKZEPTIEREN</button>
                      <button ng-hide="schoolConcept.status == 'rejected' || !canEdit()" ng-class="{disabled: !school_concept[schoolConcept.id].comment}" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'reject', $index)" class="btn w-lg btn-lg btn-danger">ANMERKUNG</button>
                    </div>
<!--                    <div class="text-right pull-right" ng-if="canFormEdit && !isTextareaShow && !canAccept && schoolConcept.status != 'in_progress' && schoolConcept.status != 'accepted' && canEdit()">
                      <h4 class="m-t-0"></h4>
                      <button class="btn w-lg btn-lg custom-btn m-b-10" ng-click="submitForm(school_concept[schoolConcept.id], schoolConcept, 'submit', $index)" title="Antragsteil zur Prüfung übermitteln">SENDEN</button>
                    </div>-->
                  </div>
                </div>
            </div>
          </div>
          </ng-form>
          <div ng-class="{current: conceptTab[schoolConcept.id] == 'history'}" id="tab-history-{{::schoolConcept.id}}" class="tab-history block-concept">
            <div ng-repeat-start="history in schoolConcept.histories" ng-if="::history.changes" class="changes-content">
              <div class="heading-changes" data-toggle="collapse">
                Inhaltsveränderungen
                <i class="ion-chevron-down arrow-box"></i>
              </div>
              <div class="content-changes">
                <div class="thead">
                  <div class="col-lg-4 p-l-0">
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
                    <div class="col-lg-4 p-l-0">
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
              <strong class="status-history" ng-bind="::history.status_name">Geprüft</strong>
              <span class="check-history">Überpüft von {{::history.user_name}} {{::history.date}}</span>
              <p class="check-text-history" ng-bind="::history.comment"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    </form>
  </div>
</div>