<?php
$this->pageTitle = '404 | ' . Yii::app()->name;
?>

<div class="container unknown-page" ng-init="_m = 404">
	<div class="col-lg-12 animated fadeInDown text-center">
		<div class="col-lg-12">
			<h1>404</h1>
			<h2>Entschuldigung, die angeforderte Seite konnte leider nicht gefunden werden.</h2>
			<ul class="list-inline" ng-switch="isLogin">
				<li ng-switch-when="true"><a href="/dashboard">Return to the Homepage</a></li>
				<li ng-switch-when="true"><a href="/performers">Träger</a></li>
				<li ng-switch-when="true"><a href="/requests">Antrag</a></li>
				<li ng-switch-when="true"><a href="/financial-request.php">Mittelabruf</a></li>
				<li ng-switch-default><a href="/">Return to the Login Page</a></li>
			</ul>
		</div>
	</div>
</div>