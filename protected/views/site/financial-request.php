<?php
$this->pageTitle = 'Mittelabrufe | ' . Yii::app()->name;
$this->breadcrumbs = array('Finanzen','Mittelabrufe');
?>	
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid finance-request">
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
										<div class="col-lg-4">
											<label>Träger</label>
											<div class="input-group">
			                                    <input type="text" class="form-control datepicker" placeholder="dd.mm.yyyy">
			                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			                                </div>
										</div>
										<div class="col-lg-4">
											<label>Belegdatum</label>
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
									<h4>Zusammenfassung der Finanzen für G052 (01.01.2016 - 31.12.2016)</h4>
									<div class="box-finance">
										<span class="sum total">
	                                    	<strong>Fördersumme</strong>
											<span>€ 87.443</span>
	                                    </span>
									</div>
									<div class="box-finance">
										<span class="sum requested">
	                                    	<strong>Änderungen</strong>
											<span>€ 0.00</span>
	                                    </span>
									</div>
									<div class="box-finance box-custom-width">
										<span class="sum refund">
	                                    	<strong>aktuelle Fördersumme</strong>
											<span>€ 100.00</span>
	                                    </span>
									</div>
									<div class="box-finance">
										<span class="sum income">
	                                    	<strong>Ausgezahlt</strong>
											<span>€ 58.295</span>
	                                    </span>
									</div>
									<div class="box-finance">
										<span class="sum spent">
	                                    	<strong>Verblieben</strong>
											<span>€ 1.000</span>
	                                    </span>
									</div>
									<div class="box-finance">
										<span class="sum expenditure">
	                                    	<strong>Finanzbericht</strong>
											<span>€ 29.147</span>
	                                    </span>
									</div>
									
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
													<th>Kennz.</th>
													<th>Jahr</th>
													<th>Rate</th>
													<th>Träger </th>
													<th>Kreditor</th>
													<th>Beleg Typ</th>
													<th>Beleg<br/>-Datum</th>
													<th>Betrag</th>
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
														<a class="id-request" href="order.php"><span>G052</span></a>
													</td>
													<td>2016</td>
													<td>Jan-Feb</td>
													<td><a href="#">Tandem BQG</a></td>
													<td>3148800</td>
													<td>Mittelabruf</td>
													<td>28.10.2015</td>
													<td>€ 9,749.86</td>
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
													<td>2016</td>
													<td>Jan-Feb</td>
													<td><a href="#">Tandem BQG</a></td>
													<td>3148800</td>
													<td>Mittelabruf</td>
													<td>28.10.2015</td>
													<td>€ 2,749.86</td>
													<td></td>
													<td>
														<a class="btn document print-disable" href="#" title="Drucken"><i class="ion-printer"></i></a>
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
													<td>2016</td>
													<td>Jan-Feb</td>
													<td><a href="#">CJD Berlin</a></td>
													<td>3148800</td>
													<td>Mittelabruf</td>
													<td>28.10.2015</td>
													<td>€ 862.86</td>
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
													<td>2016</td>
													<td>März-Apr</td>
													<td><a href="#">CJD Berlin</a></td>
													<td>3148800</td>
													<td>Freimeldung</td>
													<td>28.10.2015</td>
													<td>€ 862.86</td>
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
													<td>2016</td>
													<td>März-Apr</td>
													<td><a href="#">Tandem BQG</a></td>
													<td>3148800</td>
													<td>Freimeldung</td>
													<td>28.10.2015</td>
													<td>€ 862.86</td>
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
													<td>2016</td>
													<td>März-Apr</td>
													<td><a href="#">Tandem BQG</a></td>
													<td>3148800</td>
													<td>Freimeldung</td>
													<td>28.10.2015</td>
													<td>€ 2,749.86</td>
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
													</td>
													<td>2016</td>
													<td>März-Apr</td>
													<td><a href="#">CJD Berlin</a></td>
													<td>3148800</td>
													<td>Freimeldung</td>
													<td>28.10.2015</td>
													<td>€ 2,749.86</td>
													<td>28.10.2015</td>
													<td>
														<a class="btn document print-disable" href="#" title="Drucken"><i class="ion-printer"></i></a>
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
													<td>2016</td>
													<td>März-Apr</td>
													<td><a href="#">CJD Berlin</a></td>
													<td>3148800</td>
													<td>Freimeldung</td>
													<td>28.10.2015</td>
													<td>€ 9,749.86</td>
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
													</td>
													<td>2016</td>
													<td>Jan-Feb</td>
													<td><a href="#">CJD Berlin</a></td>
													<td>3148800</td>
													<td>Ergänzung</td>
													<td>28.10.2015</td>
													<td>€ 9,749.86</td>
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
													<td>2016</td>
													<td>Jan-Feb</td>
													<td><a href="#">CJD Berlin</a></td>
													<td>3148800</td>
													<td>Ergänzung</td>
													<td>28.10.2015</td>
													<td>€ 2,749.86</td>
													<td></td>
													<td>
														<a class="btn document print-disable" href="#" title="Drucken"><i class="ion-printer"></i></a>
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
													<td>2016</td>
													<td>März-Apr</td>
													<td><a href="#">CJD Berlin</a></td>
													<td>3148800</td>
													<td>Ergänzung</td>
													<td>28.10.2015</td>
													<td>€ 9,749.86</td>
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
											<button class="btn m-b-5">Export zu DATEV</button>
											<button class="btn m-b-5">Zahl. Datum hinzufügen</button>
											<button class="btn m-b-5" data-target="#modal-2" data-toggle="modal">Druck-Template wählen</button>
										</div>
									</div>
								</div>
								<div class="notice">
									<span class="color-notice inprogress-row"></span>
									In Bearbeitung
								</div>
								<div class="notice">
									<span class="color-notice open"></span>
									Erleding
								</div>
							</div>
						</div>
					</div>
				</div> <!-- End Row -->
			</div>
		</div>

		
		
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
									<dt>Träger</dt>
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
									<dt>E-Mail</dt>
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
									<label class="col-lg-4 control-label">Kontoinhaber</label>
									<div class="col-lg-8 control-label">
										Mr Werner Munk
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4 control-label">Kreditor</label>
									<div class="col-lg-8 control-label">
										3148800
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
								<h4 class="m-t-0">Prüfnotiz</h4>
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
							<div class="col-lg-7 text-left">
								<a class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"><i class="fa fa-trash-o"></i></a>
								<button class="btn btn-icon btn-danger btn-lg" data-dismiss="modal">Mittelabrufe schließen</button>
							</div>
							<div class="col-lg-5 text-right">
								<button class="btn w-lg cancel-btn btn-lg">Abbrechen</button>
								<button class="btn w-lg custom-btn btn-lg">Speichern</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- Letter received and correctly  -->
		<div id="modal-2" class="modal fade request-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
								<label>Document 1</label>
								<select class="form-control">
									<option>Document 1.doc</option>
									<option>Document 2.doc</option>
								</select>
							</div>
							<div class="form-group">
								<label>Document 2</label>
								<select class="form-control">
									<option>Document 1.doc</option>
									<option>Document 2.doc</option>
								</select>
							</div>
							<div class="form-group">
								<label>Document 3</label>
								<select class="form-control">
									<option>Document 1.doc</option>
									<option>Document 2.doc</option>
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

		<div class="md-overlay"></div>
	

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
						{ "width": "8%", "targets": [1, 3] },
						{ className:"width-col", "targets": [1] },
						{ className:"width-col2", "targets": [2] },
						{ className:"align-right", "targets": [8] }
					],
					"oLanguage": {
				      	"sLengthMenu": "_MENU_   Objekte pro Seite ",
				      	"sInfo": "Seite _PAGE_ von _PAGES_ aus _TOTAL_ Einträgen",
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
    
    <script src="js/lib/jquery.min.js"></script>

		<!-- js placed at the end of the document so the pages load faster -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/pace.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/wow.js"></script>

		<!--common script for all pages-->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.js"></script>

		<!-- validation form -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.validate.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/form-validation-init.js"></script>
		
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/sweet-alert.js"></script>

		
		<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/plug-ins/1.10.9/api/fnFilterClear.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/datatables/dataTables.bootstrap.js"></script>

		<!-- Modal-Effect -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/modal-effect/js/classie.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/modal-effect/js/modalEffects.js"></script>

		<!-- Datepicker -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/timepicker/bootstrap-datepicker.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/timepicker/bootstrap-datepicker.de.js"></script>

		<!-- Select -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/jquery-multi-select/jquery.quicksearch.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/select2/select2.min.js" type="text/javascript"></script>

		<!-- Wisiwig -->
		<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

    <!--form validation init-->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/assets/summernote/summernote.min.js"></script>
	