 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 			 	<div class="row">
		 			 		<?php if($msg){ ?>
		 			 			<div class="alert alert-success">
		 			 				<?php echo $msg; ?>
		 			 			</div>
		 			 		<?php } ?>
							<div class="col-xs-12">	
										<a href="?backup=1" class="btn btn-success pull-right"><i class="fa fa-download"></i> Generate Backup</a>
										<br>
										<br>
						 				<table class="table table-striped table-hover ">						 					

						 					<tr>
						 						<td><strong><i class="fa fa-database"></i> Database Name </strong></td>
						 						<td><?php echo $this->db->database; ?></td>						 						
						 						<td></td>						 						
						 						<td></td>						 						
						 						<td></td>						 						
						 						<td></td>						 						
						 					</tr>		
						 					<tr>
						 						<td><strong> Database Size </strong></td>
						 						<td><?php
								            	$temp = $database->row();	            	
								            	?>
								                <?php echo number_format($temp->used,2); ?> MB</td>						 						
						 						<td></td>						 						
						 						<td></td>						 						
						 						<td></td>						 						
						 						<td></td>						 						
						 					</tr>		
						 					<tr>
						 						<td colspan="6" class="text-center">
						 						<strong>Tables</strong>
						 						</td>
						 					</tr>
						 					<?php foreach ($tables as $key => $value) {
						 						$extra = getTableInfo($value);
						 						?>
						 						<tr>
							 						<td><span> <i class="fa fa-table"></i> <?php echo $value; ?> </span></td>
							 						<td title="Rows/Size"><span> <i class="fa fa-list-ol"></i> <?php echo number_format($extra->rows,0); ?> <small>(<?php echo formatBytes($extra->size); ?> )</small> </span></td>
							 						<td><i class="fa fa-download"></i> Backup <a href="?action=export&table=<?php echo $value; ?>&format=sql">[SQL]</a> <a href="?action=export&table=<?php echo $value; ?>&format=csv">[CSV]</a></td>						 												 						
							 						<td><i class="fa fa-refresh"></i> <a href="?action=optimize&table=<?php echo $value; ?>"> Optimze</a></td>						 						
							 						<td><i class="fa fa-wrench"></i> <a href="?action=repair&table=<?php echo $value; ?>"> Repair</a></td>						 						
							 						<td class="text-danger">
							 						<button  type="button" class="btn btn-xs btn-danger" onClick="$(this).hide();$('.truncate-<?php echo $key; ?>').slideToggle();">Truncate (Remove All Records)</button>
							 						<a  style="display:none" class="btn btn-xs btn-danger truncate-<?php echo $key; ?>" href="?action=truncate&table=<?php echo $value; ?>"><i class="fa fa-warning"></i> Click to Continue Truncate Table <?php echo $value; ?></a>
							 						</td>						 						
						 						</tr>	
						 						<?php					 				
						 					}
						 					?>

						 				</table>							 				
						 				
							</div>
						</div>
		 		</div>

			
				<div class="box-footer">				
					
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>
