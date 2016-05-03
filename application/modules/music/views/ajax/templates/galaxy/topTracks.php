<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="page-header">
 	<h1><?php echo ___("label_top_tracks"); ?> <?php echo getCountry(); ?>    <div class="clearfix"></div>

  <!-- Split button -->
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default"><?php echo ___("label_genres"); ?></button>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu">  
   <?php if($this->config->item("genres") != '')
    {
      $tags = explode(",", $this->config->item("genres"));
      foreach ($tags as $key => $value) 
      {     
        ?>
        <li  onclick="getTopTags('<?php echo encode($value); ?>');" ><a href="#"><?php echo ucwords($value); ?></a></li>
        <?php    
      }
    }
    ?>    
    
  </ul>
</div>
</h1>
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
  
  <div class="col-xs-<?php echo  $this->config->item("col_xs"); ?> col-md-<?php echo  $this->config->item("col_md"); ?> col-lg-<?php echo  $this->config->item("col_lg"); ?>" style="margin-bottom:20px;">
    <div class="thumbnail cursor-pointer"  style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
    	<div style="height:150px;overflow:hidden;">      		
      	</div>      
          <p class="button">
            <button class="btn btn-default"  title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>','<?php echo $image; ?>');"><i class="fa fa-plus"></i></button>                                         
            <button class="btn btn-default pull-right"  title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i></button>                                         
        </p>
    </div>
    <div class="caption">
        <div class="caption-main">
          <div onclick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>','<?php echo $image; ?>',true);" class="pull-left" style="font-size:20px;margin-right:10px;cursor:pointer;border-right:1px #121314 solid"><i class="fa fa-play" style="margin-right:10px"></i></div>
          <h4 onclick="getSongInfo('<?php echo addslashes($value->artist->name); ?>','<?php echo addslashes($value->name); ?>');"  class="truncate artistInfo"><?php echo $value->name; ?></h4>      
          <p class="artistInfo truncate" onClick="getArtistInfo('<?php echo $value->artist->name; ?>');" title=<?php echo ___("label_get_artist_info"); ?>><?php echo $value->artist->name; ?></p>      
        </div>
      
      </div>
  </div>	
<?php
}
?>
</div>
<script>
$(".nav-sidebar li").removeClass("active");
$("#topTrack").addClass('active');
</script>