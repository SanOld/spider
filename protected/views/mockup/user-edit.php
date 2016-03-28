<!DOCTYPE html>
<html lang="en">
	<head>

		<title>User | SPIder</title>
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
					<li class="active">Benutzer</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						 <div class="hint-details alert alert-success m-0 clearfix">
							<div class="heading-alert">
								<strong>Lorem ipsum dolor sit amet</strong>
								<span class="show-link pull-right">
									Zeige Details <span class="caret"></span>
								</span>
							</div>
							<div class="content-alert">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Benutzer</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
									<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Neuen Benutzer hinzufügen</button>
								</div>
							</div>
							<div class="panel-body edit-user">
								<div class="row">
									<div class="col-lg-12">
										<div class="row datafilter">
											<form action="#" class="class-form">
												<div class="col-lg-3">
													<div class="form-group">
														<label>Suche nach Name, Benutzername oder Email</label>
														<input type="search" class="form-control" placeholder="Enter keyword">
													</div>
												</div>
												<div class="col-lg-2">
													<div class="form-group">
														<label>Benutzerrollen</label>
														<select class="type-user form-control">
															<option value="">Alles anzeigen</option>
															<option value="Accountant">District</option>
															<option value="Integration Specialist">Performer (F)</option>
															<option value="Javascript Developer">Senate</option>
															<option value="Junior Technical Author">School</option>
															<option value="Office Manager">PA</option>
															<option value="Regional Director">Admin</option>
														</select>
													</div>
												</div>
												<div class="col-lg-4">
													<div class="form-group">
														<label>Verbindung</label>
														<input type="text" placeholder="Enter relation name" class="search-relation form-control">
													</div>
												</div>
												<div class="col-lg-2">
													<div class="form-group">
														<label>Status</label>
														<select class="type-status form-control">
															<option value="Active">Aktiv</option>
															<option value="Disable">Deaktivieren</option>
														</select>
													</div>
												</div>
												<div class="col-lg-2 reset-btn-width">
													<button class="btn w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Reset filter</span></button>
												</div>
											</form>
										</div>
										
										<table id="datatable" class="table table-hover table-bordered table-edit" data-page-length="10000">
											<thead>
												<tr>
													<th>Name</th>
													<th class="select-filter">Benutzerrollen</th>
													<th>Verbindung</th>
													<th>Benutzername</th>
													<th>Email</th>
													<th>Telefon#</th>
													<th class="status-filter">Status</th>
													<th>Bearbeiten</th>
												</tr>
											</thead>
			
											<tbody>
												<tr>
													<td>Tiger Nixon</td>
													<td>Admin</td>
													<td></td>
													<td><a href="#">jack.nik</a></td>
													<td><a href="#">jack.nik@mail.com</a></td>
													<td>(030) 2888 496</td>
													<td>Aktiv</td>
													<td>
														<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Garrett Winters</td>
													<td>PA</td>
													<td></td>
													<td><a href="#">ralph.fiennes</a></td>
													<td><a href="#">ralph.fiennes@mail.com</a></td>
													<td>(030) 2888 496</td>
													<td>Aktiv</td>
													 <td>
														<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Ashton Cox</td>
													<td>Performer (F)</td>
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td><a href="#">daniel.daylewis</a></td>
													<td><a href="#">daniel.daylewis@mai.com</a></td>
													<td>(030) 2888 496</td>
													<td>Aktiv</td>
													 <td>
													 	<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Cedric Kelly</td>
													<td>School</td>
													<td>tandem BQG</td>
													<td><a href="#">dustin.hoffman</a></td>
													<td><a href="#">dustin.hoffman@mail.com</a></td>
													<td>(030) 2888 496</td>
													<td>Aktiv</td>
													 <td>
														<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="disable">
													<td>Airi Satou</td>
													<td>District</td>
													<td>Nachbarschafts- und Selbsthilfezentr in der UFA-Fabrik e.V.</td>
													<td><a href="#">ralph.fiennes</a></td>
													<td><a href="#">ralph.fiennes@mail.com</a></td>
													<td>(030) 2888 496</td>
													<td>Deaktivieren</td>
													 <td>
														<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Brielle Williamson</td>
													<td>Senate</td>
													<td></td>
													<td><a href="#">daniel.daylewis</a></td>
													<td><a href="#">daniel.daylewis@mai.com</a></td>
													<td>(030) 2888 496</td>
													<td>Aktiv</td>
													 <td>
														<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Herrod Chandler</td>
													<td>Admin</td>
													<td></td>
													<td><a href="#">jack.nik</a></td>
													<td><a href="#">jack.nik@mail.com</a></td>
													<td>(030) 2888 496</td>
													<td>Aktiv</td>
													 <td>
														<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Rhona Davidson</td>
													<td>PA</td>
													<td></td>
													<td><a href="#">jack.nik</a></td>
													<td><a href="#">jack.nik@mail.com</a></td>
													<td>(030) 2888 496</td>
													<td>Aktiv</td>
													 <td>
														<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Colleen Hurst</td>
													<td>District</td>
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td><a href="#">jack.nik</a></td>
													<td><a href="#">jack.nik@mail.com</a></td>
													<td>(030) 2888 496</td>
													<td>Aktiv</td>
													 <td>
														<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>Sonya Frost</td>
													<td>PA</td>
													<td>tandem BQG</td>
													<td>jack.nik</td>
													<td><a href="#">jack.nik@mail.com</a></td>
													<td>(030) 2888 496</td>
													<td>Aktiv</td>
													 <td>
														<a class="btn center-block" data-target="#modal-1" data-toggle="modal">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="notice">
											<span class="color-notice"></span>
											Deaktivierte Benutzer
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

<!--Add user -->

		<div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Bearbeiten eines Benutzer</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div> 
					<div class="alert alert-danger m-t-20">
	                    Lorem ipsum dolor sit.
	                    <a class="alert-link" href="#">Alert Link</a>
	                </div>
					<h3 class="subheading">Benutzerinformation</h3>
					<hr>
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-2 control-label">Status</label>
								<div class="col-lg-10">
									<div class="btn-group btn-toggle"> 
										<button class="btn btn-sm btn-default">AKTIV</button>
										<button class="btn btn-sm active">DEAKTIVIEREN</button>
									</div>
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Benutzerrollen</label>
								<div class="col-lg-4 custom-width">
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
								  	<div class="wrap-hint">
								  		<select class="form-control">
		                                    <option value="Accountant">District</option>
												<option value="Integration Specialist">Performer (F)</option>
												<option value="Javascript Developer">Senate</option>
												<option value="Junior Technical Author">School</option>
												<option value="Office Manager">PA</option>
												<option value="Regional Director">Admin</option>
		                                </select>
								  	</div>
								</div>
							</div>
							  <div class="form-group">
								<label class="col-lg-2 control-label">Verbindung</label>
								<div class="col-lg-10">
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
									<div class="wrap-hint">
										<select class="form-control">
		                                    <option>Nachbarschafts- und Selbsthilfezentrum in der UFA-Fabrik e.V.</option>
		                                    <option>Nachbarschafts- und Selbsthilfezentrum in der UFA-Fabrik e.V.</option>
		                                </select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Finanzrecht</label>
								<div class="col-lg-10">
									<div class="btn-group btn-toggle"> 
										<button class="btn btn-sm btn-default">JA</button>
										<button class="btn btn-sm active">NEIN</button>
									</div>
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
								</div>
							</div>
							<div class="form-group">
	                            <label class="col-lg-2 control-label">Anrede</label>
	                            <div class="col-lg-10">
	                                <div class="radio-inline">
	                                    <label for="radio1" class="cr-styled">
	                                        <input type="radio" value="option1" name="radios1" id="radio1" checked=""> 
	                                        <i class="fa"></i>
	                                        Herr 
	                                    </label>
	                                </div>
	                                <div class="radio-inline">
	                                    <label for="radio2" class="cr-styled">
	                                        <input type="radio" value="option2" name="radios1" id="radio2"> 
	                                        <i class="fa"></i> 
	                                        Frau
	                                    </label>
	                                </div>
	                            </div>
	                        </div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="col-lg-4 control-label" for="username">Titel</label>
										<div class="col-lg-8">
											<div class="wrap-hint">
												<input class="form-control" type="text" id="username" value="">
											</div>
										</div>
									</div>
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" for="fname">Vorname</label>
										<div class="col-lg-8 wrap-line error"> 
											<input class="form-control" type="text" id="fname" value="">
											<label id="username-error" class="error" for="username">Bitte geben Sie einen Vornamen</label>
											<span class="glyphicon glyphicon-remove form-control-feedback"></span>
										</div>
									</div>
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" for="fname">Nachname</label>
										<div class="col-lg-8 wrap-line error"> 
											<input class="form-control" type="text" id="fname" value="">
											<label id="username-error" class="error" for="username">Bitte geben Sie einen Nachnamen</label>
											<span class="glyphicon glyphicon-remove form-control-feedback"></span>
										</div>
									</div>
									
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="col-lg-3 control-label" for="username">Benutzername</label>
										<div class="col-lg-9"> 
											<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
												<i class="fa fa-question"></i>
											</button>
											<div class="wrap-hint">
												<input class="form-control" type="text" id="username" value="jack.nik">
											</div>
										</div>
									</div>
									 <div class="form-group">
										<label class="col-lg-3 control-label" for="email">Email</label>
										<div class="col-lg-9"> 
											<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
												<i class="fa fa-question"></i>
											</button>
											<div class="wrap-hint">
												<input class="form-control" type="text" id="email" value="jack.nik@mail.com">
											</div>
										</div>
										
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label" for="phone">Telefon</label>
										<div class="col-lg-9"> 
											<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
												<i class="fa fa-question"></i>
											</button>
											<div class="wrap-hint">
												<input class="form-control" type="text" id="phone" value="(030) 2888 496">
											</div>
										</div>
										
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="form-custom-box clearfix">
									<div class="col-lg-12">
										<h4>Passwort</h4>
									</div>
									<div class="col-lg-6">
										<label>Passwort</label>
										<input class="form-control" type="text" value="">
									</div>
									<div class="col-lg-6">
										<label>Passwort bestätigen</label>
										<input class="form-control" type="text" value="">
									</div>
								
								</div>
							</div>
							<div class="form-group group-btn">
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

<!--Edit user -->

		<div id="modal-1" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: block;">
            <div class="modal-dialog">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Bearbeiten eines Benutzer</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="alert alert-danger m-t-20">
	                    Lorem ipsum dolor sit.
	                    <a class="alert-link" href="#">Alert Link</a>
	                </div>
					<h3 class="subheading">Benutzerinformation</h3>
					<hr>
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-2 control-label">Status</label>
								<div class="col-lg-10">
									<div class="btn-group btn-toggle"> 
										<button class="btn btn-sm btn-default">AKTIV</button>
										<button class="btn btn-sm active">DEAKTIVIEREN</button>
									</div>
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2">Benutzerrollen</label>
	                            <div class="col-lg-10">
	                            	<span class="no-edit-text">Träger</span>
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
	                            </div>
							</div>
							  <div class="form-group">
								<label class="col-lg-2">Organisation</label>
	                            <div class="col-lg-10">
	                           	 	<span class="no-edit-text">Nachbarschafts- und Selbsthilfezentrum in der UFA-Fabrik e.V.</span>
	   								<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
	   									<i class="fa fa-question"></i>
	   								</button>
	                           </div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Finanzrecht</label>
								<div class="col-lg-10">
									<div class="btn-group btn-toggle"> 
										<button class="btn btn-sm btn-default">JA</button>
										<button class="btn btn-sm active">NEIN</button>
									</div>
									<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
										<i class="fa fa-question"></i>
									</button>
								</div>
							</div>
							<div class="form-group">
	                            <label class="col-lg-2 control-label">Anrede</label>
	                            <div class="col-lg-10">
	                                <div class="radio-inline">
	                                    <label for="radio3" class="cr-styled">
	                                        <input type="radio" value="option1" name="radios2" id="radio3" checked=""> 
	                                        <i class="fa"></i>
	                                        Herr 
	                                    </label>
	                                </div>
	                                <div class="radio-inline">
	                                    <label for="radio4" class="cr-styled">
	                                        <input type="radio" value="option2" name="radios2" id="radio4"> 
	                                        <i class="fa"></i> 
	                                        Frau
	                                    </label>
	                                </div>
	                            </div>
	                        </div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label class="col-lg-4 control-label" for="username">Titel</label>
										<div class="col-lg-8">
											<div class="wrap-hint">
												<input class="form-control" type="text" id="username" value="">
											</div>
										</div>
									</div>
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" for="fname">Vorname</label>
										<div class="col-lg-8 wrap-line error"> 
											<input class="form-control" type="text" id="fname" value="">
											<label id="username-error" class="error" for="username">Bitte geben Sie Vornamen ein</label>
											<span class="glyphicon glyphicon-remove form-control-feedback"></span>
										</div>
									</div>
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" for="fname">Nachname</label>
										<div class="col-lg-8 wrap-line error"> 
											<input class="form-control" type="text" id="fname" value="">
											<label id="username-error" class="error" for="username">Bitte geben Sie Nachnamen ein</label>
											<span class="glyphicon glyphicon-remove form-control-feedback"></span>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label class="col-lg-3 control-label" for="username">Benutzername</label>
										<div class="col-lg-9"> 
											<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
												<i class="fa fa-question"></i>
											</button>
											<div class="wrap-hint">
												<input class="form-control" type="text" id="username" value="jack.nik">
											</div>
										</div>
									</div>
									 <div class="form-group">
										<label class="col-lg-3 control-label" for="email">Email</label>
										<div class="col-lg-9"> 
											<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
												<i class="fa fa-question"></i>
											</button>
											<div class="wrap-hint">
												<input class="form-control" type="text" id="email" value="jack.nik@mail.com">
											</div>
										</div>
										
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label" for="phone">Telefon</label>
										<div class="col-lg-9"> 
											<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="has-hint btn btn-question" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
												<i class="fa fa-question"></i>
											</button>
											<div class="wrap-hint">
												<input class="form-control" type="text" id="phone" value="(030) 2888 496">
											</div>
										</div>
										
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="form-custom-box clearfix">
									<div class="col-lg-12">
										<h4>Passwort ändern</h4>
									</div>
									<div class="col-lg-4">
										<label>Altes Passwort</label>
										<input class="form-control" type="text" id="phone" value="">
									</div>
									<div class="col-lg-4">
										<label>Neues Passwort</label>
										<input class="form-control" type="text" id="phone" value="">
									</div>
									<div class="col-lg-4">
										<label>Neues Passwort wiederholen</label>
										<input class="form-control" type="text" id="phone" value="">
									</div>
								</div>
							</div>
							<div class="form-group group-btn">
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

<!--End Edit user -->


		<div class="md-overlay"></div>
		<div class="modal-backdrop fade in"></div>

		<?php include('templates/scripts.php'); ?>

		<script type="text/javascript">

			jQuery(window).load(function() {

				// Swicher button	
				jQuery('.btn-toggle').click(function(){
				  	$(this).find(".btn").toggleClass('active');
				    $(this).find(".btn").toggleClass('btn-default');
				    return false;
				})


				var table = $('.edit-user #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{ className:"dt-edit", "orderable": false, "targets": 7 },
						{ "width": "25%", "targets": 2 }
					]
				});

				$('button').on('click', function(){
					table.search( '' ).columns().search( '' ).draw();
				});

				$('.hint-details .show-link').click(function(){
					
					if ($('.hint-details .content-alert').is(":visible")) {
		                $(this).html($(this).html().replace(/Hide/, 'Show'));
		                $(this).find('span').removeClass('open');
		                
		            } else {
		                $(this).html($(this).html().replace(/Show/, 'Hide'));
		                $(this).find('span').addClass('open');
		            }

		            $(".hint-details .content-alert").slideToggle();
				})

				 $('.sweet-4').on('click', function(){
				 	swal({
			          title: "Are you sure?",
			          text: "You will not be able to recover this file!",
			          type: "warning",
			          showCancelButton: true,
			          confirmButtonClass: 'btn-danger',
			          confirmButtonText: 'Yes, delete it!',
			          closeOnConfirm: false
			        },
			        function(){
			          swal("Deleted!", "Your imaginary file has been deleted!", "success");
			        });
				 })

			});
		
		</script>

	</body>
</html>