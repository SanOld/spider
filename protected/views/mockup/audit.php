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
					<li><a href="/dashboard">Home</a></li>
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
											<table id="datatable" class="table table-hover table-bordered table-history">
												<thead class="thead delete">
													<tr>
														<th>
															<strong>Veränderungen</strong>
															<span>Bearbeitet von Mustermann am 11.12.2015</span>
														</th>
														<th><span class="after">Früher</span></th>
														<th>
															<div class="holder-th">
																<span class="before">Nachher</span>
																<i class="ion-chevron-down arrow-box"></i>
															</div>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><div>
															<strong>id</strong>
														</div></td>
														<td>
															<div>026</div>
														</td>
														<td>
															<div></div>
														</td>
													</tr>
													<tr>
														<td><strong>id</strong></td>
														<td>026</td>
														<td></td>
													</tr>
													<tr>
														<td><strong>id</strong></td>
														<td>026</td>
														<td></td>
													</tr>
												</tbody>
												<thead class="thead">
													<tr>
														<th>
															<strong>Veränderungen</strong>
															<span>Bearbeitet von Mustermann am 11.12.2015</span>
														</th>
														<th><span class="after">Früher</span></th>
														<th>
															<div class="holder-th">
																<span class="before">Nachher</span>
																<i class="ion-chevron-down arrow-box"></i>
															</div>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><strong>Kontoinhaber</strong></td>
														<td>Herr Mustermann</td>
														<td>Frau Schmidt</td>
													</tr>
													<tr>
														<td><strong>Address</strong></td>
														<td>Gieseler Str.4, 10713</td>
														<td>Gieseler Str.4</td>
													</tr>
													
												</tbody>
												<thead class="thead">
													<tr>
														<th>
															<strong>Veränderungen</strong>
															<span>Bearbeitet von Mustermann am 11.12.2015</span>
														</th>
														<th><span class="after">Früher</span></th>
														<th>
															<div class="holder-th">
																<span class="before">Nachher</span>
																<i class="ion-chevron-down arrow-box"></i>
															</div>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><strong>Kontoinhaber</strong></td>
														<td>Herr Mustermann</td>
														<td>Frau Schmidt</td>
													</tr>
													<tr>
														<td><strong>Address</strong></td>
														<td>Gieseler Str.4, 10713</td>
														<td>Gieseler Str.4</td>
													</tr>
													
												</tbody>
												<thead class="thead insert">
													<tr>
														<th>
															<strong>Insert</strong>
															<span>Bearbeitet von Mustermann am 11.12.2015</span>
														</th>
														<th><span class="after">Früher</span></th>
														<th>
															<div class="holder-th">
																<span class="before">Nachher</span>
																<i class="ion-chevron-down arrow-box"></i>
															</div>
														</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><strong>id</strong></td>
														<td></td>
														<td>026</td>
													</tr>
													<tr>
														<td><strong>Name</strong></td>
														<td></td>
														<td>John Doe</td>
													</tr>
													
												</tbody>
											</table>
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

				var table = $('.audit-page #datatable').DataTable({
					"bSort" : false,
					"paging":   true,
			        "info":     false,
			        "bLengthChange": false,
			        "columnDefs": [
						{ "width": "40%", "orderable": false,  "targets": [0] }
					]
				});

			});
		

		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>