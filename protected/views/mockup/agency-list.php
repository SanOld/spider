<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include('templates/head.php'); ?>
		<title>Träger Agentur | SPIder</title>
	</head>

	<body class="agency-list">
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
			
			 <!-- Navbar Start -->
			<?php include('templates/menu.php'); ?>
				
			<div class="container">
				<ul class="breadcrumb p-0">
					<li><a href="/dashboard">Startseite</a></li>
					<li class="active">Träger Agentur</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Träger Agentur</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
									<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Agentur hinzufügen</button>
								</div>
							</div>
							<div class="panel-body agency-edit">
								<div class="row datafilter">
									<form action="#">
										<div class="col-lg-5">
											<div class="form-group">
												<label>Suche nach Adresse, Ansprechpartner oder E-Mail</label>
												<input class="form-control" type="text" placeholder="Eingegeben"/>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<div class="form-group">
													<label>Suche nach Bankverbindung</label>
													<input class="form-control" type="text" placeholder="Eingegeben"/>
												</div>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<div class="form-group">
													<label>Überprüft</label>
													<select class="form-control">
														<option>Alles anzeigen</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-lg-2 reset-btn-width">
											<button class="btn pull-right w-lg custom-reset"><i class="fa fa-rotate-left"></i><span>Filter zurücksetzen</span></button>
										</div>
									</form>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<table id="datatable" class="table table-hover table-bordered table-edit" data-page-length="10000">
											<thead>
												<tr>
													<th>Name</th>
													<th>Adresse</th>
													<th>Ansprechpartner(in)</th>
													<th>E-Mail</th>
													<th>Telefon</th>
													<th>Überprüft</th>
													<th>Bearbeiten</th>
												</tr>
											</thead>
			
											<tbody>
												<tr class="disable">
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Tiger Nixon</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center">-</td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Garrett Winters</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center"><i class="ion-checkmark"></i></td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Brielle Williamson</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center"><i class="ion-checkmark"></i></td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Herrod Chandler</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center"><i class="ion-checkmark"></i></td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Rhona Davidson</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center"><i class="ion-checkmark"></i></td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="disable">
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Colleen Hurst</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center">-</i></td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Sonya Frost</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center"><i class="ion-checkmark"></i></td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Charde Marshall</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center"><i class="ion-checkmark"></i></td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Haley Kennedy</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center"><i class="ion-checkmark"></i></td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr class="disable">
													<td>GSJ - Gesellschaft für Sport und Jugendsozialarbeit gGmbH</td>
													<td>Hannas-Braun-Str./Frisenhous 11 14053 Berlin</td>
													<td>Tatyana Fitzpatrick</td>
													<td><a href="mailto:test@test.com">test@test.com</a></td>
													<td>(030) 2888 496</td>
													<td class="text-center">-</td>
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
								<div class="notice">
									<span class="color-notice"></span>
									Nicht überprüfte Agenturen
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

		<!-- <div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Edit Agency</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
		</div> -->

<!--End Add user -->

<!--Edit agency -->

		<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-width-full">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Trägerdaten - Tandem gemeinnützige Beschäftigungs- und Qualifizierungsgesellschaft mbH</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="row">
						<div class="row">
							<ul class="nav nav-tabs"> 
								<li class="active"> 
									<a href="#general" data-toggle="tab" aria-expanded="false">
										<span class="hidden-xs">General</span> 
									</a> 
								</li>
								<li> 
									<a href="#profile" data-toggle="tab" aria-expanded="false">
										<span class="hidden-xs">Profil</span> 
									</a> 
								</li>  
								<li> 
									<a href="#request" data-toggle="tab" aria-expanded="false">
										<span class="hidden-xs">Anträge</span> 
									</a> 
								</li> 
								<li> 
									<a href="#user" data-toggle="tab" aria-expanded="false">
										<span class="hidden-xs">Benutzer</span> 
									</a> 
								</li> 
								<li> 
									<a href="#projects" data-toggle="tab" aria-expanded="false">
										<span class="hidden-xs">Projekte</span> 
									</a> 
								</li>
							</ul> 
							<div class="tab-content clearfix m-0"> 
								<div class="tab-pane active" id="general"> 
									<div class="holder-tab">
										<div class="col-lg-8">
											<h3 class="subheading">Allgemeine Information</h3>
											<hr>
											<form action="#" class="form-horizontal">
												<div class="address-row">
													<div class="form-group">
														<label class="col-lg-2 control-label">Kurzname</label>
														<div class="col-lg-10">
															<input class="form-control" type="text" value="Tandem BQG"/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-lg-2 control-label">Name</label>
														<div class="col-lg-10">
															<input class="form-control" type="text" value="Tandem gemeinnützige Beschäftigungs- und Qualifizierungsgesellschaft mbH"/>
														</div>
													</div>
												</div>
												<div class="row address-row">
													<div class="col-lg-6">
														<div class="form-group">
															<label class="col-lg-4 control-label">Adresse</label>
															<div class="col-lg-8">
																<textarea class="form-control">Potsdamer Str. 182, 10783 Berlin</textarea>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-4 control-label">PLZ</label>
															<div class="col-lg-8">
																<input class="form-control" type="text" value="10997"/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-4 control-label">Stadt</label>
															<div class="col-lg-8">
																<input class="form-control" type="text" value="Berlin"/>
															</div>
														</div>
													</div>
													<div class="col-lg-5 col-lg-offset-1">
														<div class="form-group">
															<label class="col-lg-3 control-label">Telefon</label>
															<div class="col-lg-9">
																<input class="form-control" type="tel" value="(030) 2888 496"/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Fax</label>
															<div class="col-lg-9">
																<input class="form-control" type="tel" value="(030) 2888 496"/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">E-Mail</label>
															<div class="col-lg-9">
																<input class="form-control" type="email" value="admin@warenform.de"/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Webseite</label>
															<div class="col-lg-9">
																<input class="form-control" type="email" value="warenform.de"/>
															</div>
														</div>
													</div>
												</div>
												<div class="row holder-three-blocks">
													<div class="col-lg-4">
														<h4>Vertretungsberechtigte Person</h4>
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
															<dt>E-Mail</dt>
															<dd>admin@warenform.de </dd>
														</dl>
													</div>
													<div class="col-lg-4">
														<h4>Ansprechperson für Antragsbearbeitung</h4>
														<select class="form-control">
															<option>Mr Werner Munk</option>
															<option>Mr Werner Munk</option>
														</select>
														<dl>
															<dt>Titel</dt>
															<dd>Some title</dd>
															<dt>Telefon</dt>
															<dd>(030) 2888 496</dd>
															<dt>E-Mail</dt>
															<dd>admin@warenform.de </dd>
														</dl>
													</div>
													<div class="col-lg-4">
														<h4>Ansprechperson für die Finanzplanbearbeitung</h4>
														<select class="form-control">
															<option>Mr Werner Munk</option>
															<option>Mr Werner Munk</option>
														</select>
														<dl>
															<dt>Titel</dt>
															<dd>Some title</dd>
															<dt>Telefon</dt>
															<dd>(030) 2888 496</dd>
															<dt>E-Mail</dt>
															<dd>admin@warenform.de </dd>
														</dl>
													</div>
												</div>
											</form>
										</div>
										<div class="col-lg-4">
											<div class="heading-button clearfix m-b-15">
												<h3 class="subheading pull-left">Bankverbindungen</h3>
												<button class="btn w-md custom-btn pull-right" type="button">Neu</button>
											</div>
											<div class="holder-bank-details">
												<div class="form-custom-box bank-details">
													<form action="#" class="form-horizontal">
														<div class="heading-bank clearfix m-b-15">
															<h4 class="pull-left">Bankverbindungen</h4>
															<!-- <button class="btn btn-icon btn-danger btn-sm pull-right"><i class="fa fa-trash-o"></i></button> -->
														</div>
														<div class="form-group">
															<label class="col-lg-5 p-r-0 control-label">Kontoinhaber</label>
															<div class="col-lg-7">
																<input class="form-control" type="text" value="Mustermann"/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-5 p-r-0 control-label">IBAN</label>
															<div class="col-lg-7">
																<input class="form-control" type="text" value="DE64100708480511733803a"/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-5 p-r-0 control-label">Kreditor</label>
															<div class="col-lg-7">
																<input class="form-control" type="text" value=""/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-5 p-r-0 control-label">Beschreibung</label>
															<div class="col-lg-7">
																<textarea class="form-control"></textarea>
															</div>
														</div>
														<div class="pull-right">
														 	<button class="btn w-sm cancel-btn">Löschen</button>
															<button class="btn w-sm custom-btn">Hinzufügen</button>
														</div>
													</form>
												</div>

												<div class="form-custom-box bank-details">
													<form action="#" class="form-horizontal">
														<div class="heading-bank clearfix m-b-15">
															<h4 class="pull-left">Bankverbindungen</h4>
															<!-- <button class="btn btn-icon btn-danger btn-sm pull-right"><i class="fa fa-trash-o"></i></button> -->
														</div>
														<div class="form-group">
															<label class="col-lg-5 p-r-0 control-label">Kontoinhaber</label>
															<div class="col-lg-7">
																<input class="form-control" type="text" value="Mustermann"/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-5 p-r-0 control-label">IBAN</label>
															<div class="col-lg-7">
																<input class="form-control" type="text" value="DE64100708480511733803a"/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-5 p-r-0 control-label">Kreditor</label>
															<div class="col-lg-7">
																<input class="form-control" type="text" value=""/>
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-5 p-r-0 control-label">Beschreibung</label>
															<div class="col-lg-7">
																<textarea class="form-control"></textarea>
															</div>
														</div>
														<div class="pull-right">
														 	<button class="btn w-sm cancel-btn">Löschen</button>
															<button class="btn w-sm custom-btn">Hinzufügen</button>
														</div>
													</form>
												</div>
											
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<hr>
										<div class="group-btn clearfix m-t-20">
											<div class="pull-left">
												<button class="btn btn-icon btn-danger btn-lg sweet-4" id="sa-warning"><i class="fa fa-trash-o"></i></button>
											</div>
											<div class="pull-right">
											 	<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
												<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="profile"> 
									<div class="holder-tab">
										<div class="panel-body">
											<div class="col-lg-6">
												<div class="form-group">
													<label>Selbstdarstellung</label>
													<div class="holder-textarea">
														<textarea class="form-control animate-textarea textarea-1" placeholder="Tragen Sie den Text hier ein"></textarea>
													</div>
												</div>
												<div class="form-group">
													<label>Diversity: GM, CM, Inklusion</label>
													<div class="holder-textarea">
														<textarea class="form-control animate-textarea textarea-2" placeholder="Tragen Sie den Text hier ein"></textarea>
													</div>
												</div>
												<div class="clearfix m-t-40">
													<div class="heading pull-left">
														<h3 class="m-0">Dokumente</h3>
														<label>Sie können PDF- und DOC-Dateien hochladen<br/> (10 Mb Größenbeschränkung)</label>
													</div>
													
													<div style="position:relative;">
														<a class='btn w-sw custom-color pull-right' href='javascript:;'>
															Dokumente hinzufügen
															<input type="file" style='position:absolute;z-index:2;top:0;right:0; cursor:pointer; width: 118px; height: 36px; filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_source" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
														</a>
														<span class='label label-info' id="upload-file-info"></span>
													</div>
												</div>
												<div class="form-custom-box clearfix m-0 upload-box">
													<ul class="list-unstyled">
														<li><i class="ion-document-text "></i><a href="#">Some document.doc</a><a class="sweet-4" href="#"><i class="ion-close"></i></a></li>
														<li><i class="ion-document-text "></i><a href="#">Some document.doc</a><a class="sweet-4" href="#"><i class="ion-close"></i></a></li>
														<li><i class="ion-document-text "></i><a href="#">Some document.doc</a><a class="sweet-4" href="#"><i class="ion-close"></i></a></li>
														<li><i class="ion-document-text "></i><a href="#">Some document.doc</a><a class="sweet-4" href="#"><i class="ion-close"></i></a></li>
														<li><i class="ion-document-text "></i><a href="#">Some document.doc</a><a class="sweet-4" href="#"><i class="ion-close"></i></a></li>
													</ul>
												</div>
											</div>
											<div class="col-lg-6 clearfix">
												<div class="form-group">
													<label>Fortbildung</label>
													<div class="holder-textarea">
														<textarea class="form-control animate-textarea textarea-3" placeholder="Tragen Sie den Text hier ein"></textarea>
													</div>
												</div>
												<div class="form-group">
													<label>Qualitätsstandards</label>
													<div class="holder-textarea">
														<textarea class="form-control animate-textarea textarea-4" placeholder="Tragen Sie den Text hier ein"></textarea>
													</div>
												</div>
												<div class="clearfix m-t-40">
													<h3 class="m-0">Interner Vermerk</h3>
													<label>Sie können eine Nachricht für PA hinterlassen </label>
												</div>
												<div class="form-group">
													<textarea class="form-control custom-height" placeholder="Tragen Sie den Text hier ein"></textarea>
												</div>
												<div class="form-custom-box clearfix m-0">
													<div class="pull-left">
														<label class="control-label">Information ist überprüft und korrekt</label><br/>
														<span class="checked-person">Überpüft von Mustermann 15.12.2015</span>
													</div>
													<div class="pull-right m-t-10">
														<div class="btn-group btn-toggle"> 
															<button class="btn btn-sm btn-default">JA</button>
															<button class="btn btn-sm active">NEIN</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<hr>
										<div class="group-btn clearfix m-t-20">
											<div class="pull-left">
												<button class="btn btn-icon btn-danger btn-lg sweet-4"><i class="fa  fa-trash-o"></i></button>
											</div>
											<div class="pull-right">
											 	<button class="btn w-lg cancel-btn" data-dismiss="modal">Abbrechen</button>
												<button class="btn w-lg custom-btn" data-dismiss="modal">Speichern</button>
											</div>
										</div>
									</div>
								</div> 
								<div class="tab-pane" id="request"> 
									<div class="holder-tab">
										<div class="panel-body request-edit">
											<div class="datafilter clearfix">
												<form action="#">
													<div class="col-lg-4">
														<div class="form-group">
															<div class="form-group">
																<label>Antragstyp</label>
																<select class="form-control">
																	<option>Alles anzeigen</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-lg-2">
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
																	<option>In Progress</option>
																	<option>Akzeptiert</option>
																	<option>Ablehnen </option>
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
												</form>
											</div>
											<div>
												<div class="col-lg-12">
													<table id="datatable" class="table table-hover table-bordered table-edit">
														<thead>
															<tr class="head-top">
																<th>Kennziffer</th>
																<th>Jahr</th>
																<th>Status</th>
																<th></th>
																<th></th>
																<th></th>
																<th>Abgabe</th>
																<th>Letzte Änd.</th>
																<th>Ansicht</th>
															</tr>
															<tr>
																<th>Kennziffer</th>
																<th>Jahr</th>
																<th>Status</th>
																<th colspan="3">Beanst.</th>
																<th>Abgabe</th>
																<th>Letzte Änd.</th>
																<th>Ansicht</th>
															</tr>
															
														</thead>
						
														<tbody>
															<tr class="acceptable-row">
																<td><a href="order.php">K026</a></td>
																<td>2016</td>
																<td>Förderfähig</td>
																<td></td>
																<td></td>
																<td></td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
																</td>
															</tr>
															<tr>
																<td><a href="order.php">G053</a></td>
																<td>2016</td>
																<td>Unbearbeitet</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
																		<span class="cell-finplan select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
																		<span class="cell-concept select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
																		<span class="cell-school"></span>
																	</a>
																</td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	
																</td>
															</tr>
															<tr>
																<td><a href="order.php">K026</a></td>
																<td>2016</td>
																<td>Unbearbeitet</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
																		<span class="cell-finplan select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
																		<span class="cell-concept select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
																		<span class="cell-school"></span>
																	</a>
																</td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	
																</td>
															</tr>
															<tr>
																<td><a href="order.php">G053</a></td>
																<td>2016</td>
																<td>Unbearbeitet</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
																		<span class="cell-finplan select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
																		<span class="cell-concept select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
																		<span class="cell-school"></span>
																	</a>
																</td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	
																</td>
															</tr>
															<tr class="acceptable-row">
																<td><a href="order.php">K026</a></td>
																<td>2016</td>
																<td>Förderfähig</td>
																<td></td>
																<td></td>
																<td></td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
																	
																</td>
															</tr>
															<tr class="inprogress-row">
																<td><a href="order.php">G053</a></td>
																<td>2016</td>
																<td>Bitte Bearbeiten</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
																		<span class="cell-finplan select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
																		<span class="cell-concept select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
																		<span class="cell-school"></span>
																	</a>
																</td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	
																</td>
															</tr>
															<tr class="acceptable-row">
																<td><a href="order.php">K026</a></td>
																<td>2016</td>
																<td>Förderfähig</td>
																<td></td>
																<td></td>
																<td></td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
																	
																</td>
															</tr>
															<tr class="accept-row">
																<td><a href="order.php">K026</a></td>
																<td>2016</td>
																<td>Genehmigt</td>
																<td></td>
																<td></td>
																<td></td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
																	
																</td>
															</tr>
															<tr class="decline-row">
																<td><a href="order.php">G053</a></td>
																<td>2016</td>
																<td>Nur Leserecht</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
																		<span class="cell-finplan select-decline"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
																		<span class="cell-concept select-decline"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
																		<span class="cell-school select-decline"></span>
																	</a>
																</td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	
																</td>
															</tr>
															<tr class="accept-row">
																<td><a href="order.php">K026</a></td>
																<td>2016</td>
																<td>Genehmigt</td>
																<td></td>
																<td></td>
																<td></td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td>
																	<a class="btn document" href="#" data-target="#modal-5" data-toggle="modal" title="Drucken"><i class="ion-printer"></i></a>
																	
																</td>
															</tr>
															<tr class="decline-row">
																<td><a href="order.php">G053</a></td>
																<td>2016</td>
																<td>Nur Leserecht</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_finance" title="Finanzplan">
																		<span class="cell-finplan select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_concepts" title="Schulkonzept">
																		<span class="cell-concept select"></span>
																	</a>
																</td>
																<td>
																	<a class="request-button btn edit-btn" href="/order.php#tab_schools-goals" title="Entwicklungsziele">
																		<span class="cell-school"></span>
																	</a>
																</td>
																<td>13.11.2015</td>
																<td>15.10.2015</td>
																<td></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<div class="clearfix m-b-30">
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
								<div class="tab-pane" id="user"> 
									<div class="holder-tab">
										<div class="panel-body edit-user agency-tab-user">
											<div>
												<div class="col-lg-12">
													<div class="row datafilter">
														<form action="#" class="class-form">
															<div class="col-lg-3">
																<div class="form-group">
																	<label>Suche nach Name, Benutzername oder E-Mail</label>
																	<input type="search" class="form-control" placeholder="Eingegeben">
																</div>
															</div>
															<div class="col-lg-4">
																<div class="form-group">
																	<label>Benutzerrollen</label>
																	<select class="type-user form-control">
																		<option>Performer (F)</option>
																		<option>Performer</option>
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
																<th>E-Mail</th>
																<th>Telefon</th>
																<th class="status-filter">Status</th>
																<th>Bearbeiten</th>
															</tr>
														</thead>
						
														<tbody>
															<tr>
																<td>Tiger Nixon</td>
																<td>Performer</td>
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
																<td>Performer</td>
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
																<td>Performer (F)</td>
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
																<td>Performer</td>
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
																<td>Performer (F)</td>
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
																<td>Performer</td>
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
																<td>Performer</td>
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
																<td>Performer (F)</td>
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
																<td>Performer (F)</td>
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
																<td>Performer</td>
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
								<div class="tab-pane" id="projects"> 
									<div class="holder-tab">
										<div class="panel-body edit-user">
											<div class="col-lg-12">
												<div class="row datafilter">
													<form action="#" class="class-form">
														<div class="col-lg-3 col-width-type">
															<div class="form-group">
																<label>Suche nach Kennziffer</label>
																<input type="search" class="form-control" placeholder="Eingegeben">
															</div>
														</div>
														<div class="col-lg-2 col-width-type">
															<div class="form-group">
																<label>Typ</label>
																<select class="type-user form-control">
																	<option>Alles anzeigen</option>
																</select>
															</div>
														</div>
														<div class="col-lg-3 col-width-type">
															<div class="form-group">
																<label>Bezirk</label>
																<select class="type-user form-control">
																	<option>Alles anzeigen</option>
																</select>
															</div>
														</div>
														<div class="col-lg-3">
															<div class="form-group">
																<label>Schule</label>
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
															<th>Kennziffer</th>
															<th>Bezirk</th>
															<th>Schule</th>
															<th>Bearbeiten</th>
														</tr>
													</thead>
														
													<tbody>
														<tr>
															<td><a href="#">B026</a></td>
															<td class="custom-data"><a href="#">Bezirk Neukolln</a></td>
															<td><a href="#">Pestalozzi-Schule (06S01)</a></td>
															<td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td><a href="#">B053</a></td>
															<td class="custom-data"><a href="#">Bezirk Pankow</a></td>
															<td><a href="#">Pestalozzi-Schule (06S01)</a></td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td><a href="#">Z026</a></td>
															<td><a href="#">Lina Morgenstern</a></td>
															<td class="custom-data"><a href="#">Lina Morgenstern (02K04)</a></td>
															 <td>
															 	<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td><a href="#">G053</a></td>
															<td><a href="#">Bezirk Neukolln</a></td>
															<td><a href="#">Solling-Schule (ISS) (07K05)</a></td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td><a href="#">B026</a></td>
															<td class="custom-data"><a href="#">Bezirk Neukolln</a></td>
															<td><a href="#">Solling-Schule (ISS) (07K05)</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td><a href="#">S053</a></td>
															<td><a href="#">Bezirk Pankow</a></td>
															<td><a href="#">Biesalski-Schule (06S02)</a></td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td><a href="#">K026</a></td>
															<td><a href="#">Bezirk Pankow</a></td>
															<td><a href="#">Biesalski-Schule (06S02)</a></td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td><a href="#">Z053</a></td>
															<td><a href="#">Bezirk Neukolln</a></td>
															<td class="custom-data"><a href="#">Biesalski-Schule (06S02)</a></td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td><a href="#">S053</a></td>
															<td><a href="#">Bezirk Pankow</a></td>
															<td><a href="#">Biesalski-Schule (06S02)</a></td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
																	<i class="ion-edit"></i>
																</a>
															</td>
														</tr>
														<tr>
															<td><a href="#">S053</a></td>
															<td><a href="#">Bezirk Pankow</a></td>
															<td>
																<a href="#">Solling-Schule (ISS) (07K05)</a><br/>
																<a href="#">Pestalozzi-Schule (06S01)</a><br/>
																<a href="#">Biesalski-Schule (06S02)</a>
															</td>
															 <td>
																<a class="btn edit-btn center-block" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
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
						</div>
					</div>
				</div>
			</div>
		</div>

<!--End Edit agency -->

		<div class="md-overlay"></div>
		
		<?php include('templates/scripts.php'); ?>
		
		<script type="text/javascript">

			jQuery(window).load(function() {

				jQuery(".select2").select2();

				$("#profile .animate-textarea").focus(function(){
				    $(this).addClass("animate");

					}).blur(function(){
					    $(this).removeClass("animate");
				})

				$('#request #datatable').DataTable({
					"sDom": 'Rfrtlip',
					"columnDefs": [
						{ className:"dt-edit", "targets": [8] },
						{ className:"dt-width3", "targets": [0, 1, 3, 4, 5 ] },
						{ className:"dt-width2", "targets": [6,7] }
					],
					"oLanguage": {
				      	"sLengthMenu": "_MENU_ Objekte pro Seite",
				      	"sInfo": "Seite _PAGE_ von _PAGES_ aus _TOTAL_ Einträgen",
				      	"oPaginate": {
			                "sPrevious": "Zurück", // This is the link to the previous page
			                "sNext": "Weiter", // This is the link to the next page
			            }
				    }
				});
				$('#datatable_length').insertAfter('#datatable_paginate');
				$('#datatable_info, #datatable_length, #datatable_paginate').wrapAll('<div class="wrap-paging clearfix">');
				
				// Swicher button	
				jQuery('.btn-toggle').click(function(){
					$(this).find(".btn").toggleClass('active');
					$(this).find(".btn").toggleClass('btn-default');
					return false;
				})

				$('.agency-edit #datatable').DataTable({
					"paging":   false,
					"info":     false,
					"columnDefs": [
						{ "width": "23%", "targets": 1 },
						{ "width": "23%", "targets": 0 },
						{ className:"dt-edit", "orderable": false, "targets": 6 }
					]
				});

				$('#user #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{ className:"dt-edit", "orderable": false, "targets": 6 },
						{ "width": "25%", "targets": 2 }
					]
				});

				$('#projects #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{ className:"dt-edit", "orderable": false, "targets": 4 },
						{ className:"dt-width3", "targets": [0] },
						{ "width": "30%", "targets": 3 }
					]
				});
 
			        
			});
		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>