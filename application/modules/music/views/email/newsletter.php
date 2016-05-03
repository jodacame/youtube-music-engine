<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title><?php echo $this->config->item("newsletter_title"); ?></title>


</head>
<body style="width:100% !important;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;background-color:#F3F4F4">

<style type="text/css">

	#outlook a{padding:0;}
	body{width:100% !important;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;}
	.ExternalClass{width:100%;}
	.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%;}
	.bodytbl{margin:0;padding:0;width:100% !important;}
	img{outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;display:block;max-width:100%;}
	a img{border:none;}
	p{margin:1em 0;}
	
	table{border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;}
	table td{border-collapse:collapse;}
	.o-fix table,.o-fix td{mso-table-lspace:0pt;mso-table-rspace:0pt;}
	
	body{background-color:#F3F4F4;}
	table{font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#585858;}
	td,p{line-height:24px;color:#585858/*Text*/;}
	td,tr{padding:0;}
	ul,ol{margin-top:24px;margin-bottom:24px;}
	li{line-height:24px;}
	
	a{color:#5ca8cd/*Contrast*/;text-decoration:none;padding:2px 0px;}
	a:link{color:#5ca8cd;}
	a:visited{color:#5ca8cd;}
	a:hover{color:#5ca8cd;}
	
	.h1{font-family:Helvetica,Arial,sans-serif;font-size:26px;letter-spacing:-1px;margin-bottom:16px;margin-top:2px;line-height:30px;}
	.h2{font-family:Helvetica,Arial,sans-serif;font-size:20px;letter-spacing:0;margin-top:2px;line-height:30px;}
	h1,h2,h3,h4,h5,h6{font-family:Helvetica,Arial,sans-serif;font-weight:normal;}
	h1{font-size:20px;letter-spacing:-1px;margin-bottom:16px;margin-top:4px;line-height:24px;}
	h2{font-size:18px;margin-bottom:12px;margin-top:2px;line-height:24px;}
	h3{font-size:14px;margin-bottom:12px;margin-top:2px;line-height:24px;}
	h4{font-size:14px;font-weight:bold;}
	h5{font-size:12px;}
	h6{font-size:12px;font-weight:bold;}
	h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color:#5ca8cd;}
	h1 a:active,h2 a:active,h3 a:active,h4 a:active,h5 a:active,h6 a:active{color:#5ca8cd !important;}
	h1 a:visited,h2 a:visited,h3 a:visited,h4 a:visited,h5 a:visited,h6 a:visited{color:#5ca8cd !important;}
	
	.wrap.header{border-top:1px solid #FEFEFE;}
	.wrap.footer{border-bottom:1px solid #FEFEFE;}
	.wrap.body,.wrap.header,.wrap.footer{background-color:#FFFFFF;border-right:1px solid #FEFEFE;border-left:1px solid #FEFEFE;}
	.padd{width:24px;}
	
	.small{font-size:11px;line-height:18px;}
	.separator{border-top:1px dotted #E1E1E1;}
	.btn{margin-top:10px;display:block;}
	.btn img{display:inline;}
	.subline{line-height:18px;font-size:16px;letter-spacing:-1px;}

	table.textbutton td{background:#efefef;padding:1px 14px 4px 14px;color:#585858;display:block;height:22px;border:1px solid #FEFEFE;vertical-align:top;}
	table.textbutton a{color:#585858;font-size:13px;font-weight:normal;line-height:22px;width:100%;display:inline-block;}

	div.preheader{line-height:0px;font-size:0px;height:0px;display:none !important;display:none;visibility:hidden;}
	

	
</style>
<center style="padding:5px;color:#A5A5A5;font-size:11px">
	<a style="color:#A5A5A5;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>user/<?php echo $user->nickname; ?>"><?php echo ___('label_profile'); ?></a> | 
	<a style="color:#A5A5A5;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>user/<?php echo $user->nickname; ?>/unsubscribe/<?php echo sha1($this->config->item("encryption_key").$user->nickname); ?>"><?php echo ___('label_unsubscribe_newsletter'); ?></a> 

</center>
<table class="bodytbl" width="100%" cellspacing="0" cellpadding="0" style="font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#585858;">
<tr>
	<td  align="center">
	
		
		
		

		



		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF" style="background-color:#FFFFFF">
		<tr>
			<td valign="top" align="center">
				<img src="<?php echo $this->config->item("newsletter_base_url") ; ?>assets/images/email/header.png" class="m-100" alt="" title="" width="790" height="336" border="0" />
			</td>
		</tr>
		</table>



		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
		<tr><td height="12" colspan="3"></td></tr>
		<tr>
			<td width="24" class="padd">&nbsp;</td>
			<td valign="top" align="left">
				<small style="float:right">Hello! <a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>user/<?php echo $user->nickname; ?>"><?php echo $user->nickname; ?></a></small>
				<h1><?php echo $this->config->item("newsletter_title"); ?></h1>
				<div class="h2"><?php echo $this->config->item("newsletter_description"); ?></div>
			</td>
			<td width="24" class="padd">&nbsp;</td>
		</tr>
		<tr><td height="12" colspan="3"></td></tr>
		</table>



		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
			<tr><td height="12" colspan="3"></td></tr>
			<tr><td width="24" class="padd">&nbsp;</td>
			<td align="center"><table width="100%" cellpadding="0" cellspacing="0" class="separator" style="border-top:1px dotted #E1E1E1;"><tr><td height="23">&nbsp;</td></tr></table></td>
			<td width="24" class="padd">&nbsp;</td>
			</tr>
		</table>
	


	<?php if($this->config->item("newsletter_mod_recommended") == '1'){ ?>
		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
		
		<tr><td height="12" colspan="3"></td></tr>
		<tr>
			<td width="24" class="padd">&nbsp;</td>
			<td valign="top" align="center">
				<?php if($similar->artist->similar){ ?>
				<table width="100%" cellpadding="0" cellspacing="0" class="o-fix">
				<tr>
					<td colspan="5"><h1><?php echo ___('newsletter_recommended'); ?></h1></td>
				</tr>
				<tr>

					
					<?php 
					$x=0;
					foreach($similar->artist->similar->artist as $row){ 
						if($x<=3){
							$image =  $row->image[3]->text;
						if($image == '')
							$image =  $row->image[2]->text;
						if($image == '')
							$image =  $this->config->item("newsletter_base_url") ."assets/images/no-cover.png";
						?>
					<td valign="top" align="left">
						<table width="192" cellpadding="0" cellspacing="0" class="m-b m-b-b" align="left">
						<tr>
						<td width="10" class="s">&nbsp;</td>
							<td valign="top" align="left">
							
							<div >
							<p>
								<a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>artist/<?php echo encode($row->name); ?>">
									<img src="<?php echo $image; ?>" height="165"  width="172" style="width:172px;height:172px">
								</a>
							</p></div>
							<div class="btn"><buttons>
							<strong><a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>artist/<?php echo encode($row->name); ?>" ><?php echo $row->name; ?> </a></strong> <br>							
							</buttons></div>
							</td>
							<td width="10" class="s">&nbsp;</td>
						</tr>
						</table>

					<?php 
						$x++;
					}

					}
					 ?>

					</td>
		
				</tr>
				</table>
				<?php } ?>
			</td>
			<td width="24" class="padd">&nbsp;</td>
		</tr>
		<tr><td height="12" colspan="3"></td></tr>
		</table>

		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
			<tr><td height="12" colspan="3"></td></tr>
			<tr><td width="24" class="padd">&nbsp;</td>
			<td align="center"><table width="100%" cellpadding="0" cellspacing="0" class="separator" style="border-top:1px dotted #E1E1E1;"><tr><td height="23">&nbsp;</td></tr></table></td>
			<td width="24" class="padd">&nbsp;</td>
			</tr>
		</table>


		<?php } ?>
		<?php if($this->config->item("newsletter_mod_the_most_listened") == '1' && $top->num_rows() >= 1) { ?>
		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
		
		<tr><td height="12" colspan="3"></td></tr>
		<tr>
			<td width="24" class="padd">&nbsp;</td>
			<td valign="top" align="center">
				
				<table width="100%" cellpadding="0" cellspacing="0" class="o-fix">
				<tr>
					<td colspan="5"><h1><?php echo ___('newsletter_listened'); ?></h1></td>
				</tr>
				<tr>
					
					<?php 
					
					$x=0;
					foreach($top->result() as $row){ 
						if($x<=3)
						{
							$x++;
							
						?>
						<td valign="top" align="left">
							<table width="192" cellpadding="0" cellspacing="0" class="m-b m-b-b" align="left">
							<tr>
							<td width="10" class="s">&nbsp;</td>
								<td valign="top" align="left">
								
								<div ><p>
									 <a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>?artist=<?php echo encode($row->artist); ?>&track=<?php echo encode($row->track); ?>" ><img src="<?php echo $row->picture; ?>"   height="165"  width="172" style="width:172px;height:172px"></a>
								</p></div>
								<div class="btn"><buttons>
								<strong><a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>artist/<?php echo encode($row->artist); ?>" ><?php echo $row->artist; ?></a></strong><br>
								<a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>?artist=<?php echo encode($row->artist); ?>&track=<?php echo encode($row->track); ?>" ><?php echo $row->track; ?></a>
								</buttons></div>
								</td>
								<td width="10" class="s">&nbsp;</td>
							</tr>
							</table>
						</td>
						<?php 
						} 
					}
						?>

						
		
				</tr>
				</table>
			</td>
			<td width="24" class="padd">&nbsp;</td>
		</tr>
		<tr><td height="12" colspan="3"></td></tr>
		</table>

		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
			<tr><td height="12" colspan="3"></td></tr>
			<tr><td width="24" class="padd">&nbsp;</td>
			<td align="center"><table width="100%" cellpadding="0" cellspacing="0" class="separator" style="border-top:1px dotted #E1E1E1;"><tr><td height="23">&nbsp;</td></tr></table></td>
			<td width="24" class="padd">&nbsp;</td>
			</tr>
		</table>
		<?php } ?>
		<?php if($this->config->item("newsletter_mod_top_artist_weekend") == '1'  && $topA->num_rows() >= 1){ ?>

		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
		
		<tr><td height="12" colspan="3"></td></tr>
		<tr>
			<td width="24" class="padd">&nbsp;</td>
			<td valign="top" align="center">
				
				<table width="100%" cellpadding="0" cellspacing="0" class="o-fix">
				<tr>
					<td colspan="10"><h1><?php echo ___('newsletter_weekend'); ?></h1></td>
				</tr>
				<tr>
					
					<?php 
					
					$x=0;
					foreach($topA->result() as $row){ 
						if($x<=3 && rand(1,2) == 2)
						{
							$x++;
							
						?>
						<td valign="top" align="left">
							<table width="192" cellpadding="0" cellspacing="0" class="m-b m-b-b" align="left">
							<tr>
							<td width="10" class="s">&nbsp;</td>
								<td valign="top" align="left">
								
								<div ><p>
									 <a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>artist/<?php echo encode($row->artist); ?>" ><img src="<?php echo $row->picture; ?>"  height="165"  width="172"  style="width:172px;height:172px"></a>
								</p></div>
								<div class="btn"><buttons>
								<strong><a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>artist/<?php echo encode($row->artist); ?>" ><?php echo $row->artist; ?></a></strong><br>								
								</buttons></div>
								</td>
								<td width="10" class="s">&nbsp;</td>
							</tr>
							</table>
						</td>
						<?php 
						} 
					}
						?>

						
		
				</tr>
				</table>
			</td>
			<td width="24" class="padd">&nbsp;</td>
		</tr>
		<tr><td height="12" colspan="3"></td></tr>
		</table>

		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
			<tr><td height="12" colspan="3"></td></tr>
			<tr><td width="24" class="padd">&nbsp;</td>
			<td align="center"><table width="100%" cellpadding="0" cellspacing="0" class="separator" style="border-top:1px dotted #E1E1E1;"><tr><td height="23">&nbsp;</td></tr></table></td>
			<td width="24" class="padd">&nbsp;</td>
			</tr>
		</table>




		<?php } ?>
		<?php if($this->config->item("newsletter_mod_trending_now") == '1'  && $activity->num_rows() >= 1){ ?>
		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
		
		<tr><td height="12" colspan="3"></td></tr>
		<tr>
			<td width="24" class="padd">&nbsp;</td>
			<td valign="top" align="center">
				
				<table width="100%" cellpadding="0" cellspacing="0" class="o-fix">
				<tr>
					<td colspan="5"><h1><?php echo ___('newsletter_trending'); ?></h1></td>
				</tr>
				<tr>
					
					<?php 
					
					$x=0;
					foreach($activity->result() as $row){ 
						if($x<=3)
						{
							$x++;
							
						?>
						<td valign="top" align="left">
							<table width="192" cellpadding="0" cellspacing="0" class="m-b m-b-b" align="left">
							<tr>
							<td width="10" class="s">&nbsp;</td>
								<td valign="top" align="left">
								
								<div ><p>
									 <a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>?artist=<?php echo encode($row->artist); ?>&track=<?php echo encode($row->track); ?>" ><img  height="165"  width="172" src="<?php echo $row->picture; ?>"  style="width:172px;height:172px"></a>
								</p></div>
								<div class="btn"><buttons>
								<strong><a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>artist/<?php echo encode($row->artist); ?>" ><?php echo $row->artist; ?></a></strong><br>
								<a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>?artist=<?php echo encode($row->artist); ?>&track=<?php echo encode($row->track); ?>" ><?php echo $row->track; ?></a>
								</buttons></div>
								</td>
								<td width="10" class="s">&nbsp;</td>
							</tr>
							</table>
						</td>
						<?php 
						} 
					}
						?>
				</tr>
				</table>
			</td>
			<td width="24" class="padd">&nbsp;</td>
		</tr>
		<tr><td height="12" colspan="3"></td></tr>
		</table>

		<table width="790" cellspacing="0" cellpadding="0" class="wrap body" style="background-color:#FFFFFF">
			<tr><td height="12" colspan="3"></td></tr>
			<tr><td width="24" class="padd">&nbsp;</td>
			<td align="center"><table width="100%" cellpadding="0" cellspacing="0" class="separator" style="border-top:1px dotted #E1E1E1;"><tr><td height="23">&nbsp;</td></tr></table></td>
			<td width="24" class="padd">&nbsp;</td>
			</tr>
		</table>

		<?php } ?>
		<table width="790" cellspacing="0" cellpadding="0" class="wrap footer" style="background-color:#FFFFFF">
		<tr>
			<td width="24" class="padd">&nbsp;</td>
			<td valign="top" align="center">
				<table width="100%" cellpadding="0" cellspacing="0" class="o-fix" style="background-color:#FFFFFF">
				<tr>
		
					<td valign="top" align="left">
						<table width="360" cellpadding="0" cellspacing="0" align="left">
						<tr>
							<td class="small m-b" align="left" valign="top">
								<div><?php echo $this->config->item("newsletter_footer"); ?></div>
								<div>&copy; <?php echo date('Y'); ?> <a style="color:#5ca8cd;text-decoration:none" href="<?php echo $this->config->item("newsletter_base_url") ; ?>"><?php echo $this->config->item('title'); ?></a></div>
							</td>
						</tr>
						</table>
						<table width="168" cellpadding="0" cellspacing="0" align="right">
						<tr>
							<td class="small" align="right" valign="top">
							<div class="btn"><buttons>
								<?php if($this->config->item("twitter_username") != '')
								{
									?><a style="color:#5ca8cd;text-decoration:none"  href="https://twitter.com/<?php echo $this->config->item("twitter_username"); ?>"><img src="<?php echo $this->config->item("newsletter_base_url") ; ?>assets/images/twitter-128.png" alt="" title="" width="32" height="32" border="0" /></a><?php
								}
								?>
								<?php if($this->config->item("facebook_fanpage") != ''){ ?>
								<a style="color:#5ca8cd;text-decoration:none"  href="<?php echo $this->config->item("facebook_fanpage"); ?>"><img src="<?php echo $this->config->item("newsletter_base_url") ; ?>assets/images/facebook-128.png" alt="" title="" width="32" height="32" border="0" /></a>
								<?php } ?>
								
							</buttons></div>
							</td>
						</tr>
						</table>
					</td>
		
				</tr>
				</table>
			</td>
			<td width="24" class="padd">&nbsp;</td>
		</tr>
		<tr><td height="24" colspan="3"></td></tr>
		</table>
		<table cellpadding="0" cellspacing="0" class="wrap m-b-b" >
			<tr><td valign="top"><img src="<?php echo $this->config->item("newsletter_base_url") ; ?>assets/images/email/shadown.png" class="m-100" width="790" height="25" alt="" border="0" /></td></tr>
		</table>


	
	</td>
</tr>
</table>
</body>
</html>