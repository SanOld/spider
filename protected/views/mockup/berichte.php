<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Berichte | SPIder</title>
		<?php include('templates/head.php'); ?>
	</head>

	<body class="berichte-page">
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
			
			 <!-- Navbar Start -->
			
			<?php include('templates/menu.php'); ?>
				
			<div class="container">
				<ul class="breadcrumb p-0">
					<li><a href="#">Home</a></li>
					<li class="active">Berichte</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Berichte</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken<i class="ion-printer"></i></a>
								</div>
							</div>
							<div class="panel-body finacing-edit">
								<div class="row">
									<div class="col-lg-12">
										<div class="row datafilter">
											<form action="#" class="class-form">
												<div class="col-lg-2">
													<div class="form-group">
														<div class="form-group">
															<label>Knnz.</label>
															<select class="form-control">
																<option>G053</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-lg-2">
													<div class="form-group">
														<div class="form-group">
															<label>Status</label>
															<select class="form-control">
																<option>New</option>
																<option>Abgelehnt</option>
																<option>Accepted</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<div class="form-group">
															<label>Finanzierung</label>
															<select class="form-control">
																<option>LM_2016_sofort</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<div class="form-group">
															<label>Jahr</label>
															<select class="form-control">
																<option>2016</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-lg-2 reset-btn-width">
													<button class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
												</div>
											</form>
										</div>
										
										<table id="datatable" class="table table-hover table-bordered table-edit" data-page-length="10000">
											<thead>
												<tr>
													<th>Knnz.</th>
													<th>Status</th>
													<th>Finanzierung</th>
													<th>Jahr</th>
													<th>Personalkosten</th>
													<th>Fortbildungskosten</th>
													<th>Regiekosten</th>
													<th>Berufsgenos</th>
													<th>Ansicht /<br/> Bearbeiten</th>
												</tr>
											</thead>
			
											<tbody>
												<tr>
													<td><a href="order.php">G052</a>
													<td>New</td>
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="decline-row">
													<td><a href="order.php">G052</a>
													<td>Abgelehnt</td>
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="exported-row">
													<td><a href="order.php">G052</a>
													<td>Accepted</td>
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="order.php">G052</a>
													<td>New</td> 
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="decline-row">
													<td><a href="order.php">G052</a>
													<td>Abgelehnt</td> 
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="exported-row">
													<td><a href="order.php">G052</a>
													<td>Accepted</td> 
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="order.php">G052</a>
													<td>New</td> 
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="decline-row">
													<td><a href="order.php">G052</a>
													<td>Abgelehnt</td> 
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="order.php">G052</a>
													<td>New</td> 
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="order.php">G052</a>
													<td>New</td> 
													<td>LM_2016_sofort</td>
													<td>2016</td>
													<td>33300,00</td>
													<td>4500,00</td>
													<td>33500,00</td>
													<td>7500,00</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="row m-t-30">
											<div class="col-lg-12">
												<div class="notice">
													<span class="color-notice open"></span>
													New
												</div>
												<div class="notice">
													<span class="color-notice decline-row"></span>
													Abgelehnt
												</div>
												<div class="notice">
													<span class="color-notice exported-row"></span>
													Accepted
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


<!--Edit Finance source -->

		<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Finanzierung bearbeiten</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="row">
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Finanzierung</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" value="LM_2016_sofort" readonly>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Jahr</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" value="2016">
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Ansprechpartner/in</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" value="Brigitte Bollinger">
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">IBAN</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" value="DE64100708480511733803a">
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Geldinstitut</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" value="Berliner Bank">
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Fördertopf</label>
									<div class="col-lg-9">
										<select class="form-control">
											<option>Landesmittel</option>
											<option>Bonusprogramm</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Programm</label>
									<div class="col-lg-9">
										<select class="form-control">
											<option>Schulsozialarbeit</option>
											<option>Zusatzprogramm A</option>
											<option>Zusatzprogramm B</option>
											<option>Bonusprogramm</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Details</label>
									<div class="col-lg-9">
										<textarea class="form-control"></textarea>
									</div>
								</div>
							</div>
							<div class="form-group group-btn m-t-15">
								<div class="col-lg-2">
									<a class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa fa-trash-o"></i></a>
								</div>
								<div class="col-lg-10 text-right pull-right">
								 	<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
									<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
			</div>
		</div>

<!--End Edit Finance source -->

		<div class="md-overlay"></div>
		

		<?php include('templates/scripts.php'); ?>

		<script type="text/javascript">

			jQuery(window).load(function() {

				jQuery(".select2").select2();

				var table = $('.berichte-page #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{ className:"dt-edit", "orderable": false, "targets": 8 },
						{ "width": "8%", "targets": [0] }
					]
				});

			});
		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>