
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
 		
		 			<input type="hidden" name="id" value="<?php echo intval($lyric->idlyrics); ?>">
					<input required maxlength="50" type="text" value="<?php echo $lyric->artist; ?>" class="form-control" name="artist" style="width:100%" placeholder="Artist">
					<br>
					<input required maxlength="50" type="text" value="<?php echo $lyric->track; ?>" class="form-control" name="track" style="width:100%" placeholder="Track">
					<br>
					<textarea  placeholder="Lyric" required name="lyric" style="min-height:350px;width:100%"><?php echo br2n($lyric->lyric) ?></textarea>
		 		</div>

			
				<div class="box-footer">
					<button type="submit" class="btn btn-primary" style="width:100%">Save</button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>