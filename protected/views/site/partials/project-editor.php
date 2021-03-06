<div class="panel panel-color panel-primary">
  <div class="panel-heading clearfix"> 
    <h3 class="m-0 pull-left" ng-if="!isInsert">Projekt bearbeiten #{{ProjectId}}</h3>
    <h3 class="m-0 pull-left" ng-if="isInsert">Projekt hinzufügen #{{ProjectId}}</h3>
    <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
  </div>
  <div class="panel-body">
    <ng-form name="formProjects" class="form-horizontal" disable-all="modeView">
      <div class="row">
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label">Schultyp</label>
          <div class="col-lg-4">
            <div spi-hint text="_hint.school_type_id.text"  title="_hint.school_type_id.title"  class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('school_type_id')}">
              <ui-select ng-disabled="!$select.items.length || !isInsert || modeView" ng-model="project.school_type_id"
                         name="school_type_id" required on-select="updateSchools();updateCode();getDistricts();">
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                  {{$select.selected.fullName}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search | orderBy: 'fullName'">
                  <span ng-bind-html="item.fullName | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('school_type_id')}" class="hide">
                  <label class="error">Schultyp erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label">Fördertopf</label>
          <div class="col-lg-4">
            <div spi-hint text="_hint.type_id.text"  title="_hint.type_id.title"  class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('type_id')}">
              <ui-select ng-disabled="!$select.items.length || !isInsert || modeView" ng-model="project.type_id"
                         name="type_id" required on-select="updateCode();getProgramms();">
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                  {{$select.selected.name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in projectTypes | filter: $select.search  | orderBy: 'name'">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('type_id')}" class="hide">
                  <label class="error">Fördertopf erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
          <label class="col-lg-2 control-label p-r-0">Programm</label>
          <div class="col-lg-4">
            <div spi-hint text="_hint.performer_id.text"  title="_hint.performer_id.title"  class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('programm_id')}">
              <ui-select ng-disabled="!project.type_id || modeView || !isInsert " ng-model="project.programm_id"
                         name="programm_id" required on-select="updateCode();" >
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                {{$select.selected.programm}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in programms | filter: $select.search | orderBy: 'name'">
                  <span ng-bind-html="item.programm | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('programm_id')}" class="hide">
                  <label class="error">Programm erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label">Kennziffer</label>
          <div class="col-lg-4">
            <div spi-hint text="_hint.code.text"  title="_hint.code.title"  class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('code')}">
              <input name="code" ng-model="project.code" class="form-control" type="text" value="" required ng-disabled="!isInsert || modeView">
              <span ng-class="{hide: !fieldError('code')}" class="hide">
                <label ng-show="formProjects.code.$error.required" class="error">Kennziffer erforderlich</label>
                <label ng-show="formProjects.code.$pristine && error.code.dublicate" class="error">Dieser Kennziffer existiert bereits</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
          
          <label class="col-lg-2 control-label">Stellenanteil</label>
          <div class="col-lg-4">
            <div spi-hint text="_hint.rate.text"  title="_hint.rate.title"  class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('rate')}">
              <input name="rate" ng-model="project.rate" class="form-control" type="text" value="" required ng-change="checkRate(project)" ng-disabled="!isInsert || modeView">
              <span ng-class="{hide: !fieldError('rate')}" class="hide">
                <label ng-show="formProjects.rate.$error.required" class="error">Rate erforderlich</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
          
        </div>
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label">Bezirk</label>
          <div class="col-lg-10">
            <div spi-hint text="_hint.district_id.text"  title="_hint.district_id.title"  class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('district_id')}">
              <ui-select ng-disabled="!$select.items.length || modeView || project.is_old == 1" ng-model="project.district_id"
                         name="district_id" on-select="updateSchools()" ng-required="schoolTypeCode != 'z' && schoolTypeCode != 'b'">
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                  {{project.district_id == "--Kein Bezirk--" ? project.district_id : $select.selected.name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in districts | filter: $select.search | orderBy: 'name'">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('district_id')}" class="hide">
                  <label class="error">Bezirk erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label">Schule</label>
          <div class="col-lg-10">
            <div spi-hint text="_hint.schools.text"  title="_hint.schools.title"  class="has-hint"></div>

            <div class="wrap-hint" ng-class="{'select2-empty-list':(!schools.length && !project.school_type_id) || (!schools.length && project.school_type_id == 6), 'wrap-line error': fieldError('schools')}">
              <ui-select ng-disabled="!schools.length || modeView || project.is_old == 1" multiple ng-model="project.schools" ng-required="schoolTypeCode != 'z'"
                         name="schools">
                <ui-select-match placeholder="{{!schools.length ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                  {{$item.name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in schools | filter: $select.search | orderBy: 'name'">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('schools')}" class="hide">
                  <label class="error">Schule erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
<!--            <div class="wrap-hint" ng-hide="schoolTypeCode == 's'" ng-class="{'select2-empty-list':!schools.length, 'wrap-line error': fieldError('school')}" >
              <ui-select ng-disabled="!$select.items.length || project.is_old == 1 || modeView" ng-model="project.school" ng-required="schoolTypeCode != 'z' && schoolTypeCode != 's' "
                         name="school">
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte wählen Sie)'}}">
                  {{$select.selected.name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in schools | filter: $select.search | orderBy: 'name'">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('school')}" class="hide">
                  <label class="error">Schule erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>-->

          </div>
        </div>
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label p-r-0">Träger</label>
          <div class="col-lg-10">
            <div spi-hint text="_hint.performer_id.text"  title="_hint.performer_id.title"  class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('performer_id')}">
              <ui-select ng-disabled="!$select.items.length || project.is_old == 1 || modeView" ng-model="project.performer_id"
                         name="performer_id" required>
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte auswählen)'}}">
                  {{$select.selected.short_name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in performers | filter: $select.search | orderBy: 'name'">
                  <span ng-bind-html="item.short_name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
              <span ng-class="{hide: !fieldError('performer_id')}" class="hide">
                  <label class="error">Träger erforderlich</label>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group group-btn m-t-15">
        <div class="col-lg-2" ng-if="canEdit() && canByType(['a']) && !isInsert && project.is_old != 1">  
          <a ng-cloak ng-if="project.status_id" class="btn-deactivate" ng-click="remove()">DEAKTIVIEREN</a>
          <a ng-cloak class="btn btn-icon btn-danger btn-lg sweet-4" ng-if="!project.status_id" ng-click="remove()"><i class="fa fa-trash-o"></i></a>        
        </div>
        <div class="group-btn clearfix m-t-20 hidden">
          <div class="pull-right">                  
            <button ng-if="canEdit() && !modeView" class="btn w-lg custom-btn" data-dismiss="modal" ng-click="submitFormProjects()">Speichern</button>
          </div> 
        </div>
        <div class="col-lg-10 text-right pull-right">
          <button class="btn w-lg cancel-btn" data-dismiss="modal" ng-click="cancel()">Abbrechen</button>
          <button ng-if="canEdit() && !modeView && project.is_old != 1" class="btn w-lg custom-btn" data-dismiss="modal" ng-click="submitFormProjects()">Speichern</button>
        </div>
      </div>
    </ng-form>
  </div>
</div>