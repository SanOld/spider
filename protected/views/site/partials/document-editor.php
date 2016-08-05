	<div class="panel panel-color panel-primary" >
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left" >Druck-Template bearbeiten - {{document.name}}</h3>
			<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
		</div>
      <form novalidate name="form">

			<uib-tabset active="tabActive">
        <uib-tab index="0" heading="Allgemein" active="tabs[0].active" ng-click="tabs[0].active = true">
          <div class="tab-content clearfix m-0">
            <div class="tab-pane active" id="general">
              <ng-form  name="formDocument"   class="form-horizontal">

                <div class="row m-t-30">
                  <div class="m-b-15 clearfix">
                    <label class="col-lg-1 control-label">Name</label>
                    <div class="col-lg-6">
                      <div spi-hint text="_hint.name.text"  title="_hint.name.title"  class="has-hint"></div>
                      <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('name')}">
                        <input class="form-control" type="text" name="name" ng-model="document.name" value="{{document.name}}" required ng-disabled="!canEdit()">

                        <span ng-class="{hide: !fieldError('name')}" class="hide">
                                <label ng-show="form.formDocument.name.$error.required" class="error">Name erforderlich</label>
                                <label ng-show="error.name.dublicate" class="error">This Name already exists</label>
                                <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        </span>
                      </div>
                    </div>
                    <label class="col-lg-2 control-label label-type">Dokument-Typ</label>
                    <div class="col-lg-3">
                      <div spi-hint text="_hint.document_type.text"  title="_hint.document_type.title"  class="has-hint"></div>
                      <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('type_id')}">
                        <ui-select  class="type-document" ng-model="document.type_id" required name="type_id">
                          <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                          <ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search | orderBy: 'name'">
                              <span ng-bind-html="item.name | highlight: $select.search"></span>
                          </ui-select-choices>
                        </ui-select>
                        <span ng-class="{hide: !fieldError('type_id')}" class="hide">
                            <label class="error">Dokument-Typ erforderlich</label>
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="m-b-15 clearfix wrap-summernote" >
                      <div class="col-sm-12">
                        <div spi-hint text="_hint.text.text"  title="_hint.text.title"  class="has-hint"></div>
                        <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('text')}">
                          <div class="">
                            <summernote config="options" ng-model="document.text"></summernote>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="group-btn clearfix m-t-20 hidden">
                  <div class="pull-right">                  
                    <button class="btn w-lg custom-btn" ng-click="submitDocumentTemplate()" data-dismiss="modal">Speichern</button>
                  </div>
                </div>      
                </ng-form>

                <hr />
                <div class="form-group group-btn m-t-15">
                  <div class="col-lg-2">
                    <a class="btn btn-icon btn-danger btn-lg sweet-4" ng-click="remove()"><i class="fa fa-trash-o"></i></a>
                  </div>
                  <div class="col-lg-10 text-right pull-right">
                    <button class="btn w-lg cancel-btn" ng-click="cancel()" data-dismiss="modal">Abbrechen</button>
                    <button class="btn w-lg custom-btn" ng-click="submitDocumentTemplate()" data-dismiss="modal">Speichern</button>
                  </div>
                </div>

            </div>
          </div>
        </uib-tab>

				<uib-tab index="1" heading="Platzhalter" active="tabs[1].active" ng-click="tabs[1].active = true">
            <div>
              <table id="placeholder" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
                <tr ng-repeat="row in $data">
                  <td data-title="'Platzhalter'" sortable="'name'">{{row.name}}</td>
                  <td data-title="'Beschreibung'" sortable="'type_name'">{{row.text}}</td>
                </tr>
              </table>
            </div>
				</uib-tab>

			</uib-tabset>

      </form>
	</div>