 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
					  <div class="form-group col-md-6">
					    <label >SMTP Host</label>
					    <input name="smtp_host"   type="text" required class="form-control" placeholder="Example: ssl://smtp.gmail.com" value="<?php echo $this->config->item("smtp_host"); ?>">					    
					  </div> 

					  <div class="form-group col-md-6">
					    <label >SMTP Port</label>
					    <input name="smtp_port"   type="text" required class="form-control" placeholder="465" value="<?php echo $this->config->item("smtp_port"); ?>">					    
					  </div> 	

					  <div class="form-group col-md-6">
					    <label >SMTP User</label>
					    <input name="smtp_user"   type="text" required class="form-control" placeholder="myUser@email.com" value="<?php echo $this->config->item("smtp_user"); ?>">					    
					  </div> 	
					  <div class="form-group col-md-6">
					    <label >SMTP Password</label>
					    <input name="smtp_pass"   type="password" required class="form-control" placeholder="" value="<?php echo $this->config->item("smtp_pass"); ?>">					    
					  </div> 	
					   <div class="form-group col-md-6">
					    <label >From Email </label>
					     <input  name="contact_email" type="email" required class="form-control" placeholder="your@email.com" value="<?php echo $this->config->item("contact_email"); ?>">
					  </div>
						<div class="form-group col-md-6">
					    <label >Contact Email </label>
					     <input  name="contact_email2" type="email" required class="form-control" placeholder="your@email.com" value="<?php echo $this->config->item("contact_email2"); ?>">
					  </div>

		 		</div>
				<div class="clearfix"></div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary" style="width:100%">Save</button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>


 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
					  <div class="form-group col-md-6">
					    <label >Test Email Setting</label>
					    <input name="target"   type="email" class="form-control" placeholder="target@email.com" value="<?php echo $this->session->userdata("username"); ?>">					    
					  </div>   
					  <div class="form-group col-md-6">
					  <label>After Send Please Check your Email</label>
					    <button type="submit" class="btn btn-danger" style="width:100%">Send Test Email <i class="fa fa-share"></i></button>
					  </div> 


		 		</div>
				<div class="clearfix"></div>
				<div class="box-footer">	
				<?php if($error && $error != '1')			{
					?>
					<div class="alert alert-danger">
					<?php echo $error; ?>
					</div>
					<?php
				}
				else
				{
					if($error == '1')
					{
						?>
						<div class="alert alert-success">
							<i class="fa fa-check-circle"></i> Email sent successfully
						</div>
						<?php
					}

				}
				?>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>
