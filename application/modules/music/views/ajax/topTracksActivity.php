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
	  <div class="col-xs-<?php echo  $this->config->item("col_xs"); ?> col-md-<?php echo  $this->config->item("col_md"); ?> col-lg-<?php echo  $this->config->item("col_lg"); ?>">
	    <div class="thumbnail" style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
	    	<div style="height:180px;overflow:hidden;">
	      		
	      	</div>
	      <div class="caption">
	        <h4 class="truncate"><?php echo $row->track; ?></h4>      
	        <p class="artistInfo truncate" onClick="getArtistInfo('<?php echo $row->artist; ?>');" title=<?php echo ___("label_get_artist_info"); ?>><?php echo $row->artist; ?></p>      
	        <p>
	        	<button class="btn btn-primary" style="width:45%" title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($row->track); ?>','<?php echo addslashes($row->artist); ?>','<?php echo $image; ?>');"><i class="fa fa-plus"></i></button>                                         
	            <button class="btn btn-primary pull-right" style="width:45%" title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($row->track); ?>','<?php echo addslashes($row->artist); ?>','<?php echo $image; ?>',true);"><i class="fa fa-play"></i></button>                                         
	        </p>
	      </div>
	    </div>
	  </div>	
	<?php
	}
}
?>
</div>
