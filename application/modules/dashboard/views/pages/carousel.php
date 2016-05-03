<?php 
$items = getCarousel(); 
$stations = getStations(); 
?>
 <div class="row">
 	<div class="col-md-8">
	 	<div class="box box-warning">	 	 	
	 	 		<div class="box-header">
	 	 			<h3 class="box-title"><i class="fa fa-picture-o"></i> New Slider</h3>
	 	 		</div>
		 		<div class="box-body">		 
                <?php if(file_exists('./application/modules/music/controllers/musik.php')){ ?>			
		 			<form role="form" enctype="multipart/form-data"  method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="titleSlider">Caption Slider</label>
                                <input type="text" required name="title" class="form-control" id="titleSlider" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="buttonAction">Button Action</label>
                                <select  required name="type" id="buttonAction" class="form-control">
                                    <option selected value="" disabled></option>
                                	<option value="start-radio">Start Radio</option>
                                    <option value="artist-info">Artist Page</option>
                                	<option value="playlist-artist">Artist Station</option>
                                    <option value="song-info">Song Page</option>
                                    <option value="station">Streaming Station</option>
                                	<option value="url">External URL</option>
                                </select>
                            </div>

                            <div class="form-group song-info start-radio artist-info playlist-artist hide-input" style="display:none">
                                <label for="artist">Artist</label>
                                <input name="artist" id="artist" class="form-control select2-artist">
                            </div>

                            <div class="form-group song-info start-radio hide-input" style="display:none">
                                <label for="song">Song</label>
                                <input id="song" name="track" class="form-control select2-song">
                                 <p class="help-block text-warning">Required for <strong>Song Page</strong> and <strong>Start Radio</strong></p>
                             </div>    

                             <div class="form-group url hide-input" style="display:none">
                                <label for="external_url">External URL</label>
                                <input id="external_url" placeholder="http://example.com" name="external_url" class="form-control">
                                 <p class="help-block text-warning">Required for <strong>External URL</strong></p>
                             </div>      
                             <div class="form-group url hide-input" style="display:none">
                                <label for="external_url_target">Target</label>
                                <select name="external_url_target" class="form-control" id="external_url_target">
                                    <option value="">Same Window</option>
                                    <option value="_blank">New Window</option>
                                    
                                </select>
                                
                                 
                             </div>       

                              <div class="form-group station hide-input" style="display:none">
                                <label for="station">Station</label>
                                <select name="station" id="station" class="form-control select2">                                    
                                    <?php
                                        foreach ($stations->result() as $row) {
                                            ?>
                                            <option value="<?php echo $row->idtstation; ?>"><?php echo $row->title; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                             </div>                                	
                            

                            <div class="form-group">
                                <label for="order">Order</label>
                                <input id="order" name="order"  type="number" value="<?php echo intval($items->num_rows() +1); ?>" class="form-control">                                 
                             </div>     


                             


                            <div class="form-group">
                                <label for="picture">Picture</label>
                                <input required name="upload" class="file" data-show-preview="true" data-show-upload="false" accept="image/png, image/jpeg, image/jpg" type="file" id="picture">
                                <p class="help-block text-success">Recomended: 1700x800 Pixels</p>
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
    <div class="col-md-4">
        <div class="box box-warning">           
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-gears"></i> Setting</h3>
                </div>
                <div class="box-body">       
                <?php if(file_exists('./application/modules/music/controllers/musik.php')){ ?>          
                    <form role="form" enctype="multipart/form-data"  method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="titleSlider">Active Carousel</label>
                                 <select  required name="carousel_active" class="form-control">
                                    <option  <?php if($this->config->item("carousel_active") == '1'){ echo "selected"; } ?> value="1">On</option>
                                    <option  <?php if($this->config->item("carousel_active") == '0'){ echo "selected"; } ?> value="0">Off</option>                                    
                                </select>
                            </div>

                             <div class="form-group">
                                <label for="titleSlider">Show Carousel</label>
                                 <select  required name="carousel_show" class="form-control">
                                    <option <?php if($this->config->item("carousel_show") == 'all'){ echo "selected"; } ?> value="all">All Users</option>
                                    <option <?php if($this->config->item("carousel_show") == 'guest'){ echo "selected"; } ?> value="guest">Only Guest Users</option>                                    
                                    <option <?php if($this->config->item("carousel_show") == 'registered'){ echo "selected"; } ?> value="registered">Only Registered Users</option>                                    
                                </select>
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
</div>		 	
<?php

$type['artist-info'] = ___('label_carousel_artist');
$type['playlist-artist'] = ___('label_artist_playlist');
$type['song-info'] = ___('label_carousel_track');
$type['start-radio'] = ___('label_carousel_radio');
$type['station'] = ___('label_station');
?>
<div class="row">
	<?php foreach ($items->result() as $row) {
		?>
		<div class="col-md-4">
		    <div class="thumbnail">
		      <img src="<?php echo base_url(); ?>uploads/<?php echo $row->picture; ?>">
		      <div class="caption">
		      <small class="text-muted pull-right"><?php echo $type[$row->type]; ?></small>
		        <h3><?php echo $row->title; ?></h3>
		        <p><?php echo $row->artist; ?> <span class="text-muted"><?php echo $row->track; ?> </span></p>	
		        
		        <p>
		        
		        <a href="<?php echo base_url(); ?>dashboard/carousel/remove/<?php echo $row->idcarousel; ?>" class="btn btn-danger btn-block" role="button"><i class="fa fa-trash-o"></i> Delete</a>
                <form method="post">
                    <div class="input-group">
                          <input type="number" required name="order2"  value="<?php echo $row->order; ?>" title="Order" palceholder="Order" class="form-control"  data-trigger="hover" data-container="body" data-toggle="popover" data-content="Update Order Slider" data-placement="top" >
                          <input type="hidden" class="hide" value="<?php echo $row->idcarousel; ?>" name="id">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Update</button>
                          </span>
                        </div><!-- /input-group -->
                </form>
		        </p>		        
		        <div class="clearfix"></div>
		      </div>
		    </div>
	  </div>
	  <?php
	}
	?>

</div>

<script>
$(function () {
    $("#buttonAction").change(function (e) {
        e.preventDefault();
        var target = $(this).val();
        $(".hide-input").hide();        
        $(".hide-input input").attr('disabled','disabled');
        $("."+target).show();                
        $("."+target+" input").removeAttr('disabled');

    });
});
</script>