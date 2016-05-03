<?php

class MY_Install {    
    public function __construct() {
        $CI =& get_instance();
        $CI->load->database();
        $CI->config->load("custom");        
        if($CI->config->item("use_database") == 1)
        {
            if ($CI->db->database == "#database#") {
                redirect(base_url()."install");
            } else {
                if (is_dir('install')) {
                    @unlink("install");
                    rename("install", "install_".substr(sha1(rand(0,99999999)), 0,10));
                    if (is_dir('install')) {
                        chmod("install", 755);
                        rename("install", "install_".substr(sha1(rand(0,99999999)), 0,10));
                        if (is_dir('install')) {
                            echo '<i>Plese delete or rename <b>Install</b> folder</i>';
                        }
                        exit;
                    }
                }
            }
        }
    }
    
}
