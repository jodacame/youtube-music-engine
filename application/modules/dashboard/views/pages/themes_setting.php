<?php
$setting_file = './assets/css/themes/'.$this->config->item("theme").'/'.$this->config->item("theme").'.conf';
$config = array();
if(file_exists($setting_file))
{
	$setting_file = file_get_contents($setting_file);
	$temp = explode("\n", $setting_file );	
	foreach ($temp as $key => $value) {
		$temp2 = explode(":", $value);
		$config[$temp2[0]] = $temp2[1];
	}	
}


?>
 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 			<div class="col-md-3">
		 					<div class="col-md-12">
							 
							      <img src="<?php echo base_url(); ?>assets/css/themes/<?php echo $this->config->item("theme"); ?>/<?php echo $this->config->item("theme"); ?>.png" class="img-responsive thumbnail" style="width:100%">							      
							    
							  </div>
					</div>
					<?php if($config['setting_theme'] !== 'false'){ ?>
					<div class="col-md-9">
							 <h3>Items by Rows on Top Pages</h3>			  
					  <hr>
					  <div class="form-group col-md-6">	
					    <label>Phones (<768px)</label>
					     <select  name="col_xs" class="form-control">
					    	<?php
					    	for($x=1;$x<=12;$x++)
					    	{
					    		if(12%$x ==0)
					    		{
					    			?>
						    		<option  <?php if((intval(12/$x)) == $this->config->item("col_xs")){ echo "selected";} ?>  value="<?php echo (intval(12/$x)); ?>"><?php echo $x; ?></option>
						    		<?php	
					    		}
					    		
					    	}
					    	?>
					    </select>
					  </div> 	

					   <div class="form-group col-md-6">	
					    <label>Tablets (≥768px)</label>
					     <select  name="col_sm" class="form-control">
					    	<?php
					    	for($x=1;$x<=12;$x++)
					    	{
					    		if(12%$x ==0)
					    		{
					    		?>
						    		<option  <?php if((intval(12/$x)) == $this->config->item("col_sm")){ echo "selected";} ?>  value="<?php echo (intval(12/$x)); ?>"><?php echo $x; ?></option>
						    		<?php
					    		}
					    	}
					    	?>
					    </select>
					  </div> 	

					   <div class="form-group col-md-6">	
					    <label>Desktops (≥992px)</label>
					     <select  name="col_md" class="form-control">
					    	<?php
					    	for($x=1;$x<=12;$x++)
					    	{
					    		if(12%$x ==0)
					    		{
						    		?>
						    		<option  <?php if((intval(12/$x)) == $this->config->item("col_md")){ echo "selected";} ?>  value="<?php echo (intval(12/$x)); ?>"><?php echo $x; ?></option>
						    		<?php
						    	}
					    	}
					    	?>
					    </select>
					  </div> 

					   <div class="form-group col-md-6">	
					    <label>Desktops HD (≥1200px)</label>
					     <select  name="col_lg" class="form-control">
					    	<?php
					    	for($x=1;$x<=12;$x++)
					    	{
					    		if(12%$x ==0)
					    		{
						    		?>
						    		<option  <?php if((intval(12/$x)) == $this->config->item("col_lg")){ echo "selected";} ?>  value="<?php echo (intval(12/$x)); ?>"><?php echo $x; ?></option>
						    		<?php
						    	}
					    	}
					    	?>
					    </select>
					  </div> 
					  
					 
					
					   <?php 
						}
					    if(file_exists( './assets/css/themes/'.$this->config->item("theme").'/skins/'))
					    {
					    ?>

					   <div class="form-group col-md-12">	
					    <label>Skin Color</label>
					     <select  name="skin_color" class="form-control">
					     	<option <?php if($this->config->item("skin_color") == ''){ echo 'selected'; } ?> value="">Default</option>

					    	<?php
					    	 $this->load->helper('directory');
						    $skin = directory_map( './assets/css/themes/'.$this->config->item("theme").'/skins/');
						    array_multisort($skin);
						    foreach ($skin as $key => $value) {
						    	$name = str_ireplace(".css", "", $value);
						    	?>
						    	<option <?php if($this->config->item("skin_color") == $name){ echo 'selected'; } ?>  value="<?php echo $name; ?>"><?php echo ucfirst($name); ?></option>
						    	<?php
						    }
						    ?>
					    </select>
					  </div> 
					  <?php } ?>

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

