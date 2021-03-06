<?php
$this->pageTitle = 'Forgot Password | ' . Yii::app()->name;
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/forgot-password.js"></script>

<div ng-controller="ForgotPasswordController">
    <div ng-hide="success" ng-class="{'animated': !success}" class="wrapper-page fadeInDown">
        <div class="panel panel-color panel-primary">
            <form novalidate name="form" class="text-center cmxform form-horizontal">
                <h3 class="m-t-20">Passwort vergessen?</h3>
                <p class="m-b-10">Bitte geben Sie Ihre E-Mail-Adresse ein, um Ihr Passwort zurückzusetzen</p>
                <div class="alert alert-danger" ng-style="submited && error && {'display': 'block'}">
                    Bitte geben Sie die markierten Felder korrekt ein
                </div>
                <div class="form-group text-left has-feedback m-t-15">
                    <div class="col-lg-12 wrap-line" ng-class="{'wrap-line error': fieldError(), 'wrap-line success': !fieldError()}">
                        <input type="email" ng-model="email" name="email" class="form-control" placeholder="Geben Sie die E-Mail-Adresse ein" name="email" autofocus required>
                        <span ng-show="fieldError()">
                            <label ng-show="form.email.$error.email || form.email.$error.required" class="error">Bitte geben Sie Ihre E-Mail-Adresse ein, um Ihr Passwort zurückzusetzen</label>
                            <label ng-show="error && form.email.$pristine" class="error">E-Mail-Adresse nicht im System vorhanden oder nicht aktiv</label>
                            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        </span>
                        <span ng-show="form.email.$dirty && !fieldError()" class="glyphicon glyphicon-ok form-control-feedback"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12">
                        <button ng-click="submitForm()" class="btn btn-block btn-lg btn-purple w-md custom-btn" type="submit">SENDEN</button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12">
                      <a href="/" class="btn btn-block btn-lg w-md cancel-btn"style="text-transform: uppercase;color: rgb(32, 32, 32);">Abbrechen</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>