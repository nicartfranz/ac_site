<?php

//Standard operating procedure (SOP)
class Ctr2Model extends Model{

    //Standard operating procedure (SOP)
    protected $ass_code = 'ctr2';
    
    //Standard operating procedure (SOP)
    public function getLastVisitedPage(){
        
        if($_SESSION['ac2']['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        $row = $this->db->fetchAssoc('SELECT page FROM tbstatus '
                                        . 'WHERE 1=1 '
                                        . 'AND user_id = ? '
                                        . 'AND AssCode = ? '
                                        . 'LIMIT 1', array($_SESSION['ac2']['candidate_info']['username'], $this->ass_code));
        return $row['page'];
        
    }
  
    //Standard operating procedure (SOP)
    public function update_tbstatus($params){
        
        if($_SESSION['ac2']['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        if(is_null($params)){ return false; }
        
        foreach($params as $key => $value){
            $update_cols[] = $key.' = ?';
            $update_vals[] = $value;
        }
        
        $update_vals[] = $_SESSION['ac2']['candidate_info']['username'];
        $update_vals[] = $this->ass_code;
        
        $update = $this->db->executeUpdate('UPDATE tbstatus '
                    . 'SET '
                    . implode(', ', $update_cols) .' '
                    . 'WHERE 1=1 '
                    . 'AND user_id = ? '
                    . 'AND AssCode = ? ', 
                    $update_vals);
        return true;
        
    }
    
    //Standard operating procedure (SOP)
    public function save_update_tbanswer($params){
        
        if($_SESSION['ac2']['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        
        //check if has data already
        $tbanswer = $this->db->fetchAssoc('SELECT * FROM tbanswer '
                                        . 'WHERE 1=1 '
                                        . 'AND userID = ? '
                                        . 'AND testID = ? '
                                        . 'LIMIT 1', array($_SESSION['ac2']['candidate_info']['username'], $this->ass_code));

        if($tbanswer){
            //UPDATE
            $update_cols = array();
            $update_vals = array();
            foreach($params as $key => $value){
                $update_cols[] = $key.' = ?';
                if($key == 'answer'){
                     $update_vals[] = $tbanswer['answer'] . $value;
                } else {
                    $update_vals[] = $value;
                }
            }
            $update_vals[] = $_SESSION['ac2']['candidate_info']['username'];
            $update_vals[] = $this->ass_code;
            
            $update = $this->db->executeUpdate('UPDATE tbanswer '
                    . 'SET '
                    . implode(', ', $update_cols) .' '
                    . 'WHERE 1=1 '
                    . 'AND userID = ? '
                    . 'AND testID = ? ',
                    $update_vals);
            
        } else {
            //INSERT NEW ROW
            $insert_cols = array();
            $insert_vals = array();
            foreach($params as $key => $value){
                $insert_cols[$key] = '?';
                $insert_vals[] = $value;
            }
            $insert_cols += array('fd_UserIndx' => '?', 'userID' => '?' , 'testID' => '?');
            $insert_vals[] = $_SESSION['ac2']['candidate_info']['id'];
            $insert_vals[] = $_SESSION['ac2']['candidate_info']['username']; 
            $insert_vals[] = $this->ass_code;
            
            $this->queryBuilder->insert('tbanswer')
                                        ->values($insert_cols)
                                        ->setParameters($insert_vals);
            $this->queryBuilder->execute();
        }

        return true;
        
    }
    
    //Standard operating procedure (SOP)
    public function save_tbresult($params){

        if($_SESSION['ac2']['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        
        //INSERT NEW ROW
        $insert_cols = array();
        $insert_vals = array();
        foreach($params as $key => $value){
            $insert_cols[$key] = '?';
            $insert_vals[] = $value;
        }
        $insert_cols += array('fd_UserIndx' => '?', 'userID' => '?' , 'testID' => '?');
        $insert_vals[] = $_SESSION['ac2']['candidate_info']['id'];
        $insert_vals[] = $_SESSION['ac2']['candidate_info']['username']; 
        $insert_vals[] = $this->ass_code;
        
        $this->queryBuilder->insert('tbresult')
                                    ->values($insert_cols)
                                    ->setParameters($insert_vals);
        $this->queryBuilder->execute();


        return true;
        
    }
    
    //Standard operating procedure (SOP)
    public function send_report(){

        if($_SESSION['ac2']['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        
    }
    
    //Standard operating procedure (SOP)
    public function meter_deduction(){
        
        if($_SESSION['ac2']['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        $meterLog = $this->initClass('meterLog');
        
    }
    
}
