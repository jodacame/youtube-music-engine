
 <div class="row">
 	<div class="col-md-6 <?php if($routes->num_rows() == 0) { echo 'hide'; } ?>">
	 	<div class="box box-warning">	 	 	
	 	 		<div class="box-header">
	 	 			<h3 class="box-title"><i class="fa fa-map-signs"></i> Routes</h3>
	 	 		</div>
		 		<div class="box-body">		 
                
		 			

                    <table class="table table-hover table-stripped">
                    <tr>
                        <th>URL</th>
                        <th>Code</th>
                        <th>Target</th>
                        <th></th>
                    </tr>
                        <?php foreach ($routes->result() as $row) {
                            ?>
                            <tr>
                                
                                    <td><i class="fa fa-link"></i> <a href="<?php echo base_url().$row->url; ?>"><?php echo base_url().$row->url; ?></a></td>
                                    <td><a href="https://en.wikipedia.org/wiki/List_of_HTTP_status_codes"><?php echo $row->code; ?></a></td>
                                    <td><?php echo $row->target; ?></td>
                                    <td><a href="?id=<?php echo $row->id; ?>"><i class="fa fa-trash-o"></i></a></td>
                                
                            </tr>
                            <?php
                        }
                        ?>
                    </table>

                    
                    <div class="clearfix"></div>
				</div>
		</div>
	</div>
    <div class=" col-md-<?php if($routes->num_rows() == 0) { echo '12'; }else { echo '6'; } ?>">
        <div class="box box-success">           
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-map-signs"></i> New Route</h3>
                </div>
                <div class="box-body">       
                
                    <form role="form" enctype="multipart/form-data"  method="post">
                        <div class="box-body">
                            <div class="form-group">

                                  <div class="form-group">
                                <div class="alert alert-warning">
                                <strong>NOTE:</strong> Only it takes effect when it is loaded directly from the url using browser or spider.
                                </div>
                            </div>

                                
                                <div class="form-group">
                                    <label> URL </label>
                                    <div class="input-group">
                                      <span class="input-group-addon" id="basic-addon1"><?php echo base_url(); ?></span>
                                      <input type="text" class="form-control" placeholder="Use Valid URL" name="url" aria-describedby="basic-addon1">
                                    </div>
                                </div>


                             <div class="form-group">
                                <label><a href="https://en.wikipedia.org/wiki/List_of_HTTP_status_codes" target="blank">HTTP Code</a></label>
                                 <select  required name="code" id="type" class="form-control">
                                    <option  value="" selected></option>
                                    <option  value="0">000 - Redirect Location</option>                        
                                    <option  value="204">204 - No Content</option>                           
                                    <option  value="301">301 - Moved</option>                           
                                    <option  value="302">302 - Found</option>                           
                                    <option  value="400">400 - Bad Request</option>                           
                                    <option  value="401">401 - Unauthorized</option>                           
                                    <option  value="403">403 - Forbidden</option>                           
                                    <option  value="404">404 - Not found</option>                           
                                    <option  value="500">500 - Internal Error</option>                      
                                    <option  value="501">501 - Not implemented</option>  
                                    <option  value="503">503 - Service Unavailable</option>  
                                </select>
                            </div>

                            <div class="form-group">
                                <label> URL Target </label>
                                <input type="url" placeholder="" name="target" class="form-control">
                            </div>

                           

                             

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success btn-block">Save</button>
                        </div>
                    </form>
                 
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
</div>		 	



