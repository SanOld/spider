<?php
$this->pageTitle = 'Passwort zurücksetzen | ' . Yii::app()->name;
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/reset-password.js"></script>

<div ng-controller="ResetPasswordController" class="wrapper-page animated fadeInDown">
    <div class="panel panel-color panel-primary">
        <h3 class="m-t-20 text-center">Passwort zurücksetzen</h3>
        <form novalidate name="form" class="cmxform form-horizontal m-t-20">
            <div class="alert alert-danger text-center" ng-style="submited && (error || form.$invalid) && {'display': 'block'}">
                Bitte geben Sie die markierten Felder korrekt ein
            </div>
            <div class="form-group has-feedback">
                <label class="col-lg-12" for="password">Neues Passwort</label>
                <div class="col-lg-12 wrap-line" ng-class="{'wrap-line error': fieldError('password'), 'wrap-line success': !fieldError('password')}">
                    <input class="form-control" type="password" ng-model="password" name="password" ng-minlength="3" autofocus required>
                    <span ng-show="fieldError('password')">
                        <label ng-show="form.password.$error.required" class="error">Neues Passwort ist erforderlich</label>
                        <label ng-show="form.password.$error.minlength" class="error">Neues Passwort ist zu kurz</label>
                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
								    </span>
                    <span ng-show="form.password.$dirty && form.password.$valid && !fieldError('password')" class="glyphicon glyphicon-ok form-control-feedback"></span>
                </div>
            </div>
            <div class="form-group has-feedback">
                <label class="col-lg-12" for="password2">Ein neues Passwort bestätigen </label>
                <div class="col-lg-12 wrap-line" ng-class="{'wrap-line error': fieldError('password_repeat'), 'wrap-line success': !fieldError('password_repeat')}">
                    <input class="form-control" type="password" ng-model="password_repeat" name="password_repeat" ng-pattern="password" ng-minlength="3" required>
                    <span ng-show="fieldError('password_repeat') || error">
                      <label ng-show="form.password_repeat.$error.required" class="error">Ein neues Passwort bestätigen repeat ist erforderlich</label>
                      <label ng-show="form.password_repeat.$error.passwordVerify" class="error">Passwörter sind nicht gleich</label>
                      <label ng-show="error && form.$pristine" class="error">Es gibt keinen Benutzer mit diesem Wiederherstellung -Token</label>
                      <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    </span>
                    <span ng-show="form.password_repeat.$dirty && form.password_repeat.$valid && !fieldError('password_repeat')" class="glyphicon glyphicon-ok form-control-feedback"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <button ng-click="submitForm()" class="btn btn-block btn-lg btn-purple w-md custom-btn" type="submit">Speichern &amp; Einloggen</button>
                </div>
            </div>
        </form>
    </div>
</div>