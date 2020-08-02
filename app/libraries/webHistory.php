<?php
/**
 * Description of webHistoryModel
 * This class is used to track web history of a user
 * - controller
 * - method (run)
 * - get
 * - post
 * @author Franz
 */
class webHistory {

    //Add database connection
    public $db;
    public $queryBuilder;
    public function __construct() {
        global $db, $queryBuilder;
        $this->db = $db;
        $this->queryBuilder = $queryBuilder;
    }
    
    public function log_web_history($params){
        
        //candidate activity tracker status
        require_once '../app/models/CandidateSiteRequirementsModel.php';
        $candidateSiteRequirements = new CandidateSiteRequirementsModel();
        $requirements = $candidateSiteRequirements->get_requirements();
        if($requirements['candidate_activity_tracker'] == '0'){ return true; }
        
        //INSERT NEW ROW - id  user_id  web_history_controller  web_history_method  web_history_get  web_history_post  usertype  date_entered  
        $insert_cols = array();
        $insert_vals = array();
        foreach($params as $key => $value){
            $insert_cols[$key] = '?';
            $insert_vals[] = $value;
        }
        $this->queryBuilder->insert('tbweb_history')
                                    ->values($insert_cols)
                                    ->setParameters($insert_vals);
        $this->queryBuilder->execute();
        return true;
        
    }
    
    public function test(){
         echo 'OK';
    }
    
}
