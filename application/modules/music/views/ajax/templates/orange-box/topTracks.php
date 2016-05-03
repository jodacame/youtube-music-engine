<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="page-header">
 	<h1><?php echo ___("label_top_tracks"); ?> <?php echo getCountry(); ?></h1>
 </div>
 
<div class="row">
<?php

foreach ($top->tracks->track as $key => $value) {
  if($key >= $this->config->item("items_top"))
    return false;

  $value->name = clean_quotes($value->name);
  $value->artist->name = clean_quotes($value->artist->name);
  
	$image = $value->image[3]->text;
		if($image == '')
			$image = base_url()."assets/images/no-cover.png";
	?>		
  <div class="col-xs-<?php echo  $this->config->item("col_xs"); ?> col-md-<?php echo  $this->config->item("col_md"); ?> col-lg-<?php echo  $this->config->item("col_lg"); ?>">
    <div class="thumbnail cursor-pointer"  style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
    	<div style="height:120px;overflow:hidden;">      		
      	</div>      
          <p>
          <button class="btn btn-default" style="width:45%" title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>','<?php echo $image; ?>');"><i class="fa fa-plus"></i></button>                                         
            <button class="btn btn-default pull-right" style="width:45%" title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i></button>                                         
        </p>
    </div>
    <div class="caption">
        <h4 class="truncate"><?php echo $value->name; ?></h4>      
        <p class="artistInfo truncate" onClick="getArtistInfo('<?php echo $value->artist->name; ?>');" title=<?php echo ___("label_get_artist_info"); ?>><?php echo $value->artist->name; ?></p>      
      
      </div>
  </div>	
<?php
}
?>
</div>
