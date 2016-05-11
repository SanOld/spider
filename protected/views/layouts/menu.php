<nav class="navbar navbar-default header-nav m-b-0">
	<div class="container">
		<ul class="nav navbar-nav">
			<li ng-class="{'active': _m=='dashboard'}"><a href="/dashboard">Startseite</a></li>
			<li><a href="request-list.php">Anträge</a></li>
			<li ng-class="{'active': ['finance_source'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Finanzen</a>
				<ul class="dropdown-menu">
					<li><a href="summary.php">Finanzübersicht</a></li>
                    <li><a href="financial-request.php">Mittelabrufe</a></li>
					<li><a href="finance-report.php">Belege</a></li>
					<li><a ng-if="canShow('finance_source')" href="/finance-source">Fördertöpfe</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Berichte</a>
				<ul class="dropdown-menu">
					<li><a href="#" style="color: #aaa;">Sachberichte</a></li>
					<li><a href="#" style="color: #aaa;">Auswertung</a></li>
				</ul>
			</li>
			<li ng-class="{'active': ['user', 'user_type'].indexOf(_m) !== -1}" class="dropdown" ng-if="canShow('user') || canShow('user_type')">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Benutzer</a>
				<ul class="dropdown-menu">
					<li><a ng-if="canShow('user')" href="/users">Benutzerliste</a></li>
					<li><a ng-if="canShow('user_type')" href="/user-roles">Benutzerrollen</a></li>
				</ul>
			</li>
			<li><a href="projects" ng-if="canShow('audit')">Projekte</a></li>
			<li ng-class="{'active': ['performer', 'school', 'district'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Akteure</a>
				<ul class="dropdown-menu">
					<li><a ng-if="canShow('performer')" href="/performers">Träger</a></li>
					<li><a ng-if="canShow('school')" href="/schools">Schule</a></li>
					<li><a ng-if="canShow('district')" href="/districts">Bezirk</a></li>
				</ul>
			</li>
			<li ng-class="{'active': ['hint'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Systemverwaltung</a>
				<ul class="dropdown-menu">
					<li><a href="document-templates.php">Druck-Templates</a></li>
					<li><a ng-if="canShow('hint')" href="/hints">Hilfetexte</a></li>
					<li><a href="email-templates.php">Email-Vorlagen</a></li>
					<li><a href="#" style="color: #aaa;">Email-Sendebericht</a></li>
					<li><a href="audit" ng-if="canShow('audit')">Audit</a></li>
				</ul>
			</li>
			<li><a href="#">Kontakt</a></li>
		</ul>
	</div>
</nav>