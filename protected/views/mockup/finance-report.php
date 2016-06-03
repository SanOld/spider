<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Belege | SPIder</title>
		<?php include('templates/head.php'); ?>
	</head>

	<body class="fin-report">
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
			
			<!-- Navbar Start -->
			<?php include('templates/menu.php'); ?>
				
			<div class="container">
				<ul class="breadcrumb p-0">
					<li><a href="/dashboard">Startseite</a></li>
					<li class="active">Belege</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default finance-report">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Belege</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
									<button class="btn w-lg custom-btn" data-modal="">Import aus DATEV</button>
									<button class="btn w-lg custom-btn" data-modal="">Beleg hinzufügen</button>
								</div>
							</div>
							<div class="panel-body finacing-edit">
								<div id="reports" class="tab-pane active">
									<div class="row datafilter m-b-30">
										<form action="#">
											<div class="col-lg-3">
												<div class="form-group">
													<label>Suche nach dem Empfänger</label>
													<input class="form-control" type="text" value="Eingegeben" />
												</div>
											</div>
											<div class="col-lg-1">
												<div class="form-group">
													<div class="form-group">
														<label>Kennziffer</label>
														<select class="form-control">
															<option>G053</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-2">
												<div class="form-group">
													<div class="form-group">
														<label>Jahr</label>
														<select class="form-control">
															<option>2016</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-2">
												<div class="form-group">
													<div class="form-group">
														<label>Kostenart</label>
														<select class="form-control">
															<option>Alles anzeigen</option>
															<option>Personalkosten</option>
															<option>Fortbildung</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-2">
												<div class="form-group">
													<div class="form-group">
														<label>Status</label>
														<select class="form-control">
															<option>Alles anzeigen</option>
															<option>Abgelehnt</option>
															<option>Sachlich richtig</option>
															<option>In Bearbeitung</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-2 reset-btn-width">
												<button class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<div class="form-group">
														<label>Zahlungsweise</label>
														<select class="form-control">
															<option>Alles anzeigen</option>
															<option>Barbezahlung</option>
															<option>Unbar</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-3 datapicker-filter">
												<label>Belegdatum</label>
												<div class="input-group">
				                                    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
				                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				                                </div>
											</div>
											<div class="col-lg-3 datapicker-filter">
												<label>Buchungsdatum</label>
												<div class="input-group">
				                                    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
				                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				                                </div>
											</div>
											<div class="col-lg-3 p-r-15 datapicker-filter">
												<label>Zahlungsdatum</label>
												<div class="input-group">
				                                    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
				                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				                                </div>
											</div>
											
										</form>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<table id="datatable" class="table table-hover table-bordered table-edit">
												<thead>
													<tr>
														<th>
															<label class="cr-styled">
																<input type="checkbox">
																<i class="fa"></i>
															</label>
														</th>
														<th>Kennziffer /<br/> Beleg-Nr.</th>
														<th>Kostenart</th>
														<th>Status</th>
														<th>Jahr</th>
														<th>Zahlungsweise</th>
														<th>Betrag</th>
														<th>Empfänger</th>
														<th>Zahl.<br/>-Datum</th>
														<th>Beschreibung</th>
														<th>Bearbeiten</th>
													</tr>
													
												</thead>
												
												<tbody>
													<tr class="approved-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Personalkosten</td>
														<td>Sachlich richtig</td>
														<td>2016</td>
														<td>Barbezahlung</td>
														<td title="Reason for payment">€ 2,445.33
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Markus Prill</td>
														<td>28.10.2015</td>
														<td title="Beschreibung">
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="fa fa-align-left"></i>
															</button>
														</td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="approved-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Personalkosten</td>
														<td>Sachlich richtig</td>
														<td>2016</td>
														<td>Unbar</td>
														<td title="Reason for payment">€ 9,749.86 
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Anita Reindl</td>
														<td>28.10.2015</td>
														<td></td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="decline-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Fortbildung</td>
														<td>Abgelehnt</td>
														<td>2016</td>
														<td>Unbar</td>
														<td title="Reason for payment">€ 862.89 
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Frank Kiepert</td>
														<td>28.10.2015</td>
														<td title="Beschreibung">
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="fa fa-align-left"></i>
															</button>
														</td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="approved-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Fortbildung</td>
														<td>Sachlich richtig</td>
														<td>2016</td>
														<td>Unbar</td>
														<td title="Reason for payment">€ 2,445.33 
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Undine Zeibig</td>
														<td>28.10.2015</td>
														<td></td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="approved-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Personalkosten</td>
														<td>Sachlich richtig</td>
														<td>2016</td>
														<td>Unbar</td>
														<td title="Reason for payment">€ 9,749.86 
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Brigit Bolling</td>
														<td>28.10.2015</td>
														<td></td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="approved-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Personalkosten</td>
														<td>Sachlich richtig</td>
														<td>2016</td>
														<td>Barbezahlung</td>
														<td title="Reason for payment">€ 862.89
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Werner Munk</td>
														<td>28.10.2015</td>
														<td title="Beschreibung">
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="fa fa-align-left"></i>
															</button>
														</td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="decline-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Personalkosten</td>
														<td>Abgelehnt</td>
														<td>2016</td>
														<td>Unbar</td>
														<td title="Reason for payment">€ 2,445.33 
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Anita Kästner</td>
														<td>28.10.2015</td>
														<td></td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="inprogress-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Fortbildung</td>
														<td>In Bearbeitung</td>
														<td>2016</td>
														<td>Barbezahlung</td>
														<td title="Reason for payment">€ 9,749.86
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Markus Prill</td>
														<td>28.10.2015</td>
														<td></td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="inprogress-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Fortbildung</td>
														<td>In Bearbeitung </td>
														<td>2016</td>
														<td>Unbar</td>
														<td title="Reason for payment">€ 862.89
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Anita Reindl</td>
														<td>28.10.2015</td>
														<td title="Beschreibung">
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="fa fa-align-left"></i>
															</button>
														</td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="approved-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Fortbildung</td>
														<td>Sachlich richtig</td>
														<td>2016</td>
														<td>Unbar</td>
														<td title="Reason for payment">€ 2,445.33
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Frank Kiepert</td>
														<td>28.10.2015</td>
														<td title="Beschreibung">
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="fa fa-align-left"></i>
															</button>
														</td>
														<td>
															<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																<i class="ion-edit"></i>
															</a>
														</td>
													</tr>
													<tr class="approved-row">
														<td>
															<label class="cr-styled">
																<input type="checkbox" checked="">
																<i class="fa"></i>
															</label>
														</td>
														<td><a href="order.php" class="id-request"><span>G052</span></a> 
														<a href="order.php">16-000091</a></td>
														<td>Personalkosten</td>
														<td>Sachlich richtig</td>
														<td>2016</td>
														<td>Unbar</td>
														<td title="Reason for payment">€ 9,749.86
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn id-request" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="ion-information-circled"></i>
															</button>
														</td>
														<td>Frank Kiepert</td>
														<td>28.10.2015</td>
														<td title="Beschreibung">
															<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
																<i class="fa fa-align-left"></i>
															</button>
														</td>
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
									<div class="btn-row m-t-15 clearfix">
										<button class="btn m-b-5">Akzeptieren</button>
										<button class="btn m-b-5">Ablehnen</button>
										<button class="btn m-b-5" data-target="#modal-2" data-toggle="modal">Kommentar hinzufügen</button>
									</div>
									<div class="row m-t-30">
										<div class="col-lg-12">
											<div class="notice">
												<span class="color-notice approved-row"></span>
												Sachlich richtig
											</div>
											<div class="notice">
												<span class="color-notice decline-row"></span>
												Abgelehnt
											</div>
											<div class="notice">
												<span class="color-notice inprogress-row"></span>
												In Bearbeitung 
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
		
		<!-- Edit -->
		<div id="modal-1" class="modal fade edit-summary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog project-modal custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Beleg bearbeiten</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						<div class="alert alert-warning">
                            <strong>Bitte bearbeiten</strong>
                        </div>
					</div>
					<div class="row">
						<form role="form" class="form-horizontal">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-lg-5 control-label">Kennziffer</label>
									<div class="col-lg-7 control-label">
										G027
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-5 control-label">Kostenart</label>
									<div class="col-lg-7">
										<select class="form-control">
											<option>Personalkosten</option>
											<option>Fortbildung</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-5 control-label">Zahlungsweise</label>
									<div class="col-lg-7">
										<select class="form-control">
											<option>Barbezahlung</option>
											<option>Unbar</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-5 control-label">Betrag</label>
									<div class="col-lg-4">
										<input type="text" value="€ 9,749.86" class="form-control">
									</div>
									<div class="col-lg-1 p-0  m-t-5">
										<span class="symbol">€</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-5 control-label">Empfänger</label>
									<div class="col-lg-7">
										<select class="form-control">
											<option>Markus Prill</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-lg-5 control-label">Belegdatum</label>
									<div class="col-lg-7">
	                                	<div class="input-group">
	                                	    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
	                                	    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                	</div>
	                                </div>
                                </div>
                                <div class="form-group">
									<label class="col-lg-5 control-label">Buchungsdatum</label>
                                	<div class="col-lg-7">
	                                	<div class="input-group">
	                                	    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
	                                	    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                	</div>
	                                </div>
                                </div>
                                <div class="form-group">
									<label class="col-lg-5 control-label">Zahlungsdatum</label>
                                	<div class="col-lg-7">
	                                	<div class="input-group">
	                                	    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
	                                	    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                	</div>
	                                </div>
                                </div>
							</div>
						</div>
						<div class="row m-t-30">
							<div class="form-group clearfix">
								<label class="col-lg-3 control-label">Grund der Zahlung</label>
                            	<div class="col-lg-9">
                                	<textarea class="form-control custom-height-textarea3"></textarea>
                                </div>
							</div>
							<div class="form-group clearfix">
								<label class="col-lg-3 control-label">Beschreibung</label>
                            	<div class="col-lg-9">
                                	<textarea class="form-control custom-height-textarea3"></textarea>
                                </div>
							</div>
							<div class="col-lg-9">
								<h4 class="m-t-0">Prüfnotiz</h4>
								<textarea class="form-control custom-height-textarea2" placeholder="Tragen Sie den Text hier ein"></textarea>
							</div>
							<div class="col-lg-3 m-t-30">
								<div class="group-btn pull-right">
									<button class="btn w-lg btn-lg btn-success disabled">AKZEPTIEREN</button>
									<button class="btn w-lg btn-lg btn-danger disabled m-t-10">ABLEHNEN</button>
									
								</div>
							</div>
						</div>
						<div class="form-group group-btn row m-t-30">
							<div class="col-lg-5 text-left">
								<a class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"><i class="fa fa-trash-o"></i></a>
							</div>
							<div class="col-lg-7 text-right">
								<button class="btn w-lg cancel-btn btn-lg">Abbrechen</button>
								<button class="btn w-lg custom-btn btn-lg">Speichern</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Add comment -->

		<div id="modal-2" class="modal fade edit-summary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog project-modal custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Kommentar hinzufügen</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="row">
						<form role="form">
							<div class="col-lg-12">
								<div class="form-group m-t-30">
									<h4 class="m-t-0">Prüfnotiz</h4>
									<textarea class="form-control" placeholder="Tragen Sie den Text hier ein"></textarea>
								</div>
							</div>
						</form>
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
				$('.finacing-edit #datatable').DataTable({
					"sDom": 'Rfrtlip',
					"columnDefs": [
						{ className:"dt-edit", "targets": [9, 10] },
						{ className:"align-right", "targets": [6] }
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
				
			

			});
		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>