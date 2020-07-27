<?php
/**
 * Description of MeterDeduction
 * - This class is used for all meter deduction related functions.
 * @author Franz
 */
class meterLog {

    public $company_id;    
    public $meter_deduction = 1;

    //Add database connection
    public $db;
    public $queryBuilder;
    public function __construct($company_id) {
        global $db, $queryBuilder;
        $this->db = $db;
        $this->queryBuilder = $queryBuilder;
        
        $this->company_id = $company_id;
        $this->company_meters = $this->getMeter($company_id);
    }
    
    function getMeter($company_id){
        
        $meters = $this->db->fetchAssoc('SELECT * FROM tbusers '
                                        . 'WHERE 1=1 '
                                        . 'AND identity = ? '
                                        . 'LIMIT 1', array($company_id));
        return $meters;
    }
    
    function updateMeter(){
        
        $update_cols[] = 'meters = ?';
        $update_vals[] = $this->company_meters['meter'] - $this->getMeterDeduction();
        
        $update_vals[] = $this->company_id;
        
        $update = $this->db->executeUpdate('UPDATE tbusers '
                    . 'SET '
                    . implode(', ', $update_cols) .' '
                    . 'WHERE 1=1 '
                    . 'AND identity = ? ', 
                    $update_vals);

        $this->notifyCompanyMeterIsLow(10);

        return $update;
        
    }
    
    function setMeterDeduction($int = 1){
        $this->meter_deduction = $int;
    }
    
    function getMeterDeduction(){
        return $this->meter_deduction;
    }
    
    function notifyCompanyMeterIsLow($notify_when_meter_is = 10){
        $notification_msg = '';
        
        if(($meters) && ($this->company_meters['meter'] <= $notify_when_meter_is)){
            $notification_msg = $this->company_meters['name'].' Meter is low.';
            
            //TO DO: SEND EMAIL TO THE COMPANY
            
        }
    }
    
    function isMeterDeductionPositive(){
        
        $remaining_meters = $this->company_meters['meter'] - $this->getMeterDeduction();
        if($remaining_meters < 0){
            return false; // NOT OK
        }
        
        return true; //OK
        
    }
    
    function test(){
        echo get_class() .': test';
    }
    
}


//Implementation
//$meterLog = new meterLog($company_id);
//$meterLog->setMeterDeduction(1);
//if($meterLog->isMeterDeductionPositive()){
//    $meterLog->updateMeter();
//} else {
//    //echo 'Meter is not enough. Please contact you company.';
//}