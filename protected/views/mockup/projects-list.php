<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Projekte | SPIder</title>
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
					<li><a href="/dashboard">Home</a></li>
					<li class="active">Projekte</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Projekte</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
									<button <?php $this->demo(); ?>  class="btn w-lg custom-btn" data-target="#modal-2" data-toggle="modal">Projekt hinzufügen</button>
								</div>
							</div>
							<div class="panel-body edit-user">
								<div class="row">
									<div class="col-lg-12">
										<div class="row datafilter">
											<form action="#" class="class-form">
												<div class="col-lg-3 col-width-type">
													<div class="form-group">
														<label>Suche nach Kennziffer</label>
														<input type="search" class="form-control" placeholder="Stichwort eingegeben">
													</div>
												</div>
												<div class="col-lg-2 col-width-type">
													<div class="form-group">
														<label>Schultyp</label>
														<select class="type-user form-control">
															<option>Alles anzeigen</option>
														</select>
													</div>
												</div>
												<div class="col-lg-2">
													<div class="form-group">
														<label>Träger</label>
														<select class="type-user form-control">
															<option>Alles anzeigen</option>
														</select>
													</div>
												</div>
												<div class="col-lg-2">
													<div class="form-group">
														<label>Schule</label>
														<select class="type-user form-control">
															<option>Alles anzeigen</option>
														</select>
													</div>
												</div>
												<div class="col-lg-2 col-width-type">
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
													<th>Kennziffer</th>
													<th>Schule</th>
													<th>Träger</th>
													<th>Bezirk</th>
													<th>Bearbeiten</th>
												</tr>
											</thead>
			
											<tbody>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">B026</a></td>
													<td><a href="schools#id=4">Pestalozzi-Schule (06S01)</a></td>
													<td><a href="performers#id=2">Träger Nachbarschaftsheim Schöneberg e.V.</a></td>
													<td class="custom-data"><a href="districts#id=1">Bezirk Neukolln</a></td>
													<td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">B053</a></td>
													<td><a href="schools#id=4">Pestalozzi-Schule (06S01)</a></td>
													<td><a href="performers#id=2">JAO gGmbH</a></td>
													<td class="custom-data"><a href="districts#id=1">Bezirk Pankow</a></td>
													 <td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">Z026</a></td>
													<td class="custom-data"><a href="schools#id=4">Lina Morgenstern (02K04)</a></td>
													<td><a href="performers#id=2">Horizonte gGmbH</a></td>
													<td><a href="districts#id=1">Lina Morgenstern</a></td>
													 <td>
													 	<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">G053</a></td>
													<td><a href="schools#id=4">Solling-Schule (ISS) (07K05)</a></td>
													<td><a href="performers#id=2">LebensWelt</a></td>
													<td><a href="districts#id=1">Bezirk Neukolln</a></td>
													 <td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">B026</a></td>
													<td><a href="schools#id=4">Solling-Schule (ISS) (07K05)</a></td>
													<td><a href="performers#id=2">JAO gGmbH</a></td>
													<td class="custom-data"><a href="districts#id=1">Bezirk Neukolln</a></td>
													 <td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">S053</a></td>
													<td><a href="schools#id=4">Biesalski-Schule (06S02)</a></td>
													<td><a href="performers#id=2">AWO Südost</a></td>
													<td><a href="districts#id=1">Bezirk Pankow</a></td>
													 <td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">K026</a></td>
													<td><a href="schools#id=4">Biesalski-Schule (06S02)</a></td>
													<td><a href="performers#id=2">Arbeit und Bildung e.V.</a></td>
													<td><a href="districts#id=1">Bezirk Pankow</a></td>
													 <td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">Z053</a></td>
													<td class="custom-data"><a href="schools#id=4">Biesalski-Schule (06S02)</a></td>
													<td><a href="performers#id=2">Stadtteilzentrum Steglitz e.V.</a></td>
													<td><a href="districts#id=1">Bezirk Neukolln</a></td>
													 <td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">K026</a></td>
													<td><a href="schools#id=4">Biesalski-Schule (06S02)</a></td>
													<td><a href="performers#id=2">gss Schulpartner GmbH</a></td>
													<td><a href="districts#id=1">Bezirk Pankow</a></td>
													 <td>
														<a class="btn center-block edit-btn" data-target="#modal-1" data-toggle="modal" title="Bearbeiten">
															<i class="ion-edit"></i>
														</a>
													</td>
												</tr>
												<tr>
													<td><a data-target="#modal-1" data-toggle="modal" href="#">S053</a></td>
													<td>
														<a href="schools#id=4">Solling-Schule (ISS) (07K05)</a><br/>
														<a href="schools#id=4">Pestalozzi-Schule (06S01)</a><br/>
														<a href="schools#id=4">Biesalski-Schule (06S02)</a>
													</td>
													<td><a href="performers#id=2">LebensWelt</a></td>
													<td><a href="districts#id=1">Bezirk Pankow</a></td>
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

<!--Add Projects -->

		<div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
           
            <div class="modal-dialog project-modal custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Projekt bearbeiten﻿</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="row">
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Kennziffer</label>
									<div class="col-lg-4">
										<input class="form-control" type="text" value="">
									</div>
									<label class="col-lg-2 control-label">Schultyp</label>
									<div class="col-lg-4">
										<select class="form-control">
											<option>S (Förderschulen)</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Programm</label>
									<div class="col-lg-10">
										<select class="form-control">
											<option>Schulsozialarbeit</option>
											<option>Zusatzprogramm A</option>
											<option>Zusatzprogramm B</option>
											<option>Bonusprogramm</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Fördertopf</label>
									<div class="col-lg-10">
										<select class="form-control">
											<option>LM</option>
											<option>BP</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label p-r-0">Träger</label>
									<div class="col-lg-10">
										<select class="form-control">
											<option>Stadtteilzentrum Steglitz e.V.</option>
											<option>Arbeit und Bildung e.V.</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Bezirk</label>
									<div class="col-lg-10">
										<select class="form-control">
											<option>Bezirk Neukolln</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Schule</label>
									<div class="col-lg-10">
										<select class="select2" multiple data-placeholder="Schule">
											<option>Solling-Schule (ISS) (07K05)</option>
											<option>Lina Morgenstern (02)</option>
											<option>Isaac-Newton-Schule (09K04)</option>
										</select>
									</div>
								</div>
								
							</div>
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
				</div>
				
			</div>
		
		</div>

<!--End Add Projects -->

<!--Edit Projects -->

		<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog project-modal custom-width">
				<div class="panel panel-color panel-primary">
					<div class="panel-heading clearfix"> 
						<h3 class="m-0 pull-left">Projekt bearbeiten﻿</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="ion-close-round "></i></button>
					</div>
					<div class="panel-body">
						<form role="form" class="form-horizontal">
							<div class="row">
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Kennziffer</label>
									<div class="col-lg-4">
										<input class="form-control" type="text" value="S001">
									</div>
									<label class="col-lg-2 control-label">Schultyp</label>
									<div class="col-lg-4">
										<select class="form-control">
											<option>S (Förderschulen)</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Programm</label>
									<div class="col-lg-10">
										<select class="form-control">
											<option>Schulsozialarbeit</option>
											<option>Zusatzprogramm A</option>
											<option>Zusatzprogramm B</option>
											<option>Bonusprogramm</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Fördertopf</label>
									<div class="col-lg-10">
										<input class="form-control" type="text" value="BP" readonly>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label p-r-0">Träger</label>
									<div class="col-lg-10">
										<select class="form-control">
											<option>Stadtteilzentrum Steglitz e.V.</option>
											<option>Arbeit und Bildung e.V.</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Bezirk</label>
									<div class="col-lg-10">
										<select class="form-control">
											<option>Bezirk Neukolln</option>
										</select>
									</div>
								</div>
								<div class="m-b-15 clearfix">
									<label class="col-lg-2 control-label">Schule</label>
									<div class="col-lg-10">
										<select class="select2" multiple data-placeholder="Schule">
											<option>Solling-Schule (ISS) (07K05)</option>
											<option>Lina Morgenstern (02)</option>
											<option>Isaac-Newton-Schule (09K04)</option>
										</select>
									</div>
								</div>
								
							</div>
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
				</div>
				
			</div>
		</div>

<!--End Edit Projects -->

		<div class="md-overlay"></div>
		

		<?php include('templates/scripts.php'); ?>

		<script type="text/javascript">

			jQuery(window).load(function() {

				jQuery(".select2").select2();

				var table = $('.edit-user #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
						{ className:"dt-edit", "orderable": false, "targets": 4 }
					]
				});

			});
		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>