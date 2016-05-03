<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="page-header">
 	<h1><?php echo ___("label_music_folder"); ?></h1>
 	<button class="btn btn-xs btn-default pull-right" onclick="profile()"><i class="fa fa-user"></i> <?php echo ___("label_profile"); ?></button>
 </div>  
 <?php 
 $image = base_url()."assets/images/no-cover.png";
 ?>
 <div class="pull-right col-md-4">
	<?php echo login_spotify('label_import_spotify'); ?>
</div>
<div class="clearfix"></div>
<div class="row">

		<div class="col-xs-12 col-md-3 col-lg-2">
		    <div onClick="$('#savePlaylistModal').modal('show');"  class="thumbnail cursor-pointer" style="background:url('<?php echo $image ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
		    	<div style="height:180px;overflow:hidden;">		      				    	
		      	</div>
		     
		    </div>
		     <div class="caption">
		     	<div class="caption-main">
		        	<h4 class="nowrap"><?php echo ___("label_create_new_folder"); ?></h4>      		        
		       		<button onClick="$('#savePlaylistModal').modal('show');" class="btn btn-danger" style="width:100%" ><?php echo ___("label_new_playlist"); ?></button>
		       	</div>
		      </div>
		  </div>	

	<?php
	$x=0;
	if ($myplaylist->num_rows() > 0)
	{
	   foreach ($myplaylist->result() as $row)
	   {
	   	$x++;
	   	 $image = base_url()."assets/images/no-cover.png";
	   	$json = json_decode($row->json);
	   	if($json[0]->cover != '')
	   		 $image = $json[0]->cover;

	   	?>

	   		<script type="text/javascript">
			var json<?php echo $x; ?> = "<?php echo str_ireplace('"','\"',$row->json); ?>";
			</script>
					
	   	
		<div class="col-xs-12 col-md-3 col-lg-2">
		    <div class="thumbnail cursor-pointer" onClick="loadPlayListDB(json<?php  echo $x ?>)"  style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
		    	<span class="label label-info pull-right">
		    	<i class="fa fa-music"></i> <?php echo count($json); ?> 
		    	</span>
		    	<div class="btn-group pull-left">	
		    		<button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown" title="<?php echo ___("label_share"); ?>">
			    		<i class="fa fa-share-square"></i>
			    	 </button>
			  		<ul class="dropdown-menu pull-right" role="menu">					   
			    		<li><a href="#" onClick="custom_share('fb','<?php echo base_url()."?playlist=".sha1($this->config->item("encryption_key").intval($row->idplaylist)); ?>');return false;"><i class="fa fa-facebook-square"></i> Facebook</a></li>                              
                        <li><a href="#" onClick="custom_share('tw','<?php echo base_url()."?playlist=".sha1($this->config->item("encryption_key").intval($row->idplaylist)); ?>');return false;"><i class="fa fa-twitter"></i> Twitter</a></li>                              
                        <li><a href="#" onClick="custom_share('gp','<?php echo base_url()."?playlist=".sha1($this->config->item("encryption_key").intval($row->idplaylist)); ?>');return false;"><i class="fa fa-google-plus-square"></i> Google Plus</a></li>                              
                        <li><a href="#" onClick="custom_share('c','<?php echo base_url()."?playlist=".sha1($this->config->item("encryption_key").intval($row->idplaylist)); ?>');return false;"><i class="fa fa-link"></i> Copy Link</a></li>  
			  		</ul>
			  	</div>


		    	<div style="height:180px;overflow:hidden;">	
		    	<?php foreach ($json as $key => $value) {
		    		if($key>0)
		    		{
		    			?><img class="hoverimg" style="width:80px;padding:0px;margin:-5px" src="<?php echo $value->cover; ?>">      	
		    			<?php
		    		}
		    	}
		    	?>	


		    					    	
		     				    	
		      	</div>
		    
		    </div>

		      <div class="caption">
		      	<div class="caption-main">
		        <h4 class="nowrap"><?php echo $row->name; ?></h4>      		        
		   		        
					<div class="btn-group" style="width:100%">	

				
					<button onClick="loadPlayListDB(json<?php  echo $x ?>)" class="btn btn-default" style="width:80%" ><i class="fa fa-play"></i> <?php echo ___("label_load_playlist_folder"); ?></button>		        	
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width:19%">
					    <span class="caret"></span>
					    <span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu pull-right" role="menu">					   
					    <li  onClick='loadPlayListDB(json<?php  echo $x ?>,true)'><a href="#"><?php echo ___("label_load_append_folder"); ?></a></li>					   	
					    <li onClick='addToPlayListDB(<?php echo intval($row->idplaylist); ?>);'><a href="#"><?php echo ___("label_save_current_into"); ?></a></li>					   						   						    
					    <li class="divider"></li>
					    <li onClick='removeFolder(<?php echo intval($row->idplaylist); ?>);'><a href="#"><?php echo ___("label_remove_folder"); ?></a></li>
					  </ul>
					</div>
		 
		      </div>
		      </div>

		  </div>	
		
	      	      
	      <?php
	   }
	}
	?>
</div>

<script>
$(".nav-sidebar li").removeClass("active");
$("#musicFolder").addClass('active');
</script>