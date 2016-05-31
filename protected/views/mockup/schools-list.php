<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Schule | SPIder</title>
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
					<li class="active">Schule</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Schule</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
									<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Schule hinzufügen</button>
								</div>
							</div>
							<div class="panel-body schoole-user">
								<div class="row">
									<div class="col-lg-12">
										<div class="row datafilter">
											<form action="#" class="class-form">
												<div class="col-lg-5">
													<div class="form-group">
														<label>Suche nach Namen, Nummer, Adresse oder Ansprechpartner(in)</label>
														<input type="search" class="form-control" placeholder="Eingegeben">
													</div>
												</div>
												<div class="col-lg-2">
													<div class="form-group">
														<label>Schultyp</label>
														<select class="type-user form-control">
															<option>Hauptschulen</option>
														</select>
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Bezirk</label>
														<select class="type-user form-control">
															<option>Alles anzeigen</option>
														</select>
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
													<th>Nummer</th>
													<th>Name</th>
													<th>Schultyp</th>
													<th>Bezirk</th>
													<th>Adresse</th>
													<th>Ansprechpartner(in)</th>
													<th>Telefon</th>
													<th>Bearbeiten</th>
												</tr>
											</thead>
			
											<tbody>
												<tr>
													<td>10G18</td>
													<td><a href="#">Pusteblume-Grundschule</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Neukolln</a></td>
													<td>Hanns-Braun-Str./Friesenhaus II 14053 Berlin</td>
													<td>Markus Prill</td>
													<td>(030) 2888 496</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>07G19</td>
													<td><a href="#">Paul-Simmel-Grundschule</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Pankow</a></td>
													<td>Karl-Marx-Allee 31 10178 Berlin</td>
													<td>Anita Reindl</td>
													<td>(030) 2888 496</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>11K06</td>
													<td><a href="#">Schule am Rathaus (ISS)</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Spandau</a></td>
													<td>Paulstr. 28 10557 Berlin</td>
													<td>Frank Kiepert</td>
													<td>(030) 2888 496</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>07K04</td>
													<td><a href="#">Theodor-Haubach-Schule (ISS)</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Neukolln</a></td>
													<td>Hanns-Braun-Str./Friesenhaus II 14053 Berlin</td>
													<td>Undine Zeibig</td>
													<td>(030) 2888 496</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>06S01</td>
													<td><a href="#">Pestalozzi-Schule</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Pankow</a></td>
													<td>Karl-Marx-Allee 31 10178 Berlin</td>
													<td>Brigitte Bollinger</td>
													<td>(030) 2888 496</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>10G18</td>
													<td><a href="#">Pusteblume-Grundschule</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Neukolln</a></td>
													<td>Hanns-Braun-Str./Friesenhaus II 14053 Berlin</td>
													<td>Markus Prill</td>
													<td>(030) 2888 496</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>07G19</td>
													<td><a href="#">Paul-Simmel-Grundschule</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Pankow</a></td>
													<td>Karl-Marx-Allee 31 10178 Berlin</td>
													<td>Anita Reindl</td>
													<td>(030) 2888 496</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>11K06</td>
													<td><a href="#">Schule am Rathaus (ISS)</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Spandau</a></td>
													<td>Paulstr. 28 10557 Berlin</td>
													<td>Frank Kiepert</td>
													<td>(030) 2888 496</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>07K04</td>
													<td><a href="#">Theodor-Haubach-Schule (ISS)</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Neukolln</a></td>
													<td>Hanns-Braun-Str./Friesenhaus II 14053 Berlin</td>
													<td>Undine Zeibig</td>
													<td>(030) 2888 496</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>06S01</td>
													<td><a href="#">Pestalozzi-Schule</a></td>
													<td>Hauptschulen</td>
													<td><a href="#">Bezirk Pankow</a></td>
													<td>Karl-Marx-Allee 31 10178 Berlin</td>
													<td>Brigitte Bollinger</td>
													<td>(030) 2888 496</td>
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

<!--Add schoole -->

		<!-- <div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Add schoole</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					

				</div>
			</div>
		</div> -->

<!--End Add schoole -->

<!--Edit schoole -->

		<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-width-full schoole-modal">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Schule bearbeiten - 10G08</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body p-t-0">
						<div class="row">
							<ul class="nav nav-tabs row"> 
								<li class="active"> 
									<a href="#general" data-toggle="tab" aria-expanded="false">
										<span class="hidden-xs">Allgemein</span> 
									</a> 
								</li>
								<li> 
									<a href="#user" data-toggle="tab" aria-expanded="false">
										<span class="hidden-xs">Benutzer</span> 
									</a> 
								</li>
							</ul>
						</div>
						<div class="tab-content clearfix m-0"> 
							<div class="tab-pane active" id="general"> 
								<form role="form" class="form-horizontal">
									<div class="row m-t-30">
										<div class="col-lg-9">
											<h3 class="subheading m-0">Allgemeine Information</h3>
											<hr>
											<div class="clearfix">
												<div class="col-lg-6">
													<div class="form-group">
														<label class="col-lg-4 control-label">Name</label>
														<div class="col-lg-8">
															<input class="form-control" type="text" value="Wilhelm-Busch-Grundschule (10G08)">
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-4 control-label">Bezirk</label>
														<div class="col-lg-8">
															<input class="form-control" type="text" value="Bezirk Neukolln">
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-4 control-label">Adresse</label>
														<div class="col-lg-8">
															<textarea class="form-control">Potsdamer Str. 182, 10783 Berlin</textarea>
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-4 control-label">PLZ</label>
														<div class="col-lg-8">
															<input type="text" value="10997" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-4 control-label">Stadt</label>
														<div class="col-lg-8">
															<input type="text" value="Berlin" class="form-control">
														</div>
													</div>
												</div>
												<div class="col-lg-5 col-lg-offset-1">
													<div class="form-group">
														<label class="col-lg-3 control-label">Nummer</label>
														<div class="col-lg-9">
															<input class="form-control" type="text" value="10G08">
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Schultyp</label>
														<div class="col-lg-9">
															<select class="form-control">
																<option>Hauptschulen</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Telefon</label>
														<div class="col-lg-9">
															<input type="tel" value="(030) 2888 496" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Fax</label>
														<div class="col-lg-9">
															<input type="tel" value="(030) 2888 496" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Email</label>
														<div class="col-lg-9">
															<input type="email" value="admin@warenform.de" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-3 control-label">Webseite</label>
														<div class="col-lg-9">
															<input type="text" value="warenform.de" class="form-control">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-3 schoole-contact">
											<h3 class="m-t-0 m-b-15">Ansprechpartner(in)</h3>
											<select class="form-control">
												<option>Mr Werner Munk</option>
												<option>Mr Werner Munk</option>
											</select>
											<dl>
												<dt>Funktion</dt>
												<dd>Some function</dd>
												<dt>Titel</dt>
												<dd>Some title</dd>
												<dt>Telefon</dt>
												<dd>(030) 2888 496</dd>
												<dt>Email</dt>
												<dd>admin@warenform.de </dd>
											</dl>
										</div>
									</div>
									<hr />
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
							<div class="tab-pane" id="user"> 
								<div class="holder-tab">
									<div class="panel-body edit-user agency-tab-user">
										<div>
											<div class="col-lg-12">
												<div class="row datafilter">
													<form action="#" class="class-form">
														<div class="col-lg-3">
															<div class="form-group">
																<label>Suche nach Name, Benutzername oder Email</label>
																<input type="search" class="form-control" placeholder="Stichwort eingegeben">
															</div>
														</div>
														<div class="col-lg-4">
															<div class="form-group">
																<label>Benutzerrollen</label>
																<select class="type-user form-control">
																	<option>Träger (F)</option>
																	<option>Träger</option>
																</select>
															</div>
														</div>
														<div class="col-lg-4">
															<div class="form-group">
																<label>Status</label>
																<select class="type-status form-control">
																	<option value="Active">Aktiv</option>
																	<option value="Disable">Deaktivieren</option>
																</select>
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
															<th>Name</th>
															<th class="select-filter">Benutzerrollen</th>
															<th>Benutzername</th>
															<th>Email</th>
															<th>Telefon</th>
															<th class="status-filter">Status</th>
															<th>Bearbeiten</th>
														</tr>
													</thead>
					
													<tbody>
														<tr>
															<td>Tiger Nixon</td>
															<td>Träger</td>
															<td><a href="#">jack.nik</a></td>
															<td><a href="#">jack.nik@mail.com</a></td>
															<td>(030) 2888 496</td>
															<td>Aktiv</td>
															<td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td>Garrett Winters</td>
															<td>Träger</td>
															<td><a href="#">ralph.fiennes</a></td>
															<td><a href="#">ralph.fiennes@mail.com</a></td>
															<td>(030) 2888 496</td>
															<td>Aktiv</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td>Ashton Cox</td>
															<td>Träger (F)</td>
															<td><a href="#">daniel.daylewis</a></td>
															<td><a href="#">daniel.daylewis@mai.com</a></td>
															<td>(030) 2888 496</td>
															<td>Aktiv</td>
															 <td>
															 	<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td>Cedric Kelly</td>
															<td>Träger</td>
															<td><a href="#">dustin.hoffman</a></td>
															<td><a href="#">dustin.hoffman@mail.com</a></td>
															<td>(030) 2888 496</td>
															<td>Aktiv</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr class="disable">
															<td>Airi Satou</td>
															<td>Träger (F)</td>
															<td><a href="#">ralph.fiennes</a></td>
															<td><a href="#">ralph.fiennes@mail.com</a></td>
															<td>(030) 2888 496</td>
															<td>Deaktivieren</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td>Brielle Williamson</td>
															<td>Träger</td>
															<td><a href="#">daniel.daylewis</a></td>
															<td><a href="#">daniel.daylewis@mai.com</a></td>
															<td>(030) 2888 496</td>
															<td>Aktiv</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td>Herrod Chandler</td>
															<td>Träger</td>
															<td><a href="#">jack.nik</a></td>
															<td><a href="#">jack.nik@mail.com</a></td>
															<td>(030) 2888 496</td>
															<td>Aktiv</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td>Rhona Davidson</td>
															<td>Träger (F)</td>
															<td><a href="#">jack.nik</a></td>
															<td><a href="#">jack.nik@mail.com</a></td>
															<td>(030) 2888 496</td>
															<td>Aktiv</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td>Colleen Hurst</td>
															<td>Träger (F)</td>
															<td><a href="#">jack.nik</a></td>
															<td><a href="#">jack.nik@mail.com</a></td>
															<td>(030) 2888 496</td>
															<td>Aktiv</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td>Sonya Frost</td>
															<td>Träger</td>
															<td>jack.nik</td>
															<td><a href="#">jack.nik@mail.com</a></td>
															<td>(030) 2888 496</td>
															<td>Aktiv</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
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
						</div>
					</div>
				</div>
			</div>
		</div>

<!--End Edit schoole -->

		<div class="md-overlay"></div>
		

		<?php include('templates/scripts.php'); ?>

		<script type="text/javascript">

			jQuery(window).load(function() {

				var table = $('.schoole-user #datatable').DataTable({
					"paging":   false,
			        "info":     false
				});

				$('.edit-user #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{ className:"dt-edit", "orderable": false, "targets": 6 },
						{ "width": "25%", "targets": 2 }
					]
				});

			});


		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>