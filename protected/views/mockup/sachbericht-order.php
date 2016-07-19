<!DOCTYPE html>
<html lang="en">
	<head>

		<title>Sachbericht | SPIder</title>
		<?php include('templates/head.php'); ?>
	</head>

	<body class="reporting-page">
		
		<div id="page">
			<!-- Header -->
			<?php include('templates/header.php'); ?>
			<!-- Header Ends -->
	
			 <!-- Navbar Start -->
			<?php include('templates/menu.php'); ?>
					
			<div class="container">
				<ul class="breadcrumb p-0">
					<li><a href="/dashboard">Startseite</a></li>
					<li><a href="#">Sachbericht</a></li>
					<li class="active">Sachbericht 2015</li>
				</ul>
			</div>
	
			<!-- Page Content Start -->
			<!-- ================== -->
	
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading heading-noborder clearfix">
								<h1 class="panel-title col-lg-6">Sachbericht 2015</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
								</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<ul class="nav nav-tabs row request-order-nav">
										<li class="success-control"> 
											<a href="#success-control" data-toggle="tab" aria-expanded="true">
												<span class="hidden-xs">Erfolgskontrolle</span> 
											</a> 
										</li>
										<li class="resume"> 
											<a href="#resume" data-toggle="tab" aria-expanded="false">
												<span class="hidden-xs">Resümee und Sonstiges</span> 
											</a> 
										</li>
										<li class="statistic"> 
											<a href="#statistic" data-toggle="tab" aria-expanded="false">
												<span class="hidden-xs">Statistik</span> 
											</a> 
										</li>
									</ul>
								</div>
								<div class="tab-content order-tabs clearfix">
									<div class="tab-pane" id="success-control"> 
										<div class="panel-group panel-group-joined" id="accordion-order">
											<div class="panel panel-default"> 
												<div class="panel-heading"> 
													<h4 class="panel-title"> 
														<a data-toggle="collapse" data-parent="#accordion-order" href="#collapse-1" class="collapsed">
															Pusteblume-Grundschule (10G18)
														</a> 
													</h4> 
												</div> 
												<div id="collapse-1" class="panel-collapse collapse"> 
													<div class="panel-body">
														<img src="images/screen.gif" style="width:100%" alt="image description" />
													</div> 
												</div> 
											</div> 
											<div class="panel panel-default"> 
												<div class="panel-heading"> 
													<h4 class="panel-title"> 
														<a data-toggle="collapse" data-parent="#accordion-order" href="#collapse-2" class="collapse">
															Posteblume-Grundshule (10G18)
														</a> 
													</h4> 
												</div> 
												<div id="collapse-2" class="panel-collapse collapse in"> 
													<div class="panel-body">
														<div class="tabs-vertical-env"> 
															<ul class="nav tabs-vertical"> 
																<li class="active">
																	<a aria-expanded="true" data-toggle="tab" href="#goal-1">Entwicklungsziel 1</a>
																</li> 
																<li>
																	<a aria-expanded="false" data-toggle="tab" href="#goal-2">Entwicklungsziel 2</a>
																</li> 
																<li>
																	<a aria-expanded="false" data-toggle="tab" href="#goal-3">Entwicklungsziel 3</a>
																</li> 
																<li class="optional">
																	<a aria-expanded="false" data-toggle="tab" href="#goal-4">Entwicklungsziel 4 <span>(optional)</span></a>
																</li>
																<li class="optional">
																	<a aria-expanded="false" data-toggle="tab" href="#goal-5">Entwicklungsziel 5 <span>(optional)</span></a>
																</li> 
															</ul> 
															<div class="tab-content"> 
																<div id="goal-1" class="tab-pane active"> 
																	<div class="alert alert-warning">
																		<strong>Bereit zu überprüfen</strong>
																	</div>
																	<h4>Entwicklungsziel 1</h4>
																	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
																	<h4 class="m-t-30">Indikatoren und Zielwerte</h4>
																	<p>Formulation of indicators and targets for measuring the achievement of objectives</p>

																	<hr />

																	<div class="m-b-30">
																		<div class="btn-group btn-toggle m-r-15"> 
																			<button class="btn btn-sm btn-default">JA</button>
																			<button class="btn btn-sm active">NEIN</button>
																		</div>
																		<span>Wurde der Zielwert erreicht? Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</span>
																	</div>
																	<div class="m-b-30">
																		<div class="btn-group btn-toggle m-r-15"> 
																			<button class="btn btn-sm btn-default">JA</button>
																			<button class="btn btn-sm active">NEIN</button>
																		</div>
																		<span>Wurde der Zielwert erreicht? Ut enim ad minim veniam, quis nostrud </span>
																	</div>
																	<div class="m-b-30">
																		<div class="btn-group btn-toggle m-r-15"> 
																			<button class="btn btn-sm btn-default">JA</button>
																			<button class="btn btn-sm active">NEIN</button>
																		</div>
																		<span>Wurde der Zielwert erreicht? Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span>
																	</div>
																	<div class="m-b-30">
																		<div class="btn-group btn-toggle m-r-15"> 
																			<button class="btn btn-sm btn-default">JA</button>
																			<button class="btn btn-sm active">NEIN</button>
																		</div>
																		<span>Wurde der Zielwert erreicht? Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod </span>
																	</div>
																	<div class="m-b-30">
																		<div class="btn-group btn-toggle m-r-15"> 
																			<button class="btn btn-sm btn-default">JA</button>
																			<button class="btn btn-sm active">NEIN</button>
																		</div>
																		<span>Wurde der Zielwert erreicht? Ut enim ad minim veniam, quis nostrud </span>
																	</div>

																	<hr />

																	<div class="row">
																		<div class="block-schedule col-lg-4">
																			<strong>Ergebnis</strong><br/>
																			<strong>Das Ziel wurde erreicht</strong>
																		</div>
																		<div class="col-lg-8 text-right">
																			<span>Wurde das Ziel im Berichtszeitraum verändert?</span>
																			<div class="btn-group btn-toggle m-l-15"> 
																				<button class="btn btn-sm btn-default">JA</button>
																				<button class="btn btn-sm active">NEIN</button>
																			</div>
																		</div>
																	</div>

																	<div class="m-b-30">
																		<h4 class="m-t-40">Kurze Beschreibung der Arbeit zur Zielerreichung, Darstellung von Problemen und Entwicklungen im Hinblick auf die Umsetzung des Ziels</h4>
																		<textarea placeholder="Tragen Sie den Text hier ein here" class="form-control"></textarea>
																	</div>
																	
																	<div class="row">
																		<div class="col-lg-9">
																			<h4 class="m-t-0">Kommentare</h4>
																			<textarea placeholder="Tragen Sie den Text hier ein here" class="form-control"></textarea>
																		</div>

																		<div class="col-lg-3">
																			<div class="m-t-30 text-right pull-right">
																				<button class="btn w-lg btn-lg btn-success m-b-10">AKZEPTIEREN</button>
																				<button class="btn w-lg btn-lg btn-danger">ABLEHNEN</button>
																			</div>
																		</div>
																	</div>

																</div> 
																<div id="goal-2" class="tab-pane"> 
																	<img src="images/screen-goals.gif" width="800" alt="image description" />
																</div> 
																<div id="goal-3" class="tab-pane"> 
																	<img src="images/screen-goals.gif" width="800" alt="image description" />
																</div> 
																<div id="goal-4" class="tab-pane"> 
																	<img src="images/screen-goals.gif" width="800" alt="image description" />
																</div>
																<div id="goal-5" class="tab-pane"> 
																	<img src="images/screen-goals.gif" width="800" alt="image description" />
																</div> 
															</div> 
														</div>
														
													</div> 
												</div> 
											</div> 
											<div class="panel panel-default"> 
												<div class="panel-heading"> 
													<h4 class="panel-title"> 
														<a data-toggle="collapse" data-parent="#accordion-order" href="#collapse-3" class="collapsed">
															Posteblume-Grundshule (07G19)
														</a> 
													</h4> 
												</div> 
												<div id="collapse-3" class="panel-collapse collapse"> 
													<div class="panel-body">
														<img src="images/screen.gif" style="width:100%" alt="image description" />
													</div> 
												</div> 
											</div> 
											<div class="panel panel-default"> 
												<div class="panel-heading"> 
													<h4 class="panel-title"> 
														<a data-toggle="collapse" data-parent="#accordion-order" href="#collapse-4" class="collapsed">
															Schule am Rathaus (ISS) (11K06)
														</a> 
													</h4> 
												</div> 
												<div id="collapse-4" class="panel-collapse collapse"> 
													<div class="panel-body">
														<img src="images/screen.gif" style="width:100%" alt="image description" />
													</div> 
												</div> 
											</div>
											<div class="panel panel-default"> 
												<div class="panel-heading"> 
													<h4 class="panel-title"> 
														<a data-toggle="collapse" data-parent="#accordion-order" href="#collapse-5" class="collapsed">
															Theodor-Haubach-Schule (ISS) (07K04)
														</a> 
													</h4> 
												</div>
												<div id="collapse-5" class="panel-collapse collapse"> 
													<div class="panel-body">
														<img src="images/screen.gif" style="width:100%" alt="image description" />
													</div> 
												</div> 
											</div> 
										</div>
										<div class="form-group group-btn clearfix col-lg-12">
											<div class="col-lg-8 text-left">
												<button class="btn w-lg btn-info btn-lg">
													<i class="fa fa-rotate-left"></i>
													<span>Neu eröffnen</span>
												</button>
												<button class="btn w-lg btn-info btn-lg">Förderfähig</button>
												<button class="btn w-lg btn-info btn-lg">Genehmigt</button>
											</div>
											<div class="col-lg-4 text-right">
												<button class="btn w-lg cancel-btn btn-lg">Abbrechen</button>
												<button class="btn w-lg custom-btn btn-lg">Speichern</button>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="resume"> 
										<div class="panel-group panel-group-joined" id="accordion-concepts">
											<div class="panel panel-default"> 
												<div class="panel-heading"> 
													<h4 class="panel-title"> 
														<a data-toggle="collapse" data-parent="#accordion-concepts" href="#collapse-001" class="collapsed">
															Pusteblume-Grundschule (10G18)
														</a> 
													</h4> 
												</div> 
												<div id="collapse-001" class="panel-collapse collapse"> 
													<div class="panel-body">
														
													</div> 
												</div> 
											</div> 
											<div class="panel panel-default"> 
												<div class="panel-heading"> 
													<h4 class="panel-title"> 
														<a data-toggle="collapse" data-parent="#accordion-concepts" href="#collapse-002" class="collapse">
															Paul-Simmel-Grundschule (07G19)
															<div class="btn-group btn-toggle pull-right tabs-toggle"> 
																<button data-tab="tab-data" class="btn btn-sm active">DATEN</button>
																<button data-tab="tab-history" class="btn btn-sm btn-default">VERLAUF</button>
															</div>
														</a> 
													</h4> 
												</div> 
												<div id="collapse-002" class="panel-collapse collapse in"> 
													<div class="panel-body">
														<div id="tab-data" class="block-concept current">
															<div class="alert alert-danger">
							                                    Ablehnen
							                                </div>
							                                <form action="#">
						                                		<div class="form-group">
						                                			<label>Positive Entwicklungen</label>
						                                			<textarea class="form-control custom-height" placeholder="Tragen Sie den Text hier ein"></textarea>
						                                		</div>
						                                		<div class="form-group">
						                                			<label>Herausforderungen</label>
						                                			<textarea class="form-control custom-height" placeholder="Tragen Sie den Text hier ein"></textarea>
						                                		</div>
						                                		<div class="form-group m-b-30">
						                                			<label>Sonstiges I</label>
						                                			<textarea class="form-control custom-height" placeholder="Tragen Sie den Text hier ein"></textarea>
						                                		</div>
						                                		<div class="form-group">
						                                			<h4>Sonstiges II</h4>
						                                			<p>Folgende Themen spielten im Berichtszeitraum eine besondere Rolle</p>
						                                		</div>
																<hr />

																<div class="form-group">
						                                			<div class="m-b-15">
						                                				<label>Display topic 1</label>
						                                				<div class="btn-group btn-toggle m-l-15"> 
																			<button class="btn btn-sm btn-default">JA</button>
																			<button class="btn btn-sm active">NEIN</button>
																		</div>
						                                			</div>
						                                			<textarea class="form-control custom-height" placeholder="Tragen Sie den Text hier ein"></textarea>
						                                		</div>
						                                		<div class="form-group">
						                                			<div class="m-b-15">
						                                				<label>Display topic 2</label>
						                                				<div class="btn-group btn-toggle m-l-15"> 
																			<button class="btn btn-sm btn-default">JA</button>
																			<button class="btn btn-sm active">NEIN</button>
																		</div>
						                                			</div>
						                                			<textarea class="form-control custom-height" placeholder="Tragen Sie den Text hier ein"></textarea>
						                                		</div>
						                                		<div class="form-group">
						                                			<div class="m-b-15">
						                                				<label>Display topic 3</label>
						                                				<div class="btn-group btn-toggle m-l-15"> 
																			<button class="btn btn-sm btn-default">JA</button>
																			<button class="btn btn-sm active">NEIN</button>
																		</div>
						                                			</div>
						                                			<textarea class="form-control custom-height" placeholder="Tragen Sie den Text hier ein"></textarea>
						                                		</div>
						                                		<hr />	
																<div class="row">
																	<div class="col-lg-10">
																		<h4 class="m-t-0">Kommentare</h4>
																		<textarea placeholder="Tragen Sie den Text hier ein" class="form-control comments"></textarea>
																	</div>
															
																	<div class="col-lg-2">
																		<div class="m-t-30 text-right pull-right">
																			<button class="btn w-lg btn-lg btn-success m-b-10 disabled">AKZEPTIEREN</button>
																			<button class="btn w-lg btn-lg btn-danger disabled">ABLEHNEN</button>
																		</div>
																	</div>
																</div>
															</form>
														</div>
														<div id="tab-history" class="block-concept">
															<div class="alert alert-success">
							                                    <strong class="status-history">Genehmigt</strong>
							                                    <span class="check-history">Überpüft von Mustermann 15.12.2015</span>
							                                </div>
							                                <div class="alert alert-warning">
							                                    <strong class="status-history">Bereit zu überprüfen</strong>
							                                    <span class="check-history">Überpüft von Mustermann 13.12.2015</span>
							                                </div>
															<div class="changes-content">
																<div class="heading-changes">
																	Inhaltsveränderungen
																	<i class="ion-chevron-down arrow-box"></i>
																</div>
																<div class="content-changes">
																	<div class="thead">
																		<div class="col-lg-4">
																			<strong>Veränderungen</strong>
																			<span>Bearbeitet von Mustermann am 11.12.2015</span>
																		</div>
																		<div class="col-lg-4">
																			Früher
																		</div>
																		<div class="col-lg-4">
																			Nachher
																		</div>
																	</div>
																	<div class="row-holder">
																		<div class="custom-row">
																			<div class="col-lg-4 ">
																				<strong>Kontoinhaber</strong>
																			</div>
																			<div class="col-lg-4">
																				<dl class="custom-dl">
																					<dt></dt>
																					<dd>Herr Mustermann</dd>
																				</dl>
																			</div>
																			<div class="col-lg-4">
																				<dl class="custom-dl">
																					<dt></dt>
																					<dd>Frau Schmidt</dd>
																				</dl>
																			</div>
																		</div>
																	</div>
																	<div class="thead">
																		<div class="col-lg-4">
																			<strong>Veränderungen</strong>
																			<span>Bearbeitet von Mustermann am 11.12.2015</span>
																		</div>
																		<div class="col-lg-4">
																			Früher
																		</div>
																		<div class="col-lg-4">
																			Nachher
																		</div>
																	</div>
																	<div class="row-holder">
																		<div class="custom-row">
																			<div class="col-lg-4 ">
																				<strong>Situation in der Schule</strong>
																				<div class="btn-row m-t-10">
																					<button class="btn w-xs" data-target="#modal-1" data-toggle="modal">
																						<span>Vergleichen</span>
																						<i class="ion-arrow-swap"></i>
																					</button>
																				</div>
																			</div>
																			<div class="col-lg-4">
																				...  labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem enim ad ...
																			</div>
																			<div class="col-lg-4">
																				...  labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat . Ut enim ad minim ...
																			</div>
																		</div>
																		<div class="custom-row">
																			<div class="col-lg-4">
																				<strong>Gesundheitsförderung</strong>
																			</div>
																			<div class="col-lg-4">
																				<dl class="custom-dl">
																					<dt></dt>
																					<dd>Kein Ziel</dd>
																				</dl>
																			</div>
																			<div class="col-lg-4">
																				<dl class="custom-dl">
																					<dt></dt>
																					<dd>Weiteres Ziel</dd>
																				</dl>
																			</div>
																		</div>
																		<div class="custom-row">
																			<div class="col-lg-4 ">
																				<strong>Kontoinhaber</strong>
																			</div>
																			<div class="col-lg-4">
																				<dl class="custom-dl">
																					<dt></dt>
																					<dd>Herr Mustermann</dd>
																				</dl>
																			</div>
																			<div class="col-lg-4">
																				<dl class="custom-dl">
																					<dt></dt>
																					<dd>Herr Mustermann</dd>
																				</dl>
																			</div>
																		</div>
																	</div>
																	<div class="thead">
																		<div class="col-lg-4">
																			<strong>Veränderungen</strong>
																			<span>Bearbeitet von Mustermann am 11.12.2015</span>
																		</div>
																		<div class="col-lg-4">
																			Früher
																		</div>
																		<div class="col-lg-4">
																			Nachher
																		</div>
																	</div>
																	<div class="row-holder">
																		<div class="custom-row">
																			<div class="col-lg-4 ">
																				<strong>Vorname</strong>
																			</div>
																			<div class="col-lg-4">
																				<dl class="custom-dl">
																					<dt></dt>
																					<dd>Dohn</dd>
																				</dl>
																			</div>
																			<div class="col-lg-4">
																				<dl class="custom-dl">
																					<dt></dt>
																					<dd>Frau Schmidt</dd>
																				</dl>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
							                                <div class="alert alert-danger">
							                                    <strong class="status-history">Ablehnen</strong>
							                                    <span class="check-history">Überpüft von Mustermann 13.12.2015</span>
							                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							                                </div>
							                                 <div class="alert alert-warning">
							                                    <strong class="status-history">Bereit zu überprüfen</strong>
							                                    <span class="check-history">Überpüft von Mustermann 13.12.2015</span>
							                                </div>
														</div>
													</div> 
												</div>
											</div> 
											<div class="panel panel-default"> 
												<div class="panel-heading"> 
													<h4 class="panel-title"> 
														<a data-toggle="collapse" data-parent="#accordion-concepts" href="#collapse-003" class="collapsed">
															Schule am Rathaus (ISS) (11K06)
														</a> 
													</h4> 
												</div> 
												<div id="collapse-003" class="panel-collapse collapse"> 
													<div class="panel-body">
														
													</div> 
												</div> 
											</div>
											<div class="panel panel-default"> 
												<div class="panel-heading"> 
													<h4 class="panel-title"> 
														<a data-toggle="collapse" data-parent="#accordion-concepts" href="#collapse-004" class="collapsed">
															Theodor-Haubach-Schule (ISS) (07K04)
														</a> 
													</h4> 
												</div>
												<div id="collapse-004" class="panel-collapse collapse"> 
													<div class="panel-body">
														
													</div> 
												</div> 
											</div> 
										</div>
										 <div class="form-group group-btn clearfix col-lg-12">
											<div class="col-lg-8 text-left">
												<button class="btn w-lg btn-info btn-lg">
													<i class="fa fa-rotate-left"></i>
													<span>Neu eröffnen</span>
												</button>
												<button class="btn w-lg btn-info btn-lg">Förderfähig</button>
												<button class="btn w-lg btn-info btn-lg">Genehmigt</button>
											</div>
											<div class="col-lg-4 text-right">
												<button class="btn w-lg cancel-btn btn-lg">Abbrechen</button>
												<button class="btn w-lg custom-btn btn-lg">Speichern</button>
											</div>
										</div>
									</div>
									
									<div class="tab-pane" id="statistic"> 
										<div class="panel-group panel-group-joined m-0">
											<div class="panel panel-default"> 
												<div class="clearfix">
													<h2 class="panel-title title-custom pull-left"> 
														Statistic 
													</h2>
												</div>
												<hr />
												<div class="panel-body p-t-0">
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- End Row -->
		</div>
			

		<!-- Page Content Ends -->
		<!-- ================== -->
		<?php include('templates/footer.php'); ?>

<!--Compare -->

		<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-width-full">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Vergleichen</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						<div class="heading-compare">
							<strong>Veränderungen</strong>
							<span>Bearbeitet von Mustermann am 09.12.2015</span>
							<p>Bereich: <strong>Situation at the school</strong></p>
						</div>
						<hr />
						<div class="row compare-box">
							<div class="col-lg-6">
								<strong class="title">Früher</strong>
								<div class="ready">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
								<div class="no-status">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
								<div class="decline">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
								<div class="no-status">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
								<div class="approve">
									
								</div>
							</div>
							<div class="col-lg-6">
								<strong class="title">Nachher</strong>
								<div class="ready">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
								<div class="no-status">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
								<div class="decline">
									
								</div>
								<div class="no-status">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
								<div class="approve">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
								</div>
							</div>
						</div>
						<hr />
					</div>
					<div class="row">
						<div class="form-group group-btn">
							<div class="col-lg-12">
								<button class="btn w-lg custom-btn pull-right" data-dismiss="modal">SCHLIEßEN</button>
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
						<h3 class="m-0 pull-left">Datum ändern</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body text-center">
						<div class="form-group m-t-30">
							<div class="holder-datepicker text-right">
								<div class="col-lg-2 p-0">
									<label>Beginn</label>
								</div>
								<div class="col-lg-3 p-0">
									<div class="input-group">
	                                    <input type="text" class="form-control datepicker" placeholder="dd/mm/yyyy">
	                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
	                                </div>
								</div>
                                <div class="col-lg-2 p-0">
                                	<label>Ende</label>
                                </div>
                                <div class="col-lg-3 p-0">
                                	<div class="input-group">
                                	    <input type="text" class="form-control datepicker" placeholder="dd/mm/yyyy">
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

<!--End Compare -->
		<div class="md-overlay"></div>
		
		<?php include('templates/scripts.php'); ?>

		<script type="text/javascript">

			jQuery(window).load(function() {
				// Swicher button	
				jQuery('.btn-toggle').click(function(){
				  	$(this).find(".btn").toggleClass('active');
				    $(this).find(".btn").toggleClass('btn-default');
				    return false;
				})

				$('#finance #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{ className:"input-cell", "width": "10%", "targets": 2 },
						{ className:"rate-cell", "targets": 1 }
					]
				});

				$('.tabs-toggle button').click(function(){
					var tab_id = $(this).attr('data-tab');
					$('.block-concept').removeClass('current');
					$("#"+tab_id).addClass('current');
				})

				$('.changes-content .heading-changes').click(function(){
					$(this).toggleClass('open');
					$(this).next().slideToggle();
				})

			});
		

		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>