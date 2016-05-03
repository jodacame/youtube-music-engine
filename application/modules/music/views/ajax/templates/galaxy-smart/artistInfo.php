<?php

	$itemRand = rand(0,count($toptracks->toptracks->track));

	if(count($toptracks->toptracks->track) == 0)
	{
		?>
		<div class="alert alert-info">
			<strong><?php echo ___("label_artist"); ?>!</strong>  No Found!
		</div>
		<?php
		exit;
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

<div class="row" style="">
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
	</div>

	
</div>



<div class="page-header">
 	<h1><?php echo ___("label_top_tracks"); ?> <button class="btn btn-success pull-right" onclick="addAlltoPlaylist()"><i class="fa fa-plus"></i> <?php echo ___("label_add_all"); ?></button> </h1>
 </div>
<div class="row" style="">
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
<script>
$(".removehref").attr("href","#");
var stateObj = { foo: "bar" };
history.pushState(stateObj, "", "<?php echo base_url(); ?>artist/<?php echo encode2($artist->artist->name); ?>");

</script>