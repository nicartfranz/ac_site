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
    
    public function getAllTests($where = array()){
        
        if(count($where) != 0){
            $tests = $this->db->fetchAll('SELECT * FROM tbassessment WHERE 1=1 '
                . $where['conditions'], $where['values']);
        } else {
            $tests = $this->db->fetchAll('SELECT * FROM tbassessment WHERE 1=1');
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
                                            tbdimension.dimensionNumber ASC,
                                            tbtest_items.fldQOrder ASC, 
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
            
            $this->db->commit();
        } catch (Exception $ex) {
            $this->db->rollBack();
            echo $ex;
        }

    }
    
    function createTestController($assessment_code, $page_methods){
        //Create controller file dynamically
        $controller_file = APPROOT."\\controllers\\".ucfirst($assessment_code)."Controller.php";
        $file_pointer = $controller_file; 
        if(!file_exists($controller_file)){
            $fh = fopen($controller_file, 'w') or die("Can't create file");
            $open = file_get_contents($file_pointer); 
                        
            $open .= "<?php 

class ".ucfirst($assessment_code)."Controller extends Controller{

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
        
        
        
        return $page_methods;
        
    }
    
}
