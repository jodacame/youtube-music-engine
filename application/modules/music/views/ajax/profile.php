<?php
$editable 	= false;
if($user->id == $this->session->userdata('id'))
	$editable = true;
?>
<div class="row">
	<div class="col-md-2">
		<img id="avatar" class="thumbnail img-responsive cursor-pointer" style="width:100%;max-height:100%" onClick="$('#imgInp').click();" src="<?php echo $user->avatar; ?>">
		<?php if($editable){ ?>		
		<p class="help-block">360x360 Recommended</p>
		<center><span id="avatarLoading"></span></center>
		<?php }else{
			?>
			<?php	
			} ?>

		
		<?php if($editable){ ?>
		<form id="form1" class="hide">
		   <input type='file' id="imgInp" />
		   <img id="blah" src="#" alt="your image" />
		</form>
		<?php } ?>
	</div>
	<div class="col-md-10">
	<div class="page-header"> 		
 		 <div class="tabbable">
		<ul class="nav nav-tabs" id="myTabProfile">
		  <li class="active"><a href="#profile" data-toggle="tab"><?php echo $user->nickname; ?></a></li>
		  <li><a href="#folder" data-toggle="tab"><?php echo ___("label_profile_music_folder"); ?> <span class="badge alert-info"><?php echo $playlist->num_rows(); ?></span> </a></li>	
		  <!--<li><a href="#similarTab" data-toggle="tab"><?php echo ___("label_profile_followers"); ?> <span class="badge alert-info">42</span> </a></li>	-->
		  <!--<li><a href="#similarTab" data-toggle="tab"><?php echo ___("label_profile_following"); ?> <span class="badge alert-info">42</span></a></li>	-->
		</ul>
		<div class="tab-content">
		  <div class="tab-pane active" id="profile">
		  <button class="btn btn-primary pull-right" onclick="showActivity(true);"><i class="fa fa-users"></i> <?php echo ___("social_activity"); ?></button>		  
		  <div class="clearfix"></div>
		  <br>
		  		<?php if($editable){ ?>
		  		<table class="table table-striped table-hover ">
		  			<tr>
		  				<td><strong><?php echo ___("label_public_profile"); ?></strong></td>
		  				<td><?php echo base_url()."user/".encode2($user->nickname); ?></td>
		  			</tr>
		  			<?php if($editable){ ?>	
		  			<tr>
		  				<td><strong><?php echo ___("label_email"); ?></strong></td>
		  				<td><?php echo $user->username; ?></td>
		  			</tr>
		  			<?php } ?>
		  			<tr>
		  				<td><strong><?php echo ___("label_bio"); ?></strong></td>
		  				<td><?php echo $user->bio; ?>
		  				<?php if($editable){ ?>
		  				<button class="btn btn-default btn-xs" onClick="$(this).hide();$('#bio').fadeIn(500);"><i class="fa fa-pencil"></i></button>
		  				<textarea id="bio" maxlength="200" style="display:none"  class="form-control col-xs-12"></textarea>
		  				<?php } ?>
		  				</td>
		  			</tr>
		  			<tr>
		  				<td><strong><?php echo ___("label_nickname"); ?></strong></td>
		  				<td><?php echo $user->nickname; ?>
		  				<?php if($editable){ ?>
		  				<button class="btn btn-default btn-xs" onClick="$(this).hide();$('#nickname').fadeIn(500);"><i class="fa fa-pencil"></i></button>
		  				<input id="nickname" maxlength="30" placeholder="Max 30 Char / Not Special Characters" style="display:none" class="form-control" style="width:200px" type="text">
		  				<?php } ?>
		  				</td>
		  			</tr>
		  			<tr>
		  				<td><strong><?php echo ___("social_activity_public"); ?></strong></td>
		  				<td>
		  				<?php if($editable){ ?>
		  				<select id="publicS"  class="form-control m-b">
		  					<option value="" selected disabled></option>
		  					<option <?php if($user->activity_global == '1' || $user->activity_global == 'S'){echo "selected";} ?> value="1">On</option>
		  					<option <?php if($user->activity_global == '0'){echo "selected";} ?> value="0">Off</option>
		  				</select> 
		  				<?php } ?>
		  				</td>
		  			</tr>
		  			 <?php if($editable){ ?>
		  			<tr>
		  				<td><strong><?php echo ___("label_biography_lang"); ?></strong></td>
		  				<td>
		  				
                          
                          	
				  				<select id="biography_lang" class="form-control m-b">
				  					<option <?php if($user->biography_lang == 'zh'){ echo "selected"; } ?> value="zh">Chinese</option>
							    	<option <?php if($user->biography_lang == 'de'){ echo "selected"; } ?> value="de">German</option>
							    	<option <?php if($user->biography_lang == 'fr'){ echo "selected"; } ?> value="fr">French</option>
							    	<option <?php if($user->biography_lang == 'it'){ echo "selected"; } ?> value="it">Italian</option>
							    	<option <?php if($user->biography_lang == 'pt'){ echo "selected"; } ?> value="pt">Portuguese</option>
							    	<option <?php if($user->biography_lang == 'ru'){ echo "selected"; } ?> value="ru">Russian</option>
							    	<option <?php if($user->biography_lang == 'es'){ echo "selected"; } ?> value="es">Spanish</option>
							    	<option <?php if($user->biography_lang == 'en'){ echo "selected"; } ?> value="en">English</option>
				  				</select> 
				  			
		  			

		  				</td>
		  			</tr>		  			
		  			<?php } ?>
		  			<tr>
		  				<td><strong><?php echo ___("label_registered"); ?></strong></td>
		  				<td><?php echo $user->registered; ?></td>
		  			</tr>


		  		</table>
		  		<div class="col-md-12">
		  			<?php echo comments('profile'); ?>
		  			</div>

		  		<?php }else{ ?>
		  			<div class="col-md-12">
		  			<?php echo comments('profile'); ?>
		  			</div>
		  			<div class="row">
		  			<div class="col-xs-12" style="text-align:center">
		  			<?php echo $user->bio; ?>
		  			</div>
		  			 <div class="col-md-12 col-sm-12 top-margin" >

                 
                        <ul class="timeline">                      
                           <li class="time-label">
                                <span class="bg-blue"><?php echo ___("social_activity"); ?>
                                </span>
                                <br />
                                <br />
                            </li>


                         <?php foreach ($activity->result() as $row) {

                         	?>
                         	 <li>
                                <i class="fa <?php echo $icon[$row->action]['icon']; ?> bg-<?php echo $icon[$row->action]['color']; ?>"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo ago(strtotime($row->date)); ?></span>
                                    <h3 class="timeline-header"><a class="removehref" href="<?php echo base_url(); ?>user/<?php echo $row->nickname; ?>" onClick='profile("<?php echo $row->nickname; ?>");'><?php echo $row->nickname; ?></a> <small><?php echo more($row->bio); ?></small> </h3>
                                    <div class="timeline-body">
                                    	
                                         <a style="color:#000000" href="<?php echo base_url(); ?>artist/<?php echo econde($row->artist); ?>" class="artistInfo removehref truncate" onClick="getArtistInfo('<?php echo addslashes($row->artist); ?>');" title=<?php echo ___("label_get_artist_info"); ?>><?php echo $row->artist; ?></a>      
                                        - 
                                        <a style="color:#6C6C6C" href="<?php echo base_url(); ?>?artist=<?php echo encode($row->artist); ?>&track=<?php echo encode($row->track); ?>" class="removehref text-muted cursor-pointer"   onclick="getSongInfo('<?php echo addslashes($row->artist); ?>','<?php echo addslashes($row->track); ?>');"><i class="fa fa-music"></i> <?php echo $row->track; ?></a>
                                      
                                    </div>
                                    <div class='timeline-footer'>                                     	
                                        <button class="btn btn-primary btn-xs"  onclick="addPlayList('<?php echo addslashes($row->track); ?>','<?php echo addslashes($row->artist); ?>','<?php echo base_url(); ?>assets/images/no-cover.png',true);"><i class="fa fa-play"></i> <?php echo ___("label_playnow"); ?></button>                                                                                
                                        <button class="btn btn-warning btn-xs" onclick="start_radio('<?php echo addslashes($row->track); ?>','<?php echo addslashes($row->artist); ?>','<?php echo base_url(); ?>assets/images/no-cover.png')"><i class="fa fa-rss"></i> <?php echo ___("label_start_radio"); ?></button>                                                                                
                                        
                                        <?php                                        
                                         $disable = '';
                                        if($this->session->userdata('like_'.$row->idactivity) == "1" || !is_logged())
                                        {  
                                            $disable = "disabled";                    
                                        }
                                        ?>
                                               <!-- <button class="btn btn-info btn-xs <?php echo $disable; ?>" onclick="like(<?php echo $row->idactivity; ?>,$(this))"><i class="fa fa-heart"></i> <span class="like"><?php echo number_format($row->likes); ?></span> <?php echo ___("label_like"); ?></button> -->
                                         
                                        
                                    </div>
                                </div>
                            </li>
                         	<?php
                         }
                         ?>

                           

                          
                            <li>
                                <i class="fa fa-clock-o"></i>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                        </div>

                    </div> <?php } ?>

		  		<div class="clearfix"></div>

		  </div>
		  	<div class="tab-pane" id="folder">
		  		<div class="panel-group" id="accordion">
				  <?php foreach ($playlist->result() as $row) { 
				  	$pl = json_decode($row->json);  
				  	?>
				  	 
						   
						   
						        <span class="cursor-pointer" data-toggle="collapse" data-parent="#accordion" href="#pl-<?php echo $row->idplaylist; ?>">
							      <img class="thumbnail pull-left" style="width:80px;margin-right:20px" src="<?php echo addslashes($pl[0]->cover); ?>">
						          <h2 style="margin:0px;padding:0px;margin-left:20px;"><?php echo $row->name; ?></h2>
						          <?php echo number_format(count($pl)); ?> <?php echo ___("social_songs"); ?>
						          <button class="btn btn-default pull-right btn-xs" onclick="$('.song-pl-<?php echo $row->idplaylist; ?>').click();"><i class="fa fa-plus"></i> <?php echo ___("label_add_all"); ?> &nbsp;&nbsp; <span class="badge alert-default"><?php echo count($pl); ?></span></button>
						          <div class="clearfix"></div>
						        </span>
						   
					
						    <div id="pl-<?php echo $row->idplaylist; ?>" class="panel-collapse collapse">
								      <?php 
								      
								      foreach ($pl as $key => $value) { ?>
								      	  <a href="#" class="list-group-item">
								      	  <i class="fa fa-music"></i> <?php echo $value->track; ?> 
								      	  <span class="text-muted"><?php echo $value->artist; ?></span>
								      	  <button class="btn btn-primary btn-xs pull-right song-pl-<?php echo $row->idplaylist; ?>" title="<?php echo ___("label_add_playlist"); ?>" onclick="addPlayList('<?php echo addslashes($value->track); ?>','<?php echo addslashes($value->artist); ?>','<?php echo $value->cover; ?>');"><i class="fa fa-plus"></i></button>                                         
								      	  </a>
								      <?php } ?>
						    </div>
						
				  <?php } ?>	
				</div>
		  	</div>	 
		  	<div class="tab-pane" id="similarTab" style="text-align:center">
		  		Similar		  		
		  	</div>	 
		</div>


	</div>
 	</div>
	</div>
</div>
<script>
var stateObj = { foo: "bar" };
history.pushState(stateObj, "", "<?php echo base_url(); ?>user/<?php echo encode2($user->nickname); ?>");


<?php if($editable){ ?>
function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
       
        img = new Image();
        img.onload = function () {
            if(input.files[0].size > 300000)
            {
            	alert("Pls upload picture < 300kB size");
            	
            }
            else
            {
            $('#avatar').attr('src', e.target.result);        
			show_loading('avatarLoading');
			$.post(base_url+"music/saveAvatar", {avatar:e.target.result}, function(data, textStatus) {
				$("#avatarLoading").html('');
			});  
            }
        };
        img.src = e.target.result;
    }

    reader.readAsDataURL(input.files[0]);
}
}

$("#imgInp").change(function(){
	readURL(this);
});
$("#nickname").keyup(function(event) {
	$(this).val($(this).val().replace(/[^\w\s]/gi, ''));
	$(this).val($(this).val().replace(" ", ''));
});
$("#nickname").blur(function(event) {
	var nickname = $(this).val();	
	if(nickname == '')
		return false;
	show_loading();
	$.post(base_url+'music/SaveDataUser', {nickname: nickname}, function(data, textStatus, xhr) {
		if(data == "1")
		{
			var stateObj = { foo: "bar" };
			history.pushState(stateObj, "", "<?php echo base_url(); ?>user/"+nickname);	
			
		}
		else
		{
			alert(data);
		}
		location.reload();
		
	});
});
$("#biography_lang").change(function(event) {
	var biography_lang = $(this).val();	
	if(biography_lang == '')
		return '0';

	show_loading();
	$.post(base_url+'music/SaveDataUser', {biography_lang: biography_lang,biography_lang_save:'1'}, function(data, textStatus, xhr) {
		if(data == "1")
		{
			var stateObj = { foo: "bar" };
			history.pushState(stateObj, "", "<?php echo base_url(); ?>user/<?php echo encode2($user->nickname); ?>");
			
		}
		else
		{
			if(data != '')
				alert(data);
		}
		location.reload();
		
	});
});
$("#bio").blur(function(event) {
	var bio = $(this).val();	
	if(bio == '')
		return false;
	show_loading();
	$.post(base_url+'music/SaveDataUser', {bio: bio}, function(data, textStatus, xhr) {
		if(data == "1")
		{
			var stateObj = { foo: "bar" };
			history.pushState(stateObj, "", "<?php echo base_url(); ?>user/<?php echo encode2($user->nickname); ?>");			
		}
		else
		{
			alert(data);
		}
		location.reload();
	});
});

$("#publicS").change(function(event) {
	var publicS = $(this).val();	
	if(publicS == '')
		return '0';
	show_loading();
	$.post(base_url+'music/SaveDataUser', {publicS: publicS,publicST:'1'}, function(data, textStatus, xhr) {
		if(data == "1")
		{
			var stateObj = { foo: "bar" };
			history.pushState(stateObj, "", "<?php echo base_url(); ?>user/<?php echo encode2($user->nickname); ?>");
			
		}
		else
		{
			if(data != '')
				alert(data);
		}
		location.reload();
		
	});
});

<?php } ?>

</script>