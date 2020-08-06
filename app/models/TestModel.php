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
    
    public function getAllTests($where_conditions = array(), $where_values = array(), $limit = ''){
        if(count($where_conditions) != 0){
            $where_conditions = implode(' ', $where_conditions);
            
            $tests = $this->db->fetchAll('SELECT * FROM tbassessment WHERE 1=1 AND AssName <> "" '
                . $where_conditions
                . ' ORDER BY AssName '
                . $limit
                    ,$where_values);
  
        } else {
            $tests = $this->db->fetchAll('SELECT * FROM tbassessment WHERE 1=1 AND AssName <> "" ORDER BY AssName');
        }
        
        
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
    
    public function getTestByUsername($username){
        
        $tests = $this->db->fetchAll('SELECT tbstatus.user_id, tbstatus.AssCode, tbassessment.AssName, tbstatus.status FROM tbstatus '
                . ' LEFT JOIN tbassessment ON tbassessment.AssCode = tbstatus.AssCode '
                . ' WHERE 1=1 '
                . ' AND tbstatus.user_id = ?', array($username));
        return $tests;
        
    }
    
    public function get_tb_assessment($id){
        $test = $this->db->fetchAssoc('SELECT * FROM tbassessment '
                . 'WHERE 1=1 '
                . 'AND id = ?', array($id));
        return $test;
    }
    
    public function get_tb_dimensions($assCode){
        $test_dimensions = $this->db->fetchAll('SELECT * FROM tbdimension '
                                                . 'WHERE 1=1 '
                                                . 'AND AssCode = ? '
                                                . 'ORDER BY dimensionNumber ASC', array($assCode));
        return $test_dimensions;
    }
    
    public function get_test_items($assCode){
        $test_items = $this->db->fetchAll('SELECT * FROM tbtest_items '
                                            . 'WHERE 1=1 '
                                            . 'AND QuesCode LIKE ? '
                                            . 'ORDER BY fldQOrder ASC, level ASC', 
                                            array('%'.$assCode.'%'));
        return $test_items;
    }
    
    public function get_test_items2($assCode){
        
        $test_items = $this->db->fetchAll('SELECT 
                                            tbassessment.id,
                                            tbassessment.AssName,
                                            tbdimension.dimensionName,
                                            tbdimension.dimensionDescription,
                                            tbdimension.dimensionNumber,
                                            tbdimension.flag,
                                            tbdimension.topic_id,
                                            tbdimension.t_score,
                                            tbtest_items.*
                                            FROM tbdimension  
                                            INNER JOIN tbtest_items ON tbdimension.dimensionNumber = tbtest_items.level AND tbtest_items.QuesCode LIKE CONCAT(tbdimension.AssCode, "-", "%")
                                            INNER JOIN tbassessment ON tbdimension.AssCode = tbassessment.AssCode
                                            WHERE 1=1 
                                            AND tbtest_items.QuesCode LIKE ? 
                                            ORDER BY 
                                            tbtest_items.fldQOrder ASC, 
                                            tbdimension.dimensionNumber ASC,
                                            tbtest_items.level ASC', array($assCode.'-%'));
        return $test_items;

    }
    
    public function get_instruction_per_dimension($assCode, $dimensionNumber){
         $test_dimensions = $this->db->fetchAssoc('SELECT tbdimension.*, tbassessment_category.* FROM tbdimension ' 
                                                . 'LEFT JOIN tbassessment_category ON tbassessment_category.CategoryCode = CONCAT(tbdimension.AssCode,"-part:",tbdimension.dimensionNumber) '
                                                . 'WHERE 1=1 ' 
                                                . 'AND tbdimension.AssCode = ? ' 
                                                . 'AND tbdimension.dimensionNumber = ? ' 
                                                . 'LIMIT 1', array($assCode, $dimensionNumber));
        return $test_dimensions;
    }
    
     public function get_instruction_by_topicCode($assCode, $CategoryCode){
         $test_dimensions = $this->db->fetchAssoc('SELECT tbdimension.*, tbassessment_category.* FROM tbdimension ' 
                                                . 'LEFT JOIN tbassessment_category ON tbassessment_category.CategoryCode = CONCAT(tbdimension.AssCode,"-part:",tbdimension.dimensionNumber) '
                                                . 'WHERE 1=1 ' 
                                                . 'AND tbdimension.AssCode = ? ' 
                                                . 'AND tbassessment_category.CategoryCode = ? ' 
                                                . 'LIMIT 1', array($assCode, $CategoryCode));
        return $test_dimensions;
    }
    
    public function getQuestionsForConversion($assCode){
        
        $test_items = $this->db->fetchAll('SELECT 
                                            tbassessment.id,
                                            tbassessment.AssName,
                                            tbdimension.dimensionName,
                                            tbdimension.dimensionDescription,
                                            tbdimension.dimensionNumber,
                                            tbdimension.flag,
                                            tbdimension.topic_id,
                                            tbdimension.t_score,
                                            tbtest_items.*
                                            FROM tbdimension  
                                            INNER JOIN tbtest_items ON tbdimension.dimensionNumber = tbtest_items.level AND tbtest_items.QuesCode LIKE CONCAT(tbdimension.AssCode, "-", "%")
                                            INNER JOIN tbassessment ON tbdimension.AssCode = tbassessment.AssCode
                                            WHERE 1=1 
                                            AND tbtest_items.QuesCode LIKE ? 
                                            ORDER BY 
                                            tbtest_items.fldQOrder ASC, 
                                            tbdimension.dimensionNumber ASC,
                                            tbtest_items.level ASC', array($assCode.'-%'));
        return $test_items;

    }
    
    public function save_tbtest_items_summary($insert){
        
        $this->db->beginTransaction();
        try{
            
            $assessment_code = $insert['ass_code'];
            $formbuilder_json = $insert['question'];
            $total_pages = $insert['total_pages'];

            $this->queryBuilder->insert('tbtest_items_summary')
                                ->values(['ass_code' => '?', 'question' => '?'])
                                ->setParameters([$assessment_code, $formbuilder_json]);
            $this->queryBuilder->execute();
            $page_methods = $this->pageMethods($total_pages);
            $this->createTestController($assessment_code, $page_methods);
            
            $test_methods = $this->testModelMethods();
            $this->createTestModel($assessment_code, $test_methods);
            
            $this->db->commit();
        } catch (Exception $ex) {
            $this->db->rollBack();
            echo $ex;
        }

    }
    
    function createTestController($assessment_code, $page_methods){
        //Create controller file programatically
        $controller_file = APPROOT."\\controllers\\".ucfirst($assessment_code)."Controller.php";
        $file_pointer = $controller_file; 
        if(!file_exists($controller_file)){
            $fh = fopen($controller_file, 'w') or die("Can't create file");
            $open = file_get_contents($file_pointer); 
                        
            $open .= "<?php 

class ".ucfirst($assessment_code)."Controller extends Test{

    public \$ass_code = '".$assessment_code."';
    public \$site_level_form_builder_js = [
        'public/js/formbuilder/form-builder.min.js', 
        'public/js/formbuilder/form-render.min.js', 
        'public/js/formbuilder/control_plugins/starRating.js', 
        'public/js/formbuilder/control_plugins/customHTMLTemplate.js', 
        'public/js/formbuilder/control_plugins/startPageMarker.js', 
        'public/js/formbuilder/control_plugins/endPageMarker.js',
        'public/js/formbuilder/control_plugins/likertQuestion.js',
        'public/js/formbuilder/control_plugins/LeastBestQuestion.js',
        'public/js/formbuilder/control_plugins/rankingQuestion.js',
        'public/js/formbuilder/control_plugins/sliderQuestion.js',
        'public/js/formbuilder/control_plugins/customMC1Question.js',
        'public/js/formbuilder/control_plugins/customMC2Question.js',
        'public/js/formbuilder/control_plugins/single_char_question_template.js',
        'public/js/formbuilder/control_plugins/true_false_question_template.js',
        'public/js/formbuilder/control_plugins/yes_no_question_template.js',
        'public/js/formbuilder/control_plugins/true_false_undecided_question_template.js',
        'public/js/formbuilder/control_plugins/yes_no_undecided_question_template.js',
        'public/js/formbuilder/control_plugins/video_question_template.js',
        'public/js/fb_fields_acsite.js',
        'public/js/testtaking.js',
    ];

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['test_taker']);
    }
    
    ";
                  
            $open .= $page_methods;    
            
$open .= "
}"; 
            
            file_put_contents($file_pointer, $open); 
        }
    }
    
    function pageMethods($total_pages){
        
        $page_methods = "";
        for($i=1; $i<=$total_pages; $i++){
            $method_name = '';
            if($i=='1'){
                $method_name = 'index';
            } else {
                $method_name = 'page'.$i;
            }

            $page_methods .= "
    public function ".$method_name."(){
        
        //--SUBMIT PREV FORM---//
        \$this->submitForm(false);
        \$this->saveSnapshot();
        //--------------------//

        //1.) Initialize Model Class -> TestModel (For DB functions)
        \$test = \$this->initModel('TestModel');
        \$test_data = \$test->getTestByAssCode(\$this->ass_code);

        //2.) Get questions from db
        \$question_arr = \$this->loadQuestionCandidate(\$test_data['question']);

        //3.) Set test page timer
        testTimer('unset', \$this->ass_code, 0); //unset timer on this page

        //4.) Set the required test_info variables
        \$test_info = [];
        //4.1) Set AssCode
        \$test_info['AssCode'] = \$this->ass_code;
        //4.2) Set the questions to display
        \$test_info['question'] = json_encode(\$question_arr['page".$i."']);
        //4.3) Javascript to run on timer times up
        \$test_info['onTimesUp'] = \$question_arr['page".$i."'][0]->onTimerTimesUp;
        //4.4) Snapshot
        \$test_info['enableSnapshot'] = \$question_arr['page".$i."'][0]->enableSnapshot;";

            if($i==$total_pages){
$page_methods .= "
        \$test_info['submit_page'] = 'finish';";
            } else {
                $next_page = $i+1;
                $page_methods .= "
        \$test_info['submit_page'] = 'page".$next_page."';";
            }

            $page_methods .="
        //5.) Load the testing page and pass the test_info array
        \$content = \$this->getView('pages/candidate/testing', \$test_info);

        //6.) Load the candidate template page, pass the candidate testing page then load the page.
        \$html['includeSiteLevelCSS'] = array(); //include site level css
        \$html['includeSiteLevelJS'] = \$this->site_level_form_builder_js; //include site level js
        \$html['content'] = \$content;
        \$this->renderView('layouts/candidate', \$html);
    }
            
            ";

            if($i=='1'){
                $page_methods .= "
                
    public function page1(){
        \$this->index();
    }

                ";
            }
        }
        
        $page_methods .= "
                
    public function finish(){
        parent::finish();
    }

        ";
        
        
        return $page_methods;
        
    }
    
    function createTestModel($assessment_code, $test_methods){
        //Create test model file programatically
        $model_file = APPROOT."\\models\\".ucfirst($assessment_code)."Model.php";
        $file_pointer = $model_file; 
        if(!file_exists($model_file)){
            $fh = fopen($model_file, 'w') or die("Can't create file");
            $open = file_get_contents($file_pointer); 
                        
            $open .= "<?php 

//Standard operating procedure (SOP)
class ".ucfirst($assessment_code)."Model extends Model{

    //Standard operating procedure (SOP)
    protected \$ass_code = '".$assessment_code."';
    
    ";
                  
            $open .= $test_methods;    
            
$open .= "
}"; 
            
            file_put_contents($file_pointer, $open); 
        }
    }
    
    
    function testModelMethods(){
        
        $test_model_methods = "";

        $test_model_methods .= "

    //Standard operating procedure (SOP)
    public function getLastVisitedPage(){
        
        if(\$_SESSION['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        \$row = \$this->db->fetchAssoc('SELECT page FROM tbstatus '
                                        . 'WHERE 1=1 '
                                        . 'AND user_id = ? '
                                        . 'AND AssCode = ? '
                                        . 'LIMIT 1', array(\$_SESSION['candidate_info']['username'], \$this->ass_code));
        return \$row['page'];
        
    }
    
    //Standard operating procedure (SOP)
    public function update_tbstatus(\$params){
        
        if(\$_SESSION['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        if(is_null(\$params)){ return false; }
        
        foreach(\$params as \$key => \$value){
            \$update_cols[] = \$key.' = ?';
            \$update_vals[] = \$value;
        }
        
        \$update_vals[] = \$_SESSION['candidate_info']['username'];
        \$update_vals[] = \$this->ass_code;
        
        \$update = \$this->db->executeUpdate('UPDATE tbstatus '
                    . 'SET '
                    . implode(', ', \$update_cols) .' '
                    . 'WHERE 1=1 '
                    . 'AND user_id = ? '
                    . 'AND AssCode = ? ', 
                    \$update_vals);
        return true;
        
    }
    

    //Standard operating procedure (SOP)
    public function save_update_tbanswer(\$params){
        
        if(\$_SESSION['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        
        //check if has data already
        \$tbanswer = \$this->db->fetchAssoc('SELECT * FROM tbanswer '
                                        . 'WHERE 1=1 '
                                        . 'AND userID = ? '
                                        . 'AND testID = ? '
                                        . 'LIMIT 1', array(\$_SESSION['candidate_info']['username'], \$this->ass_code));

        if(\$tbanswer){
            //UPDATE
            \$update_cols = array();
            \$update_vals = array();
            foreach(\$params as \$key => \$value){
                \$update_cols[] = \$key.' = ?';
                if(\$key == 'answer'){
                     \$update_vals[] = \$tbanswer['answer'] . \$value;
                } else {
                    \$update_vals[] = \$value;
                }
            }
            \$update_vals[] = \$_SESSION['candidate_info']['username'];
            \$update_vals[] = \$this->ass_code;
            
            \$update = \$this->db->executeUpdate('UPDATE tbanswer '
                    . 'SET '
                    . implode(', ', \$update_cols) .' '
                    . 'WHERE 1=1 '
                    . 'AND userID = ? '
                    . 'AND testID = ? ',
                    \$update_vals);
            
        } else {
            //INSERT NEW ROW
            \$insert_cols = array();
            \$insert_vals = array();
            foreach(\$params as \$key => \$value){
                \$insert_cols[\$key] = '?';
                \$insert_vals[] = \$value;
            }
            \$insert_cols += array('fd_UserIndx' => '?', 'userID' => '?' , 'testID' => '?');
            \$insert_vals[] = \$_SESSION['candidate_info']['id'];
            \$insert_vals[] = \$_SESSION['candidate_info']['username']; 
            \$insert_vals[] = \$this->ass_code;
            
            \$this->queryBuilder->insert('tbanswer')
                                        ->values(\$insert_cols)
                                        ->setParameters(\$insert_vals);
            \$this->queryBuilder->execute();
        }

        return true;
        
    }
    
    //Standard operating procedure (SOP)
    public function save_update_tbresult(\$params){

        if(\$_SESSION['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        
        //INSERT NEW ROW
        \$insert_cols = array();
        \$insert_vals = array();
        foreach(\$params as \$key => \$value){
            \$insert_cols[\$key] = '?';
            \$insert_vals[] = \$value;
        }
        \$insert_cols += array('fd_UserIndx' => '?', 'userID' => '?' , 'testID' => '?');
        \$insert_vals[] = \$_SESSION['candidate_info']['id'];
        \$insert_vals[] = \$_SESSION['candidate_info']['username']; 
        \$insert_vals[] = \$this->ass_code;
        
        \$this->queryBuilder->insert('tbresult')
                                    ->values(\$insert_cols)
                                    ->setParameters(\$insert_vals);
        \$this->queryBuilder->execute();


        return true;
        
    }
    
    //Standard operating procedure (SOP)
    public function send_report(){

        if(\$_SESSION['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        
    }
    
    //Standard operating procedure (SOP)
    public function meter_deduction(){
        
        if(\$_SESSION['usertype'] == 'super_admin'){ return true; } // IF SUPER ADMIN, disable saving processes
        \$meterLog = \$this->initClass('meterLog');
        
    }
    

    ";
        
        
        return $test_model_methods;
        
    }
    
}
