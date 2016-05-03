 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 			<?php if(file_exists('./application/modules/music/controllers/musik.php')){ ?>
		 				<div class="alert alert-info">
							This is available only for Musik Template
						</div>
		 			  <div class="form-group col-md-12">
					    <label >Allow Login With Facebook</label>
					    <select name="loginfb" class="form-control">
					    	<option <?php if($this->config->item("loginfb") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("loginfb") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>
					  <div class="form-group col-md-6">
					    <label >Facebook APP ID</label>
					    <input  name="fb_appId" type="text" class="form-control" placeholder="" value="<?php echo $this->config->item("fb_appId"); ?>">
					  </div>
					  <div class="form-group col-md-6">
					    <label >Facebook APP Secret Key</label>
					    <input  name="fb_secret" type="text" class="form-control" placeholder="" value="<?php echo $this->config->item("fb_secret"); ?>">
					  </div>	  
					  <div class="form-group col-md-12">
					    <label >Share Text</label>
					    <input  name="share_fb_msg" type="text" class="form-control" placeholder="TAGS: {TRACK} {ARTIST} {SITE}" value="<?php echo $this->config->item("share_fb_msg"); ?>">
					  </div>					  
		 		</div>
				<div class="clearfix"></div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary" style="width:100%">Save</button>
				</div>
				<div class="alert alert-warming">
					For autopost on facebook wall user, the app required <a href="https://developers.facebook.com/docs/facebook-login/permissions/v2.3">publish_actions</a> permission. 
				</div>
				<?php }else{ ?>
				<br>
				<div class="alert alert-danger">
					<strong>Module Require:</strong> Musik Extend For Youtube Music Engine
				</div>
				<?php } ?>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>
