
 <div class="row">
  <div class="col-md-12">
                            <!-- Primary tile -->
                            <div class="box box-solid bg-light-blue">
                                <div class="box-header">
                                    <h3 class="box-title"><i class="fa fa-tablet"></i> Theme for Mobile Devices</h3>
                                </div>
                                <div class="box-body">                                  
                                    <p>
                                        You can select a different theme for visitors entering for mobile devices, if you desired.
                                    </p>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
<a href="<?php echo base_url(); ?>dashboard/themes_setting_mobile" class="pull-right btn btn-xs- btn-success"><i class="fa fa-sliders"></i> Setting Current Theme</a>
<div class="clearfix"></div>
<br>
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST" id="frmTheme">
		 		<div class="box-body">
		 				<div class="form-group col-xs-12">					    
					    <select name="theme_mobile" id="theme" class="form-control hide">
					    <?php
					    $this->load->helper('directory');
					    $skin = directory_map('./assets/css/themes/');
					    array_multisort($skin);
					    foreach ($skin as $key => $value) {
					    	if($key !='fonts' && $key != 'yeti')
					    	{
					    	?>
					    	<option data-img-src='<?php echo base_url(); ?>assets/css/themes/<?php echo $key; ?>/<?php echo $key; ?>.png' <?php if($key == $this->config->item("theme")){ echo "selected";} ?> value="<?php echo $key; ?>"><?php echo ucfirst($key); ?></option>
					    	<?php	
					    	}	 	
					    }		    
					    ?>
					    </select>

					    <?php

   							foreach ($skin as $key => $value) {
					    	if($key !='fonts' && $key != 'yeti')
					    	{
					    	?>
					    	<div class="col-sm-6 col-md-3 col-lg-3">
							    <div class="thumbnail <?php echo $key; ?> <?php if($key == $this->config->item("theme_mobile")){ echo "active";} ?> ">
							      <img src="<?php echo base_url(); ?>assets/css/themes/<?php echo $key; ?>/<?php echo $key; ?>.png" alt="<?php echo ucfirst($key); ?>" class="img-responsive" style="width:100%">
							      <div class="caption">
							        <h3><?php echo ucwords(str_ireplace("-", " ", $key)); ?></h3>							        
							        <p>
							        <button type="button" onClick="selectTheme('<?php echo $key; ?>')" class="btn btn-primary btn-flat pull-left" style="width:49%" role="button">Active</button> 							        
							        <a href="<?php echo base_url(); ?>?skin=<?php echo $key; ?>" target="previewTheme" class="btn btn-default btn-flat pull-right" style="width:49%" role="button">Preview</a></p>
							        <div class="clearfix"></div>
							      </div>
							    </div>
							  </div>
					    	<?php	
					    	}	 	
					    }		    
					    ?>					    
					  </div>
		 		</div>
				<div class="clearfix"></div>
				<div class="box-footer">
					
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>

<script>
function selectTheme(key)
{
	$('#theme option[value="'+key+'"]').prop('selected', true);
	$(".thumbnail").removeClass('active');
	$("."+key).addClass('active');
	$("#frmTheme").submit();

}
</script>