<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Kontakt | SPIder</title>
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
					<li><a href="/dashboard">Startseite</a></li>
					<li class="active">Kontakt</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Kontakt</h1>
							</div>
							<div class="panel-body contact-block">
								<div class="row">
									<div class="col-lg-6">
										<ul class="list-unstyled">
											<li class="address">
												<address>
													<strong>Stiftung SPI</strong>
													<span><strong>Programmagentur "Jugendsozialarbeit an Berliner Schulen"</strong></span>
													<span>Schicklerstr. 5-7</span>
													<span>10179 Berlin</span>
												</address>
											</li>
											<li class="contact-phone">
												<dl class="dl-horizontal">
													<dt>Telefon:</dt>
													<dd> +49 30 2888-496-0</dd>
													<dt>Fax:</dt>
													<dd>+49 30 2888-496-20</dd>
												</dl>
											</li>
											<li class="contact-email">
												<a href="mailto:programmagentur@stiftung-spi.de">E-Mail Senden</a>
											</li>
										</ul>

									</div>
									<div class="col-lg-6">
										<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d606.9895126108502!2d13.4159470038166!3d52.516098241428715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47a84e2309f23001%3A0xfb148ef06b4adf58!2sSchicklerstra%C3%9Fe+5%2C+10179+Berlin%2C+Germany!5e0!3m2!1sen!2sua!4v1464094492782" width="550" height="210" frameborder="0" style="border:0" allowfullscreen></iframe>
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


		<?php include('templates/scripts.php'); ?>

		
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>