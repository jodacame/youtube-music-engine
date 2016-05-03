 <?php 
 	if($users->num_rows()>0)
 	{
 		foreach ($users->result() as $row) {	    	 			
	    	@$type[$row->type]++;
	    		
	    }
	}
	    	?>
<div class="row">            


	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-green">
	        <div class="inner">
	            <h3>
	              <?php echo number_format($type['guest']); ?>
	            </h3>
	            <p>
	                Guest
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-eye"></i>
	        </div>
	   		 <span class="small-box-footer">
	   		 &nbsp;
	   		 </span>
	    </div>
	</div><!-- ./col -->   

	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-blue">
	        <div class="inner">
	            <h3>
	              <?php echo number_format($type['user']); ?>
	            </h3>
	            <p>
	                Registered
	            </p>
	        </div>
	        <div class="icon">
	            <i class="ion ion-person-add"></i>
	        </div>
	   		 <span class="small-box-footer">
	   		 &nbsp;
	   		 </span>
	    </div>
	</div><!-- ./col -->   

	<div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-red">
	        <div class="inner">
	            <h3>
	              <?php echo number_format($type['robot']); ?>
	            </h3>
	            <p>
	                Robots
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-flask"></i>
	        </div>
	   		 <span class="small-box-footer">
	   		 &nbsp;
	   		 </span>
	    </div>
	</div><!-- ./col -->   

	 <div class="col-lg-3 col-xs-6">
	    <div class="small-box bg-yellow">
	        <div class="inner">
	            <h3>
	              <?php echo number_format($type['other']); ?>
	            </h3>
	            <p>
	                 Others
	            </p>
	        </div>
	        <div class="icon">
	            <i class="fa fa-question"></i>
	        </div>
	   		 <span class="small-box-footer">
	   		 &nbsp;
	   		 </span>
	    </div>
	</div><!-- ./col -->   



</div>

<table id="tableOnline"  class="table table-striped table-bordered table-hover">
  <thead>
	        <tr>
	            
	            <th>User</th>
	            <th>Nickname</th>	            
	            <th>IP</th>	            
	            <th>Last Activity</th>	            
	        </tr>
	    </thead>
	    <tbody>
	    <?php 
	    if($users->num_rows()>0)
 		{
	    foreach ($users->result() as $row) {
	    	$data = unserialize($row->user_data);
	    	if($row->nickname != '')
	    	{
	    		if($row->idfacebook != '')
	    			$row->username = '<a href="http://facebook.com/'.$row->idfacebook.'"><i class="fa fa-facebook-square"></i> '.$row->names.'</a>';
	    		?>
	    		<tr>
	    		
	    		<td><img style="max-height:24px;max-width:24px;margin-right:10px" class="pull-left" src="<?php echo $row->avatar; ?>"> <?php echo $row->username; ?></td>
	    		<td><a href="<?php echo base_url(); ?>user/<?php echo $row->nickname; ?>"><?php echo $row->nickname; ?></a></td>
	    		<td><?php echo $row->ip; ?></td>
	    		<td><?php echo ago(strtotime($row->last_activity)); ?></td>
	    		</tr>
	    		<?php
	    	}
	    	?>
	    	
	    	<?php
	    }
		}
	    ?>
	    </tbody>	  
</table>
<script>
$(function () {
	 $('#tableOnline').dataTable();
});
</script>