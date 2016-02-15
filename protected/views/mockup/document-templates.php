<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Dokumentvorlage | SPIder</title>
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
					<li class="active">Dokumentvorlage</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Dokumentvorlage</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken<i class="ion-printer"></i></a>
									<button class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Neues Dokument</button>
								</div>
							</div>
							<div class="panel-body edit-user doc-template">
								<div class="row">
									<div class="col-lg-12">
										<div class="row datafilter">
											<form action="#" class="class-form">
												<div class="col-lg-5">
													<div class="form-group">
														<label>Suche nach Namen und Typ</label>
														<input type="search" class="form-control" placeholder="Eingegeben">
													</div>
												</div>
												<div class="col-lg-5">
													<div class="form-group">
														<label>Typ</label>
														<select class="type-user form-control">
															<option>Alles anzeigen</option>
															<option>Typ 1</option>
															<option>Typ 2</option>
															<option>Typ 3</option>
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
													<th>Typ</th>
													<th>Letzte Änd.</th>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
														<a class="btn document" href="view-document.php"><i class="ion-document-text" title="Ansicht"></i></a>
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
						<h3 class="m-0 pull-left">Vorlage bearbeiten - FV_2013_Sonderkündigung</h3>
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
											<div class="col-lg-7">
												<input class="form-control" type="text" value="FV_2013_Sonderkündigung">
											</div>
											<label class="col-lg-1 control-label label-type">Typ</label>
											<div class="col-lg-3">
												<select class="form-control">
													<option>Typ 1</option>
													<option>Typ 2</option>
													<option>Typ 3</option>
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
													<td>KENNZIFFER</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </td>
												</tr>
												<tr>
													<td>TRAEGER</td>
													<td>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</td>
												</tr>
												<tr>
													<td>ZEITRAUM</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </td>
												</tr>
												<tr>
													<td>FOERDERSUMME</td>
													<td>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </td>
												</tr>
												<tr>
													<td>AUFLAGEN</td>
													<td>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</td>
												</tr>
												<tr>
													<td>KONTONUMMER</td>
													<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </td>
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