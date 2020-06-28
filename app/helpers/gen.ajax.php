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
    $formbuilder_arr = json_decode($_POST['formbuilder_json']);
    
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
            
            $queryBuilder->insert('tbtest_items_summary')
                        ->values(['ass_code' => '?', 'question' => '?'])
                        ->setParameters([$assessment_code, $formbuilder_json]);
            $queryBuilder->execute();
            
            require_once '../app/models/TestModel.php';
            $test = new TestModel();
            $total_pages = 0;
            foreach($formbuilder_arr as $data){
                if($data->type == 'startPageMarker'){
                    $total_pages++;
                }
            }
            $page_methods = $test->pageMethods($total_pages);
            $test->createTestController($assessment_code, $page_methods);
            
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

