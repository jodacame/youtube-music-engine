<?php
function _curl($url,$post = false,$headers = false,$gzip = false) {	
	$CI 	=& get_instance();	
	$ch = curl_init(); 
	//curl_setopt($ch, CURLOPT_HEADER, 0);	
	if(strpos($url, base_url()) === FALSE)
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	//curl_setopt($ch,CURLOPT_USERAGENT,"Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,15);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);    
    curl_setopt($ch,CURLOPT_REFERER,base_url());    
    if(strtolower(parse_url($url, PHP_URL_SCHEME)) == 'https')
    {
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,1);
    }
    if($CI->config->item("proxy") != '')
    {    	
    	curl_setopt($ch, CURLOPT_PROXY, $CI->config->item("proxy"));
    }
    if($gzip)
		curl_setopt($ch,CURLOPT_ENCODING , "gzip");
    if($post)
    {
    	foreach($post as $key=>$value) 
    	{ 
    		$fields_string .= $key.'='.$value.'&'; 
    	}
		rtrim($fields_string, '&');
		curl_setopt($ch,CURLOPT_POST, count($post));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    }
    if($headers)
    {
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
	curl_setopt($ch, CURLOPT_URL, $url); 
	$data = curl_exec($ch);
	curl_close($ch); 
	return $data;
}



function prepare_data($json,$unique = false)
{	
	$CI 	=& get_instance();
	
	if($CI->config->item("use_proxy_images") == '1')
	{

		
		//$json = str_ireplace('"text":"http:\/\/', "MMMMMMMMMMM", $json);
		$json = str_ireplace(base_url()."music/preview?img=",'', $json);
		$json = str_ireplace('"text":"http://', '"text":"MMMMMMMMMMM', $json);
		$json = str_ireplace('MMMMMMMMMMM',  base_url()."music/preview?img=http://", $json);
		$json = str_ireplace("http:\/\/",  base_url()."music/preview?img=http://", $json);
		$json = str_ireplace('"label":"http:',  '"label":"'.base_url()."music/preview?img=http:", $json);
		$json = str_ireplace('170x170',  '200x200', $json);

		

	}
	return $json;

}

function print_p($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function searchLastFm($query)
{
	
	$CI 	=& get_instance();		




	$query	= econde($query);
	switch ($CI->config->item("search_engine")) {
		case 'lastfm':
			$url 	= "http://ws.audioscrobbler.com/2.0/?method=track.search&track=$query&api_key=".$CI->config->item("lastfm")."&format=json&limit=".intval($CI->config->item("items_search"))."&autocorrect=1";					
			break;		
		case 'spotify':
			$url 	= base_url()."spotify/search?query=$query&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
			break;		
		case 'deezer':
			$url 	= base_url()."deezer/search?query=$query&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
			break;
		case 'musixmatch':
			$url 	= base_url()."musixmatch/search?query=$query&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
			break;
		case 'itunes':
			$url 	= base_url()."itunes/search?query=$query&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
			break;	
		case 'spotify':
			$url 	= base_url()."spotify/search?query=$query&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
			break;			
		default:
			$url 	= "http://ws.audioscrobbler.com/2.0/?method=track.search&track=$query&api_key=".$CI->config->item("lastfm")."&format=json&limit=".intval($CI->config->item("items_search"))."&autocorrect=1";					
			break;
	}	
	
	$json 	= _curl($url);	
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
	return prepare_data($json);
}

function loadPlayListsArtist($artist)
{
	$CI 	=& get_instance();	
	
	$localartist 	= json_decode(getArtistInfo(urldecode($artist)));
	
	if($localartist->artist->syncpl != '1')
	{
		$artist = urlencode($artist);
		$url 	= base_url()."deezer/getPlaylistsArtist?query=$artist&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");		

		
		$artist = urldecode($artist);
		$json 	= json_decode(_curl($url));		

		
		foreach ($json as $key => $value) {
			$data = array();
			$data['name'] = $value->name;
			$data['json'] = ($value->json);
			$data['public'] = $value->public;
			$data['external_id'] = $value->external_id;
			$data['type'] = $value->type;
			$data['source'] = 'deezer.com';
			$data['description'] = $value->description;
			$data['cover'] = $value->cover;
			
			$exist = $CI->admin->getTable("playlist",array("external_id" => $value->external_id));
			if($exist->num_rows() == 0)
				$CI->admin->setTableIgnore("playlist",$data);
			
		}
		$CI->admin->updateTable("artist",array("syncpl" => '1'),array("artist" => $artist));
		
	}		
	$t= search_playlist($artist,true);
	//echo $CI->db->last_query();
	

	
	return $t;
	

}
function searchArtist($query)
{
	$CI 	=& get_instance();	
	$temp 	= explode("-", $query);
	$query  = $temp[0];
	$query	= econde($query);
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=$query&api_key=".$CI->config->item("lastfm")."&format=json";						
	$json 	= _curl($url);
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
	return $json ;
}
function getCountryCode()
{
    $CI     =& get_instance();  
    if($CI->session->userdata('countryCode'))
        return $CI->session->userdata('countryCode');
    $ip         = $CI->input->ip_address();
    $url = "http://ip-api.com/json/$ip";
    $data = json_decode(_curl($url));
    $code = $data->countryCode;
    if($code != '')
        $CI->session->set_userdata('countryCode', $code);
    if($code == '')
        $code = 'us';
    return $code;

}

function searchYoutube($artist,$track)
{	
	$CI 	=& get_instance();	
	if($CI->config->item("custom_video_youtube") == 1)
	{
		
		$customVideo = $CI->admin->getTable('tracks',array('artist' =>urldecode($artist),'track' => urldecode($track)));			
		
		if($customVideo->num_rows() > 0)
		{		
			$customVideo = $customVideo->row_array();			
			
			if($customVideo['youtube'])
			{
				$jtmep['youtube'] = $customVideo['youtube'];
				$jtmep['custom'] = 1;
				return json_encode($jtmep);
			}
		}
		else
		{
			$ttt = getTrackInfo($artist,$track,false);
			$art = json_decode($ttt);		
		
			if(!$temp->error)	
			{
				$genre = $art->track->toptags->tag[0]->name;
				if($genre == '')
				{
					$genre = 'unknown';
				}
				$CI->admin->setTableIgnore('tracks',array('genre'=> $genre,'mbid'=> $art->track->mbid,'artist' =>urldecode($artist),'track' => urldecode($track),"updated" => date("Y-m-d H:i:s"),"json" => (($ttt))));												
				
			}
		}	
	}
	
	//$query 	= urlencode($query);	
	$artist =urldecode($artist);
	
	$track =urldecode($track);

	$query	= urlencode($artist." ".$track);

	
	$url = "https://www.googleapis.com/youtube/v3/search?videoEmbeddable=true&part=snippet&q=$query&type=video&maxResults=5&key=".$CI->config->item("youtube_api_key");

	if($CI->config->item("filter_youtube_by_region") =='1' || 1==1)			
	{		
		$url = "https://www.googleapis.com/youtube/v3/search?videoEmbeddable=true&part=snippet&regionCode=".getCountryCode()."&q=$query&type=video&maxResults=1&key=".$CI->config->item("youtube_api_key");
	}


	
	$json 	= _curl($url);	
	
	//print_p($json);
	$temp = json_decode($json);
	//print_p($temp);
	if($temp->error->errors)
	{
		$jtmep['error'] = true;
		$jtmep['message'] = $temp->error->errors[0]->message;
		return json_encode($jtmep);
		//show_error($temp->error->errors[0]->message,403);
		//exit;
	}
	if($CI->config->item("custom_video_youtube") == 1)
	{
		if($CI->config->item("youtube_save_video_id") =='1' || 1==1)
		{		
			$CI->admin->updateTable('tracks',array('youtube' => get_video_id($temp)),array('artist' =>urldecode($artist),'track' => urldecode($track)));
		}
	}

	return $json ;
}

function get_video_id($data)
{
	$CI 	=& get_instance();	
	
	if($data->custom)
	{		
		return $data->youtube;
	}
	return $data->items[0]->id->videoId; 	
	
	
}
function getSimilar($artist,$track)
{
	$CI 	=& get_instance();
	$artist	= ($artist);
	$track	= ($track);
	$track	= econde($track);	
	$artist	= econde($artist);	

	$url 	= "http://ws.audioscrobbler.com/2.0/?method=track.getsimilar&artist=$artist&track=$track&api_key=".$CI->config->item("lastfm")."&format=json&limit=20&autocorrect=1";				
	$json 	= _curl($url);
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
	return $json ;
}


function getTrackInfo($artist,$track,$prepare=true)
{
	$CI 	=& get_instance();
	$artist	= ($artist);
	$track	= ($track);
	$track	= econde($track);	
	$artist	= econde($artist);	
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=track.getInfo&api_key=".$CI->config->item("lastfm")."&artist=$artist&track=$track&format=json";				
	

	
	//$CI->db->query("UPDATE tracks set json = '' WHERE updated < DATE_SUB(NOW(), INTERVAL 30 DAY)");		 // Clear Cache


	$exist 	= $CI->db->query("SELECT * FROM  tracks WHERE track = '".prepare_sql(decode($track))."' and artist = '".prepare_sql(decode($artist))."' and json != '' LIMIT 1");	
	if($exist->num_rows() > 0)
	{	

		$data 	= $exist->row();

		$json  	= $data->json;	
		$json  	= str_ireplace('{"track":{','{"track":{"video":"'.$data->youtube.'",', $json);	

		
	
	
		
	/*	$json 	= str_ireplace("/", "\/",$json);
		$json 	= str_ireplace('="', '=\\"',$json);
		$json 	= str_ireplace('">', '\\">',$json);
		$json 	= str_ireplace('\\n"', '',$json);
		$json 	= str_ireplace(array("\r", "\n"), "", $json);*/
				
		

	}
	else
	{				

		ping_google();
		$json 	= _curl($url);		
		//$CI->db->query("INSERT INTO tracks (artist,track,updated,json) VALUES ('".prepare_sql(decode($artist))."','".prepare_sql(decode($track))."','".date("Y-m-d H:i:s")."','".addslashes(prepare_sql($json))."')  ON DUPLICATE KEY UPDATE json='".addslashes(prepare_sql($json))."',updated = '".date("Y-m-d H:i:s")."'");			
	}

	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
    if($prepare)
		return prepare_data($json,true) ;
	return $json;
}

function getArtistInfo($artist)
{	
	
	ini_set('memory_limit','256M');

	$CI 	=& get_instance();	

	$artist 	= urldecode($artist);

	//$artist		= econde($artist);	
	switch ($CI->config->item("data_engine")) 
	{
		case 'lastfm':
			$url 	= "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=$artist&api_key=".$CI->config->item("lastfm")."&autocorrect=1&format=json&lang=".$CI->config->item("biography_lang");			
		break;
		case 'deezer':
			$url 	= base_url()."deezer/artist?query=$artist&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
		break;
		default:
			$url 	= "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist=$artist&api_key=".$CI->config->item("lastfm")."&autocorrect=1&format=json&lang=".$CI->config->item("biography_lang");			
		break;
	}
	
	if($CI->config->item("remote_artist") == 1)
	{
		
		
			
		if($json = get_local_artist(urldecode($artist)) )		
		{
			

		}	
		else
		{
		
			$json 	= _curl($url);			
			$jsonT 	= $json;
			$jsonT 	= str_ireplace("#text","text",$jsonT);
			$jsonT 	= str_ireplace(":totalResults","",$jsonT);
			$jsonT 	= json_decode($jsonT);
			
			if(!$jsonT->error && $CI->config->item("local_artist") == '1')
			{
				$DATA['artist'] 	= ($jsonT->artist->name);
				$DATA['mbid'] 		= urldecode($jsonT->artist->mbid);
				$DATA['lang'] 		= $CI->config->item("biography_lang");
				$DATA['bio'] 		= ltrim(strip_tags($jsonT->artist->bio->content));

				foreach ($jsonT->artist->tags->tag as $key => $value) {
					if($DATA['tags'] == '')
						$DATA['tags'] = $value->name;
				}
				for($x=0;$x<=2;$x++)
				{
					if($jsonT->artist->image[$x]->text)
						$DATA['cover'] 		= $jsonT->artist->image[$x]->text;
				}    			
				if($DATA['bio'])
					$CI->admin->setTableIgnore('artist',$DATA);    			
	    	}	
		}
	}
	else
	{
		$json = get_local_artist(urldecode($artist));
	}
	$json 	= str_ireplace("#text","text",$json);
	$json 	= str_ireplace(":totalResults","",$json);



	if(!$json)
		show_404();	
	return prepare_data($json,true);
}

function get_local_artist($artist)
{
	$json = false;
	$CI 	=& get_instance();	

	if($CI->config->item("local_artist") == '1')
	{
		

		$data = $CI->db->get_where('artist',array("lang" => $CI->config->item("biography_lang"),"artist" => ($artist)));

		if($data->num_rows() > 0)
			$cached = true;
	}
	if($cached && $CI->config->item("local_artist") == '1' )
	{	

		
		$row 								= $data->row();		
		$jsonT['artist']['syncpl'] 			= $row->syncpl;
		$jsonT['artist']['name'] 			= $row->artist;
		$jsonT['artist']['mbid'] 			= $row->mbid;
		$row->cover 						= str_ireplace(base_url()."music/preview?img=", "", $row->cover);

		$jsonT['artist']['image'][] 		= array("text" => $row->cover);
		$jsonT['artist']['image'][] 		= array("text" => $row->cover);
		$jsonT['artist']['image'][] 		= array("text" => $row->cover);
		$jsonT['artist']['image'][] 		= array("text" => $row->cover);
		$jsonT['artist']['image'][] 		= array("text" => $row->cover);
		$jsonT['artist']['bio']['content'] 	= str_ireplace('"', "",stripslashes($row->bio)) . "<!-- Cached -->";
		$tags 								= $row->tags;			
		$jsonT['artist']['tags']['tag'][] 	= 	array("name" => $tags);

		
		if($CI->config->item("show_similar_artist") == '1')
		{
			$data = $CI->db->get_where('artist',array("tags" => $tags),10);
			if($data->num_rows() > 0)
			{
				foreach ($data->result() as $key => $value) 
				{
					
					$jsonT_similar = array();
					$row->cover 						= str_ireplace(base_url()."music/preview?img=", "", $row->cover);
					$jsonT_similar['name'] = $value->artist;
					$jsonT_similar['image'][] = array("text" => $value->cover);
					$jsonT_similar['image'][] = array("text" => $value->cover);
					$jsonT_similar['image'][] = array("text" => $value->cover);
					$jsonT_similar['image'][] = array("text" => $value->cover);
					if($value->artist != $artist)
						$jsonT['artist']['similar']['artist'][] = $jsonT_similar;
				}
			}			
		}
		$jsonT_similar = null;
		$json 			= $jsonT;	

		$json 			= 	(json_encode(($json)));				

		
	}
	return $json;	
}
function loadPlaylistArtist($artist)
{
	$CI 	=& get_instance();	
	$artist	= econde($artist);	
	//$url ="http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=$artist&api_key=".$CI->config->item("lastfm")."&limit=200&format=json";
	switch ($CI->config->item("data_engine")) 
	{
		case 'lastfm':
			$url 	= "http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=$artist&api_key=".$CI->config->item("lastfm")."&autocorrect=1&format=json";	
		break;
		case 'deezer':
			$url 	= base_url()."deezer/gettoptracks?query=$artist&limit=100&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
		break;
		default:
			$url 	= "http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=$artist&api_key=".$CI->config->item("lastfm")."&autocorrect=1&format=json";	
		break;
	}


	
	// Cache
	$CI->load->helper('file');

	$folder = strtoupper(substr(sha1($artist), 0,2));
	if(!file_exists("cache/playlist"))				
		mkdir("cache/playlist");
	if(!file_exists("cache/playlist/$folder"))				
		mkdir("cache/playlist/$folder");

	$file_cache = 'cache/playlist/'.$folder.'/artist_'.sha1($artist)."_playlist.cache";
	if($CI->config->item("use_cache") == "1" )
		$cache 	= read_file($file_cache);
	if(strlen($cache)<100)
		$cache = false;
	if($cache)
	{	
		$json = $cache;
		/*if (time()-filemtime($file_cache) > 24 * 3600) {		  
			@unlink($file_cache);
		}*/
	}
	else
	{		
		$json 	= _curl($url);			
		if($CI->config->item("use_cache") == "1")
			write_file($file_cache, $json);
	}	
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
	return $json ;

}

function getAddons()
{
	return false;
	$CI 	=& get_instance();		
	//$url 	= "http://api.andthemusic.net/music/addons";			

	// Cache
	$CI->load->helper('file');
	$file_cache = "cache/addons.cache";
	
	$cache 	= read_file($file_cache);
	if(strlen($cache)<800)
		$cache = false;
	if($cache)
	{	
		$json = $cache;
		if (time()-filemtime($file_cache) > 24 * 3600) {
		  // file older than 24 hours
			@unlink($file_cache);
		}
	}
	else
	{		
		$json 	= _curl($url);					
		write_file($file_cache, $json);
	}	
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
	return $json ;
}

function getAlbums($artist)
{
	$CI 	=& get_instance();		
	//$artist	= urlencode($artist);	
	
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=artist.gettopalbums&artist=$artist&api_key=".$CI->config->item("lastfm")."&format=json";	
	
	$json 	= _curl($url);
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
    
	return prepare_data($json);
}
function getEvents($artist)
{
	$CI 	=& get_instance();	
	$artist	= econde($artist);	
	
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=artist.getevents&artist=$artist&api_key=".$CI->config->item("lastfm")."&format=json&limit=100";	
	$json 	= _curl($url);
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
    $json 	= str_ireplace("geo:point","geo",$json);
    $json 	= str_ireplace("geo:lat","lat",$json);
    $json 	= str_ireplace("geo:long","long",$json);
	return $json ;
}
function getTracksAlbums($album,$artist)
{
	$CI 	=& get_instance();
	$album	= urlencode($album);	
	$artist	= urlencode($artist);	
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=".$CI->config->item("lastfm")."&artist=$artist&album=$album&format=json&autocorrect=1";				

	$json 	= _curl($url);
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
	return $json ;
}
function getTags()
{
	$CI 	=& get_instance();	
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=chart.gettoptags&api_key=".$CI->config->item("lastfm")."&format=json&limit=200";					
	//$url 	= "http://ws.audioscrobbler.com/2.0/?method=tag.getTopTags&api_key=".$CI->config->item("lastfm")."&format=json";				
	$json 	= _curl($url);	
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
	return $json ;
}

function getTopTracks($artist = false)
{
	$CI 	=& get_instance();	
	$artist	= urldecode($artist);	
	


	if($artist)
	{
		$folder = strtoupper(substr(sha1($artist), 0,2));

		if(!file_exists("cache/tracks"))				
			mkdir("cache/tracks");
		if(!file_exists("cache/tracks/$folder"))				
			mkdir("cache/tracks/$folder");

		switch ($CI->config->item("data_engine")) 
		{
			case 'lastfm':
				$url 	= "http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=$artist&api_key=".$CI->config->item("lastfm")."&autocorrect=1&format=json";	
			break;
			case 'deezer':
				$url 	= base_url()."deezer/gettoptracks?query=$artist&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
			break;
			default:
				$url 	= "http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=$artist&api_key=".$CI->config->item("lastfm")."&autocorrect=1&format=json";	
			break;
		}

		
		$file_cache = 'cache/tracks/'.$folder.'/tracks_'.sha1($artist).".cache";
	}
	else
	{		
		$url 	= "http://ws.audioscrobbler.com/2.0/?method=chart.gettoptracks&api_key=".$CI->config->item("lastfm")."&format=json";	
		$file_cache = 'cache/tracks_'.sha1("toptracks").".cache";
		if($CI->config->item("auto_country") == "1")
		{

			$ip = getIP($CI->input->ip_address());			
			
			$url 	= "http://ws.audioscrobbler.com/2.0/?method=geo.gettoptracks&country=".urlencode(getCountryCode())."&api_key=".$CI->config->item("lastfm")."&format=json";					
			$file_cache = 'cache/tracks_'.sha1(getCountryCode()).".cache";
			
			
		}
	}		

	
	// Cache
	$CI->load->helper('file');
	if($CI->config->item("use_cache") == "1")
		$cache 	= read_file($file_cache);
	if(strlen($cache)<100 )
		$cache = false;
	if($cache)
	{	
		$json = $cache;
		/*if (time()-filemtime($file_cache) > 24 * 3600) {		  
			@unlink($file_cache);
		}*/
	}
	else
	{		
		$json 	= _curl($url);	
		if($CI->config->item("use_cache") == "1")
			write_file($file_cache, $json);
	}	
		
	if(!$artist)
		$json 	= str_ireplace("toptracks","tracks",$json);
	else
		$json 	= prepare_data($json,true) ;
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);

	return prepare_data($json) ;
}
function getTopTags($tag,$limit=100)
{
	$CI 	=& get_instance();
	$tag	= econde($tag);		
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=tag.gettoptracks&tag=$tag&api_key=".$CI->config->item("lastfm")."&format=json&limit=$limit";		
	

	
	// Cache
	$CI->load->helper('file');
	$file_cache = 'cache/tag_'.sha1($tag).".cache";
	if($CI->config->item("use_cache") == "1")
		$cache 	= read_file($file_cache);
	if(strlen($cache)<100)
		$cache = false;
	if($cache)
	{	
		$json = $cache;
		/*if (time()-filemtime($file_cache) > 24 * 3600) {		  
			@unlink($file_cache);
		}*/
	}
	else
	{		
		$json 	= _curl($url);	
		if($CI->config->item("use_cache") == "1")
			write_file($file_cache, $json);
	}	
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
    
	$t= prepare_data($json);
	return $t;
}
function getTopArtist()
{
	
	$CI 	=& get_instance();
	$artist	= urlencode($artist);
	$url 	= "http://ws.audioscrobbler.com/2.0/?method=chart.gettopartists&api_key=".$CI->config->item("lastfm")."&format=json";	
	$file_cache = 'cache/top_'.sha1("topartist").".cache";
	if($CI->config->item("auto_country") == "1")
	{
		$ip = getIP($CI->input->ip_address());			
		if(is_object($ip))
		{
			if($ip->geoplugin_countryName != '')
			{				
				$url 		= "http://ws.audioscrobbler.com/2.0/?method=geo.gettopartists&country=".urlencode($ip->geoplugin_countryName)."&api_key=".$CI->config->item("lastfm")."&format=json";					
				$file_cache = 'cache/top_'.sha1($ip->geoplugin_countryName).".cache";
				
			}	
		}		
	}	

	// Cache
	$CI->load->helper('file');
	if($CI->config->item("use_cache") == "1")
		$cache 	= read_file($file_cache);
	if(strlen($cache)<100)
		$cache = false;
	if($cache)
	{	
		$json = $cache;
		/*if (time()-filemtime($file_cache) > 24 * 3600) {		  
			@unlink($file_cache);
		}*/
	}
	else
	{		
		
		$json 	= _curl($url);	
		if($CI->config->item("use_cache") == "1")
			write_file($file_cache, $json);
	}		
	$json 	= str_ireplace("topartists","artists",$json);
	$json 	= str_ireplace("#text","text",$json);
    $json 	= str_ireplace(":totalResults","",$json);
	return prepare_data($json);
}

function getLyric($artist,$track)
{	
	$CI 	=& get_instance();

	$artist = decode($artist);
	$track = decode($track);

	if($CI->config->item("local_lyrics") == 1)
	{		
		$localLyric = $CI->admin->getTable('lyrics',array('artist' => $artist,'track' => $track));		

		if($localLyric->num_rows() > 0)
		{		
			$temp = $localLyric->row_array();			

			return json_encode($temp);
		}
		else
		{
			if($CI->config->item("remote_lyrics_service") == '1')
			{

				$track	= econde($track);	
				$artist	= econde($artist);	

				if($CI->config->item("lyrics_engine") == 'yme')					
					$url 	= "http://api.andthemusic.net/music/getLyric/".$CI->config->item("purchase_code")."?artist=$artist&track=$track";					
				if($CI->config->item("lyrics_engine") == 'musixmatch')					
					$url 	= base_url()."musixmatch/lyrics?artist=$artist&track=$track&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
				if($CI->config->item("lyrics_engine") == 'chartlyrics')					
					$url 	= base_url()."chartlyrics/lyrics?artist=$artist&track=$track&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
				$html 	= _curl($url);			
	    		$temp 	= json_decode($html);

	    		if( strpos($temp->lyric, 'alert') === false)
	    		{	    			
	    			$CI->admin->setTableIgnore('lyrics',array("artist" => ($temp->artist),"track" => ($temp->track),"lyric" => $temp->lyric));
	    			
	    		}
	    		else
	    		{
	    			if($CI->config->item("lyrics_engine") == 'yme')	
	    			{
	    				if(strpos($temp->lyric, 'script') === false)
	    					$CI->admin->setTableIgnore('lyrics',array("artist" => ($temp->artist),"track" => ($temp->track),"lyric" => "No Found"));	
	    			}
	    		}
	    		return $html;			
			}
			
		}

	}
	else
	{

		if($CI->config->item("remote_lyrics_service") == '1')
		{
			$track	= econde($track);	
			$artist	= econde($artist);		
			if($CI->config->item("lyrics_engine") == 'yme')									
				$url 	= "http://api.andthemusic.net/music/getLyric/".$CI->config->item("purchase_code")."?artist=$artist&track=$track";					
			if($CI->config->item("lyrics_engine") == 'musixmatch')					
				$url 	= base_url()."musixmatch/lyrics?artist=$artist&track=$track&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
			if($CI->config->item("lyrics_engine") == 'chartlyrics')					
				$url 	= base_url()."chartlyrics/lyrics?artist=$artist&track=$track&".$CI->security->get_csrf_token_name()."=".$CI->security->get_csrf_hash()."&key=".$CI->config->item("encryption_key");
			$html 	= _curl($url);			
	    	return $html;	
	    }
	}
	return false;
	
}

function getIP($ip)
{
	$json = json_decode(_curl("http://www.geoplugin.net/json.gp?ip=$ip"));
	return $json;
}

function getCountry()
{
	$CI 	=& get_instance();
	if($CI->config->item("auto_country") == "1")
	{		
		$ip = getIP($CI->input->ip_address());	

		if(is_object($ip))
		{

			if($ip->geoplugin_countryName != '')
			{		

				return " - ".$ip->geoplugin_countryName;
			}	
			return "";
		}	
		return "";
	}
	return "";

}

function is_writable_cache()
{
	return is_writable('cache/');
}

function ___($key)
{
	$CI 	=& get_instance();
	if($CI->config->item("use_db_language") == '1')
		$text 	= $CI->get_label($key);
	else
		$text 	= $CI->lang->line($key);
	
	if($text == '')
		$text = $key;
	return $text;
}
function econde($text)
{
	return urlencode($text);
	$text	= strip_tags($text);
	$text	= str_ireplace("/","-", $text);			
	$text	= str_ireplace(" ","+", $text);			
	$text	= str_ireplace("(","-", $text);
	$text	= str_ireplace(")","-", $text);
	$text	= str_ireplace("&#41;","", $text);
	$text	= str_ireplace("&#40;","", $text);
	$text	= str_ireplace("'","", $text);
	//$text	= str_ireplace("-","%20", ($text));	
	$text	= str_ireplace("-","+", ($text));	
	$text	= str_ireplace("%252c",",", $text);		
	$text	= str_ireplace("%2c",",", $text);		
	$text	= str_ireplace("%2527","'", $text);		
	$text	= str_ireplace("%26","and", $text);
	$text	= str_ireplace("&","and", $text);
	
	
	return $text;
	
}

function is_logged()
{
	$CI 	=& get_instance();
	if(intval($CI->session->userdata('id'))>0)
		return true;
	return false;
}
function encode($text)
{
	return econde($text);
}

function encode2($text)
{
	$text	= urldecode($text);	
	$text	= strip_tags($text);	
	$text	= str_ireplace('"',"", ($text));	
	$text	= str_ireplace(" ","-", $text);			
	$text	= str_ireplace(" ","-", $text);			
	$text	= str_ireplace(" ","-", $text);			
	$text	= str_ireplace("<","", $text);			
	$text	= str_ireplace(">","", $text);			
	$text	= str_ireplace("--","-", $text);			
	$text	= str_ireplace("--","-", $text);			
	$text	= str_ireplace("--","-", $text);			
	$text	= str_ireplace("%252c",",", $text);		
	$text	= str_ireplace("%2c",",", $text);		
	$text	= str_ireplace("%2527","'", $text);		
	$text	= str_ireplace("%26","and", $text);
	$text	= str_ireplace("&","and", $text);
	$text	= str_ireplace(":","", $text);
	$text	= str_ireplace("&#41;","", $text);
	$text	= str_ireplace("&#40;","", $text);
	return $text;
}
function decode($text)
{
	/*$text	= str_ireplace("\\'","", $text);	
	$text	= str_ireplace("\'","", $text);	*/
	$text	= str_ireplace(":"," ", $text);	
	$text	= str_ireplace("+"," ", $text);	
	$text	= str_ireplace("-"," ", $text);	
	$text	= str_ireplace("/"," - ", $text);	
	$text	= str_ireplace("%20"," ", $text);	
	$text	= urldecode($text);	
	return $text;
}

function prepare_sql($text)
{
	$text	= str_ireplace("'","''", $text);		
	return $text;

}

function clean($string) {

   $string = str_replace('&', 'and', $string); 
   $string = str_replace(' ', '-', $string); 
   //$string =  preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
   //$string = urlencode($string);
   $string = preg_replace('/[^أ-يA-Za-z0-9- ]/ui', '', $string);
   $string = str_replace('-', ' ', $string); 
   return $string;
}

function secure($text)
{
	$text	= str_ireplace("'","", $text);	
	$text	= str_ireplace("+","", $text);	
	$text	= str_ireplace("-","", $text);	
	$text	= str_ireplace("=","", $text);	
	$text	= str_ireplace("/","-", $text);	
	$text	= str_ireplace("%20","", $text);	
	$text	= str_ireplace("%","", $text);	
	$text	= urldecode($text);	
	$text	= strip_tags($text);	
	return $text;

}

function clean_quotes($text)
{
	$text	= str_ireplace('"',"", $text);		
	$text	= strip_tags($text);	
	return $text;

}

function validateEMAIL($EMAIL) {
   $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	return preg_match($regex, $email); 

}

function getTemplate($view)
{
		$CI 	=& get_instance();
		$template = 'ajax/'.$view;				
		$theme = $CI->config->item("theme");
		$skin = $CI->config->item("skin_color");
		if($CI->agent->is_mobile())
			$theme = $CI->config->item("theme_mobile");		
		if(file_exists(APPPATH."modules/music/views/ajax/templates/".$theme."/".$view.EXT))
		{
			$template = "ajax/templates/".$theme."/".$view;
			if(file_exists(APPPATH."modules/music/views/ajax/templates/".$theme."/".$view."_".$skin.EXT))
			{
				$template = "ajax/templates/".$theme."/".$view."_".$skin;
			}			
		}

		if($CI->input->is_ajax_request()) {
			$common = $CI->load->view("templates/common/_common",false,true);
			$CI->output->append_output($common);
		}
		return $template;
		
}
function ago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference ".___($periods[$j]);
}
function more($str,$len = 30)
{
	if(strlen($str)>$len)
	{
		$str = substr($str,0,$len)."...";
	}
	if($str == '')
		$str= '&nbsp;';
	return $str;
}

function base64_to_jpeg($base64_string, $output_file) {
	if(file_exists($output_file))
		unlink($output_file);
    $ifp = fopen($output_file, "wb"); 

    $data = explode(',', $base64_string);

    fwrite($ifp, base64_decode($data[1])); 
    fclose($ifp); 

    return $output_file; 
}
function getNewReleases()
{
	$CI 	=& get_instance();
	$url 	= "https://itunes.apple.com/WebObjects/MZStore.woa/wpa/MRSS/newreleases/sf=143441/limit=".intval($CI->config->item("items_search"))."/rss.xml";
	$html 	= _curl($url);			
	$html 	= str_ireplace("itms:", "", $html);
    return $html;
}
function getTopSongsItunes()
{
	$CI 	=& get_instance();
	$url 	= "https://itunes.apple.com/".$CI->config->item("itunes_country")."/rss/topsongs/limit=".intval($CI->config->item("items_search"))."/json";
	$html 	= _curl($url);			
	$html 	= str_ireplace("itms:", "", $html);
	$html 	= str_ireplace("im:", "", $html);
    return prepare_data($html);
}

function getGoogleLinks2($url)
{
   /* $url  = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=site:$url&filter=0";
    $str  = json_decode(_curl($url));  
    return intval($str->responseData->cursor->estimatedResultCount);*/
		$CI 	=& get_instance();
    if($CI->session->userdata('GoogleLinksDate') == date('Ymd')){
    	return $CI->session->userdata('GoogleLinks');
    }
 	$api_url = "http://www.google.ca/search?q=site%3A".$url;
    $content = _curl($api_url); 
        if (empty($content)) 
        {
            return intval(0);
        }
        if (!strpos($content, 'results')) return intval(0);
        $match_expression = '/About (.*?) results/sim'; 
        preg_match($match_expression,$content,$matches); 
        if (empty($matches)) return intval(0);
        {
        	$CI->session->set_userdata("GoogleLinks", intval(str_replace(",", "", $matches[1])));
        	$CI->session->set_userdata("GoogleLinksDate", date("Ymd"));
        	return intval(str_replace(",", "", $matches[1]));
        }


    
}
function getGoogleLinks($url)
{
   /* $url  = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=site:$url&filter=0";
    $str  = json_decode(_curl($url));  
    return intval($str->responseData->cursor->estimatedResultCount);*/
		$CI 	=& get_instance();
    if($CI->session->userdata('GoogleLinksDate') == date('Ymd')){
    	return $CI->session->userdata('GoogleLinks');
    }
 	$api_url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=site:$url&filter=0";
    $content = _curl($api_url);     
        if (empty($content)) 
        {
            return intval(0);
        }
         $data = json_decode($content);
        
    	$i =  intval($data->responseData->cursor->estimatedResultCount);
        	$CI->session->set_userdata("GoogleLinks", intval(str_replace(",", "", $i)));
        	$CI->session->set_userdata("GoogleLinksDate", date("Ymd"));
        	return intval(str_replace(",", "", $i));
        

   
}


function alexaRank()
{
	$CI 	=& get_instance();
	
    if($CI->session->userdata('AlexaRankDate') == date('Ymd')){
    	return $CI->session->userdata('alexaRank');
    }
	$source = _curl('http://data.alexa.com/data?cli=10&dat=snbamz&url='.base_url());
	//Alexa Rank
	preg_match('/\<popularity url\="(.*?)" text\="([0-9]+)" source\="panel"\/\>/si', $source, $matches);
	$aresult = ($matches[2]) ? $matches[2] : 0;
	$aresult = floatval($aresult);
	$CI->session->set_userdata("alexaRank", $aresult);
	$CI->session->set_userdata("AlexaRankDate", date("Ymd"));
	return $aresult;
}

function full_url()
{
   $ci=& get_instance();
   $return = base_url().$ci->uri->uri_string();
   if(count($_GET) > 0)
   {
      $get =  array();
      foreach($_GET as $key => $val)
      {
         $get[] = $key.'='.$val;
      }
      $return .= '?'.implode('&',$get);
   }
   return $return;
} 

function comments($where)
{
	$CI 	=& get_instance();
	switch ($where) {
		case 'profile':
			if($CI->config->item("comment_profile") == '1')
			{
				return $CI->load->view("templates/common/_comments",false,true);
			}
			break;
		case 'songinfo':
			if($CI->config->item("comment_songinfo") == '1')
			{
				return $CI->load->view("templates/common/_comments",false,true);
			}
			break;
		case 'artist':
			if($CI->config->item("comment_artist") == '1')
			{
				return $CI->load->view("templates/common/_comments",false,true);
			}
			break;
		case 'station':
			if($CI->config->item("comment_station") == '1')
			{
				return $CI->load->view("templates/common/_comments",false,true);
			}
			break;

		default:
			return false;
			break;
	}


}

function getInfoDatabase()
{

	$CI 	=& get_instance();
	return $CI->db->query("SELECT table_schema 'name',sum( data_length + index_length ) / 1024 / 1024 'used',sum( data_free )/ 1024 / 1024 'free' FROM information_schema.TABLES where table_schema ='".$CI->db->database."' GROUP BY table_schema");
	
}
function getTableInfo($table)
{

	$CI 	=& get_instance();
	$TEMP = $CI->db->query("SELECT TABLE_ROWS as rows,DATA_LENGTH as size FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$CI->db->database."' AND TABLE_NAME='$table'");
	return $TEMP->row();
}


function getIdUser($username)
{
	$CI 	=& get_instance();
	$temp = $CI->db->query("SELECT id from users where nickname ='$username'");
	$row = $temp->row();
	return intval($row->id);
}
function getAvatarUser($username,$iduser = false)
{
	$CI 	=& get_instance();
	if(!$iduser)
		$temp = $CI->db->query("SELECT avatar from users where nickname ='$username'");
	else
		$temp = $CI->db->query("SELECT avatar from users where id ='$iduser'");
	$row = $temp->row();
	return ($row->avatar);
}
function getNickNameUser($id)
{
	$CI 	=& get_instance();	
	$temp = $CI->db->query("SELECT nickname from users where id ='$id'");
	$row = $temp->row();	
	return ($row->nickname);

}
function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
     $bytes /= pow(1024, $pow);
     //$bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 

function getPage($page)
{
	$CI 	=& get_instance();
	 if($CI->config->item("lastfm") == '')
     {
     	echo '<div class="alert alert-danger">
              	<strong>Error Api KEY</strong> Remember config your api key
              </div>';
                        
    }
    if(!is_writable_cache())
    {
    	echo '<div class="alert alert-danger">
   				<strong>Error Cache Folder</strong> Please allow read/write persmission (777) to the cache folder in your root.
              </div>';
              
    }    
    echo $page;
}

function br2n($text)
{
	$breaks = array("<br />","<br>","<br/>");  
    $text = str_ireplace($breaks, "", $text);  
    return $text;
}
function getStyle()
{
	$CI 	=& get_instance();
	
	$css = '<link href="'.base_url().'assets/css/themes/'.$CI->config->item("theme").'/bootstrap.min.css" rel="stylesheet">';
	if($CI->config->item("skin_color") != '')
	{
		if(file_exists( './assets/css/themes/'.$CI->config->item("theme").'/skins/'.$CI->config->item("skin_color").".css"))
		{
			$css = '<link href="'.base_url().'assets/css/themes/'.$CI->config->item("theme").'/skins/'.$CI->config->item("skin_color").'.css" rel="stylesheet">';		
		}
					  
	}
	return $css;
	
}

function getFollowButton($userid,$username,$type='big',$is_follow = false)
{

	$CI 		=& get_instance();	

	if(!$is_follow)
		$is_follow 	= $CI->admin->getTable("follows",array('iduser' =>  $CI->session->userdata('id'),'iduserf' =>  $userid));
	$followers = getFollowers($userid);
	if($is_follow->num_rows() == 0)
	{
		$button = '<button class="btn btn-success btn-block btn-follow-user" data-user="'.$username.'">'.___('label_follow_user').' <span class="badge badge-sm  badge-danger">'.number_format($followers->num_rows(),0).'</span></button>';
		$button_xs = '<button href="#" class="btn btn-xs btn-success btn-follow-user" data-user="'.$username.'">'.___('label_follow_user').'</button>';
	}
	else
	{
		
		// data-avatar="'+val.avatar+'"  data-user="'+val.nickname+'"
		$button_chat = '<button class="btn btn-info btn-chat" data-avatar="'.getAvatarUser($username).'" data-user="'.$username.'"><i class="fa fa-comments"></i></button>';
		$button_chat_xs = '<button class="btn btn-xs btn-info btn-chat"  data-avatar="'.getAvatarUser($username).'"  data-user="'.$username.'"><i class="fa fa-comments"></i></button>';
		$button = '<div class="btn-group btn-group-justified"><div class="btn-group"><button class="btn btn-default  btn-unfollow-user" data-user="'.$username.'">'.___('label_unfollow_user').' <span class="badge badge-sm  badge-danger">'.number_format($followers->num_rows(),0).'</span></button></div><div class="btn-group">'.$button_chat.'</div></div>';
		$button_xs = '<div class="btn-group"><button href="#" class="btn btn-xs btn-default btn-unfollow-user" data-user="'.$username.'">'.___('label_unfollow_user').'</button>'.$button_chat_xs.'</div>';
	}

	if($type == 'big')
		$btn =  $button;
	else
		$btn = $button_xs;

	if(!is_logged())
		$btn = str_ireplace("btn-follow-user", "btn-login", $btn);
	if($userid ==  $CI->session->userdata('id'))
		$btn = str_ireplace("btn-follow-user", "disabled", $btn);
	

	return $btn;
}

function getFollowers($userid)
{
	$CI 		=& get_instance();	
	//return $CI->db->query("follows",array('iduserf' =>  $userid));	
	return $CI->db->query("SELECT * from users,follows where users.id=follows.iduser and follows.iduserf = $userid");;
}

function getFollowing($userid)
{
	$CI 		=& get_instance();	
	//return $CI->db->query("follows",array('iduserf' =>  $userid));	
	return $CI->db->query("SELECT users.* FROM `follows`,users WHERE follows.iduser=$userid and follows.iduserf = users.id");;
}

function getFollowingOnline($userid)
{
	$CI 		=& get_instance();	
	//return $CI->db->query("follows",array('iduserf' =>  $userid));	
	return $CI->db->query("SELECT users.* FROM follows,users,online WHERE follows.iduser=$userid and follows.iduserf = users.id and online.iduser = users.id group by users.id");
}

function getUsersOnline()
{
	$CI 		=& get_instance();
	return $CI->db->query("SELECT * from online LEFT JOIN users ON (users.id=online.iduser)");
}

function checkOnline($iduser)
{
	$CI 		=& get_instance();
	$iduser = intval($iduser);
	$data = $CI->db->query("SELECT * from online where iduser=$iduser");
	if($data->num_rows() > 0 )
		return true;
	return false;
}

function isFollowMe($iduserf)
{
	$CI 		=& get_instance();
	$iduserf = intval($iduserf);
	$iduser = $CI->session->userdata('id');
	$data = $CI->db->query("SELECT * from follows where iduserf=$iduser and iduser=$iduserf");
	if($data->num_rows() > 0 )
		return true;
	return false;
}

function isPublicChat($iduser)
{
	$CI 		=& get_instance();
	$iduser 	= intval($iduser);	
	$data 		= $CI->db->query("SELECT public_chat from users where id=$iduser and public_chat='1'");
	if($data->num_rows() > 0 )
		return true;
	return false;
}
function getCustomTopArtist()
{
	$CI 		=& get_instance();	
	return $CI->admin->getTable('top_page_artist');
}

function emoticons($text) 
{
	$icons = array(
	        ':)'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/smiling.png" alt="smile" class="icon_smile" />',
	        ':-)'   =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/smiling.png" alt="smile" class="icon_smile" />',
	        ':D'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/laughing.png" alt="smile" class="icon_laugh" />',
	        'xD'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/laughing.png" alt="smile" class="icon_laugh" />',
	        ':d'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/laughing.png" alt="laugh" class="icon_laugh" />',
	        ';)'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/winking.png" alt="wink" class="icon_wink" />',
	        ':P'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/tongue_out.png" alt="tounge" class="icon_tounge" />',
	        ':-P'   =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/tongue_out.png" alt="tounge" class="icon_tounge" />',
	        ':-p'   =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/tongue_out.png" alt="tounge" class="icon_tounge" />',
	        ':p'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/tongue_out.png" alt="tounge" class="icon_tounge" />',
	        ':('    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/frowning.png" alt="sad face" class="icon_sad" />',
	        ':o'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/gasping.png" alt="shock" class="icon_shock" />',
	        ':O'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/gasping.png" alt="shock" class="icon_shock" />',
	        ':0'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/gasping.png" alt="shock" class="icon_shack" />',
	        ':|'    =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/surprised.png" alt="straight face" class="icon_straight" />',
	        ':-|'   =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/surprised.png" alt="straight face" class="icon_straight" />',	        
	        ':-/'   =>  '<img src="'.base_url().'assets/css/themes/musik/images/faces/surprised.png" alt="straight face" class="icon_straight" />'
	);
	/* foreach($icons as $icon=>$image) 
	 {
      $icon = preg_quote($icon);
      $text = preg_replace("~\b$icon\b~",$image,$text);
 	}
 	return $text;*/

 	 return strtr($text, $icons);
}

function getCarousel()
{
	$CI 		=& get_instance();	
	return $CI->admin->getTable("carousel",false,"order");
}


function shortcode($content) {

	
	$pattern = '/\[(.*?)\]/';
	$regex = '/(\w+)\s*=\s*"(.*?)"/';
	$shorcode = array();

  	preg_match_all($pattern, $content, $matches);  	

  	foreach ($matches[1] as $key => $value) {

  		preg_match_all($regex, $value, $matches2);	  		  		
  		foreach ($matches2[1] as $key2 => $value2) {

  			$shorcode[$key][$value2] = $matches2[2][$key2];
  		}
  		if($shorcode[$key]['type'])
  			$shorcode[$key]['shortcode'] = $matches[0][$key];
  		
	}
	return $shorcode;
}
function processShortCode($text)
{
	$CI 		=& get_instance();	
	$form 				= $CI->load->view("templates/common/_contact_form",false,true);
	$carousel 			= $CI->load->view("templates/common/_carousel",false,true);
	if(strpos($text, '{custom-top-artist-page}'))
		$top_page_artist 	= $CI->getTopArtistCustom(true,true);	
	if(strpos($text, '{radio-stations}'))
		$radio 	= $CI->getStations(true);	
	if(strpos($text, '{top-tracks}'))
		$top 	= $CI->getTopTracks(true,true);
	if(strpos($text, '{activity-page}'))
		$activity 	= $CI->getActivity(true);
	$text  	= str_ireplace('{contact-form}',  '<div style="margin-left:-30px;margin-right:-30px">'.$form.'</div>', $text);
	$text  	= str_ireplace('{facebook-page-like}',  '<div class="fb-page" title="Facebook" data-href="'.$CI->config->item("facebook_fanpage").'"  data-width="100%" data-hide-cover="false" data-show-facepile="true"   data-show-posts="false"></div>', $text);	
	$text  	= str_ireplace('{carousel}', $carousel, $text);
	$text  	= str_ireplace('{custom-top-artist-page}',  '<div style="margin-left:-30px;margin-right:-30px">'.$top_page_artist.'</div>', $text);
	$text  	= str_ireplace('{radio-stations}', '<div style="margin-left:-30px;margin-right:-30px">'.$radio."</div>", $text);
	$text  	= str_ireplace('{top-tracks}', '<div style="margin-left:-30px;margin-right:-30px">'.$top."</div>", $text);
	$text  	= str_ireplace('{activity-page}', $activity, $text);
	$text  	= str_ireplace('"]', ' "]', $text);

	// Shorcode


	$shortcode = shortcode($text);



	

	foreach ($shortcode as $key => $value) {
		if($CI->agent->is_mobile())
			$value['type'] = '';
		switch ($value['type']) {
			case 'artist':
				$artist = getArtistInfo($value['name']);
				$text  	= str_ireplace($value['shortcode'], process_artist_item($artist), $text);
				break;
			case 'track':
				$data = getTrackInfo($value['artist'],$value['track']);
				$text  	= str_ireplace($value['shortcode'], process_track_item($data), $text);
				break;
			case 'playlist':			
				$data = get_playlist_by_id($value['id']);
				$text  	= str_ireplace($value['shortcode'], process_playlist_item($data), $text);
				break;
			default:
				$text = '';
				break;
		}
	}
	
	return $text."<div class='clearfix'></div><br>";
}


function process_playlist_item($json)
{
	$CI 		=& get_instance();	
	$row = $json->row();
	$json = json_decode($row->json);
	
	foreach ($json as $key => $value) 
	{
		if($value->cover != '' && $image == '')
			 $image = $value->cover;
	}


	
	
	$html ="<div class='item'>
			      		<div class='pos-rlt'>
			      			<div class='bottom'>
                        		<span class=' m-b-sm m-l-sm badge bg-info'>".count($json)." </span>
                      		</div>			        		
			        		<div class='item-overlay opacity r r-2x bg-black'>			       
			          			<div class='center text-center m-t-n'>
			            			<a class='btn-play-playlist' data-id='".$row->idplaylist."' href='#'><i class='icon-control-play i-2x'></i></a>
			          			</div>
			        		</div>
			        		<a href='#'>			          
			          			<div class='r r-2x img-full' style='background:url(".$image.") no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;'>
			           				<div style='height:180px;overflow:hidden;'></div>
			          			</div>
			          		</a>
			      		</div>
			      		<div class='padder-v'>
			        		<a href='#' class='text-ellipsis btn-edit-playlist'  data-id='".$row->idplaylist."'>".$row->name."</a>			        
			      		</div>
			    	</div>";
			  return $html;
}
function process_artist_item($json)
{
	$json = json_decode($json);
	$image = $json->artist->image[4]->text;
	if($image == '')
		$image = $json->artist->image[3]->text;
	if($image == '')
		$image = $json->artist->image[2]->text;
	if($image == '')
		$image = base_url()."assets/images/no-cover.png";

	$html = '
	 <div class="item">
            <div class="pos-rlt">
                <div class="item-overlay opacity r r-2x bg-black btn-artist-info" data-artist="'.addslashes($json->artist->name).'">
                    <div class="text-info padder m-t-sm text-sm">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="center text-center m-t-n">
                        <a  href="#"><i class="icon-info i-2x"></i></a>
                    </div>
                    <div class="bottom padder m-b-sm hide">
                        <a href="#" class="pull-right">
                            <i class="fa fa-heart-o"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <a href="#">
                    <div class="r r-2x img-full" style="background:url('.$image.') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
                        <div style="height:180px;overflow:hidden;"></div>
                    </div>
                </a>
            </div>
            <div class="padder-v">
                <a href="#" class="text-ellipsis btn-artist-info removehref" data-artist="'.$json->artist->name.'">'.$json->artist->name.'</a>
            </div>
        </div>'; 

        return $html;
}
function process_track_item($json)
{
	$json = json_decode($json);
	$image = $json->track->album->image[4]->text;
	if($image == '')
		$image = $json->track->album->image[3]->text;

	if($image == '')
		$image = base_url()."assets/images/no-cover.png";

	$html = '
	  <div class="item">
                <div class="pos-rlt">
                    <div class="item-overlay opacity r r-2x bg-black">
                        <div class="center text-center m-t-n">
                            <a class="btn-play-now" data-track="'.addslashes($json->track->name).'"  data-artist="'.addslashes($json->track->artist->name).'" data-cover="'.$image.'"  href="#"><i class="icon-control-play i-2x"></i></a>
                        </div>
                        <div class="bottom padder m-b-sm">
                            <a href="#" class="btn-start-radio pull-right" data-track="'.addslashes($json->track->name).'"  data-artist="'.addslashes($json->track->artist->name).'" data-cover="'.$image.'">
                                <i class="fa fa-rss"></i>
                            </a>
                            <a href="#" class="btn-add-playlist" data-track="'.addslashes($json->track->name).'"  data-artist="'.addslashes($json->track->artist->name).'" data-cover="'.$image.'"  >
                                <i class="fa fa-plus-circle"></i>
                            </a>
                        </div>
                    </div>
                    <a href="#">
                        <div class="r r-2x img-full" style="background:url('.$image.') no-repeat top center; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;  background-size: cover;">
                            <div style="height:180px;overflow:hidden;"></div>
                        </div>
                    </a>
                </div>
                <div class="padder-v">
                    <a href="#" class="text-ellipsis btn-track-info" data-artist="'.addslashes($json->track->artist->name).'" data-track="'.addslashes($json->track->name).'">'.$json->track->name.'</a>
                    <a href="#" class="text-ellipsis text-xs text-muted btn-artist-info" data-artist="'.$json->track->artist->name.'">'.$json->track->artist->name.'</a>
                </div>
            </div>'; 

        return $html;
}

function get_badges($id)
{
	$CI 		=& get_instance();	
	$data = $CI->db->query("SELECT * from badges order by type,id");			

	foreach ($data->result() as $row)
	{
		
		if($row->type == 'follows_users')
		{
			if(!$follows)
			{
				$follows = getFollowing($id);
				$follows = $follows->num_rows();
			}
			if($follows > $row->value)			
				echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;opacity:1"> ';
			else
				echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;" class="badges-gray"> ';
		}


		if($row->type == 'followed_users')
		{
			if(!$following)
			{
				$following = getFollowing($id);
				$following = $following->num_rows();
			}
			if($following > $row->value)			
				echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;opacity:1"> ';
			else
				echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;" class="badges-gray"> ';
		}

		if($row->type == 'listen_song')
		{
			if(!$listen)
			{
				$listen =  $CI->db->query("SELECT distinct artist,track from activity  where iduser= '$id' group by artist,track limit ".( $row->value + 1));			
				$listen = $listen->num_rows();
			}
			if($listen > $row->value)			
				echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;opacity:1"> ';
			else
				echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;" class="badges-gray"> ';
		}

		if($row->type == 'listen_artist')
			{
				if(!$listen_a)
				{
					$listen_a =  $CI->db->query("SELECT distinct track from activity  where iduser= '$id' group by track limit ".( $row->value + 1));			
					$listen_a = $listen_a->num_rows();
				}
				if($listen_a > $row->value)			
					echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;opacity:1"> ';
				else
					echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;" class="badges-gray"> ';
			}

		if($row->type == 'chat')
			{
				if(!$chat_u)
				{
					$chat_u =  $CI->db->query("SELECT distinct idfriend from chat  where iduser= '$id' and seen != '0000-00-00' group by idfriend limit ".( $row->value + 1));							
					$chat_u = $chat_u->num_rows();
				}
				if($chat_u > $row->value)			
					echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;opacity:1"> ';
				else
					echo '<img title="'.$row->title.'" src="'.base_url().'assets/css/themes/musik/images/badges/'.$row->badge.'" style="width:24px;height:24px;" class="badges-gray"> ';
			}



	
	}
	// Get Follows Users


	// Get Followed Users

	// Get Diferent Chat count

	// Get Number Diferent Songs

	// get Number Diferent Artist


	
	
}
function get_itunes_link($query) 
{	
	$CI 		=& get_instance();	
	$id 		= $CI->config->item("itunes_afiliate");
	if($id  == '')
		 $id = '10lJNg';
	$query 		= encode($query);	
	$link 		= "http://itunes.apple.com/search?term=$query&media=music&at=$id&limit=1&country=".$CI->config->item("itunes_country");
	return $link;
}
function search_itunes($query)
{
	$json = _curl(get_itunes_link($query));
	return $json;
}
 

 function getMp3StreamTitle($steam_url,$faceke = 0)
{


	if(strpos($steam_url,";?icy=http") !== FALSE)
	{
		$steam_url = str_ireplace("/;?icy=http", "", $steam_url);		
		$steam_url = str_ireplace("http://", "", $steam_url);		
		$steam_url = str_ireplace("https://", "", $steam_url);		
		$a = explode(":", $steam_url);
		$ip = $a[0];
		$port = $a[1];
		$fp = @fsockopen($ip,$port,$errno,$errstr,1);
		if (!$fp) { 
		    $title = "";
		} else { 
		    fputs($fp, "GET /7.html HTTP/1.0\r\nUser-Agent: Mozilla\r\n\r\n");
		    while (!feof($fp)) {
		        $info = fgets($fp);
		    }
		    $info = str_replace('</body></html>', "", $info);
		    $split = explode(',', $info);
		    if (empty($split[6])) {
		        $title = "";
		    } else {
		        $count = count($split);
		        $i = "6";
		        while($i<=$count) {
		            if ($i > 6) {
		                $title .= ", " . $split[$i];
		            } else {
		                $title .= $split[$i];
		            }
		            $i++;
		        }
		    }
		}
		$title = substr($title, 0, -2);		
		if($title)
			return array("title" =>$title);
	}
	
	$steam_url = str_ireplace("\n", "", $steam_url);
	$steam_url = str_ireplace("\r", "", $steam_url);
	$steam_url = trim($steam_url);


	if(!function_exists('stream_context_set_default'))
	{		
		return false;
	}
    $result = false;
    $icy_metaint = -1;
    $needle = 'StreamTitle=';
    $ua = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36';

    $opts = array(
        'http' => array(
            'method' => 'GET',
            'header' => 'Icy-MetaData: 1',
            'user_agent' => $ua
        )
    );

    $default = stream_context_set_default($opts);



    $stream = fopen($steam_url, 'r');    
 


    if($stream && ($meta_data = stream_get_meta_data($stream)) && isset($meta_data['wrapper_data'])){    	
        foreach ($meta_data['wrapper_data'] as $header){        	
        	if (strpos(strtolower($header), 'icy-description:') !== false)
        		$result['description'] = str_ireplace("icy-description:", "", $header);
        	if (strpos(strtolower($header), 'icy-genre:') !== false)
        		$result['genre'] = str_ireplace("icy-genre:", "", $header);
            if (strpos(strtolower($header), 'icy-metaint') !== false){
                $tmp = explode(":", $header);
                $icy_metaint = trim($tmp[1]);
                break;
            }
        }
    }

    if($icy_metaint == -1)
    {
    	$a = get_headers($steam_url);
    	if(is_array($a))
    	{
	    	foreach ($a as $key => $header) {
	    		if (strpos(strtolower($header), 'icy-description:') !== false)
	        		$result['description'] = str_ireplace("icy-description:", "", $header);
	        	if (strpos(strtolower($header), 'icy-genre:') !== false)
	        		$result['genre'] = str_ireplace("icy-genre:", "", $header);
	            if (strpos(strtolower($header), 'icy-metaint') !== false){
	                $tmp = explode(":", $header);
	                $icy_metaint = trim($tmp[1]);
	                break;
	            }
	    	}
	    }
    }

    if($icy_metaint != -1)
    {

        $buffer = stream_get_contents($stream, 300, $icy_metaint);
        //echo $buffer;

        if(strpos($buffer, $needle) !== false)
        {
        
            $title = explode($needle, $buffer);
            $title = trim($title[1]);
            $result['title'] = substr($title, 1, strpos($title, ';') - 2);
        }
    }

    if($stream)
        fclose($stream);                



    return $result;
}

function get_content_type($url)
{
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	$content = curl_exec ($ch);
	$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	curl_close ($ch);
	//print_p(curl_getinfo($ch));
	//echo "<br>URL = ". $url;
	//echo "<br>Type=". $contentType;
	return $contentType;
}

function extract_link_station($url)
{
	$data 	= _curl($url);
	
	$temp 	= explode("\n", $data);
	$station = array();
	foreach ($temp as $key => $value) {
		if(strpos($value,'http') !== false)
			$station[] = str_ireplace("File1=", "", $value);
			
	}

	if(count($station)>0)
	{
		return trim(str_ireplace("\r", "",$station[0]));
	}
	return trim(str_ireplace("\r", "",$temp[0]));

}

function canAccessAPI()
{
	return 1;
	return intval(_curl("http://api.andthemusic.net/music/status"));

}

function isApache()
{
	if(strpos(strtolower($_SERVER["SERVER_SOFTWARE"]) , 'apache') !== FALSE)
	{
		return true;
	} 
	return false;
}
function getStationLink($url)
{
	

	/* New Logic */

	$ext = substr($url, strlen($url)-4,4);
	if(strpos($url, ".m3u") != false)
		$ext = '.m3u';
	if(strpos($url, ".pls") != false)
		$ext = '.pls';

	switch ($ext) {
		case '.pls':
			$url = getStationLink(extract_link_station($url));
			break;
		case '.m3u':
			$url = getStationLink(extract_link_station($url));
			break;		
		case '.mp4':
			# code...
			break;		
		case '.mp3':
			# code...
			break;		
		case '.wma':
			# code...
			break;		
		case 'http': ///;?icy=http"
			# code...
			break;		
		default:
			if(strpos($url,'radionomy') === false)
			{
				
				$header = get_headers($url);				
				//print_p($header);
				$icy = false;
				foreach ($header as $key => $value) {					
					if(strpos(strtolower($value), 'icy-url') !== false)
					{
						$t = explode(":", $value);						
						if(trim($t[1]) != '')
						{							
							$icy = true;
						}
					}
				}


				if($icy)
				{
					if(substr($url, -1)=="/")
						$url= $url.";?icy=http";
					else
						$url= $url."/;?icy=http";	
				}
				
			}
			break;
	}
	return $url;


	
	  

}

function search_playlist($query,$f = false)
{
	//$query = decode($query);
	$query = urldecode($query);
	$query = str_ireplace("/","\\\\\\\/",$query);
	$query = str_ireplace("+","\+",$query);
	$query = str_ireplace("'","\'",$query);
	
	$query = ($query);
	$CI 		=& get_instance();		
	if(!$f)
		return $CI->db->query("SELECT * FROM playlist where playlist.json LIKE '%$query%' or playlist.name LIKE '%$query%' LIMIT 30");
	return $CI->db->query("SELECT * FROM playlist where type='F' and json LIKE '%$query%' LIMIT 100");
	
}

function search_lyrics($query)
{
	$query = decode($query);
	$CI 		=& get_instance();	
	$temp 		= explode(" ", $query);
	/*foreach ($temp as $key => $value) {
		if(strlen($value)>2)
			$CI->db->like('lyric', $value);	
	}*/
		$CI->db->like('lyric', $query);	
	$CI->db->limit(50);
	return $CI->db->get("lyrics");	
}


function search_stations($query)
{
	$query = decode($query);
	$CI 		=& get_instance();	
	$CI->db->like('title', $query);
	$CI->db->or_like('keywords', $query); 
	$CI->db->or_like('description', $query); 
	return $CI->db->get("stations_m3a");	
}
function getStations($where=false)
{
	$CI 		=& get_instance();	
	return $CI->admin->getTable("stations_m3a",$where,"idtstation desc");
}

function setDownload($artist,$track,$cover,$service)
{
	$CI 		=& get_instance();	
	return $CI->db->query("INSERT INTO tracks (artist,track,cover,downloads_$service) VALUES ('$artist','$track','$cover','1')  ON DUPLICATE KEY UPDATE downloads_$service=downloads_$service+1");	
}
function getTotalDownloads()
{
	$CI 		=& get_instance();	
	return $CI->db->query("SELECT sum(downloads_mp3) as  mp3, sum(downloads_itunes) as itunes, sum(downloads_amazon) as amazon,sum(downloads_mp3)+sum(downloads_itunes)+sum(downloads_amazon) as  total FROM tracks WHERE 1");		
}
function getTopDownloads()
{
	$CI 		=& get_instance();	
	return $CI->db->query("SELECT artist,track,downloads_mp3 as mp3,downloads_itunes as itunes,downloads_amazon as amazon, downloads_mp3  +  downloads_itunes  +  downloads_amazon  AS total FROM  tracks  order by total DESC LIMIT 100");			
}

function get_playlist($id)
{
	$CI 		=& get_instance();	
	return  $CI->admin->getTable("playlist",array("iduser" => $id),'name');
}

function get_playlist_by_id($id)
{
	$CI 		=& get_instance();	
	return  $CI->admin->getTable("playlist",array("idplaylist" => $id));
}




function ping_google()
{
	return false;
	if(file_exists("./application/modules/sitemap/controllers/sitemap.php"))
	{
		$CI 		=& get_instance();	
		$last_submit = $CI->session->userdata('last_submit');
		if($last_submit != date("YmdH"))
		{
			$CI->session->set_userdata('last_submit',date("YmdH"));
			$sitemap = base_url()."sitemap";
			_curl("http://www.google.com/webmasters/sitemaps/ping?sitemap=".urlencode($sitemap));		
		}		
	}
	
}

function login_spotify($label ='label_login_spotify')
{
	$CI 		=& get_instance();	
	$html  = '';
	if($CI->config->item("spotify_secrect") != '' && $CI->config->item("spotify_key") != '')
	{
		if(file_exists("./application/modules/spotify/controllers/spotify.php"))
		{
			$html = '<a class="btn btn-success btn-block" style="margin-top:10px;margin-bottom:10px"  href="'.base_url().'spotify"><i class="fa fa-fw fa-spotify"></i>'.___($label).'</a>';                          	
		}	
	}
	return $html;
}


function login_facebook($label ='label_login_facebook')
{
	$CI 		=& get_instance();	
	$html  = '';
	if($CI->config->item("fb_appId") != '' && $CI->config->item("fb_secret") != '' && $CI->config->item("loginfb") == '1')
	{
		if(file_exists("./application/modules/facebook/controllers/facebook.php"))
		{
			$html = '<a class="btn btn-primary btn-block" style="margin-top:10px;margin-bottom:10px"  href="'.base_url().'facebook"><i class="fa fa-fw fa-facebook"></i>'.___($label).'</a>';                          	
		}	
	}
	return $html;
}

function __fb_post($data)
{	

	if(!is_logged())
		return false;
	$CI 		=& get_instance();		

	$token_obj 	= $CI->admin->getTable("token_facebook",array("iduser" => $CI->session->userdata('id')));
	$token = $token_obj->row();
	if($CI->config->item("fb_appId") != '' && $CI->config->item("fb_secret") != '' && $CI->config->item("loginfb") == '1' && $token)
	{
		if(file_exists("./application/modules/facebook/controllers/facebook.php") && $CI->session->userdata('auto_fb_wall') == '1')
		{
			$link 	=  base_url()."?artist=".$data['artist']."&track=".$data['track'];
			$action = array('name' => ___("label_playnow"), 'link' => urlencode($link));
							
							
			$actions = json_encode($action);	
			$post['message'] 	= $CI->config->item("share_fb_msg");
			$post['message'] 	= str_ireplace("{ARTIST}", $data['artist'], $post['message']);
			$post['message'] 	= str_ireplace("{TRACK}", $data['track'], $post['message']);
			$post['message'] 	= str_ireplace("{SITE}", base_url(), $post['message']);
			$post['name'] 		= $data['track'];
			$post['caption'] 	= $data['artist']." - ".$data['track'];
			$post['actions'] 	= $actions;
			$post['picture'] 	= $data['picture'];
			$post['link'] 		= urlencode(base_url()."?artist=".$data['artist']."&track=".$data['track']);
			$me 				= json_decode(_curl("https://graph.facebook.com/v2.3/me/feed?access_token=".$token->access_token,$post));			
		}
	}
}



function get_data_file($data)
{
	$temp 	= explode("\n",$data);	
	if($temp[1] == '/**')
	{
		$values[0] = $temp[2];
		$values[1] = $temp[3];	
		$values[2] = $temp[4];	
		foreach ($values as $key => $value) {
			$t = explode(":", $value);
			$metadata[ltrim(str_ireplace("*","", trim($t[0])))] = ltrim($t[1]);
		}
	}
	
	return $metadata;
}
function array_delete($array, $element) {
    return (is_array($element)) ? array_values(array_diff($array, $element)) : array_values(array_diff($array, array($element)));
}

function is_musik(){
	if(file_exists('./application/modules/music/controllers/musik.php')){ 
	    return true;
	}
	return false;
}


function facebook_like_btn($url = false)
{
	if(!$url)
		$url = base_url();
	$html ='<div class="fb-like" data-href="'.$url.'" data-width="100%" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>';
	$CI 		=& get_instance();	
	if($CI->input->is_ajax_request())
	{
		$html .='<script>try{FB.XFBML.parse();}catch(ex){}</script>';
	}	
	return $html;
}

function _like_btn($idactivity,$objactivity,$count,$iduser)
{

	$CI 		=& get_instance();	
	if($iduser ==$CI->session->userdata('id'))
	{
			return '<div class="btn-group" role="group" aria-label="...">
			  		<button type="button" class="btn btn-xs btn-default disabled" >'.___("label_like").'</button>
			  		<button type="button"  class="btn btn-xs btn-default  disabled" >'.$count.'</button>			  
				</div>';
	}

	$allow = '';
	$label = ___("label_like");
	$label2 = ___("label_youlike");
	if($objactivity->num_rows>0)
	{
		
		foreach ($objactivity->result() as $key => $value) {
			
			if($value->idactivity == $idactivity)
			{	
				$label = ___("label_youlike");
				$allow = 'disabled';
				break;
				
			}
		}
	}

	$style = 'btn-like-activity';
	if(!is_logged())
		$style='btn-login';
	$html ='<div class="btn-group" role="group" aria-label="...">
			  <button type="button" class="btn btn-xs btn-default '.$allow.' '.$style.'" data-iduser="'.$iduser.'" data-idactivity="'.$idactivity.'"  >'.$label.'</button>
			  <button type="button" data-label="'.$label2.'" class="btn btn-xs btn-default  disabled count-like-'.$idactivity.'">'.$count.'</button>			  
			</div>';
	
	
	return $html;
}
function in_arrayi($needle, $haystack) {
    return in_array(strtolower($needle), array_map('strtolower', $haystack));
}

function check_banned_genre($genre)
{
	$CI 		=& get_instance();	
	$banned = explode(",", $CI->config->item("banned_genres"));
	if(in_arrayi(decode($genre),$banned))
	 {
	 	show_404();
	 	exit;
	 }
}

function adfly($url, $title,$key, $uid,$domain = 'adf.ly', $advert_type = 'int')
{
  // base api url
  $api = 'http://api.adf.ly/api.php?';

  // api queries
  $query = array(
    'key' => $key,
    'uid' => $uid,
    'advert_type' => $advert_type,
    'domain' => $domain,
    'url' => $url,
    'folder' => 'Music',
    'title' => $title
  );

  // full api url with query string
  $api = $api . http_build_query($query);
  // get data
  if ($data = _curl($api))
    return $data;
}

function save_error($error)
{
	$CI 		=& get_instance();	
	$data['error'] 	= $error;
	$data['date'] 	= date("Y-m-d H:i:s");
	$CI->admin->setTable("errors",$data);
}
function current_full_url()
{
    $CI =& get_instance();

    $url = $CI->config->site_url($CI->uri->uri_string());
    
    return $_SERVER['QUERY_STRING'] ? $url.'/?'.$_SERVER['QUERY_STRING'] : $url;
}
function is_ok($value,$det = false)
{
	
	
	
	
		
		
			$data['purchase_date'] 	= date("Y-m-d H:i:s");
			$data['name'] 			= "Youtube Music Engine";
			$data['license'] 		= "Free License (<a href='http://yme.nexxuz.com'>Download Updates</a>)";
			$data['author'] 		= "Jodacame";
			$data['author_url'] 	= "http://jodacame.com";
			$data['supported_until'] = "99999999";
			return $data;
		
		
		

	
	return false;
}
function embed_code($url)
{

	 $CI =& get_instance();
	 if($CI->config->item("use_embed") == '1')
	 {		
		 	$iframe = '<iframe style="border:1px rgba(0,0,0,.2) solid" width="260" height="310" data-src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
		 	$html = "<button class='btn btn-show-embed btn-default btn-block'>
		 	".___("label_embed").
		 	"</button>
		 	<br><div id='embed' style='display:none'>
		 	<textarea rows='5' style='width:100%;font-size:12px'>$iframe</textarea>
		 	<div class='text-center' id='preview-iframe'>$iframe</div>
		 	</div>
		 	";
		 	return $html;
	 }
	
}

?>