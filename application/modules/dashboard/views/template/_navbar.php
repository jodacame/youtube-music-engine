  <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                       
                   
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $this->session->userdata('username'); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">                                  
                                    <img src="<?php echo $this->session->userdata('avatar'); ?>" class="img-circle" alt="User Image" />

                                    <p>
                                       <?php echo $this->session->userdata('username'); ?>
                                        <small><?php echo $this->session->userdata('nickname'); ?></small>                                        
                                    </p>
                                </li>
                             
                          
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo base_url(); ?>user/<?php echo $this->session->userdata('nickname'); ?>" class="btn btn-default btn-flat">My Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url(); ?>dashboard/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>                                   
                                      
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                