 <?php
	$id 		= 0;
	$content 	= '';
	$title 		= '';
	if($editpages)
	{
		$temp 		= $editpages->result_array();
		$id 		= $temp[0]['idpage'];
		$content 	= $temp[0]['content'];
		$title_page		= $temp[0]['title'];
	}
?>

 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 			<input type="hidden" name="id" value="<?php echo intval($id); ?>">
					<input required maxlength="25" type="text" value="<?php echo $title_page; ?>" class="form-control" name="title" style="width:100%" placeholder="Title">
					<br>
					<textarea  name="content" style="min-height:350px;" class="tinymce"><?php echo $content; ?></textarea>
		 		</div>

			
				<div class="box-footer">
					<button type="submit" class="btn btn-primary" style="width:100%">Save</button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>

