
  <script>
var map;
function initialize() {
  var mapOptions = {
    zoom: 8,
    center: new google.maps.LatLng(-34.397, 150.644)
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

 var myLatlng = new google.maps.LatLng(-25.363882,131.044922);
 var image = '';
 var latlngbounds = new google.maps.LatLngBounds();
	<?php 
	$evento = false;
		foreach ($events->events->event as $key => $value) {
		
			if($value->venue->location->geo->lat != '')
			{
				$evento = true;
				?>
				myLatlng = new google.maps.LatLng(<?php echo $value->venue->location->geo->lat; ?>,<?php echo $value->venue->location->geo->long; ?>);
				image = '<?php echo $value->image[1]->text; ?>';
				var marker<?php echo $key; ?> = new google.maps.Marker({
				     position: myLatlng,
				     map: map,
				     title: '<?php echo addslashes($value->title); ?>',
			         icon: image,
			         animation: google.maps.Animation.DROP

				  });

				 var contentString<?php echo $key; ?>  = '<div id="content"><div id="bodyContent"><strong><?php echo $value->startDate; ?></strong><br><?php echo addslashes(str_ireplace("<a ","<span ",str_ireplace("</a","</span",$value->description))); ?> <br><br><a href="<?php echo $value->url; ?>" target="_blank" class="btn btn-xs btn-info">More Info</a> <button onClick="getArtistInfo(\'<?php echo $artist; ?>\');" class="btn btn-primary btn-xs" ><?php echo ___("label_artist_info"); ?></button> </div></div>';
				  var infowindow<?php echo $key; ?> = new google.maps.InfoWindow({
				      content: contentString<?php echo $key; ?>
				  });

				google.maps.event.addListener(marker<?php echo $key; ?>, 'click', function() {				    
				    //window.open('<?php echo $value->url; ?>');
				     infowindow<?php echo $key; ?>.open(map,marker<?php echo $key; ?>);
				});


				
				  latlngbounds.extend(myLatlng);
				
				
				<?php
			}
		}
		?> 
		map.fitBounds(latlngbounds);

}


    </script>
<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="page-header">
 	<h1  class="artistInfo" onClick="getArtistInfo('<?php echo $artist; ?>');"><?php echo ___("label_events"); ?> - <?php echo $artist; ?></h1>
 </div> 
<div class="row">
	<div class="col-xs-12">
	 	<div id="map-canvas" style="height:100%;min-height:500px;"></div>
	</div>
</div>
<div class="alert alert-info" style="display:none" id="noevents">
	<strong>Events!</strong>  No Found!
</div>
<script type="text/javascript">
initialize();
<?php
if(!$evento)
{
	?>
	$("#map-canvas").hide();
	$("#noevents").show();
	<?php
}
?>
</script>

