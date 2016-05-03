 <div class="row">
 	<div class="col-xs-12">
	 	<div class="box box-primary">
	 	 	<form role="form" method="POST">
		 		<div class="box-body">
		 		

					   <div class="form-group col-md-12">
					    <label ><?php echo ___("admin_cover_frame"); ?></label>
					    <select  name="cover_search" class="form-control select-img">
					    <?php
					    
					    for($x=1;$x<=9;$x++){		    	
					    	?>
					    	<option data-img-src='<?php echo base_url(); ?>assets/images/bg-cover<?php echo $x; ?>.png' <?php if($x == $this->config->item("cover_search")){ echo "selected";} ?> value="<?php echo $x; ?>"><?php echo "Cover ".$x; ?></option>
					    	<?php			    		 	
					    }		    
					    ?>
					    </select>
					  </div>

					    <div class="form-group col-md-4">
						    <label >Website Brand</label>
						    <input name="brand"  placeholder="Can use html here for add your logo" type="text" class="form-control" placeholder="" value="<?php echo htmlentities($this->config->item("brand"), ENT_QUOTES, "UTF-8"); ?>">
						  </div>



					  <?php if(is_musik()){ 


						$icons_file = "http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css";
						$parsed_file = _curl($icons_file);
						preg_match_all("/fa\-([a-zA-z0-9\-]+[^\:\.\,\s])/", $parsed_file, $matches);
						$exclude_icons = array("fa-lg","fa-lg{", "fa-2x","fa-2x{", "fa-3x","fa-3x{", "fa-4x","fa-4x{", "fa-5x","fa-5x{", "fa-ul","fa-ul{", "fa-li", "fa-li{", "fa-fw{", "fa-border{","fa-border{", "fa-pulse{", "fa-rotate-90{", "fa-rotate-180{", "fa-rotate-270{", "fa-spin{", "fa-flip-horizontal{", "fa-flip-vertical{", "fa-stack{", "fa-ul>", "fa-stack-1x", "fa-stack-1x{", "fa-stack-2x{", "fa-inverse{");
						$icons = array("icons" => array_delete($matches[0], $exclude_icons));
						foreach ($icons['icons'] as $key => $value) {
							$icons['icons'][$key] = "fa ".$value;
						}
						
						$icons['icons'][] 	= 'icon-earphones';
						$icons['icons'][] 	= 'none';
						
					  	?>
					   <div class="form-group col-md-4">
					    <label >Brand Icon</label>
					    <select  name="brand_icon" class="form-control icon_select2">					    	
					    	<?php foreach ($icons['icons'] as $key => $value) {
					    		?><option <?php if($this->config->item("brand_icon") == $value){ echo "selected";} ?>  data-icon="<?php echo $value; ?>" value="<?php echo $value; ?>"><?php echo $value; ?></option>
					    	<?php
					    	}
					    	?>
					    	
					    </select>
					  </div>
					  <?php } ?>
					  <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_start"); ?></label>
					    <select  name="start" class="form-control select2">
					    	<option <?php if($this->config->item("start") == 'TopArtist'){ echo "selected"; } ?> value="TopArtist"><?php echo ___("label_top_artist"); ?> - Last.fm</option>
					    	<option <?php if($this->config->item("start") == 'TopArtistCustom'){ echo "selected"; } ?> value="TopArtistCustom"><?php echo ___("label_top_artist"); ?> - Custom</option>
					    	<option <?php if($this->config->item("start") == 'TopTracks'){ echo "selected"; } ?> value="TopTracks"><?php echo ___("label_top_tracks"); ?> - Last.fm</option>
					    	<option <?php if($this->config->item("start") == 'TopTracksItunes'){ echo "selected"; } ?> value="TopTracksItunes"><?php echo ___("label_top_tracks"); ?> - iTunes</option>					    						    	
					    	<option <?php if($this->config->item("start") == 'TopTracksActivity'){ echo "selected"; } ?> value="TopTracksActivity"><?php echo ___("label_top_tracks"); ?> - Activity</option>					    	
					    	<option <?php if($this->config->item("start") == 'Activity'){ echo "selected"; } ?> value="Activity"><?php echo ___("label_activity"); ?></option>
					    	<option <?php if($this->config->item("start") == 'SearchBox'){ echo "selected"; } ?> value="SearchBox">Search Box</option>
					    	<optgroup label="Pages">
					    	<?php foreach ($pages->result() as  $row) {
					    		?>
					    		<option  <?php if($this->config->item("start") == "page::{$row->idpage}"){ echo "selected"; } ?> value="page::<?php echo $row->idpage; ?>"><?php echo $row->title; ?></option>
					    		<?php
					    	}
					    	?>
					    	</optgroup>
					    	<optgroup label="Stations">
					    	<?php
					    			$stations = getStations();
									foreach ($stations->result() as $row) {
										$value = $row->idtstation;
										?>
										<option <?php if($this->config->item("start") == "station::$value"){ echo "selected"; } ?>   value="station::<?php echo $value; ?>"><?php echo $row->title; ?></option>
										<?php
									}
									?>
					    	</optgroup>

					    	<optgroup label="Genres">
					    	<?php
					    			$tags 			= json_decode(getTags());
									$tags_current 	= explode(",",$this->config->item("genres"));

									foreach ($tags->toptags->tag as $key => $value) {
										$tmp[] = $value->name;
									}
									sort($tmp);
									foreach ($tmp as $key => $value) {
										?>
										<option <?php if($this->config->item("start") == "genres::$value"){ echo "selected"; } ?>   value="genres::<?php echo $value; ?>"><?php echo ucwords(decode($value)); ?></option>
										<?php
									}
									?>
					    	</optgroup>
					    	<?php
					    	$custom = explode(",", $this->config->item("custom_genres"));
					    	?>
					    	<optgroup label="Custom Genres">
							<?php
							foreach ($custom as $key => $value) {
								?>

								<option  <?php if($this->config->item("start") == "genres::$value"){ echo "selected"; } ?>  value="genres::<?php echo $value; ?>"><?php echo ucwords($value); ?></option>
								<?php
							}
							?></optgroup>
					    </select>
					  </div>

					 <div class="form-group col-md-4">
					    <label >Top Tracks Link</label>
					    <select  name="top_tracks_link" class="form-control">					    	
					    	<option <?php if($this->config->item("top_tracks_link") == 'TopTracks'){ echo "selected"; } ?> value="TopTracks"><?php echo ___("label_top_tracks"); ?> - Last.fm</option>
					    	<option <?php if($this->config->item("top_tracks_link") == 'TopTracksItunes'){ echo "selected"; } ?> value="TopTracksItunes"><?php echo ___("label_top_tracks"); ?> - iTunes</option>					    						    	
					    	<option <?php if($this->config->item("top_tracks_link") == 'TopTracksActivity'){ echo "selected"; } ?> value="TopTracksActivity"><?php echo ___("label_top_tracks"); ?> - Activity</option>					    	
					    	
					    </select>
					  </div> 
					  <div class="form-group col-md-4">
					    <label >Top Artist Link</label>
					    <select  name="top_artist_menu" class="form-control">					    	
					    	<option <?php if($this->config->item("top_artist_menu") == 'lastfm'){ echo "selected"; } ?> value="l">Last.fm</option>					    	
					    	<option <?php if($this->config->item("top_artist_menu") == 'TopArtistCustom'){ echo "selected"; } ?> value="TopArtistCustom">Top Artist - Custom</option>					    	
					    	
					    </select>
					  </div>

					

					   <div class="form-group col-md-4">
					    <label >Brand Title Link</label>
					     <select  name="brand_link" class="form-control select2">
					    	<option <?php if($this->config->item("brand_link") == 'TopArtist'){ echo "selected"; } ?> value="TopArtist"><?php echo ___("label_top_artist"); ?> - Last.fm</option>
					    	<option <?php if($this->config->item("brand_link") == 'TopArtistCustom'){ echo "selected"; } ?> value="TopArtistCustom"><?php echo ___("label_top_artist"); ?> - Custom</option>
					    	<option <?php if($this->config->item("brand_link") == 'TopTracks'){ echo "selected"; } ?> value="TopTracks"><?php echo ___("label_top_tracks"); ?> - Last.fm</option>
					    	<option <?php if($this->config->item("brand_link") == 'TopTracksItunes'){ echo "selected"; } ?> value="TopTracksItunes"><?php echo ___("label_top_tracks"); ?> - iTunes</option>					    						    	
					    	<option <?php if($this->config->item("brand_link") == 'TopTracksActivity'){ echo "selected"; } ?> value="TopTracksActivity"><?php echo ___("label_top_tracks"); ?> - Activity</option>					    	
					    	<option <?php if($this->config->item("brand_link") == 'Activity'){ echo "selected"; } ?> value="Activity"><?php echo ___("label_activity"); ?></option>
					    	<option <?php if($this->config->item("brand_link") == 'SearchBox'){ echo "selected"; } ?> value="SearchBox">Search Box</option>
					    	<optgroup label="Pages">
					    	<?php foreach ($pages->result() as  $row) {
					    		?>
					    		<option  <?php if($this->config->item("brand_link") == "page::{$row->idpage}"){ echo "selected"; } ?> value="page::<?php echo $row->idpage; ?>"><?php echo $row->title; ?></option>
					    		<?php
					    	}
					    	?>
					    	</optgroup>
					    	<optgroup label="Genres">
					    	<?php
					    			$tags 			= json_decode(getTags());
									$tags_current 	= explode(",",$this->config->item("genres"));

									foreach ($tags->toptags->tag as $key => $value) {
										$tmp[] = $value->name;
									}
									sort($tmp);
									foreach ($tmp as $key => $value) {
										?>
										<option <?php if($this->config->item("brand_link") == "genres::$value"){ echo "selected"; } ?>   value="genres::<?php echo $value; ?>"><?php echo ucwords(decode($value)); ?></option>
										<?php
									}
									?>
					    	</optgroup>
					    	<?php
					    	$custom = explode(",", $this->config->item("custom_genres"));
					    	?>
					    	<optgroup label="Custom Genres">
							<?php
							foreach ($custom as $key => $value) {
								?>

								<option  <?php if($this->config->item("brand_link") == "genres::$value"){ echo "selected"; } ?>  value="genres::<?php echo $value; ?>"><?php echo ucwords($value); ?></option>
								<?php
							}
							?></optgroup>

					    </select>
					  </div>




					  <div class="form-group col-md-4">
					    <label >Left Menu (Only Musik Template)</label>
					    <select name="musik_left_menu" class="form-control">
					    	<option <?php if($this->config->item("musik_left_menu") == 'nav-xs'){ echo "selected"; } ?> value="nav-xs">Close</option>
					    	<option <?php if($this->config->item("musik_left_menu") != 'nav-xs'){ echo "selected"; } ?> value="0">Open</option>		    	
					    </select>
					  </div>  

					   <div class="form-group col-md-4">
					    <label >Menu Search (Only Musik Template)</label>
					    <select name="menu_search" class="form-control">
					    	<option <?php if($this->config->item("menu_search") == '1'){ echo "selected"; } ?> value="1">Show</option>
					    	<option <?php if($this->config->item("menu_search") != '1'){ echo "selected"; } ?> value="0">Hide</option>		    	
					    </select>
					  </div>  


					   <div class="form-group col-md-4">
					    <label >Menu Top Tracks (Only Musik Template)</label>
					    <select name="menu_top_tracks" class="form-control">
					    	<option <?php if($this->config->item("menu_top_tracks") == '1'){ echo "selected"; } ?> value="1">Show</option>
					    	<option <?php if($this->config->item("menu_top_tracks") != '1'){ echo "selected"; } ?> value="0">Hide</option>		    	
					    </select>
					  </div>  

					  <div class="form-group col-md-4">
					    <label >Menu Top Artist (Only Musik Template)</label>
					    <select name="menu_top_artist" class="form-control">
					    	<option <?php if($this->config->item("menu_top_artist") == '1'){ echo "selected"; } ?> value="1">Show</option>
					    	<option <?php if($this->config->item("menu_top_artist") != '1'){ echo "selected"; } ?> value="0">Hide</option>		    	
					    </select>
					  </div>  

					 

					  <div class="form-group col-md-4">
					    <label >Menu Genres (Only Musik Template)</label>
					    <select name="menu_genres" class="form-control">
					    	<option <?php if($this->config->item("menu_genres") == '1'){ echo "selected"; } ?> value="1">Show</option>
					    	<option <?php if($this->config->item("menu_genres") != '1'){ echo "selected"; } ?> value="0">Hide</option>		    	
					    </select>
					  </div>  




					  <div class="form-group col-md-4">
					    <label >Sidebar  (Only Musik Template)</label>
					    <select name="musik_sidebar" class="form-control">
					    	<option <?php if($this->config->item("musik_sidebar") == 'hide'){ echo "selected"; } ?> value="hide">Close</option>
					    	<option <?php if($this->config->item("musik_sidebar") != 'hide'){ echo "selected"; } ?> value="">Open</option>		    	
					    </select>
					  </div>   
					  <div class="form-group col-md-4">
					    <label >Stations List Style  (Only Musik Template)</label>
					    <select name="stations_style" class="form-control">
					    	<option <?php if($this->config->item("stations_style") == 'stations'){ echo "selected"; } ?> value="stations">Thumnbail</option>
					    	<option <?php if($this->config->item("stations_style") == 'stations_list'){ echo "selected"; } ?> value="stations_list">List With Filter</option>		    	
					    </select>
					  </div>     

					  <div class="form-group col-md-4">
					    <label >Force User Register</label>
					    <select name="force_register" class="form-control">
					    	<option <?php if($this->config->item("force_register") == '1'){ echo "selected"; } ?> value="1">Yes</option>
					    	<option <?php if($this->config->item("force_register") == '0'){ echo "selected"; } ?> value="0">No</option>		    	
					    </select>
					  </div>      

					  <div class="form-group col-md-4">
					    <label >Video on Lyrics Page (Only Musik Template)</label>
					    <select name="video_lyric" class="form-control">
					    	<option <?php if($this->config->item("video_lyric") == '1'){ echo "selected"; } ?> value="1">Yes</option>
					    	<option <?php if($this->config->item("video_lyric") == '0'){ echo "selected"; } ?> value="0">No</option>		    	
					    </select>
					  </div>    

					  <div class="form-group col-md-4">
					    <label >Show Related Aritst   (Only Musik Template)</label>
					    <select name="show_similar_artist" class="form-control">
					    	<option <?php if($this->config->item("show_similar_artist") == '1'){ echo "selected"; } ?> value="1">Yes</option>
					    	<option <?php if($this->config->item("show_similar_artist") == '0'){ echo "selected"; } ?> value="0">No</option>		    	
					    </select>
					  </div>    

					  <div class="form-group col-md-4">
					    <label >Download Mp3 Button</label>
					    <select name="download_button" class="form-control">
					    	<option <?php if($this->config->item("download_button") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("download_button") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>   
					  <div class="form-group col-md-4">
					    <label >Download Mp3 Only Registered</label>
					    <select name="download_only_registered" class="form-control">
					    	<option <?php if($this->config->item("download_only_registered") == '1'){ echo "selected"; } ?> value="1">Yes</option>
					    	<option <?php if($this->config->item("download_only_registered") != '1'){ echo "selected"; } ?> value="0">No</option>		    	
					    </select>
					  </div>    
					  <div class="form-group col-md-4">
					    <label >Remove Download Button</label>
					    <select name="remove_download_button" class="form-control">
					    	<option <?php if($this->config->item("remove_download_button") == '1'){ echo "selected"; } ?> value="1">Yes</option>
					    	<option <?php if($this->config->item("remove_download_button") != '1'){ echo "selected"; } ?> value="0">No</option>		    	
					    </select>
					  </div>  
					  <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_export_playlist"); ?></label>
					    <select name="export_playlist" class="form-control">
					    	<option <?php if($this->config->item("export_playlist") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("export_playlist") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>

					  <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_lyrics"); ?></label>
					    <select name="lyrics_button" class="form-control">
					    	<option <?php if($this->config->item("lyrics_button") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("lyrics_button") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>

					  <div class="form-group col-md-4">
					    <label >Closed Captions (Experimental)</label>
					    <select name="cc" class="form-control">
					    	<option <?php if($this->config->item("cc") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("cc") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>


					   <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_volume"); ?></label>
					    <select name="volume_control" class="form-control">
					    	<option <?php if($this->config->item("volume_control") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("volume_control") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>

					   <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_youtube_button"); ?></label>
					    <select name="youtube_button" class="form-control">
					    	<option <?php if($this->config->item("youtube_button") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("youtube_button") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>

					  <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_random"); ?></label>
					    <select name="random_button" class="form-control">
					    	<option <?php if($this->config->item("random_button") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("random_button") != '1'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>

					  <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_search"); ?></label>
					    <select name="search"  class="form-control">
					    	<option <?php if($this->config->item("search") == 'Modern'){ echo "selected"; } ?> value="Modern">Modern</option>
					    	<option <?php if($this->config->item("search") == 'Classic'){ echo "selected"; } ?> value="Classic">Classic</option>		    	
					    </select>
					  </div>

					   <div class="form-group col-md-4">
					    <label >Start Youtube Video Player</label>
					    <select name="start_youtube"  class="form-control">
					    	<option <?php if($this->config->item("start_youtube") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("start_youtube") == '0'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>   
					  <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_user_change_lang"); ?></label>
					    <select name="user_change_lang"  class="form-control">
					    	<option <?php if($this->config->item("user_change_lang") == '1'){ echo "selected"; } ?> value="1">On</option>
					    	<option <?php if($this->config->item("user_change_lang") == '0'){ echo "selected"; } ?> value="0">Off</option>		    	
					    </select>
					  </div>

					  <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_items_search"); ?></label>
					    <select name="items_search"  class="form-control">
					    	<?php for($x=1;$x<=100;$x++){ ?>
					    	<option <?php if($this->config->item("items_search") == $x){ echo "selected"; } ?> value="<?php echo $x; ?>"><?php echo $x; ?></option>
					    	<?php } ?>
					    	
					    </select>
					  </div> 

					  <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_limit_nplaylist"); ?></label>
					    <select name="nplaylist"  class="form-control">
					    	<?php for($x=1;$x<=5;$x++){ ?>
					    	<option <?php if($this->config->item("nplaylist") == $x){ echo "selected"; } ?> value="<?php echo $x; ?>"><?php echo $x; ?></option>
					    	<?php } ?>
					    	
					    </select>
					  </div> 

					   <div class="form-group col-md-4">
					    <label ><?php echo ___("admin_items_top"); ?></label>
					    <select name="items_top"  class="form-control">
					    	<?php for($x=1;$x<=50;$x++){ ?>
					    	<option <?php if($this->config->item("items_top") == $x){ echo "selected"; } ?> value="<?php echo $x; ?>"><?php echo $x; ?></option>
					    	<?php } ?>
					    	
					    </select>
					  </div>

					   <div class="form-group col-md-4">
					    <label >Youtube Video Quality </label>
					    <i class="fa fa-info-circle pull-right" style="cursor:help" title="If quality is not available for the video, then the quality will be set to the next lowest level that is available"></i>
					    <select name="youtube_quality"  class="form-control">
					    	<option <?php if($this->config->item("youtube_quality") == 'small'){ echo "selected"; } ?> value="small">Small</option>					    	
					    	<option <?php if($this->config->item("youtube_quality") == 'medium'){ echo "selected"; } ?> value="medium">Medium</option>					    	
					    	<option <?php if($this->config->item("youtube_quality") == 'large'){ echo "selected"; } ?> value="large">Large</option>					    	
					    	<option <?php if($this->config->item("youtube_quality") == 'hd720'){ echo "selected"; } ?> value="hd720">HD</option>					    	
					    	<option <?php if($this->config->item("youtube_quality") == 'default'){ echo "selected"; } ?> value="default">Auto</option>					    						    	
					    </select>
					  </div>

					   <div class="form-group col-md-4">
					    <label >Youtube Video Controls</label>
					    <select name="youtube_controls"  class="form-control">
					    	<option <?php if($this->config->item("youtube_controls") == '1'){ echo "selected"; } ?> value="1">Show</option>
					    	<option <?php if($this->config->item("youtube_controls") == '0'){ echo "selected"; } ?> value="0">Hide</option>		    	
					    </select>
					  </div>

					  <div class="form-group col-md-4">
					    <label >Popup Guest</label>
					    <select name="popup_guest"  class="form-control">
					    	<option <?php if($this->config->item("popup_guest") == '1'){ echo "selected"; } ?> value="1">Show</option>
					    	<option <?php if($this->config->item("popup_guest") == '0'){ echo "selected"; } ?> value="0">Hide</option>		    	
					    </select>
					  </div>
					  <div class="form-group col-md-4">
					    <label >Box Home Info Guest</label>
					    <select name="box_guest_info"  class="form-control">
					    	<option <?php if($this->config->item("box_guest_info") == '1'){ echo "selected"; } ?> value="1">Show</option>
					    	<option <?php if($this->config->item("box_guest_info") == '0'){ echo "selected"; } ?> value="0">Hide</option>		    	
					    </select>
					  </div> 

					    <div class="form-group col-md-4">
						    <label >Popup Guest Delay (Milliseconds)</label>
						    <input  name="popup_guest_delay" type="number" min="100" max="1000000" class="form-control" placeholder="" value="<?php echo $this->config->item("popup_guest_delay"); ?>">
						  </div>  

	 					<div class="form-group col-md-4">
						    <label >Report Wrong Video Button</label>
						    <select name="report_video"  class="form-control">
						    	<option <?php if($this->config->item("report_video") == '1'){ echo "selected"; } ?> value="1">Show</option>
						    	<option <?php if($this->config->item("report_video") == '0'){ echo "selected"; } ?> value="0">Hide</option>		    	
						    </select>
						</div>



					


		 		</div>
				<div class="clearfix"></div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary" style="width:100%">Save</button>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>	
	</div>
</div>
 
 <script src="<?php echo base_url(); ?>assets/plugins/image-picker.js"></script>
 

<script>
$(function () {
	$(".select-img").imagepicker();
	$('.icon_select2').select2({
	    width: "100%",
	    formatResult: format
	});
	function format(icon) {
	    var originalOption = icon.element;
	    console.log(originalOption);
	    return '<i class="' + $(originalOption).data('icon') + '"></i> ' + icon.text;
	}
});



</script>