<?php 
$items = getStations(); 
if($edit)
{
	$edit = $edit->result_array();
	$edit = $edit[0];

	
}

?>
 <div class="row">
 	<div class="col-md-7">
	 	<div class="box box-warning">	 	 	
	 	 		<div class="box-header">
	 	 			<h3 class="box-title"><i class="fa fa-picture-o"></i> New Station Streaming</h3>
	 	 		</div>
		 		<div class="box-body">		 
                <?php if(file_exists('./application/modules/music/controllers/musik.php')){ ?>			
		 			<form role="form" enctype="multipart/form-data"  method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" required name="title" class="form-control" id="title" value="<?php echo $edit['title']; ?>" placeholder="">
                            </div>

                             <div class="form-group">
                                <label for="m3u">Streaming Url</label>
                                <input type="text" required name="m3u" class="form-control" id="m3u" value="<?php echo $edit['m3u']; ?>"  placeholder="">
                            </div>

                           <div class="form-group">
                                <label for="description">Description</label>
                                <textarea  name="description" class="form-control tinymce" value=""  id="description" placeholder=""><?php echo $edit['description']; ?></textarea>
                            </div>

                            <div class="form-group">
							    <label >Keywords Search</label>
							    <i class="fa fa-info-circle pull-right" style="cursor:help" title="This is not visible, is used to when users search"></i>
							    <input  data-role="tagsinput" name="keywords" type="text" value="<?php echo $edit['keywords']; ?>" class="form-control" placeholder="Artists Name, Tracks Names, Albums Name, etc.." >
							  </div>

							 <div class="form-group">
							    <label >Category</label>							    
							    <input  data-role="tagsinput" name="category" type="text" value="<?php echo $edit['category']; ?>" class="form-control" placeholder="Category for Station (Only List Style)">
							 </div>



                   

							
                            <div class="form-group">
                                <label for="cover">Cover</label>
                                <input name="upload" class="file"  data-show-preview="true" data-show-upload="false" accept="image/png, image/jpeg, image/jpg" type="file" id="cover">
                                <p class="help-block text-success">Recomended: 300x200 Pixels</p>
                            </div>      
                            
                             

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success btn-block">Save</button>
                        </div>
                    </form>
                    <?php }else{ ?>
                    <br>
                    <div class="alert alert-danger">
                        <strong>Module Require:</strong> Musik Extend For Youtube Music Engine
                    </div>
                    <?php } ?>
                    <div class="clearfix"></div>
				</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="box box-warning">	 	 	
	 	 		<div class="box-header">
	 	 			<h3 class="box-title"><i class="fa fa-search"></i> Search on TuneIn</h3>
	 	 		</div>
		 		<div class="box-body">	
		 		   <div class="input-group">
				      <input type="text" class="form-control" id="station_search" placeholder="Search ...">
				      <span class="input-group-btn">
				        <button class="btn btn-default btn-search-station" type="button">Go!</button>
				      </span>
				    </div><!-- /input-group -->	
				    <div id="resulttunein">
				    </div>
		 		</div>
		 </div>
	</div>
</div>		 	

<div class="row">
	<div class="col-xs-12">
	<ul class="list-group">
	<?php foreach ($items->result() as $row) {
		?>
		 <li class="list-group-item">
		 	<img src="<?php echo base_url(); ?>uploads/stations/<?php echo $row->cover; ?>" style="width:34px;max-height:24px;padding-right:10px" class="pull-left">
		 	<?php echo $row->title; ?>
			<div class="pull-right">
		 		  	<a href="<?php echo base_url(); ?>dashboard/stations/remove/<?php echo $row->idtstation; ?>" class="btn btn-xs btn-danger " role="button"><i class="fa fa-trash-o"></i> Delete</a>                
		        	<a href="<?php echo base_url(); ?>dashboard/stations/edit/<?php echo $row->idtstation; ?>" class="btn btn-xs  btn-info " role="button"><i class="fa fa-pencil"></i> Edit</a>                
		 	</div>
		 </li>
	  <?php
	}
	?>
	</ul>
	</div>
</div>

