<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="page-header">
	<h1><?php echo ___("label_new_releases"); ?> <img title="<?php echo $releases->channel->image->title; ?>" src="<?php echo $releases->channel->image->url; ?>"></h1>
</div>

<div class="row">
<?php
$x=0;
foreach ($releases->channel->item as $key => $value) {	
	 $value->title = str_ireplace( "- ".$value->artist, "",  $value->title);
  if($x >= $this->config->item("items_top"))
    return false;
	$x++;
	$image = $value->coverArt[2];
		if($image == '')
			$image = base_url()."assets/images/no-cover.png";
	
    $image = str_ireplace("100x100", "150x150", $image);
    
	?>		
  <div class="col-xs-12 col-md-4 col-lg-3">
    <div class="thumbnail" style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
    	<div style="height:180px;overflow:hidden;">
      		
      	</div>
      <div class="caption">
        <h4 class="truncate"><?php echo $value->title; ?></h4>      
        <p class="artistInfo truncate" onClick="getArtistInfo('<?php echo $value->artist; ?>');" title=<?php echo ___("label_get_artist_info"); ?>><?php echo $value->artist; ?></p>      
        <p>
        	<button class="btn btn-primary" style="width:45%" title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->title); ?>','<?php echo addslashes($value->artist); ?>','<?php echo $image; ?>');"><i class="fa fa-plus"></i></button>                                         
            <button class="btn btn-primary pull-right" style="width:45%" title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->title); ?>','<?php echo addslashes($value->artist); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i></button>                                         
        </p>
      </div>
    </div>
  </div>	
<?php
}
?>
</div>

<?php
echo "<pre>";
print_r($releases->channel);
?>