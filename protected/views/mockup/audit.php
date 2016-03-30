<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include('templates/head.php'); ?>
		<title>Audit | SPIder</title>
	</head>

	<body class="audit-page">
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
			
			 <!-- Navbar Start -->
			<?php include('templates/menu.php'); ?>
				
			<div class="container">
				<ul class="breadcrumb p-0">
					<li><a href="#">Home</a></li>
					<li class="active">Audit</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Audit</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
								</div>
							</div>
							<div class="panel-body agency-edit">
								<div class="row datafilter">
									<form action="#">
										<div class="col-lg-3">
											<div class="form-group">
												<label>Suche nach Namen</label>
												<input class="form-control" type="text" placeholder="Eingegeben"/>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<div class="form-group">
													<label>Choose section</label>
													<select class="form-control">
														<option>District</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2">
											<label>Date</label>
											<div class="input-group">
			                                    <input type="text" class="form-control datepicker" placeholder="All dates">
			                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                </div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<div class="form-group">
													<label>Typ</label>
													<select class="form-control">
														<option>Alles anzeigen</option>
													</select>
												</div>
											</div>
										</div>
										
										<div class="col-lg-2 reset-btn-width">
											<button class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
										</div>
									</form>
								</div>
								<div class="row">
									<div id="tab-history" class="col-lg-12">
										<div class="changes-content">
											<div class="heading-changes">
												District
											</div>
											<div class="content-changes">
												<div class="thead delete">
													<div class="col-lg-4 p-l-0">
														<strong>Delete</strong>
														<span>Bearbeitet von Mustermann am 11.12.2015</span>
													</div>
													<div class="col-lg-4">
														<span class="after">Früher</span>
													</div>
													<div class="col-lg-4">
														<span class="before">Nachher</span>
													</div>
													<i class="ion-chevron-down arrow-box"></i>
												</div>
												<div class="row-holder">
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>id</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>026</dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Name</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>John Doe</dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Address</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>Gieseler Str.4, 10713 </dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>PLZ</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>10713</dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Phone</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>(030) 8540-56-67</dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Email</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>m.werner@mail.com</dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Contact</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt>Select:</dt>
																<dd>Werner Munk</dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
													</div>
												</div>
											</div>
											<div class="content-changes">
												<div class="thead">
													<div class="col-lg-4 p-l-0">
														<strong>Veränderungen</strong>
														<span>Bearbeitet von Mustermann am 11.12.2015</span>
													</div>
													<div class="col-lg-4">
														<span class="after">Früher</span>
													</div>
													<div class="col-lg-4">
														<span class="before">Nachher</span>
													</div>
													<i class="ion-chevron-down arrow-box"></i>
												</div>
												<div class="row-holder">
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Kontoinhaber</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>Herr Mustermann</dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>Frau Schmidt</dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Address</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>Gieseler Str.4</dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>Gieseler Str.4, 10713 </dd>
															</dl>
														</div>
													</div>
												</div>
											</div>
											<div class="content-changes">
												<div class="thead">
													<div class="col-lg-4 p-l-0">
														<strong>Veränderungen</strong>
														<span>Bearbeitet von Mustermann am 11.12.2015</span>
													</div>
													<div class="col-lg-4">
														<span class="after">Früher</span>
													</div>
													<div class="col-lg-4">
														<span class="before">Nachher</span>
													</div>
													<i class="ion-chevron-down arrow-box"></i>
												</div>
												<div class="row-holder">
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Kontoinhaber</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>Herr Mustermann</dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>Frau Schmidt</dd>
															</dl>
														</div>
													</div>
												</div>
											</div>
											<div class="content-changes">
												<div class="thead insert">
													<div class="col-lg-4 p-l-0">
														<strong>Insert</strong>
														<span>Bearbeitet von Mustermann am 11.12.2015</span>
													</div>
													<div class="col-lg-4">
														<span class="after">Früher</span>
													</div>
													<div class="col-lg-4">
														<span class="before">Nachher</span>
													</div>
													<i class="ion-chevron-down arrow-box"></i>
												</div>
												<div class="row-holder">
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>id</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>026</dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Name</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>John Doe</dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Address</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>Gieseler Str.4, 10713 </dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>PLZ</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>10713</dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Phone</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>(030) 8540-56-67</dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Email</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd>m.werner@mail.com</dd>
															</dl>
														</div>
													</div>
													<div class="custom-row">
														<div class="col-lg-4 p-l-0">
															<strong>Contact</strong>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt></dt>
																<dd></dd>
															</dl>
														</div>
														<div class="col-lg-4">
															<dl class="custom-dl">
																<dt>Select:</dt>
																<dd>Werner Munk</dd>
															</dl>
														</div>
													</div>
												</div>
												</div>
											</div>
										</div>
									</div>
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

		<script type="text/javascript">

			jQuery(window).load(function() {
				
				$('.changes-content .thead .arrow-box').click(function(){
					$(this).parent().toggleClass('open');
					$(this).parent().next().slideToggle();
				})

			});
		

		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>