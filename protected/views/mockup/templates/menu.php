				<nav class="navbar navbar-default header-nav m-b-0">
					<div class="container">
						<ul class="nav navbar-nav">
							<li ng-class="{'active': _m=='dashboard'}"><a href="/dashboard">Startseite</a></li>
							<li><a href="request-list.php">Anträge</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Finanzen</a>
								<ul class="dropdown-menu">
									<li><a href="summary.php">Finanzübersicht</a></li>
									<li><a href="financial-request.php">Mittelabrufe</a></li>
									<li><a href="finance-report.php">Belege</a></li>
									<li><a href="finance-source.php">Fördertöpfe</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Berichte</a>
								<ul class="dropdown-menu">
									<li><a href="#" style="color: #aaa;">Sachberichte</a></li>
									<li><a href="#" style="color: #aaa;">Auswertung</a></li>
								</ul>
							</li>
							<li ng-class="{'active': ['user', 'user_type'].indexOf(_m) !== -1}" class="dropdown" ng-if="_r.user.view || _r.user_type.view">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Benutzer</a>
								<ul class="dropdown-menu">
									<li><a ng-if="canView('user')" href="/users">Benutzerliste</a></li>
									<li><a ng-if="canView('user_type')" href="/user-roles">Benutzerrollen</a></li>
								</ul>
							</li>
							<li><a href="projects">Projekte</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Akteure</a>
								<ul class="dropdown-menu">
									<li><a href="/performers">Träger</a></li>
									<li><a href="/schools">Schule</a></li>
									<li><a href="/districts">Bezirk</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Systemverwaltung</a>
								<ul class="dropdown-menu">
                  <li><a ng-if="canView('document-templates')" href="/document-templates">Druck-Templates</a></li>
									<li><a href="/hints">Hilfetexte</a></li>
                  <li><a ng-if="canView('email-templates')" href="/email-templates">Email-Vorlagen</a></li>
									<li><a href="#" style="color: #aaa;">Email-Sendebericht</a></li>
									<li><a href="audit">Audit</a></li>
								</ul>
							</li>
							<li><a href="/contact.php">Kontakt</a></li>
						</ul>
					</div>
				</nav>