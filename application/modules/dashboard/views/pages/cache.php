 <div class="row">
 	<div class="col-xs-12">
 	<div class="box box-primary">
	    <!-- form start -->
		 <form role="form" method="POST" accept-charset="UTF-8">
		 	<div class="box-body">
			   

		
			  




			
			<div class="form-group col-md-6">
			    <label >Local Lyrics Module</label>
			    <select name="local_lyrics" class="form-control">
			    	<option <?php if($this->config->item("local_lyrics") == '1'){ echo "selected"; } ?> value="1">On</option>
			    	<option <?php if($this->config->item("local_lyrics") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
			    </select>
			  </div> 			

			  <div class="form-group col-md-6">
			    <label >Remote Lyrics Module</label><i class="fa fa-info-circle pull-right" style="cursor:help" title="Required Valid Purchase Code"></i>
			    <select name="remote_lyrics_service" class="form-control">
			    	<option <?php if($this->config->item("remote_lyrics_service") == '1'){ echo "selected"; } ?> value="1">On</option>
			    	<option <?php if($this->config->item("remote_lyrics_service") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
			    </select>
			  </div> 

			

			  <div class="form-group col-md-6">
			    <label >Local Artist Module (Cache Database)</label>
			    <select name="local_artist" class="form-control">
			    	<option <?php if($this->config->item("local_artist") == '1'){ echo "selected"; } ?> value="1">On</option>
			    	<option <?php if($this->config->item("local_artist") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
			    </select>
			  </div>

			  <div class="form-group col-md-6">
			    <label >Proxy Images (BETA)</label>
			    <select name="use_proxy_images" class="form-control">
			    	<option <?php if($this->config->item("use_proxy_images") == '1'){ echo "selected"; } ?> value="1">On</option>
			    	<option <?php if($this->config->item("use_proxy_images") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
			    </select>
			  </div>

 				<div class="form-group col-md-6">
			    <label >Cache Pictures (Required Proxy Images ON)</label>
			    <select name="save_local_picture" class="form-control">
			    	<option <?php if($this->config->item("save_local_picture") == '1'){ echo "selected"; } ?> value="1">On</option>
			    	<option <?php if($this->config->item("save_local_picture") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
			    </select>
			  </div>

			   <div class="form-group col-md-6">
			    <label >Remote Artist Module</label> <i class="fa fa-info-circle pull-right" style="cursor:help" title="Auto download information artist into your database"></i>
			    <select name="remote_artist" class="form-control">
			    	<option <?php if($this->config->item("remote_artist") == '1'){ echo "selected"; } ?> value="1">On</option>
			    	<option <?php if($this->config->item("remote_artist") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
			    </select>
			  </div>




			  <div class="form-group col-md-6">
			    <label >Cache Request</label>
			    <select name="use_cache" class="form-control">
			    	<option <?php if($this->config->item("use_cache") == '1'){ echo "selected"; } ?> value="1">On</option>
			    	<option <?php if($this->config->item("use_cache") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
			    </select>
			  </div>  

			  <div class="form-group col-md-6">
			    <label >Use Browser Cache</label>
			    <i class="fa fa-info-circle pull-right" style="cursor:help" title="Improve speed up 100% using LocalStorage browser cache (It is restarted when you make a change in the admin.)"></i>
			    <select name="local_cache" class="form-control">
			    	<option <?php if($this->config->item("local_cache") == '1'){ echo "selected"; } ?> value="1">On</option>
			    	<option <?php if($this->config->item("local_cache") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
			    </select>
			  </div>  
			   <?php
			    if(exec('echo EXEC') == 'EXEC'){
				    ?>
			  <div class="form-group col-md-6">
			    <label >Auto Clean Cache Folder</label>
			   
				    <select  name="clean_cache" class="form-control">
				    <option <?php if($this->config->item("clean_cache") == '0'){ echo "selected"; } ?> value="0"> Never</option>
				    <?php for($x=5;$x<=90;$x=$x+5){
				    	?>
				    	<option <?php if($this->config->item("clean_cache") == $x){ echo "selected"; } ?> value="<?php echo $x; ?>"><?php echo $x; ?> Days</option>
				    	<?php
				    }
				    ?>
				    </select>

				
			    
			  </div>
			    <?php
				}
				?>
				
		


			 <div class="clearfix"></div>
			      <div class="box-footer">
		            <button type="submit" class="btn btn-primary" style="width:100%">Save</button>
		        </div>
			</form>
		</div>
	</div>
</div>
