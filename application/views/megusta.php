<!DOCTYPE html>
<html class="no-js">
<head>
 <!-- Basic Page Needs
        ================================================== -->
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/images/favicon.png">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<!-- Mobile Specific Metas
	================================================== -->
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>yoow</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tachyons/4.6.1/tachyons.min.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<style>
		*{
			font-family: 'Open Sans', sans-serif;
		}
		tr.odd{
			background-color:#efefef !important;
		}
	</style>
</head>
<body class='w-100'>
	<div class="pa3 relative br2 bg-light-gray ma2 w-100 overflow-x-scroll">
		<table class='myTable'>
			<thead>
				<tr>
					<?php for($i=0;$i<39;$i++) {?>
					<?php if($i==0){
					?>
					<th>Nama</td>
					<?php
					}else{
					?>
					<th><?php echo $string[$i-1]; ?></td>
					<?php
					} ?>
					<?php }?>
				</tr>
			</thead>
			<tbody>
			<?php for($j=0;$j<100;$j++) {?>
			<tr class='pointer'>
				<td><?php echo $allData[$j]['INISIAL']?></td>
				<?php for($i=0;$i<38;$i++) {?>
					<td><?php echo $allData[$j][$string[$i]]?></td>
				<?php }?>
			</tr>
			<?php }?>
			</tbody>
		</table>
	</div>
	<div class="pa3 relative br2 bg-light-gray ma2 w-100 overflow-x-scroll">
		<table class='myTable'>
			<thead>
				<tr>
					<?php for($i=0;$i<38;$i++) {?>
					<th>Table</td>
					<?php }?>
				</tr>
			</thead>
			<tbody>
			<?php for($j=0;$j<100;$j++) {?>
			<tr class='pointer'>
				<?php for($i=0;$i<38;$i++) {?>
					<td>Table<?php echo $j?></td>
					<?php }?>
			</tr>
			<?php }?>
			</tbody>
		</table>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src='//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js' ></script>
	<script>
		// console.log('h')
		$(document).ready(function(){
			// console.log('h')
			$('.myTable').DataTable();
		});
	</script>
</body>
</html>