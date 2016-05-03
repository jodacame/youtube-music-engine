<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="page-header">
  <h1><?php echo ___("label_top_artist"); ?> <?php echo getCountry(); ?></h1>
 </div>
<div class="row">
<?php

foreach ($top->result() as $value) {
  if($key >= $this->config->item("items_top"))
    return false;
  $image = $value->cover;
  if($image == '')
    $image = $value->cover;
  if($image == '')
     $image = base_url()."assets/images/no-cover.png";
	?>		
  <div class="col-xs-<?php echo  $this->config->item("col_xs"); ?> col-md-<?php echo  $this->config->item("col_md"); ?> col-lg-<?php echo  $this->config->item("col_lg"); ?>">
    <div onClick="getArtistInfo('<?php echo $value->artist; ?>');" class="thumbnail cursor-pointer" style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
    	<div style="height:120px;overflow:hidden;">      		
      </div>      
    </div>
    <div class="caption">
        <div class="caption-main">
          <h4 class="nowrap"><?php echo $value->artist; ?></h4>              
        </div>
      </div>
      
  </div>	
<?php
}
?>
</div>
<script>
$(".nav-sidebar li").removeClass("active");
$("#topArtist").addClass('active');
</script>