<div id="project" class="tab-pane active" ng-controller="RequestProjectDataController">
  <ng-form name="projectData" disable-all="{{!canEdit()}}">
    <div class="panel-group panel-group-joined m-0">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-lg-4 heading-title">
              <h2 class="panel-title">
                Projekt <strong>{{data.code}}</strong>
              </h2>
              <div class="m-t-10 holder-head-date custom-dl">
               <div class="wrap-data-project">
                  <span class="data-project">Letzte Änderung:</span>
                 <em ng-if="request.last_change">{{getDate(request.last_change)| date : 'dd.MM.yyyy'}} </em>
                 <em ng-if="!request.last_change">-</em>
               </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="heading-date">
                <strong>Abgabedatum für den Antrag:</strong>
                <div class="holder-head-date custom-dl m-t-10">
                  <i class="fa fa-calendar"></i>
                  <div class="wrap-data">
                    <div class="m-t-10">
                      <span>Abgabe:</span>
                      <em ng-if="request.end_fill">{{getDate(request.end_fill)| date : 'dd.MM.yyyy'}}</em>
                      <em ng-if="!request.end_fill">-</em>
                    </div>
                  </div>
                  <div class="btn-row" ng-show="userCan('dates')">
                    <button class="btn m-t-5" ng-click="setEndFillDate()">Datum ändern</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="heading-date">
                <strong>Beginn und Ende der Maßnahme:</strong>
                <div class="holder-head-date custom-dl  m-t-10">
                  <i class="fa fa-calendar"></i>
                  <div class="wrap-data">
                    <div>
                      <span>Beginn:</span>
                      
                      <em ng-if="request.start_date">{{getDate(request.start_date) | date : 'dd.MM.yyyy'}}</em>
                      <em ng-if="!request.start_date">-</em>
                    </div>
                    <div>
                      <span>Ende:</span>
                      <em ng-if="request.due_date">{{getDate(request.due_date)| date : 'dd.MM.yyyy'}}</em>
                      <em ng-if="!request.due_date">-</em>
                    </div>
                  </div>
                  <div class="btn-row" ng-show="userCan('dates')">
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
                  <a class="btn" ng-show="canFormEdit || user_type == 't'" href="performers#id={{data.performer_id}}" target="_blank" ng-click="setUpdater()" >Bearbeiten</a>
                </span>
              </h3>
              <hr/>
              <ng-show ng-show="data.performer_id">
                <strong>{{data.performer_long_name}}</strong>
                <span ng-if="+data.performer_is_checked">
                  <i class="ion-checkmark"></i>
                  {{data.performer_checked_by}}
                </span>

                <div class="row m-t-20">
                  <div class="col-lg-7">
                    <div class="col-lg-12 p-l-0 m-b-15">
                      <dl class="custom-dl width-dt-2 align-bottom">
                       <ng-show ng-show="data.performer_contact">
                          <dt>Vertretungsberechtigte Person:</dt>
                          <dd><strong>{{data.performer_contact}}</strong></dd>
                        </ng-show>
                      </dl>
                    </div>
                    <div class="row m-t-20 m-b-30">
                      <div class="col-lg-6">
                        <dl class="custom-dl width-dt-2">
                          <ng-show ng-show="data.performer_contact_function">
                            <dt>Funktion:</dt>
                            <dd class="request-webseite">{{data.performer_contact_function}}</dd>
                          </ng-show>
                          <ng-show ng-show="data.performer_address">
                            <dt>Adresse:</dt>
                            <dd class="request-webseite">{{data.performer_address}}</dd>
                          </ng-show>
                          <ng-show ng-show="data.performer_plz">
                            <dt>PLZ:</dt>
                            <dd class="request-webseite">{{data.performer_plz}}</dd>
                          </ng-show>
                          <ng-show ng-show="data.performer_city">
                            <dt>Stadt:</dt>
                            <dd class="request-webseite">{{data.performer_city}}</dd>
                          </ng-show>
                          <ng-show ng-show="data.performer_homepage">
                            <dt>Webseite:</dt>
                            <dd class="request-webseite"><a target="_blank" href="{{data.performer_homepage}}">{{data.performer_homepage}}</a></dd>
                          </ng-show>
                        </dl>
                      </div>
                      <div class="col-lg-6">
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
                            <dt>E-Mail:</dt>
                            <dd><a href="mailto:them@stiftungs-spi.de">{{data.performer_email}}</a></dd>
                          </ng-show>
                        </dl>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-5 custom-box-btn">
                    <h4 class="panel-title m-b-10">   
                      <label>
                        Ansprechperson für Rückfragen zum Konzept
                        <span spi-hint text="_hint.project_data_concept_user_id.text"  title="_hint.project_data_concept_user_id.title"  class="has-hint"></span>
                      </label>
                    </h4>
                    <div class="clearfix">
                      <div class="col-lg-9 p-l-0 m-b-15"  ng-class="{'wrap-line error': dublicate || required || concept_user_error}" >  
                      <input placeholder="Vorname Nachname" ng-keyup="escape($event)" ng-disabled="userLoading" 
                             ng-keypress="submitToAddUser($event, new_project_user)" ng-hide="!add_project_user" class="form-control popup-input" type="text" 
                             ng-model="new_project_user" ng-required="add_project_user" id="project_user">
                      <ui-select on-select="onSelectCallback($item, $model, 2);checkProjectError()" class="type-document" ng-model="request.concept_user_id" ng-disabled="!userCan('users')">
                        <ui-select-match allow-clear="true" placeholder="Bitte auswählen">{{$select.selected.name}}</ui-select-match>
                        <ui-select-choices repeat="item.id as item in  performerUsers | filter: $select.search | orderBy: 'name'">
                          <span ng-bind-html="item.name | highlight: $select.search"></span>
                        </ui-select-choices>
                      </ui-select>
                      <span ng-class="{hide: !(dublicate || required)}" class="hide">
                        <label ng-show="required" class="error">Füllen Sie die Daten</label>
                        <label ng-show="dublicate" class="error">Dieser Name existiert bereits</label>
                      </span>
                      </div>
                      <div class="col-lg-2 p-0 btn-row" ng-cloak ng-show="!add_project_user && (data.status_id == '3' || data.status_id == '1') && canEdit()" >
                        <button class="btn m-t-2 add-user" ng-click="addNewConceptUser()">&nbsp;</button>
                      </div>             
                      <div class="col-lg-3 p-0" ng-show="add_project_user && data.status_finance != 'accepted' && data.status_finance != 'acceptable' && canEdit()" >
                        <button class="btn m-t-2 confirm-btn" ng-click="submitToAddUser($event, new_project_user)">&nbsp;</button>
                        <button class="btn m-t-2 hide-btn" ng-click="addNewConceptUser()">&nbsp;</button>
                      </div>
                    </div>                   
                    <dl class="custom-dl" ng-show="selectConceptResult && !add_project_user">                      
<!--                      <ng-show ng-show="selectConceptResult.function">
                        <dt>Funktion:</dt>
                        <dd>{{selectConceptResult.function}}</dd>
                      </ng-show>
                      <ng-show ng-show="selectConceptResult.title">
                        <dt>Anrede:</dt>
                        <dd>{{selectConceptResult.gender}}</dd>
                      </ng-show>-->
                      <ng-show ng-show="selectConceptResult.phone">
                        <dt>Telefon:</dt>
                        <dd>{{selectConceptResult.phone}}</dd>
                      </ng-show>
                      <ng-show ng-show="selectConceptResult.email">
                        <dt>E-Mail:</dt>
                        <dd><a class="visible-lg-block" href="mailto:{{selectConceptResult.email}}">{{selectConceptResult.email}}</a></dd>
                      </ng-show>
                    </dl>
                  </div>
                </div>
              </ng-show>
            </div>
          </div>
          <h3 ng-if="length_schools(data.schools) > 0" class="panel-title m-b-15">
            {{length_schools(data.schools) > 1?'Schulen':'Schule'}}
          </h3>
          <div ng-if="length_schools(data.schools) > 0"  id="accordion-project" class="panel-group panel-group-joined">

            <div ng-repeat="school in data.schools" class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="collapse ng-binding collapsed _{{::school.id}}_" href="#_{{::school.id}}_" data-parent="#accordion-project" data-toggle="collapse">
                    {{school.name}} ({{school.number}})
                  </a>
                </h4>
              </div>
              <div class="panel-collapse collapse" id="_{{school.id}}_">
                <div class="panel-body">
                  <div class="row m-b-30 row-holder-dl">
                    <div class="col-lg-12">
                      <div class="btn-row m-b-15">
                        <a class="btn" ng-show="canFormEdit || user_type == 's'" href="schools#id={{school.id}}" target="_blank" ng-click="setUpdater()"  >Bearbeiten</a>
                      </div>                      
                    </div>
                    <div class="col-lg-5">
                      <dl class="custom-dl width-dt-2">
                        <ng-show ng-show="school.user_name">
                          <dt>Schulleitung:</dt>
                          <dd>{{school.user_name}}</dd>
                        </ng-show>
                        <ng-show ng-show="school.user_function">
                          <dt>Funktion:</dt>
                          <dd>{{school.user_function}}</dd>
                        </ng-show>
                      </dl>
                      <dl class="custom-dl width-dt-2">
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
                      </dl>
                    </div>
                    <div class="col-lg-7">
                      <dl class="custom-dl width-dt-2">
                        <ng-show ng-show="school.phone">
                          <dt>Telefon:</dt>
                          <dd>{{school.phone}}</dd>
                        </ng-show>
                        <ng-show ng-show="school.fax">
                          <dt>Fax:</dt>
                          <dd>{{school.fax}}</dd>
                        </ng-show>
                        <ng-show ng-show="school.email">
                          <dt>E-Mail:</dt>
                          <dd><a href="mailto:{{school.email}}">{{school.email}}</a></dd>
                        </ng-show>
                        <ng-show ng-show="school.homepage">
                          <dt>Webseite:</dt>
                          <dd class="request-webseite"><a target="_blank" href="{{school.homepage}}">{{school.homepage}}</a></dd>
                        </ng-show>                          
                      </dl>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <h3 class="panel-title">
            Angaben zum Jugendamt
            <span class="btn-row m-l-15">
              <a class="btn" ng-show="canFormEdit || user_type == 'd'" href="districts#id={{data.district_id}}" target="_blank" ng-click="setUpdater()">Bearbeiten</a>
            </span>
          </h3>
          <hr/>
          <div class="row" ng-show="data.district_id">
            <div class="col-lg-12 m-b-10">
              <dl class="custom-dl width-dt-2">
                <ng-show ng-show="data.district_name">
                  <dt>Bezirk:</dt>
                  <dd><strong>{{data.district_name}}</strong></dd>
                </ng-show>
                <ng-show ng-show="data.district_contact">
                  <dt>Jugendamtsleiter(in):</dt>
                  <dd><strong>{{data.district_contact}}</strong></dd>
                </ng-show>
              </dl>
            </div>
            <div class="col-lg-4">
              <dl class="custom-dl width-dt-2">
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
                <ng-show ng-show="data.district_homepage">
                  <dt>Webseite:</dt>
                  <dd class="request-webseite"><a target="_blank" href="{{data.district_homepage}}">{{data.district_homepage}}</a></dd>
                </ng-show>
              </dl>
            </div>
            <div class="col-lg-6">
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
                  <dt>E-Mail:</dt>
                  <dd><a href="mailto:{{data.district_email}}">{{data.district_email}}</a></dd>
                </ng-show>
              </dl>
            </div>
          </div>
        </div>
        <hr/>
        <div class="row">
          <div class="col-lg-12">
            <h4 class="m-t-0">Zusätzliche Information (z.B. Ansprechperson im Jugendamt)</h4>
            <textarea ng-disabled="!userCan('additional_info')" placeholder="Tragen Sie den Text hier ein" ng-model="request.additional_info" class="form-control"></textarea>
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-lg-4 form-horizontal" ng-if="user_type == 'a' || user_type == 'p'">
            <h4>Druck-Template wählen</h4>
            <div class="form-group">
              <label class="col-lg-4 control-label">Zielvereinbarung:</label>
              <div class="col-lg-8">
                <ui-select ng-change="" class="type-document" ng-model="request.doc_target_agreement_id" ng-disabled="!userCan('templates')">
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
                <ui-select ng-change="" class="type-document" ng-model="request.doc_request_id" ng-disabled="!userCan('templates')">
                  <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                  <ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search | filter:{type_code:'request_agreement'} | orderBy: 'name'">
                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                  </ui-select-choices>
                </ui-select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label">Fördervertrag:</label>
              <div class="col-lg-8">
                <ui-select ng-change="" class="type-document" ng-model="request.doc_financing_agreement_id" ng-disabled="!userCan('templates')">
                  <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                  <ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search | filter:{type_code:'funding_agreement'} | orderBy: 'name'">
                    <span ng-bind-html="item.name | highlight: $select.search"></span>
                  </ui-select-choices>
                </ui-select>
              </div>
            </div>
          </div>
          <div class="col-lg-{{user_type == 'a' || user_type == 'p' ? '8' : '12'}}">
            <h4>Auflage</h4>
            <textarea ng-disabled="!userCan('senat_additional_info')" class="form-control custom-height-textarea" placeholder="Tragen Sie den Text hier ein" ng-model="request.senat_additional_info" class="form-control"></textarea>
          </div>
        </div>
      </div>
    </div>
  </ng-form>
</div>
