<?php
$temp = $page->result_array();
$p = $temp[0];
?>
<?php if($this->config->item("ads_refresh") == '1'){ ?>
<center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
<?php } ?>
<div class="row">
	<div class="col-xs-12">
		<div class="page-header">
			<h1><?php echo $p["title"]; ?></h1>
			<?php echo processShortCode($p['content']); ?>
		</div>		
	</div>
</div>
<script>
var stateObj = { foo: "bar" };
history.pushState(stateObj, "", "<?php echo base_url(); ?>page/<?php echo $p['idpage']; ?>-<?php echo encode2($p['title']); ?>");
</script>