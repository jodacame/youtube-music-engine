<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Name: Youtube Music Engine
 * Version: 6.1.0
 * URL: //support.jodacame.com/category/updates/youtube-music-engine
 */
class Music extends MY_Controller
{

    public function index($type = '', $query = '', $query2 = '', $query3 = '')
    {


        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->output->set_header("Cache-Control: private, no-store, no-cache, must-revalidate, post-check=0, pre-check=0");


        $query = urldecode($query); // Fix bug tiket 1518
        $query = str_ireplace("-", " ", $query); // Fix bug tiket 1518


        $this->output->enable_profiler(false);

        //$this->output->cache(1);

        if ($this->input->get("s") != '') {
            $data['search'] = urldecode($this->input->get("s"));
            $query = urldecode($this->input->get("s"));
            $type = "search";
        }

        if ($this->input->get("artist") != '' && $this->input->get("track") != '') {
            $data['search'] = $this->input->get("artist") . "-" . $this->input->get("track");
            $query = $this->input->get("artist") . "-" . $this->input->get("track");
            $type = "songInfo";
        }


        $data['search'] = decode(urldecode($data['search']));
        $data['page'] = null;
        $data['title2'] = '';
        $data['description2'] = '';


        if ($this->input->get("playlist") != '') {

            $playlist = $this->admin->getTable("playlist", array("sha1(CONCAT('" . $this->config->item("encryption_key") . "',idplaylist))" => $this->input->get("playlist")));

            $temp = $playlist->result();

            $data['title2'] = "Playlist " . $temp[0]->name . " |";

            $temp2 = json_decode($temp[0]->json);

            foreach ($temp2 as $key => $value) {
                if ($key == 0)
                    $data['picture'] = $value->cover;
                if ($key < 10)
                    $data['description2'] .= $value->track . " - " . $value->artist . " | ";
            }


        }


        switch ($type) {
            case 'artist':
                $data['page'] = $this->getArtistInfo($query, true);
                $data['title2'] = $query . " | ";
                $temp = json_decode(getArtistInfo($query));
                foreach ($temp->artist->tags->tag as $key => $value) {

                    $tags .= $value->name . ",";
                }
                $data['picture'] = $temp->artist->image[4]->text;
                $data['description2'] = ltrim(strip_tags($temp->artist->bio->content)) . " ";
                if ($data['picture'] == '')
                    $data['picture'] = $temp->artist->image[3]->text;


                $metatags['twitter:description'] = more($data['description2'] . " " . $this->config->item("description"), 200);
                $metatags['twitter:title'] = $data['title2'] . " " . $this->config->item("title");
                $metatags['twitter:card'] = "product";
                $metatags['twitter:image'] = $data['picture'];
                $metatags['twitter:image:width'] = '500';
                $metatags['twitter:label1'] = 'Artist';
                $metatags['twitter:data1'] = $query;
                $metatags['twitter:label2'] = 'Tags';
                $metatags['twitter:data2'] = more($tags, 25);


                $og_fb['og:title'] = $metatags['twitter:title'];
                $og_fb['og:type'] = "profile";
                //$og_fb['og:url'] 					=  base_url()."artist/".encode2($query);
                $og_fb['og:image'] = $data['picture'];


                $data['metatags'] = $metatags;
                $data['og_fb'] = $og_fb;


                break;


            case 'albums':
                if ($this->input->get("album"))
                    $data['page'] = $this->getTracksAlbums($query, $this->input->get("album"), true);
                else
                    $data['page'] = $this->getAlbums($query, true);
                $data['title2'] = "Albums " . $query . " | ";
                $temp = json_decode(getArtistInfo($query));
                foreach ($temp->artist->tags->tag as $key => $value) {

                    $tags .= $value->name . ",";
                }
                $data['picture'] = $temp->artist->image[4]->text;
                $data['description2'] = "Albums " . ltrim(strip_tags($temp->artist->bio->content)) . " ";
                if ($data['picture'] == '')
                    $data['picture'] = $temp->artist->image[3]->text;


                $metatags['twitter:description'] = more($data['description2'] . " " . $this->config->item("description"), 200);
                $metatags['twitter:title'] = $data['title2'] . " " . $this->config->item("title");
                $metatags['twitter:card'] = "product";
                $metatags['twitter:image'] = $data['picture'];
                $metatags['twitter:image:width'] = '500';
                $metatags['twitter:label1'] = 'Artist';
                $metatags['twitter:data1'] = $query;
                $metatags['twitter:label2'] = 'Tags';
                $metatags['twitter:data2'] = more($tags, 25);


                $og_fb['og:title'] = $metatags['twitter:title'];
                $og_fb['og:type'] = "profile";
                //$og_fb['og:url'] 					=  base_url()."artist/".encode2($query);
                $og_fb['og:image'] = $data['picture'];


                $data['metatags'] = $metatags;
                $data['og_fb'] = $og_fb;


                break;
            case 'tag':
                $data['page'] = $this->getTopTags($query, true);
                $data['title2'] = $query . " | ";
                break;
            case 'timeline':
                $data['page'] = $this->getActivity(true, intval($query));
                break;
            case 'search':
                $data['search'] = decode(urldecode($query));
                $data['title2'] = ___("label_search") . " " . decode($query) . " | ";
                $data['page'] = $this->search(decode($query), true);
                break;
            case 'user':

                if ($query3 != '' && $query2 == 'unsubscribe' && sha1($this->config->item("encryption_key") . $query) == $query3) {

                    $temp = $this->admin->getTable("users", array("nickname" => ($query)));
                    if ($temp->num_rows() == 0)
                        show_404();
                    $data_temp = $temp->row();
                    $this->admin->updateTable("users", array("newsletter" => '0'), array("id" => intval($data_temp->id)));
                    redirect(base_url() . "user/" . $query);
                    exit;
                }

                $data['title2'] = "Profile " . (urldecode($query)) . " | ";
                $temp = $this->admin->getTable("users", array("nickname" => ($query)));

                if ($temp->num_rows() == 0)
                    show_404();

                $data_temp = $temp->row();
                $data['description2'] = ltrim(strip_tags($data_temp->bio)) . "  ";
                $data['picture'] = $data_temp->avatar;
                $data['page'] = $this->profile(($query), true);
                break;
            case 'page':
                $tmp = explode("-", $query);
                unset($tmp[0]);
                $data['title2'] = implode(" ", $tmp) . " | ";
                $temp_id = explode("-", $query);
                $page_temp = $this->admin->getTable("pages", array("idpage" => intval(intval($temp_id[0]))), "title");
                if ($page_temp->num_rows() == 0)
                    show_404();
                $page = $page_temp->row();
                $page->content = processShortCode($page->content);
                $data['description2'] = more(ltrim(strip_tags($page->content))) . " ";
                $data['page'] = $this->getPage(intval($temp_id[0]), true);
                break;
            case 'station':
                $tmp = explode("-", $query);
                unset($tmp[count($temp) - 1]);
                $temp_id = explode("-", $query);
                $station = getStations(array("idtstation" => intval($temp_id[count($temp_id) - 1])));
                if ($station->num_rows() == 0)
                    show_404();
                $row = $station->row();
                $data['title2'] = $row->title . " | ";
                $data['description2'] = ltrim(strip_tags($row->description)) . " ";
                $data['picture'] = base_url() . "uploads/stations/" . $row->cover;

                $og_fb['og:title'] = $row->title;
                $og_fb['og:type'] = "music.song";
                $og_fb['og:image'] = $data['picture'];
                $og_fb['og:description'] = ltrim(strip_tags($row->description)) . " ";

                $data['page'] = $this->getStation(intval($temp_id[count($temp_id) - 1]), true);


                break;

            case 'playlist':

                $data_temp = get_playlist_by_id(intval($query2));
                $row = $data_temp->row();
                $json = json_decode($row->json);
                foreach ($json as $key => $value) {
                    $subtitle .= $value->track . " by " . $value->artist . ", ";
                    if ($data['picture'] == '')
                        $data['picture'] = $value->cover;
                }


                $data['description2'] = ltrim(strip_tags($subtitle)) . " ";
                $data['title2'] = $row->name . " | ";
                $data['page'] = $this->edit_playlist(intval($query2), true);


                $metatags['twitter:description'] = more($data['description2'] . " " . $this->config->item("description"), 200);
                $metatags['twitter:title'] = ltrim(strip_tags($row->name)) . " | " . $this->config->item("title");
                $metatags['twitter:card'] = "product";
                $metatags['twitter:image'] = $data['picture'];
                $metatags['twitter:image:width'] = '500';
                $metatags['twitter:image:height'] = '500';
                $metatags['twitter:label1'] = 'Playlist';
                $metatags['twitter:data1'] = $row->name;
                $metatags['twitter:label2'] = 'Play Now';
                $metatags['twitter:data2'] = count($json) . " Songs";

                $og_fb['og:title'] = ltrim(strip_tags($row->name)) . " | " . $this->config->item("title");
                $og_fb['og:type'] = "music.playlist";
                $og_fb['og:image'] = $data['picture'];
                $og_fb['og:description'] = more($data['description2'] . " " . $this->config->item("description"), 200);


                break;
            case 'lyric':

                $data_temp = json_decode(getLyric($query, $query2));
                $data_temp->lyric = str_replace(array("\n", "\r"), '', $data_temp->lyric);
                $data['description2'] = more(ltrim(strip_tags($data_temp->lyric)), 250) . " ";
                $data['title2'] = ___("label_lyrics") . ' ' . $data_temp->track . " by " . $data_temp->artist . " | ";
                $data['page'] = $this->getLyric($query, $query2, true);


                break;

            case 'music_folder':
                $data['page'] = $this->myPlaylist(false, true);
                break;

            case 'top':
                if ($query == 'artist') {
                    $data['title2'] = ___("label_artist") . " | ";;
                    $data['page'] = $this->getTopArtist(true);
                }
                if ($query == 'tracks') {
                    $data['title2'] = ___("label_track") . " | ";;
                    $data['page'] = $this->getTopTracks(true);
                }
                break;

            case 'songInfo':
                $artist = $this->input->get("artist");
                $track = $this->input->get("track");
                if (!$artist && !$track) {
                    $artist = decode(urldecode($query));
                    $track = decode(urldecode($query2));
                }
                $data['search'] = decode(urldecode($query));

                $temp = json_decode(getTrackInfo($artist, $track));

                foreach ($temp->track->album->image as $key => $value) {
                    if ($value->text != '')
                        $data['picture'] = $value->text;
                }
                if ($temp->track->artist->name)
                    $artist = $temp->track->artist->name;
                if ($temp->track->name)
                    $track = $temp->track->name;


                $meta_others[] = array("type" => 'link',
                    "attr" =>
                        array("rel" => 'canonical',
                            "href" => base_url() . "?artist=" . urlencode($artist) . "&track=" . urlencode($track)
                        )
                );


                $data['title2'] = $artist . " - " . $track . " | ";

                if ($data['picture'] == '') {
                    $data['picture'] = "http://i1.ytimg.com/vi/" . $temp->track->video . "/hqdefault.jpg";
                    /*$temp2 					= json_decode(getArtistInfo($artist));
					foreach ($temp2->artist->image as $key => $value) {
						if( $value->text != '')
							$data['picture'] = $value->text;
						}
					*/

                    //$desc2 = $temp2->artist->bio->content;
                }


                $data_temp = json_decode(getLyric($artist, $track));
                $data_temp->lyric = str_replace(array("\n", "\r", "<br>"), '  ', $data_temp->lyric);
                $desc2 = more(ltrim(strip_tags($data_temp->lyric)), 250) . " ";
                $desc2 = str_ireplace("  ", "\n", $desc2);


                if (strlen($desc2) > 100) {
                    $data['description2'] = more(str_ireplace("'", "", str_ireplace('"', "", $desc2)), 250) . " ";
                } else {
                    if (!$temp2)
                        $temp2 = json_decode(getArtistInfo($artist));
                    $desc2 = $temp2->artist->bio->content;
                    $data['description2'] = "(" . $track . " - " . $artist . ") " . more(str_ireplace("'", "", str_ireplace('"', "", $desc2)), 250) . " ";

                }
                if ($data['picture'] == '') {
                    $data['picture'] = base_url() . "assets/images/no-cover.png";
                }


                $data['page'] = $this->getSongInfo($artist, $track, true, $temp2);


                $metatags['twitter:description'] = more(ltrim(strip_tags($desc2)) . " " . $this->config->item("description"), 200);
                $metatags['twitter:title'] = $this->config->item("title");
                $metatags['twitter:card'] = "product";
                $metatags['twitter:image'] = $data['picture'];
                $metatags['twitter:image:width'] = '500';
                $metatags['twitter:image:height'] = '500';
                $metatags['twitter:label1'] = 'Aritst';
                $metatags['twitter:data1'] = mb_strtoupper(decode($artist), 'UTF-8');
                $metatags['twitter:label2'] = 'Track';
                $metatags['twitter:data2'] = mb_strtoupper(decode($track), 'UTF-8');


                if ($temp->track->video && $this->config->item("format_share_fb") == 'video') {


                    $og_fb['og:type'] = "video";
                    $og_fb[0]['og:video:url'] = "https://www.youtube.com/embed/" . $temp->track->video . "?autoplay=1";
                    $og_fb[0]['og:video:secure_url'] = "https://www.youtube.com/embed/" . $temp->track->video . "?autoplay=1";
                    $og_fb[0]['og:video:type'] = "text/html";
                    $og_fb[0]['og:video:width'] = "1280";
                    $og_fb[0]['og:video:height'] = "720";

                    $og_fb[1]['og:video:url'] = "http://www.youtube.com/v/" . $temp->track->video . "?autohide=1&version=3?autoplay=1";
                    $og_fb[1]['og:video:secure_url'] = "https://www.youtube.com/v/" . $temp->track->video . "?autohide=1&version=3?autoplay=1";
                    $og_fb[1]['og:video:type'] = "application/x-shockwave-flash";
                    $og_fb[1]['og:video:width'] = "1281";
                    $og_fb[1]['og:video:height'] = "720";

                    $meta_others[] = array("type" => 'link',
                        "attr" =>
                            array("rel" => 'alternate',
                                "href" => 'ios-app://544007664/vnd.youtube/www.youtube.com/watch?v=' . $temp->track->video
                            )
                    );


                    $og_fb['al:ios:app_store_id'] = "544007664";
                    $og_fb['al:ios:app_name'] = "YouTube";
                    $og_fb['al:ios:url'] = "vnd.youtube://www.youtube.com/watch?v=" . $temp->track->video . "&feature=applinks";

                    $og_fb['al:android:url'] = "vnd.youtube://www.youtube.com/watch?v=" . $temp->track->video . "&feature=applinks";
                    $og_fb['al:android:package'] = "com.google.android.youtube";
                    $og_fb['al:android:app_name'] = "YouTube";


                    $og_fb['al:web:url'] = base_url() . "?artist=" . urlencode($artist) . "&track=" . urlencode($track);


                    $og_fb['og:url'] = base_url() . "?artist=" . urlencode($artist) . "&track=" . urlencode($track);

                    $og_fb['og:image'] = str_ireplace(base_url() . "music/preview?img=", "", $data['picture']);

                    /* if(is_array($temp->track->toptags->tag))
			        	$og_fb['og:video:tag'] 			= $temp->track->toptags->tag[0]->name ;*/

                } else {


                    //$og_fb['og:type'] 					=  "music.song";
                    $og_fb['og:image'] = str_ireplace(base_url() . "music/preview?img=", "", $data['picture']);
                    //$og_fb['music:musician'] 			=  base_url()."artist/".$artist;
                    //$og_fb['music:album:track'] 			=  1;
                    //$og_fb['music:album:url'] 			= base_url()."artist/".encode2($artist);
                }

                $og_fb['og:title'] = urldecode($artist) . " - " . urldecode($track);

                $og_fb['og:description'] = urldecode($track) . ": " . $data['description2'];


                break;
            case 'admin':
                $data['hide_ads'] = TRUE;
                $data['page'] = $this->admin();
                break;
            default:
                $trg = explode("::", $this->config->item("start"));
                if ($this->config->item("start") == "newReleases")
                    $data['page'] = $this->getNewReleases(true);
                if ($this->config->item("start") == "TopArtist")
                    $data['page'] = $this->getTopArtist(true, true);
                if ($this->config->item("start") == "TopArtistCustom")
                    $data['page'] = $this->getTopArtistCustom(true);
                if ($this->config->item("start") == "TopTracks" || $this->config->item("start") == "TopTracksItunes" || $this->config->item("start") == "TopTracksActivity")
                    $data['page'] = $this->getTopTracks(true);
                if ($this->config->item("start") == "Activity")
                    $data['page'] = $this->getActivity(true);
                if ($this->config->item("start") == "SearchBox")
                    $data['page'] = $this->getSearchBox(true);
                if ($trg[0] == "page") {
                    $data['page'] = $this->getPage($trg[1], true);
                }
                if ($trg[0] == "genres") {
                    $data['page'] = $this->getTopTags($trg[1], true);
                }
                if ($trg[0] == "station") {
                    $data['page'] = $this->getStation(intval($trg[1]), true);
                }


                break;
        }


        if ($this->config->item('hide_ads_registered') == '1' && is_logged()) {
            $data['hide_ads'] = true;
        }


        if ($this->config->item("use_database") == 1) {
            $data['pages'] = $this->admin->getTable("pages", false, "title");
        }


        $data['metatags'] = $metatags;
        $data['meta_others'] = $meta_others;
        $data['og_fb'] = $og_fb;

        $template = 'templates/music';

        if (file_exists(APPPATH . "modules/music/views/templates/" . $this->config->item("theme") . EXT)) {
            $template = "templates/" . $this->config->item("theme");
            if (file_exists(APPPATH . "modules/music/views/templates/" . $this->config->item("theme") . "_" . $this->config->item("skin_color") . EXT)) {
                $template = "templates/" . $this->config->item("theme") . "_" . $this->config->item("skin_color");
            }

        }
        if ($this->input->is_ajax_request())
            echo $data['page'];
        else
            $this->load->view($template, $data);
    }


    /* AJAX */
    public function search()
    {
        //$this->output->enable_profiler(TRUE);
        $query = $this->input->get("query");
        $data['search'] = json_decode(searchLastFm($query));
        $data['query'] = $query;
        if ($data['search']->error) {
            show_error($data['search']->message, 401);
        }
        return $this->load->view(getTemplate('search'), $data, $return);
    }

    public function nowPlaying()
    {

        $data['artist'] = urldecode($this->input->post("artist"));
        $data['track'] = urldecode($this->input->post("track"));
        $data['cover'] = urldecode($this->input->post("cover"));

        return $this->load->view(getTemplate('nowPlaying'), $data, $return);
    }

    public function searchArtist()
    {

        $query = $this->input->get("query");
        $data['search'] = json_decode(searchArtist($query));
        $data['query'] = $query;
        $this->load->view(getTemplate('searchArtist'), $data);
    }

    public function getActivity($return = false, $id = 0)
    {
        if ($this->input->post("id"))
            $id = intval($this->input->post("id"));


        //$this->output->enable_profiler(TRUE);
        if ($this->config->item('registration') == "1") {
            $data['icon']['1']['icon'] = "fa-user";
            $data['icon']['1']['color'] = "orange";

            if ($id > 0) {
                $data['idactivity'] = $id;
                $data['activity'] = $this->admin->getActivityUser(false, 1, $id);
            } else
                $data['activity'] = $this->admin->getActivityUser(false, $this->config->item("limit_activity_page"));


            $data['activity_likes'] = $this->admin->getTable('activity_likes', array('iduser' => $this->session->userdata('id')));

            if ($this->input->post("json") == '1') {
                if ($this->config->item("activity_module") != '1')
                    return false;
                $x = 0;
                foreach ($data['activity']->result_array() as $row) {
                    //if($x==0)
                    //{


                    $row['avatar'] = str_ireplace("http://", "", $row['avatar']);
                    $row['avatar'] = str_ireplace("https://", "", $row['avatar']);
                    //$row['avatar'] = base_url().$row['avatar'];
                    if ($row['avatar'] != '')
                        $row['avatar'] = "//" . $row['avatar'];
                    $row['picture'] = str_ireplace(base_url() . "music/preview?img=", "", $row['picture']);
                    if ($this->config->item("use_proxy_images") == '1') {
                        $row['picture'] = base_url() . "music/preview?img=" . $row['picture'];

                    }

                    //$row['avatar'] = $row['picture'];

                    if ($row['avatar'] == '')
                        $row['avatar'] = base_url() . "assets/images/default_avatar.jpg";

                    $row['date'] = ago(strtotime($row['date']));
                    $row['like_btn'] = _like_btn($row['idactivity'], $data['activity_likes'], $row['likes'], $row['iduser']);
                    if ($row['action'] == '1')
                        $json[] = $row;
                    $x++;
                    //}

                }
                $this->output->set_content_type('application/json')->set_output(json_encode($json));
            } else {
                if ($this->config->item("activity_module") == '1')
                    return $this->load->view(getTemplate('activity'), $data, $return);
                else {
                    return $this->getTopTracks();
                }
            }


        } else {
            $trg = explode("-", $this->config->item("start"));
            if ($this->config->item("start") == "TopArtist")
                return $this->getTopArtist($return);
            if ($this->config->item("start") == "topArtistCustom")
                return $this->getTopArtistCustom($return);
            if ($this->config->item("start") == "TopTracks")
                return $this->getTopTracks($return);
            if ($this->config->item("start") == "Activity")
                return $this->getActivity($return);
            if ($this->config->item("start") == "SearchBox")
                return $this->getSearchBox($return);
            if ($trg[0] == "page") {
                return $this->getPage($trg[1], $return);
            }


        }
    }

    function getBrandPage()
    {
        $trg = explode("::", $this->config->item("brand_link"));
        if ($this->config->item("brand_link") == "newReleases")
            $data['page'] = $this->getNewReleases(true);
        if ($this->config->item("brand_link") == "TopArtist")
            $data['page'] = $this->getTopArtist(true);
        if ($this->config->item("brand_link") == "TopArtistCustom")
            $data['page'] = $this->getTopArtistCustom(true);
        if ($this->config->item("brand_link") == "TopTracks" || $this->config->item("brand_link") == "TopTracksItunes" || $this->config->item("brand_link") == "TopTracksActivity")
            $data['page'] = $this->getTopTracks(true);
        if ($this->config->item("brand_link") == "Activity")
            $data['page'] = $this->getActivity(true);
        if ($this->config->item("brand_link") == "SearchBox")
            $data['page'] = $this->getSearchBox(true);
        if ($trg[0] == "page") {
            $data['page'] = $this->getPage($trg[1], true);
        }
        if ($trg[0] == "genres") {
            $data['page'] = $this->getTopTags($trg[1], true);
        }
        echo $data['page'];

    }

    public function SaveDataUser()
    {
        if ($this->session->userdata('username') == 'demo@jodacame.com') {
            echo "Demo Account don't have permission for this action";
            return false;
        }
        if ($this->input->post("nickname")) {
            $nickname = $this->input->post("nickname", true);
            $nickname = str_replace($this->config->item("badwords"), "***", $nickname);
            $nickname = str_replace(" ", "_", $nickname);
            $nickname = trim($nickname);

            $temp = $this->admin->getTable("users", array("nickname" => $nickname));
            if ($temp->num_rows() > 0) {
                echo ___("nickname_already_registered");
            } else {
                if (strlen($nickname) < 5) {
                    echo ___("error_nickname_min");
                } else {
                    if (!in_array($nickname, $this->config->item("badwords")) && strpos($nickname, "***") === FALSE) {
                        if ($this->admin->updateTable("users", array("nickname" => $nickname), array("id" => $this->session->userdata('id')))) {
                            $this->session->set_userdata("nickname", $nickname);
                            echo "1";
                        } else
                            echo ___("msg_error_500");
                    } else {
                        echo ___("msg_error_bad_words");
                    }

                }
            }
        }
        if ($this->input->post("bio")) {
            $bio = $this->input->post("bio", true);
            $bio = str_replace($this->config->item("badwords"), "***", $bio);
            if (!in_array($bio, $this->config->item("badwords"))) {
                if ($this->admin->updateTable("users", array("bio" => $bio), array("id" => $this->session->userdata('id')))) {
                    $this->session->set_userdata("bio", $bio);
                    echo "1";
                } else
                    echo ___("msg_error_500");
            } else {
                echo ___("msg_error_bad_words");
            }
        }
        if ($this->input->post("publicST") == '1') {
            $publicS = intval($this->input->post("publicS", true));
            if ($this->admin->updateTable("users", array("activity_global" => $publicS), array("id" => $this->session->userdata('id')))) {
                $this->session->set_userdata("publicS", $publicS);
                echo "1";
            } else
                echo ___("msg_error_500");
        }

        if ($this->input->post("public_chat_save")) {
            $public_chat = intval($this->input->post("public_chat", true));
            if ($this->admin->updateTable("users", array("public_chat" => $public_chat), array("id" => $this->session->userdata('id')))) {
                $this->session->set_userdata("public_chat", $public_chat);
                echo "1";
            } else
                echo ___("msg_error_500");
        }
        if ($this->input->post("biography_lang_save")) {
            $biography_lang = $this->input->post("biography_lang", true);
            if ($this->admin->updateTable("users", array("biography_lang" => $biography_lang), array("id" => $this->session->userdata('id')))) {
                $this->session->set_userdata("biography_lang", $biography_lang);
                echo "1";
            } else
                echo ___("msg_error_500");
        }

        if ($this->input->post("newsletter_save")) {
            $newsletter = $this->input->post("newsletter", true);
            if ($this->admin->updateTable("users", array("newsletter" => $newsletter), array("id" => $this->session->userdata('id')))) {
                $this->session->set_userdata("newsletter", $newsletter);
                echo "1";
            } else
                echo ___("msg_error_500");
        }
        if ($this->input->post("auto_fb_wall_save")) {
            $auto_fb_wall = $this->input->post("auto_fb_wall", true);
            if ($this->admin->updateTable("users", array("auto_fb_wall" => $auto_fb_wall), array("id" => $this->session->userdata('id')))) {
                $this->session->set_userdata("auto_fb_wall", $auto_fb_wall);
                echo "1";
            } else
                echo ___("msg_error_500");
        }


    }

    public function profile($nickname = 'fake', $return = false)
    {

        if ($this->config->item("use_database") == "0")
            show_404();
        if ($nickname == "fake" || $nickname == '0')
            $nickname = $this->session->userdata('nickname');
        $nickname = urldecode($nickname);
        $temp = $this->admin->getTable("users", array("nickname" => ($nickname)));
        if ($temp->num_rows() == 0)
            show_404();
        $temp = $temp->result();
        $temp = $temp[0];
        $data['user'] = $temp;
        $data['icon']['1']['icon'] = "fa-user";
        $data['icon']['1']['color'] = "orange";
        $data['activity'] = $this->admin->getActivityUser($temp->id, $this->config->item("limit_activity_profile"));

        $data['playlist'] = $this->admin->getTable("playlist", array("iduser" => $temp->id));
        $data['activity_like'] = $this->db->query("SELECT activity_likes.date as date2,activity.*,users.* from activity_likes,activity,users where activity_likes.iduser= " . $temp->id . " and users.id = activity.iduser and activity_likes.idactivity = activity.idactivity order by activity.date desc limit 5");
        $data['activity_like_you'] = $this->db->query("SELECT activity_likes.date AS date2, activity.* ,users.* 
										FROM activity_likes, activity, users
										WHERE activity.iduser =" . $temp->id . "
										AND users.id = activity_likes.iduser
										AND activity_likes.idactivity = activity.idactivity
										ORDER BY activity.date DESC 
										LIMIT 5");


        return $this->load->view(getTemplate('profile'), $data, $return);
    }

    public function edit_playlist($id = false, $return = false)
    {

        $idplaylist = intval($this->input->post("id"));
        if ($id)
            $idplaylist = $id;
        $temp = $this->admin->getTable("playlist", array("idplaylist" => $idplaylist));
        if ($temp->num_rows() == 0)
            show_404();

        $data['playlist'] = $temp;
        return $this->load->view(getTemplate('edit_playlist'), $data, $return);
    }


    public function getYoutube()
    {
        $json['ads'] = '';
        $adsActive = false;
        $ads = explode(",", $this->config->item("audio_ads"));
        if (count($ads) > 0) {
            $json['rand'] = rand(0, intval($this->config->item('factor_ads')));
            if (is_logged() && $this->config->item("hide_ads_registered") == '1') {
                $json['rand'] = 0;
            }
            if ($json['rand'] == '1' && $this->session->userdata('ads') != '1') {

                $this->session->set_userdata("ads", '1');
                $json['ads'] = $ads[rand(0, count($ads) - 1)];

            } else {
                $this->session->set_userdata("ads", '0');
            }
        }

        $track = $this->input->get("track");
        $artist = $this->input->get("artist");
        $picture = base64_decode($this->input->get("picture"));
        $picture = str_ireplace(base_url() . "music/preview?img=", "", $picture);
        //$replace = array('http://','https://','ftp://','ftps://','smtp://','sftp;//');
        //$picture 			= str_ireplace($replace, "", $picture);
        //$picture 			= "http://".$picture;
        //$picture 			= str_ireplace("preview?img=", "preview?img=http://", $picture);

        $track = urlencode(ltrim(($track)));
        $artist = urlencode(ltrim(($artist)));
        $data = json_decode(searchYoutube($artist, $track));

        if (!$data->error) {
            $json['id'] = get_video_id($data);
            if ($json['id'] == '' || $json['id'] == 'null') {
                $this->admin->updateTable('tracks', array('reported' => '1'), array('artist' => urldecode($artist), 'track' => urldecode($track)));
                $json['id'] = $this->config->item("custom_video_error");
                sleep(1);
            } else {
                if ($this->session->userdata('activity') != date("Y-m-d H:i") && is_logged() && $this->config->item("activity_module") == '1') {
                    $this->session->set_userdata("activity", date("Y-m-d H:i"));
                    if ($this->config->item("use_database") == "1") {
                        $this->admin->setTable("activity", array("picture" => $picture, "youtube" => $json['id'], "track" => decode($track), "artist" => decode($artist), "date" => date("Y-m-d H:i:s"), "action" => "1", "iduser" => $this->session->userdata('id')));
                    }

                }

                /*if($this->session->userdata('activity_fb') != date("Y-m-d H") && is_logged())
					{

							$this->session->set_userdata("activity_fb",date("Y-m-d H"));
							$post['picture'] 	= base_url()."music/preview?img=".urlencode($picture);
							$post['artist'] 	= decode($artist);
							$post['track'] 		= decode($track);
							$post['youtube'] 	= $json['id'];
							$post['iduser'] 	= $this->session->userdata('id');
							if(rand(0,10) == 1)
								__fb_post($post);

					}*/


            }
        } else {
            $json = $data;
        }
        if (!is_ok($this->config->item("purchase_code"))) {
            $json = array();
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function getRelated($track, $artist, $index = 0)
    {
        sleep(3); // Wait 3 seconds
        $track = $this->input->get("track");
        $artist = $this->input->get("artist");
        $track = urlencode(ltrim(($track)));
        $artist = urlencode(ltrim(($artist)));
        $data = json_decode(getSimilar($artist, $track));
        $index = $index + 3;
        /*if($index == 1)
			$index = rand(5,8);
		if($index == 2)
			$index = rand(0,4);
		if($index == 3)
			$index = rand(13,16);
		if($index == 4)
			$index = rand(9,12);
		if($index == 5)
			$index = rand(14,20);
		if($index > 6)
			$index = rand(0,20);*/
        $data = $data->similartracks->track[$index];
        $output['track'] = $data->name;
        $output['artist'] = $data->artist->name;
        $image = $data->image[3]->text;
        $output['source'] = "Related Track";
        if ($output['track'] == '') {
            $index = $index - 3;
            $top = json_decode(getTopTracks($artist));
            $output['track'] = $top->toptracks->track[$index]->name;
            $output['artist'] = $top->toptracks->track[$index]->artist->name;
            $image = $top->tracks->toptracks[$index]->image[3]->text;
            if ($output['track'] != '') {
                $track = ltrim($output['track']);
                $artist = ltrim($output['artist']);
                $data = json_decode(getSimilar($artist, $track));
                $data = $data->similartracks->track[$index];
                $output['track'] = $data->name;
                $output['artist'] = $data->artist->name;
                $image = $data->image[3]->text;
                $output['source'] = "Related Track 2";
            }

            if ($output['track'] == '') {
                sleep(3);
                $index = $index + 3;
                $top = json_decode(getTopTracks($artist));
                $output['track'] = $top->toptracks->track[$index]->name;
                $output['artist'] = $top->toptracks->track[$index]->artist->name;
                $image = $top->tracks->toptracks[$index]->image[3]->text;
                $output['source'] = "Top Artist";
            }
        }

        if ($image == '')
            $image = base_url() . "assets/images/no-cover.png";
        $output['cover'] = $image;
        $output['key2'] = sha1($output['track'] . $output['artist']);
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function getTopArtist($return = false, $home = false)
    {

        $show = $this->config->item("top_artist_menu");
        if ($home) {
            $show = $this->config->item("start");
        }
        if ($show == "TopArtistCustom") {
            return $this->getTopArtistCustom($return);
        } else {
            $data['top'] = json_decode(getTopArtist());
            if (count($data['top']->artists->artist) <= 1) {
                $this->config->set_item("auto_country", '0');
                $data['top'] = json_decode(getTopArtist());
            }
            return $this->load->view(getTemplate('topArtist'), $data, $return);

        }

    }

    public function getStations($return = false)
    {
        $data['stations'] = getStations();
        return $this->load->view(getTemplate($this->config->item("stations_style")), $data, $return);
    }

    public function getStation($id = false, $return = false)
    {
        if (!$id)
            $id = intval($this->input->post("id"));
        $data['station'] = getStations(array("idtstation" => $id));
        return $this->load->view(getTemplate('station'), $data, $return);
    }

    public function getTopArtistCustom($return, $page = false)
    {
        $data['top'] = getCustomTopArtist();
        $data['page'] = $page;
        return $this->load->view(getTemplate('topArtistCustom'), $data, $return);
    }

    public function getNewReleases($return = false)
    {
        $data['releases'] = simplexml_load_string(getNewReleases(), null, LIBXML_NOCDATA);

        return $this->load->view(getTemplate('newReleases'), $data, $return);
    }

    public function getTopTracks($return = false, $page = false)
    {
        $data['page'] = $page;
        if ($this->config->item("top_tracks_link") == "TopTracksItunes") {
            $data['top'] = json_decode(getTopSongsItunes());
            return $this->load->view(getTemplate('topTracksItunes'), $data, $return);
        } else {
            if ($this->config->item("top_tracks_link") == "TopTracksActivity") {
                $data['top'] = $this->admin->getTopTrackActivity();
                return $this->load->view(getTemplate('topTracksActivity'), $data, $return);
            } else {
                $data['top'] = json_decode(getTopTracks());
                if (count($data['top']->tracks->track) <= 1) {
                    $this->config->set_item("auto_country", '0');
                    $data['top'] = json_decode(getTopTracks());
                }
                return $this->load->view(getTemplate('topTracks'), $data, $return);
            }
        }


    }

    public function getTopTags($tag, $return = false)
    {
        if ($tag != "" && $tag != 'all') {
            $data['top'] = json_decode(getTopTags($tag));
            $data['title'] = ucwords(urldecode($tag));
            return $this->load->view(getTemplate('topTags'), $data, $return);
        } else {
            return $this->load->view(getTemplate('topTagsList'), $data, $return);
        }

    }

    public function getArtistInfo($artist, $return = false)
    {

        if ($this->input->get("artist") != '')
            $artist = $this->input->get("artist");
        $data['artist'] = json_decode(getArtistInfo($artist));
        $data['query']['artist'] = $artist;
        $data['toptracks'] = json_decode(getTopTracks($artist));
        return $this->load->view(getTemplate('artistInfo'), $data, $return);
    }

    public function getSongInfo($artist = false, $track = false, $return = false, $extra = false)
    {

        if ($this->input->post("artist") != '') {
            $artist = $this->input->post("artist");
        }
        if ($this->input->post("track") != '') {
            $track = $this->input->post("track");
        }

        $data['song'] = json_decode(getTrackInfo($artist, $track));
        $data['lyrics'] = json_decode(getLyric($artist, $track));
        if ($extra) {
            $data['artist'] = $extra;
        } else {
            $data['artist'] = json_decode(getArtistInfo($artist));

        }

        $data['toptracks'] = json_decode(getTopTracks($artist));
        return $this->load->view(getTemplate('songInfo'), $data, $return);
    }

    public function getAlbums($artist, $return = false)
    {

        if (!$artist)
            $artist = $this->input->get("artist");


        $data['artist'] = json_decode(getArtistInfo($artist));
        $data['albums'] = json_decode(getAlbums($artist));
        return $this->load->view(getTemplate('albums'), $data, $return);
    }

    public function getEvents($artist)
    {

        $artist = $this->input->get("artist");
        $data['events'] = json_decode(getEvents($artist));
        $data['artist'] = $artist;
        $this->load->view(getTemplate('events'), $data);
    }

    public function getTracksAlbums($artist, $album, $return = false)
    {
        /*if (!$this->input->is_ajax_request()) {
   			show_404();
			exit;
		}*/
        //if(!$artist)
        $artist = $this->input->get("artist");
        //if(!$album)
        $album = $this->input->get("album");
        $data['album'] = json_decode(getTracksAlbums($album, $artist));
        return $this->load->view(getTemplate('TracksAlbum'), $data, $return);
    }

    public function getSearchBox($return = false)
    {


        return $this->load->view(getTemplate('searchBox'), $data, $return);
    }

    public function getLyric($artist = false, $track = false, $return = false)
    {
        if (!$return) {
            if (!$this->input->is_ajax_request()) {
                show_404();
                exit;
            }
        }

        if (!$artist && !$track) {
            $artist = $this->input->get("artist");
            $track = $this->input->get("track");
        }

        $data['lyrics'] = json_decode(getLyric($artist, $track));
        $data['title'] = $artist . " - " . $track;
        $data['artist'] = $artist;
        $data['track'] = $track;
        $ytb = json_decode(searchYoutube($artist, $track . " lyric"));
        $data['id'] = get_video_id($ytb);

        return $this->load->view(getTemplate('lyrics'), $data, $return);
    }

    public function getPage($id, $return = false)
    {
        for ($x = 0; $x <= 10; $x++)
            $number[] = $x;
        $rand1 = rand(0, count($number) - 1);
        $rand2 = rand(0, count($number) - 1);
        $r = intval($number[$rand1]) + intval($number[$rand2]);

        $this->session->set_userdata('captcha', $r);
        $this->session->set_userdata('captcha1', $rand1);
        $this->session->set_userdata('captcha2', $rand2);

        $data['page'] = $this->admin->getTable("pages", array("idpage" => intval($id)), "title");
        if ($data['page']->num_rows() == 0)
            show_404();
        return $this->load->view(getTemplate('page'), $data, $return);
    }

    public function likeActivity()
    {
        $id = intval($this->input->post("id"));
        $iduser = intval($this->input->post("iduser"));
        if ($id > 0 and intval($this->session->userdata('id')) > 0 && $iduser > 0)
            $t = $this->admin->setLike($id, $iduser);


    }

    public function report()
    {
        if (is_logged()) {
            $artist = $this->input->post("artist");
            $track = $this->input->post("track");
            $this->admin->updateTable('tracks', array('reported' => '1'), array('artist' => urldecode($artist), 'track' => urldecode($track)));
        }


    }

    public function myPlaylist($json = false, $return = false)
    {

        if (!is_logged()) {
            show_404();
            exit;
        }
        $data['myplaylist'] = $this->admin->getTable("playlist", array("iduser" => $this->session->userdata('id')));
        $data['spotify'] = $this->admin->getTable("token_spotify", array("iduser" => $this->session->userdata('id')));
        if (!$json) {
            return $this->load->view(getTemplate('myPlaylist'), $data, $return);
        } else {

            foreach ($data['myplaylist']->result() as $row) {
                echo "<li ><a data-action='addto' data-id='{$row->idplaylist}' href='#'>{$row->name}</a></li>";
            }


        }

    }

    public function saveAvatar()
    {

        if (!file_exists("avatars")) {
            mkdir("avatars");
        }

        $avatar = addslashes($this->input->post("avatar", false));
        $file = "avatars/" . sha1($this->config->item("encryption_key") . $this->session->userdata('id')) . ".jpg";
        base64_to_jpeg($avatar, $file);
        $config['image_library'] = 'gd2';
        $config['source_image'] = $file;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 360;
        $config['height'] = 360;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
        $this->admin->updateTable("users", array("avatar" => base_url() . $file), array("id" => $this->session->userdata('id')));

    }

    public function uploadAvatar()
    {


        if (!file_exists("avatars")) {
            mkdir("avatars");
        }


        $config['upload_path'] = './avatars/';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = '1024';
        $config['max_width'] = '2000';
        $config['max_height'] = '2000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('upload')) {
            $error = array('error' => $this->upload->display_errors());
            redirect(base_url() . 'user/' . $this->session->userdata('nickname'), 'location');
        } else {
            $data = $this->upload->data();
            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = './avatars/' . $data['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 300;
            $config['height'] = 300;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $file = sha1($this->config->item("encryption_key") . $this->session->userdata('id')) . $data['file_ext'];
            rename('./avatars/' . $data['file_name'], './avatars/' . $file);
            $this->admin->updateTable("users", array("avatar" => base_url() . 'avatars/' . $file), array("id" => $this->session->userdata('id')));
            $this->session->set_userdata("avatar", base_url() . 'avatars/' . $file);
            redirect(base_url() . 'user/' . $this->session->userdata('nickname'), 'location');
        }

    }

    public function updatePlaylist()
    {
        if (!is_logged()) {
            show_404();
            exit;
        }
        $playlist = $this->input->post("playlist");
        $id = intval($this->input->post("id"));
        if ($this->db->update("playlist", array("json" => $playlist), array("iduser" => $this->session->userdata('id'), "idplaylist" => $id)))
            $json['msg'] = ___("msg_playlist_updated");
        else
            $json['msg'] = ___("error_500");
        $this->output->set_content_type('application/json')->set_output(json_encode($json));

    }

    public function savePlayList()
    {

        if (!is_logged()) {
            show_404();
            exit;
        }


        $action = intval($this->input->post("action"));


        // New
        if ($action == 1) {
            $name = $this->input->post("name", TRUE);
            $external_id = $this->input->post("external_id", TRUE);
            if ($external_id) {
                $this->admin->deleteTable("playlist", array("external_id" => $external_id));
            }
            $playlist = $this->input->post("playlist", TRUE);
            $playlist2 = json_decode($playlist);

            if (count($playlist2) > 0 || 1 == 1) {
                $data['name'] = $name;
                $data['iduser'] = $this->session->userdata('id');
                $data['json'] = $playlist;
                $data['type'] = $this->input->post("type", TRUE);
                $data['external_id'] = $this->input->post("externalid", TRUE);
                $data['external_owner'] = $this->input->post("owner", TRUE);
                $json['error'] = "0";
                $json['msg'] = ___("msg_playlist_saved");
                $id = $this->admin->setTable("playlist", $data);
                if ($this->session->userdata('activity') != date("Y-m-d H:i") && is_logged()) {
                    //$this->session->set_userdata("activity",date("Y-m-d H:i"));
                    //$this->admin->setTable("activity",array("date"=> date("Y-m-d H:i:s"),"action" => "2","iduser" => $this->session->userdata('id')));
                }
                if ($id) {
                    $json['id'] = $id;
                    $json['name'] = more($name, 20);
                }

            } else {
                $json['error'] = "1";
                $json['msg'] = ___("error_playlist_empty");
            }
        }

        // Update
        if ($action == 2) {
            $id = intval($this->input->post("id", TRUE));
            $playlista = json_decode($this->input->post("playlist", TRUE));


            $playlist = $this->admin->getTable("playlist", array("iduser" => $this->session->userdata('id'), "idplaylist" => $id));
            $playlist = $playlist->result_array();
            $playlist2 = json_decode($playlist[0]['json']);
            $playlistok = array_merge($playlist2, $playlista);


            if (intval(count($playlist2) + count($playlista)) <= 500) {
                if (count($playlistok) > 0) {


                    $data['json'] = json_encode($playlistok);
                    $json['error'] = "0";
                    $json['msg'] = ___("msg_playlist_saved");
                    $json['title'] = "<br>" . ___("label_playlist");
                    $json['content'] = "<br><strong>" . stripslashes($playlista[0]->track) . "</strong><br><span class='text-muted'>" . stripslashes($playlista[0]->artist) . "</span>";
                    $json['image'] = $playlista[0]->cover;
                    $this->admin->updateTable("playlist", $data, array("iduser" => $this->session->userdata('id'), "idplaylist" => $id));
                } else {
                    $json['error'] = "1";
                    $json['msg'] = ___("error_playlist_empty");
                }

            } else {
                $json['error'] = "1";
                $json['msg'] = ___("error_folder_max");
            }

        }

        // Update
        if ($action == 3) {
            $id = intval($this->input->post("id", TRUE));

            if (count($id) > 0) {
                $json['error'] = "0";
                $json['msg'] = ___("msg_playlist_saved");
                $this->admin->deleteTable("playlist", array("iduser" => $this->session->userdata('id'), "idplaylist" => $id));
            } else {
                $json['error'] = "1";
                $json['msg'] = ___("error_500");
            }


        }


        $this->output->set_content_type('application/json')->set_output(json_encode($json));

    }


    public function admin()
    {
        if ($this->config->item("use_database") == 0) {
            show_404();
            exit;
        }

        if ($this->session->userdata('is_admin') == 1) {
            return $this->load->view('dashboard/admin', NULL, true);
        } else {
            if (!is_logged())
                return $this->load->view('dashboard/login', NULL, true);
            else {
                show_404();
            }
        }
    }


    public function exportPlayList()
    {
        $this->load->helper('download');
        $list = $this->input->post("list");

        force_download("playlist.json", $list);
    }

    public function typeahead()
    {
        $query = $this->input->get("query", true);
        $json = json_decode(searchLastFm($query));
        $x = 0;
        foreach ($json->results->trackmatches->track as $key => $value) {
            if ($value->image[0]->text != '') {
                $data[$x]['image'] = $value->image[0]->text;
                $data[$x]['artist'] = $value->artist;
                $data[$x]['name'] = $value->name;
                $data[$x]['value'] = $value->name . ' - ' . $value->artist;
                $x++;
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function registerUser()
    {

        $email = addslashes($this->input->post("email", TRUE));
        $pwd1 = $this->input->post("pwd1", TRUE);
        $pwd2 = $this->input->post("pwd2", TRUE);
        $nickname = $this->input->post("nick", TRUE);
        $nickname = str_replace($this->config->item("badwords"), "_REMOVED_", $nickname);
        $nickname = str_replace(" ", "_", $nickname);
        $nickname = trim($nickname);

        $temp = $this->admin->getTable("users", array("nickname" => $nickname));
        if ($temp->num_rows() > 0) {
            $json["error"] = 1;
            $json["msg"] = ___("nickname_already_registered") . " ($nickname)";
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
            return false;
        } else {
            if (strlen($nickname) < 5) {
                $json["error"] = 1;
                $json["msg"] = ___("error_nickname_min") . " ($nickname)";
                $this->output->set_content_type('application/json')->set_output(json_encode($json));
                return false;
            }
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $json["error"] = 1;
            $json["msg"] = ___("msg_email_not_valid") . " ($email)";
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
            return false;
        }

        if ($pwd1 != $pwd2) {
            $json["error"] = 1;
            $json["msg"] = ___("msg_password_doesnt_match");
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
            return false;
        }

        if (strlen(trim($pwd1)) < 4) {
            $json["error"] = 1;
            $json["msg"] = ___("msg_password_min_characters");
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
            return false;
        }

        $user = $this->admin->getTable("users", array('username' => $email));
        if ($user->num_rows > 0) {
            $json["error"] = 1;
            $json["msg"] = ___("msg_email_already_registered");
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
            return false;
        }

        $data['password'] = sha1($pwd1);
        $data['username'] = $email;
        $temp = explode("@", $email);
        $data['names'] = $temp[0];
        //$nickname 			= $temp[0].strtoupper(random_string('alnum', 5));
        //$data['nickname']	= strtolower($nickname);
        $data['avatar'] = base_url() . "assets/images/default_avatar.jpg";
        $data['nickname'] = $nickname;
        $id = $this->admin->setTable("users", $data);
        $user = $this->admin->getTable("users", array('id' => $id, 'password' => $data['password'], 'username' => $data['username']));
        if ($user->num_rows > 0) {

            $data = $user->result_array();
            $this->session->set_userdata($data[0]);
            $json["error"] = 0;
            $json["target"] = base_url() . "user/" . $nickname;
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
            return false;

        } else {
            $json["error"] = 1;
            $json["msg"] = ___("msg_error_500");
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
            return false;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));

    }

    public function login()
    {

        $username = addslashes($this->input->post("email", TRUE));
        $password = sha1($this->input->post("pwd1", TRUE));
        if ($username && $password) {
            $user = $this->admin->getTable("users", array('username' => $username, 'password' => $password));
            if ($user->num_rows == 0) {
                $user = $this->admin->getTable("users", array('nickname' => $username, 'password' => $password));
            }
            if ($user->num_rows > 0) {
                $data = $user->result_array();
                //unset($data[0]['avatar']);
                if (strlen($data[0]['avatar']) > 500 || strlen($data[0]['avatar']) <= 5)
                    $data[0]['avatar'] = base_url() . "assets/images/default_avatar.jpg";
                $this->session->set_userdata($data[0]);
                $json["error"] = 0;

            } else {
                $json["error"] = 1;
                $json["msg"] = ___("error_login");

            }
        } else {
            $json["error"] = 1;
            $json["msg"] = ___("error_login");
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    function logout()
    {
        $fb = $this->session->userdata('facebook');
        $sp = $this->session->userdata('spotify');
        $iduser = $this->session->userdata('id');
        $this->admin->deleteTable('online', array('iduser' => $this->session->userdata('id')));
        $this->session->unset_userdata('id');
        $this->session->sess_destroy();
        if ($fb == '1') {
            $this->admin->deleteTable("token_facebook", array("iduser" => $iduser));
            header('Location: ' . base_url());
            die();
        }
        if ($sp != '') {
            header('Location: ' . base_url() . "spotify/logout/" . $sp);
            die();
        } else {
            header('Location: ' . base_url());
            die();
        }
    }

    function reload()
    {
        header('Location: ' . base_url());
    }

    function recovery($sha1 = '')
    {

        if ($this->session->userdata('username') == 'demo@jodacame.com') {
            return false;
        }

        if ($sha1 != '') {
            if (strlen($sha1) > 40 || strlen($sha1) < 38 || $sha1 == sha1('')) {
                show_404();
                exit;
            }
        }


        if ($sha1 == '') {

            $email = addslashes($this->input->post("email", TRUE));
            $user = $this->admin->getTable("users", array('username' => $email));
            if ($user->num_rows > 0) {
                $this->load->helper('string');
                $data['password'] = random_string('alnum', 10);
                $data['link'] = base_url() . "music/recovery/" . sha1($data['password']);
                $this->email->from($this->config->item("contact_email"), $this->config->item("title"));
                $this->email->to($email);
                $this->email->subject(___('email_subject') . " - " . $this->config->item("title"));
                $emailTemplate = $this->load->view('email/email', $data, true);
                $this->email->message($emailTemplate);
                if ($this->email->send()) {
                    $dataBD['recovery'] = sha1($data['password']);
                    $this->admin->updateTable("users", $dataBD, array("username" => $email));
                    $json["error"] = 0;
                    $json["msg"] = ___("email_check_email");
                } else {
                    $json["error"] = 1;
                    $json["msg"] = ___("msg_error_500");
                }

            } else {
                $json["error"] = 1;
                $json["msg"] = ___("error_email_nofound");
            }
        } else {
            $user = $this->admin->getTable("users", array('recovery' => $sha1));
            if ($user->num_rows > 0) {
                $data = $user->result_array();
                if ($data[0]['recovery'] == '') {
                    show_404();
                    exit;
                } else {
                    $dataBD['password'] = $sha1;
                    $dataBD['recovery'] = '';
                    $this->admin->updateTable("users", $dataBD, array("recovery" => $sha1));
                    redirect(base_url() . "#!/login", "refresh");
                }

            } else {
                show_404();
                exit;
            }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function updatePassword()
    {

        if ($this->session->userdata('username') == 'demo@jodacame.com') {
            return false;
        }
        $password1 = sha1($this->input->post("password1", TRUE));
        $password2 = sha1($this->input->post("password2", TRUE));


        if ($password1 != $password2) {
            $json['error'] = "1";
            $json['msg'] = ___("error_password_match");
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
            return;
        }

        if (strlen($password1) < 4) {
            $json['error'] = "1";
            $json['msg'] = ___("error_password_min");
            $this->output->set_content_type('application/json')->set_output(json_encode($json));
            return;
        }

        if ($this->session->userdata('username') != '') {
            $this->admin->updateTable("users", array("password" => $password1), array("username" => $this->session->userdata('username')));
        } else {
            show_404();
        }

        $json['error'] = "0";
        $json['msg'] = ___("msg_password_updated");
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
        return;


    }

    function update_folder()
    {
        $id = intval($this->input->post('id'));
        $name = $this->input->post('name');
        if ($this->admin->updateTable("playlist", array("name" => $name), array("iduser" => $this->session->userdata('id'), "idplaylist" => $id))) {
            $json['title'] = ___("msg_playlist_updated");
            $json['content'] = $name;
        } else {
            $json['title'] = ___("msg_error_500") . $this->db->last_query();
            $json['content'] = $name;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    function getPlayList($hash = "fake")
    {
        $data['myplaylist'] = $this->admin->getTable("playlist", array("sha1(CONCAT('" . $this->config->item("encryption_key") . "',idplaylist))" => $hash));
        $json = json_encode(array());
        if ($data['myplaylist']->num_rows > 0) {

            $temp = $data['myplaylist']->result_array();
            $json = $temp[0]['json'];
        }


        $this->output->set_content_type('application/json')->set_output($json);
    }

    function getPlayListID($id)
    {
        $data['myplaylist'] = $this->admin->getTable("playlist", array("idplaylist" => $id));
        $json = json_encode(array());
        if ($data['myplaylist']->num_rows > 0) {

            $temp = $data['myplaylist']->result_array();
            $json = $temp[0]['json'];
        }


        $this->output->set_content_type('application/json')->set_output($json);
    }


    function loadPlaylistArtist()
    {
        $artist = $this->input->post('artist', true);
        $playlist = json_decode(loadPlaylistArtist($artist));
        $pl = array();
        foreach ($playlist->toptracks->track as $key => $value) {
            foreach ($value->image as $k => $v) {
                $image = $v->text;
            }

            if ($image != '') {
                $image_ok = $image;
                if ($this->config->item("use_proxy_images") == '1') {

                    $image = base_url() . "music/preview?img=" . $image;

                }
            }
            if ($image == '')
                $image = $image = base_url() . "assets/images/no-cover.png";
            if (strlen($value->name) > 3)
                $pl[] = array('track' => $value->name, 'artist' => $value->artist->name, 'cover' => $image, 'key' => sha1($value->name));
        }
        shuffle($pl);

        if ($this->session->userdata('activity') != date("Y-m-d H:i") && is_logged() && $this->config->item("activity_module") == '1') {
            $this->session->set_userdata("activity", date("Y-m-d H:i"));
            if ($this->config->item("use_database") == "1") {
                $this->admin->setTable("activity", array("picture" => $image_ok, "youtube" => '', "track" => '', "artist" => urldecode($artist), "date" => date("Y-m-d H:i:s"), "action" => "3", "iduser" => $this->session->userdata('id')));
            }

        }

        $this->output->set_content_type('application/json')->set_output(json_encode($pl));
    }

    function sendEmail()
    {
        $from = $this->input->post("from", TRUE);
        $subject = $this->input->post("subject", TRUE);
        $message = $this->input->post("message", TRUE);
        $captcha = $this->input->post("captcha", TRUE);
        $name = $this->input->post("name", TRUE);

        $this->email->from($this->config->item("contact_email"), $this->config->item("title"));
        $this->email->reply_to($from, $name);
        $this->email->to($this->config->item("contact_email2"));
        $this->email->subject($this->config->item("title") . ' - ' . $subject);
        $this->email->message($message . "<br><br>" . $name . "<br>" . $from . "<br>" . $this->session->userdata('nickname'));


        $json = array();
        if ($this->session->userdata('captcha') == $captcha && $captcha != '') {
            if ($this->email->send()) {
                $json['error'] = '0';
                $json['msg'] = ___('contact_form_success');
            } else {
                $json['error'] = '1';
                $json['msg'] = ___('contact_form_error_500');
            }
        } else {
            $json['error'] = '1';
            $json['msg'] = ___('contact_form_error_captcha');
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));


    }

    function download_itunes()
    {
        $query = decode(urlencode($this->input->get("q", TRUE)));
        $artist = urldecode($this->input->get("a", TRUE));
        $track = urldecode($this->input->get("t", TRUE));
        setDownload($artist, $track, '', 'itunes');
        $json = search_itunes($query);
        $json = json_decode($json);
        if ($json->resultCount > 0) {
            $url_redirect = $json->results[0]->trackViewUrl;

        } else {
            $query = (decode($query));
            $url_redirect = "http://www.apple.com/search/?section=itunes&geo=" . $this->config->item("itunes_country") . "&q=$query";
        }

        if ($this->config->item("adfly_itunes") == '1' && $this->config->item("adfly_key") != '' && $this->config->item("adfly_uid")) {
            $url_redirect = adfly($url_redirect, $artist . " - " . $track, $this->config->item("adfly_key"), $this->config->item("adfly_uid"));

        }
        redirect($url_redirect, 'location');


    }

    function download_amazon()
    {

        $query = decode(urlencode($this->input->get("q", TRUE)));
        $artist = urldecode($this->input->get("a", TRUE));
        $track = urldecode($this->input->get("t", TRUE));
        setDownload($artist, $track, '', 'amazon');

        $url_redirect = $this->config->item("amazon_site") . "/gp/search?ie=UTF8&camp=1789&creative=9325&index=music&keywords=$query&linkCode=ur2&tag=" . $this->config->item("amazon_afiliate");
        if ($this->config->item("adfly_amazon") == '1' && $this->config->item("adfly_key") != '' && $this->config->item("adfly_uid")) {
            $url_redirect = adfly($url_redirect, $artist . " - " . $track, $this->config->item("adfly_key"), $this->config->item("adfly_uid"));

        }

        redirect($url_redirect, 'location');

    }

    function download_mp3()
    {
        $query = decode(urlencode($this->input->get("q", TRUE)));

        $artist = urldecode($this->input->get("a", TRUE));
        $track = urldecode($this->input->get("t", TRUE));
        $data = json_decode(searchYoutube($artist, $track));
        setDownload($artist, $track, '', 'mp3');

        $videoID = get_video_id($data);

        $video = "https://www.youtube.com/watch?v=" . $videoID;
        $download_service = $this->config->item("download_service");
        $download_service = str_ireplace("%youtube_url%", $video, $download_service);
        $download_service = str_ireplace("%youtube_video%", $videoID, $download_service);
        if ($videoID == '') {
            redirect("http://www.youtube.com/results?search_query=$query", 'location');
        } else {
            if ($this->config->item("adfly_downloads") == '1' && $this->config->item("adfly_key") != '' && $this->config->item("adfly_uid")) {
                $download_service = adfly($download_service, $artist . " - " . $track, $this->config->item("adfly_key"), $this->config->item("adfly_uid"));

            }
            redirect($download_service, 'location');
        }
    }

    public function newsletter($key)
    {
        @ini_set('max_execution_time', 0);
        $example = $this->input->get('example', TRUE);
        $userTemp = $this->input->post('target', TRUE);

        if ($key != $this->config->item("newsletter_key"))
            show_error("Key No Found!", 403);

        $data['topA'] = $this->admin->getTopArtistActivity();
        $data['top'] = $this->admin->getTopTrackActivity();
        $data['activity'] = $this->admin->getActivityUser(false, 4);

        if ($example)
            $users = $this->admin->getTable("users", array("is_admin" => '1'));
        else {
            if ($userTemp)
                $users = $this->admin->getTable("users", array('username' => $userTemp));
            else
                $users = $this->admin->getTable("users", false);
        }

        $json['error'] = '1';
        foreach ($users->result() as $row) {


            if ($example)
                $row->username = $example;
            if ($row->username != '') {
                $temp = $this->admin->getActivityUser($row->username, 50);
                if ($temp->num_rows() > 0) {
                    $tracks = $temp->result_array();
                    $temp = $tracks[rand(0, count($tracks))];
                    //$data['similar'] 	= json_decode(getSimilar($temp['artist'],$temp['track']));
                    if ($this->config->item("newsletter_mod_recommended") == '1')
                        $data['similar'] = json_decode(getArtistInfo($temp['artist']));

                } else {
                    $temp = $data['top']->result_array();
                    $temp = $tracks[rand(0, count($tracks))];
                    //$data['similar'] 	= json_decode(getSimilar($temp['artist'],$temp['track']));
                    if ($this->config->item("newsletter_mod_recommended") == '1')
                        $data['similar'] = json_decode(getArtistInfo($temp['artist']));
                }
                $data['user'] = $row;

                $this->email->from($this->config->item("contact_email"), $this->config->item("title"));
                $this->email->to($row->username);
                $this->email->subject($this->config->item("newsletter_title"));
                $emailTemplate = $this->load->view('email/newsletter', $data, true);
                $this->email->message($emailTemplate);
                usleep(300000);
                if ($row->newsletter == '1') {
                    if ($this->email->send()) {
                        $mails_received = intval($row->mails_received) + 1;
                        $this->admin->updateTable("users", array("mails_received" => $mails_received), array("username" => $row->username));
                        $json['sent'] = '1';
                        $json['error'] = '0';
                    } else {
                        $json['sent'] = '0';
                        $json['error'] = '1';
                    }
                } else {
                    $json['sent'] = '1';
                    $json['error'] = '0';
                }


            }
            if ($example) {
                if ($json['error'] == '1')
                    echo $this->email->print_debugger();
                else
                    echo "Check your inbox!<br>";

                exit;
            }
        }

        if ($userTemp)
            $this->output->set_content_type('application/json')->set_output(json_encode($json));

    }

    public function get_station()
    {
        $station = $this->input->post('station', true);
        $url = getStationLink($station);
        $json['url'] = $url;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    public function getPlaylistsArtist($artist = false, $return = false)
    {
        if (!$artist)
            $artist = urldecode($this->input->post("artist"));

        $data['playlists'] = loadPlayListsArtist($artist);

        return $this->load->view(getTemplate('artist_playlists'), $data, $return);
    }

    public function preview()
    {

        Header("Cache-Control: public, must-revalidate, max-age=54400");

        $this->load->helper('file');
        /*
		header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  		header("Pragma: no-cache"); //HTTP 1.0
	  	header("Cache-Control: max-age=2592000"); //30days (60sec * 60min * 24hours * 30days)*/
        $picture = urldecode($this->input->get("img"));
        $ext_t = explode(".", $picture);
        $ext = end($ext_t);
        $allow = array("jpg", "png", "jpeg");
        if (!in_array($ext, $allow)) {
            /*header('Content-type: image/png');
			echo read_file("./assets/images/no-cover.png");
			exit;*/
        }

        $picture = str_ireplace(base_url(), "[banned]", $picture);

        if ($this->config->item("save_local_picture") == '1') {

            $cache_folder = "cache/pictures/";
            if (!file_exists($cache_folder))
                mkdir($cache_folder);

            $folder = strtoupper(substr(sha1($picture), 0, 2));
            if (!file_exists($cache_folder . $folder))
                mkdir($cache_folder . $folder);

            $cache_folder = $cache_folder . $folder;
            if (!file_exists($cache_folder)) {
                show_error("Create folder cache/pictures/ and set write permissions", 500);
            }

            $cache_picture = $cache_folder . "/" . sha1($picture) . "." . $ext;


            if (file_exists($cache_picture)) {
                //header('Content-type: image/'.$ext);
                //echo read_file($cache_picture);
                redirect(base_url() . $cache_picture, 301);
            } else {
                $picture = str_ireplace("\/", "/", $picture);
                if (!copy($picture, $cache_picture)) {
                    //header('Content-type: image/png');
                    echo redirect(base_url() . "/assets/images/no-cover.png");
                    exit;
                } else {
                    //header('Content-type: image/'.$ext);
                    //echo read_file($cache_picture);
                    redirect(base_url() . $cache_picture, 301);
                }
            }
        } else {

            $img = _curl($picture);
            if (!$img) {
                header('Content-type: image/png');
                read_file("./assets/images/no-cover.png");
            } else {
                header('Content-type: image/' . $ext);
                echo $img;
            }

        }

    }


}
