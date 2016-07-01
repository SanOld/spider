<nav class="navbar navbar-default header-nav m-b-0">
	<div class="container">
		<ul class="nav navbar-nav">
			<li ng-class="{'active': _m=='dashboard'}"><a href="/dashboard">Startseite</a></li>
			<!--<li><a href="/request-list.php">Anträge</a></li>-->
      <li><a href="/requests">Anträge</a></li>
			<li ng-class="{'active': ['finance_source'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Finanzen</a>
				<ul class="dropdown-menu">
					<li><a href="/summary">Finanzübersicht</a></li>
					<li><a href="/financial-request">Mittelabrufe</a></li>
					<li><a href="/finance-report">Belege</a></li>
					<li ng-if="canShow('finance_source')"><a href="/finance-source">Fördertöpfe</a></li>
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
					<li ng-if="canShow('user')"><a href="/users">Benutzerliste</a></li>
					<li ng-if="canShow('user_type')"><a href="/user-roles">Benutzerrollen</a></li>
				</ul>
			</li>
			<li ng-if="canShow('project')"><a href="/projects">Projekte</a></li>
			<li ng-class="{'active': ['performer', 'school', 'district'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Akteure</a>
				<ul class="dropdown-menu">
					<li ng-if="canShow('performer')"><a href="/performers">Träger</a></li>
					<li ng-if="canShow('school')"><a href="/schools">Schule</a></li>
					<li ng-if="canShow('district')"><a href="/districts">Bezirk</a></li>
				</ul>
			</li>
			<li ng-class="{'active': ['hint'].indexOf(_m) !== -1}" 
                ng-if="canShow('document_template') || canShow('email_template') || canShow('audit') || canShow('hint')"
                class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Systemverwaltung</a>
				<ul class="dropdown-menu">
          <li><a ng-if="canShow('document_template')" href="/document-templates">Druck-Templates</a></li>
					<li><a ng-if="canShow('hint')" href="/hints">Hilfetexte</a></li>
          <li><a ng-if="canShow('email_template')" href="/email-templates">Email-Vorlagen</a></li>
					<li><a href="#" style="color: #aaa;">Email-Sendebericht</a></li>
					<li><a href="/audit" ng-if="canShow('audit')">Audit</a></li>
				</ul>
			</li>
			<li><a href="/contact">Kontakt</a></li>
		</ul>
	</div>   
</nav>