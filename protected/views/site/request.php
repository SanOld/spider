<?php
$this->pageTitle = 'Anträge | ' . Yii::app()->name;
$this->breadcrumbs = array('Anträge'=>'/requests', 'Anträg {{request_code}}');
?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/diff_match_patch.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/request.js"></script>

<div class="wraper container-fluid" ng-controller="RequestController">
	<div class="row">
		<div class="container center-block request-edit-page">
			<div class="panel panel-default" ng-cloak>
				<div class="panel-heading heading-noborder clearfix">
                  <h1 class="panel-title col-lg-6">Antrag {{requestYear}} <span ng-show="projectID">({{projectID}})</span></h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
					</div>
				</div>

				<uib-tabset class="panel-body request-order-nav" active="tabActive">
					<uib-tab class="project" index="'project-data'" select="setTab('project-data')" heading="Projektdaten">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-project-data.php'); ?>
          </uib-tab>
					<uib-tab ng-if="isFinansist" class="finance {{financeStatus}}" index="'finance-plan'" select="setTab('finance-plan')" heading="Finanzplan">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-financial-plan.php'); ?>
					</uib-tab>
					<uib-tab class="concepts {{conceptStatus}}" index="'school-concepts'" select="setTab('school-concepts')" heading="Konzept">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-concept-data.php'); ?>
					</uib-tab>
          <uib-tab class="schools-goals {{goalsStatus}}"  index="'schools-goals'" select="setTab('schools-goals')" heading="Entwicklungsziele">
						<?php include(Yii::app()->getBasePath().'/views/site/partials/request-goals-data.php'); ?>
          </uib-tab>
				</uib-tabset>

				<br>
				<div class="form-group group-btn row">
					<div class="col-lg-6 text-left">
						<button ng-show="userCan('delete')" ng-click="block()" class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"><i class="fa fa-trash-o"></i></button>
						<button ng-show="userCan('reopen')" class="btn w-lg btn-info btn-lg">
							<i class="fa fa-rotate-left"></i>
							<span>Neu eröffnen</span>
						</button>
						<button ng-show="userCan('changeStatus')" class="btn w-lg btn-info btn-lg">Förderfähig</button>
						<button ng-show="userCan('changeStatus')" class="btn w-lg btn-info btn-lg">Genehmigt</button>
					</div>
					<div class="col-lg-6 text-right">
						<button class="btn w-lg cancel-btn btn-lg" ng-click="cancel()">Abbrechen</button>
						<button ng-show="userCan('save')" class="btn w-lg custom-btn btn-lg" ng-click="submitRequest()">Speichern</button>
						<button ng-show="userCan('save')"  class="btn w-lg custom-btn btn-lg" ng-click="submitRequest(true)" title="Speichern und zurück zur Liste">Anwenden</button>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


<script type="text/ng-template" id="setDuration.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left">Dauer ändern</h3>
			<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body text-center">
			<div class="form-group">
				<ng-form>
					<div class="holder-datepicker text-right">
						<div class="col-lg-2 p-0">
							<label>Beginn</label>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_start_date_is_open = !dp_start_date_is_open" ng-model="form.start_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_start_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon" ng-click="dp_start_date_is_open = !dp_start_date_is_open"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
						<div class="col-lg-2 p-0">
							<label>Ende</label>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_due_date_is_open = !dp_due_date_is_open" ng-model="form.due_date" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_due_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon" ng-click="dp_due_date_is_open = !dp_due_date_is_open"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
					</div>
				</ng-form>
			</div>
		</div>
		<div class="row p-t-10 text-center">
			<div class="form-group group-btn m-t-20">
				<div class="col-lg-12">
					<button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
					<button class="btn w-lg custom-btn" ng-click="ok()" ng-disabled="form.$invalid || form.due_date < form.start_date|| form.start_date > form.end_fill || form.due_date < form.end_fill">Speichern</button>
				</div>
			</div>
		</div>
	</div>
</script>


<script type="text/ng-template" id="conceptCompareTemplate.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left">Vergleichen</h3>
			<button ng-click="cancel()" type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body">
			<div class="heading-compare">
				<strong>Veränderungen</strong>
				<span>Bearbeitet von {{::history.user_name}} am {{::history.date}}</span>
				<p>Bereich: <strong ng-bind="::history.name"></strong></p>
			</div>
			<hr />
			<div class="row compare-box">
        <div class="col-lg-12 emphasize" ng-bind-html="::compareText"></div>
      </div>
			<hr />
		</div>
		<div class="row">
			<div class="form-group group-btn">
				<div class="col-lg-12">
					<button ng-click="cancel()" class="btn w-lg custom-btn pull-right" data-dismiss="modal">SCHLIEßEN</button>
				</div>
			</div>
		</div>
	</div>
</script>


<script type="text/ng-template" id="setEndFill.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 class="m-0 pull-left">Abgabedatum für den Antrag</h3>
			<button type="button" class="close" ng-click="cancel()"><i class="ion-close-round "></i></button>
		</div>
		<div class="panel-body text-center">
			<div class="form-group">
				<ng-form>
					<div class="holder-datepicker text-right">
						<div class="col-lg-2 col-lg-offset-2 p-0">
							<label>Abgabe</label>
						</div>
						<div class="col-lg-4 p-0">
							<div class="input-group">
								<input type="text" ng-click="dp_start_date_is_open = !dp_start_date_is_open" ng-model="form.end_fill" uib-datepicker-popup="dd.MM.yyyy" datepicker-append-to-body="true" show-button-bar="false" is-open="dp_start_date_is_open" datepicker-options="dateOptions" required class="form-control datepicker" >
								<span class="input-group-addon" ng-click="dp_start_date_is_open = !dp_start_date_is_open"><i class="glyphicon glyphicon-calendar"></i></span>
							</div>
						</div>
					</div>
				</ng-form>
			</div>
		</div>
		<div class="row p-t-10 text-center">
			<div class="form-group group-btn m-t-20">
				<div class="col-lg-12">
					<button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
					<button class="btn w-lg custom-btn" ng-click="ok()"  ng-disabled="form.$invalid || form.start_date > form.end_fill || form.due_date < form.end_fill">Speichern</button>
				</div>
			</div>
		</div>
	</div>
</script>
