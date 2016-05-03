<div class="col-md-12">
				
			 	<table class="table table-striped table-bordered table-hover" id="tableUsers">
				  <thead>
				    <tr>	
				    	
				      	<th>Language</th>
				      	<th>Code</th>
				      	<th>Translated</th>
				      	<th>Progress</th>
				      	<th>Actions</th>				   				      	
				      	
				    </tr>
				  </thead>
				  <tbody>
				  <?php
				  $x=0;
				  
				  foreach ($langs->result() as $row) {		

				 	 $lang = $this->admin->getTable("language",array("language" => $row->language),"language");	
				 	 $total =  $lang->num_rows();		  	
				 	 $not 	= 0;
				 	 
				 	 foreach ($lang->result() as $row2) {
				 	 	if($row2->text == '')
				 	 		$not++;
				 	 }

				 	 $yes 	= $total-$not;
				 	 $por 	= intval(($yes*100)/$total);
				 	 
				  	?>
				  	 <tr>						  	    
				      <td class="text-left"><i class="fa fa-language"></i> <?php echo $row->language; ?>  </td>
				      <td class="text-left"><?php echo $row->iso; ?> </td>				      
				      <td class="text-left"><?php echo $yes; ?> of <?php echo number_format($total); ?> <?php if($not>0){ ?><small class="text-danger">(-<?php echo number_format($not); ?>)</small> <?php } ?></td>				      
				      <td class="text-left">
				      	<div class="progress">
							  <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo  $por ; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo  $por ; ?>%;">
							    <?php echo  $por ; ?>%
							  </div>
							</div>
				      </td>				      
						
				     <td class="text-left" style="width:150px">
				     		<?php if( $total >0){ ?>
				      			<a   href="?download=<?php echo $row->language; ?>" title="Generate and Download File" class="btn btn-xs btn-primary"><i class="fa fa-download"></i></a>
				      		<?php } ?>
				      		<a  href="?r=<?php echo $row->language; ?>" title="Remove Language" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>
				      		<?php if( $total >0){ ?>
				      			<a  href="<?php echo base_url(); ?>dashboard/language_edit/<?php echo $row->language; ?>"  title="Translate Lines" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
				      		<?php } ?>
				      		<a  href="?sync=<?php echo $row->language; ?>" title="Sync New Labels" class="btn btn-xs btn-success"><i class="fa fa-refresh"></i></a>
				      		<?php if(file_exists("./application/language/".$row->language."/".$row->language."_lang.php")){ ?>
				      		<a  href="?restore=<?php echo $row->language; ?>" title="Restore labels from local file application/language/<?php echo $row->language; ?>/<?php echo $row->language; ?>_lang.php" class="btn btn-xs btn-warning"><i class="fa fa-upload"></i></a>
				      		<?php } ?>
				      		
				      		
				      </td>				
				    </tr>	
				  	<?php
				  }
				   ?>			   
				  </tbody>
				</table> 
				<br>
				<button class="btn btn-info btn-block" onclick="$('#frmlang').slideToggle(500)">Add New Language</button>
				<br>
				<br>
				<form id="frmlang" style="display:none" method="post"  class="box box-primary">
					<div class="box-body">
					  	<div class="form-group col-md-6">
						    <label >Language</label>
						   	<input name="language"  required type="text" class="form-control" placeholder="Ex. spanish" >	
						  </div> 
						<div class="form-group col-md-6">
						    <label >ISO Code</label>
						    <a class="pull-right" href="http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes">Code List</a>
						   	<input name="iso" required  type="text" class="form-control" placeholder="Ex. es" >	
						  </div> 

					</div>
					<div class="clearfix"></div>
					<div class="box-footer">
						<button class="btn btn-success btn-block">Save</button>
					</div>
				</form>
				<br>
				<a href="http://support.jodacame.com/knowledge-base/how-to-translate-youtube-music-engine" class="link pull-right"><strong>Help:</strong> How to translate Youtube Music Engine?</a>
		
	</div>
<script>
function removeUser(id,email)
{

	if (confirm("Remove "+email)) {				
			$.post(base_url+"dashboard/removeUser", {id:id}, function(data, textStatus) {
				location.reload();
			});
		
	}
}
$(function () {
	 $('#tableUsers').dataTable();
});
</script>