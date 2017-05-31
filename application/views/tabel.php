<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic|Play+Fair:700" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="../css/style.css" type="text/css" />
	<link rel="stylesheet" href="../css/dark.css" type="text/css" />
	<link rel="stylesheet" href="../css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="../css/animate.css" type="text/css" />
	<link rel="stylesheet" href="../css/magnific-popup.css" type="text/css" />

	<!-- Bootstrap Data Table Plugin -->
	<link rel="stylesheet" href="../css/components/bs-datatable.css" type="text/css" />

	<link rel="stylesheet" href="../css/responsive.css" type="text/css" />
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
				<h1>Hasil</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Form</a></li>
					<li class="active">Hasil</li>
				</ol>
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

				<!-- tabel 1 -->
					<div class="table-responsive">

						<table id="datatable1" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Jenis</th>
									<th>Nilai LDA</th>
								</tr>
							</thead>
							<!--<tfoot>
								<tr>
									<?php //for($i=0;$i<38;$i++) {?>
										<th>Table<?php //echo $i?></th>
									<?php //} ?>
								</tr>
							</tfoot>-->
							<tbody>
								<?php
									$kelas = ["Berat", "Sedang", "Ringan", "Tidak", ];
									foreach($kelas as $i=>$value){
								?>
								<tr >
									<td><?php echo $kelas[$i] ?></td>
									<td><?php echo $allfn[$i] ?></td>
								</tr>
								<?php } ?>
						</table>

					</div>
					<!-- tabel 1 end -->

					<!--<div class="col-md-12">
						<h3>Persentase</h3>
							
							<ul class="skills">
								<?php foreach($percent as $key=>$value) {?>
								<li data-percent="<?php echo $value ?>">
									<span><?php echo $kelas[$key] ?></span>
									<div class="progress">
										<div class="progress-percent"><div class="counter counter-inherit counter-instant"><span data-from="0" data-to="<?php echo $value ?>" data-refresh-interval="30" data-speed="1100"></span>%</div></div>
									</div>
								</li>
								<?php }?>
							</ul>
					</div>-->
					<div class="col-md-12">
						<h4>
							Hasil test dari sistem menunjukkan bahwa responden mengalami:
						</h4>
						<h3>
							<?php  
								$printKelas = ['Autis Berat', 'Autis Sedang', 'Autis Ringan', 'Tidak Autis' ];
								echo $printKelas[$rank1];
							?>
						</h3>
					</div>
					<div class="col-md-12">

						<div id="posts" class="post-grid grid-container clearfix" data-layout="fitRows">

							<?php
							$images = ['intp.png', 'estj.png', 'isfj.png', 'esfp.png'];
							 foreach($printKelas as $key=>$value){?>
							<div class="clearfix col-md-3">
								<div class="entry-image">
									<a href="../images/blog/full/<?php echo $images[$key] ?>" data-lightbox="image"><img class="image_fade" src="../images/blog/grid/<?php echo $images[$key] ?>" alt="Standard Post with Image"></a>
								</div>
								<div class="entry-title">
									<h2><a href="blog-single.html">Cari Tahu Info Mengenai <?php echo $value ?></a></h2>
								</div>
								<ul class="entry-meta clearfix">
									<li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
									<li><a href="#"><i class="icon-camera-retro"></i></a></li>
								</ul>
								<div class="entry-content">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
									<a href="blog-single.html"class="more-link">Read More</a>
								</div>
							</div>
							<?php }?>
						</div>
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
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/plugins.js"></script>

	<!-- Bootstrap Data Table Plugin -->
	<script type="text/javascript" src="../js/components/bs-datatable.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="../js/functions.js"></script>

	<script>

		$(document).ready(function() {
			$('#datatable1').dataTable({
				searching: false,
				paging: false,
				info: false
			})
			// $('#datatable2').dataTable();
		});

	</script>
</body>