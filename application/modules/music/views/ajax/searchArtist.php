
<div class="row">
<?php
$x=0;
foreach ($search->results->artistmatches->artist as $key => $value) {
  $image = $value->image[4]->text;
  if($image == '')
    $image = $value->image[3]->text;
 /* if($image == '')
    $image = base_url()."assets/images/no-cover.png";*/
  if($value->name != '' && $x<4 && $image != '')
  {
    $x++;
	?>		
  <div class="col-xs-12 col-md-3">
    <div class="thumbnail" style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
    	<div style="height:180px;overflow:hidden;">
      		
      	</div>
      <div class="caption">
        <h4 class="nowrap"><?php echo $value->name; ?></h4>      
        <p class="nowrap"><a href="<?php echo base_url(); ?>artist/<?php echo econde($value->name); ?>" onClick="getArtistInfo('<?php echo addslashes($value->name); ?>');" class="btn btn-primary removehref" style="width:100%" ><?php echo ___("label_artist_info"); ?></a></p>
      </div>
    </div>
  </div>	
<?php
  }
}
if($x==0)
{
  ?>
    <script type="text/javascript">
    $("#search-artist").html("");
    </script>
  <?php
}
?>
<script type="text/javascript">
  $(".removehref").attr("href","#");
</script>
</div>


