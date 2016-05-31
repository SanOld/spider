<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Fördertöpfe | SPIder</title>
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
					<li><a href="/">Home</a></li>
					<li class="active">Fördertöpfe</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Fördertöpfe</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken<i class="ion-printer"></i></a>
									<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Fördertopf hinzufügen</button>
								</div>
							</div>
							<div class="panel-body edit-user">
								<div class="row">
									<div class="col-lg-12">
										<table id="datatable" class="table table-hover table-bordered table-edit" data-page-length="10000">
											<thead>
												<tr>
													<th>Fördertopf</th>
													<th>Programm</th>
													<th>Details</th>
													<th>Bearbeiten</th>
												</tr>
											</thead>
			
											<tbody>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Landesmittel</td>
													<td>Zusatzprogramm B</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
											</tbody>
										</table>
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

<!--Add Finance source -->

		<div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
           
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Fördertöpf hinzufügen</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="row">
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Fördertopf</label>
									<div class="col-lg-9">
										<select class="form-control">
											<option>LM</option>
											<option>BP</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Programm</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" value="">
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

<!--End Add Finance source -->

<!--Edit Finance source -->

		<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Fördertöpf bearbeiten</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="row">
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Fördertopf</label>
									<div class="col-lg-9">
										<select class="form-control">
											<option>LM</option>
											<option>BP</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-3 control-label">Programm</label>
									<div class="col-lg-9">
										<input class="form-control" type="text" value="BP">
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

				var table = $('.edit-user #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{ className:"dt-edit", "orderable": false, "targets": 3 }
					]
				});

			});
		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>