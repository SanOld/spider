<nav class="navbar navbar-default header-nav m-b-0">
	<div class="container">
		<ul class="nav navbar-nav">
			<li ng-class="{'active': _m=='dashboard'}"><a href="/dashboard">Startseite</a></li>
			<li><a href="projects-list.php">Projekte</a></li>
			<li><a href="request-list.php">Anträge</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Berichte</a>
				<ul class="dropdown-menu">
					<li><a href="#">Statistik</a></li>
					<li><a href="#">Auswertung</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Finanzen</a>
				<ul class="dropdown-menu">
					<li><a href="summary.php">Finanzübersicht</a></li>
					<li><a href="financial-request.php">Mittelabrufe</a></li>
					<li><a href="finance-report.php">Belege</a></li>
					<li><a href="finance-source.php">Finanzierungen</a></li>
				</ul>
			</li>
			<li ng-class="{'active': ['user', 'user_type'].indexOf(_m) !== -1}" class="dropdown" ng-if="_r.user.view || _r.user_type.view">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Benutzer</a>
				<ul class="dropdown-menu">
					<li><a ng-if="canView('user')" href="/users">Benutzerliste</a></li>
					<li><a ng-if="canView('user_type')" href="/user-roles">Benutzerrollen</a></li>
				</ul>
			</li>
			<li ng-class="{'active': ['performer'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Akteure</a>
				<ul class="dropdown-menu">
					<li><a href="agency-list.php">Träger Agentur</a></li>
					<li><a href="schools-list.php">Schule</a></li>
					<li><a href="districts-list.php">Bezirk</a></li>
				</ul>
			</li>
			<li ng-class="{'active': ['hint'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Systemverwaltung</a>
				<ul class="dropdown-menu">
					<li><a href="email-templates.php">E-Mail-Vorlagen</a></li>
					<li><a href="#">E-Mail-Warteschlange</a></li>
					<li><a ng-if="canView('hint')" href="/hints">Hintsmodul</a></li>
					<li><a href="document-templates.php">Dokumentvorlage</a></li>
					<li><a href="#">Audit</a></li>
				</ul>
			</li>
			<li><a href="#">Kontakt</a></li>
		</ul>
	</div>
</nav>