	<?php
	$_curl = curl_version();
	?>
	<div class="col-md-12">
		
		<div class="box box-primary">
		    <div class="box-header">
	 	 			<h3 class="box-title">Minimum Requirements</h3>
	 	 		</div>
		    <div class="box-body">
		         <table class="table table-bordered table-hover table-striped">
		        	<tr>

						<td style="width:200px">Server</td>
		        		<td style="width:300px"><strong><a href="http://support.jodacame.com/knowledge-base/youtube-music-engine-htaccess">.htaccess File</a></strong></td>
		        		<td><?php if(file_exists("./.htaccess")){ echo '<span class="text-success">Ok</span>'; }else { echo "<span class='text-danger'>Error</span>"; } ?></td>
		        	</tr>
 					<?php if(function_exists('apache_get_modules')){ ?>
		        	<tr>
		        		<td>Server</td>
		        		<td><strong><a href="http://support.jodacame.com/knowledge-base/enable-mod_rewrite-in-ubuntu-12-04-lts">Mod Rewrite Module</a></strong></td>
		        		<td><?php  if (in_array('mod_rewrite', apache_get_modules())) { echo '<span class="text-success">Ok</span>'; }else { echo "<span class='text-danger'>Error</span>"; } ?></td>
		        	</tr>
		        	<?php } ?>
		        	<tr>
		        		<td>Server</td>
		        		<td><strong><a href="http://askubuntu.com/questions/9293/how-do-i-install-curl-in-php5">Curl Module</a></strong></td>
		        		<td><?php if (extension_loaded('curl')) { echo '<span class="text-success">Ok</span>'; }else { echo "<span class='text-danger'>Error</span>"; } ?></td>
		        	</tr>
		        	<tr>
		        		<td>Server</td>
		        		<td><strong><a href="http://codecanyon.net/item/youtube-music-engine/7490975#Requeriments">Web Server</a></strong></td>
		        		<td><?php if (isApache()) { echo '<span class="text-success">OK '.$_SERVER["SERVER_SOFTWARE"].'</span>'; }else { echo "<span class='text-danger'>Error ".$_SERVER["SERVER_SOFTWARE"]."</span>"; } ?></td>
		        	</tr>

		        	<tr>
		        		<td>Server</td>
		        		<td><strong><a href="http://askubuntu.com/questions/9293/how-do-i-install-curl-in-php5">Test Connection API</a></strong></td>
		        		<td><?php if (canAccessAPI()) { echo '<span class="text-success">Ok</span>'; }else { echo "<span class='text-danger'>Curl can't access to API</span>"; } ?></td>
		        	</tr>


		        	<tr>
		        		<td>Settings</td>
		        		<td><strong><a href="http://support.jodacame.com/knowledge-base/how-i-can-get-youtube-data-api">Youtube API Key</a></strong></td>
		        		<td><?php if (!$error_youtube) { echo '<span class="text-success">Ok</span>'; }else { echo "<span class='text-danger'>".$error_youtube."</span>"; } ?></td>
		        	</tr>

		        	<tr>
		        		<td>Settings</td>
		        		<td><strong><a href="http://support.jodacame.com/knowledge-base/get-last-fm-api-key">Last FM API Key</a></strong></td>
		        		<td><?php if (!$error_lastfm) { echo '<span class="text-success">Ok</span>'; }else { echo "<span class='text-danger'>".$error_lastfm."</span>"; } ?></td>
		        	</tr>

		        	<tr>
		        		<td>Settings</td>
		        		<td><strong><a href="http://support.jodacame.com/knowledge-base/where-i-can-get-envato-purchase-code">Purchase Code</a></strong></td>
		        		<td><?php if (!$error_code) { echo '<span class="text-success">Ok</span>'; }else { echo "<span class='text-danger'>".$error_code."</span>"; } ?></td>
		        	</tr>



		        </table>
		    </div><!-- /.box-body-->
		</div><!-- /.box -->



		<div class="box box-primary">
		    <div class="box-header">
	 	 			<h3 class="box-title">System Information</h3>
	 	 		</div>
		    <div class="box-body">
		         <table class="table table-bordered table-hover table-striped">
		        	<tr>
						<td style="width:200px">Database</td>
		        		<td style="width:300px"><strong>Plataform</strong></td>
		        		<td><?php echo $this->db->platform(); ?> </td>
		        	</tr>

		        	<tr>
						<td>Database</td>
		        		<td><strong>Version</strong></td>
		        		<td><?php echo $this->db->version(); ?> </td>
		        	</tr>

		        	<tr>
						<td>Database</td>
		        		<td><strong>Driver</strong></td>
		        		<td><?php echo $this->db->dbdriver; ?> </td>
		        	</tr>

		        	<tr>
						<td>Database</td>
		        		<td><strong>Hostname</strong></td>
		        		<td><?php echo $this->db->hostname; ?> </td>
		        	</tr>

		        	<tr>
						<td>Database</td>
		        		<td><strong>Username</strong></td>
		        		<td><?php echo $this->db->username; ?> </td>
		        	</tr>

		        	<tr>
						<td>Database</td>
		        		<td><strong>Password</strong></td>
		        		<td><?php echo str_pad(substr($this->db->password, 0,4),strlen($this->db->password),"*"); ?> </td>
		        	</tr>

		        	<tr>
						<td>Database</td>
		        		<td><strong>Name</strong></td>
		        		<td><?php echo $this->db->database; ?> </td>
		        	</tr>

					<tr>
						<td>Server</td>
		        		<td><strong>Software</strong></td>
		        		<td><?php echo $this->input->server('SERVER_SOFTWARE'); ?>  </td>
		        	</tr>
		        	<tr>
						<td>Server</td>
		        		<td><strong>IP Address</strong></td>
		        		<td><?php echo $this->input->server('SERVER_ADDR'); ?> </td>
		        	</tr>

		        	<tr>
						<td>Server</td>
		        		<td><strong>OS</strong></td>
		        		<td><?php echo PHP_OS; ?>  </td>
		        	</tr>
		        	<tr>
						<td>Server</td>
		        		<td><strong>PHP Version</strong></td>
		        		<td><?php echo phpversion(); ?>  </td>
		        	</tr>

		        	<tr>
						<td>Curl</td>
		        		<td><strong>Version</strong></td>
		        		<td><?php echo $_curl['version']; ?>  </td>
		        	</tr>

		        	<tr>
						<td>Curl</td>
		        		<td><strong>SSL Version</strong></td>
		        		<td><?php echo $_curl['ssl_version']; ?>  </td>
		        	</tr>

		        	<tr>
						<td>Curl</td>
		        		<td><strong>Libz Version</strong></td>
		        		<td><?php echo $_curl['libz_version']; ?>  </td>
		        	</tr>

		        	
		        	

 					


		        </table>
		    </div><!-- /.box-body-->
		</div><!-- /.box -->

	</div>

