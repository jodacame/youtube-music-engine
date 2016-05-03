<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends MY_Controller {

public $redirect_url = "";
public $client_id = "";
public $client_secret = "";
 function __construct()
    {    
        parent::__construct();       
        $this->redirect_url 		= base_url()."facebook/login";         
        $this->client_id 			= $this->config->item("fb_appId"); 
        $this->client_secret 		= $this->config->item("fb_secret");     
		
    }   

	public function index()
	{
		$token 	= $this->get_stored_token(true);
		if(!$token)
		{
			$url = "https://www.facebook.com/dialog/oauth?client_id=".$this->client_id."&redirect_uri=".$this->redirect_url."&scope=public_profile,publish_actions,email,publish_actions&response_type=code";		
			redirect($url,"location");
		}
		else
		{
			$this->register($token['access_token']);
			redirect(base_url());
		}		
	}

	public function login()
	{	
		$code 	= $this->input->get("code");		

		if($code)
		{
			// First Time
			$token 	= json_decode(_curl("https://graph.facebook.com/v2.3/oauth/access_token?client_id=".$this->client_id."&redirect_uri=".$this->redirect_url."&client_secret=".$this->client_secret."&code=$code"));						
			
			

			// Extend Token Time Life
			$token 	= json_decode(_curl("https://graph.facebook.com/v2.3/oauth/access_token?grant_type=fb_exchange_token&client_id=".$this->client_id."&client_secret=".$this->client_secret."&fb_exchange_token=".$token->access_token));						
			


			if($token->access_token)
			{				
				$data['access_token'] 	= $token->access_token;
				$data['token_type'] 	= $token->token_type;
				$data['expires_in'] 	= $token->expires_in;
				$data['created'] 		= date("Y-m-d H:i:s");
				if(is_logged())
					$data['iduser'] 		= $this->session->userdata('id');
				else
				{
					$this->register($data['access_token']);
					$data['iduser'] 		= $this->session->userdata('id');
				}
				$this->save_token($data);
				redirect(base_url());
			}
			else
			{
				
				show_error("Error Facebook Login ".$token->error->message."<br><a href='".base_url()."facebook'>Try login again</a>",403);
			}
		}

		if($this->input->get("error"))
		{
			if($this->input->get("error_code") == '200')	
			{
				redirect(base_url()."facebook");
			}
			else
			{
				show_error($this->input->get("error_description")."<br><a href='".base_url()."facebook'>Try login again</a>",403);

			}
		}
	}

	protected function register($token)
	{
		$data = json_decode($this->get_profile($token));

		if($data)
		{
			$exist          = $this->admin->getTable('users',array('idfacebook' => $data->id));            
            if($exist->num_rows() == 0 && $data->email != '')
                $exist      = $this->admin->getTable('users',array('username' => $data->email));           


            $SAVE['idfacebook'] = $data->id;            
            $SAVE['names']  	= $data->name;            
            if($exist->num_rows() > 0)
            {	            
            	$temp_data = $exist->row();
            
	            if($temp_data->nickname == $data->id)
	        	{
	        		$SAVE['nickname']  = str_ireplace(" ", "",$data->name);
	        		if($SAVE['nickname'] == '')
	        		{
	        			$nickname           = explode("@", $data->email);
	                    $SAVE['nickname']   = str_ireplace(".", "_", $nickname[0]);   
	        		}
	        		if($SAVE['nickname'] == '')
	        			$SAVE['nickname'] == $data->id;
	        	}
	        	/*
	        	if($data->email != '')
	            	$SAVE['username']  = $data->email;     
	            else
	                $SAVE['username']  = $data->id.'@facebook.com';   */

	            $SAVE['avatar']     = 'https://graph.facebook.com/'.$data->id.'/picture?type=large';

	            
	            if($data->email == '') 
	            	$this->admin->updateTable('users',$SAVE,array('idfacebook' => $data->id));                                  
	            else
	            	$this->admin->updateTable('users',$SAVE,array('username' => $data->email));                                  
	                
	            if($data->email)
	            	$exist          	= $this->admin->getTable('users',array('username' => $data->email));                
	            else
	            	$exist          	= $this->admin->getTable('users',array('idfacebook' => $data->id));                
	            $user 				= $exist->row_array();                                       
	            $user['facebook'] 	= '1';                                                
	            if($data->id)
	            	$this->session->set_userdata($user);                
	            //redirect(base_url());
	        }
	        else
	        {
	        	if($data->email== '')
                {
                    $data->email =     $data->id.'@facebook.com';
                }                     

                if($data->email != '')
                {
                	$SAVE['username']  = $data->email;    
                    $SAVE['password']   = sha1(rand(99999,999999999).date('Y-m-d H:i:s'));
                    $SAVE['avatar']     = 'https://graph.facebook.com/'.$data->id.'/picture?type=large';
                   	$SAVE['nickname']  = str_ireplace(" ", "",$data->name);
                   	if($SAVE['nickname'] == '')
                   	{
                   		$nickname           = explode("@", $data->email);
                    	$SAVE['nickname']   = str_ireplace(".", "_", $nickname[0]);   
                   	}
                    	
                    $checknick              = $this->admin->getTable('users',array('nickname' =>  $SAVE['nickname']));
                    if($checknick->num_rows() > 0)
                        $SAVE['nickname'] = $SAVE['nickname']."_".rand(1,9999);

                    $this->admin->setTable('users',$SAVE);                                  
                    
                    $exist              = $this->admin->getTable('users',array('idfacebook' => $data->id));
                    $data               = $exist->row_array();                                       
                    $data['facebook']= '1';
                    if($data->id)
                    	$this->session->set_userdata($data);   
                }
                //redirect(base_url());

	        }


		}
			

			
	}

	protected function get_profile($token)
	{
		//return _curl("https://graph.facebook.com/v2.3/me?access_token=".$token);
		$appsecret_proof= hash_hmac('sha256', $token, $this->client_secret); 
		return _curl("https://graph.facebook.com/v2.3/me?access_token=".$token."&appsecret_proof=".$appsecret_proof);
	}

	protected function save_token($data)
	{
	
		if($data['access_token'] == '')
			return false;
		$exists = $this->get_stored_token();		
		if(!$exists)
		{
			return false;
		}
		if($exists->num_rows() > 0)
		{

			$this->admin->updateTable("token_facebook",$data,array("iduser" => $this->session->userdata('id')));
		}
		else
		{
			
			$this->admin->setTable("token_facebook",$data);
		}		

	}

	protected function get_stored_token($array = false)
	{
		if(!is_logged())
			return false;
		if($array)
		{
			$token_obj 	= $this->admin->getTable("token_facebook",array("iduser" => $this->session->userdata('id')));
			$token 		= false;
			if($token_obj->num_rows() > 0)
				$token = $token_obj->row_array();
			if(!$token['access_token'])
				return false;
			return $token;
		}
		return $this->admin->getTable("token_facebook",array("iduser" => $this->session->userdata('id')));
	}


	

	

	



}