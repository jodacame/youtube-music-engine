<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="row">
	<div class="jumbotron" style="text-align:center;padding-top:10px;padding-bottom:10px" id="flagLyrics"> 

 	<h1>Lyrics</h1>
 	<h3><strong><?php echo $title; ?></strong></h3>


  		<p><?php echo $lyrics->lyric; ?></p>
	</div>
</div>


