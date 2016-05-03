<div class="clearfix"></div>
<div class="row hidden-xs">
<?php
$x=0;
foreach ($search->results->artistmatches->artist as $key => $value) {
  $image = $value->image[4]->text;
  if($image == '')
    $image = $value->image[3]->text;
 /* if($image == '')
    $image = base_url()."assets/images/no-cover.png";*/
  if($value->name != '' && $x<=5 && $image != '')
  {
    $x++;
	?>		
  <div class="col-xs-12 col-md-2">
    <div class="thumbnail cursor-pointer" onClick="getArtistInfo('<?php echo addslashes($value->name); ?>');" style="background:url('<?php echo $image; ?>') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
    	<div style="height:120px;overflow:hidden;">
      		
      	</div>     
    </div>
     <div class="caption">
      <div class="caption-main">
        <h4 class="nowrap"><?php echo $value->name; ?></h4>      
        <p class="nowrap"><a href="<?php echo base_url(); ?>artist/<?php echo econde($value->name); ?>"  class="btn btn-primary removehref hide" style="width:100%" ><?php echo ___("label_artist_info"); ?></a></p>
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
    var stateObj = { foo: "bar" };
history.pushState(stateObj, "", "<?php echo base_url(); ?>?s=<?php echo encode2($query); ?>");
    </script>
  <?php
}
?>
<script type="text/javascript">
  $(".removehref").attr("href","#");

var stateObj = { foo: "bar" };
history.pushState(stateObj, "", "<?php echo base_url(); ?>?s=<?php echo encode2($query); ?>");


</script>
</div>


