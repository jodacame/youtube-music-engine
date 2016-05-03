<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="page-header">
<img class="pull-right" src="https://rss.itunes.apple.com/images/image_title_itunes.png"> 
  <h1><?php echo ___("label_top_tracks"); ?> </h1>

</div>
<div class="row">
<?php

foreach ($top->feed->entry as $key => $value) {
  $value->title->label = str_ireplace( "- ".$value->artist->label, "",  $value->title->label);
  if($key >= $this->config->item("items_top"))
    return false;

  $image = $value->image[2]->label;
    if($image == '')
      $image = base_url()."assets/images/no-cover.png";
  $image = str_ireplace("170x170", "200x200", $image);

  ?>    
  <div class="col-xs-<?php echo  $this->config->item("col_xs"); ?> col-md-<?php echo  $this->config->item("col_md"); ?> col-lg-<?php echo  $this->config->item("col_lg"); ?>">
    <div class="thumbnail cursor-pointer" onClick="getSongInfo('<?php echo addslashes(encode2($value->artist->label)); ?>','<?php echo addslashes(encode2($value->title->label)); ?>');"  style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
      <div style="height:180px;overflow:hidden;">
          
        </div> 
         <div class="caption">

        <h4 class="truncate"><a class="removehref" href="<?php echo base_url(); ?>?artist=<?php echo encode2($value->artist->label); ?>&track=<?php echo encode2($value->title->label); ?>"><?php echo $value->title->label; ?></a></h4>      
        <p class="artistInfo truncate" onClick="getArtistInfo('<?php echo addslashes($value->artist->label); ?>');" title=<?php echo ___("label_get_artist_info"); ?>><?php echo $value->artist->label; ?></p>      
        <p>
          <button class="btn btn-default" style="width:45%" title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->title->label); ?>','<?php echo addslashes($value->artist->label); ?>','<?php echo $image; ?>');"><i class="fa fa-plus"></i></button>                                         
            <button class="btn btn-default pull-right" style="width:45%" title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->title->label); ?>','<?php echo addslashes($value->artist->label); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i></button>                                         
        </p>
      </div>  
    </div>
      
  </div>  
<?php
}
?>
<script>
$(".removehref").attr("href","#");
</script>