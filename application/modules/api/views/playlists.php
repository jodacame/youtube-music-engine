<p class="msg">

<a href="<?php echo base_url(); ?>"><?php echo ___("label_continue"); ?> <?php echo $this->config->item("title"); ?></a><br>
<small><?php echo ___("label_or"); ?><br></small>
<?php echo ___("label_import_spotify_playlist"); ?>
</p>
<div class="row">
<?php foreach ($playlist as $key => $value) {	
	?>
	<div class="col-md-3">
		<a href="<?php echo base_url(); ?>spotify/playlist/<?php echo $value['owner']; ?>/<?php echo $value["id"]; ?>" class="thumb animated lightSpeedIn">	
			<img src="<?php echo $value["picture"]; ?>" style="width:231px;height:231px">
			<div class="footer">
				<img src="http://musik.andthemusic.net/assets/addons/spotify.png" class="pull-right" style="width:24px;opacity:0.2">
				<span class="name"><?php echo $value["name"]; ?></span>
				<span class="tracks"><?php echo number_format($value["tracks"]); ?> Tracks</span>
				
			</div>		
		</a>
	</div>
	<?php	
}
?>
</div>
