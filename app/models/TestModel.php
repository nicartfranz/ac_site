<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestModel
 *
 * @author Nitro 5
 */
class TestModel extends Model{
    
    public function getAllTests(){
        
        $tests = $this->db->fetchAll('SELECT * FROM tbassessment');
        return $tests;
        
    }
    
    public function getTest($id){
        
        $test = $this->db->fetchAssoc('SELECT tbassessment.*, tbtest_items_summary.question FROM tbassessment '
                . 'LEFT JOIN tbtest_items_summary ON tbtest_items_summary.ass_code = tbassessment.AssCode '
                . 'WHERE 1=1 '
                . 'AND tbassessment.id = ?', array($id));
        return $test;
        
    }
    
     public function getTestByAssCode($assCode){
        
        $test = $this->db->fetchAssoc('SELECT tbassessment.*, tbtest_items_summary.question FROM tbassessment '
                . 'LEFT JOIN tbtest_items_summary ON tbtest_items_summary.ass_code = tbassessment.AssCode '
                . 'WHERE 1=1 '
                . 'AND tbassessment.AssCode = ?', array($assCode));
        return $test;
        
    }
    
    
    
}
