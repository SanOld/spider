<!DOCTYPE html>
<html lang="en">
	<head>
		<title>404 | SPIder</title>
		<?php include('templates/head.php'); ?>
	</head>

	<body class="bg">
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
	
			<!-- Navbar Start -->
	
			<?php include('templates/menu.php'); ?>

			<div class="container unknown-page">
				<div class="col-lg-12 animated fadeInDown text-center">
					<div class="col-lg-12">
						<h1>404</h1>
						<h2>Entschuldigung, die angeforderte Seite konnte leider nicht gefunden werden.</h2>
						<ul class="list-inline">
							<li><a href="/dashboard">Return to the Homepage</a></li>
							<li><a href="/performers">Träger</a></li>
							<li><a href="/request-list.php">Antrag</a></li>
							<li><a href="/financial-request.php">Mittelabruf</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
	<?php include('templates/footer.php'); ?>
	
	<?php include('templates/scripts.php'); ?>

	<?php include('templates/edit-user.php'); ?>
	</body>
</html>