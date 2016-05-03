
 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
		    <!-- form start -->
			 <form role="form" method="POST" accept-charset="UTF-8">
			 	<div class="box-body">
			 	  <button type="submit" class="btn btn-success btn-block">Save</button>
			 	  <br>
			 	  <br>
			 	<?php foreach ($labels->result() as $row) { ?>
				  <div class="form-group col-md-4">
				    <label ><?php echo $row->key; ?> </label>				    
				    <input name="<?php echo $row->key; ?>" type="text" class="form-control" placeholder="<?php echo ___($row->key); ?>" value="<?php echo htmlentities($row->text, ENT_QUOTES, "UTF-8"); ?>">
				  </div>
				  <?php } ?>
				 </div>
				  <div class="clearfix"></div>
				      <div class="box-footer">
			            <button type="submit" class="btn btn-success" style="width:100%">Save</button>
			        </div>
			</form>
		</div>
	</div>
</div>

