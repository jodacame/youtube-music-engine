<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="page-header">
 	<h1><?php echo ___("label_top_tracks"); ?></h1>
 </div>
 
<div class="row">
<?php
$key = 0;
if($top->num_rows > 0)
{
	foreach ($top->result() as $row) {
		$key++;
	  if($key >= $this->config->item("items_top"))
	    return false;

		$image = $row->picture;
			if($image == '')
				$image = base_url()."assets/images/no-cover.png";
		?>		
	 <div class="col-xs-<?php echo  $this->config->item("col_xs"); ?> col-md-<?php echo  $this->config->item("col_md"); ?> col-lg-<?php echo  $this->config->item("col_lg"); ?>" style="margin-bottom:20px;">
    <div class="thumbnail cursor-pointer"  style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
      <div style="height:150px;overflow:hidden;">         
        </div>      
          <p class="button">
            <button class="btn btn-default"  title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($row->track); ?>','<?php echo addslashes($row->artist); ?>','<?php echo $image; ?>');"><i class="fa fa-plus"></i></button>                                         
            <button class="btn btn-default pull-right"  title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($row->track); ?>','<?php echo addslashes($row->artist); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i></button>                                         
        </p>
    </div>
    <div class="caption">
        <div class="caption-main">
          <div onclick="addPlayList('<?php echo addslashes($row->track); ?>','<?php echo addslashes($row->artist); ?>','<?php echo $image; ?>',true);" class="pull-left" style="font-size:20px;margin-right:10px;cursor:pointer;border-right:1px #121314 solid"><i class="fa fa-play" style="margin-right:10px"></i></div>
          <h4 onclick="getSongInfo('<?php echo addslashes($row->artist); ?>','<?php echo addslashes($row->track); ?>');"  class="truncate artistInfo"><?php echo $row->track; ?></h4>      
          <p class="artistInfo truncate" onClick="getArtistInfo('<?php echo $row->artist; ?>');" title=<?php echo ___("label_get_artist_info"); ?>><?php echo $row->artist; ?></p>      
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
$("#topTrack").addClass('active');
</script>