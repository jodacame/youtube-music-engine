<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Api extends MY_Controller {

	
 function __construct()
    {    
        parent::__construct();       
   		/* VALIDATE TOKEN */
		$key = $this->input->get("key",true);
		if($key == '')
			$key = $this->input->post("key",true);
		if($key != $this->config->item("apikey1"))
		{
			show_error("Invalid API key - You must be granted a valid key",403);
			exit;		
		}
    }   



	public function search()
	{
		$query = $this->input->get("query",true);
		$result = json_decode(searchLastFm($query));
		
		
		foreach ($result->results->trackmatches->track as $key => $value) {
			foreach ($value->image as $key2 => $value2)
				if($value2->text != '')
					$images = (String)$value2->text;			
			$json[] = array("name" => $value->name,'artist' => $value->artist,'image' => $images);
		}
		$this->send_api($json);
	}

	public function getTrack()
	{
		$artist = $this->input->get("artist",true);
		$track 	= $this->input->get("track",true);
		$result = json_decode(getTrackInfo($artist,$track));		
		$similar = json_decode(getSimilar($artist,$track));		
		$video = get_video_id(json_decode(searchYoutube($artist." ".$track)));
		
		
		$json['name'] = $result->track->name;
		$json['mbid'] = $result->track->mbid;
		$json['artist'] = array("name" => $result->track->artist->name,"mbid" =>$result->track->artist->mbid) ;
		foreach ($result->track->album->image as $key => $value) {
			if($key <= 3)
				$json['image'] = $value->text;
		}
		$json['video'] = $video;
		foreach ($similar->similartracks->track as $key => $value) {						
			$similar_track[$key]['name'] = $value->name;
			$similar_track[$key]['artist'] = $value->artist->name;
			foreach ($value->image as $key2 => $value2) {
				if($key <= 3)
					$similar_track[$key]['image'] = $value2->text;
			}
		}
		$json['similar'] = $similar_track;
		$this->send_api($json);
	}

	public function getVideo()
	{
		$artist = $this->input->get("artist",true);
		$track 	= $this->input->get("track",true);
		$result = get_video_id(json_decode(searchYoutube($artist." ".$track)));
		$json['v'] = $result;
		$this->send_api($json);
		
	}
	public function getLyric()
	{
		$artist = $this->input->get("artist",true);
		$track 	= $this->input->get("track",true);
		$result = json_decode(getLyric($artist,$track));		
		$json['artist'] = $result->artist;
		$json['track'] = $result->track;
		$json['lyric'] = $result->lyric;
		$this->send_api($json);		
	}
	public function getStations()
	{
		$artist = $this->input->get("artist",true);
		$track 	= $this->input->get("track",true);
		$result = getStations();		
		foreach ($result->result() as $key => $value) {
			$station = array();
			$station['id'] = $value->idtstation;
			$station['name'] = $value->title;
			$station['streaming'] = $value->m3u;
			$station['image'] = $value->cover;
			$station['description'] = $value->description;
			$station['category'] = $value->category;
			$json[] = $station;
			
		}	
		$this->send_api($json);		
	}
	
	

	public function getArtist()
	{
		$artist = $this->input->get("artist",true);
		$result = json_decode(getArtistInfo($artist));
		$topT = json_decode(getTopTracks($artist));


		
		if(!$result->error)
		{
			$json['name'] = $result->artist->name;
			
		//	$json['mbid'] = $result->artist->mbid;
			foreach ($result->artist->image as $key => $value) {
				if($key <= 3)
					$json['image'] = $value->text;
			}	
			$json['bio'] = $result->artist->bio->content;

			foreach ($topT->toptracks->track as $key => $value) {				
				$top[$key]['name'] = $value->name;
				$top[$key]['artist'] = $value->artist->name;				
			}
			$json['topTracks'] = $top;

			foreach ($result->artist->similar->artist as $key => $value) {
				$similar[$key]['name'] = $value->name;
				foreach ($value->image as $key2 => $value2) {
					if($key <= 3)
						$similar[$key]['image'] = $value2->text;
				}
				
			}

			$json['similar'] = $similar;
		}
		else
		{
			$json = $result;
		}
		$this->send_api($json);
	}

	/* USERS */
	public function createUser()
	{
		$email 		= addslashes($this->input->post("email",TRUE));
		$pwd1 		= $this->input->post("password",TRUE);		
		$nickname 	= $this->input->post("nickname",TRUE);
		$nickname  = str_replace($this->config->item("badwords"), "_REMOVED_", $nickname);
		$nickname  = str_replace(" ", "_", $nickname);
		$nickname  = trim($nickname);

		$temp = $this->admin->getTable("users",array("nickname" => $nickname));
		if($temp->num_rows() > 0)
		{
			$json["error"] 	= 1;
			$json["msg"] 	= ___("nickname_already_registered");
			$this->send_api($json);
			return false;			
		}
		else
		{
			if(strlen($nickname)<5)
			{
				$json["error"] 	= 1;
				$json["msg"] 	= ___("error_nickname_min"). " ($nickname)";
				$this->send_api($json);
				return false;							
			}			
		}

		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{

			$json["error"] 	= 1;
			$json["msg"] 	= ___("msg_email_not_valid"). " ($email)";
			$this->send_api($json);
			return false;
		}

		

		if(strlen(trim($pwd1)) <4)
		{
			$json["error"] 	= 1;
			$json["msg"] 	= ___("msg_password_min_characters");
			$this->send_api($json);
			return false;
		}

		$user 				= $this->admin->getTable("users",array('username' => $email));
		if($user->num_rows > 0)
		{			
			$json["error"] 	= 1;
			$json["msg"] 	= ___("msg_email_already_registered");
			$this->send_api($json);
			return false;
		}

		$data['password']	= sha1($pwd1);
		$data['username']	= $email;
		$temp 				= explode("@",$email);
		$data['names']		= $temp[0];		
		$data['avatar']		= base_url()."assets/images/default_avatar.jpg";
		$data['nickname']	= $nickname;
		$id 				= $this->admin->setTable("users",$data);
		$user 				= $this->admin->getTable("users",array('id' => $id, 'password' => $data['password'],'username' => $data['username']));
		if($user->num_rows > 0)
		{	
			
			$data = $user->result_array();			

			
			$json["id"] 		= $data[0]['id'];	
			$json["username"] 	= $data[0]['username'];	
			$json["nickname"] 	= $data[0]['nickname'];	
			$json["names"] 		= $data[0]['names'];	
			$json["profile"] 	= base_url()."user/".$nickname;	
			$this->send_api($json);
			return false;		
			
		}
		else
		{
			$json["error"] 	= 1;
			$json["msg"] 	= ___("msg_error_500");
			$this->send_api($json);
			return false;
		}
		$this->send_api($json);

	}

	public function validateUser()
	{
		
		$username 	= addslashes($this->input->get("email",TRUE));
		$password 	= sha1($this->input->get("password",TRUE));
		if($username && $password)
		{
			$user 		= $this->admin->getTable("users",array('username' => $username, 'password' => $password));		
			if($user->num_rows == 0)
			{
				$user 		= $this->admin->getTable("users",array('nickname' => $username, 'password' => $password));		
			}
			if($user->num_rows > 0)
			{			
				$data = $user->result_array();
				//unset($data[0]['avatar']);
				if(strlen($data[0]['avatar'])>500)
					$data[0]['avatar'] = base_url()."assets/images/default_avatar.jpg";	
				$json['user'] = $data[0];
				$json["error"] 	= 0;	
				
			}
			else
			{
				$json["error"] 	= 1;
				$json["msg"] 	= ___("error_login");
			
			}
		}	
		else
		{
			$json["error"] 	= 1;
			$json["msg"] 	= ___("error_login");
		}	
		$this->send_api($json);
	}

	public function recoveryPasswordUser()
	{
			$email 				= addslashes($this->input->post("email",TRUE));				        
	        $user 				= $this->admin->getTable("users",array('username' => $email));
			if($user->num_rows > 0)
			{
				$this->load->helper('string');				
				$data['password'] 	= random_string('alnum', 10);		
				$data['link'] 		= base_url()."music/recovery/".sha1($data['password']);		      	
		        $this->email->from($this->config->item("contact_email"),$this->config->item("title"));
		        $this->email->to($email);
		        $this->email->subject(___('email_subject')." - ".$this->config->item("title"));
		        $emailTemplate		= $this->load->view('music/email/email',$data,true);
		        $this->email->message($emailTemplate);
		        if($this->email->send())
		        {
		        	$dataBD['recovery']= sha1($data['password']);
					$this->admin->updateTable("users",$dataBD,array("username" => $email));
					$json["error"] 	= 0;
					$json["recovery"] 	= $data['link'];
					$json["newpassword"] 	= $data['password'];
					$json["msg"] 	= ___("email_check_email");					
		        }
		        else
		        {
		        	$json["error"] 	= 1;
					$json["msg"] 	= ___("msg_error_500");
		        }
				
			}
			else
			{
				$json["error"] 	= 1;
				$json["msg"] 	= ___("error_email_nofound");
			}
			$this->send_api($json);
	}

	/* END USERS */

	protected function send_api($json)
	{	
		if($this->input->get("format") == 'xml' || $this->input->post("format") == 'xml')
		{
			header('Content-Type: application/xml; charset=utf-8');
        	$this->output->set_content_type('text/xml');
			echo $this->toXml($json);	
		}
		else
		{
			$this->output->set_content_type('application/json')->set_output(json_encode($json));
		}
		
		
		
		/*$xml = new SimpleXMLElement('<root/>');
		array_walk_recursive($json, array ($xml, 'addChild'));
		echo $xml->asXML(); */
	}

	public function toXml($data, $rootNodeName = 'root', $xml=null)
	{
		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set ('zend.ze1_compatibility_mode', 0);
		}
 
		if ($xml == null)
		{
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		}
 
		// loop through the data passed in.
		foreach($data as $key => $value)
		{
			// no numeric keys in our xml please!
			if($value == '')
				$value = ' ';
			if (is_numeric($key))
			{
				// make string key...
				$key = "item". (string) $key;
			}
 
			// replace anything not alpha numeric
			$key = preg_replace('/[^a-z]/i', '', $key);
 
			// if there is another array found recrusively call this function
			if (is_array($value))
			{
				$node = $xml->addChild($key);
				// recrusive call.
				$this->toXml($value, $rootNodeName, $node);
			}
			else 
			{
				// add single node.
                                //$value = htmlentities($value);
				$xml->addChild($key,$value);
			}
 
		}
		// pass back as string. or simple xml object if you want!
		return $xml->asXML();
	}

	
}