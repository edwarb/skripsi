<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic|Play+Fair:700" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>css/dark.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>css/animate.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>css/magnific-popup.css" type="text/css" />

	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="<?php echo base_url() ?>css/components/bs-datatable.css" type="text/css" />

	<link rel="stylesheet" href="<?php echo base_url() ?>css/responsive.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />



	<!-- Document Title
	============================================= -->
	<title>Autis LDA | Pengujian</title>

</head>
<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">


		<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>Hasil Pengujian</h1>
				<ol class="breadcrumb">
					<li><a href="#">Admin</a></li>
					<li><a href="#">Option</a></li>
				</ol>
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">
					
					<h3>Pengujian Berdasarkan Data Latih</h3>

						<div class="tabs side-tabs responsive-tabs clearfix" id="tab-4">

							<ul class="tab-nav tab-nav2 clearfix">
								<?php $titleLatih = array('Latih 75', 'Latih 65', 'Latih 55', 'Latih 45', 'Latih 35');
								
								foreach($dataSemua as $key=>$value) {?>
								<li><a href="#latih-<?php echo $key?>"><i class="icon-home2"></i> <?php echo $titleLatih[$key] ?></a></li>
								<?php }?>
							</ul>
							<div class="tab-container">
								<?php foreach($dataSemua as $keySemua=>$semuaData){?>
								<div class="tab-content clearfix" id="latih-<?php echo $keySemua ?>">
									
									<!--tab kontainer-->
									<div class="tabs tabs-bb responsive clearfix" id="tab-9">

										<ul class="tab-nav clearfix">
											<li><a href="#tabs-31"> Data Latih</a></li>
											<li><a href="#tabs-32"> Data Uji</a></li>
											<li><a href="#tabs-33"> Rata-Rata</a></li>
											<li><a href="#tabs-34">Mean Corrected</a></li>
											<li><a href="#tabs-35">Kovarian</a></li>
											<li> <a href="#tabs-36">FN LDA</a></li>
										</ul>

										<div class="tab-container">

											<div class="tab-content clearfix" id="tabs-31">
												<!-- tabel data latih -->
												<h3> Data Latih </h3>
												<div class="table-responsive">
													<table id="datatable-latih-<?php echo $keySemua ?>" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr>
																<?php foreach($semuaData[0][0] as $key=> $value) {?>
																<th><?php echo $key; ?></th>
																<?php }?>
															</tr>
														</thead>
														<tfoot>
															<tr>
																<?php foreach($semuaData[0][0] as $key=> $value) {?>
																	<th><?php echo $key; ?></th>
																<?php }?>
															</tr>
														</tfoot>
														<tbody>
															<?php foreach($semuaData[2] as $key=> $row) {?>
															<?php foreach($row as $key2=> $row2) {?>
															<tr >
																<?php foreach($row2 as $i=>$value){?>
																	<td><?php echo $value; ?></td>
																<?php }?>
															</tr>
															<?php } ?>
															<?php } ?>
													</table>
												</div>
												<!--tabel data latih end-->
											</div>

											<div class="tab-content clearfix" id="tabs-32">
												<!-- tabel data Uji -->
												<h3> Data Uji </h3>
												<div class="table-responsive">
													<table id="datatable-uji-<?php echo $keySemua ?>" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
												<div class="divider divider-short divider-border divider-center"><i class="icon-diamond"></i></div>
												<!--tabel data Uji end-->	
											</div>

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
															<?php foreach($semuaData[1] as $key=> $row) {?>
															<tr >
																<td> <?php echo $jenis[$key] ?> </td>
																<?php foreach($row as $i=>$value){?>
																	<td><?php echo $value; ?></td>
																<?php }?>
															</tr>
															<?php } ?>
															<tr>
																<td> Mean Global </td>
																<?php foreach($semuaData[9] as $key=>$value) {?>
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
												<?php foreach($semuaData[3] as $key=>$row) {?>
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
												<div class="divider divider-short divider-border divider-center"><i class="icon-pencil"></i></div>
												<!--tabel data mean-corrected end-->
												<?php } ?>
											</div>
											<div class="tab-content clearfix" id="tabs-35">
												<!-- tabel kovarian kelas -->
												<h3> Tabel Kovarian </h3>
												<div class="table-responsive">
													<table id="datatable-kovarian-<?php echo $keySemua ?>" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th> No </th>
																<?php foreach($stringKey as $key=> $value) {?>
																<th><?php echo $value; ?></th>
																<?php }?>
															</tr>
														</thead>
														
														<tbody>
															<?php foreach($semuaData[4] as $key2=> $row2) {?>
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
												<div class="divider divider-short divider-border divider-center"><i class="icon-diamond"></i></div>
												<!-- tabel kovarian inverse kelas -->
												<h3> Tabel Kovarian Inverse</h3>
												<div class="table-responsive">
													<table id="datatable-inverse<?php echo $keySemua ?>" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th> No </th>
																<?php foreach($stringKey as $key=> $value) {?>
																<th><?php echo $value; ?></th>
																<?php }?>
															</tr>
														</thead>
														
														<tbody>
															<?php foreach($semuaData[5] as $key2=> $row2) {?>
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
													<table id="datatable-fn<?php echo $keySemua ?>" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th> No </th>
																<?php foreach($jenis as $key=> $value) {?>
																<th><?php echo $value; ?></th>
																<?php }?>
															</tr>
														</thead>
														
														<tbody>
															<?php foreach($semuaData[6] as $key2=>$row2) {?>
															<tr >
																<?php
																	$maxRank = array_keys($row2, max($row2));
																?>
																<td> <?php echo $dataUji[$key2]['NO'] ?> </td>
																<?php foreach($row2 as $i=>$value){?>

																	<td><?php echo ($i == $maxRank[0]) ? '<b>'.$value.'</b>' : $value; ?></td>
																<?php }?>
															</tr>
															<?php } ?>
													</table>
												</div>
												<!--tabel data FN LDA end-->

												<!-- tabel Akurasi  kelas -->
												<div class="divider divider-short divider-border divider-center"><i class="icon-diamond"></i></div>
												<h3> Tabel Akurasi</h3>
												<div class="table-responsive">
													<table id="datatable-akurasi<?php echo $keySemua ?>" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
																<td> <?php echo $dataUji[$key2]['NO'] ?> </td>
																<td><?php echo $jenis[$semuaData[7][$key2]]; ?></td>
																<td><?php echo $jenis[$row2]; ?></td>
																<td><?php echo ($semuaData[7][$key2] == $row2) ?  '<b>Ya</b>' : 'Tidak'; ?></td>
															</tr>
															<?php } ?>
													</table>
												</div>
												<!--tabel data akurasi end-->

												<h3> Akurasi Data = <?php echo $semuaData[8] ?> % </h3>
											</div>

										</div>

									</div>
									<!--tab kontainer end-->
								</div>
								<?php }?>
								<!-- end of everything -->
							</div>
							

						</div>
						<div>
						
						</div>
				</div>
				
			</div>

		</section><!-- #content end -->


	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>



<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/plugins.js"></script>

	<!-- Bootstrap Data Table Plugin -->
	<script type="text/javascript" src="<?php echo base_url() ?>js/components/bs-datatable.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="<?php echo base_url() ?>js/functions.js"></script>

	<script>

		$(document).ready(function() {
			// $('#datatable-latih').dataTable({
			// })
			// $('#datatable-uji').dataTable({
			// })
			$("[id*='mean']").dataTable({
			})
			$("[id*='datatable-latih']").dataTable({
			})
			$("[id*='datatable-uji']").dataTable({
			})
			$("[id*='datatable-kovarian']").dataTable({
			})
			$("[id*='datatable-inverse']").dataTable({
			})
			$("[id*='datatable-fn']").dataTable({
			})
			$("[id*='datatable-akurasi']").dataTable({
			})
			// $('#datatable-mean1').dataTable({
			// })
			// $('#datatable-mean2').dataTable({
			// })
			// $('#datatable-mean3').dataTable({
			// })
			// $('#datatable-kovarian').dataTable({
			// })
			// $('#datatable-inverse').dataTable({
			// })
			// $('#datatable-fn').dataTable({
			// })
			// $('#datatable-akurasi').dataTable({
			// })
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