<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Youtube Music Engine | Admin</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url(); ?>assets/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>assets/admin/css/main.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <meta name="generator" content="Youtube Music Engine <?php echo $this->config->item("yme_version"); ?>"/>

    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Youtube Music Engine</div>
            <form  method="post">
                <div class="body bg-gray">
                    <?php
                    if($error)
                    {
                        ?>
                        <div class="text-danger text-center">
                        <?php echo $error; ?>
                        </div>
                        <?php
                    }
                    ?>
                     <?php                     
                    if($msg)
                    {
                        ?>
                        <div class="text-success text-center">
                        <?php echo $msg; ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <input required type="email" name="username" class="form-control" placeholder="Email"/>
                    </div>
                    <div class="form-group">
                        <input required type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>                              
                </div>
                <div class="footer">                            
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>                                          
                    <p class="text-right"><a href="<?php echo base_url(); ?>">Go to Site</a></p>                                                       
                </div>
            </form>

           
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>