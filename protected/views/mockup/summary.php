<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title>Finanzübersicht | SPIder</title>
		<?php include('templates/head.php'); ?>
	</head>

	<body class="summary-page">
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
					<li class="active">Finanzübersicht</li>
				</ul>
			</div>
			
			<!-- Page Content Start -->
			<!-- ================== -->
			
			<div class="wraper container-fluid">
				<div class="row">
					<div class="container center-block">
						<div class="panel panel-default">
							<div class="panel-heading clearfix">
								<h1 class="panel-title col-lg-6">Finanzübersicht</h1>
								<div class="pull-right heading-box-print">
									<a href="javascript:window.print()">Drucken <i class="ion-printer"></i></a>
								</div>
							</div>
							<div class="panel-body summary-user">
								<div class="row">
									<div class="col-lg-12">
										<div class="row datafilter">
											<form action="#" class="class-form">
												<div class="col-lg-5">
													<div class="form-group">
														<label>Suche nach Kennz.</label>
														<input type="search" class="form-control" placeholder="Eingegeben">
													</div>
												</div>
												<div class="col-lg-3">
													<div class="form-group">
														<label>Finanzierung</label>
														<select class="type-user form-control">
															<option>Alles anzeigen</option>
															<option>2016_LM</option>
														</select>
													</div>
												</div>
												<div class="col-lg-2">
													<div class="form-group">
														<label>Jahr</label>
														<select class="type-user form-control">
															<option>Aktuell</option>
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
													<th>Kennz.</th>
													<th>Finanzierung</th>
													<th>Jahr</th>
													<th class="total-th"><span></span>Förders.</th>
													<th class="requested-th"><span></span>Angefordert</th>
													<th class="income-th"><span></span>Ausgezahlt</th>
													<th class="spent-th"><span></span>Ausgegeben</th>
													<th class="refund-th"><span></span>Rückgezahlt</th>
													<th class="expenditure-th"><span></span>Verblieben</th>
													<th>Mittelabrufe /<br/> Belege</th>
												</tr>
											</thead>
			
											<tbody>
												<tr>
													<td><a href="#">B010</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 39,749.98</td>
													<td>€ 6,624.00</td>
													<td>€ 26,499.91</td>
													<td>€ 8,743.00</td>
													<td></td>
													<td>€ 6,624.98</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">K034</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 54,860.00</td>
													<td></td>
													<td>€ 36,573.33</td>
													<td>€ 6,733.00</td>
													<td></td>
													<td>€ 18,286.67</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">Z014</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 46,613.86</td>
													<td>€ 7,768.98</td>
													<td>€ 31,075.91</td>
													<td>€ 17,623.00</td>
													<td></td>
													<td>€ 7,768.98</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">G085</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 76,168.48</td>
													<td></td>
													<td>€ 50,778.99</td>
													<td>€ 0.00</td>
													<td></td>
													<td>€ 25,389.49</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">Z021</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 68,776.54</td>
													<td></td>
													<td>€ 45,851.03</td>
													<td>€ 1,225.00</td>
													<td></td>
													<td>€ 22,925.51</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">G044</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 7,633.44</td>
													<td></td>
													<td>€ 5,088.96</td>
													<td>€ 544.00</td>
													<td></td>
													<td>€ 2,544.48</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">BG058</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 31,637.43</td>
													<td></td>
													<td>€ 21,098.62</td>
													<td>€ 0.00</td>
													<td>€ 100.00</td>
													<td>€ 10,545.81</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">G075</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 98,763.86</td>
													<td></td>
													<td>€ 65,842.57</td>
													<td>€ 50,000.00</td>
													<td></td>
													<td>€ 32,921.29</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">G061</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 53,647.42</td>
													<td></td>
													<td>€ 35,764.95</td>
													<td>€ 0.00</td>
													<td></td>
													<td>€ 17,882.47</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">G052</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 87,443.54</td>
													<td></td>
													<td>€ 58,295.69</td>
													<td>€ 1,000.00</td>
													<td>€ 100.00</td>
													<td>€ 29,147.85</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">K024</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 54,687.45</td>
													<td>€ 9,114.58</td>
													<td>€ 36,458.30</td>
													<td>€ 0.00</td>
													<td></td>
													<td>€ 9,114.58</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tr>
													<td><a href="#">K037</a></td>
													<td>2016_LM</td>
													<td>2016</td>
													<td>€ 18,676.35</td>
													<td></td>
													<td>€ 12,450.90</td>
													<td>€ 0.00</td>
													<td>445.33</td>
													<td>€ 6,225.45</td>
													<td>
														<a href="financial-request.php" class="btn requsted-btn" title="Mittelabrufe">
															<span></span>
														</a>
														<a href="finance-report.php" class="btn requsted-btn" title="Belege">
															<span></span>
														</a>
													</td>
												</tr>
												<tfoot>
													<tr>
													    <th></th>
														<th></th>
														<th></th>
														<th>€ 638,658.23</th>
														<th>€ 23,508.53</th>
														<th>€ 425,772.15</th>
														<th>€ 143,163.69</th>
														<th>€ 645.33</th>
														<th>€ 189,377.55</th>
														<th></th>
													</tr>
												</tfoot>
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

		<div class="md-overlay"></div>
		

		<?php include('templates/scripts.php'); ?>

		<script type="text/javascript">

			jQuery(window).load(function() {

				var table = $('.summary-user #datatable').DataTable({
					"paging":   false,
			        "info":     false,
			        "columnDefs": [
			        	{ className:"align-right", "targets": [3, 4, 5, 6, 7, 8] },
			        	{ className:"dt-edit", "targets": [9] },
			        	{ "width": "9%", "targets": [3] }
			        ],
			         "createdRow": function ( row, data, index ) {
			            $('td', row).eq(4).addClass('highlight');
			            $('td', row).eq(5).addClass('highlight');
			            $('td', row).eq(6).addClass('highlight');
			        }

				});
			});


		
		</script>
		<?php include('templates/edit-user.php'); ?>
	</body>
</html>