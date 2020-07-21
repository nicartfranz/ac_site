<?php

class SiteModel extends Model{

     public function candidate_login($username, $password){
         
        $password = base64_encode(base64_encode(base64_encode(base64_encode($password))));//based on old ac
        
        $candidate_login = $this->db->fetchAssoc(' SELECT tbtaker.* FROM tbtaker ' 
                                                . 'WHERE 1=1 ' 
                                                . 'AND tbtaker.username = ? ' 
                                                . 'AND tbtaker.password = ? ' 
                                                . 'LIMIT 1', array($username, $password));
        
        return $candidate_login;
        
    }
    
}
