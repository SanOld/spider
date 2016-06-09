<?php
/* @var $this SiteController */

$this->pageTitle = 'Startseite | ' . Yii::app()->name;

?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/dashboard.js"></script>

<div class="container home-dashboard" ng-controller="DashboardController">
    <div class="col-lg-12 animated fadeInDown text-center">
        <div class="col-lg-12">
            <h2 ng-bind="_hint.header.title"></h2>
            <p ng-bind-html="_hint.header.text | nl2br"></p>
        </div>
        <div class="row text-left">
            <div class="col-lg-4">
                <a class="box-home box-1" href="/performers">
                    <h2>Träger</h2>
                </a>
            </div>
            <div class="col-lg-4">
                <a class="box-home box-2" href="/requests">
                    <h2>Antrag</h2>
                </a>
            </div>
            <div class="col-lg-4">
                <a class="box-home box-3" href="financial-request.php">
                    <h2>Mittelabruf</h2>
                </a>
            </div>
        </div>
    </div>
</div>