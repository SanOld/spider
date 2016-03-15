<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Anträge | SPIder</title>
		<?php include('templates/head.php'); ?>
	</head>

	<body class="request-page">
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
			
			<!-- Navbar Start -->
			<?php include('templates/menu.php'); ?>
				
			<div class="container">
				<ul class="breadcrumb p-0">
					<li><a href="#">Home</a></li>
					<li class="active">Anträge</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Anträge</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()" title="Drucken">Drucken <i class="ion-printer"></i></a>
									<button class="btn w-lg custom-btn" data-modal="">Antrag hinzufügen</button>
								</div>
							</div>
							<div class="panel-body request-edit">
								<div class="row datafilter">
									<form action="#">
										<div class="col-lg-3 col1">
											<div class="form-group">
												<label>Träger</label>
												<select class="select2" data-placeholder="View All">
													<option>Alles anzeigen</option>
													<option>Users</option>
													<option>Request</option>
													<option>Login</option>
													<option>Registration</option>
												</select>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<div class="form-group">
													<label>Schultyp</label>
													<select class="form-control">
														<option>Alles anzeigen</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-1">
											<div class="form-group">
												<div class="form-group">
													<label>Jahr</label>
													<select class="form-control">
														<option>2015</option>
														<option>2016</option>
														<option>2017</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<div class="form-group">
													<label>Status</label>
													<select class="form-control">
														<option>Akzeptabel</option>
														<option>Öffnen</option>
														<option>In Bearbeitung</option>
														<option>Akzeptiert</option>
														<option>Ablehnen </option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<div class="form-group">
													<label>Fördertopf</label>
													<select class="form-control">
														<option>LM</option>
														<option>BP</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2 reset-btn-width">
											<button class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
										</div>
									</form>
								</div>
								<div class="overview">
									<h2>Statusüberblick</h2>
									<div class="box-overview">
										<a href="#">
											<span>In Bearbeitung</span>
											<strong>253</strong>
										</a>
									</div>
									<div class="box-overview">
										<a href="#">
											<span>Empfangen</span>
											<strong>2</strong>
										</a>
									</div>
									<div class="box-overview">
										<a href="#">
											<span>Zurücksendet</span>
											<strong>0</strong>
										</a>
									</div>
									<div class="box-overview">
										<a href="#">
											<span>Berechtigt</span>
											<strong>0</strong>
										</a>
									</div>
									<div class="box-overview">
										<a href="#">
											<span>Genehmigt</span>
											<strong>3</strong>
										</a>
									</div>
									<div class="box-overview">
										<a href="#">
											<span>Ge­samt­zahl</span>
											<strong>258</strong>
										</a>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table id="datatable" class="table table-hover table-bordered table-edit">
											<thead>
												<tr class="head-top">
													<th>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</th>
													<th>Kennziffer</th>
													<th>Träger</th>
													<th>Programm</th>
													<th>Jahr</th>
													<th>Status</th>
													<th></th>
													<th></th>
													<th></th>
													<th>Abgabe</th>
													<th>Letzte Änd.</th>
													<th>Ansicht /<br>Bearbeiten</th>
												</tr>
												<tr>
													<th>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</th>
													<th>Kennziffer</th>
													<th>Träger</th>
													<th>Programm</th>
													<th>Jahr</th>
													<th>Status</th>
													<th colspan="3">Prüfstatus</th>
													<th>Abgabe</th>
													<th>Letzte Änd.</th>
													<th>Ansicht /<br>Bearbeiten</th>
												</tr>
												
											</thead>
			
											<tbody>
												<tr class="acceptable-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox" checked="">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">K026</a></td>
													<td><a href="#">Horizonte gGmbH</a></td>
													<td>JSA</td>
													<td>2016</td>
													<td>Förderfähig</td>
													<td></td>
													<td></td>
													<td></td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">G053</a></td>
													<td><a href="#">CJD Berlin</a></td>
													<td>BP</td>
													<td>2016</td>
													<td>Unbearbeitet</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_finance" title="Finanzplan">
															<span class="cell-finplan"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
															<span class="cell-concept select"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
															<span class="cell-school select"></span>
														</a>
													</td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">K026</a></td>
													<td><a href="#">Tandem BQG</a></td>
													<td>ZP_2017</td>
													<td>2016</td>
													<td>Unbearbeitet</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_finance" title="Finanzplan">
															<span class="cell-finplan"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
															<span class="cell-concept"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
															<span class="cell-school select"></span>
														</a>
													</td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">G053</a></td>
													<td><a href="#">Tandem BQG</a></td>
													<td>BP</td>
													<td>2016</td>
													<td>Unbearbeitet</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_finance" title="Finanzplan">
															<span class="cell-finplan"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
															<span class="cell-concept"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
															<span class="cell-school select"></span>
														</a>
													</td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="acceptable-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">K026</a></td>
													<td><a href="#">JaKuS gGmbH</a></td>
													<td>JSA</td>
													<td>2016</td>
													<td>Förderfähig</td>
													<td></td>
													<td></td>
													<td></td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="inprogress-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">G053</a></td>
													<td><a href="#">EJF gAG</a></td>
													<td>ZP_2017</td>
													<td>2016</td>
													<td>Bitte Bearbeiten</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_finance" title="Finanzplan">
															<span class="cell-finplan select-decline"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
															<span class="cell-concept select-decline"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
															<span class="cell-school select-decline"></span>
														</a>
													</td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="acceptable-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">K026</a></td>
													<td><a href="#">Pad gGmbH</a></td>
													<td>ZP_2017</td>
													<td>2016</td>
													<td>Förderfähig</td>
													<td></td>
													<td></td>
													<td></td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="accept-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">K026</a></td>
													<td><a href="#">JaKuS gGmbH</a></td>
													<td>BP</td>
													<td>2016</td>
													<td>Genehmigt</td>
													<td></td>
													<td></td>
													<td></td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="decline-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">G053</a></td>
													<td><a href="#">CJD Berlin</a></td>
													<td>ZP_2017</td>
													<td>2016</td>
													<td>Nur Leserecht</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_finance" title="Finanzplan">
															<span class="cell-finplan select"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
															<span class="cell-concept"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
															<span class="cell-school select"></span>
														</a>
													</td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="accept-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">K026</a></td>
													<td><a href="#">Horizonte gGmbH</a></td>
													<td>JSA</td>
													<td>2016</td>
													<td>Genehmigt</td>
													<td></td>
													<td></td>
													<td></td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="decline-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</td>
													<td><a href="order.php">G053</a></td>
													<td><a href="#">Tandem BQG</a></td>
													<td>BP</td>
													<td>2016</td>
													<td>Nur Leserecht</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_finance" title="Finanzplan">
															<span class="cell-finplan select"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
															<span class="cell-concept select"></span>
														</a>
													</td>
													<td>
														<a class="request-button edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
															<span class="cell-school"></span>
														</a>
													</td>
													<td>13.11.2015</td>
													<td>15.10.2015</td>
													<td>
														<a class="btn edit-btn" href="order.php" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="btn-row m-t-15 clearfix">
											<button class="btn m-b-5" data-target="#modal-2" data-toggle="modal">Druck-Template wählen</button>
											<button class="btn m-b-5" data-target="#modal-3" data-toggle="modal">Laufzeit festlegen</button>
											<button class="btn m-b-5">Geprüft</button>
											<button class="btn m-b-5">Genehmigung</button>
											<!--<button class="btn m-b-5 pull-right">Folgeantrag hinzufügen</button>-->
										</div>
									</div>
								</div>
								<div class="clearfix">
									<div class="notice">
										<span class="color-notice open"></span>
										Unbearbeitet
									</div>
									<div class="notice">
										<span class="color-notice decline-row"></span>
										Nur Leserecht
									</div>
									<div class="notice">
										<span class="color-notice inprogress-row"></span>
										Bitte bearbeiten
									</div>
									<div class="notice">
										<span class="color-notice acceptable-row"></span>
										Förderfähig 
									</div>
									<div class="notice">
										<span class="color-notice accept-row"></span>
										Genehmigt 
									</div>
								</div>
								<div class="clearfix square-legend">
									<div class="notice">
										<div class="legends">
										  	<span class="cell-finplan select"></span>
										  	<span class="cell-concept select"></span>
										    <span class="cell-school select"></span>
										</div>
										In Bearbeitung 
									</div>
									<div class="notice">
										<div class="legends">
										  	<span class="cell-finplan"></span>
										  	<span class="cell-concept"></span>
										    <span class="cell-school"></span>
										</div>
										Förderfähig 
									</div>
									<div class="notice">
										<div class="legends">
										  	<span class="cell-finplan select-decline"></span>
										  	<span class="cell-concept select-decline"></span>
										    <span class="cell-school select-decline"></span>
										</div>
										Abgelehnt
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
		
		<!-- Edit -->

		<!-- <div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Edit request</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="row">
						
					</div>
				</div>
			</div>
		</div> -->
		
		<!-- Select agreement template -->

		<div id="modal-2" class="modal fade request-alert1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Druck-Template wählen</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div> 
					<div class="panel-body text-center">
						<h3 class="m-b-30">Vertragsvorlage für 4 Elemente auswählen</h3>
						<div class="col-lg-12 text-left">
							<div class="form-group">
								<label>Zielvereinbarung</label>
								<select class="form-control">
									<option>Zielvereinbarung 1.doc</option>
									<option>Zielvereinbarung 2.doc</option>
								</select>
							</div>
							<div class="form-group">
								<label>Antrag</label>
								<select class="form-control">
									<option>Antrag 1.doc</option>
									<option>Antrag 2.doc</option>
								</select>
							</div>
							<div class="form-group">
								<label>Fördervertrag</label>
								<select class="form-control">
									<option>Fördervertrag 1.doc</option>
									<option>Fördervertrag 2.doc</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row p-t-10 text-center">
						<div class="form-group group-btn m-t-20">
							<div class="col-lg-12">
								<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
								<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Set duration -->

		<div id="modal-3" class="modal fade request-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Laufzeit festlegen</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body text-center">
						<h3 class="m-b-30">Geben Sie die Zeitdauer für die 4 Elemente ein</h3>
						<div class="form-group">
							<div class="holder-datepicker text-right">
								<div class="col-lg-3 p-0">
									<label>Anfangsdatum</label>
								</div>
								<div class="col-lg-3 p-0">
									<div class="input-group">
	                                    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
	                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                </div>
								</div>
                                <div class="col-lg-3 p-0">
                                	<label>Fälligkeitstermin</label>
                                </div>
                                <div class="col-lg-3 p-0">
                                	<div class="input-group">
                                	    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
                                	    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                	</div>
                                </div>
							</div>
						</div>
					</div>
					<div class="row p-t-10 text-center">
						<div class="form-group group-btn m-t-20">
							<div class="col-lg-12">
								<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
								<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Print alert  -->
		<div id="modal-5" class="modal fade request-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Dokumente drucken - K026</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div> 
					<div class="panel-body">
						<h3 class="m-b-30 text-center">Dokumente zum Druck wählen</h3>
						<div class="doc-print">
							<div class="holder-doc-print">
								<span class="name-doc">Zielvereinbarung</span>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, eiusmod tempor incididunt ut labore</p>
							</div>
							<div class="btn-row">
								<button class="btn w-xs" data-target="#modal-1" data-toggle="modal">
									<span>Drucken</span>
									<i class="ion-printer"></i>
								</button>
							</div>
						</div>
						<div class="doc-print">
							<div class="holder-doc-print">
								<span class="name-doc">Antrag</span>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, eiusmod tempor incididunt ut labore</p>
							</div>
							<div class="btn-row">
								<button class="btn w-xs" data-target="#modal-1" data-toggle="modal">
									<span>Drucken</span>
									<i class="ion-printer"></i>
								</button>
							</div>
						</div>
						<div class="doc-print">
							<div class="holder-doc-print">
								<span class="name-doc">Vertrag</span>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, eiusmod tempor incididunt ut labore</p>
							</div>
							<div class="btn-row">
								<button class="btn w-xs" data-target="#modal-1" data-toggle="modal">
									<span>Drucken</span>
									<i class="ion-printer"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="row p-t-10 text-center">
						<div class="form-group group-btn m-t-20">
							<div class="col-lg-12">
								<button class="btn w-lg cancel-btn" data-dismiss="modal">ABBRECHEN</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="md-overlay"></div>
		
		<?php include('templates/scripts.php'); ?>

		<script type="text/javascript">

			jQuery(window).load(function() {
				jQuery(".select2").select2();
				$('.datepicker').datepicker({
					format: 'dd.mm.yyyy',
					language: 'de',
					orientation: "top"
				});
				$('.request-edit #datatable').DataTable({
					"sDom": 'Rfrtlip',
					"columnDefs": [
						{ className:"dt-edit", "targets": [11] }
					],
					"oLanguage": {
				      	"sLengthMenu": "_MENU_   Objekte pro Seite ",
				      	"sInfo": "_PAGE_ bis _PAGES_ Einträge aus _TOTAL_ anzeigen",
				      	"oPaginate": {
			                "sPrevious": "Zurück", // This is the link to the previous page
			                "sNext": "Weiter", // This is the link to the next page
			            }
				    },
				});
				 $('#datatable_length').insertAfter('#datatable_paginate');
				        $('#datatable_info, #datatable_length, #datatable_paginate').wrapAll('<div class="wrap-paging clearfix">');
				
				$('.request-alert1 #datatable').DataTable({
					"paging":   false,
					"info":     false,
					"columnDefs": [
						{className:"dt-checkbox", "targets": 0 },
						{className:"dt-edit-width", "targets": [2,3] }
					]
				});

			});
		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>