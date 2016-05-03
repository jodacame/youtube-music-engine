<?php
class Admin extends CI_Model 
{
    function __construct()
    {    
        parent::__construct();
    }    

    function getTable($table,$where = false,$order = false,$select = false,$offset = false,$limit = false,$like = false,$distinct = false)    
    {

        if($limit !== FALSE)
            $this->db->limit($offset,$limit);
        if($distinct !== FALSE)
            $this->db->distinct();
        if($select)
            $this->db->select($select);
        if($order)
            $this->db->order_by($order);
        if($like)
        {
            foreach ($like as $key => $value) {
                $this->db->or_like($key,$value);
            }    
        }
        

        //if($where && is_array($where))   
        if($where)   
            return $this->db->get_where($table,$where);
        return $this->db->get($table);        
    }



    function getCountTable($table)
    {
        return $this->db->count_all($table);
    }

    


    function setTable($table,$data)
    {
        if($this->db->insert($table, $data))
            return $this->db->insert_id();
        else
            return false;
    }

    function setTableIgnore($table,$data)
    {
        $insert_query = $this->db->insert_string($table, $data);
        $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
        if($this->db->query($insert_query))
            return $this->db->insert_id();
        else
            return false;
    }

    function updateTable($table,$data,$where)
    {
        return $this->db->update($table, $data, $where);
    }
    function setLike($id,$iduserf)
    {
        $this->db->query('UPDATE activity set likes = likes+1 where idactivity = '.intval($id));
        $this->setTableIgnore('activity_likes',array("date"=>date("Y-m-d H:i:s"),"idactivity" => $id,"iduser" => intval($this->session->userdata('id'))));
        $this->setTableIgnore('notifications',array('type' => 'l','iduser' => intval($this->session->userdata('id')),'iduserf' => $iduserf,'date' => date('Y-m-d H:i:s')));        
        
    }

    function followUser($username)
    {
        if(is_logged())
        {
            $iduser = getIdUser($username);
            if($iduser>0)
            {
                $this->db->query("INSERT INTO follows (iduser,iduserf) VALUES(".intval($this->session->userdata('id')).",$iduser)");    
                $this->setTableIgnore('notifications',array('iduser' => intval($this->session->userdata('id')),'iduserf' => $iduser,'date' => date('Y-m-d H:i:s')));        
            }
            
            
        }
        
    } 
    function unFollowUser($username)
    {
        if(is_logged())
        {
            $iduser = getIdUser($username);
            $this->db->query("DELETE FROM follows WHERE  iduser= ".intval($this->session->userdata('id'))." AND iduserf = $iduser");    
            
        }
        
    }

    function deleteTable($table,$where)
    {
        return $this->db->delete($table,$where); 
    }

    function getRegisteredUsersByMonth()
    {
        return $this->db->query("SELECT count(*) as n,SUBSTRING(registered,1,7) as month FROM `users` GROUP BY SUBSTRING( registered, 1, 7 ) order by SUBSTRING(registered,1,7) desc limit 12 ");
    }
    function usersToday()
    {
        $temp = $this->db->query("SELECT count(*) FROM `users`  where SUBSTRING(registered,1,10)='".date("Y-m-d")."'");
        return intval($temp->num_rows());
    }
    function getActivityUser($id=false,$limit = 50,$idactivity = false)
    {
        $extra = '';
        if(intval($id)>0)
            $extra = "AND users.id = '$id'";
        if(intval($idactivity )>0)
            $extra =  $extra ." AND activity.idactivity = '$idactivity'";

        return $this->db->query("SELECT activity.*,users.username,users.id,users.names,users.nickname,users.avatar FROM activity,users WHERE  users.activity_global = '1' $extra and users.id =  activity.iduser  ORDER BY date DESC LIMIT $limit");
    }

    function getTopArtistActivity()
    {
        return $this->db->query("SELECT COUNT(artist) AS TotalRows,artist,picture FROM activity  WHERE action ='1' AND picture != '' AND picture NOT LIKE '%no-cover%' AND date > NOW() - INTERVAL 7 DAY group by artist,picture order by TotalRows DESC LIMIT ".INTVAL($this->config->item("items_top")));
    }
     function getTopTrackActivity()
    {
        $a= $this->db->query("SELECT COUNT(*) AS TotalRows,artist,track,picture FROM activity  WHERE action ='1' AND picture != '' AND date > NOW() - INTERVAL 30 DAY  group by artist,track,picture order by TotalRows DESC LIMIT ".INTVAL($this->config->item("items_top")));        
        if($a->num_rows < INTVAL($this->config->item("items_top")))
                $a = $this->db->query("SELECT COUNT(*) AS TotalRows,artist,track,picture FROM activity  WHERE action ='1' AND picture != '' AND date > NOW() - INTERVAL 90 DAY  group by artist,track,picture order by TotalRows DESC LIMIT ".INTVAL($this->config->item("items_top")));        
        return $a;
    }

    function setUsuarioOnline($id)
    {
        
        $date   = date('Y-m-d H:i:s');
        $ip     = $this->input->ip_address();
        $this->load->library('user_agent');
        if ($this->agent->is_browser())
        {
            $type = 'guest';
        }
        elseif ($this->agent->is_robot())
        {
            $type = 'robot';
        }
        elseif ($this->agent->is_mobile())
        {
            $type = 'guest';
        }
        else
        {
            $type = 'other';
        }
        if($id>0)
            $type = 'user';

        $this->db->query("DELETE FROM online WHERE last_activity < ('$date' - INTERVAL 1 MINUTE)");        
        return $this->db->query("INSERT INTO `online` (`iduser`, `last_activity`, `ip`,`type`)   VALUES ($id,'$date','$ip','$type')  ON DUPLICATE KEY UPDATE last_activity = '$date'");
    }

}
