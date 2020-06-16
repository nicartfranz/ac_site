<?php
/* 
 * Contributor: Franz
 * Date Modified: May 17, 2020
 * 
 * Description: Contains all the ajax backend functions
 */



function ajax_save_test(){
    global $db, $queryBuilder;

    $assessment_name = $_POST['assessment_obj']['assessment_name'];
    $assessment_code = $_POST['assessment_obj']['assessment_code'];
    $formbuilder_json = $_POST['formbuilder_json'];
    
//    $sql = $db->executeQuery('SELECT * FROM tbassessment WHERE AssCode = ? LIMIT 1', array('bmaa'));
//    $assessment = $sql->fetch();
//    OR    
    $queryBuilder
            ->select('AssCode')
            ->from('tbassessment')
            ->where('AssCode = ?')
            ->setParameter(0, $assessment_code)
            ->setMaxResults(1);
    $stm = $queryBuilder->execute();
    $assessment = $stm->fetch();   
    
    //Check if assessment code exist
    if(empty($assessment)){
        
        $db->beginTransaction();
        try{
           
            $queryBuilder = $queryBuilder->insert('tbassessment')
                                        ->values(['AssCode' => '?', 'AssName' => '?' , 'AssAbb' => '?', 'CliCode' => '?', 'remarks' => '?', 'AssDesc_Summary' => '?',
                                            'text_top' => '?' ,'text_middle' => '?' ,'text_bottom' => '?' ,'text_summary' => '?' ,'graph_title' => '?', 
                                            'date_inserted' => '?', 'date_modified' => '?'])
                                        ->setParameters([$assessment_code, $assessment_name, $assessment_code, 'profiles', '', '', '', '', '' , '', '', 
                                            date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
            $queryBuilder->execute();
            //echo "Executed: $queryBuilder->getSQL(). '<br>';

            $queryBuilder->insert('tbtest_items_summary')
                        ->values(['ass_code' => '?', 'question' => '?'])
                        ->setParameters([$assessment_code, $formbuilder_json]);
            $queryBuilder->execute();
            //echo "Executed: $queryBuilder->getSQL(). '<br>';
            
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

                    }"; 
                file_put_contents($file_pointer, $open); 
            }
            
            $db->commit();
        } catch (\Exception $e) {
            $db->rollBack();
            echo $e;
        }
        
        echo 1;
        
    } else {
        echo 'Assessment code ' .$assessment_code. ' already exist.';
    }
    
}

function ajax_update_test($test_id){
    global $db, $queryBuilder;

    $assessment_name = $_POST['assessment_obj']['assessment_name'];
    $assessment_code = $_POST['assessment_obj']['assessment_code'];
    $formbuilder_json = $_POST['formbuilder_json'];
    
    $db->beginTransaction();
    try{

        //update assessment
        $db->update('tbassessment', 
                    [
                        'AssName' => $assessment_name, 
                        'date_modified' => date('Y-m-d H:i:s')
                    ], 
                    array('id' => $test_id));
        
        //update questions
        $db->update('tbtest_items_summary', 
                    [
                        'question' => $formbuilder_json, 
                    ], 
                    array('ass_code' => $assessment_code));
        
        $db->commit();
        
    } catch (\Exception $e) {
        $db->rollBack();
        echo $e;
    }

    echo 1;

}

