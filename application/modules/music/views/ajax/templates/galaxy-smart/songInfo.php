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

<div class="row" style="">
	<div class="col-md-3">
	<img class="img-responsive thumbnail" style="width:100%;" src="<?php echo $image; ?>">
	
			<button class="btn btn-default" style="width:100%;margin-bottom:5px" onclick="start_radio('<?php echo addslashes($lyrics->track); ?>','<?php echo addslashes($lyrics->artist); ?>','<?php echo $image; ?>')"><i class="fa fa-rss"></i> <?php echo ___("label_start_radio"); ?></button>		
		
			  <button class="btn btn-primary" style="width:100%;margin-bottom:5px" title="<?php echo ___("label_playnow"); ?>" onclick="addPlayList('<?php echo addslashes($lyrics->track); ?>','<?php echo addslashes($lyrics->artist); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i> <?php echo ___("label_playnow"); ?></button>                                         
			    <?php if($this->config->item("amazon_afiliate") != '')
                {
                    ?><button  onClick="buyOnAmazon('<?php echo addslashes($lyrics->track); ?> - <?php echo addslashes($lyrics->artist); ?>')" class="btn btn-warning" style="width:100%" title="<?php echo ___("label_buy_on_amazon"); ?>"><i class="fa fa-shopping-cart"></i> <?php echo ___("label_buy_on_amazon"); ?></button><?php
                }
                ?>
		 
	</div>
	<div class="col-md-9">
	 <div class="tabbable">
		<ul class="nav nav-tabs" id="myTab">
		  <li class="active"><a href="#lyricTab" data-toggle="tab"><?php echo ___("label_lyrics"); ?></a></li>	
		  <li><a href="#artistTab" data-toggle="tab"><?php echo $lyrics->artist; ?></a></li>		  
		  <li><a href="#topTracks" data-toggle="tab"><?php echo ___("label_top_tracks"); ?></a></li>	
		  <li><a href="#similarTab" data-toggle="tab"><?php echo ___("label_related_artist"); ?></a></li>	
		</ul>
		<div class="tab-content">
		  <div class="tab-pane" id="artistTab">
		  		<h2><?php echo $lyrics->track; ?></h2>	        	
	        	<div class="clearfix"></div>
	        	
			 
	    	<div class="clearfix"></div>
	    	<br>
	    	<?php echo @strip_tags($song->track->wiki->summary); ?>
	    	<br><br>
	    	<?php echo @strip_tags($artist->artist->bio->content); ?>

		  </div>
		  	<div class="tab-pane active" id="lyricTab" style="text-align:center">
		  	<strong><i class="fa fa-music"></i> <?php echo $lyrics->track; ?> <i class="fa fa-music"></i></strong><br>
		  	<strong><small><?php echo $lyrics->artist; ?></small></strong><br>
		  	<?php echo $lyrics->lyric; ?></div>	 
		  	<div class="tab-pane" id="similarTab" style="text-align:center">
		  		<div class="row">
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
					    <div class="col-xs-12 col-md-3 col-lg-3">
					    <div class="thumbnail" style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
					    	<div style="height:180px;overflow:hidden;">
					      		
					      	</div>
					      <div class="caption">
					        <h4 class="nowrap"><?php echo $value->name; ?></h4>      
					        <p class="nowrap"><a href="<?php echo base_url(); ?>artist/<?php echo econde($value->name); ?>"  onClick="getArtistInfo('<?php echo $value->name; ?>');" class="btn btn-primary removehref" style="width:100%" ><?php echo ___("label_artist_info"); ?></a></p>
					      </div>
					    </div>
					  </div>
					<?php
						}
					}
					?>
					</div>
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