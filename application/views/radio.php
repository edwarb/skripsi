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

	<!-- Bootstrap Switch CSS -->
	<link rel="stylesheet" href="../css/components/bs-switches.css" type="text/css" />

	<!-- Radio Checkbox Plugin -->
	<link rel="stylesheet" href="../css/components/radio-checkbox.css" type="text/css" />

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
				<h1>Form Pertanyaan</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li class="active">Form Pertanyaan</li>
				</ol>
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<!-- Post Content
					============================================= -->
					<div class="postcontent nobottommargin clearfix">

						<div class="row">

							<div class="clear"></div><div class="line"></div>

							<form method="post" action="hasil">
							<!--Question here-->
							<?php foreach($pertanyaan as $i=>$value){ ?>
								<div class="col-md-12">
									<h4><?php echo ($i+1) . '. ' . $value; ?></h4>
								</div>

								<div class="col-md-6">

									<div>
										<input id="G<?php echo ($i+1) ?>-1" value=50 class="checkbox-style" name="G<?php echo ($i+1) ?>" type="radio" checked>
										<label for="G<?php echo ($i+1) ?>-1" class="checkbox-style-3-label">Sering</label>
									</div>
									<div>
										<input id="G<?php echo ($i+1) ?>-2" value=30 class="checkbox-style" name="G<?php echo ($i+1) ?>" type="radio">
										<label for="G<?php echo ($i+1) ?>-2" class="checkbox-style-3-label">Kadang-Kadang </label>
									</div>
									<div>
										<input id="G<?php echo ($i+1) ?>-3" value=20 class="checkbox-style" name="G<?php echo ($i+1) ?>" type="radio">
										<label for="G<?php echo ($i+1) ?>-3" class="checkbox-style-3-label">Tidak Pernah </label>
									</div>

									<div class="line"></div>

								</div>
							<?php } ?>
							<div class="col-md-12">
								<button type="submit" class="button button-border button-rounded button-fill fill-from-right button-blue"><span>Submit</span></a>
							</div>
							
							</form>

						</div>

					</div><!-- .postcontent end -->


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

	<!-- Bootstrap Switch Plugin -->
	<script type="text/javascript" src="../js/components/bs-switches.js"></script>

	<!-- Bootstrap Data Table Plugin -->
	<script type="text/javascript" src="../js/components/bs-datatable.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="../js/functions.js"></script>

	<script>

		$(document).ready(function() {
			jQuery(".bt-switch").bootstrapSwitch();
		});

	</script>
</body>