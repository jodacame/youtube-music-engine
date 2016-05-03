<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $this->load->view("templates/common/_header",false,true); ?>
    
</head>
<body>
  <div id="fb-root"></div>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="panel panel-primary">
            <div id="thumbnail" class="hidePlayer"  data-html="true" data-container="body" data-toggle="popover" data-placement="right" data-content="<?php echo ___("msg_play_player"); ?>">
            <button  class="btn btn-warning btn-sm btn-download-mp3" style="position:absolute;margin-top:210px;width:100%;border-radius:0px"><i class="fa fa-cloud-download"></i> <?php echo ___("label_download"); ?></button>
            <div id="player">  
            		<div id="ytapiplayer">You need flash!</div>
            	</div>
            	 <a href="<?php echo $this->config->item("link_cover_player"); ?>"><img src="<?php echo base_url(); ?>assets/images/no-cover.png"></a>

            </div>           

              <div class="navbar navbar-default" id="playlist">
	             <div class="list-group">
	                <span  class="list-group-item active" data-ignore="true">	                    
                            
                            <div class="btn-group" >
                              <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="label label-info" id="numItems"></span><?php echo ___("label_playlist"); ?> <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" role="menu" id="changePlaylist">
                              <?php for($x=1;$x<=intval($this->config->item("nplaylist"));$x++)
                              {
                                ?><li data-playlist="<?php echo $x; ?>" class="playlist_<?php echo $x; ?>"><a href="#"><?php echo ___("label_load_playlist"); ?> <?php echo $x; ?></a></li><?php
                              }
                              if($this->config->item('use_database') == 1 && is_logged())
                              {
                                ?>
                                <li class="divider"></li>                                
                                  <li><a href="#" id="save_as_playlist"><?php echo ___("label_save_as_playlist"); ?></a></li>
                                <?php
                              }
                              ?>
                                <?php if($this->config->item('export_playlist') == "1"){ ?>
                                <li class="divider"></li>
                                <li onClick="exportPlayList();"><a href="#"><i class="fa fa-download"></i> <?php echo ___("label_export_playlist"); ?></a></li>
                                <li onClick="importPlayList();"><a href="#"><i class="fa fa-upload"></i> <?php echo ___("label_import_playlist"); ?></a></li>
                                <?php } ?>
                                <li class="divider"></li>
                                <li  onClick="clearPlaylist();" ><a href="#"><?php echo ___("label_clear_playlist"); ?></a></li>
                              </ul>
                            </div>	 
                            <?php if($this->config->item('download_button') == '1'){ ?>
                            <button type="button" title="<?php echo ___("label_mp3_title"); ?>" class="btn btn-primary btn-xs btn-download-mp3">
                               <i class="fa fa-cloud-download"></i> <?php echo ___("label_mp3"); ?>
                            </button>
                            <?php } ?>
                            <?php if($this->config->item('lyrics_button') == '1'){ ?>
                             <button type="button" id="lyric" title="<?php echo ___("label_lyrics_title"); ?>" class="btn btn-primary btn-xs">
                               <i class="fa fa-align-center"></i> <?php echo ___("label_lyrics"); ?>
                            </button>
                            <?php } ?>
                             <?php if($this->config->item('volume_control') == '1'){ ?>
                            <input type="text" id="volume" class="col-xs-12" value="" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="100" data-slider-orientation="horizontal" data-slider-selection="after"data-slider-tooltip="hide">
                            <?php } ?>


	                </span>
	                <div id="playlist-items">
	                </div>                 
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div id="page-content-wrapper">
            <div class="navbar navbar-default" style="margin-bottom:0px;z-index:999">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><span id="menu-toggle" href="#" class="btn btn-primary btn-xs"><i class="fa fa-list"></i></span> <?php echo $this->config->item("brand"); ?></a>
                </div>
                <div class="navbar-collapse collapse navbar-responsive-collapse">
                    <ul class="nav navbar-nav">
                        <?php if($this->config->item('youtube_button') == '1'){ ?>
                          <li id="videoPlayer" title="<?php echo ___("label_video"); ?>"><a href="#"><i class="fa fa-youtube"></i></a></li>                         
                        <?php } ?>
                        <?php if($this->config->item('random_button') == '1'){ ?>
                          <li id="random" title="<?php echo ___("label_random"); ?>"><a href="#"><i class="fa fa-random"></i></a></li>       
                        <?php } ?>
                        <li class="active" id="stopRadio" style="display:none" onClick="stop_radio();"><a href="#"><i class="fa fa-rss"></i> <?php echo ___("label_stop_radio"); ?></a></li>                                                 
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo ___("label_top"); ?>"><i class="fa fa-star"></i></a>
                            <ul class="dropdown-menu">
                                <li id="topArtist"><a href="#"><?php echo ___("label_artist"); ?></a></li>
                                <li id="topTrack"><a href="#"><?php echo ___("label_track"); ?></a></li>                                                                
                            </ul>
                        </li>


                         <li class="dropdown" id="shareMenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo ___("label_share"); ?>"><i class="fa fa-share-square"></i></a>
                            <ul class="dropdown-menu">
                              <li><a href="#" onClick="share('fb');return false;"><i class="fa fa-facebook-square"></i> Facebook</a></li>                              
                              <li><a href="#" onClick="share('tw');return false;"><i class="fa fa-twitter"></i> Twitter</a></li>                              
                              <li><a href="#" onClick="share('gp');return false;"><i class="fa fa-google-plus-square"></i> Google Plus</a></li>                              
                              <li><a href="#" onClick="share('c');return false;"><i class="fa fa-link"></i> Copy Link</a></li>                              
                            </ul>
                          </li>


                        
                        <li class="dropdown">
			                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ___("label_genres"); ?> <b class="caret"></b></a>
			                <ul class="dropdown-menu" id="tags">
                        <?php if($this->config->item("genres") != '')
                        {
                          $tags = explode(",", $this->config->item("genres"));
                          foreach ($tags as $key => $value) {                          
                            ?><li><a href="<?php echo base_url(); ?>tag/<?php echo encode($value); ?>" class="removehref" onClick="return false;" data-tag="<?php echo encode($value); ?>"><?php echo ucwords($value); ?></a></li><?php
                          }
                        }
                        else
                        {

                          ?>
			                  <li><a href="<?php echo base_url(); ?>tag/alternative" class="removehref" onClick="return false;" data-tag="alternative">Alternative</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/blues" class="removehref" onClick="return false;" data-tag="blues">Blues</a></li>
                        <li><a href="<?php echo base_url(); ?>tag/christian" class="removehref" onClick="return false;" data-tag="christian">Christian</a></li>
                        <li><a href="<?php echo base_url(); ?>tag/classical" class="removehref" onClick="return false;" data-tag="classical">Classical</a></li>			                  
			                  <li><a href="<?php echo base_url(); ?>tag/country" class="removehref" onClick="return false;" data-tag="country">Country</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/dance" class="removehref" onClick="return false;" data-tag="dance">Dance</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/easy-listening" class="removehref" onClick="return false;" data-tag="easy listening">Easy Listening</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/electronic" class="removehref" onClick="return false;" data-tag="electronic">Electronic</a></li>
							         <li><a href="<?php echo base_url(); ?>tag/hip-hop" class="removehref" onClick="return false;" data-tag="hip-hop">Hip-Hop</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/indie-pop" class="removehref" onClick="return false;" data-tag="indie pop">Indie Pop</a></li>
							           <li><a href="<?php echo base_url(); ?>tag/instrumental" class="removehref" onClick="return false;" data-tag="instrumental">Instrumental</a></li>                
							         <li><a href="<?php echo base_url(); ?>tag/japanese" class="removehref" onClick="return false;" data-tag="japanese">Japanese</a></li>
                       <li><a href="<?php echo base_url(); ?>tag/jazz" class="removehref" onClick="return false;" data-tag="jazz">Jazz</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/latino" class="removehref" onClick="return false;" data-tag="latino">Latino</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/opera" class="removehref" onClick="return false;" data-tag="opera">Opera</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/pop" class="removehref" onClick="return false;" data-tag="pop">Pop</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/reggae" class="removehref" onClick="return false;" data-tag="reggae">Reggae</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/rock" class="removehref" onClick="return false;" data-tag="rock">Rock</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/rap" class="removehref" onClick="return false;" data-tag="rap">Rap</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/soundtrack" class="removehref" onClick="return false;" data-tag="soundtrack">Soundtrack</a></li>
			                  <li><a href="<?php echo base_url(); ?>tag/world" class="removehref" onClick="return false;" data-tag="world">World</a></li>
                        <?php } ?>
			                </ul>
			              </li>

                    
                 
                         <li id="nowPlaying"><a href="#" onClick="return false;"><?php echo ___("label_now_playing"); ?></a></li>
                          <?php if($this->config->item("user_change_lang") == "1")
                          {?>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ___("label_language"); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu" id="tags">
                              <?php foreach ($this->config->item("langs_available") as $key => $value) {
                                ?>
                                <li><a href="?lang=<?php echo $value; ?>"><?php echo ucfirst($value); ?></a></li>
                                <?php
                              }
                              ?>
                            </ul>
                          </li>
                          <?php } ?>

                            <?php
                            if($this->session->userdata('is_admin') == 1 && $this->config->item("use_database") == 1)
                            {
                              ?>
                              <li id="admin"><a href="<?php echo base_url(); ?>dashboard"><span  class="label label-danger">Admin</span></a></li>
                              <?php

                            }
                            ?>


                          <?php if($pages){if($pages->num_rows()>0){ ?>
                         <li class="dropdown" id="shareMenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" ><?php echo ___("label_page"); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                              <?php foreach ($pages->result() as $row) {
                                ?>
                                <li><a href="#" onClick="showPage('<?php echo $row->idpage; ?>');return false;"> <?php echo $row->title; ?></a></li>                                                            
                                <?php
                              }
                              ?>
                              
                            </ul>
                          </li>
                          <?php }} ?>


                    </ul>
                    <?php if($this->config->item('registration') == "1" && !is_logged()) { ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li  id="menuLogin">
                          <a  href="#" id="navLogin"><?php echo ___("label_login"); ?></a>                         
                        </li>
                    </ul>
                      <?php } ?>

                      <?php if($this->config->item('registration') == "1" && is_logged()) { ?>
                      <ul class="nav navbar-nav navbar-right">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('nickname'); ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li><a href="#" onClick="myPlaylist();"><i class="fa fa-folder-open-o"></i> <?php echo ___("label_music_folder"); ?></a></li>
                          <li><a href="#" onClick="changePassword();"><i class="fa fa-lock"></i> <?php echo ___("label_change_password"); ?></a></li>
                          <li class="divider"></li>
                            <li><a href="#" onClick="profile();"><i class="fa fa-user"></i> <?php echo ___("label_profile"); ?></a></li>
                          <li class="divider"></li>
                          <li>
                            <a  href="<?php echo base_url(); ?>music/logout" id="navLogin"><i class="fa fa-sign-out"></i> <?php echo ___("label_logout"); ?></a>                         
                          </li>
                        </ul>   
                      </li>                 
                      <?php } ?>


                   
                   
                </div>
            </div>

         

            <div class="navbar navbar-default" style="margin-top:0px;;z-index:998">
           
                    <div class="col-md-3" style="padding-top:15px" id="controls">
                    	
	                        <button class="btn btn-primary" id="play" onClick="playNextSong(0)"><i class="fa fa-play"></i></button>
	                        <button class="btn btn-primary" id="pause" style="display:none" onClick="pause();"><i class="fa fa-pause"></i></button>
	                        <button class="btn btn-primary btn-sm" onClick="playBackSong();"><i class="fa fa-step-backward"></i></button>
	                        <button class="btn btn-primary btn-sm" onClick="playNextSong();"><i class="fa fa-step-forward"></i></button>
	                        
	                     
                        
                    </div>                    
                    <div class="col-md-9"  style="padding-top:5px"> 
  
                        <div class="btn-group" style="margin-bottom:2px">
                            <span class="" disabled id="artistInfo">&nbsp;</span>
                            <span class="" disabled><i class="fa fa-angle-double-right"></i></span>
                            <span class="" disabled id="trackInfo">&nbsp;</span>
                            <span class="" disabled><i class="fa fa-angle-double-right"></i></span>
                            <span class="" disabled id="loaded">&nbsp;</span>
                           
                        </div>
                         <span class="pull-right" disabled id="tracktime">00:00</span> 
                         <span class="pull-right" disabled>/</span>
                         <span class="pull-right" disabled id="tracktime2">00:00</span> 
                        <div id="current" class="progress" style="margin-bottom:1px;height:16px">
                          <div class="progress-bar progress-bar-success" style="width: 0%;height:10px;margin-top:3px;"></div>
                          
                        </div>
                        <div id="buffer" class="progress" style="height:2px;cursor:wait">
						  <div class="progress-bar progress-bar-info" style="width: 0%;cursor:wait"></div>
						</div>
                    </div>                    
                            
            </div>       
              
            <!-- Keep all page content within the page-content inset div! -->
            <div class="page-content inset">      	
	            <div class="row">               
	                <div class="col-md-12 well">
	                    <div class="input-group input-group">                        
	                        <input autocomplete="OFF"  type="text" class="form-control"  id="s" placeholder="<?php echo ___("label_listen"); ?>" value="<?php echo $search; ?>">
	                        <span class="input-group-btn">
	                            <button class="btn btn-success" id="btnSearch" type="button"><?php echo ___("label_search"); ?> <i class="fa fa-search"></i></button>
	                        </span>
	                    </div>                  
					</div>
				</div>
			</div>

             <?php if($this->config->item("ads_refresh") == '0'){ ?>
              <center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block"); } ?></center><br><br>
            <?php } ?>
            <div class="page-content inset" id="target">      			
            <?php if($this->config->item("lastfm") == '')
            {
              ?>
              <div class="alert alert-danger">
                <strong>Error Api KEY</strong> Remember config your api key on your <a href="<?php echo base_url(); ?>admin">admin panel</a>
              </div>
              <?php 
            }
            ?>

            <?php if(!is_writable_cache())
            {
              ?>
              <div class="alert alert-danger">
                <strong>Error Cache Folder</strong> Please allow read/write persmission (777) to the cache folder in your root.
              </div>
              <?php 
            }
            ?>

            <?php echo $page; ?>
            </div>
            <div class="clearfix"></div>
            <center class="adsblock"><?php if(!$hide_ads){ echo $this->config->item("ads_block_footer"); } ?></center>
              <div style="text-align:center;width:100%">
                <?php echo $this->config->item("footer_text"); ?> 
              </div>         
        </div>

    </div>

    <div class="modal" id="popup">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
              <h4 class="modal-title"><?php echo $this->config->item("title"); ?></h4>           
          </div>
          <div class="modal-body">
                <center>
                    <?php echo $this->config->item("popup_code"); ?>
                </center>
          </div>          
        </div>
      </div>
    </div>

     <div class="modal" id="importPlayList">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
              <h4 class="modal-title"><?php echo ___("msg_import_playlist"); ?></h4>           
          </div>
          <div class="modal-body">                
                <div class="alert alert-info"><?php echo ___("msg_select_json"); ?><br><strong><?php echo ___("msg_target"); ?>:</strong> <span id="pltrg"></span></div>
                <input type="file" id="files" name="files" />
          </div>          
        </div>
      </div>
    </div>

    <div class="modal" id="customShare">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
              <h4 class="modal-title"><?php echo ___("label_share"); ?></h4>           
          </div>
          <div class="modal-body">                     
                <textarea readonly style="width:100%;min-height;100px"></textarea>
                <p>Copy and share link</p>
          </div>          
        </div>
      </div>
    </div>

     <div class="modal" id="savePlaylistModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
              <h4 class="modal-title"><?php echo ___("label_new_playlist"); ?></h4>           
          </div>
          <div class="modal-body">   
                <div class="alert alert-info">
                  <?php echo ___("msg_save_playlist"); ?>
                </div>                  
             
                <div class="form-group">
                  <label for="namePlaylist"><?php echo ___("label_name_playlist"); ?></label>
                  <input type="text" class="form-control" id="namePlaylist" placeholder="<?php echo ___("label_name_playlist"); ?>">
                </div>               
                <button type="button" onClick="savePlayListDB()" class="btn btn-default pull-right"><?php echo ___("label_save_playlist"); ?></button>
                <div class="clearfix"></div>
              
          </div>          
        </div>
      </div>
    </div>

    <?php if(!is_logged())
    {
    ?>
    <div class="modal" id="loginModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
              <h4 class="modal-title"><?php echo ___("label_login"); ?></h4>           
          </div>
          <div class="modal-body loginModal">
              <form class="form-signin" role="form">
                <div id="loginForm" >
                  <h3 class="form-signin-heading"><?php echo ___("label_sing_in"); ?></h3>
                  <input type="email" name="email" class="form-control" placeholder="<?php echo ___("label_email"); ?>" required autofocus>
                  <input type="password" name="password1" class="form-control" placeholder="<?php echo ___("label_password"); ?>" required>          
                  <a href="#" onClick="$('#recoveryForm').slideDown();$('#loginForm').slideUp();$('#registerForm').slideUp();"><?php echo ___("label_recovery_password"); ?></a>
                  <button  onClick="login();" class="btn btn-primary" style="width:100%;margin-top:10px;margin-bottom:10px" type="button"><?php echo ___("label_login"); ?></button>                          
                  <?php if($this->config->item("loginfb") == '1' && $this->config->item("fb_appId") != '' && $this->config->item("fb_secret") != '' ){ ?>                  
                  <a class="btn btn-primary btn-block"  href="<?php echo base_url(); ?>music/facebook/login"><i class="fa fa-fw fa-facebook"></i> <?php echo ___("label_login_facebook"); ?></a>                          
                  <?php } ?>
                </div>
                <div id="registerForm" style="display:none" >
                  <?php echo $this->load->view("templates/common/_form_register",false,true); ?>                 
                </div>

                <div id="recoveryForm" style="display:none" >
                  <h3 class="form-signin-heading"><?php echo ___("label_recovery_password"); ?></h3>
                  <input type="email" name="email" class="form-control" placeholder="<?php echo ___("label_email"); ?>" required autofocus>                  
                  <button  onClick="recoveryPassword();" class="btn btn-danger" style="width:100%" type="button"><?php echo ___("label_sendme_password"); ?></button>
                  <hr>
                </div>

                <button onClick="$('#recoveryForm').slideUp();$('#loginForm').slideDown();$('#registerForm').slideUp();$('.btnregister').fadeIn(500);$('.btnlogin').fadeOut(500);"  class="btn btn-primary btn-block btnlogin" style="display:none" type="button"><?php echo ___("label_login"); ?></button>
                <button onClick="$('#recoveryForm').slideUp();$('#loginForm').slideUp();$('#registerForm').slideDown();$('.btnregister').fadeOut(500);$('.btnlogin').fadeIn(500);" class="btn btn-info pull-right btn-block btnregister"  type="button"><?php echo ___("label_register"); ?></button>
                <div class="clearfix"></div>
              </form>
              
          </div>          
        </div>
      </div>
    </div>
    <?php }else{
      ?>
       <div class="modal" id="chPasswordModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
              <h4 class="modal-title"><?php echo ___("label_change_password"); ?></h4>           
          </div>
          <div class="modal-body loginModal">
              <form class="form-signin" role="form">
                <div id="changePasswordForm" >
                  <h3 class="form-signin-heading"><?php echo ___("label_change_password"); ?></h3>                  
                  <input type="password" name="password1" class="form-control" placeholder="<?php echo ___("label_password"); ?>" required>          
                  <input type="password" name="password2" class="form-control" placeholder="<?php echo ___("label_password_repeat"); ?>" required>                            
                  <button  onClick="change();" class="btn btn-primary" style="width:100%;margin-top:10px;margin-bottom:10px" type="button"><?php echo ___("label_change_password_button"); ?></button>                          
                </div>

                
                <div class="clearfix"></div>
              </form>
              
          </div>          
        </div>
      </div>
    </div>
      <?php
      } ?>

    <ul id="contextMenu" class="dropdown-menu" role="menu" style="display:none" >
    <?php if($this->config->item('registration') == "1" && is_logged()) { ?>
      <li class="dropdown-submenu">
        <a tabindex="-1" href="#"><?php echo ___("label_add_to"); ?></a>
        <ul class="dropdown-menu" id="playlistSaved">          
        </ul>
      </li>
    <?php } ?>
      <li class="dropdown-submenu">
        <a tabindex="-1" href="#"><?php echo ___("label_playlist"); ?></a>
        <ul class="dropdown-menu" id="changePlaylist2">          
            <?php for($x=1;$x<=intval($this->config->item("nplaylist"));$x++)
              {
                ?><li data-playlist="<?php echo $x; ?>" class="playlist_<?php echo $x; ?>"><a href="#"><?php echo ___("label_load_playlist"); ?> <?php echo $x; ?></a></li><?php
              }
              ?>
        </ul>
      </li>
      <?php if($this->config->item('registration') == "1" && is_logged()) { ?>
        <li class="divider"></li>
        <li onClick="myPlaylist();" ><a href="#"><i class="fa fa-folder-open-o"></i> <?php echo ___('label_music_folder'); ?></a></li>
        <li class="divider"></li>
      <?php } ?>
      <li><a tabindex="-1" data-action="remove" href="#"><i class="fa fa-trash-o"></i> <?php echo ___("label_remove_item"); ?></a></li>
      <li><a tabindex="-1" data-action="playThis" href="#"><i class="fa fa-play"></i> <?php echo ___("label_playnow"); ?></a></li>
      <?php if($this->config->item('lyrics_button') == '1'){ ?>
        <li><a tabindex="-1" data-action="getlyric" href="#"><i class="fa fa-align-center"></i> <?php echo ___("label_lyrics_title"); ?></a></li>
      <?php } ?>
    </ul>



    <form method="POST" id="export" action="<?php echo base_url(); ?>music/exportPlayList" class="hide" target="_blank">
        <textarea name="list"></textarea>
        <button type="submit"></button>
    </form>

    <!-- JavaScript --> 

  
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>    
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-slider.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap3-typeahead.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/notify.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sort.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/menu.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/js/custom.js?v=2.0-<?php echo date("Ymd"); ?>"></script>
    
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
    $("#trgPlaylist").on('click', function(event) {        
        event.preventDefault();
        $("#playlist").slideToggle(0);
    });
    $(function() {
        /*if(!$("#s").val() =='')            
            $("#btnSearch").click();*/

         <?php
      
          if($this->input->get("playlist",true))
          {
            ?>loadPlayListShare('<?php echo $this->input->get("playlist",true); ?>');<?php
          }
          ?>
    });
    </script>
        <?php echo $this->load->view("templates/common/_footer",false,true); ?>
    
    

</body>
</html>
