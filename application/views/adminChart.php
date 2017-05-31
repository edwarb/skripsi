<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic|Play+Fair:700" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/dark.css" type="text/css" />
	<link rel="stylesheet" href="css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="css/animate.css" type="text/css" />
	<link rel="stylesheet" href="css/magnific-popup.css" type="text/css" />

	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="css/components/bs-datatable.css" type="text/css" />

	<link rel="stylesheet" href="css/responsive.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />



	<!-- Document Title
	============================================= -->
	<title>Data Tables | Canvas</title>

</head>
<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">


		<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>Halaman Pengujian</h1>
				<ol class="breadcrumb">
					<li><a href="#">Admin</a></li>
					<li><a href="#">Shortcodes</a></li>
					<li class="active">Data Tables</li>
				</ol>
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">
					<!-- tabel data latih -->
					<h3> Data Latih </h3>
					<div class="table-responsive">
						<table id="datatable-latih" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<?php foreach($allData[0] as $key=> $value) {?>
									<th><?php echo $key; ?></th>
									<?php }?>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<?php foreach($allData[0] as $key=> $value) {?>
										<th><?php echo $key; ?></th>
									<?php }?>
								</tr>
							</tfoot>
							<tbody>
								<?php foreach($allData as $key=> $row) {?>
								<tr >
									<?php foreach($row as $i=>$value){?>
										<td><?php echo $value; ?></td>
									<?php }?>
								</tr>
								<?php } ?>
						</table>
					</div>
					<!--tabel data latih end-->

					<!-- tabel data Uji -->
					<h3> Data Uji </h3>
					<div class="table-responsive">
						<table id="datatable-uji" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<?php foreach($dataUji[0] as $key=> $value) {?>
									<th><?php echo $key; ?></th>
									<?php }?>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<?php foreach($dataUji[0] as $key=> $value) {?>
										<th><?php echo $key; ?></th>
									<?php }?>
								</tr>
							</tfoot>
							<tbody>
								<?php foreach($dataUji as $key=> $row) {?>
								<tr >
									<?php foreach($row as $i=>$value){?>
										<td><?php echo $value; ?></td>
									<?php }?>
								</tr>
								<?php } ?>
						</table>
					</div>
					<!--tabel data Uji end-->

					<!--tab kontainer-->
					<div class="tabs tabs-bb clearfix" id="tab-9">

						<ul class="tab-nav clearfix">
							<li><a href="#tabs-33"> Mean</a></li>
							<li><a href="#tabs-34">Mean Corrected</a></li>
							<li><a href="#tabs-35">Kovarian</a></li>
							<li> <a href="#tabs-36">FN LDA</a></li>
						</ul>

						<div class="tab-container">

							<div class="tab-content clearfix" id="tabs-33">
								<!-- tabel rata-rata kelas -->
								<h3> Rata-Rata Kelas </h3>
								<div class="table-responsive">
									<table id="datatable-ratarata" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th> Jenis </th>
												<?php foreach($stringKey as $key=> $value) {?>
												<th><?php echo $value; ?></th>
												<?php }?>
											</tr>
										</thead>
										
										<tbody>
											<?php foreach($ratarata as $key=> $row) {?>
											<tr >
												<td> <?php echo $jenis[$key] ?> </td>
												<?php foreach($row as $i=>$value){?>
													<td><?php echo $value; ?></td>
												<?php }?>
											</tr>
											<?php } ?>
											<tr>
												<td> Mean Global </td>
												<?php foreach($meanGlobal as $key=>$value) {?>
												<td>
													<?php echo $value; ?>
												</td>
												<?php }?>
											</tr>
									</table>
								</div>
								<!--tabel data ratarata end-->
							</div>
							<div class="tab-content clearfix" id="tabs-34">
								<?php foreach($meanCorrected as $key=>$row) {?>
								<!-- tabel mean-corrected kelas -->
								<h3> Mean Corrected <?php echo $jenis[$key] ?> </h3>
								<div class="table-responsive">
									<table id="datatable-mean<?php echo $key ?>" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th> No </th>
												<?php foreach($stringKey as $key=> $value) {?>
												<th><?php echo $value; ?></th>
												<?php }?>
											</tr>
										</thead>
										
										<tbody>
											<?php foreach($row as $key2=> $row2) {?>
											<tr >
												<td> <?php echo $key2 ?> </td>
												<?php foreach($row2 as $i=>$value){?>
													<td><?php echo $value; ?></td>
												<?php }?>
											</tr>
											<?php } ?>
									</table>
								</div>
								<!--tabel data mean-corrected end-->
								<?php } ?>
							</div>
							<div class="tab-content clearfix" id="tabs-35">
								<!-- tabel kovarian kelas -->
								<h3> Tabel Kovarian </h3>
								<div class="table-responsive">
									<table id="datatable-kovarian" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th> No </th>
												<?php foreach($stringKey as $key=> $value) {?>
												<th><?php echo $value; ?></th>
												<?php }?>
											</tr>
										</thead>
										
										<tbody>
											<?php foreach($kovarianTotal as $key2=> $row2) {?>
											<tr >
												<td> <?php echo $key2 ?> </td>
												<?php foreach($row2 as $i=>$value){?>
													<td><?php echo $value; ?></td>
												<?php }?>
											</tr>
											<?php } ?>
									</table>
								</div>
								<!--tabel data kovarian end-->

								<!-- tabel kovarian inverse kelas -->
								<h3> Tabel Kovarian Inverse</h3>
								<div class="table-responsive">
									<table id="datatable-inverse" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th> No </th>
												<?php foreach($stringKey as $key=> $value) {?>
												<th><?php echo $value; ?></th>
												<?php }?>
											</tr>
										</thead>
										
										<tbody>
											<?php foreach($kovarianInverse as $key2=> $row2) {?>
											<tr >
												<td> <?php echo $key2 ?> </td>
												<?php foreach($row2 as $i=>$value){?>
													<td><?php echo $value; ?></td>
												<?php }?>
											</tr>
											<?php } ?>
									</table>
								</div>
								<!--tabel data kovarian inverse end-->
							</div>
							<div class="tab-content clearfix" id="tabs-36">
								<!-- tabel FN LDA kelas -->
								<h3> Tabel FN LDA</h3>
								<div class="table-responsive">
									<table id="datatable-fn" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th> No </th>
												<?php foreach($jenis as $key=> $value) {?>
												<th><?php echo $value; ?></th>
												<?php }?>
											</tr>
										</thead>
										
										<tbody>
											<?php foreach($fnKelas as $key2=>$row2) {?>
											<tr >
												<td> <?php echo ($key2+1) ?> </td>
												<?php foreach($row2 as $i=>$value){?>
													<td><?php echo $value; ?></td>
												<?php }?>
											</tr>
											<?php } ?>
									</table>
								</div>
								<!--tabel data FN LDA end-->

								<!-- tabel Akurasi  kelas -->
								<h3> Tabel Akurasi</h3>
								<div class="table-responsive">
									<table id="datatable-akurasi" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th> No </th>
												<th> Sistem </th>
												<th> Pakar </th>
												<th> Akurasi </th>
											</tr>
										</thead>
										
										<tbody>
											<?php foreach($pakar as $key2=>$row2) {?>
											<tr >
												<td> <?php echo ($key2+1) ?> </td>
												<td><?php echo $jenis[$rankMax[$key2]]; ?></td>
												<td><?php echo $jenis[$row2]; ?></td>
												<td><?php echo ($rankMax[$key2] == $row2) ?  'Ya' : 'Tidak'; ?></td>
											</tr>
											<?php } ?>
									</table>
								</div>
								<!--tabel data akurasi end-->

								<h3> Akurasi Data = <?php echo $nilaiAkurasi ?> % </h3>
							</div>

						</div>

					</div>
					<!--tab kontainer end-->
				</div>
				
			</div>

		</section><!-- #content end -->


	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>



<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/plugins.js"></script>

	<!-- Bootstrap Data Table Plugin -->
	<script type="text/javascript" src="js/components/bs-datatable.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="js/functions.js"></script>

	<script>

		$(document).ready(function() {
			$('#datatable-latih').dataTable({
			})
			$('#datatable-uji').dataTable({
			})
			$('#datatable-mean0').dataTable({
			})
			$('#datatable-mean1').dataTable({
			})
			$('#datatable-mean2').dataTable({
			})
			$('#datatable-mean3').dataTable({
			})
			$('#datatable-kovarian').dataTable({
			})
			$('#datatable-inverse').dataTable({
			})
			$('#datatable-fn').dataTable({
			})
			$('#datatable-akurasi').dataTable({
			})
			$('#datatable-ratarata').dataTable({
				paging: false
			})
			$('#datatable1').dataTable({
				searching: false,
				paging: false,
				info: false
			})
		});

	</script>
</body>