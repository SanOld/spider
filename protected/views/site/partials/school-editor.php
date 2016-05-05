<script type="text/ng-template" id="EditSchoolTemplate.html">

  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left" ng-if="!isInsert && !modeView">Schule bearbeiten - {{school.number}}</h3>
      <h3 class="m-0 pull-left" ng-if="!isInsert && modeView">Schule ansicht - {{school.number}}</h3>
      <h3 class="m-0 pull-left" ng-if="isInsert">Schule hinzufügen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>

    <div class="panel-body p-t-0">
      <form novalidate name="form">
        <uib-tabset>
          <uib-tab heading="Stammdaten">
            <ng-form name="formSchool" class="form-horizontal" disable-all="!canEditSchool() || modeView">
              <div class="row m-t-30">
                <div ng-class="isInsert ? 'col-lg-12' : 'col-lg-9'">
                  <h3 class="subheading m-0">Allgemeine Information</h3>
                  <hr>
                  <div class="clearfix">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="col-lg-4 control-label">Name</label>
                        <div class="col-lg-8">
                          <div spi-hint text="_hint.name" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('name')}">
                            <input name="name" ng-model="school.name" class="form-control" type="text" value="" required ng-disabled="!canEdit()">
                            <span ng-class="{hide: !fieldError('name')}" class="hide">
                              <label ng-show="form.formSchool.name.$error.required" class="error">Name is required</label>
                              <label ng-show="error.name.dublicate" class="error">This Name already exists</label>
                              <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-4 control-label">Bezirk</label>

                        <div class="col-lg-8">
                          <div spi-hint text="_hint.district_id" class="has-hint"></div>
                          <span ng-if="!canEdit() || modeView" ng-bind="districtName"></span>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('district_id')}" ng-if="canEdit() && !modeView">
                            <ui-select ng-disabled="!$select.items.length" ng-model="school.district_id"
                                       name="district_id" required>
                              <ui-select-match
                                placeholder="{{$select.disabled ? '(No items available)' :'(Please choose)'}}">
                                {{$select.selected.name}}
                              </ui-select-match>
                              <ui-select-choices repeat="item.id as item in districts | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                            <span ng-class="{hide: !fieldError('district_id')}" class="hide">
                              <label ng-show="form.formSchool.district_id.$error.required" class="error">Bezirk is
                                required</label>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" ng-if="!(modeView && !school.address)">
                        <label class="col-lg-4 control-label">Adresse</label>
                        <div class="col-lg-8">
                          <div spi-hint text="_hint.address" class="has-hint"></div>
                          <div class="wrap-hint">
                            <textarea name="address" ng-model="school.address" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" ng-if="!(modeView && !school.plz)">
                        <label class="col-lg-4 control-label">PLZ</label>

                        <div class="col-lg-8">
                          <div spi-hint text="_hint.plz" class="has-hint"></div>
                          <div class="wrap-hint">
                            <input name="plz" ng-model="school.plz" type="text" value="" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-group" ng-if="!(modeView && !school.city)">
                        <label class="col-lg-4 control-label">Stadt</label>

                        <div class="col-lg-8">
                          <div spi-hint text="_hint.city" class="has-hint"></div>
                          <div class="wrap-hint">
                            <input name="city" ng-model="school.city" type="text" value="Berlin" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-5 col-lg-offset-1">
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Schul-Nr.</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.number" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('number')}">
                            <input name="number" ng-model="school.number" class="form-control" type="text" value="" required  ng-disabled="!canEdit()">
                            <span ng-class="{hide: !fieldError('number')}" class="hide">
                              <label ng-show="form.formSchool.number.$error.required" class="error">Schul-Nr. is
                                required</label>
                              <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Schultyp</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.type_id" class="has-hint"></div>
                          <span ng-if="!canEdit() || modeView" ng-bind="schoolName"></span>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('type_id')}" ng-if="canEdit() && !modeView">
                            <ui-select ng-change="setNumber(school.type_id)" ng-disabled="!$select.items.length" ng-model="school.type_id" name="type_id"
                                       required>
                              <ui-select-match
                                placeholder="{{$select.disabled ? '(No items available)' :'(Please choose)'}}">
                                {{$select.selected.name}}
                              </ui-select-match>
                              <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                            <span ng-class="{hide: !fieldError('type_id')}" class="hide">
                              <label ng-show="form.formSchool.type_id.$error.required" class="error">Schultyp is
                                required</label>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" ng-if="!(modeView && !school.phone)">
                        <label class="col-lg-3 control-label">Telefon</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.phone" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('phone')}">
                            <input name="phone" ng-model="school.phone" type="text" value="" class="form-control" ng-pattern="/^[^A-Za-z]*$/">
                            <span ng-class="{hide: !fieldError('phone')}" class="hide">
                              <label ng-show="form.formSchool.phone.$error.pattern" class="error">Telefon must not contain letters</label>
                              <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" ng-if="!(modeView && !school.fax)">
                        <label class="col-lg-3 control-label">Fax</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.fax" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('fax')}">
                            <input name="fax" ng-model="school.fax" type="text" value="" class="form-control" ng-pattern="/^[^A-Za-z]*$/">
                            <span ng-class="{hide: !fieldError('fax')}" class="hide">
                              <label ng-show="form.formSchool.fax.$error.pattern" class="error">Fax must not contain letters</label>
                              <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" ng-if="!(modeView && !school.email)">
                        <label class="col-lg-3 control-label">Email</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.email" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('email')}">
                            <input name="email" ng-model="school.email" type="email" value="" class="form-control">
                            <span ng-class="{hide: !fieldError('email')}" class="hide">
                              <label ng-show="form.formSchool.email.$error.email" class="error">Enter a valid email</label>
                              <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" ng-if="!(modeView && !school.homepage)">
                        <label class="col-lg-3 control-label">Webseite</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.homepage" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('homepage')}">
                            <input name="homepage" ng-model="school.homepage" type="text" value=""
                                   ng-pattern="/^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$/"
                                   class="form-control">
                            <span ng-class="{hide: !fieldError('homepage')}" class="hide">
                              <label ng-show="form.formSchool.homepage.$error.pattern" class="error">Enter a valid
                                webseite</label>
                              <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div ng-if="!isInsert" class="col-lg-3 schoole-contact">
                  <h3 class="m-t-0 m-b-15">Ansprechpartner(in)</h3>
                  <span ng-if="!canEdit() || modeView" ng-bind="contactUser.name || '-'"></span>
                  <span spi-hint text="_hint.contact_id" class="{{canEdit() && !modeView ? 'has-hint' : ''}}"></span>
                  <div class="wrap-hint" ng-if="canEdit() && !modeView">
                    <ui-select ng-disabled="!$select.items.length" ng-change="changeContactUser(school.contact_id)"
                               ng-model="school.contact_id" name="contact_id">
                      <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(No chosen)'}}">
                        {{$select.selected.name}}
                      </ui-select-match>
                      <ui-select-choices repeat="item.id as item in users | filter: $select.search">
                        <span ng-bind-html="item.name | highlight: $select.search"></span>
                      </ui-select-choices>
                    </ui-select>
                  </div>
                  <dl ng-if="contactUser">
                    <dt>Funktion</dt>
                    <dd ng-bind="contactUser.function || '-'"></dd>
                    <dt>Titel</dt>
                    <dd ng-bind="contactUser.title || '-'"></dd>
                    <dt>Telefon</dt>
                    <dd ng-bind="contactUser.phone || '-'"></dd>
                    <dt>Email</dt>
                    <dd ng-bind="contactUser.email || '-'"></dd>
                  </dl>
                </div>
              </div>
              <hr/>
              <div class="form-group group-btn m-t-15">
                <div class="col-lg-2" ng-if="!isInsert && canEdit() && !modeView">
                  <a ng-click="remove()" class="btn btn-icon btn-danger btn-lg sweet-4"><i
                      class="fa fa-trash-o"></i></a>
                </div>
                <div class="col-lg-10 text-right pull-right">
                  <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
                  <button ng-if="canEditSchool() && !modeView" class="btn w-lg custom-btn" ng-click="submitFormSchool()">Speichern</button>
                </div>
              </div>
            </ng-form>
          </uib-tab>

          <uib-tab heading="Benutzer" ng-if="!isInsert" ng-init="page = 's'; relationId = schoolId"
                   ng-if="canView('user')">
            <div class="holder-tab" ng-controller="UserController">
              <div class="panel-body edit-user agency-tab-user">
                <div>
                  <div class="col-lg-12">
                    <div class="row datafilter">
                      <ng-form class="class-form">
                        <div class="col-lg-7">
                          <div class="form-group">
                            <label>Suche nach Name, Benutzername oder Email</label>
                            <input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control"
                                   placeholder="Stichwort eingegeben">
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label>Status</label>
                            <ui-select append-to-body="true" ng-change="updateGrid()" class=""
                                       ng-model="filter.is_active" theme="select2">
                              <ui-select-match allow-clear="true" placeholder="Alles anzeigen">
                                {{$select.selected.name}}
                              </ui-select-match>
                              <ui-select-choices repeat="item.id as item in statuses | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
                        </div>
                        <div class="col-lg-2 reset-btn-width">
                          <button ng-click="resetFilter()" class="btn w-lg custom-reset"><i
                              class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                        </div>
                      </ng-form>
                    </div>
                    <?php include(Yii::app()->getBasePath() . '/views/site/partials/users-table.php'); ?>
                  </div>
                </div>
              </div>
            </div>
          </uib-tab>
        </uib-tabset>
      </form>
    </div>
  </div>
</script>