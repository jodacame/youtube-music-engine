<?php

	$itemRand = rand(0,count($toptracks->toptracks->track));

	if(count($toptracks->toptracks->track) == 0)
	{
		?>
		<div class="alert alert-info">
			<strong><?php echo ___("label_artist"); ?>!</strong>  No Found!
		</div>
		<?php		
	}
	if(count($toptracks->toptracks->track) == 1)
	{
		$image = @$toptracks->toptracks->track->image[3]->text;
		$top = $toptracks->toptracks->track;
	}
	else
	{
		$image = @$toptracks->toptracks->track[$itemRand]->image[3]->text;
		$top = $toptracks->toptracks->track[$itemRand];
	}
	if($image == '')
		$image = base_url()."assets/images/no-cover.png";

?>
<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<?php
if(count($toptracks->toptracks->track) > 0)
{
?>
<div class="row">
	<div class="col-md-3">
		<img class="img-responsive thumbnail" style="width:100%;" src="<?php echo $artist->artist->image[3]->text; ?>">
	</div>
	<div class="col-md-9">
		<h2><?php echo $artist->artist->name; ?></h2>
		<p><?php echo str_ireplace("</a","</span",str_ireplace("<a", "<span", $artist->artist->bio->content)); ?></p>
		<?php foreach ($artist->artist->tags->tag as $key => $value) {
			?>
			<a href="<?php echo base_url(); ?>tag/<?php echo $value->name; ?>" onClick="getTopTags('<?php echo $value->name; ?>');" class="label label-primary artistInfo removehref"><?php echo $value->name; ?></a>
			<?php
		}
		?>
		<div class="clearfix"></div>
		<br>
		<button class="btn btn-default" onclick="start_radio('<?php echo addslashes($top->name); ?>','<?php echo addslashes($artist->artist->name); ?>','<?php echo $image; ?>')"><i class="fa fa-rss"></i> <?php echo ___("label_start_radio"); ?></button>
		<button class="btn btn-default" onclick="getAlbums('<?php echo addslashes($artist->artist->name); ?>')"><i class="fa fa-folder-o"></i> <?php echo ___("label_album"); ?></button>
		<button class="btn btn-default" onclick="getEvents('<?php echo addslashes($artist->artist->name); ?>')"><i class="fa fa-bullhorn"></i> <?php echo ___("label_events"); ?></button>
		<div class="btn-group">
		    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		      <i class="fa fa-share-square"></i> <?php echo ___("label_share"); ?>
		      <span class="caret"></span>
		    </button>
		    <ul class="dropdown-menu">
		       	<li><a href="#" onClick="custom_share('fb','<?php echo base_url()."artist/".addslashes(encode2($artist->artist->name)); ?>');return false;"><i class="fa fa-facebook-square"></i> Facebook</a></li>                              
               	<li><a href="#" onClick="custom_share('tw','<?php echo base_url()."artist/".addslashes(encode2($artist->artist->name)); ?>');return false;"><i class="fa fa-twitter"></i> Twitter</a></li>                              
               	<li><a href="#" onClick="custom_share('gp','<?php echo base_url()."artist/".addslashes(encode2($artist->artist->name)); ?>');return false;"><i class="fa fa-google-plus-square"></i> Google Plus</a></li>   
               	<li><a href="#" onClick="custom_share('c','<?php echo base_url()."artist/".addslashes(encode2($artist->artist->name)); ?>');return false;"><i class="fa fa-link"></i> Copy Link</a></li>   
		    </ul>
		  </div>
		    <br>
		  <br>
		  	<div class="col-md-12">	
				<?php echo comments('artist'); ?>
			</div>
	</div>

	
</div>
<div class="page-header">
 	<h1><?php echo ___("label_related_artist"); ?></h1>
 </div>

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


<div class="page-header">
 	<h1><?php echo ___("label_top_tracks"); ?> <button class="btn btn-success pull-right" onclick="addAlltoPlaylist()"><i class="fa fa-plus"></i> <?php echo ___("label_add_all"); ?></button> </h1>
 </div>
<div class="row">
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


	$value->name = clean_quotes($value->name);
   	$value->artist->name = clean_quotes($value->artist->name);

	if($value->name != '')
	{
	?>		
	  <a href="<?php echo base_url(); ?>?artist=<?php echo $value->artist->name; ?>&track=<?php echo $value->name; ?>" onClick="return false;" class="list-group-item removehref"><i class="fa fa-music"></i> <?php echo $value->name; ?>
	  		<div class="btn-group pull-right">
	  			<button class="btn btn-warning btn-xs"   onclick="getSongInfo('<?php echo addslashes($value->artist->name); ?>','<?php echo addslashes($value->name); ?>');"><i class="fa fa-info-circle"></i></button>
	  			<button class="btn btn-primary btn-xs addTrg"  title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>','<?php echo $image; ?>');"><i class="fa fa-plus"></i></button>
	  			<button class="btn btn-danger btn-xs"  title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->name); ?>','<?php echo addslashes($value->artist->name); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i></button>                                         				
                <button  data-artist="<?php echo ($value->artist->name); ?>" data-track="<?php echo ($value->name); ?>" data-cover="<?php echo $image; ?>" class="btn-download-mp3 btn btn-info btn-xs" title="<?php echo ___("label_download"); ?>"><i class="fa fa-cloud-download"></i></button>
                
            </div>
	  </a>
 
<?php
	}
}
?>
 </div>
</div>
<?php } ?>
<script>
$(".removehref").attr("href","#");
var stateObj = { foo: "bar" };
history.pushState(stateObj, "", "<?php echo base_url(); ?>artist/<?php echo encode2($artist->artist->name); ?>");

</script>