<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('head.php'); ?>
</head>
<body ng-class="{'bg': _m == 'dashboard'}" ng-app="spi" ng-controller="main">
<div id="page">
  <header class="top-head container-fluid">
    <div class="container">
      <div class="logo p-0 m-t-10 m-b-10 col-lg-6">
        <a href="/dashboard">
          <img src="<?php echo $baseUrl; ?>/images/logo.png" alt="logo">
        </a>
      </div>
      <div class="logo logo-print p-0 m-t-20 m-b-15 col-lg-5">
        <a target="_blank" href="http://service.berlin.de/senatsverwaltungen/" class="pull-right">
          <img src="<?php echo $baseUrl; ?>/images/logo2.png" alt="logo">
        </a>
      </div>
      <ul class="list-inline navbar-right top-menu top-right-menu profile-box">
        <li class="dropdown text-center">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img class="img-circle profile-img thumb-sm" src="<?php echo $baseUrl; ?>/images/avatar.jpg" alt="">

            <div class="holder-box">
              <span class="username" ng-bind="user.login">&nbsp</span>
              <span class="organization">Stiftung SPI</span>
            </div>
            <span class="caret"></span>
          </a>
          <ul style="overflow: hidden; outline: none;" tabindex="5003"
              class="dropdown-menu extended pro-menu fadeInUp animated">
            <li><a href="" ng-click="openEdit()"><i class="fa fa-briefcase"></i>Profil</a></li>
            <li><a href="" ng-click="logout()"><i class="fa fa-sign-out"></i>Ausloggen</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </header>

  <?php include('menu.php'); ?>

  <?php if (isset($this->breadcrumbs) && $this->breadcrumbs): ?>
    <div class="container">
      <?php
      $this->widget('zii.widgets.CBreadcrumbs', array('links' => $this->breadcrumbs, 'homeLink' => '<li>' . CHtml::link('Home', array('/site/dashboard')) . '</li>', 'tagName' => 'ul', 'separator' => '', 'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>', 'inactiveLinkTemplate' => '<li class="active">{label}</li>', 'htmlOptions' => array('class' => 'breadcrumb p-0'))); ?>
    </div>
  <?php endif; ?>

  <?php echo $content; ?>
</div>

<div class="footer">
  <div class="container">
    <div class="col-lg-7">
      <a href="http://service.berlin.de/senatsverwaltungen" class="pull-left m-t-10">
        <img src="<?php echo $baseUrl; ?>/images/logo2-small.png" alt="logo">
      </a>
    </div>
    <div class="col-lg-5 contact-footer">
      <a target="_blank" href="http://www.stiftung-spi.de" class="pull-right m-l-15">
        <img src="<?php echo $baseUrl; ?>/images/logo3.png" alt="logo">
      </a>
    </div>
  </div>
</div>
<div class="md-overlay"></div>

<script type="text/ng-template" id="editUserTemplate.html">
  <div class="panel panel-color panel-primary">
    <div class="panel-heading clearfix">
      <h3 ng-if="isInsert" class="m-0 pull-left">Bearbeiten eines Benutzer</h3>

      <h3 ng-if="!isInsert" class="m-0 pull-left">Benutzerprofil editieren</h3>
      <button type="button" ng-click="cancel()" class="close"><i class="ion-close-round "></i></button>
    </div>
    <div ng-show="(submited && form.$invalid) || error" class="alert alert-danger m-t-20">
      Bitte geben Sie die markierten Felder korrekt ein.
    </div>
    <h3 class="subheading">Benutzerinformation</h3>
    <hr>
    <div class="panel-body">
      <form novalidate class="form-horizontal" name="form" disable-all="!canEdit()">
        <div class="form-group">
          <label class="col-lg-2 control-label">Status</label>

          <div class="col-lg-10">
            <div ng-if="!isCurrentUser" class="btn-group btn-toggle">
              <button class="btn btn-sm" ng-class="{'btn-default': user.is_active != 1}" ng-model="user.is_active"
                      uib-btn-radio="1">AKTIV
              </button>
              <button class="btn btn-sm" ng-class="{'btn-default': user.is_active != 0}" ng-model="user.is_active"
                      uib-btn-radio="0">DEAKTIVIEREN
              </button>
            </div>
            <span ng-if="isCurrentUser" class="no-edit-text">{{user.is_active ? 'Aktiv' : 'Deaktivieren'}}</span>
            <span spi-hint text="_hint.is_active"></span>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label">Benutzer-Typ</label>

          <div ng-if="isCurrentUser || (!isInsert && !isPerformer)" class="col-lg-10">
            <span class="no-edit-text">{{type_name}}</span>
            <span spi-hint text="_hint.type_id"></span>
          </div>

          <div ng-if="!isCurrentUser && (isInsert || isPerformer)" class="col-lg-4 custom-width">
            <div spi-hint text="_hint.type_id" class="has-hint"></div>

            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('type_id')}">
              <ui-select ng-change="reloadRelation()" ng-model="user.type_id" name="type_id" required>
                <ui-select-match placeholder="(Please choose)">{{$select.selected.name}}</ui-select-match>
                <ui-select-choices repeat="type.id as type in userTypes | filter: $select.search">
                  <span ng-bind-html="type.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
								<span ng-show="fieldError('type_id')">
									<label ng-show="form.type_id.$error.required" class="error">Benutzer-Typ is required.</label>
								</span>
            </div>
          </div>

        </div>
        <div ng-if="(isInsert && isRelation) || (!isInsert && relation_name)" class="form-group">
          <label class="col-lg-2 control-label">Organisation</label>

          <div ng-if="!isInsert" class="col-lg-10">
            <span class="no-edit-text">{{relation_name}}</span>
            <span spi-hint text="_hint.relation_id"></span>
          </div>

          <div ng-if="isInsert" class="col-lg-10">
            <div spi-hint text="_hint.relation_id" class="has-hint"></div>

            <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('relation_id')}">
              <ui-select ng-disabled="!$select.items.length" ng-model="user.relation_id" name="relation_id" required>
                <ui-select-match placeholder="{{$select.disabled ? '(No items available)' :'(Please choose)'}}">
                  {{$select.selected.name}}
                </ui-select-match>
                <ui-select-choices repeat="item.id as item in relations | filter: $select.search">
                  <span ng-bind-html="item.name | highlight: $select.search"></span>
                </ui-select-choices>
              </ui-select>
								<span ng-show="fieldError('relation_id')">
									<label ng-show="form.type_id.$error.required" class="error">Organisation is required.</label>
								</span>
            </div>
          </div>
        </div>
        <div class="form-group" ng-if="!isPerformer">
          <label class="col-lg-2 control-label two-line">Finanzielle Rechte</label>

          <div class="col-lg-10">
            <div ng-if="!isCurrentUser" class="btn-group btn-toggle">
              <button class="btn btn-sm" ng-class="{'btn-default': user.is_finansist != 1}" ng-model="user.is_finansist"
                      uib-btn-radio="1">JA
              </button>
              <button class="btn btn-sm" ng-class="{'btn-default': user.is_finansist != 0}" ng-model="user.is_finansist"
                      uib-btn-radio="0">NEIN
              </button>
            </div>
            <span ng-if="isCurrentUser" class="no-edit-text">{{user.is_finansist ? 'Ja' : 'Nein'}}</span>
            <span spi-hint text="_hint.is_finansist"></span>
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
                <div spi-hint text="_hint.title" class="has-hint"></div>
                <div class="wrap-hint">
                  <input id="title" class="form-control" ng-model="user.title" type="text" value="">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-4 control-label" for="title">Funktion</label>

              <div class="col-lg-8">
                <div spi-hint text="_hint.function" class="has-hint"></div>
                <div class="wrap-hint">
                  <input id="title" class="form-control" ng-model="user.function" type="text" value="">
                </div>
              </div>
            </div>
            <div class="form-group has-feedback">
              <label class="col-lg-4 control-label" for="first_name">Vorname</label>
              <div class="col-lg-8">
                <div spi-hint text="_hint.first_name" class="has-hint"></div>
                <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('first_name')}">
                  <input class="form-control" ng-model="user.first_name" name="first_name" type="text" id="first_name"
                         value="" ng-minlength="2" ng-maxlength="45" required>
                    <span ng-show="fieldError('first_name')">
                    <label ng-show="form.first_name.$error.required" class="error">Vorname is required.</label>
                    <label ng-show="form.first_name.$error.minlength" class="error">Vorname is too short.</label>
                    <label ng-show="form.first_name.$error.maxlength" class="error">Vorname is too long.</label>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                  </span>
                </div>
              </div>
            </div>
            <div class="form-group has-feedback">
              <label class="col-lg-4 control-label" for="lname">Nachname</label>
              <div class="col-lg-8">
                <div spi-hint text="_hint.last_name" class="has-hint"></div>
                <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('last_name')}">
                  <input class="form-control" ng-model="user.last_name" name="last_name" type="text" id="lname" value=""
                         ng-minlength="2" ng-maxlength="45" required>
                  <span ng-show="fieldError('last_name')">
                    <label ng-show="form.last_name.$error.required" class="error">Nachname is required.</label>
                    <label ng-show="form.last_name.$error.minlength" class="error">Nachname is too short.</label>
                    <label ng-show="form.last_name.$error.maxlength" class="error">Nachname is too long.</label>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                  </span>
                </div>
              </div>
            </div>

          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label class="col-lg-3 control-label" for="login">Benutzername</label>

              <div class="col-lg-9">
                <div spi-hint text="_hint.login" class="has-hint"></div>
                <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('login')}">
                  <input class="form-control" type="text" name="login" ng-model="user.login" id="login" value=""
                         ng-disabled="isCurrentUser" ng-minlength="3" ng-maxlength="45" required>
									<span ng-show="fieldError('login')">
										<label ng-show="form.login.$error.required" class="error">Benutzername is required.</label>
										<label ng-show="form.login.$error.minlength" class="error">Benutzername is too short.</label>
										<label ng-show="form.login.$error.maxlength" class="error">Benutzername is too long.</label>
                    <label ng-show="error.login.dublicate" class="error">This Username already registered.</label>
										<span class="glyphicon glyphicon-remove form-control-feedback"></span>
									</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="email">Email</label>

              <div class="col-lg-9">
                <div spi-hint text="_hint.email" class="has-hint"></div>
                <div class="wrap-hint" ng-class="{'wrap-line error': fieldError('email')}">
                  <input class="form-control" type="email" name="email" ng-model="user.email" id="email" value=""
                         ng-maxlength="45" required>
									<span ng-show="fieldError('email')">
										<label ng-show="form.email.$error.required" class="error">Email is required.</label>
										<label ng-show="form.email.$error.email" class="error">Enter a valid email.</label>
										<label ng-show="form.email.$error.maxlength" class="error">Username is too long.</label>
										<label ng-show="error.email.dublicate" class="error">This email already registered.</label>
										<span class="glyphicon glyphicon-remove form-control-feedback"></span>
									</span>
                </div>
              </div>

            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label" for="phone">Telefon</label>

              <div class="col-lg-9">
                <div spi-hint text="_hint.phone" class="has-hint"></div>
                <div class="wrap-hint">
                  <input class="form-control" type="text" ng-model="user.phone" id="phone" value=""
                         ui-mask="(999) 9999 999" ui-mask-placeholder ui-mask-placeholder-char="_">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row" ng-if="isCurrentUser || canEdit()">
          <div class="form-custom-box clearfix">
            <div class="col-lg-12">
              <h4>Passwort</h4>
            </div>
            <div ng-if="isCurrentUser" class="col-lg-4">
              <label>Altes Passwort</label>

              <div
                ng-class="{'wrap-line error': fieldError('old_password')}">
                <input class="form-control" name="old_password" ng-model="user.old_password" type="password" value="">
								  <span ng-show="fieldError('old_password')">
                    <label ng-show="error.old_password.error" class="error">Old password is wrong.</label>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
								  </span>
              </div>
            </div>
            <div ng-class="isCurrentUser ? 'col-lg-4' : 'col-lg-6'">
              <label>Passwort</label>

              <div ng-class="{'wrap-line error': fieldError('password')}">
                <input class="form-control" name="password" ng-model="user.password" type="password" value=""
                       ng-minlength="3" ng-required="isInsert">
								  <span ng-show="fieldError('password')">
                    <label ng-show="form.password.$error.required" class="error">Passwort is required.</label>
                    <label ng-show="form.password.$error.minlength" class="error">Passwort is too short.</label>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
								  </span>
              </div>
            </div>
            <div ng-class="isCurrentUser ? 'col-lg-4' : 'col-lg-6'">
              <label>Passwort bestätigen</label>

              <div ng-class="{'wrap-line error': fieldError('password_repeat')}">
                <input class="form-control" name="password_repeat" ng-model="password_repeat" type="password" value=""
                       ng-pattern="user.password" ng-required="isInsert || user.password.length">
								<span ng-show="fieldError('password_repeat')">
									<label ng-show="form.password_repeat.$error.required" class="error">Passwort bestätigen is
                    required.</label>
									<label ng-show="form.password_repeat.$error.pattern" class="error">Passwords are not equal.</label>
									<span class="glyphicon glyphicon-remove form-control-feedback"></span>
								</span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group group-btn">
          <div class="col-lg-2" ng-if="!isInsert && !isCurrentUser && canDelete()">
            <a class="btn btn-icon btn-danger btn-lg sweet-4" ng-click="remove(userId)"><i
                class="fa fa-trash-o"></i></a>
          </div>
          <div class="col-lg-6 text-right pull-right">
            <button class="btn w-lg cancel-btn" ng-click="cancel()">Abbrechen</button>
            <button class="btn w-lg custom-btn" ng-if="canEdit()" ng-click="submitForm(user)">Speichern</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</script>

</body>
</html>


