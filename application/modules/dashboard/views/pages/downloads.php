<div class="row">            
 	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-green">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($total->total); ?>
	            </h3>
	            <p>
	                Total Downloads
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-cloud-download"></i>
	        </div>
	   		 	<span  class="small-box-footer">
	            <br>
		        </span>
	    </div>
	</div><!-- ./col -->    
 	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-red">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($total->mp3); ?>
	            </h3>
	            <p>
	               Youtube MP3
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-file-audio-o"></i>
	        </div>
	         	<span  class="small-box-footer">
	            <br>
	        	</span>
	      
	    </div>
	</div><!-- ./col -->    
 	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-aqua">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($total->itunes); ?>
	            </h3>
	            <p>
	              iTunes
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-apple"></i>
	        </div>
	        <a href="https://itunes.phgconsole.performancehorizon.com/login/itunes/"  class="small-box-footer">
	            Go to iTunes <i class="fa fa-arrow-circle-right"></i>
	        </a>
	    </div>
	</div><!-- ./col -->    
 <div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-yellow">
	        <div class="inner">
	            <h3>
	                  <?php echo number_format($total->amazon); ?>
	            </h3>
	            <p>
	              Amazon
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-shopping-cart"></i>
	        </div>
	      <a href="https://affiliate-program.amazon.com/"  class="small-box-footer">
	            Go to Amazon <i class="fa fa-arrow-circle-right"></i>
	        </a>
	    </div>
	</div><!-- ./col -->    

	<div class="col-md-12">
		<div class="box box-success">
		 	<div class="box-body">
				<h4 class="text-center">Top 100 Downloads</h4>
			 	<table class="table table-striped table-bordered table-hover" id="tableDownloads">
				  <thead>
				    <tr>	
				    	<th class="text-center"><i class="fa fa-cloud-download"></i></th>			      
				      	<th>Artist</th>
				      	<th>Track</th>
				      	<th class="text-center" title="Youtube MP3"><i class="fa fa-file-audio-o"></i> </th>				   
				      	<th class="text-center" title="iTunes"><i class="fa fa-apple"></i> </th>				   
				      	<th class="text-center" title="Amazon"><i class="fa fa-shopping-cart"></i> </th>				   
				      	<th class="text-center">Total</th>				   
				    </tr>
				  </thead>
				  <tbody>
				  <?php
				  $x=0;				  
				  foreach ($top->result() as $row) {
				  	$x++;
				  	?>
				  	 <tr>		
				  	  <td class="text-center"> <?php echo $x; ?></td>		  				      
				      <td class="text-left"><?php echo $row->artist; ?> </td>
				      <td class="text-left"><?php echo $row->track; ?> </td>
				      <td class="text-center"><?php echo number_format($row->mp3,0); ?> </td>
				      <td class="text-center"><?php echo number_format($row->itunes,0); ?> </td>
				      <td class="text-center"><?php echo number_format($row->amazon,0); ?> </td>
				      <td class="text-center"><strong><?php echo number_format($row->total,0); ?> </strong></td>
				      
				    			
				    </tr>	
				  	<?php
				  }
				   ?>			   
				  </tbody>
				</table> 
			</div>
		</div>
	</div>
<script>
$(function () {
	 $('#tableDownloads').dataTable();
});
</script>


</div>