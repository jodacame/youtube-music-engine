<?php $items = getCarousel(); ?>
 <div class="row">
 	<div class="col-md-8 <?php if($badges->num_rows() == 0) { echo 'hide'; } ?>">
	 	<div class="box box-warning">	 	 	
	 	 		<div class="box-header">
	 	 			<h3 class="box-title"><i class="fa fa-trophy"></i> Badges</h3>
	 	 		</div>
		 		<div class="box-body">		 
                <?php if(file_exists('./application/modules/music/controllers/musik.php')){ ?>			
		 			

                    <table class="table table-hover table-stripped">
                    <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Value</th>
                        <th></th>
                    </tr>
                        <?php foreach ($badges->result() as $row) {
                            ?>
                            <tr>
                                <td>
                                    <img  style="width:16p;height:16px" src="<?php echo base_url(); ?>assets/css/themes/musik/images/badges/<?php echo $row->badge; ?>"></td>
                                    <td><?php echo $row->title; ?></td>
                                    <td> > <?php echo $row->value; ?></td>
                                    <td><a href="?id=<?php echo $row->id; ?>"><i class="fa fa-trash-o"></i></a></td>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>

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
    <div class=" col-md-<?php if($badges->num_rows() == 0) { echo '12'; }else { echo '4'; } ?>">
        <div class="box box-success">           
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-gears"></i> New Badge</h3>
                </div>
                <div class="box-body">       
                <?php if(file_exists('./application/modules/music/controllers/musik.php')){ ?>          
                    <form role="form" enctype="multipart/form-data"  method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="form-group">
                                <label> Title </label>
                                 <input type="text" name="title" class="form-control">
                                </div>
                             <div class="form-group">
                                <label>Type</label>
                                 <select  required name="type" id="type" class="form-control">
                                    <option  value="" selected></option>
                                    <option  value="follows_users">Following Users</option>
                                    <option  value="followed_users">Followed Users</option>
                                    <option  value="listen_song">Listened Songs</option>
                                    <option  value="listen_artist">Listened Artist</option>
                                    <option  value="chat">Chatted with Friends</option>
                                    
                                                                        
                                </select>
                            </div>

                               <div class="form-group">
                                <label> <span id="that"></span> > That </label>
                                 <input type="number" name="value" class="form-control">
                            </div>

                               <div class="form-group">
                                <label>Icon</label>
                                <i class="pull-right fa fa-info-circle" title="assets/css/themes/musik/images/badges/*"></i>
                                 <select  required name="badge" id="badges" class="form-control">

                                 <?php 
                                   $this->load->helper('directory');
                                    $badge = directory_map('./assets/css/themes/musik/images/badges/');
                                    array_multisort($badge);
                                    foreach ($badge as $key => $value) {
                                        ?> <option  value="<?php echo $value; ?>"><?php echo $value; ?></option><?php
                                    }
                                    ?>
                                   
                                 
                                    
                                                                        
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


<script>
$(function () {

    function format(state) {
        if (!state.id) return state.text; // optgroup
        return "<img style='width:16px;height16px' class='flag' src='<?php echo base_url(); ?>assets/css/themes/musik/images/badges/" + state.text + "'/> " + state.text;
    }
    $("#badges").select2({
        formatResult: format,
        formatSelection: format,
        escapeMarkup: function(m) { return m; }
    });

    $("#type").change(function (e) {
        e.preventDefault();
        $("#that").text($("#type option:selected").text());
    });


});

</script>