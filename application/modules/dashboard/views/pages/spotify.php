 <div class="row">            
 	<div class="col-md-6">
	    <div class="small-box bg-green">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($users->num_rows()); ?>
	            </h3>
	            <p>
	                Accounts
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-spotify"></i>
	        </div>
	   		 <span class="small-box-footer">
	            Spotify
	        </span>  
	    </div>
	</div><!-- ./col -->  

	<div class="col-md-6">
	    <div class="small-box bg-yellow">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($playlist->num_rows()); ?>
	            </h3>
	            <p>
	                Playlist
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-list"></i>
	        </div>
	   		 <span  class="small-box-footer">	      
	   		 Spotify      
	        </span>  
	    </div>
	</div><!-- ./col -->  

</div>
 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 			<?php if(file_exists('./application/modules/spotify/controllers/spotify.php')){ ?>		 					 		
					  <div class="form-group col-md-6">
					    <label >Spotify Client ID</label>
					    <input  name="spotify_key" type="text" class="form-control" placeholder="" value="<?php echo $this->config->item("spotify_key"); ?>">
					    <small class="inline-help"><a href="http://support.jodacame.com/knowledge-base/create-an-application-on-spotify"><i class="fa fa-help"></i> How Create an Application on Spotify</a>					  </small>
					  </div>
					    <div class="form-group col-md-6">
					    <label >Spotify Client Secrect</label>
					    <input  name="spotify_secrect" type="text" class="form-control" placeholder="" value="<?php echo $this->config->item("spotify_secrect"); ?>">
					  </div>					  
									  
		 		</div>

				<div class="clearfix"></div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary" style="width:100%">Save</button>
				</div>
				<?php }else{ ?>
				<br>
				<div class="alert alert-danger">
					<strong>Required:</strong> Spotify Module
				</div>
				<?php } ?>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>
