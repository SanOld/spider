<nav class="navbar navbar-default header-nav m-b-0">
	<div class="container">
		<ul class="nav navbar-nav">
			<li ng-class="{'active': _m=='dashboard'}"><a href="/dashboard">Startseite</a></li>           
			<li ng-class="{'active': ['performer', 'school', 'district'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Stammdaten</a>
				<ul class="dropdown-menu">
          <?php if(safe(Yii::app()->session['rights']['performers'], 'show')): ?>  
					  <li><a href="/performers">Träger</a></li>
          <?php endif; ?>  
          <?php if(safe(Yii::app()->session['rights']['schools'], 'show')): ?>
					  <li><a href="/schools">Schule</a></li>
          <?php endif; ?>  
          <?php if(safe(Yii::app()->session['rights']['districts'], 'show')): ?>          
					  <li><a href="/districts">Bezirk</a></li>
          <?php endif; ?>  
				</ul>
			</li>
			<!--<li><a href="/request-list.php">Anträge</a></li>-->
      <li><a href="/requests">Anträge</a></li>
      <?php if(safe(Yii::app()->session['rights']['summary'], 'show') ||
               safe(Yii::app()->session['rights']['financial-request'], 'show') ||
               safe(Yii::app()->session['rights']['finance-report'], 'show') ||
               safe(Yii::app()->session['rights']['finance-source'], 'show')): ?>
			<li ng-class="{'active': ['finance_source'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Finanzen</a>
				<ul class="dropdown-menu">
          <?php if(safe(Yii::app()->session['rights']['summary'], 'show')):?>
					<li><a href="/summary">Finanzübersicht</a></li>
          <?php endif; ?>
          <?php if(safe(Yii::app()->session['rights']['financial-request'], 'show')):?>
					  <li ng-hide="user.type == 't' && user.is_finansist == 0"><a href="/financial-request">Mittelabrufe</a></li>
          <?php endif; ?>
          <?php if(safe(Yii::app()->session['rights']['finance-report'], 'show')):?>
					  <li><a href="/finance-report">Finanzbericht</a></li>
          <?php endif; ?>
          <?php if(safe(Yii::app()->session['rights']['finance-source'], 'show')): ?>
					  <li><a href="/finance-source">Fördertöpfe</a></li>
          <?php endif; ?>
				</ul>
			</li>
      <?php endif; ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Berichte</a>
				<ul class="dropdown-menu">
					<li><a href="#" style="color: #aaa;">Sachberichte</a></li>
					<li><a href="#" style="color: #aaa;">Auswertung</a></li>
				</ul>
			</li>
      <?php if(safe(Yii::app()->session['rights']['projects'], 'show')): ?>
			<li><a href="/projects">Projekte</a></li>
      <?php endif; ?> 
      <?php if(safe(Yii::app()->session['rights']['users'], 'show') || safe(Yii::app()->session['rights']['user-roles'], 'show')): ?>
			<li ng-class="{'active': ['user', 'user_type'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Benutzer</a>
				<ul class="dropdown-menu">
          <?php if(safe(Yii::app()->session['rights']['users'], 'show')): ?>
					  <li><a href="/users">Benutzerliste</a></li>
          <?php endif; ?>
          <?php if(safe(Yii::app()->session['rights']['user-roles'], 'show')): ?>
					  <li><a href="/user-roles">Benutzerrollen</a></li>
          <?php endif; ?>
				</ul>
			</li>
      <?php endif; ?>
      <?php if(safe(Yii::app()->session['rights']['document-templates'], 'show') || 
               safe(Yii::app()->session['rights']['hints'], 'show') || 
               safe(Yii::app()->session['rights']['email-templates'], 'show') || 
               safe(Yii::app()->session['rights']['audit'], 'show')): ?>
			<li ng-class="{'active': ['hint'].indexOf(_m) !== -1}" class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Systemverwaltung</a>
				<ul class="dropdown-menu">
          <?php if(Yii::app()->session['rights']['document-templates']['show']): ?>
            <li><a href="/document-templates">Druck-Templates</a></li>
          <?php endif; ?>
          <?php if(Yii::app()->session['rights']['hints']['show']): ?>
					  <li><a href="/hints">Hilfetexte</a></li>
          <?php endif; ?>
          <?php if(Yii::app()->session['rights']['email-templates']['show']): ?>          
            <li><a href="/email-templates">E-Mail-Vorlagen</a></li>
          <?php endif; ?>
					  <li><a href="#" style="color: #aaa;">E-Mail-Sendebericht</a></li>
          <?php if(Yii::app()->session['rights']['audit']['show']): ?>
					  <li><a href="/audit">Audit</a></li>
          <?php endif; ?>
				</ul>
			</li>
      <?php endif; ?>
			<li><a href="/contact">Kontakt</a></li>
		</ul>
	</div>   
</nav>