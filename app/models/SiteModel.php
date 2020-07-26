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
    
    public function update_tbtaker($params){
        
        if(is_null($params)){ return false; }
        
        foreach($params as $key => $value){
            $update_cols[] = $key.' = ?';
            $update_vals[] = $value;
        }
        
        $update_vals[] = $_SESSION['candidate_info']['username'];
        
        $update = $this->db->executeUpdate('UPDATE tbtaker '
                    . 'SET '
                    . implode(', ', $update_cols) .' '
                    . 'WHERE 1=1 '
                    . 'AND username = ? ', 
                    $update_vals);
        return true;
        
    }
    
}
