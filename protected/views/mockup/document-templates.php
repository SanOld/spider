<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Druck-Templates | SPIder</title>
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
					<li><a href="/dashboard">Startseite</a></li>
					<li class="active">Druck-Templates</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Druck-Templates</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken<i class="ion-printer"></i></a>
									<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Druck-Template hinzufügen</button>
								</div>
							</div>
							<div class="panel-body edit-user doc-template">
								<div class="row">
									<div class="col-lg-12">
										<div class="row datafilter">
											<form action="#" class="class-form">
												<div class="col-lg-5">
													<div class="form-group">
														<label>Suche nach Namen und Dokument-Typ</label>
														<input type="search" class="form-control" placeholder="Eingegeben">
													</div>
												</div>
												<div class="col-lg-5">
													<div class="form-group">
														<label>Dokument-Typ</label>
														<select class="type-user form-control">
															<option>Alles anzeigen</option>
															<option>Fördervertrag</option>
															<option>Zielvereinbarung</option>
															<option>Antrag</option>
															<option>Mittelabruf</option>
															<option>Verwendungsnachweis</option>
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
													<th>Dokument-Typ</th>
													<th>Letzte Änderung</th>
													<th>
														<span>Ansicht</span>
														<span>Bearbeiten</span>
													</th>
												</tr>
											</thead>
			
											<tbody>
												<tr>
													<td><a href="#">FV_2015_S</a></td>
													<td>Typ 1</td>
													<td>24.03.2010, 16:04 von Markus Prill</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht">
															<i class="ion-document-text"></i>
														</a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">FV_2015_Bonus</a></td>
													<td>Typ 1</td>
													<td>02.09.2011, 14:24 von Anita Reindl</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht"><i class="ion-document-text"></i></a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">FV_2015_LM</a></td>
													<td>Typ 1</td>
													<td>24.03.2010, 16:04 von Frank Kiepert</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht"><i class="ion-document-text"></i></a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">FV_2015_Sonderkündigung</a></td>
													<td>Typ 2</td>
													<td>02.09.2011, 14:24 von Undine Zeibig</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht"><i class="ion-document-text"></i></a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">FV_2014_Bonus</a></td>
													<td>Typ 2</td>
													<td>24.03.2010, 16:04 von Brigitte Bollinger</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht"><i class="ion-document-text"></i></a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">FV_2014_LM</a></td>
													<td>Typ 2</td>
													<td>02.09.2011, 14:24 von Werner Munk</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht"><i class="ion-document-text"></i></a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">FV_2014_Z010</a></td>
													<td>Typ 2</td>
													<td>02.09.2011, 14:24 von Sabina Kästner</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht"><i class="ion-document-text"></i></a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">FV_2014_Sonderkündigung</a></td>
													<td>Typ 3</td>
													<td>24.03.2010, 16:04 von Markus Prill</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht"><i class="ion-document-text"></i></a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">FV_2013_Z010</a></td>
													<td>Typ 3</td>
													<td>24.03.2010, 16:04 von Anita Reindl</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht"><i class="ion-document-text"></i></a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">FV_2013_Sonderkündigung</a></td>
													<td>Typ 3</td>
													<td>02.09.2011, 14:24 von Frank Kiepert</td>
													<td class="text-center">
														<a class="btn edit-btn"  data-target="#modal-3" data-toggle="modal" title="Ansicht"><i class="ion-document-text"></i></a>
														<a class="btn edit-btn"  data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
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

<!--Add Doc templ  -->

		<!-- <div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Finanzierung hinzufügen</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
		</div> -->

<!--End Add Doc templ  -->

<!--Edit Doc templ  -->

		<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-width-full">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Druck-Template bearbeiten - FV_2013_Sonderkündigung</h3>
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
									<a href="#placeholder" data-toggle="tab" aria-expanded="false">
										<span class="hidden-xs">Platzhalter</span> 
									</a> 
								</li>
							</ul>
						</div>
						<div class="tab-content clearfix m-0"> 
							<div class="tab-pane active" id="general"> 
								<form role="form" class="form-horizontal">
									<div class="row m-t-30">
										<div class="m-b-15 clearfix">
											<label class="col-lg-1 control-label">Name</label>
											<div class="col-lg-6">
												<input class="form-control" type="text" value="FV_2013_Sonderkündigung">
											</div>
											<label class="col-lg-2 control-label label-type">Dokument-Typ</label>
											<div class="col-lg-3">
												<select class="form-control">
													<option>Alles anzeigen</option>
                                                    <option>Fördervertrag</option>
                                                    <option>Zielvereinbarung</option>
                                                    <option>Antrag</option>
                                                    <option>Mittelabruf</option>
                                                    <option>Verwendungsnachweis</option>
												</select>
											</div>
										</div>
										<div class="m-b-15 clearfix">
						                    <div class="col-sm-12">
					                            <div class="panel-body"> 
					                                <div class="summernote">
														Zwischen
														der
														Stiftung Sozialpädagogisches Institut Berlin
														Programmagentur "Jugendsozialarbeit an Berliner Schulen"
														Schicklerstraße 5-7 in 10179 Berlin
														- nachstehend Programmagentur SPI genannt -
														und dem Träger

														{TRAEGER} mit der Kennziffer *{KENNZIFFER}*
														- nachstehend Förderungsempfänger genannt -
														wird folgender

														h2. FÖRDERVERTRAG (Weiterleitungsvertrag)
														geschlossen.

														<br>
					                                </div>
					                            </div>
						                    </div>
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
							<div class="tab-pane" id="placeholder">
								<div class="panel-body">
									<div>
										<table id="datatable" class="table table-hover table-bordered table-edit" data-page-length="10000">
											<thead>
												<tr>
													<th>Platzhalter</th>
													<th>Beschreibung</th>
												</tr>
											</thead>
			
											<tbody>
												<tr>
													<td>AUFLAGEN</td>
													<td>Bei der Antragsabnahme können Auflagen durch die Programmagentur hinzugefügt bzw. formuliert werden.</td>
												</tr>
												<tr>
													<td>FOERDERSUMME</td>
													<td>Die Fördersumme aus dem förderfähigen Antrag.</td>
												</tr>
												<tr>
													<td>KENNZIFFER</td>
													<td>Die Kennziffer des Projekts wird aus dem Antrag übernommen.</td>
												</tr>
												<tr>
													<td>TRAEGER</td>
													<td>Name und Adresse des antragsstellenden Trägers.</td>
												</tr>
												<tr>
													<td>ZEITRAUM</td>
													<td>Laufzeit laut förderfähigem Antrag (Beginn und Ende).</td>
												</tr>
												<tr>
													<td>JAHR</td>
													<td>Förderjahr des Antrags.</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>

<!--End Edit Doc templ -->

<!--View Doc-->

		<div id="modal-3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-width-full">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Druck-Template bearbeiten - FV_2013_Sonderkündigung</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>

                  
                  <div class="panel-body edit-user doc-template">
                    <div class="row">
                        <div class="col-lg-12">
                            Zwischen<br/>
                            der<br/>
                            Stiftung Sozialpädagogisches Institut Berlin<br/>
                            Programmagentur “Jugendsozialarbeit an Berliner Schulen”<br/>
                            Schicklerstraße 5-7 in 10179 Berlin<br/>

                            - nachstehend Programmagentur SPI genannt -<br/>
                            und dem Träger<br/>

                            <strong>{TRAEGER}</strong> mit der Kennziffer <strong>{KENNZIFFER}</strong><br/>

                            - nachstehend Förderungsempfänger genannt -<br/>
                            wird folgender<br/>
                            <h3>FÖRDERVERTRAG (Weiterleitungsvertrag)</h3>
                            geschlossen.<br/>

                            <h4>§ 1 Grundsätzliche Regelungen</h4>

                            (1) Die Programmagentur SPI ist vom Land Berlin, vertreten durch die Senatsverwaltung für Bildung, Jugend und Wissenschaft beauftragt worden, das Programm „Jugendsozialarbeit an Berliner Schulen“ umzusetzen. Das Programm wird durch Mittel des Berliner Landeshaushalts finanziert.<br/>

                            (2) Zur Umsetzung des Programms entwickeln die freien Träger der Kinder- und Jugendhilfe zusammen mit einer Schule bzw. mehreren Schulen (betrifft Jugendsozialarbeit mit besonderen Aufgaben) konkrete auf die jeweilige Schule bezogene Konzepte. Dazu werden Kooperationsverträge zwischen den Schulen und den freien Trägern der Kinder- und Jugendhilfe abgeschlossen.<br/>

                            (3) Die freien Träger verpflichten sich, das Gender-Mainstreaming-Prinzip anzuwenden, d. h. bei der Planung, Durchführung und Begleitung der Maßnahme sind Auswirkungen auf die Gleichstellung von Frauen und Männern aktiv zu berücksichtigen und in der Berichterstattung darzustellen.<br/>

                            <h4>§ 2 Vertragsgegenstand und -bestandteile</h4>

                            (1) Gegenstand dieses privatrechtlichen Vertrages ist die Weitergabe von Zuwendungen des Landes Berlin durch die Programmagentur SPI an die Förderungsempfänger auf der Grundlage entsprechender Bewilligungsbescheide der Senatsverwaltung für Bildung, Jugend und Wissenschaft.<br/>

                            (2) Bestandteile dieses Vertrages sind – in ihrer jeweils geltenden Fassung – insbesondere:<br/>
                            Antrag des Förderungsempfängers inkl. Finanzplan,
                        </div>
                    </div>
                    <hr />
                    <div class="form-group group-btn m-t-15">
                        <div class="col-lg-10 text-right pull-right">
                            <button class="btn w-lg custom-btn" data-dismiss="modal">Schließen</button>
                        </div>
                    </div>
                  </div>
				</div>
				
			</div>
		</div>

<!-- End View Doc -->

		<div class="md-overlay"></div>
		

		<?php include('templates/scripts.php'); ?>

		<script type="text/javascript">

			jQuery(window).load(function() {

				jQuery(".select2").select2();

				$('.edit-user #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{className:"dt-edit", "width": "18%", "targets": 3 }
					],
				});

				$('#placeholder #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{ className:"dt-edit", "targets": 1 }
					],
				});

				$('.summernote').summernote({
                    height: 200,                 // set editor height

                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor

                    focus: true                 // set focus to editable area after initializing summernote
                });

			});
		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>