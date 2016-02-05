<?php
/* @var $this SiteController */

//$this->pageTitle = 'Login | ' . Yii::app()->name;
?>
<!--<script src="--><?php //echo Yii::app()->request->baseUrl; ?><!--/js/login.js"></script>-->

<div class="wrapper-page animated fadeInDown">
    <div class="panel panel-color panel-primary">
        <form id="recover-password" method="post" action="success-alert.html" role="form" class="text-center cmxform form-horizontal">
            <h3 class="m-t-20">Ihr Passwort vergessen?</h3>
            <p class="m-b-10">Bitte geben Sie eine Email Adresse ein, um das Passwort zurückzusetzen</p>
            <div class="alert alert-danger">
                Bitte geben Sie die markierten Felder korrekt ein.
            </div>
            <div class="form-group text-left has-feedback m-t-15">
                <div class="col-lg-12 wrap-line">
                    <input type="email" class="form-control" placeholder="Geben Sie die Email Adresse ein" name="email" autofocus>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-12">
                    <button class="btn btn-block btn-lg btn-purple w-md custom-btn" type="submit">SENDEN</button>
                </div>
            </div>
        </form>
    </div>
</div>