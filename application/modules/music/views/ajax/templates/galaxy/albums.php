<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="row">
	<div class="col-md-3">
		<img class="img-responsive thumbnail" style="width:100%;" src="<?php echo $artist->artist->image[3]->text; ?>">
	</div>
	<div class="col-md-9">
		<h2><?php echo $artist->artist->name; ?></h2>
		<p><?php echo str_ireplace("</a","</span",str_ireplace("<a", "<span", $artist->artist->bio->content)); ?></p>
		<?php foreach ($artist->artist->tags->tag as $key => $value) {
			?>
			<span onClick="getTopTags('<?php echo $value->name; ?>');" class="label label-primary artistInfo"><?php echo $value->name; ?></span>
			<?php
		}
		?>
		<div class="clearfix"></div>
		<br>
		<button class="btn btn-info" onclick="getArtistInfo('<?php echo addslashes($artist->artist->name); ?>')">Top Tracks</button>		
	</div>
</div>
<div class="page-header">
 	<h1>Top Albums</h1>
 </div>
<div class="row">
<?php
foreach ($albums->topalbums->album as $key => $value) {
	$image = $value->image[3]->text;
		if($image == '')
			$image = base_url()."assets/images/no-cover.png";
	?>		
  <div class="col-xs-12 col-md-4 col-lg-3 marginTop20">
    <div class="thumbnail cursor-pointer" onclick="getTracksAlbum('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>');"  style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
    	<div style="height:180px;overflow:hidden;">
      		
      	</div>
     
    </div>
     <div class="caption">
     <div class="caption-main">
        <h4 title="Album Info" onclick="getTracksAlbum('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>');" class="truncate"><?php echo $value->name; ?></h4>              
        
       </div>
      </div>

  </div>	
<?php
}
?>
</div>