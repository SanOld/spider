<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Startseite | SPIder</title>
		<?php include('templates/head.php'); ?>
	</head>

	<body class="bg">
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
	
			<!-- Navbar Start -->
	
			<?php include('templates/menu.php'); ?>

			<div class="container home-dashboard">
				<div class="col-lg-12 animated fadeInDown text-center">
					<div class="col-lg-12">
						<h1>Willkommen zu Stiftung SPI</h1>
						<h2>Upgrade der "Jugendsozialarbeit an Berliner Schulen" auf SPIder 2</h2>
						<p>Ab der Antragsphase für das Förderjahr 2017 steigen wir um auf die neue Programmsoftware SPIder 2.
							Wir freuen uns, Ihnen schon jetzt die neue Software vorstellen zu können, so dass Sie sich frühzeitig 
							mit der neu überarbeiteten Software vertraut machen können.
							Damit Ihre Arbeitsumgebung zum Start der neuen Antragsphase 2017 optimal eingerichtet ist, 
							bitten wir Sie, schon jetzt Ihre Trägerdaten auszufüllen. 
							Den Antrag 2017 und den Mittelabruf können Sie sich bereits ansehen.</p>
					</div>
					<div class="row text-left">
						<div class="col-lg-4">
							<a class="box-home box-1" href="#">
								<h2>Trägerdaten</h2>
							</a>
						</div>
						<div class="col-lg-4">
							<a class="box-home box-2" href="request-list.php">
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
		</div>
		
	<?php include('templates/footer.php'); ?>
	
	<?php include('templates/scripts.php'); ?>

	<?php include('templates/edit-user.php'); ?>
	</body>
</html>