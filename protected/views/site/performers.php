<?php
$this->pageTitle = 'Träger | ' . Yii::app()->name;
$this->breadcrumbs = array('Träger');
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/performers.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/projects.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

<div ng-controller="PerformerController" ng-cloak class="wraper container-fluid">
	<div class="row">
		<div class="container center-block">
			<div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Träger</h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
						<button <?php $this->demo(); ?>  class="btn w-lg custom-btn" ng-if="canCreate() && canByType(['a'])" ng-click="openEdit()">Träger hinzufügen</button>
					</div>
				</div>
				<div class="panel-body agency-edit">
					<div class="row datafilter">
						<form>
							<div class="col-lg-5">
								<div class="form-group">
									<label>Suche nach Träger, Adresse, Ansprechpartner oder E-Mail</label>
									<input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Eingegeben">
								</div>
							</div>
							<div ng-class="canEdit() ? 'col-lg-3' : 'col-lg-5'">
								<div ng-show="canShowElement('filterBank')" class="form-group">
									<div class="form-group">
										<label>Suche nach Bankverbindung</label>
										<input ng-change="updateGrid()" type="search" ng-model="filter.bank_details" class="form-control" placeholder="Eingegeben">
									</div>
								</div>
							</div>
							<div class="col-lg-2" ng-if="canEdit()">
								<div class="form-group">
									<div class="form-group">
										<label>Profil überprüft</label>
										<ui-select ng-change="updateGrid()" class="" ng-model="filter.is_checked">
											<ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
											<ui-select-choices repeat="item.id as item in checks | filter: $select.search | orderBy: 'name'">
												<span ng-bind-html="item.name | highlight: $select.search"></span>
											</ui-select-choices>
										</ui-select>
									</div>
								</div>
							</div>
							<div class="col-lg-2 reset-btn-width">
								<button ng-click="resetFilter()" class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
							</div>
						</form>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
								<tr ng-repeat="row in $data" ng-class="{'disable': !+row.is_checked && !isOwn(row.id)}">
									<td data-title="'Name'" sortable="'short_name'">{{row.short_name}}</td>
									<td data-title="'Adresse'" sortable="'full_address'">{{row.full_address}}</td>
									<td data-title="'Ansprechpartner(in)'" sortable="'representative_user'">{{row.representative_user}}</td>
									<td data-title="'E-Mail'" sortable="'email'"><a href="mailto:{{row.email}}">{{row.email}}</a></td>
									<td data-title="'Telefon'" sortable="'phone'">{{row.phone}}</td>
									<td ng-if="canEdit()" data-title="'Profil'" sortable="'is_checked'" class="text-center">
										<i ng-if="+row.is_checked" class="ion-checkmark"></i>
										<span ng-if="!+row.is_checked">-</span>
									</td>
                  <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
                    <a class="btn center-block edit-btn" ng-click="openEdit(row, !canEdit(row.id))">
                      <i class="ion-eye"  ng-if="!canEdit(row.id)"></i>
                      <i class="ion-edit" ng-if="canEdit(row.id)"></i>
                    </a>
                  </td>
								</tr>
                <tr ng-if="!$data.length"><td class="no-result" colspan="7">Keine Ergebnisse</td></tr>
							</table>
						</div>
					</div>
					<div class="notice" ng-if="canEdit()">
						<span class="color-notice"></span>
						Nicht überprüfte Agenturen
					</div>
				</div>
			</div>
		</div>
	</div> <!-- End Row -->
</div>


<script type="text/ng-template" id="editTemplate.html">
  <?php include(Yii::app()->getBasePath().'/views/site/partials/performers-editor.php'); ?>
</script>
