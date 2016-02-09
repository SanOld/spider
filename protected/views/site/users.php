<?php

$this->pageTitle = 'Benutzerliste | ' . Yii::app()->name;
$this->breadcrumbs = array('Benutzerliste');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/users.js"></script>

<div ng-controller="UserController" class="wraper container-fluid" >
	<div class="row">
		<div class="container center-block">
			<div class="hint-details alert alert-info m-0 clearfix">
				<div class="heading-alert">
					<strong>Lorem ipsum dolor sit amet</strong>
								<span class="show-link pull-right">
									Zeigen <span class="caret"></span>
								</span>
				</div>
				<div class="content-alert">
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<h1 class="panel-title col-lg-6">Benutzerliste</h1>
					<div class="pull-right heading-box-print">
						<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
						<button class="btn w-lg custom-btn" ng-click="openEdit()">Benutzer hinzufügen</button>
					</div>
				</div>
				<div class="panel-body edit-user">
					<div class="row">
						<div class="col-lg-12">
							<div class="row datafilter">
								<form class="class-form">
									<div class="col-lg-3 add2">
										<div class="form-group">
											<label>Suche nach Namen, Benutzernamen oder Email</label>
											<input ng-change="updateGrid()" type="search" ng-model="filter.keyword" class="form-control" placeholder="Stichwort eingegeben">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label>Benutzer-Typ</label>
											<ui-select ng-change="updateGrid()" ng-model="filter.type_id" theme="select2">
												<ui-select-match allow-clear="true" placeholder="View all">{{$select.selected.name}}</ui-select-match>
												<ui-select-choices repeat="item.id as item in userTypes | filter: $select.search">
													<span ng-bind-html="item.name | highlight: $select.search"></span>
												</ui-select-choices>
											</ui-select>
										</div>
									</div>
									<div class="col-lg-4 add">
										<div class="form-group">
											<label>Organisation</label>
											<input ng-change="updateGrid()" type="text" ng-model="filter.relation_name" placeholder="Organisationsname eingeben" class="search-relation form-control">
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group">
											<label>Status</label>
											<ui-select ng-change="updateGrid()" class="" ng-model="filter.is_active" theme="select2">
												<ui-select-match allow-clear="true" placeholder="View all">{{$select.selected.name}}</ui-select-match>
												<ui-select-choices repeat="item.id as item in statuses | filter: $select.search">
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
							<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
								<tr ng-repeat="row in $data" ng-class="{'disable': row.is_active == '0'}">
									<td data-title="'Name'" sortable="'name'">{{row.name}}</td>
									<td data-title="'Benutzer-Typ'" sortable="'type_name'">{{row.type_name}}</td>
									<td data-title="'Organisation'" sortable="'relation_name'">{{row.relation_name}}</td>
									<td data-title="'Benutzername'" sortable="'login'"><a href="#">{{row.login}}</a></td>
									<td data-title="'Email'" sortable="'email'"><a href="#">{{row.email}}</a></td>
									<td data-title="'Telefon'" sortable="'phone'">{{row.phone | tel}}</td>
									<td data-title="'Status'" sortable="'is_active'">{{row.active_name}}</td>
									<td data-title="'Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
										<a class="btn center-block edit-btn" ng-click="openEdit(row)">
											<i class="ion-edit"></i>
										</a>
									</td>
								</tr>
							</table>
							<div class="notice">
								<span class="color-notice"></span>
								Deaktivierte Benutzer
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">

	jQuery(window).load(function() {

		$('.hint-details .show-link').click(function(){

			if ($('.hint-details .content-alert').is(":visible")) {
				$(this).html($(this).html().replace(/Ausblenden/, 'Zeigen'));
			} else {
				$(this).html($(this).html().replace(/Zeigen/, 'Ausblenden'));
			}

			$(".hint-details .content-alert").slideToggle();
		})

	});

</script>
