<!DOCTYPE html>
<html>
<head>
	<title><?php echo $this->config->item("title"); ?> - Spotify</title>
	  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.css" />
	  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/animate.css" />
	<style>

	@import url(http://fonts.googleapis.com/css?family=Roboto:400,300);
	body{
		background-color:#EBEBEB;
		font-family: 'Roboto', sans-serif;
		padding-bottom: 50px;
		
	}
	.thumb
	{

		display:block;				
		margin:15px;		
		border:1px #F3F3F3 solid;		
		border-radius:2px;
		box-shadow:1px 1px 3px rgba(0, 0, 0, .0);
		text-decoration:none;
		color:#4C4C4C;
		background-color:#FFF;
		transition: all .3s ease-in;
	}
	.thumb img
	{
		transition: all .3s ease-in-out;
		max-width:100%;
		width:100%;
	}
	.thumb:hover img{
		opacity:0.5;
	}
	.thumb:hover {
		box-shadow:1px 2px 3px rgba(0, 0, 0, 0);
		text-decoration:none;
		color:#000;
	}
	.thumb .footer{
		padding:10px;
		line-height:25px;
	}
	.thumb span.name
	{
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		display:block;
	}
	.thumb span.tracks
	{
		
		display:block;		
		width:100%;
		font-size:12px;
		color:rgba(0,0,0,.5);
	}

	.header{
		width:100%;
		height:200px;
		background-color:#FFF;
		box-shadow:1px 1px 3px rgba(0, 0, 0, .1);
		margin-bottom:20px;
	}



	
	#footer
	{
		
		margin-top:20px;
		bottom:0px;
		width:100%;		
		height:50px;
		text-align:center;
		font-size:12px;
		color:#858585;
	}
	#footer img
	{
		width:48px;
		display:block;
		margin:0 auto 0 auto;		
	}
	.spotify
	{
		display:inline-block;
		width:50%;		
		height:120px;
		margin-top:40px;
		float:left;		
		
		box-sizing: border-box;
		
	}
	.local
	{
		display:inline-block;
		width:50%;		
		height:120px;
		margin-top:40px;
		float:right;		
		
		box-sizing: border-box;
		
	}
	.spotify .pd,.local .pd
	{
		padding:20px;
	}
	.spotify img
	{
		width:64px;
		height:64px;
		border-radius:50%;
		float:left;
		margin-right:20px;
	}
	.local img
	{
		width:64px;
		height:64px;
		border-radius:50%;
		float:right;
		margin-left:20px;
	}

	.spotify .data
	{
		float:left;
		text-align:left;
	}
	.local .data
	{
		float:right;
		text-align:right;
	}
	.spotify .data ul,.local .data ul
	{
		padding:0px;
		margin:0px;
		list-style:none;
	}
	.spotify .data ul li,.local .data ul li
	{
		line-height:25px;
		display:block;
	}
	.spotify .data ul li.name,.local .data ul li.name
	{
		font-size:20px;
	}
	.spotify .data ul li.email,.local .data ul li.email
	{
		font-size:16px;
		color:rgba(0,0,0,.5);
	}
	.spotify .data ul li.account,.local .data ul li.account
	{
		font-size:12px;
		color:rgba(0,0,0,.5);	
	}
	.arrow
	{
		position:absolute;
		width:100%;
		font-size:50px;
		text-align:center;
		border:0px solid;
		top:60px;
	}
	.gohome
	{
		position:absolute;
		left:10px;
		top:10px;
		color:#8BB900;
		text-decoration:none;
	}
	.gohome:hover
	{
		color:#000;
		text-decoration:none;
		
	}
	.msg a
	{	
		color:#8BB900;
		text-decoration:none;
	}
	.msg a:hover
	{	
		color:#000;
		text-decoration:none;
	}
	.truncate
	{
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.msg
	{
		color:#8BB900;
		text-align:center;
		font-size:25px;
	}
	ul.tracks
	{
		padding:0px;
		margin:0px;
	}
	ul.tracks li
	{
		cursor:move;
		text-align:left;
		display:block;
		width:100%;
		height:64px;
		margin-bottom:5px;
		background-color:rgba(255, 255, 255, 1);
		border-bottom:1px rgba(0,0,0,.1) solid;

		
	}
	ul.tracks li:hover
	{
		box-shadow:1px 1px 3px rgba(0, 0, 0, .1);
	}
	ul.tracks li img
	{
		margin-right:10px;
		width:64px;
		height:64px;
		float:left;
	}
	ul.tracks li span
	{
		display:block;
		margin-top:7px;
		color:#2C2C2C;
	}
	ul.tracks li span.artist
	{
		margin-left:6px;
		color:rgba(0, 0, 0, 0.5);
	}
	ul.tracks li span.close
	{
		width:24px;
		height:24px;
		float:right;
		z-index:9999;
	}
	.buttons
	{
		text-align:left;
		padding-bottom:20px;
	}
	.buttons .btn
	{
		transition: all .3s ease-in-out;
		display:inline-block;
		background-color:#FFF;
		border:1px rgba(0,0,0,.1) solid;
		padding:10px;
		border-radius:3px;
		text-decoration:none;
		color:rgba(0, 0, 0, 0.5);
		margin-right:5px;
	}
	.buttons .btn:hover
	{
		color:rgba(0, 0, 0, 0.9);
		box-shadow:1px 3px 4px rgba(0, 0, 0, 0.1);
	}
	.form
	{
		display:none;
		width:100%;
		padding:10px;
		background-color: #FFF;
		box-shadow:1px 2px 3px rgba(0, 0, 0, 0.05);
		margin-bottom:20px;
	}

	.form select,.form input{
		width:100%;
		padding:10px;
		border:1px #F8F8F8 solid;
		background-color:#FFF;
	}
	.form .h1
	{
		font-size:30px;
		width:auto;
		padding:0px;
		border:0px;
		margin:0px;
		margin-top:5px;
		margin-bottom:5px;

	}

	.form img
	{
		width:128px;
	}
	.form .button
	{
		transition: all .3s ease-in-out;
		display:inline-block;
		background-color:#8BB900;
		border:1px rgba(0,0,0,.1) solid;
		padding:10px;
		border-radius:3px;
		text-decoration:none;
		color:rgba(255, 255, 255, 1);
		margin-top:10px;
		margin-bottom:10px;
		
	}
	#overlay{
		top:0;
		height:0;
		position:fixed;
		width:100%;
		height:100%;
		background-color:rgba(0, 0, 0, 0.5);
		z-index:9999999;
		display:none;
	}
	</style>
</head>
<body>
	<div class="main">
		<div class="header">
					
					<a href="<?php echo base_url(); ?>" class="gohome">&#8656; <?php echo $this->config->item("title"); ?></a>
					
					<div class="arrow">
						&#8680;
					</div>
			<div class="container">				
					<div class="spotify col-md-6">
						<div class="pd">
							<img src="<?php echo $profile->images[0]->url; ?>">
							<div class="data">
								<ul>
									<li class="name truncate"><?php echo $profile->display_name; ?></li>
									<li class="email truncate"><?php echo $profile->email; ?></li>
									<li class="account truncate">Spotify Account</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="local col-md-6">
						<div class="pd">						
							<img src="<?php echo $this->session->userdata('avatar'); ?>">
							<div class="data">
								<ul>
									<li class="name truncate"><?php echo $this->session->userdata('names'); ?></li>
									<li class="email truncate"><?php echo $this->session->userdata('username'); ?></li>
									<li class="account truncate"><?php echo $this->config->item("title"); ?></li>
								</ul>
							</div>						
						</div>
					</div>

			</div>

		</div>
		<div class="container">
			<?php echo $page; ?>
		</div>

		<div id="footer">		
			<img src="<?php echo base_url(); ?>assets/addons/spotify.png">		
		</div>
	</div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sort.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery.cookie.js"></script>
	<script>
	var type=false;
	$(function () {

		 $.ajaxSetup({
	        data: {
	            csrf_yme: $.cookie('csrf_cookie_yme')
	        }
	    });


		$(".btn-append").on('click', function(event) {			
			$("#new").slideUp()
			$("#append").slideDown();
			type = 'append';
		});
		$(".btn-new").on('click', function(event) {			
			$("#append").slideUp()
			$("#new").slideDown();
			type = 'new';
		});

		$(".close").on('click', function(event) {			
			$(this).parent().remove();
		});
		$( ".sort" ).sortable();

		
		

		var item;
		var list = [];		
		$(".btn-start").on('click', function(event) {
			 list = [];	
			$.each($(".tracks li"), function(index, val) {
				 var track 	= $(".track",$(this)).text();
				 var artist = $(".artist",$(this)).text();
				 var cover 	= $("img",$(this)).attr("src");
				 	item = {"track": track,"artist": artist,"cover": cover};
					list.push(item);
			});

			var playlistJSON = JSON.stringify(list);
			if(type == 'new')
			{
				var name 	= $("input.h1").val();
				var id 		= $("#id").val();
				if(!name)
				{
					 $("input.h1").focus();
					return false;
				}		
				$("#overlay").show();
				$.post('<?php echo base_url(); ?>music/savePlayList', {playlist: playlistJSON,name:name,action:'1',type:"spotify",externalid:id,owner:'<?php echo $info['owner']; ?>'}, function(data, textStatus, xhr) {			
					alert(data.msg);	
					if(data.error == '0')				
					{
						location.href = '<?php echo base_url(); ?>spotify/user';
					}							
				},"json");	
			}

			if(type == 'append')
			{
				var name = $("select").val();
				
				if(!name)
				{
					 $("select").focus();
					return false;
				}				
				$("#overlay").show();
				$.post('<?php echo base_url(); ?>music/savePlayList', {playlist: playlistJSON,id:name,action:'2'}, function(data, textStatus, xhr) {			
					alert(data.msg);				
					if(data.error == '0')				
					{
						location.href = '<?php echo base_url(); ?>spotify/user';
					}
				},"json");	
			}

			
			

		});

	});
	</script>
	<div id="overlay"></div>
</body>
</html>
