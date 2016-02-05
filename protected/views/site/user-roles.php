<?php

$this->pageTitle = 'Benutzerrollen | ' . Yii::app()->name;
$this->breadcrumbs = array('Benutzerrollen');

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/user-roles.js"></script>

<div ng-controller="UserRolesController" class="wraper container-fluid" >
	<div class="row">
		<div class="container center-block">
			<div class="panel panel-default">
				<div class="panel-heading heading-noborder clearfix">
					<h1 class="panel-title col-lg-6">Benutzerrollen</h1>
					<div class="pull-right heading-box-print">
						<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Benutzer-Typ hinzufügen</button>
					</div>
				</div>
				<div class="panel-body roles-edit">

					<table id="datatable" class="table table-hover table-bordered table-edit">
						<thead>
						<tr>
							<th>Benutzer-Typ</th>
							<th>Organisationstyp</th>
							<th></th>
						</tr>
						</thead>

						<tbody>
						<tr>
							<td>Admin</td>
							<td>Organisation</td>
							<td>
								<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
									<i class="ion-edit"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>Bezirk</td>
							<td>Bezirk</td>
							<td>
								<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
									<i class="ion-edit"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>Träger</td>
							<td>Organisation</td>
							<td>
								<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
									<i class="ion-edit"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>Träger Agentur</td>
							<td>Träger Agentur</td>
							<td>
								<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
									<i class="ion-edit"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>Senat</td>
							<td>Organisation</td>
							<td>
								<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
									<i class="ion-edit"></i>
								</a>
							</td>
						</tr>
						<tr>
							<td>Schule</td>
							<td>Schule</td>
							<td>
								<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
									<i class="ion-edit"></i>
								</a>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>



<!--Edit user -->
<script type="text/ng-template" id="editTemplate.html">
	<div class="panel panel-color panel-primary">
		<div class="panel-heading clearfix">
			<h3 ng-if="isInsert" class="m-0 pull-left">Bearbeiten eines Benutzer</h3>
			<h3 ng-if="!isInsert" class="m-0 pull-left">Benutzerprofil editieren</h3>
			<button type="button" ng-click="cancel()" class="close"><i class="ion-close-round "></i></button>
		</div>
<!--		<div class="alert alert-danger m-t-20">-->
<!--			Bitte geben Sie die markierten Felder korrekt ein.-->
<!--		</div>-->
		<h3 class="subheading">Benutzerinformation</h3>
		<hr>
		<div class="panel-body">
			<form novalidate class="form-horizontal" method="post" name="form">
				<div class="form-group">
					<label class="col-lg-2 control-label">Status</label>
					<div class="col-lg-10">
						<div class="btn-group btn-toggle">
							<button class="btn btn-sm" ng-class="{'btn-default': user.is_active != 1}" ng-model="user.is_active" uib-btn-radio="1">AKTIV</button>
							<button class="btn btn-sm" ng-class="{'btn-default': user.is_active != 0}" ng-model="user.is_active" uib-btn-radio="0">DEAKTIVIEREN</button>
						</div>
						<button uib-popover="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."  popover-trigger="focus" class="btn btn-question" type="button">
							<i class="fa fa-question"></i>
						</button>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Benutzer-Typ</label>

					<div ng-if="!isInsert" class="col-lg-10">
						<span class="no-edit-text">{{type_name}}</span>
						<button uib-popover="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."  popover-trigger="focus" class="btn btn-question" type="button">
							<i class="fa fa-question"></i>
						</button>
					</div>

					<div ng-if="isInsert" class="col-lg-4 custom-width">
						<button uib-popover="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."  popover-trigger="focus" class="btn btn-question has-hint" type="button">
							<i class="fa fa-question"></i>
						</button>
						<div class="wrap-hint" ng-class="{'wrap-line error': fieldError('type_id')}">
							<select class="form-control" ng-model="user.type_id" name="type_id" ng-options="type.id as type.name for type in userTypes" required>
								<option value="">(Please choose)</option>
							</select>
							<span ng-show="fieldError('type_id')">
								<label ng-show="form.type_id.$error.required" class="error">User type is required.</label>
								<span class="glyphicon glyphicon-remove form-control-feedback"></span>
							</span>
						</div>
					</div>

				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Organisation</label>
					<div ng-if="!isInsert" class="col-lg-10">
						<span class="no-edit-text">{{relation_name}}</span>
						<button uib-popover="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."  popover-trigger="focus" class="btn btn-question" type="button">
							<i class="fa fa-question"></i>
						</button>
					</div>

					<div ng-if="isInsert" class="col-lg-10">
						<button uib-popover="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."  popover-trigger="focus" class="btn btn-question has-hint" type="button">
							<i class="fa fa-question"></i>
						</button>
						<div class="wrap-hint">
							<select class="form-control" ng-model="user.relation_id" ng-options="relation.id as relation.name for type in relations">
								<option value="">(Not chosen)</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label two-line">Finanzielle Rechte</label>
					<div class="col-lg-10">
						<div class="btn-group btn-toggle">
							<button class="btn btn-sm" ng-class="{'btn-default': user.is_finansist != 1}" ng-model="user.is_finansist" uib-btn-radio="1">JA</button>
							<button class="btn btn-sm" ng-class="{'btn-default': user.is_finansist != 0}" ng-model="user.is_finansist" uib-btn-radio="0">NEIN</button>
						</div>

						<button uib-popover="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."  popover-trigger="focus" class="btn btn-question" type="button">
							<i class="fa fa-question"></i>
						</button>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">Anrede</label>
					<div class="col-lg-10">
						<div class="radio-inline">
							<label for="radio1" class="cr-styled">
								<input type="radio" ng-model="user.sex" value="1" id="radio1">
								<i class="fa"></i>
								Herr
							</label>
						</div>
						<div class="radio-inline">
							<label for="radio2" class="cr-styled">
								<input type="radio" ng-model="user.sex" value="2" id="radio2">
								<i class="fa"></i>
								Frau
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label class="col-lg-4 control-label" for="title">Titel</label>
							<div class="col-lg-8">
								<div class="wrap-hint">
									<input id="title" class="form-control" ng-model="user.title" type="text" value="">
								</div>
							</div>
						</div>
						<div class="form-group has-feedback">
							<label class="col-lg-4 control-label" for="first_name">Vorname</label>
							<div class="col-lg-8" ng-class="{'wrap-line error': fieldError('first_name')}">
								<input class="form-control" ng-model="user.first_name" name="first_name" type="text" id="first_name" value="" ng-minlength="2" ng-maxlength="45" required>
								<span ng-show="fieldError('first_name')">
									<label ng-show="form.first_name.$error.required" class="error">First name is required.</label>
									<label ng-show="form.first_name.$error.minlength" class="error">First name is too short.</label>
									<label ng-show="form.first_name.$error.maxlength" class="error">First name is too long.</label>
									<span class="glyphicon glyphicon-remove form-control-feedback"></span>
								</span>
							</div>
						</div>
						<div class="form-group has-feedback">
							<label class="col-lg-4 control-label" for="lname">Nachname</label>
							<div class="col-lg-8" ng-class="{'wrap-line error': fieldError('last_name')}">
								<input class="form-control" ng-model="user.last_name" name="last_name" type="text" id="lname" value="" ng-minlength="2" ng-maxlength="45" required>
								<span ng-show="fieldError('last_name')">
									<label ng-show="form.last_name.$error.required" class="error">Last name is required.</label>
									<label ng-show="form.last_name.$error.minlength" class="error">Last name is too short.</label>
									<label ng-show="form.last_name.$error.maxlength" class="error">Last name is too long.</label>
									<span class="glyphicon glyphicon-remove form-control-feedback"></span>
								</span>
							</div>
						</div>

					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label class="col-lg-3 control-label" for="login">Benutzername</label>
							<div class="col-lg-9">
								<button uib-popover="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." popover-trigger="focus" class="btn btn-question has-hint" type="button">
									<i class="fa fa-question"></i>
								</button>
								<div class="wrap-hint" ng-class="{'wrap-line error': fieldError('login')}">
									<input class="form-control" type="text" name="login" ng-model="user.login" id="login" value="" ng-minlength="3" ng-maxlength="45" required>
									<span ng-show="fieldError('login')">
										<label ng-show="form.login.$error.required" class="error">Username is required.</label>
										<label ng-show="form.login.$error.minlength" class="error">Username is too short.</label>
										<label ng-show="form.login.$error.maxlength" class="error">Username is too long.</label>
										<span class="glyphicon glyphicon-remove form-control-feedback"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="email">Email</label>
							<div class="col-lg-9">
								<button uib-popover="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." popover-trigger="focus" class="btn btn-question has-hint" type="button">
									<i class="fa fa-question"></i>
								</button>
								<div class="wrap-hint" ng-class="{'wrap-line error': fieldError('email')}">
									<input class="form-control" type="email" name="email" ng-model="user.email" id="email" value="" ng-maxlength="45" required>
									<span ng-show="fieldError('email')">
										<label ng-show="form.email.$error.required" class="error">Email is required.</label>
										<label ng-show="form.email.$error.email" class="error">Enter a valid email.</label>
										<label ng-show="form.email.$error.maxlength" class="error">Username is too long.</label>
										<span class="glyphicon glyphicon-remove form-control-feedback"></span>
									</span>
								</div>
							</div>

						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label" for="phone">Telefon</label>
							<div class="col-lg-9">
								<button uib-popover="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." popover-trigger="focus" class="btn btn-question has-hint" type="button">
									<i class="fa fa-question"></i>
								</button>
								<div class="wrap-hint">
									<input class="form-control" type="text" ng-model="user.phone" id="phone" value="" ui-mask="(999) 9999 999"  ui-mask-placeholder ui-mask-placeholder-char="_">
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-custom-box clearfix">
						<div class="col-lg-12">
							<h4>Passwort</h4>
						</div>
						<div class="col-lg-6">
							<label>Passwort</label>
							<span ng-class="{'wrap-line error': fieldError('password')}">
								<input class="form-control" name="password" ng-model="user.password" type="text" value="" ng-minlength="3" ng-maxlength="45" ng-required="isInsert">
								<span ng-show="fieldError('password')">
									<label ng-show="form.password.$error.required" class="error">Password is required.</label>
									<label ng-show="form.password.$error.minlength" class="error">Password is too short.</label>
									<label ng-show="form.password.$error.maxlength" class="error">Password is too long.</label>
									<span class="glyphicon glyphicon-remove form-control-feedback"></span>
								</span>
							</span>
						</div>
						<div class="col-lg-6">
							<label>Passwort bestätigen</label>
							<span ng-class="{'wrap-line error': fieldError('password_repeat')}">
								<input class="form-control" name="password_repeat" ng-model="user.password_repeat" type="text" value="" password-verify="user.password" ng-required="isInsert">
								<span ng-show="fieldError('password_repeat')">
									<label ng-show="form.password_repeat.$error.required" class="error">Password repeat is required.</label>
									<label ng-show="form.password_repeat.$error.passwordVerify" class="error">Passwords are not equal.</label>
									<span class="glyphicon glyphicon-remove form-control-feedback"></span>
								</span>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group group-btn">
					<div class="col-lg-2" ng-if="!isInsert">
						<a class="btn btn-icon btn-danger btn-lg sweet-4" ng-click="remove(user.id)"><i class="fa fa-trash-o"></i></a>
					</div>
					<div class="col-lg-6 text-right pull-right">
						<button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
						<button class="btn w-lg custom-btn" ng-click="submitForm(user)">Speichern</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</script>
<!--End Edit user -->


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
