<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1">    
    <title><?php echo $this->config->item("title"); ?></title>

    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/themes/<?php echo $this->config->item("theme"); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
      <script src="//www.youtube.com/iframe_api"></script>    
    <script type="text/javascript">
    var base_url              = '<?php echo base_url(); ?>';
    var popup                 = '<?php echo $this->config->item("popup"); ?>';
    var is_mobile             = '1';
    var title                 = '<?php echo $this->config->item("title"); ?>';
    var download_service      = '<?php echo $this->config->item("download_service"); ?>';
    var msg_required_fields   = "<?php echo ___('msg_required_fields'); ?>";
    var msg_exit_page         = "<?php echo ___('msg_exit_page'); ?>";
    var extend                = "<?php echo $this->config->item('use_database'); ?>";
    var start_youtube         = "0";
    var error_max             = "<?php echo ___('error_playlist_max'); ?>";
    var hide_ads_registered   = "<?php echo $this->config->item('hide_ads_registered'); ?>";
    var is_logged             = "<?php echo is_logged(); ?>";
    </script>

  </head>
  <body>

  <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-bottom" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="glyphicon glyphicon-music" id="trgToogle"></span>            
          </button>
         

          <a class="navbar-brand" href="#"><?php echo $this->config->item("brand"); ?></a>
        </div>
        <div class="collapse navbar-collapse">
          <div class="col-xs 12">
            <div class="navbar-form"> 
                  <div  id="thumbnail" class="hidePlayer">
          <div id="player">  
          <center>
                <div id="ytapiplayer" style="margin:0 auto 0 auto" ></div>
                </center>
              </div>
            </div>
    <div id="player-container">
      
        <div class="controls" id="controls" style="text-align:Center">         

          
            <button class="btn btn-primary" onClick="playBackSong();"><i class="fa fa-step-backward"></i></button>
            <button class="btn btn-primary" id="play" onClick="playNextSong(0)"><i class="fa fa-play"></i></button>            
            <button class="btn btn-primary" id="pause" style="display:none" onClick="pause();"><i class="fa fa-pause"></i></button>            
                <?php if($this->config->item("amazon_afiliate") != '')
            {
              ?><button id="amazon" data-amazon="<?php echo $this->config->item("amazon_afiliate"); ?>" class="btn btn-warning amazon" title="<?php echo ___("label_buy_on_amazon"); ?>"><i class="fa fa-shopping-cart"></i> </button><?php
            }
            ?>

            <button class="btn btn-primary" onClick="playNextSong();"><i class="fa fa-step-forward"></i></button>
            
          

        </div>        
    
      
    </div>
            </div> <!-- /navbar -form -->
          </div>         
        </div><!--/.nav-collapse -->

 

      </div>
    </div>

    <div class="container">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs navbar navbar-default navbar-fixed-top" role="tablist">
        
        <li><a href="#playlist-items" role="tab" data-toggle="tab"> <span class="label label-info pull-right" id="numItems"></span>  <?php echo ___("label_load_playlist"); ?> </a></li>
        <li class="active"><a href="#search" role="tab" data-toggle="tab">  <span class="glyphicon glyphicon-search"></span> <?php echo ___("label_search"); ?></a></li>        
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">       
        <div class="tab-pane  exclude" id="playlist-items"></div>
        <div class="tab-pane active" id="search">
          <div class="col-xs 12">
            <div class="navbar-form" role="search"  id="frmSearch"> 
                <div class="input-group">
                    <input type="text" class="form-control searchField"  placeholder="Search" name="srch-term" id="srch-term">
                    <div class="input-group-btn">
                        <button class="btn btn-default" id="btnSearch" type="submit"><i class="glyphicon glyphicon-chevron-right"></i></button>
                    </div>
                </div>

            </div>

          </div> 
          <div class="page-content inset" id="target" style="padding:10px">            
            <?php echo $page; ?>
          </div>
          <br>
          <center class="adsblock"><?php echo $this->config->item("ads_block"); ?></center>     
        </div>
      </div>
  




        
    </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/bootstrap-slider.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap3-typeahead.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/notify.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sort.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/menu.js"></script>    


    <script src="<?php echo base_url(); ?>assets/js/custom-smart.js?v=2.0-<?php echo date("Ymd"); ?>"></script>
  </body>
</html>