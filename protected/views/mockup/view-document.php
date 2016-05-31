<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Druck-Template | SPIder</title>
		<?php include('templates/head.php'); ?>
	</head>

	<body>
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
			
			 <!-- Navbar Start -->
			
			<?php include('templates/menu.php'); ?>
				
			<div class="container">
				<ul class="breadcrumb p-0">
					<li><a href="/dashboard">Home</a></li>
					<li><a href="#">Druck-Template</a></li>
					<li class="active">FV_2014_Sonderkündigung</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">FV_2014_Sonderkündigung</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken<i class="ion-printer"></i></a>
								</div>
							</div>
							<div class="panel-body edit-user doc-template">
								<div class="row">
									<div class="col-lg-12">
										Zwischen<br/>
										der<br/>
										Stiftung Sozialpädagogisches Institut Berlin<br/>
										Programmagentur “Jugendsozialarbeit an Berliner Schulen”<br/>
										Schicklerstraße 5-7 in 10179 Berlin<br/>
										
										- nachstehend Programmagentur SPI genannt -<br/>
										und dem Träger<br/>
										
										<strong>{TRAEGER}</strong> mit der Kennziffer <strong>{KENNZIFFER}</strong><br/>
										
										- nachstehend Förderungsempfänger genannt -<br/>
										wird folgender<br/>
										<h3>FÖRDERVERTRAG (Weiterleitungsvertrag)</h3>
										geschlossen.<br/>
										
										<h4>§ 1 Grundsätzliche Regelungen</h4>
										
										(1) Die Programmagentur SPI ist vom Land Berlin, vertreten durch die Senatsverwaltung für Bildung, Jugend und Wissenschaft beauftragt worden, das Programm „Jugendsozialarbeit an Berliner Schulen“ umzusetzen. Das Programm wird durch Mittel des Berliner Landeshaushalts finanziert.<br/>
										
										(2) Zur Umsetzung des Programms entwickeln die freien Träger der Kinder- und Jugendhilfe zusammen mit einer Schule bzw. mehreren Schulen (betrifft Jugendsozialarbeit mit besonderen Aufgaben) konkrete auf die jeweilige Schule bezogene Konzepte. Dazu werden Kooperationsverträge zwischen den Schulen und den freien Trägern der Kinder- und Jugendhilfe abgeschlossen.<br/>
										
										(3) Die freien Träger verpflichten sich, das Gender-Mainstreaming-Prinzip anzuwenden, d. h. bei der Planung, Durchführung und Begleitung der Maßnahme sind Auswirkungen auf die Gleichstellung von Frauen und Männern aktiv zu berücksichtigen und in der Berichterstattung darzustellen.<br/>
										
										<h4>§ 2 Vertragsgegenstand und -bestandteile</h4>
										
										(1) Gegenstand dieses privatrechtlichen Vertrages ist die Weitergabe von Zuwendungen des Landes Berlin durch die Programmagentur SPI an die Förderungsempfänger auf der Grundlage entsprechender Bewilligungsbescheide der Senatsverwaltung für Bildung, Jugend und Wissenschaft.<br/>
										
										(2) Bestandteile dieses Vertrages sind – in ihrer jeweils geltenden Fassung – insbesondere:<br/>
										Antrag des Förderungsempfängers inkl. Finanzplan,</div>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- End Row -->
			</div>
		</div>

		<!-- Page Content Ends -->
		<!-- ================== -->
		<?php include('templates/footer.php'); ?>



		<div class="md-overlay"></div>
		

		<?php include('templates/scripts.php'); ?>

		
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>