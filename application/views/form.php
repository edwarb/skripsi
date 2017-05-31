<section class="global-page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="block">
					<h2>DETEKSI Autis</h2>
					<div class="portfolio-meta">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--/#Page header-->

<section class="portfolio-single">
	<div class="container">
		<div class="row">
			<form action="<?php echo " ".base_url()."home"?>" name="" method="POST">
				<div class="col-md-12">
					<!--<div class="panel panel-default">
						<div class="panel-heading">
							<h10 class="panel-title"><strong>1. </strong> Ananda kurang memperhatikan benda yang ditunjukkan
								<br>
							</h10>
							<input type="radio" checked="checked" name="G1" value=50 id=50 /> Selalu
							<br>
							<input type="radio" name="G1" value=35 id=35/> Kadang - kadang
							<br>
							<input type="radio" name="G1" value=15 id=15/> Tidak Pernah
							<br>
						</div>-->
					<!--</div>-->
				<?php for($i = 0; $i<count($pertanyaan); $i++){
				?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h10 class="panel-title"><strong><?php echo $i+1 ?>. </strong> <?php echo $pertanyaan[$i] ?>
								<br>
							</h10>
							<input type="radio" checked="checked" name="G<?php echo ($i+1) ?>" value=50 id=50 /> Selalu
							<br>
							<input type="radio" name="G<?php echo ($i+1) ?>" value=30 id=30/> Kadang - kadang
							<br>
							<input type="radio" name="G<?php echo ($i+1) ?>" value=20 id=20/> Tidak Pernah
							<br>
						</div>
					</div>
				<?php
				} ?>
				</div>
				<button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Send</button>
				<button type="button" class="btn btn-default" href="<?php echo base_url();?>index.php/main/deteksi_adhd">Cancel</button>
			</form>
		</div>
	</div>
</section>