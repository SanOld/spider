<nav class="navbar navbar-default header-nav m-b-0">
	<div class="container">
		<ul class="nav navbar-nav">
			<li ng-class="{'active': _m=='dashboard'}"><a href="/dashboard">Startseite</a></li>
			<li><a href="#">Projekte</a></li>
			<li><a href="#">Anträge</a></li>
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
					<li><a href="#">Finanzierungen</a></li>
					<li><a href="#">Zusammenfassung der Finanzen</a></li>
					<li><a href="#">Mittelabrufe</a></li>
					<li><a href="#">Belege</a></li>
					<li><a href="#">Finanzberichte</a></li>
				</ul>
			</li>
			<li ng-class="{'active': ['user', 'user_type'].indexOf(_m) !== -1}" class="dropdown" ng-if="_r.user.view || _r.user_type.view">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Benutzer</a>
				<ul class="dropdown-menu">
					<li><a ng-if="canView('user')" href="/users">Benutzerliste</a></li>
					<li><a ng-if="canView('user_type')" href="/user-roles">Benutzerrollen</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Akteure</a>
				<ul class="dropdown-menu">
					<li><a href="#">Träger Agentur</a></li>
					<li><a href="#">Schule</a></li>
					<li><a href="#">Bezirk</a></li>
				</ul>
			</li>
			<li ng-class="{'active': ['hint'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Systemverwaltung</a>
				<ul class="dropdown-menu">
					<li><a href="#">E-Mail-Vorlagen</a></li>
					<li><a href="#">E-Mail-Warteschlange</a></li>
					<li><a ng-if="canView('hint')" href="/hints">Hintsmodul</a></li>
					<li><a href="#">Dokumentvorlage</a></li>
					<li><a href="#">Audit</a></li>
				</ul>
			</li>
			<li><a href="#">Kontakt</a></li>
		</ul>
	</div>
</nav>