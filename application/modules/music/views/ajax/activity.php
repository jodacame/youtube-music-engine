<?php if($activity->num_rows() > 0){ ?>
<div class="row">
	 <div class="col-md-offset-2 col-md-8 col-sm-12 top-margin" >                 
        <ul class="timeline" id="timeline">
         <?php foreach ($activity->result() as $key => $row) {           
            $icon[$row->action]['color'] = "orange";                 
            if($row->id == $this->session->userdata('id'))
                $icon[$row->action]['color'] = "blue";

           

         	?>
         	 <li>
                <i class="fa <?php echo $icon[$row->action]['icon']; ?> bg-<?php echo $icon[$row->action]['color']; ?>"></i>
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo ago(strtotime($row->date)); ?></span>
                    <h3 class="timeline-header"><a class="removehref" href="<?php echo base_url(); ?>user/<?php echo $row->nickname; ?>" onClick='profile("<?php echo $row->nickname; ?>");'><?php echo $row->nickname; ?></a> <small><?php echo more($row->bio); ?></small> </h3>
                    <div class="timeline-body">
                    	<div class="pull-right" >
                    		<img onClick='profile("<?php echo $row->nickname; ?>");' src="<?php echo $row->avatar; ?>" style="max-height:50px;max-width:100px;" class="cursor-pointer">
                    	</div>
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
                            <!--<button class="btn btn-info btn-xs <?php echo $disable; ?>" onclick="like(<?php echo $row->idactivity; ?>,$(this))"><i class="fa fa-heart"></i> <span class="like"><?php echo number_format($row->likes); ?></span> <?php echo ___("label_like"); ?></button>-->
                         
                        
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
     </div>

</div>
<?php }else{ ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning">
            Not Activity Found
        </div>
    </div>
</div>
<?php } ?>
<script>
timerActivity = setTimeout(function() {showActivity()}, 20000);
$(".removehref").attr("href","#");
</script>
