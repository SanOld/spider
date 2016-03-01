<?php
$this->pageTitle = 'Bezirk | ' . Yii::app()->name;
$this->breadcrumbs = array('Bezirk');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/districts.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/schools.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

<div ng-controller="DistrictController" ng-cloak class="wraper container-fluid">
  <div class="row">
    <div class="container center-block">
      <div spi-hint-main title="_hint.header.title" text="_hint.header.text"></div>
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h1 class="panel-title col-lg-6">Bezirk</h1>

          <div class="pull-right heading-box-print">
            <a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
            <button class="btn w-lg custom-btn" ng-if="canEdit()" ng-click="openEdit()">Bezirk hinzufügen</button>
          </div>
        </div>
        <div class="panel-body districts">
          <div class="row">
            <div class="col-lg-12">
              <div class="row datafilter">
                <form class="class-form">
                  <div class="col-lg-10">
                    <div class="form-group">
                      <label>Suche nach Namen, Adresse oder Ansprechpartner(in)</label>
                      <input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control"
                             placeholder="Eingegeben">
                    </div>
                  </div>
                  <div class="col-lg-2 reset-btn-width">
                    <button ng-click="resetFilter()" class="btn w-lg custom-reset"><i
                        class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                  </div>
                </form>
              </div>

              <table id="datatable" ng-cloak ng-table="tableParams"
                     class="table dataTable table-hover table-bordered table-edit">
                <tr ng-repeat="row in $data">
                  <td data-title="'Name'" sortable="'name'">{{row.name}}</td>
                  <td data-title="'Adresse'" sortable="'address'">{{row.address}}</td>
                  <td data-title="'Ansprechpartner(in)'" sortable="'contact_user_name'">{{row.contact_user_name}}</td>
                  <td data-title="'Telefon'" sortable="'phone'">{{row.phone | tel}}</td>
                  <td data-title="'Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                    <a class="btn center-block edit-btn" ng-click="openEdit(row)">
                      <i class="ion-edit"></i>
                    </a>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/ng-template" id="editTemplate.html">

  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left" ng-if="!isInsert">Bezirk bearbeiten - {{district.name}}</h3>

      <h3 class="m-0 pull-left" ng-if="isInsert">Bezirk hinzufügen</h3>
      <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
    </div>

    <div class="panel-body p-t-0">
      <form novalidate name="form">
        <uib-tabset>
          <uib-tab heading="Allgemein">
            <ng-form name="formDistrict" class="form-horizontal" disable-all="!canEdit()">
              <div class="row m-t-30">
                <div ng-class="isInsert ? 'col-lg-12' : 'col-lg-9'">
                  <h3 class="subheading m-0">Allgemeine Information</h3>
                  <hr>
                  <div class="m-b-15 clearfix">
                    <label class="col-lg-2 control-label">Name</label>

                    <div class="col-lg-10">
                      <div spi-hint text="_hint.name" class="has-hint"></div>
                      <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('name')}">
                        <input name="name" ng-model="district.name" class="form-control" type="text" value="" required>
                        <span ng-show="fieldError('name')">
                        <label ng-show="form.formDistrict.name.$error.required" class="error">Name is required.</label>
                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="col-lg-4 control-label">Adresse</label>

                        <div class="col-lg-8">
                          <div spi-hint text="_hint.address" class="has-hint"></div>
                          <div class="wrap-hint">
                            <textarea name="address" ng-model="district.address" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-4 control-label">PLZ</label>

                        <div class="col-lg-8">
                          <div spi-hint text="_hint.plz" class="has-hint"></div>
                          <div class="wrap-hint">
                            <input name="plz" ng-model="district.plz" type="text" value="" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-4 control-label">Stadt</label>

                        <div class="col-lg-8">
                          <div spi-hint text="_hint.city" class="has-hint"></div>
                          <div class="wrap-hint">
                            <input name="city" ng-model="district.city" type="text" value="" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-5 col-lg-offset-1">
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Telefon</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.phone" class="has-hint"></div>
                          <div class="wrap-hint">
                            <input name="phone" ng-model="district.phone" type="tel" value="" class="form-control"
                                   ui-mask="(999) 9999 999" ui-mask-placeholder ui-mask-placeholder-char="_">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Fax</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.fax" class="has-hint"></div>
                          <div class="wrap-hint">
                            <input name="fax" ng-model="district.fax" type="tel" value="" class="form-control"
                                   ui-mask="(999) 9999 999" ui-mask-placeholder ui-mask-placeholder-char="_">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Email</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.email" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('email')}">
                            <input name="email" ng-model="district.email" type="email" value="" class="form-control">
                            <span ng-show="fieldError('email')">
                            <label ng-show="form.formDistrict.email.$error.email" class="error">Enter a valid
                              email.</label>
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label">Webseite</label>

                        <div class="col-lg-9">
                          <div spi-hint text="_hint.homepage" class="has-hint"></div>
                          <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('homepage')}">
                            <input name="homepage" ng-model="district.homepage" type="text" value=""
                                   ng-pattern="/^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$/"
                                   class="form-control">
                            <span ng-show="fieldError('homepage')">
                              <label ng-show="form.formDistrict.homepage.$error.pattern" class="error">Enter a valid
                                webseite.</label>
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
                  <div spi-hint text="_hint.contact_id" class="has-hint"></div>
                  <div class="wrap-hint">
                    <ui-select ng-disabled="!$select.items.length" ng-change="changeContactUser(district.contact_id)"
                               ng-model="district.contact_id" name="contact_id">
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
                    <dd ng-bind="(contactUser.phone | tel) || '-'"></dd>
                    <dt>Email</dt>
                    <dd ng-bind="contactUser.email || '-'"></dd>
                  </dl>
                </div>
              </div>
              <hr/>
              <div class="form-group group-btn m-t-15">
                <div class="col-lg-2" ng-if="!isInsert && canEdit()">
                  <a ng-click="remove()" class="btn btn-icon btn-danger btn-lg sweet-4"><i
                      class="fa fa-trash-o"></i></a>
                </div>
                <div class="col-lg-10 text-right pull-right">
                  <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
                  <button class="btn w-lg custom-btn" ng-if="canEdit()" ng-click="submitFormDistrict()">Speichern</button>
                </div>
              </div>
            </ng-form>
          </uib-tab>

          <uib-tab heading="Benutzer" ng-if="!isInsert" ng-init="page = 'district'" ng-if="canView('user')">
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
                    <?php include(Yii::app()->getBasePath().'/views/site/partials/users-table.php'); ?>
                  </div>
                </div>
              </div>
            </div>
          </uib-tab>

          <uib-tab heading="Schulen" ng-if="!isInsert" ng-init="page = 'district'; districtId = districtId" ng-if="canView('school')">
            <div class="holder-tab" ng-controller="SchoolController">
              <div class="panel-body edit-user agency-tab-user">
                <div>
                  <div class="col-lg-12">
                    <div class="row datafilter">
                      <form class="class-form">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Suche nach Namen, Nummer, Adresse oder Ansprechpartner(in)</label>
                            <input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Eingegeben">
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label>Schultyp</label>
                            <ui-select ng-change="updateGrid()" class="type-user" ng-model="filter.type_id">
                              <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                              <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search">
                                <span ng-bind-html="item.name | highlight: $select.search"></span>
                              </ui-select-choices>
                            </ui-select>
                          </div>
                        </div>
                        <div class="col-lg-2 reset-btn-width">
                          <button ng-click="resetFilter()" class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
                        </div>
                      </form>
                    </div>
                    <?php include(Yii::app()->getBasePath().'/views/site/partials/schools-table.php'); ?>
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

<?php include(Yii::app()->getBasePath().'/views/site/partials/school-editor.php'); ?>
