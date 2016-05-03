 <div class="row">            
 	<div class="col-md-4">
	    <div class="small-box bg-yellow">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($users_t->num_rows()); ?>
	            </h3>
	            <p>
	                Users
	            </p>
	        </div>
	        <div class="icon">
	            <i class="ion ion-person-add"></i>
	        </div>
	   		 <a href="<?php echo base_url(); ?>dashboard/users" class="small-box-footer">
	            Total Users Registered <i class="fa fa-arrow-circle-right"></i>
	        </a>  
	    </div>
	</div><!-- ./col -->    

	<div class="col-md-4">
	    <div class="small-box bg-purple">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($users->num_rows()); ?>
	            </h3>
	            <p>
	                Subscriptions
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-user"></i>
	        </div>
	   		 <a href="<?php echo base_url(); ?>dashboard/users" class="small-box-footer">
	            Total Subscriptions <i class="fa fa-arrow-circle-right"></i>
	        </a>  
	    </div>
	</div><!-- ./col -->   	

	<div class="col-md-4">
	    <div class="small-box bg-green">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($emails_sent); ?>
	            </h3>
	            <p>
	                Emails Sent
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-paper-plane"></i>
	        </div>
	   		 <span class="small-box-footer">
	            Total
	        </span>  
	    </div>
	</div><!-- ./col -->   

</div>

 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
						<div class="form-group col-md-12">
							<img src="<?php echo base_url(); ?>assets/images/email/header.png"  class="img-thumbnail" style="width:100%">
							<small class="inline-help pull-right"><i class=" fa fa-image"></i> <strong>Header:</strong> Edit <i>assets/images/email/header.png</i> file</small>
						</div>

					  <div class="form-group col-md-12">
					    <label >Title</label>
					    <input  required name="newsletter_title" type="text" class="form-control" placeholder="" value="<?php echo htmlentities($this->config->item("newsletter_title"), ENT_QUOTES, "UTF-8"); ?>">					    
					  </div>   
					  <div class="form-group col-md-12 hide">
					    <label >Base URL</label>
					    <input  name="newsletter_base_url" type="hidden" class="form-control" placeholder="" value="<?php echo base_url(); ?>">					    
					  </div> 


					  <div class="form-group col-md-12">
					    <label >Desciption Text</label>
					    <textarea   class="form-control" name="newsletter_description" placeholder="" style="width:100%;min-height:100px"><?php echo htmlentities($this->config->item("newsletter_description"), ENT_QUOTES, "UTF-8"); ?></textarea>
					</div>  


					  <div class="form-group col-md-3">
					    <label >Recommended for You</label>
					     <select  name="newsletter_mod_recommended" class="form-control">
					    	<option <?php if($this->config->item("newsletter_mod_recommended") == '1'){ echo "selected"; } ?> value="1">Yes</option>
					    	<option <?php if($this->config->item("newsletter_mod_recommended") == '0'){ echo "selected"; } ?> value="0">No</option>					    	
					    </select>
					  </div> 	

					    <div class="form-group col-md-3">
					    <label >The Most Listened</label>
					     <select  name="newsletter_mod_the_most_listened" class="form-control">
					    	<option <?php if($this->config->item("newsletter_mod_the_most_listened") == '1'){ echo "selected"; } ?> value="1">Yes</option>
					    	<option <?php if($this->config->item("newsletter_mod_the_most_listened") == '0'){ echo "selected"; } ?> value="0">No</option>					    	
					    </select>
					  </div> 	

					    <div class="form-group col-md-3">
					    <label >Top Artist This Weekend</label>
					     <select  name="newsletter_mod_top_artist_weekend" class="form-control">
					    	<option <?php if($this->config->item("newsletter_mod_top_artist_weekend") == '1'){ echo "selected"; } ?> value="1">Yes</option>
					    	<option <?php if($this->config->item("newsletter_mod_top_artist_weekend") == '0'){ echo "selected"; } ?> value="0">No</option>					    	
					    </select>
					  </div> 	

					    <div class="form-group col-md-3">
					    <label >Trending Now</label>
					     <select  name="newsletter_mod_trending_now" class="form-control">
					    	<option <?php if($this->config->item("newsletter_mod_trending_now") == '1'){ echo "selected"; } ?> value="1">Yes</option>
					    	<option <?php if($this->config->item("newsletter_mod_trending_now") == '0'){ echo "selected"; } ?> value="0">No</option>					    	
					    </select>
					  </div> 	


					 <div class="form-group col-md-12">
					    <label >Footer Text</label>
					    <textarea   class="form-control" name="newsletter_footer" placeholder="" style="width:100%;min-height:100px"><?php echo htmlentities($this->config->item("newsletter_footer"), ENT_QUOTES, "UTF-8"); ?></textarea>
					</div>  

					  <div class="form-group col-md-12">
					    <label >Key (Required for Run Script)</label>
					    <input  required name="newsletter_key" type="text" class="form-control" placeholder="" value="<?php echo $this->config->item("newsletter_key"); ?>">					    
					    <small class="inline-help text-danger">Change this for security</small>
					  </div> 

					

		 		</div>
				<div class="clearfix"></div>
				<div class="box-footer btn-grpup">
					<button type="submit" class="btn btn-primary btn-block" >Save</button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>

	<div class="col-xs-12">
	 	<div class="box box-danger">
	 	 	
		 		<div class="box-body">
		 		<br>	<form method="GET" target="_blank" action="<?php echo base_url(); ?>music/newsletter/<?php echo $this->config->item("newsletter_key"); ?>">
		 		 <div class="input-group">
				   
				      <input type="email" class="form-control" name="example" placeholder="my@email.com" required value="<?php echo $this->session->userdata('username'); ?>">
				         <span class="input-group-btn" >
				        <button class="btn btn-primary" type="submit">Send Example!</button>
				      </span>
				    
				    </div>  </form>
				    <br>
				    <br>
		 			<div class="alert alert-warning">
		 				Use <a href="http://en.wikipedia.org/wiki/Cron"><strong>Cron</strong></a> to send newsletters <i>reccomended for many subscribers</i><br>
		 				<br>
		 				<strong>Example <a href="http://en.wikipedia.org/wiki/Cron">Cron</a> Every Week:</strong><br>
		 				<i>
		 				5 8 * * 6 php <?php echo str_ireplace("system/","",BASEPATH); ?>index.php  music newsletter <?php echo $this->config->item("newsletter_key"); ?>
		 				</i>
		 			</div>
		 			<div id="pr" style="display:none">
		 			   <div class="progress">
                            <div class="progress-bar progress-bar-info" id="total" role="progressbar"  style="width: 0%">
                                   Sent
                            </div>
                        </div>

                         <div class="progress">
                            <div class="progress-bar progress-bar-danger"  id="error" role="progressbar"  style="width: 0%">
                                   Error
                            </div>
                        </div>

                         <div class="progress">
                            <div class="progress-bar progress-bar-green"  id="sent" role="progressbar"  style="width: 0%">
                                   Success
                            </div>
                        </div>
                       </div>
		 		</div>
		 		<div class="clearfix"></div>
				<div class="box-footer btn-grpup">					
					<button  onClick="startSend();" class="btn btn-danger btn-block" >Send Now! [<?php echo number_format($users->num_rows(),0); ?> Emails] (This can take long time, Don't Close Window)</button>
				</div>
		
		 </div>
	</div>
</div>

<script>
var users = new Array();
var error 	= 0;
var sent 	= 0;
var current = 0;
var total 	= <?php echo $users->num_rows(); ?>;
<?php 
	$x=0;
	foreach ($users->result() as $row) {
	?>
	users[<?php echo $x; ?>] 	=  '<?php echo $row->username; ?>';
	<?php	
	$x++;
}
?>
function startSend(i)
{
		$("#pr").fadeIn(500);
		if(i>total)
			return false;
		
		if(users[current] == '')
			users[current] = 'dummy@dummy.com';
		$.post(base_url+'music/newsletter/<?php echo $this->config->item("newsletter_key"); ?>',{target: users[current]}, function(data, textStatus, xhr) {
					current++;
				 	
				 	if(data.error == '1')
				 		error++;
				 	if(data.sent == '1')
				 		sent++;


				 	por1 = (error*100)/total;
				 	por2 = (sent*100)/total;
				 	por3 = (current*100)/total;
				 	$("#total").width(por3+"%");
				 	$("#error").width(por1+"%");
				 	$("#sent").width(por2+"%");
				 	console.log(current+"/"+total);
				 	startSend(current);

		},'json');		 
	
}


</script>