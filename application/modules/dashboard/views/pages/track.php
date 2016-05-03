<div class="row">
 	<div class="col-xs-12">
 		<div class="box box-primary">
	 	

				
	 	 	<form role="form" method="POST">
		 		<div class="box-body">	

		 		 	<?php 
 		if($msg)
 		{
 			?>
 			<br>
 			<div class="alert alert-success">
 				<?php echo $msg; ?>
 			</div>
 			<?php
 		}
 		?>

 				<div class="col-md-9">
		 			<div class="form-group col-xs-12">
			    		<label >Artist Name</label>
						<input readonly required maxlength="50" type="text" value="<?php echo $track->artist; ?>" class="form-control" name="artist" style="width:100%" placeholder="Artist">
					</div>
					<div class="form-group col-xs-12">
			    		<label >Track Name</label>
						<input readonly required maxlength="50" type="text" value="<?php echo $track->track; ?>" class="form-control" name="track" style="width:100%" placeholder="Track">
					</div>
					<div class="form-group col-xs-12">
			    		<label >Custom Video Youtube ID </label>
						<input maxlength="50" type="text" value="<?php echo $track->youtube; ?>" class="form-control" name="youtube" style="width:100%" placeholder="Video Youtube ID">
					</div>
					<br>
					<div class="clearfix"></div>	 		
					<br>
					
					<div class="alert alert-info">
						<strong>Information:</strong> Use this module to add a custom video to a track
					</div>
					<!--<textarea name="json" rows="20" class="form-control" ><?php echo $track->json; ?></textarea>-->
					
		 		</div>
		 		<div class="col-md-3">
		 		<?php if($track->youtube){
		 			?>
		 			<div style="padding:10px;background-color:#000;text-align:center;Width:100%">
		 			<iframe width="100%" height="300" src="https://www.youtube.com/embed/<?php echo $track->youtube; ?>" frameborder="0" allowfullscreen></iframe>
		 			</div>
		 			<?php
		 		}
		 		?>
		 		</div>
		 		<div class="clearfix"></div>
		 		<br>
			</div>
			
				<div class="box-footer">
					<button type="submit" class="btn btn-primary" style="width:100%">Save</button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>

