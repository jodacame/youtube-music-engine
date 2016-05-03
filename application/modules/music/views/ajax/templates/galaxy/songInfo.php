<?php
$image = $song->track->album->image[3]->text;
if($image == '')
	$image = $song->track->album->image[2]->text;
if($image == '')
	$image = $song->track->album->image[1]->text;
if($image == '')
	$image = base_url()."assets/images/no-cover.png";
?>
<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>

<div class="row">
	<div class="col-md-3">
	<img class="img-responsive thumbnail" style="width:100%;" src="<?php echo $image; ?>">
			<div class="caption">
			<button class="btn btn-default" style="text-align:left;width:100%;margin-bottom:5px" onclick="start_radio('<?php echo addslashes($lyrics->track); ?>','<?php echo addslashes($lyrics->artist); ?>','<?php echo $image; ?>')"><i class="fa fa-rss"></i> <?php echo ___("label_start_radio"); ?></button>		
			<div class="btn-group" style="text-align:left;width:100%;margin-bottom:5px">
			    <button type="button" class="btn btn-default  dropdown-toggle" style="text-align:left;width:100%"  data-toggle="dropdown">
			      <i class="fa fa-share-square"></i> <?php echo ___("label_share"); ?>
			      <span class="caret"></span>
			    </button>
			    <ul class="dropdown-menu">
			       	<li><a href="#" onClick="custom_share('fb','<?php echo base_url()."?artist=".addslashes(encode2($lyrics->artist))."&track=".addslashes(encode2($lyrics->track)); ?>');return false;"><i class="fa fa-facebook-square"></i> Facebook</a></li>                              
	               	<li><a href="#" onClick="custom_share('tw','<?php echo base_url()."?artist=".addslashes(encode2($lyrics->artist))."&track=".addslashes(encode2($lyrics->track)); ?>');return false;"><i class="fa fa-twitter"></i> Twitter</a></li>                              
	               	<li><a href="#" onClick="custom_share('gp','<?php echo base_url()."?artist=".addslashes(encode2($lyrics->artist))."&track=".addslashes(encode2($lyrics->track)); ?>');return false;"><i class="fa fa-google-plus-square"></i> Google Plus</a></li>   
	               	<li><a href="#" onClick="custom_share('c','<?php echo base_url()."?artist=".addslashes(encode2($lyrics->artist))."&track=".addslashes(encode2($lyrics->track)); ?>');return false;"><i class="fa fa-link"></i> Copy Link</a></li>   
			    </ul>
			  </div>
			  <button class="btn btn-primary" style="text-align:left;width:100%;margin-bottom:5px" title="<?php echo ___("label_playnow"); ?>" onclick="addPlayList('<?php echo addslashes($lyrics->track); ?>','<?php echo addslashes($lyrics->artist); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i> <?php echo ___("label_playnow"); ?></button>                                         
			   <button  data-track="<?php echo ($lyrics->track); ?>" data-artist="<?php echo ($lyrics->artist); ?>" data-cover="<?php echo $image; ?>" class="btn btn-warning btn-download-mp3" style="text-align:left;width:100%" title="<?php echo ___("label_download"); ?>"><i class="fa fa-cloud-download"></i> <?php echo ___("label_download"); ?></button>
               
                </div>

                <div class="page-header">
	 					<h1><?php echo ___("label_related_artist"); ?></h1>
	 			</div>

                <?php
					$x=0;
					foreach ($artist->artist->similar->artist as $key => $value) {
						$image = $value->image[3]->text;
							if($image == '')
								$image = base_url()."assets/images/no-cover.png";
						if($value->name != '' && $x<4)
						{
							$x++;
						?>		
					    <div class="col-xs-12 col-md-12 col-lg-12">
					    <div class="thumbnail cursor-pointer"  onClick="getArtistInfo('<?php echo $value->name; ?>');"  style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
					    	<div style="height:180px;overflow:hidden;">
					      		
					      	</div>
					     
					    </div>
					     <div class="caption">
					      	<div class="caption-main">					        
					        	<p class="nowrap"><a href="<?php echo base_url(); ?>artist/<?php echo econde($value->name); ?>"  onClick="getArtistInfo('<?php echo $value->name; ?>');" class="removehref" style="width:100%" ><?php echo $value->name; ?></a></p>
					        </div>
					      </div>
					  </div>
					<?php
						}
					}
					?>

		 
	</div>
	<div class="col-md-9">

	<h2><?php echo $lyrics->track; ?></h2>
	        	<span  style="cursor:pointer" title="Album Info" onclick="getTracksAlbum('<?php echo addslashes($song->track->album->title); ?>','<?php echo addslashes($lyrics->artist); ?>');"><i class="fa fa-folder-o"></i> <?php echo $song->track->album->title; ?></span>                                                     
	        	<div class="clearfix"></div>
	        	<br>
			  <?php foreach ($song->track->toptags->tag as $key => $value) {
		      ?>
		      <span onClick="getTopTags('<?php echo $value->name; ?>');" class="label label-primary artistInfo"><?php echo $value->name; ?></span>
		      <?php
	    	}
	    	?>
	    	<div class="clearfix"></div>
	    	<br>
	    	<?php echo @strip_tags($song->track->wiki->summary); ?>
	    	<br><br>
	    	<?php echo @strip_tags($artist->artist->bio->content); ?>

	<div class="clearfix"></div><br>
			<div class="col-md-12">	
				<?php echo comments('songinfo'); ?>
			</div>
		  			<br>
	 <div class="tabbable">
		<ul class="nav nav-tabs" id="myTab">
		  <li class="active"><a href="#lyricTab" data-toggle="tab"><?php echo ___("label_lyrics"); ?></a></li>	
		  	  
		  <li><a href="#topTracks" data-toggle="tab"><?php echo ___("label_top_tracks"); ?></a></li>	
		
		</ul>
		<div class="tab-content">
	
		  	<div class="tab-pane active" id="lyricTab" style="text-align:center">
		  	<strong><i class="fa fa-music"></i> <?php echo $lyrics->track; ?> <i class="fa fa-music"></i></strong><br>
		  	<strong><small><?php echo $lyrics->artist; ?></small></strong><br>
		  	<?php echo $lyrics->lyric; ?>
		  	</div>	 
	

		  	<div class="tab-pane" id="topTracks">
		  		<!-- Top Tracks -->

			<div class="list-group">

					   
					  


					<?php
					foreach ($toptracks->toptracks->track as $key => $value) {
						$image = $value->image[3]->text;
						if($image == '')
							$image = $value->image[2]->text;
						if($image == '')		
							$image = $value->image[1]->text;
						if($image == '')
							$image = base_url()."assets/images/no-cover.png";
						if($value->name != '')
						{
						?>		
						  <a href="<?php echo base_url(); ?>?artist=<?php echo $value->artist->name; ?>&track=<?php echo $value->name; ?>" onClick="return false;" class="list-group-item removehref"><i class="fa fa-music"></i> <?php echo $value->name; ?>
						  		<div class="btn-group pull-right">
						  			<button class="btn btn-warning btn-xs"   onclick="getSongInfo('<?php echo addslashes($value->artist->name); ?>','<?php echo addslashes($value->name); ?>');"><i class="fa fa-info-circle"></i></button>
						  			<button class="btn btn-primary btn-xs addTrg"  title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>','<?php echo $image; ?>');"><i class="fa fa-plus"></i></button>
						  			<button class="btn btn-danger btn-xs"  title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i></button>                                         
									<?php if($this->config->item("amazon_afiliate") != '')
					                {
					                    ?><button  onClick="buyOnAmazon('<?php echo addslashes($value->name); ?> - <?php echo addslashes($value->artist->name); ?>')" class="btn btn-info btn-xs" title="<?php echo ___("label_buy_on_amazon"); ?>"><i class="fa fa-shopping-cart"></i></button><?php
					                }
					                ?>
					            </div>
						  </a>
					 
					<?php
						}
					}
					?>
					 </div>
				</div>
		  		<!-- /Top Tracks -->
		  	</div>	 

		</div>


	</div>



	</div>

<br>
<br>
<script>
$(window).load(function() {
	<?php if (!$this->input->is_ajax_request()) { ?>
		start_radio('<?php echo addslashes($lyrics->track); ?>','<?php echo addslashes($lyrics->artist); ?>','<?php echo $image; ?>');
	<?php } ?>
	$(".removehref").attr("href","#");
});
try{
	$(".removehref").attr("href","#");
}
catch(e)
{

}

</script>