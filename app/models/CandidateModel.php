<?php
class CandidateModel extends Model{

    public function get_candidate_info($username){
        $candidate = $this->db->fetchAssoc(' SELECT tbtaker.* FROM tbtaker ' 
                                            . 'WHERE 1=1 ' 
                                            . 'AND tbtaker.username = ? ' 
                                            . 'LIMIT 1', array($username));
            
        return $candidate;
    }
    
    public function update_candidate_demographics($params){
            
        if($params['username'] != '' || !empty($params['username'])){
        
            //gender, age, high_educ, workexp, job_level
            $update = $this->db->executeUpdate('UPDATE tbtaker '
                    . 'SET '
                    . 'gender = ?, '
                    . 'age = ?, '
                    . 'high_educ = ?, '
                    . 'workexp = ?, '
                    . 'job_level = ? '
                    . 'WHERE '
                    . 'username = ? ', 
                    array($params['gender'], $params['age'], $params['high_educ'], $params['workexp'], $params['job_level'], $params['username']));

            return true;            
            
        } else {
            return false;
        }
        
    }
    
}
