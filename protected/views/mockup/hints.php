<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Hintsmodul | SPIder</title>
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
						<li class="active">Hintsmodul</li>
					</ul>
				</div>
		
				<!-- Page Content Start -->
				<!-- ================== -->
		
				<div class="wraper container-fluid">
					<div class="row">
						<div class="container center-block">
							<div class="hint-details alert alert-info m-0 clearfix">
								<div class="heading-alert">
									<strong>Lorem ipsum dolor sit amet</strong>
									<span class="show-link pull-right">
										Zeigen <span class="caret"></span>
									</span>
								</div>
								<div class="content-alert">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading clearfix">
									<h1 class="panel-title col-lg-6">Hintsmodul</h1>
									<div class="pull-right heading-box-print">
										<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Neuen Hint hinzufügen</button>
									</div>
								</div>
								<div class="panel-body hint-edit">
									<div class="row datafilter">
										<form action="#">
											<div class="col-lg-5">
												<div class="form-group">
													<label>Seite</label>
													<select class="select2" data-placeholder="View All">
														<option>Alles anzeigen</option>
														<option>Benutzer</option>
														<option>Anfordern</option>
														<option>Anmelden</option>
														<option>Registrierung</option>
													</select>
												</div>
											</div>
											<div class="col-lg-5">
												<div class="form-group">
													<label>Position</label>
													<select class="select2" multiple data-placeholder="Position eingeben">
														<option>Name</option>
														<option>Vorname</option>
														<option>Nachname</option>
														<option>Benutzername</option>
													</select>
												</div>
											</div>
											<div class="col-lg-2">
												<button class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
											</div>
										</form>
									</div>
												
									<table id="datatable" class="table table-hover table-bordered table-edit">
										<thead>
											<tr>
												<th>Seite</th>
												<th>Position</th>
												<th>Hilfetext</th>
												<th>Bearbeiten</th>
											</tr>
										</thead>
		
										<tbody>
											<tr>
												<td>Benutzer</td>
												<td>Benutzername</td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Benutzer</td>
												<td></td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Benutzer</td>
												<td>Relation</td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Benutzer</td>
												<td>Email</td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Anfordern</td>
												<td></td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Anfordern</td>
												<td></td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Anfordern</td>
												<td>Vorname</td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Anmelden</td>
												<td></td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Anmelden</td>
												<td>Forgot password</td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Registrierung</td>
												<td></td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Anmelden</td>
												<td>Forgot password</td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
												<td>
													<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
														<i class="ion-edit"></i>
													</a>
												</td>
											</tr>
											<tr>
												<td>Registrierung</td>
												<td></td>
												<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed consectetur </td>
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

<!--Edit hint -->

		<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Hint bearbeiten</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div> 
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-2 control-label">Seite</label>
								<div class="col-lg-10">
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
									<div class="wrap-hint">
										<select class="form-control">
											<option>Benutzer</option>
											<option>Anfordern</option>
											<option>Anmelden</option>
											<option>Registrierung</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Position</label>
								<div class="col-lg-10">
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
									<div class="wrap-hint">
										<select class="form-control">
											<option>Name</option>
											<option>Vorname</option>
											<option>Nachname</option>
											<option>Benutzername</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Hilfetext</label>
								<div class="col-lg-10">
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
									<div class="wrap-hint">
										<textarea class="form-control" rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
										</textarea>
									</div>
								</div>
							</div>

							<div class="form-group group-btn p-t-10">
								<div class="col-lg-2">
									<a class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa fa-trash-o"></i></a>
								</div>
								<div class="col-lg-6 text-right pull-right">
								 	<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
									<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

<!--End Add user -->

<!--Add hint -->

		<div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Hint hinzufügen</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div> 
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-2 control-label">Seite</label>
								<div class="col-lg-10">
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
									<div class="wrap-hint">
										<select class="form-control">
											<option>Benutzer</option>
											<option>Anfordern</option>
											<option>Anmelden</option>
											<option>Registrierung</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Position</label>
								<div class="col-lg-10">
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
									<div class="wrap-hint">
										<select class="form-control">
											<option>Name</option>
											<option>Vorname</option>
											<option>Nachname</option>
											<option>Benutzername</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Hilfetext</label>
								<div class="col-lg-10">
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
									<div class="wrap-hint">
										<textarea class="form-control" rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
										</textarea>
									</div>
								</div>
							</div>

							<div class="form-group group-btn p-t-10">
								<div class="col-lg-2">
									<a class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa fa-trash-o"></i></a>
								</div>
								<div class="col-lg-6 text-right pull-right">
								 	<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
									<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

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


				$('#datatable').DataTable({
					"sDom": 'Rfrtlip',
					"oLanguage": {
				      	"sLengthMenu": "_MENU_ Objekte pro Seite",
				      	"sInfo": "_PAGE_ bis _PAGES_ Einträge aus _TOTAL_ anzeigen",
				      	"oPaginate": {
			                "sPrevious": "Zurück", // This is the link to the previous page
			                "sNext": "Weiter", // This is the link to the next page
			            }
				    },
				    "fnDrawCallback": function () {
				        $('#datatable_length').insertAfter('#datatable_paginate');
				    },
					"columnDefs": [
						{ className:"dt-edit", "orderable": false, "targets": 3 }
					]
				});

				$('.hint-details .show-link').click(function(){
					
					if ($('.hint-details .content-alert').is(":visible")) {
		                $(this).html($(this).html().replace(/Ausblenden/, 'Zeigen'));
		            } else {
		                $(this).html($(this).html().replace(/Zeigen/, 'Ausblenden'));
		            }

		            $(".hint-details .content-alert").slideToggle();
				})

			});
		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>