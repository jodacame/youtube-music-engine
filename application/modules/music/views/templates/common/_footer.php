
    <div class="modal" id="popup_guest"   data-backdrop="static"  data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <?php if($this->config->item("force_register") == '0') {  ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
              <?php } ?>
              <h4 class="modal-title"><?php echo $this->config->item("title"); ?></h4>           
          </div>
          <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                      <img src="<?php echo base_url(); ?>assets/images/guest_register.png" class="img-responsive">
                    </div>
                    <div class="col-md-8">
                    <?php echo ___('msg_guest_dialog'); ?>
                          <div class="clearfix"></div>
                              <div class="row">
                              <br>
                              <?php if($this->config->item("facebook_fanpage")){ ?>
                              <div class="col-md-6">
                                  <div id="fb-root"></div>
                                    

                                  <div class="fb-like" data-href="<?php echo $this->config->item("facebook_fanpage"); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>      
                                </div>
                              <?php } ?>
                           <?php if($this->config->item("twitter_username")){ ?>
                            <div class="col-md-6">
                                 <a href="https://twitter.com/<?php echo $this->config->item("twitter_username"); ?>" class="twitter-follow-button" data-show-count="false">Follow @<?php echo $this->config->item("twitter_username"); ?></a>
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
          </div>  
          <div class="modal-footer">
                    <button class="btn btn-primary btn-block btn-md btn-login" data-dismiss="modal"><?php echo ___("label_login"); ?></button>
                    
                     <?php echo login_facebook(); ?>                    
                     <?php echo login_spotify(); ?>
                    <button class="btn btn-info btn-block btn-md btn-register" data-dismiss="modal"><?php echo ___("label_register"); ?></button>
          </div>        
        </div>
      </div>
    </div>




    <div class="modal fade" id="download_popup"   data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">              
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>               
              <h4 class="modal-title"><i class="fa fa-cloud-download"></i> <?php echo ___('label_download'); ?></h4>           
          </div>
          <div class="modal-body">
                  <div class="row">
                    <div class="col-md-4">
                        <img src="" style="width:100%" id="download_cover" class="img-thumbnail">
                      </div>
                      <div class="col-md-8 text-left">                        
                        <h4 id="download_query" style="margin:0px;margin-bottom:15px"></h4>
                        <?php if($this->config->item("itunes_afiliate") != ''){ ?>                                                                                          
                          <a href="#" class="text-left btn btn-primary btn-block btn-download-itunes"><i class="fa fa-apple pull-right"  style="margin-right:10px"></i> <?php echo ___('label_buy_on_itunes'); ?></a>
                        <?php } ?>
                        <?php if($this->config->item("amazon_afiliate")){ ?>
                          <a href="#" class="text-left btn btn-primary btn-block btn-download-amazon"><i class="fa fa-shopping-cart pull-right"  style="margin-right:10px"></i> <?php echo ___('label_buy_on_amazon'); ?></a>
                        <?php } ?>
                        <?php
                        $allow = true;
                        if($this->config->item("download_only_registered") == '1' && !is_logged())
                        {
                          $allow = false;
                        }
                        ?>
                        <?php if($this->config->item("download_button") == '1'){ ?>
                          <a href="#" class="text-left btn btn-primary btn-block <?php if($allow) { echo 'btn-download-youtube'; } else { echo 'btn-login'; } ?> "><i class="fa fa-youtube-play pull-right"  style="margin-right:10px"></i> <?php echo ___('label_download_from_youtube'); ?></a>
                        <?php } ?>
                        <br>
                        <br>

                      </div>
                   </div>

          </div>            
        </div>
      </div>
    </div>  

    <div class="modal fade" id="share_dialog"   tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">              
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>               
              <h4 class="modal-title"><i class="fa fa-share"></i> <?php echo ___('label_share'); ?> <span id="share_name"></span></h4>           
          </div>
          <div class="modal-body">
                  <div class="row">
                    <div class="col-md-5">
                        <img src="" style="width:100%" id="share_cover" class="img-thumbnail">
                      </div>
                      <div class="col-md-7 text-left" style="padding-top:10px">                                                
                        <button class="btn-share btn-share-facebook btn btn-primary btn-block"><i class="fa fa-facebook"></i> Facebook</button>                        
                        <button class="btn-share btn-share-twitter btn btn-info btn-block"><i class="fa fa-twitter"></i> Twitter</button>                        
                        <button class="btn-share btn-share-google-plus btn btn-danger btn-block"><i class="fa fa-google-plus-square"></i> Google Plus</button>                        
                        <button class="btn-share btn-share-copy-link btn btn-default btn-block"><i class="fa fa-link"></i> Copy Link</button>         
                        <?php if(is_musik() && $this->config->item("use_embed") == '1'){ ?>
                        <button class="btn-share btn-share-embed-link btn btn-secondary btn-block"><i class="fa fa-music"></i> <?php echo ___('label_embed'); ?> </button>                        
                        <?php } ?>
                        
                      </div>
                   </div>

          </div>            
        </div>
      </div>
    </div>





    <?php if(!is_logged() && $this->config->item("popup_guest") == '1' && $this->config->item("registration") == '1'){ ?>
    <script>


  $(function () {

    setTimeout(function() {
       $("#popup_guest").modal({
            "show":true,
            "keyboard":false}
          );
     }, <?php echo intval($this->config->item("popup_guest_delay")); ?>);
       
  });

    
    </script>
    <?php } ?>

  
    
    <script src="<?php echo base_url(); ?>assets/js/wookmark.js"></script>    
    <script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js"></script>    
    <script src="<?php echo base_url(); ?>assets/plugins/jquery.cache.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-ajax-localstorage-cache.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.js'></script>

    <?php if($this->config->item("ga") != '' ){ ?>
    <script>
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '<?php echo trim($this->config->item("ga") ); ?>']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();      
    </script>
    <?php } ?>

    <?php echo $this->config->item("footer_script"); ?>
    
    