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
							</ul>
							<div class="tab-container">
								
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
			$.post('<?php echo base_url() ?>/admin/mom', {
					name: this.name,
				}, function (response) {
					var a = JSON.parse(response);
					console.log(a);
				})
		});

	</script>
</body>