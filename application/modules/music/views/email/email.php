<html>
<head>
<body style="background-color:#FFFFFF">
	<div style="color:#17A3FF;padding-top:100px;width:777px;height:491px;background:url('<?php echo base_url(); ?>assets/images/email.png') no-repeat">
	<center>
		<h1><?php echo $this->config->item("title"); ?></h1>
		<h3>Your New Password</h3>		
		<h1 style="color:#FF0000"><strong><?php echo $password; ?></strong></h1>
		<?php echo ___("email_msg"); ?> <a href="<?php echo $link; ?>"><br><?php echo $link; ?></a>
		<br>
		<br>
		<br>
		Copyright &copy; <?php echo date("Y"); ?><br><?php echo base_url(); ?>
	</center>
	</div>
</body>
</head>
</html>