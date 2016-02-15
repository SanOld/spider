<!DOCTYPE html>
<html lang="en">
	<head>
	
		<title>Benutzerrollen | SPIder</title>
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
						<li><a href="#">Home</a></li>
						<li class="active">Benutzerrollen</li>
					</ul>
				</div>
		
				<!-- Page Content Start -->
				<!-- ================== -->
		
				<div class="wraper container-fluid">
					<div class="row">
						<div class="container center-block">
							<div class="panel panel-default">
								<div class="panel-heading heading-noborder clearfix">
									<h1 class="panel-title col-lg-6">Benutzerrollen</h1>
									<div class="pull-right heading-box-print">
										<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Benutzer-Typ hinzufügen</button>
									</div>
								</div>
								<div class="panel-body roles-edit">
									
									<table id="datatable" class="table table-hover table-bordered table-edit">
										<thead>
											<tr>
												<th>Benutzer-Typ</th>
												<th>Organisationstyp</th>
												<th></th>
											</tr>
										</thead>
		
										<tbody>
											<tr>
												<td>Admin</td>
												<td>Organisation</td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Bezirk</td>
												<td>Bezirk</td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Träger</td>
												<td>Organisation</td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Träger Agentur</td>
												<td>Träger Agentur</td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Senat</td>
												<td>Organisation</td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Schule</td>
												<td>Schule</td>
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
					</div> <!-- End Row -->
				</div>
			</div>

		<!-- Page Content Ends -->
		<!-- ================== -->
		<?php include('templates/footer.php'); ?>

<!--Edit roles -->
		<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="panel panel-color panel-primary">
				<div class="panel-heading clearfix"> 
					<h3 class="m-0 pull-left">Benutzerrollen editieren</h3>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
				</div> 
				<div class="panel-body table-modal">
					<div class="form-group custom-field row clearfix">
						<div class="form-group col-lg-6">
							<label>Benutzer-Typ</label>
							<div class="wrap-line error">
								<input class="form-control" type="text" placeholder="Benutzerdefinierter Typ">
								<label class="error" for="username">Benutzer-Typ</label>
								<span class="glyphicon glyphicon-remove form-control-feedback"></span>
							</div>
						</div>
						<div class="form-group col-lg-6">
							<label>Organisationstyp</label>
							<div class="wrap-line error">
								<select class="type-user form-control">
									<option>Keine Verbindung</option>
									<option>Bezirk</option>
									<option>Schule</option>
									<option>Träger</option>
								</select>
							</div>
						</div>
					</div>
					<table id="datatable-edit-roles" class="table table-hover table-bordered text-center">
						<thead>
							<tr>
								<th>Seite</th>
								<th class="text-center">Ansicht</th>
								<th class="text-center">Bearbeitung</th>
							</tr>
						</thead>
						<tbody class="body-center">
							<tr>
								<td>Financing Project</td>
								<td>
									<label class="cr-styled">
											<input type="checkbox" checked="">
											<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Perfomer Agency</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Project list</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Project editor</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Request</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Schools list</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Schools editor</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Schools District</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>User list</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>User editor</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
											<input type="checkbox" checked="">
											<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Schools District</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>User list</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>User editor</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>

						</tbody>
					</table>
					<div class="row p-t-10">
						<div class="form-group group-btn p-t-10">
							<div class="col-lg-2">
								<button class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa  fa-trash-o"></i></button>
							</div>
							<div class="col-lg-6 text-right pull-right">
								<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
								<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
							</div>
						</div>
					</div>
				</div>
			</div>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
<!--Edit roles end -->

<!--Add roles -->

		<div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="panel panel-color panel-primary">
				<div class="panel-heading clearfix"> 
					<h3 class="m-0 pull-left">Benutzer-Typ hinzufügen</h3>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
				</div> 
				<div class="panel-body table-modal">
					<div class="form-group custom-field row clearfix">
						<div class="form-group col-lg-6">
							<label>Benutzer-Typ</label>
							<input class="form-control" type="text" placeholder="Benutzerdefinierter Typ">
						</div>
						<div class="form-group col-lg-6">
							<label>Verbindung</label>
							<select class="type-user form-control">
								<option>Keine Verbindung</option>
								<option>District</option>
								<option>School</option>
								<option>Performer</option>
							</select>
						</div>
					</div>
					<table id="datatable-edit-roles" class="table table-hover table-bordered text-center">
						<thead>
							<tr>
								<th>Seite</th>
								<th class="text-center">Überblick</th>
								<th class="text-center">Bearbeiten</th>
							</tr>
						</thead>
						<tbody class="body-center">
							<tr>
								<td>Financing Project</td>
								<td>
									<label class="cr-styled">
											<input type="checkbox" checked="">
											<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Perfomer Agency</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Project list</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Project editor</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Request</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Schools list</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Schools editor</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Schools District</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>User list</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>User editor</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
											<input type="checkbox" checked="">
											<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>Schools District</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>User list</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>
							<tr>
								<td>User editor</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
								<td>
									<label class="cr-styled">
										<input type="checkbox" checked="">
										<i class="fa"></i>
									</label>
								</td>
							</tr>

						</tbody>
					</table>
					<div class="row p-t-10">
						<div class="form-group group-btn p-t-10">
							<div class="col-lg-6 text-right pull-right">
								<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
								<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
							</div>
						</div>
					</div>
				</div>
			</div>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

<!--End Add user -->
		<div class="md-overlay"></div>
		
		<?php include('templates/scripts.php'); ?>

		<script type="text/javascript">

			jQuery(window).load(function() {

				jQuery(".select2").select2();

				jQuery('.btn-toggle').click(function(){
					$(this).find(".btn").toggleClass('active');
					$(this).find(".btn").toggleClass('btn-default');
					return false;
				})


				$('.roles-edit #datatable').DataTable({
					"paging":   false,
					"info":     false,
					"columnDefs": [
						{ className: "dt-body-left", "width": "5%", "orderable": false, "targets": 2 }
					]
				});

				$('.table-modal #datatable-edit-roles').DataTable({
						"info": false,
						// "scrollY": "420px",
						// "scrollCollapse": true,
						"paging": false,
						"columnDefs": [
						{ className: "dt-body-left", "targets": [ 0 ] }
					]
				});
			});
		

		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>