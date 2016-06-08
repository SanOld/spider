
<!--View Doc-->
  <div class="panel panel-color panel-primary" ng-if="canEdit()">
    <div class="panel-heading clearfix">
      <h3 class="m-0 pull-left">Druck-Template - {{document.name}}</h3>
      <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-hidden="true"><i class="ion-close-round "></i></button>
    </div>
      <div class="panel-body edit-user doc-template">
        <div class="row">
          <div class="col-lg-12" ng-bind-html="trustAsHtml(document.text)"></div>
        </div>
        <hr />
        <div class="form-group group-btn m-t-15">
          <div class="col-lg-10 text-right pull-right">
              <button class="btn w-lg custom-btn" ng-click="cancel()" data-dismiss="modal">Schließen</button>
          </div>
        </div>
      </div>
  </div>
<!-- End View Doc -->