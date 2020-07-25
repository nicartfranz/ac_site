<?php
/**
 * Description of MeterDeduction
 * - This class is used for all meter deduction related functions.
 * @author Franz
 */
class MeterDeduction {

    //Add database connection
    public $db;
    public $queryBuilder;
    public function __construct() {
        global $db, $queryBuilder;
        $this->db = $db;
        $this->queryBuilder = $queryBuilder;
    }
    
    function getTestMeter($company_id, $ass_code){
        
    }
    
    function setTestMeter($company_id, $ass_code){
        
    }
    
    function getTestMeterDeductionVariable($company_id, $ass_code){
        
    }
    
    function notifyCompanyMeterIsLow($notify_when_meter_is = 10){
        
    }
    
    function notifyNotEnoughMeter($company_id){
        
    }
    
    function test(){
        echo get_class() .': test';
    }
    
}
