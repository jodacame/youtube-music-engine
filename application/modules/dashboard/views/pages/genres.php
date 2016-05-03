 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 			 		<select name="genres[]"  id="selectm" class="form-control" multiple="multiple" style="height:100%;min-height:500px">			
								<?php
									$tags 			= json_decode(getTags());
									
									$tags_current 	= explode(",",$this->config->item("genres"));

									foreach ($tags->tags->tag as $key => $value) {
										$tmp[] = $value->name;
									}
									$custom = explode(",", $this->config->item("custom_genres"));

									natcasesort($tmp);
									foreach ($tmp as $key => $value) {
										?>
										<option <?php if(in_array($value, $tags_current)){ echo "selected";} ?>  value="<?php echo $value; ?>"><?php echo ucwords($value); ?></option>
										<?php
									}
									?>
									
									<?php
									foreach ($custom as $key => $value) {
										if( $value != ''){
										?>

										<option data-extra="<span class='label label-info pull-right'>Custom</span>" <?php if(in_array($value, $tags_current)){ echo "selected";} ?>  value="<?php echo $value; ?>"><?php echo ucwords($value); ?></option>
										<?php
										}
									}
								

									
								?>
								</select>								
								<div class="clearfix"></div>
							<h3>Custom Genres</h3>
							<input data-role="tagsinput" value="<?php echo $this->config->item("custom_genres"); ?>" name="custom_genres" style="width:100%" placeholder="Add your custom genres">
								<div class="clearfix"></div>
							  
							    <h3 >Banned Genres  <i class="fa fa-info-circle pull-right" style="cursor:help" title="Only for artist page and genres page (Musik)"></i></h3>
							    <input  placeholder="Ex. Pornogrind" data-role="tagsinput" name="banned_genres" type="text" class="form-control" placeholder="" value="<?php echo $this->config->item("banned_genres"); ?>">
								<div class="clearfix"></div>
								<h3 >Default Menu</h3>
							    <input  name="default_genre" type="text" class="form-control" placeholder="" value="<?php echo $this->config->item("default_genre"); ?>">


		 		</div>

			
				<div class="box-footer">
					<button type="submit" class="btn btn-primary" style="width:100%">Save</button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>
 <script src="<?php echo base_url(); ?>assets/js/multiselect.js" type="text/javascript"></script> 
 <script>
 $(function () {
 	$('#selectm').multiSelect({ selectableHeader: "<div class='custom-header'><center><strong>Inactives Genres</strong></center></div>",
  		selectionHeader: "<div class='custom-header'><center><strong>Actives Genres</strong></center></div>"});

 });
 </script>