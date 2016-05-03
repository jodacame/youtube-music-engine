 <?php

 $feed = json_decode(getAddons());
 ?>
 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 		<?php
		 		if(count($feed) == 0)
				{
					?>
					<br>
					<div class="alert alert-info"><i class="fa fa-star"></i> Coming Soon</div>
					<?php
				}else{
				?>
		 		<table class="table table-stripped table-hover ">
		 			<thead>
		 				<tr>
		 					<th></th>
		 					<th>Item</th>
		 					<th class="hidden-xs hidden-sm hidden-md">Description</th>
		 					<th>Price</th>
		 					<th></th>
		 				</tr>
		 			</thead>
		 			<tbody>
				<?php
				
					foreach ($feed as $key => $value) {
						$download = 'Download';
						if($value->price != 'Free')
							$download = 'Buy on Codecanyon.net';
						?>
						<tr>
							<td style="vertical-align:middle;min-width:64px"><img src="<?php echo $value->icon; ?>"></td>
							<td  style="vertical-align:middle;font-size:12px"><?php echo $value->title; ?></td>
							<td class="hidden-xs hidden-sm hidden-md" style="vertical-align:middle;font-size:12px"><?php echo $value->description; ?></td>
							<td  style="vertical-align:middle;font-size:12px"><strong><?php echo $value->price; ?></strong></td>
							<td  style="vertical-align:middle"><a href="<?php echo $value->url; ?>" class="btn btn-success"><?php echo $download; ?></a></td>
						</tr>
						<?php
					}
				

				?>
				</tbody>
				</table>
				<?php } ?>
	



					

		 		</div>
				<div class="clearfix"></div>
		
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>

