<div class="buttons">
	<a href="<?php echo base_url(); ?>spotify/user" class="btn">&#8656; <?php echo ___('label_playlist'); ?></a>
	<a href="#" class="btn btn-new"><?php echo ___('label_save_as_playlist'); ?></a>
	<a href="#" class="btn btn-append"><?php echo ___('label_append_folder'); ?></a>
</div>


<div class="form" id="append">
	<select>
		<option value="" selected disabled>Seleccione un Folder</option>
		<?php foreach ($users_folders->result() as $row) {
			?>
			<option value="<?php echo $row->idplaylist; ?>"><?php echo $row->name; ?></option>
			<?php
		}
		?>
	</select>
	<button class="button btn-block btn-start">Start!</button>
</div>

<div class="form" id="new">
	<div class="col-md-12">
		<img class="pull-left" src="<?php echo $info['picture']; ?>" style="margin-right:10px;">
		<div style="margin-left:10px">		
			<input type="text" class="h1" value="<?php echo $info["name"]; ?>" placeholder="<?php echo ___('label_name_playlist'); ?>">
			<input type="hidden" id="id" value="<?php echo $info["id"]; ?>">
			<div class="text-muted"> <?php echo $info["description"]; ?></div>
			<div><small class="text-muted"><?php echo number_format(count($tracks)); ?> <?php echo ___('social_songs'); ?></small></div>
			<div><small><?php echo number_format($info["followers"]); ?> <?php echo ___('label_profile_followers'); ?></small></div>
		</div>
	</div>

	<button class="button btn-block btn-start">Start!</button>
</div>

<ul class="tracks sort">
<?php
foreach ($tracks as $key => $value) {
	?>
	<li class="truncate">
		<img src="<?php echo $value["picture"]; ?>">
		<span class="close">&times;</span>
		<span class="track"><?php echo $value["track"]; ?></span>
		<span class="artist"><?php echo $value["artist"]; ?></span>		
	</li>
	<?php
}
?>
</ul>