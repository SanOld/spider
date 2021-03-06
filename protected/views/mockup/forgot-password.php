<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Forgot password | SPIder</title>
		<?php include('templates/head.php'); ?>
	</head>
	<body class="bg">

	<div id="page">
		<!-- Header -->
		<header class="top-head container-fluid">
			<div class="container">
				<div class="logo p-0 m-t-10 m-b-10 col-lg-6">
					<a href="index.php">
						<img src="images/logo.png" alt="logo">
					</a>
				</div>
				<div class="logo p-0 m-t-20 m-b-15 col-lg-6">
					<a target="_blank" href="http://service.berlin.de/senatsverwaltungen/" class="pull-right">
						 <img src="images/logo2.png" alt="logo">
					</a>
				</div>
			</div>
		</header>
		  <!-- Header Ends -->
		
			<div class="pace pace-inactive">
					<div data-progress="99" data-progress-text="100%" style="transform: translate3d(100%, 0px, 0px);" class="pace-progress">
					<div class="pace-progress-inner"></div>
				</div>
				<div class="pace-activity"></div>
			</div>
		
			<div class="wrapper-page animated fadeInDown">
				<div class="panel panel-color panel-primary">
					<form id="recover-password" method="post" action="success-alert.html" role="form" class="text-center cmxform form-horizontal">
						<h3 class="m-t-20">Ihr Passwort vergessen?</h3>
						<p class="m-b-10">Bitte geben Sie eine E-mail Adresse ein, um das Passwort zurückzusetzen</p>
						<div class="alert alert-danger">
							Bitte geben Sie die markierten Felder korrekt ein.
						</div>
						<div class="form-group text-left has-feedback m-t-15"> 
						   <div class="col-lg-12 wrap-line">
								<input type="email" class="form-control" placeholder="Geben Sie die Email Adresse ein" name="email" autofocus> 
							   <span class="glyphicon glyphicon-remove form-control-feedback"></span>
							   <span class="glyphicon glyphicon-ok form-control-feedback"></span>
						   </div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<button class="btn btn-block btn-lg btn-purple w-md custom-btn" type="submit">SENDEN</button>
							</div>
						</div>
					</form>
				</div>
			</div>
	</div>

		<div class="footer">
			<div class="container">
				<div class="col-lg-12">
				   	 <a target="_blank" href="http://www.stiftung-spi.de" class="pull-right m-l-15">
                        <img src="images/logo3.png" alt="logo">
                    </a>
			   </div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<!-- js placed at the end of the document so the pages load faster -->
		<script src="js/bootstrap.js"></script>
		<script src="js/pace.js"></script>
		<script src="js/wow.js"></script>

		<!--common script for all pages-->
		<script src="js/jquery.js"></script>

		<!-- validation form -->
		<script src="js/jquery.validate.min.js"></script>
		 <script src="js/form-validation-init.js"></script>

		 <script src="js/sweet-alert.min.js"></script>
	</body>
</html>