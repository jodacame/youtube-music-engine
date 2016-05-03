<div class="row">            
 	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-yellow">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($users); ?>
	            </h3>
	            <p>
	                User Registrations
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
 	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-green">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($playlist); ?>
	            </h3>
	            <p>
	               Music Folders
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-folder-open-o"></i>
	        </div>
	       	<span  class="small-box-footer">
	            Total Music Folders Saved
	        </span>
	    </div>
	</div><!-- ./col -->    
 	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-aqua">
	        <div class="inner">
	            <h3>
	                <?php echo number_format($activity); ?>
	            </h3>
	            <p>
	              Activity Plays
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-music"></i>
	        </div>
	        <span  class="small-box-footer">
	            Total Activity Log
	        </span>
	    </div>
	</div><!-- ./col -->    
 <div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-red">
	        <div class="inner">
	            <h3>
	                <?php echo number_format(getGoogleLinks(base_url())); ?>
	            </h3>
	            <p>
	              Google Indexed Pages
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-search"></i>
	        </div>
	       <span  class="small-box-footer">
	            Total Links Indexed Google
	        </span>
	    </div>
	</div><!-- ./col -->    


	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-aqua">
	        <div class="inner">
	            <h3>
	            	<?php
	            	$temp = $database->row();	            	
	            	?>
	                <?php echo number_format($temp->used,2); ?> MB
	            </h3>
	            <p>
	                MySQL: Used
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-database"></i>
	        </div>
	   		<a href="<?php echo base_url(); ?>dashboard/database" class="small-box-footer">
	            Database <strong><i><?php echo $this->db->database; ?></i></strong>
	        </a>
	    </div>
	</div><!-- ./col -->
        
 	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-maroon">
	        <div class="inner">
	            <h3>
	                <?php echo formatBytes($used); ?>
	            </h3>
	            <p>
	               Usage Disk Server
	               <i class="fa fa-info-circle popover-class" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="left" data-title="Shared Hosting" data-html="true" data-content="This information includes other user accounts if you have a shared hosting."></i>
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-bolt"></i>
	        </div>
	   		 <a href="#" onclick="$('#formCache').submit();" class="small-box-footer">
	            Clear Cache <i class="fa fa-refresh"></i>
	        </a>  
	        <form  method="post" class="hide" id="formCache">
	        	<input type="hidden" value="1" name="cache">
	        </form>
	    </div>
	</div><!-- ./col -->    

	

	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-purple">
	        <div class="inner">
	            <h3>
	                <?php echo formatBytes($sizeDir); ?>
	            </h3>
	            <p>
	                Free Space Disk Server
	                <i class="fa fa-info-circle popover-class" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="left" data-title="Shared Hosting" data-html="true" data-content="This information includes other user accounts if you have a shared hosting."></i>
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-tasks"></i>
	        </div>
	   		 <a href="<?php echo base_url(); ?>dashboard/users" class="small-box-footer">
	            &nbsp;
	        </a>  
	    </div>
	</div><!-- ./col -->


	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-teal">
	        <div class="inner">
	            <h3>
	                <?php echo number_format(alexaRank()); ?>
	            </h3>
	            <p>
	                Alexa Rank
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-star"></i>
	        </div>
	   		<span  class="small-box-footer">
	           &nbsp;
	        </span>  
	    </div>
	</div><!-- ./col --> 


	
</div>        

<div class="row">
	<div class="col-md-6">
		<!-- Bar chart -->
		<div class="box box-primary">
		    <div class="box-header">
		        <i class="fa fa-bar-chart-o"></i>
		        <h3 class="box-title">Users Registered Last 12 Months</h3>
		    </div>
		    <div class="box-body">
		        <div id="bar-chart" style="height: 350px;"></div>
		    </div><!-- /.box-body-->
		</div><!-- /.box -->
	</div>

	<div class="col-md-6">
		<!-- Bar chart -->
		<div class="box box-primary">
		    
		    <div class="box-body">
		         <table class="table table-bordered table-hover table-striped">
		        	<tr>
		        		<th>Month</th>
		        		<th>Users</th>
		        	</tr>
		        	<?php
		        	  foreach ($history->result() as $row) 
		        	  {
				  		?>
				  		<tr>
				  			<td><?php echo $row->month; ?></td>
				  			<td style="width:20px"><span class="badge bg-red"><?php echo number_format($row->n); ?></span></td>
				  		</tr>
				  		<?php
				  	
				  	}
				  	?>
		        </table>
		    </div><!-- /.box-body-->
		</div><!-- /.box -->
	</div>

</div>
 		<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
     	<script src="<?php echo base_url(); ?>assets/admin/js/plugins/morris/morris.min.js" type="text/javascript"></script>

<script>
<?php

				  foreach ($history->result() as $row) {
				  	$data .= "{y:'". $row->month."',a:".$row->n."},";				  	
				  	
				  }
				  $data = substr($data ,0,-1);
				   
?>
$(function () {
			$('.popover-class').popover();

                  //BAR CHART
                var bar = new Morris.Bar({
                    element: 'bar-chart',
                    resize: true,
                    data: [
                       <?php echo $data ; ?>
                    ],
                    barColors: ['#00a65a', '#f56954'],
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Users'],
                    hideHover: 'auto'
                });

});
</script>