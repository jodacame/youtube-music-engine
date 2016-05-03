  <!-- 
    SCRIPT: Youtube Music Engine 
    http://codecanyon.net/item/youtube-music-engine/7490975?ref=jodacame
  -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">        
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="google-site-verification" content="<?php echo $this->config->item("gwebmaster"); ?>" />
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png"/>
    <meta name="author" content="Jodacame">

    
    <?php
     if($og_fb){ 
     foreach ($og_fb as $key => $value) {
        if(!is_array($value))
        {
          ?><meta property="<?php echo $key; ?>" content="<?php echo $value ; ?>">
          <?php  
        }
        else
        {
          foreach ($value as $k => $v) {
            ?><meta property="<?php echo $k; ?>" content="<?php echo $v ; ?>">
            <?php  
          }
        }
        
      }
    }
    ?>

    <?php if($this->config->item("comment_fb_id") != '')
    {
      ?><meta property="fb:admins" content="<?php echo $this->config->item("comment_fb_id"); ?>"/><?php
    }
    ?> 
    <?php if($this->config->item("comment_fb_app_id") != '')
    {
      ?><meta property="fb:app_id" content="<?php echo $this->config->item("comment_fb_app_id"); ?>"/><?php
    }


   
        if($this->input->get("s",true))
        {
          $data           = json_decode(searchLastFm(decode($this->input->get("s",true))));    

            if(is_object($data->results->trackmatches))
            {
                if(count($data->results->trackmatches->track)>1)
                    $temp = $data->results->trackmatches->track;
                if(count($data->results->trackmatches->track)==1)
                    $temp[0] = $data->results->trackmatches->track;

                

             
                $picture    = $temp[0]->image[4]->text;
                if($picture == '')
                  $picture    = $temp[0]->image[3]->text;
                if($picture == '')
                   $picture = base_url()."assets/images/no-cover.png";

                $artist   = json_decode(getArtistInfo($temp[0]->artist));
              
                $ogdesciption = strip_tags(addslashes($artist->artist->bio->content));
                $ogtitle = $temp[0]->name." by ".$temp[0]->artist;
               
                $title2 .= $temp[0]->name." by ".$temp[0]->artist;
              }
        }
        else{        
      ?>
      <meta name="description" content="<?php echo addslashes($description2).$this->config->item("description"); ?>">
      <?php
      }
    
  
    ?>   
    <meta name="keywords" content="<?php echo $this->config->item("meta_keywords"); ?>"> 
    <meta name="author" content="">
    <title><?php echo (urldecode($title2)); ?> <?php echo $this->config->item("title"); ?></title>
    <?php
    if(!$picture != '')
    {    
      ?><meta property="og:image" content="<?php echo base_url(); ?>assets/images/fb_preview.png"/><?php 
    }        
    
    ?>
    
    

    <?php 
   
    if($metatags){ 
      foreach ($metatags as $key => $value) {
        ?><meta name="<?php echo $key; ?>" content="<?php echo $value ; ?>">
        <?php
      }
    }
    else
    {
      ?>
      <?php if($this->config->item("twitter_username") != '') { ?>
        <meta name="twitter:title" content="<?php echo $this->config->item("title") ; ?>">            
        <meta name="twitter:card" content="summary_large_image">            
        <meta name="twitter:description" content="<?php echo $this->config->item("description") ; ?>">    
      <?php
      }
     
    }
    ?>
    <?php if($this->config->item("twitter_username") != '') { ?>
    <meta name="twitter:site" content="@<?php echo $this->config->item("twitter_username") ; ?>">    
    <meta name="twitter:creator" content="@<?php echo $this->config->item("twitter_username") ; ?>">    
    <?php } ?>  
    
    
    
    <?php
    if($meta_others)
    {

      foreach ($meta_others as $key => $value) {
        echo "<".$value['type']." ";
        foreach ($value['attr'] as $key => $value) {
          echo $key.'="'.$value.'" ';
        }
        echo ">";
      }
    }
    ?>
    


    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">    
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <?php 
    $genericThemes = array('yeti','superhero','united','slate','spacelab','simplex','readable','lumen','journal','amelia','cerulean','cosmo','cyborg','darkly','default','flatly','flat-yme','yme-boske');
    if(in_array($this->config->item("theme"),$genericThemes)){ ?>
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <?php } ?>
    <?php 
    echo getStyle(); ?>
    <link href="<?php echo base_url(); ?>assets/css/timeline.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>


      <script src="//www.youtube.com/iframe_api"></script>    
    <script type="text/javascript">

    var base_url              = '<?php echo base_url(); ?>';
    var popup                 = '<?php echo $this->config->item("popup"); ?>';
    var is_mobile             = '<?php echo $this->agent->is_mobile(); ?>';
    var title                 = "<?php echo $this->config->item("title"); ?>";    
    var msg_required_fields   = "<?php echo ___('msg_required_fields'); ?>";
    var label_discover        = "<?php echo ___('label_discover'); ?>";
    var msg_clear_playlist   = "<?php echo ___('msg_clear_playlist'); ?>";
    var msg_exit_page         = "<?php echo ___('msg_exit_page'); ?>";
    var label_loading         = "<?php echo ___('label_loading'); ?>";
    var extend                = "<?php echo $this->config->item('use_database'); ?>";
    var start_youtube         = "<?php echo intval($this->config->item('start_youtube')); ?>";
    var label_loading_playlist= "<?php echo ___('label_loading_playlist'); ?>";
    var error_max             = "<?php echo ___('error_playlist_max'); ?>";
    var hide_ads_registered   = "<?php echo $this->config->item('hide_ads_registered'); ?>";
    var is_logged             = "<?php echo is_logged(); ?>";
    var youtube_control       = "<?php echo $this->config->item('youtube_controls'); ?>";
    var youtube_quality       = "<?php echo $this->config->item('youtube_quality'); ?>";
    var amazonID              = "<?php echo $this->config->item("amazon_afiliate"); ?>";
    var limit_time            = <?php echo $this->config->item("max_time_player"); ?>;
    var show_ads_float_rand   = <?php echo $this->config->item("show_ads_float_rand"); ?>;
    var cache                 = <?php echo $this->config->item("local_cache"); ?>;
    var cache_id              = "<?php echo $this->config->item("local_cache_id"); ?>";    
    var ___debug              = <?php echo $this->config->item("debug"); ?>;  
    </script>
  <?php if($this->config->item("comment_fb_app_id") != '')
    {
      ?>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/<?php echo $this->config->item("comment_fb_lang"); ?>/sdk.js#xfbml=1&appId=<?php echo $this->config->item("comment_fb_app_id"); ?>&version=v2.3";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <?php } ?>
    <!-- Custom Code -->
    <?php echo $this->config->item("header_code"); ?>
    <!-- /Custom Code -->
<?php if($this->config->item("remove_download_button") == '1'){ ?>
<style type="text/css" media="screen">
.btn-download-mp3{
  display:none !important;
  opacity:0 !important;
  width:0px;
  height:0px;
  visibility:hidden !important;
}  
</style>
<script>
document.addEventListener("DOMContentLoaded", function(event) { 
  $(".jp-controls div .btn-download-mp3").parent().remove();
  $(".btn-download-mp3").remove();

});
</script>
<?php } ?>