 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 			 	<div class="row">
							<div class="col-xs-12">	
										<a href="?cache=1" class="btn btn-danger pull-right">Clear Cache</a>
										<br>
										<br>
						 				<table class="table table-striped table-hover ">
						 					

						 					<tr>
						 						<td><strong><i class="fa fa-google"></i> Links Indexed Google</strong></td>
						 						<td><strong><a href="//google.com/#q=site:<?php echo base_url(); ?>"><?php echo number_format(getGoogleLinks(base_url())); ?></a></strong></td>
						 						<td></td>
						 					</tr>
						 					<tr>
						 						<td><strong><i class="fa fa-sitemap"></i> Links Sitemap</strong></td>
						 						<td><strong><a href="<?php echo base_url(); ?>sitemap"><?php echo number_format(intval($total),0); ?></a></strong></td>
						 						<td><?php if(file_exists("./cache/sitemap/sitemap.xml")){ ?><span class="text-success"><i class="fa fa-check"></i> Cached</span> <?php }else{ ?><span class="text-danger"><i class="fa fa-warning"></i> No Cached</span> <?php } ?></td>

						 					</tr>	

						 					<tr>
						 						<td><strong>Artist Crawled</strong></td>
						 						<td><a href="<?php echo base_url(); ?>sitemap"><?php echo number_format($artist->num_rows()); ?></a></td>
						 						<td><?php if(file_exists("./cache/sitemap/sitemap_artist1.xml")){ ?><span class="text-success"><i class="fa fa-check"></i> Cached</span> <?php }else{ ?><span class="text-danger"><i class="fa fa-warning"></i> No Cached</span> <?php } ?></td>
						 					</tr>

						 					<tr>
						 						<td><strong>Tracks Crawled</strong></td>
						 						<td><a href="<?php echo base_url(); ?>sitemap"><?php echo number_format($tracks->num_rows()); ?><a href="<?php echo base_url(); ?>sitemap"></td>
						 						<td><?php if(file_exists("./cache/sitemap/sitemap_tracks1.xml")){ ?><span class="text-success"><i class="fa fa-check"></i> Cached</span> <?php }else{ ?><span class="text-danger"><i class="fa fa-warning"></i> No Cached</span> <?php } ?></td>
						 					</tr>

						 					<tr>
						 						<td><strong>Pages</strong></td>
						 						<td><a href="<?php echo base_url(); ?>sitemap/pages"><?php echo number_format($pages->num_rows()); ?></a></td>
						 						<td><?php if(file_exists("./cache/sitemap/sitemap_pages.xml")){ ?><span class="text-success"><i class="fa fa-check"></i> Cached</span> <?php }else{ ?><span class="text-danger"><i class="fa fa-warning"></i> No Cached</span> <?php } ?></td>
						 					</tr>

						 					<tr>
						 						<td><strong>Tags</strong></td>
						 						<td><a href="<?php echo base_url(); ?>sitemap/tags"><?php echo number_format(count($tags)); ?></a></td>
						 						<td><?php if(file_exists("./cache/sitemap/sitemap_tags.xml")){ ?><span class="text-success"><i class="fa fa-check"></i> Cached</span> <?php }else{ ?><span class="text-danger"><i class="fa fa-warning"></i> No Cached</span> <?php } ?></td>
						 					</tr>

						 					<tr>
						 						<td><strong>Users</strong></td>
						 						<td><a href="<?php echo base_url(); ?>sitemap/users"><?php echo number_format($users->num_rows()); ?></a></td>
						 						<td><?php if(file_exists("./cache/sitemap/sitemap_users.xml")){ ?><span class="text-success"><i class="fa fa-check"></i> Cached</span> <?php }else{ ?><span class="text-danger"><i class="fa fa-warning"></i> No Cached</span> <?php } ?></td>
						 					</tr>
						 					<?php if(file_exists("./application/modules/music/controllers/musik.php")){ ?>
						 					<tr>
						 						<td><strong>Stations</strong></td>
						 						<td><a href="<?php echo base_url(); ?>sitemap/stations"><?php echo number_format($stations->num_rows()); ?></a></td>
						 						<td><?php if(file_exists("./cache/sitemap/sitemap_stations.xml")){ ?><span class="text-success"><i class="fa fa-check"></i> Cached</span> <?php }else{ ?><span class="text-danger"><i class="fa fa-warning"></i> No Cached</span> <?php } ?></td>
						 					</tr>						 					
						 					<tr>
						 						<td><strong>Playlist</strong></td>
						 						<td><a href="<?php echo base_url(); ?>sitemap/playlist"><?php echo number_format($playlist->num_rows()); ?></a></td>
						 						<td><?php if(file_exists("./cache/sitemap/sitemap_playlist.xml")){ ?><span class="text-success"><i class="fa fa-check"></i> Cached</span> <?php }else{ ?><span class="text-danger"><i class="fa fa-warning"></i> No Cached</span> <?php } ?></td>
						 					</tr>
						 					<?php } ?>
						 					<tr>
						 						<td><strong>Lyrics</strong></td>
						 						<td><a href="<?php echo base_url(); ?>sitemap/"><?php echo number_format($lyrics->num_rows()); ?></a></td>
						 						<td><?php if(file_exists("./cache/sitemap/sitemap_lyrics1.xml")){ ?><span class="text-success"><i class="fa fa-check"></i> Cached</span> <?php }else{ ?><span class="text-danger"><i class="fa fa-warning"></i> No Cached</span> <?php } ?></td>
						 					</tr>

						 				</table>			
								
							</div>
						</div>
		 		</div>

			
				<div class="box-footer">				
			  	
				<a target="_blank" href="https://www.google.com/webmasters/tools/sitemap-list?hl=en&siteUrl=<?php echo base_url(); ?>">Check Sitemap on Google Webmaster Tools</a>				
				<br>
				<br>
				<a target="_blank" href="http://support.jodacame.com/knowledge-base/submit-sitemap-to-google">How Can Submit Sitemap to Google?</a>				
				<br>
				<br>
				<a target="_blank" href="http://support.jodacame.com/knowledge-base/cache-sitemap">More info about Cache Sitemap</a>				
				<br>
				<br>				
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>
