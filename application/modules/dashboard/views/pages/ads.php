 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 			 <div class="form-group col-md-6">
					    <label ><?php echo ___("admin_popup_advertising"); ?></label>
					    <select name="popup" class="form-control">
					    	<option <?php if($this->config->item("popup") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("popup") != '1'){ echo "selected"; } ?> value="0">Off</option>
					    </select>
					  </div>
					  <div class="form-group col-md-6">
					    <label ><?php echo ___("admin_ads_refresh"); ?></label>
					    <select name="ads_refresh" class="form-control">
					    	<option <?php if($this->config->item("ads_refresh") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("ads_refresh") != '1'){ echo "selected"; } ?> value="0">Off</option>
					    </select>
					  </div>

					   <div class="form-group col-md-12">
					    <label >PopUp Advertising Code (Not Allowed by Google)</label>
					    <textarea  rows="3" name="popup_code" class="form-control"><?php echo $this->config->item("popup_code"); ?></textarea>
					  </div>
					    <div class="form-group col-md-12">
					    <label >Advertising Header Code</label>
					    <textarea rows="3" name="ads_block" class="form-control"><?php echo $this->config->item("ads_block"); ?></textarea>
					  </div>
					  <div class="form-group col-md-8">
					    <label >Advertising Footer Code</label>
					    <textarea rows="10" name="ads_block_footer" class="form-control"><?php echo $this->config->item("ads_block_footer"); ?></textarea>
					  </div> 
					   <div class="form-group col-md-4">

					     <div class="form-group col-md-12">
						    <label >Type Avertising </label>
						    <select name="ads_float" class="form-control">
						    	<option <?php if($this->config->item("ads_float") == '1'){ echo "selected"; } ?> value="1">Floating (Not Allowed by Google)</option>
						    	<option <?php if($this->config->item("ads_float") != '1'){ echo "selected"; } ?> value="0">Static</option>
						    </select>
						  </div>


						  <div class="form-group col-md-12">
						    <label >Allow User Close Advertising Floating </label>
						    <select name="allow_close_ads" class="form-control">
						    	<option <?php if($this->config->item("allow_close_ads") == '1'){ echo "selected"; } ?> value="1">Yes</option>
						    	<option <?php if($this->config->item("allow_close_ads") != '1'){ echo "selected"; } ?> value="0">No</option>
						    </select>
						  </div>  
						
						  <div class="form-group col-md-12">
						    <label >Show Floating After Close</label>
						    <select name="show_ads_float_rand" class="form-control">
						    	<option <?php if($this->config->item("show_ads_float_rand") == '0'){ echo "selected"; } ?> value="0">Off</option>
						    	<option <?php if($this->config->item("show_ads_float_rand") == '60'){ echo "selected"; } ?> value="60">1 Minute</option>
						    	<option <?php if($this->config->item("show_ads_float_rand") == '180'){ echo "selected"; } ?> value="180">3 Minutes</option>
						    	<option <?php if($this->config->item("show_ads_float_rand") == '300'){ echo "selected"; } ?> value="300">5 Minutes</option>
						    	<option <?php if($this->config->item("show_ads_float_rand") == '600'){ echo "selected"; } ?> value="600">10 Minutes</option>
						    	<option <?php if($this->config->item("show_ads_float_rand") == '900'){ echo "selected"; } ?> value="900">15 Minutes</option>
						    	<option <?php if($this->config->item("show_ads_float_rand") == '1800'){ echo "selected"; } ?> value="1800">30 Minutes</option>
						    	<option <?php if($this->config->item("show_ads_float_rand") == '2700'){ echo "selected"; } ?> value="2700">45 Minutes</option>
						    	<option <?php if($this->config->item("show_ads_float_rand") == '3600'){ echo "selected"; } ?> value="3600">60 Minutes</option>
						    </select>
						  </div>

						</div>


					  

					   <div class="form-group col-md-12">
					    <label >Advertising Sidebar (Only Musik Module)</label>
					    <textarea rows="3" name="ads_block_sidebar" class="form-control"><?php echo $this->config->item("ads_block_sidebar"); ?></textarea>
					  </div>

					  <div class="form-group col-md-6">
					    <label >Audio/Video Advertising Youtube</label>
					    <input name="audio_ads"  data-role="tagsinput" type="text" class="form-control" placeholder="Youtube Video ID" value="<?php echo $this->config->item("audio_ads"); ?>">
					    <span class="inline-helper">
					    	Example: https://www.youtube.com/watch?v=<span class='text-danger'>pDj8QYigFnw</span>
					    </span>
					  </div> 	
 						<div class="form-group col-md-6">
						    <label >Audio/Video Advertising Randon Factor</label>
						    <select name="factor_ads" required class="form-control">
						    	<?php for($x=1;$x<=10;$x++)
						    	{
						    		?>
						    		<option <?php if($this->config->item('factor_ads') == $x) { echo "selected"; } ?> value="<?php echo $x; ?>"><?php echo ($x); ?></option>						    		
						    		<?php
						    	}
						    	?>
						    	
						    </select>
						    <span class="inline-helper">
					    		Small number more probability to play ads
					    	</span>

					  </div> 	
					  <div class="clearfix"></div>
					  <div class="form-group col-md-6">
					    <label >Hide ADS To Registered Users</label>
					    <select name="hide_ads_registered" class="form-control">
					    	<option <?php if($this->config->item("hide_ads_registered") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("hide_ads_registered") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div> 
					  <div class="clearfix"></div>
					  <div class="text-center">
					   	<img src="https://cdn.adf.ly/static/image/logo.png" style="height:64px;" valign="middle"> <br>
					   	<small>Adf.ly Module</small>
					   </div>
					   <a href="http://support.jodacame.com/knowledge-base/where-i-can-get-adf-ly-api-key" class="pull-right">Where I can get the API KEY and UID?</a>
					   <div class="clearfix"></div>
					  <div class="form-group col-md-6">
					    <label >API Key</label>
					 	<input  name="adfly_key" type="text" class="form-control" placeholder="" value="<?php echo $this->config->item("adfly_key"); ?>">
					  </div> 

					  <div class="form-group col-md-6">
					    <label >UID</label>
					 	<input  name="adfly_uid" type="text" class="form-control" placeholder="" value="<?php echo $this->config->item("adfly_uid"); ?>">
					  </div> 

					  <div class="form-group col-md-4">
					    <label >Short Download Link</label>
					    <select name="adfly_downloads" class="form-control">
					    	<option <?php if($this->config->item("adfly_downloads") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("adfly_downloads") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div> 

					  <div class="form-group col-md-4">
					    <label >Short Amazon Link</label>
					    <select name="adfly_amazon" class="form-control">
					    	<option <?php if($this->config->item("adfly_amazon") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("adfly_amazon") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div> 

					  <div class="form-group col-md-4">
					    <label >Short iTunes Link</label>
					    <select name="adfly_itunes" class="form-control">
					    	<option <?php if($this->config->item("adfly_itunes") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("adfly_itunes") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div> 



					  
					  

		 		</div>
				<div class="clearfix"></div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary" style="width:100%">Save</button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>
