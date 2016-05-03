 <div class="row">
 	<div class="col-xs-12">
 	<div class="alert alert-success">
 	<strong>This Script is Free Now</strong>	


 		<form name="_xclick" action="https://www.paypal.com/ve/cgi-bin/webscr" method="post" class="pull-right">
			
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="jodacame@gmail.com">
			<input type="hidden" name="item_name" value="A Coffee to Jodacame">
			<input type="hidden" name="currency_code" value="USD">
			<div class="input-group" style="width:250px;margin-top:-5px">
				<input type="number" class="form-control" step="1" min="1" name="amount" value="20" placeholder="USD">
				<span class="input-group-btn">
					<button class="btn btn-primary" name="submit">Donate with Paypal</button>
				</span>
			  </div><!-- /input-group -->
		</form>
    
      
      
  


 	

 	</div>
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 			 	<div class="row">
							<div class="col-xs-12">		

									  <?php 									  
									   if(!$license) 
									  	{ 
									  	
									  		?><div class="alert alert-danger">Purchase Code Not is Valid!</div>													
									  		<?php if($this->session->flashdata('error_license')){ ?>
									  			<div class="alert alert-danger"><?php echo $this->session->flashdata('error_license'); ?></div>													
									  		<?php } ?>
									  	
									  	<?php }?>
								
						 				<table class="table table-striped table-hover ">
						 					<tr>
						 						<td><strong>Item Name</strong></td>
						 						<td><?php echo $license['name'] ?></td>
						 					</tr>						 					
						 					
						 					<tr>
						 						<td><strong>Author</strong></td>
						 						<td><a href="<?php echo $license['author_url']; ?>"><?php echo $license['author']; ?></a></td>
						 					</tr>
						 					<tr>
						 						<td><strong>License</strong></td>
						 						<td><?php echo $license['license'];?></td>
						 					</tr>						 					
						 					<tr>
						 						<td><strong>Server</strong></td>
						 						<td><?php echo $this->input->server('SERVER_ADDR'); ?> - <?php echo $this->input->server('SERVER_SOFTWARE'); ?>  </td>
						 					</tr>
						 					<tr>
						 						<td><strong>Domain</strong></td>
						 						<td><?php echo base_url(); ?>  </td>
						 					</tr>
						 					
						 				</table>			
								
							</div>
						</div>
		 		</div>

			
				<div class="box-footer">
					
			  	<?php echo $error; ?>	
			
			</form>
		</div>	
	</div>
</div>
