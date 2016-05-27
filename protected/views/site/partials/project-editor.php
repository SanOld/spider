<div class="panel panel-color panel-primary">
  <div class="panel-heading clearfix"> 
    <h3 class="m-0 pull-left" ng-if="!isInsert">Projekt bearbeiten</h3>
    <h3 class="m-0 pull-left" ng-if="isInsert">Projekt hinzufügen</h3>
    <button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
  </div>
  <div class="panel-body">
    <ng-form name="formProjects" class="form-horizontal">
      <div class="row">
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label">Kennziffer</label>
          <div class="col-lg-4">
            <div spi-hint text="_hint.code" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('code')}">
              <input name="code" ng-model="project.code" class="form-control" type="text" value="" required ng-disabled="!isInsert">
              <span ng-class="{hide: !fieldError('code')}" class="hide">
                <label ng-show="formFinances.code.$error.required" class="error">Code is
                  required</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
          <label class="col-lg-2 control-label">Rate</label>
          <div class="col-lg-4">
            <div spi-hint text="_hint.rate" class="has-hint"></div>
            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('rate')}">
              <input name="rate" ng-model="project.rate" class="form-control" type="text" value="" required ng-change="checkRate(project)" ng-disabled="!isInsert">
              <span ng-class="{hide: !fieldError('rate')}" class="hide">
                <label ng-show="formFinances.rate.$error.required" class="error">Rate is
                  required</label>
                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
              </span>
            </div>
          </div>
        </div>
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label">Fördertopf</label>
          <div class="col-lg-4">
            <div spi-hint text="_hint.project_type_id" class="has-hint"></div>
            <div class="wrap-hint">
              <ui-select ng-disabled="!$select.items.length || !isInsert" ng-model="project.type_id"
                         name="type_id" required on-select="updateCode();">
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte wählen Sie)'}}">
                  {{$select.selected.name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in projectTypes | filter: $select.search">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
            </div>
          </div>
          <label class="col-lg-2 control-label">Schultyp</label>
          <div class="col-lg-4">
            <div spi-hint text="_hint.school_type_id" class="has-hint"></div>
            <div class="wrap-hint">
              <ui-select ng-disabled="!$select.items.length || !isInsert" ng-model="project.school_type_id"
                         name="school_type_id" required on-select="updateSchools();updateCode();">
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte wählen Sie)'}}">
                  {{$select.selected.fullName}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in schoolTypes | filter: $select.search">
                  <span ng-bind-html="item.fullName | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
            </div>
          </div>
        </div>
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label p-r-0">Träger</label>
          <div class="col-lg-10">
            <div spi-hint text="_hint.performer_id" class="has-hint"></div>
            <div class="wrap-hint">
              <ui-select ng-disabled="!$select.items.length || project.is_old == 1" ng-model="project.performer_id"
                         name="performer_id" required>
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte wählen Sie)'}}">
                  {{$select.selected.name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in performers | filter: $select.search">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
            </div>
          </div>
        </div>
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label">Bezirk</label>
          <div class="col-lg-10">
            <div spi-hint text="_hint.district_id" class="has-hint"></div>
            <div class="wrap-hint">
              <ui-select ng-disabled="!$select.items.length || !isInsert" ng-model="project.district_id"
                         name="district_id" on-select="updateSchools()">
                <ui-select-match placeholder="{{$select.disabled ? '(keine Items sind verfügbar)' : '(Bitte wählen Sie)'}}">
                  {{$select.selected.name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in districts | filter: $select.search">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
            </div>
          </div>
        </div>
        <div class="m-b-15 clearfix">
          <label class="col-lg-2 control-label">Schule</label>
          <div class="col-lg-10">
            <div spi-hint text="_hint.schools" class="has-hint"></div>

            <div class="wrap-hint" ng-class="{'select2-empty-list':!schools.length}">
              <ui-select ng-disabled="project.is_old == 1 || !schools.length" multiple ng-model="project.schools"
                         name="schools">
                <ui-select-match placeholder="{{placeholderFN($select.items)}}">
                  {{$item.name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in schools | filter: $select.search">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
            </div>

          </div>
        </div>

      </div>
      <div class="form-group group-btn m-t-15">
        <div class="col-lg-2">
          <a class="btn btn-icon btn-danger btn-lg sweet-4" ng-click="remove()"><i class="fa fa-trash-o"></i></a>
        </div>
        <div class="col-lg-10 text-right pull-right">
          <button class="btn w-lg cancel-btn" data-dismiss="modal" ng-click="cancel()">Abbrechen</button>
          <button class="btn w-lg custom-btn" data-dismiss="modal" ng-click="submitFormProjects()">Speichern</button>
        </div>
      </div>
    </ng-form>
  </div>
</div>