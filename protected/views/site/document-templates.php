<?php

$this->pageTitle = 'Druck-templates | ' . Yii::app()->name;
$this->breadcrumbs = array('Druck-templates');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/document-templates.js"></script>

			<!-- Page Content Start -->
<div ng-controller="DocumentTemplatesController" class="wraper container-fluid" ng-cloak>
	<div class="row">
		<div class="container center-block edit-user doc-template">
			<div spi-hint-main header="_hint.header.title" text="_hint.header.text"></div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Druck-Templates</h1>
					<div class="pull-right heading-box-print">
            <a href="javascript:window.print()">Drucken<i class="ion-printer"></i></a>
						<button class="btn w-lg custom-btn" ng-if="canEdit()" ng-click="openEdit()">Druck-Template hinzufügen</button>
					</div>
				</div>
				<div class="panel-body hint-edit">
					<div class="row datafilter">
						<form>
							<div class="col-lg-5">
								<div class="form-group">
									<label>Suche nach Namen und Dokument-Typ</label>
                  <input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Eingegeben">
								</div>
							</div>
							<div class="col-lg-5">
								<div class="form-group">
									<label>Dokument-Typ</label>
									<ui-select ng-change="updateGrid()" class="type-document" ng-model="filter.type_id">
                    <ui-select-match allow-clear="true" placeholder="Alles anzeigen">{{$select.selected.name}}</ui-select-match>
                    <ui-select-choices repeat="item.id as item in  documentTypes | filter: $select.search">
                        <span ng-bind-html="item.name | highlight: $select.search"></span>
                    </ui-select-choices>
                  </ui-select>
								</div>
							</div>
							<div class="col-lg-2">
								<button ng-click="resetFilter()" class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
							</div>
						</form>
					</div>

					<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
						<tr ng-repeat="row in $data">
							<td data-title="'Name'" sortable="'name'">{{row.name}}</td>
							<td data-title="'Dokument-Typ'" sortable="'type_name'">{{row.type_name}}</td>
							<td data-title="'Letzte Änderung'">{{row.last_change}} {{row.user_name}}</td>
              <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="text-center dt-edit" style="width: 183px;">
                <a class="btn edit-btn" ng-click="openTemplate(row, !canEdit())">
                  <i class="ion-document-text" ng-if="canView()"></i>
                </a>
                <a class="btn edit-btn" ng-click="openEdit(row, !canEdit())">
                  <i class="ion-edit" ng-if="canEdit()"></i>
                </a>
              </td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
			<!-- ================== -->


		<!-- Page Content Ends -->

<script type="text/ng-template" id="editTemplate.html">
  <?php include(Yii::app()->getBasePath().'/views/site/partials/document-editor.php'); ?>
</script>

<script type="text/ng-template" id="showTemplate.html">
  <?php include(Yii::app()->getBasePath().'/views/site/partials/document-template.php'); ?>
</script>
