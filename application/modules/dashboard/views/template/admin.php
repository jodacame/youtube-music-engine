<?php 
if(file_exists('./application/modules/music/controllers/musik.php')){ 
    $musik = true;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Youtube Music Engine [Admin] | <?php echo $title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <!-- Ionicons -->
        <link href="<?php echo base_url(); ?>assets/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>assets/admin/css/main.css" rel="stylesheet" type="text/css" />

          <!-- Bootstrap Color Picker -->
        <link href="<?php echo base_url(); ?>assets/admin/css/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet"/>


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery 2.0.2 -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <link href="<?php echo base_url(); ?>assets/admin/css/morris/morris.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url(); ?>assets/admin/js/plugins/tagsinput/bootstrap-tagsinput.css" media="all" rel="stylesheet" type="text/css" />               
        <link href="<?php echo base_url(); ?>assets/admin/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />            

         <link href="<?php echo base_url(); ?>assets/admin/js/plugins/select2/select2.css" media="all" rel="stylesheet" type="text/css" />               
         <link href="<?php echo base_url(); ?>assets/admin/js/plugins/select2/select2-bootstrap.css" media="all" rel="stylesheet" type="text/css" />               

  

        <script>
        var base_url = '<?php echo base_url(); ?>';
        </script>

        

    </head>
    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url(); ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Youtube Music Engine
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
              <?php echo $_NAVBAR; ?>


            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
               <?php echo $_SIDEBAR; ?>
                <!-- /.sidebar -->
            </aside>
            <aside class="right-side">
                <section class="content-header">
                    <h1>
                       <?php echo $title; ?>
                        
                    </h1>
                 
                </section>

                <!-- Main content -->
                <section class="content">
                <?php echo $_PAGE; ?>
                </section>
                </aside>
           
        </div><!-- ./wrapper -->


     
        <!-- Bootstrap -->
        <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js" type="text/javascript"></script>
          <!-- DATA TABES SCRIPT -->
        <script src="<?php echo base_url(); ?>assets/admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/fileinput.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/core/app.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/plugins/tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/plugins/select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/custom.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/plugins/tinymce/tinymce.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/plugins/colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>

    
        <script>        

        <?php $my_playlist = get_playlist($this->session->userdata('id')); ?>

        tinymce.init({
            selector:'.tinymce',
              toolbar: [
                    "bold italic | forecolor backcolor | alignleft aligncenter alignright |  bullist numlist | outdent indent ",
                    "undo redo | styleselect | link unlink image | searchreplace | code",
                    "grid | buttons | shortcode | playlist"
                    
                ],

            plugins: [
                        "textcolor advlist autolink lists link image charmap anchor",
                        "searchreplace visualblocks code",
                        "insertdatetime media table contextmenu paste searchreplace"
                    ],
                setup : function(ed) {


                     ed.addButton('shortcode', {
                                type: 'menubutton',
                                text: 'Shortcodes',
                                icon: false,      
                                menu: [
                                    {text: 'Contact Form', onclick: function() {ed.insertContent('{contact-form}');}}<?php if($musik){ ?>,                                    
                                    {text: 'Custom Top Artist Page', onclick: function() {ed.insertContent('{custom-top-artist-page}');}},
                                    {text: 'Carousel', onclick: function() {ed.insertContent('{carousel}');}},
                                    {text: 'Radio Stations', onclick: function() {ed.insertContent('{radio-stations}');}},
                                    {text: 'Top Tracks', onclick: function() {ed.insertContent('{top-tracks}');}},                                    
                                    {text: 'Activity Page', onclick: function() {ed.insertContent('{activity-page}');}},
                                    {text: 'Custom Artist', onclick: function() {ed.insertContent('[custom type="artist" name="NAME_ARTIST_HERE" ]');}},
                                    {text: 'Custom Track', onclick: function() {ed.insertContent('[custom type="track" artist="NAME_ARTIST_HERE" track="NAME_TRACK_HERE"]');}},
                                    {text: 'Facebook Page Link Card', onclick: function() {ed.insertContent('{facebook-page-like}');}}
                                    <?php } ?>
                                ]
                            });
                    <?php 
                    if($my_playlist->num_rows() > 0 && $musik) { ?>
                      ed.addButton('playlist', {
                                type: 'menubutton',
                                text: 'Playlist',
                                icon: false,      
                                menu: [
                                    <?php foreach ($my_playlist->result()  as $row) { ?>
                                        {text: "<?php echo addslashes($row->name); ?>", onclick: function() {ed.insertContent('[custom type="playlist" id="<?php echo $row->idplaylist; ?>" ]');}},
                                    <?php }   ?>
                                    {text: 'Custom ID', onclick: function() {ed.insertContent('[custom type="playlist" id="ID_PLAYLIST" ]');}}                                    
                                    
                                ]
                            });
                     
                    <?php } ?>
                      ed.addButton('grid', {
                                type: 'menubutton',
                                text: 'Grid Bootstrap',
                                icon: false,      
                                menu: [
                                    {
                                        text: 'col-xs-*',
                                        menu: [                                        
                                            <?php for($x=1;$x<=11;$x++){ ?>
                                            {text: 'col-xs-<?php echo $x; ?>', onclick: function() {ed.insertContent('<div class="col-xs-<?php echo $x; ?>"></div>');}},
                                            <?php } ?>
                                            {text: 'col-xs-12', onclick: function() {ed.insertContent('<div class="col-xs-12"></div>');}}
                                            
                                        ]
                                    },
                                     {
                                        text: 'col-sm-*',
                                        menu: [                                        
                                            <?php for($x=1;$x<=11;$x++){ ?>
                                            {text: 'col-sm-<?php echo $x; ?>', onclick: function() {ed.insertContent('<div class="col-sm-<?php echo $x; ?>"></div>');}},
                                            <?php } ?>
                                            {text: 'col-sm-12', onclick: function() {ed.insertContent('<div class="col-sm-12"></div>');}}
                                            
                                        ]
                                    },
                                     {
                                        text: 'col-md-*',
                                        menu: [                                        
                                            <?php for($x=1;$x<=11;$x++){ ?>
                                            {text: 'col-md-<?php echo $x; ?>', onclick: function() {ed.insertContent('<div class="col-md-<?php echo $x; ?>"></div>');}},
                                            <?php } ?>
                                            {text: 'col-md-12', onclick: function() {ed.insertContent('<div class="col-md-12"></div>');}}
                                            
                                        ]
                                    },
                                     {
                                        text: 'col-lg-*',
                                        menu: [                                        
                                            <?php for($x=1;$x<=11;$x++){ ?>
                                            {text: 'col-lg-<?php echo $x; ?>', onclick: function() {ed.insertContent('<div class="col-lg-<?php echo $x; ?>"></div>');}},
                                            <?php } ?>
                                            {text: 'col-lg-12', onclick: function() {ed.insertContent('<div class="col-lg-12"></div>');}}
                                            
                                        ]
                                    },
                                    {
                                        text: 'New Block', onclick: function() {
                                            ed.dom.add(ed.getBody(), 'div', {class : 'block'}, '');
                                     
                                           
                                        }
                                    }
                                  
                                ]
                            });




                     



    


            }
        });
        </script>

    </body>
</html>