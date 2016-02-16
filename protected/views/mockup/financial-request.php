<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Mittelabrufe | SPIder</title>
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
					<li><a href="#">Finanzen</a></li>
					<li class="active">Mittelabrufe</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Mittelabrufe</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
									<button class="btn w-lg custom-btn" data-modal="">Import aus DATEV</button>
									<button class="btn w-lg custom-btn" data-modal="">Mittelabruf hinzufügen</button>
								</div>
							</div>
							<div class="panel-body finacing-edit">
								<div class="row datafilter">
									<form action="#">
										<div class="col-lg-2">
											<div class="form-group">
												<label>Suche nach Projekt</label>
												<input class="form-control" type="text" value="G052" />
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<div class="form-group">
													<label>Typ</label>
													<select class="form-control">
														<option>Alles anzeigen</option>
														<option>Regulär</option>
														<option>Extra</option>
														<option>Rückgezahlt</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<div class="form-group">
													<label>Jahr</label>
													<select class="form-control">
														<option>Aktuell</option>
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
														<option>Alles anzeigen</option>
														<option>Bitte bearbeiten </option>
														<option>Abgelehnt</option>
														<option>Genehmigt</option>
														<option>Ready for export</option>
														<option>Import from DATEVs</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<div class="form-group">
													<label>Finanzierung</label>
													<select class="form-control">
														<option>Alles anzeigen</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2 reset-btn-width">
											<button class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
										</div>
										<div class="col-lg-4">
											<label>Belegdatum</label>
											<div class="input-group">
			                                    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
			                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                </div>
										</div>
										<div class="col-lg-4">
											<label>Buchungsdatum</label>
											<div class="input-group">
			                                    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
			                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                </div>
										</div>
										<div class="col-lg-4 p-r-15">
											<label>Zahlungsdatum</label>
											<div class="input-group">
			                                    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
			                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                </div>
										</div>
										
									</form>
								</div>
								<div class="overview-finance m-t-20">
									<h4>Zusammenfassung der Finanzen für G052</h4>
									<div class="box-finance">
										<span class="sum total">
	                                    	<strong>Fördersumme</strong>
											<span>€ 87,443.54</span>
	                                    </span>
									</div>
									<div class="box-finance">
										<span class="sum requested">
	                                    	<strong>Freimeldung</strong>
											<span>€ 0,00</span>
	                                    </span>
									</div>
									<div class="box-finance">
										<span class="sum refund">
	                                    	<strong>Rückgezahlt</strong>
											<span>€ 100.00</span>
	                                    </span>
									</div>
									<div class="box-finance">
										<span class="sum income">
	                                    	<strong>Ausgezahlt</strong>
											<span>€ 58,295.69</span>
	                                    </span>
									</div>
									<div class="box-finance">
										<span class="sum spent">
	                                    	<strong>Belege</strong>
											<span>€ 1,000.00</span>
	                                    </span>
									</div>
									<div class="box-finance">
										<span class="sum expenditure">
	                                    	<strong>Verblieben</strong>
											<span>€ 29,147.85</span>
	                                    </span>
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
													<th></th>
													<th></th>
													<th>Jahr</th>
													<th>Status</th>
													<th>Finanzierung</th>
													<th>Betrag / IBAN / Typ</th>
													<th>Bel.<br/>-Datum</th>
													<th>Buch.<br/>-Datum</th>
													<th>Zahl.<br/>-Datum</th>
													<th>Druken /<br/> Bearbeiten</th>
												</tr>
												<tr>
													<th>
														<label class="cr-styled">
															<input type="checkbox">
															<i class="fa"></i>
														</label>
													</th>
													<th colspan="2">Kennz. / Beleg-Nr.</th>
													<th>Jahr</th>
													<th>Status</th>
													<th>Finanzierung</th>
													<th>Betrag / IBAN / Typ</th>
													<th>Bel.<br/>-Datum</th>
													<th>Buch.<br/>-Datum</th>
													<th>Zahl.<br/>-Datum</th>
													<th>Druken /<br/> Bearbeiten</th>
												</tr>
												
											</thead>
			
											<tbody>
												<tr class="inprogress-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox" checked="">
															<i class="fa"></i>
														</label>
													</td>
													<td>
														<a class="id-request" href="order.php"><span>G052</span> -</a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> Jan-Feb</td>
													<td>Bitte bearbeiten</td>
													<td>2016_LM_Sofort</td>
													<td>
														<div class="holder-id-request">
															<span>€ 9,749.86</span><span>DE65 1203 0000 1005 3670 06</span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td></td>
													<td></td>
													<td>
														<a class="btn document print-disable" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
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
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> Jan-Feb</td>
													<td>Bitte bearbeiten </td>
													<td>2016_LM_Sofort</td>
													<td>
														<div class="holder-id-request">
															<span>€ 2,749.86<span>DE65 1203 0000 1005 3670 06</span></span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td></td>
													<td></td>
													<td>
														<a class="btn document print-disable" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
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
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a> 
														<a data-target="#modal-1" data-toggle="modal">16-000091</a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> Jan-Feb</td>
													<td>Abgelehnt</td>
													<td>2016_LM</td>
													<td>
														<div class="holder-id-request">
															<span>€ 862.86<span>DE65 1203 0000 1005 3670 06</span></span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td></td>
													<td></td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
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
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a>
														<a data-target="#modal-1" data-toggle="modal">16-000092</a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> März-Apr</td>
													<td>Sachlich Richtig</td>
													<td>2016_LM</td>
													<td>
														<div class="holder-id-request">
															<span>€ 862.86<span>DE65 1203 0000 1005 3670 06</span></span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td></td>
													<td></td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
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
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a>
														<a data-target="#modal-1" data-toggle="modal">16-000091</a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> Jan-Feb</td>
													<td>Abgelehnt</td>
													<td>2016_LM</td>
													<td>
														<div class="holder-id-request">
															<span>€ 862.86<span>DE65 1203 0000 1005 3670 06</span></span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td></td>
													<td></td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>
														<label class="cr-styled">
															<input type="checkbox" checked="">
															<i class="fa"></i>
														</label>
													</td>
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> März-Apr</td>
													<td>aus DATEV importiert</td>
													<td>2016_LM</td>
													<td>
														<div class="holder-id-request">
															<span>€ 2,749.86<span>DE65 1203 0000 1005 3670 06</span></span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td>28.10.2015</td>
													<td>28.10.2015</td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>
														<label class="cr-styled">
															<input type="checkbox" checked="">
															<i class="fa"></i>
														</label>
													</td>
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a>
														<a data-target="#modal-1" data-toggle="modal">16-000092</a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> März-Apr</td>
													<td>aus DATEV importiert</td>
													<td>2016_LM</td>
													<td>
														<div class="holder-id-request">
															<span>€ 2,749.86<span>DE65 1203 0000 1005 3670 06</span></span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td>28.10.2015</td>
													<td>28.10.2015</td>
													<td>
														<a class="btn document print-disable" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="exported-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox" checked="">
															<i class="fa"></i>
														</label>
													</td>
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a>
														<a data-target="#modal-1" data-toggle="modal">16-000092</a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> März-Apr</td>
													<td>nach DATEV exportiert</td>
													<td>2016_LM</td>
													<td>
														<div class="holder-id-request">
															<span>€ 9,749.86</span><span>DE65 1203 0000 1005 3670 06</span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td>28.10.2015</td>
													<td></td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
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
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a>
														<a data-target="#modal-1" data-toggle="modal">16-000089</a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> Jan-Feb</td>
													<td>Bitte bearbeiten</td>
													<td>2016_LM_Sofort</td>
													<td>
														<div class="holder-id-request">
															<span>€ 9,749.86</span><span>DE65 1203 0000 1005 3670 06</span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td></td>
													<td></td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="ready-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox" checked="">
															<i class="fa"></i>
														</label>
													</td>
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a>
														<a data-target="#modal-1" data-toggle="modal">16-000092</a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> März-Apr</td>
													<td>Bereit</td>
													<td>2016_LM</td>
													<td>
														<div class="holder-id-request">
															<span>€ 2,749.86<span>DE65 1203 0000 1005 3670 06</span></span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td></td>
													<td></td>
													<td>
														<a class="btn document print-disable" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="ready-row">
													<td>
														<label class="cr-styled">
															<input type="checkbox" checked="">
															<i class="fa"></i>
														</label>
													</td>
													<td>
														<a class="id-request" href="order.php"><span>G052</span></a>
														<a data-target="#modal-1" data-toggle="modal">16-000092</a>
													</td>
													<td title="Beschreibung">
														<button data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-placement="top" data-toggle="popover" title="" data-container="body" class="btn edit-btn" type="button" data-original-title="" aria-describedby="popover332715" data-trigger="focus">
															<i class="fa fa-align-left"></i>
														</button>
													</td>
													<td>2016<br/> März-Apr</td>
													<td>Bereit</td>
													<td>2016_LM</td>
													<td>
														<div class="holder-id-request">
															<span>€ 9,749.86</span><span>DE65 1203 0000 1005 3670 06</span>
														</div>
													</td>
													<td>28.10.2015</td>
													<td></td>
													<td></td>
													<td>
														<a class="btn document" href="#" title="Drucken"><i class="ion-printer"></i></a>
														<a class="btn edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="btn-row m-t-15 clearfix">
											<button class="btn m-b-5" data-target="#modal-2" data-toggle="modal">Export zu DATEV</button>
											<button class="btn m-b-5" data-target="#modal-3" data-toggle="modal">Als importiert markieren</button>
											<button class="btn m-b-5" data-target="#modal-4" data-toggle="modal">Sachlich richtig (Druckfreigabe)</button>
											<button class="btn m-b-5" data-target="#modal-5" data-toggle="modal">Mittelabruf liegt korrekt vor</button>
										</div>
									</div>
								</div>
								<div class="notice">
									<span class="color-notice inprogress-row"></span>
									In Bearbeitung
								</div>
								<div class="notice">
									<span class="color-notice decline-row"></span>
									Abgelehnt
								</div>
								<div class="notice">
									<span class="color-notice approved-row"></span>
									Sachlich Richtig
								</div>
								<div class="notice">
									<span class="color-notice ready-row"></span>
									Bereit
								</div>
								<div class="notice">
									<span class="color-notice exported-row"></span>
									nach DATEV exportiert
								</div>
								<div class="notice">
									<span class="color-notice imported-row"></span>
									aus DATEV importiert
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
            <div class="modal-dialog modal-width-full">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Mittelabruf bearbeiten G027 / 16-000092</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						<div class="alert alert-danger">
                            <strong>Abgelehnt</strong>
                        </div>
					</div>
					<div class="row">
						<form role="form" class="form-horizontal">
							<div class="col-lg-4 row-holder-dl">
								<div class="form-group">
									<label class="col-lg-4 control-label">Projekte</label>
									<div class="col-lg-8">
										<select class="form-control">
											<option>G027</option>
										</select>
									</div>
								</div>
								<dl class="custom-dl">
									<dt>Haushaltsjahr</dt>
									<dd>2016</dd>
									<dt>Träger Agentur</dt>
									<dd>Tandem BQG</dd>
									<dt>Adresse</dt>
									<dd>Potsdamer Str. 182 10783, Berlin</dd>
								</dl>
								<hr />
								<dl class="custom-dl">
									<dt>Ansprechpartner(in)</dt>
									<dd>Mr Werner Munk</dd>
									<dt>Funktion</dt>
									<dd>Some function</dd>
									<dt>Titel</dt>
									<dd>Some title</dd>
									<dt>Telefon</dt>
									<dd>(030) 2888 496</dd>
									<dt>Email</dt>
									<dd>admin@warenform.de  </dd>
								</dl>
							</div>
							<div class="col-lg-4 border-side">
								<div class="form-group">
									<label class="col-lg-4 control-label">Typ</label>
									<div class="col-lg-8">
										<select class="form-control">
											<option>Regulär</option>
											<option>Extra</option>
											<option>Rückgezahlt</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4 control-label">Dauer</label>
									<div class="col-lg-8">
										<select class="form-control">
											<option>Exceptional request</option>
											<option>Januar/ Februar</option>
											<option>März/ April</option>
											<option>Mai / Juni</option>
											<option>Juli / August</option>
											<option>September/ Oktober</option>
											<option>November / Dezember</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4 control-label">IBAN</label>
									<div class="col-lg-8">
										<select class="form-control">
											<option>DE21 1204 0000 0622 2806 01</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4 control-label"></label>
									<div class="col-lg-8 control-label">
										Mr Werner Munk
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4 control-label"></label>
									<div class="col-lg-8 control-label">
										UBSWUS33XXX
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4 control-label"></label>
									<div class="col-lg-8 control-label">
										Tandem BQG
									</div>
								</div>
								<hr />
								<div class="form-group">
									<label class="col-lg-4 control-label">Betrag</label>
									<div class="col-lg-7">
										<input class="form-control" type="text" value="33000">
									</div>
									<div class="col-lg-1 p-0  m-t-5">
										<span class="symbol">€</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4 control-label">Beschreibung</label>
									<div class="col-lg-8">
										<textarea class="form-control">Lorem ipsum dolor sit amet consectetur</textarea>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
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
                                <hr />
                                <div class="form-group">
									<div class="col-lg-12">
										<label class="cr-styled">
											<input type="checkbox" checked="checked">
											<i class="fa"></i>
											Drucken erlauben
										</label>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<label class="cr-styled">
											<input type="checkbox">
											<i class="fa"></i>
											Brief ist erhalten und überprüft
										</label>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<label class="cr-styled">
											<input type="checkbox">
											<i class="fa"></i>
											Exportiert
										</label>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-12">
										<label class="cr-styled">
											<input type="checkbox" checked="checked">
											<i class="fa"></i>
											Ausgefüllt
										</label>
										<span class="manual-by">Manuell von Mustermann </span>
									</div>
								</div>
							</div>
						</div>
						<hr />
						<div class="row m-t-30">
							<div class="col-lg-10">
								<h4 class="m-t-0">Kommentare</h4>
								<textarea class="form-control custom-height-textarea2" placeholder="Tragen Sie den Text hier ein"></textarea>
							</div>
							<div class="col-lg-2 m-t-30 m-b-5">
								<div class="group-btn pull-right">
									<button class="btn w-lg btn-lg btn-success disabled" style="margin-bottom:10px">AKZEPTIEREN</button>
									<button class="btn w-lg btn-lg btn-danger disabled">ABLEHNEN</button>
									
								</div>
							</div>
						</div>
						<div class="form-group group-btn row m-t-30">
							<div class="col-lg-8 text-left">
								<a class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"><i class="fa fa-trash-o"></i></a>
								<button class="btn btn-icon btn-danger btn-lg" data-dismiss="modal">Mittelabrufe schließen</button>
							</div>
							<div class="col-lg-4 text-right">
								<button class="btn w-lg cancel-btn btn-lg">Abbrechen</button>
								<button class="btn w-lg custom-btn btn-lg">Speichern</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Set duration -->

		<div id="modal-3" class="modal fade request-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Delay date of import</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body text-center">
						<h3 class="m-b-30">Set delay date of import for 4 selected items</h3>
						<div class="form-group">
							<div class="holder-datepicker">
                                <div class="col-lg-4 p-0 col-md-offset-4">
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

		<!-- Accepted and allow printing  -->
		<div id="modal-4" class="modal fade request-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Accepted and allow printing</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div> 
					<div class="panel-body text-center">
						<h3 class="m-b-30">Accepted and allow printing for 4 selected items</h3>
						<div class="form-group">
							<select class="form-control">
								<option>Select template for print</option>
							</select>
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

		<!-- Letter received and correctly  -->
		<div id="modal-5" class="modal fade request-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Letter received and correctly</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div> 
					<div class="panel-body text-center">
						<h3 class="m-b-30">Letter received and correctly <br/>for 4 selected items</h3>
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
						{ className:"dt-edit", "targets": [10] },
						{ "width": "8%", "targets": [1, 3, 4] },
						{ className:"width-col", "targets": [1] },
						{ className:"width-col2", "targets": [2] },
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