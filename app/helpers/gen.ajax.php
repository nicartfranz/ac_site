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
            
            $test_methods = $test->testModelMethods();
            $test->createTestModel($assessment_code, $test_methods);
            
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


function save_video_question()
{
    if (!isset($_POST['audio-filename']) && !isset($_POST['video-filename'])) {
        echo 'Empty file name.';
        return;
    }

    // do NOT allow empty file names
    if (empty($_POST['audio-filename']) && empty($_POST['video-filename'])) {
        echo 'Empty file name.';
        return;
    }

    // do NOT allow third party audio uploads
    if (false && isset($_POST['audio-filename']) && strrpos($_POST['audio-filename'], "RecordRTC-") !== 0) {
        echo 'File name must start with "RecordRTC-"';
        return;
    }

    // do NOT allow third party video uploads
    if (false && isset($_POST['video-filename']) && strrpos($_POST['video-filename'], "RecordRTC-") !== 0) {
        echo 'File name must start with "RecordRTC-"';
        return;
    }
    
    $fileName = '';
    $tempName = '';
    $file_idx = '';
    
    if (!empty($_FILES['audio-blob'])) {
        $file_idx = 'audio-blob';
        $fileName = $_POST['audio-filename'];
        $tempName = $_FILES[$file_idx]['tmp_name'];
    } else {
        $file_idx = 'video-blob';
        $fileName = $_POST['video-filename'];
        $tempName = $_FILES[$file_idx]['tmp_name'];
    }
    
    if (empty($fileName) || empty($tempName)) {
        if(empty($tempName)) {
            echo 'Invalid temp_name: '.$tempName;
            return;
        }

        echo 'Invalid file name: '.$fileName;
        return;
    }

//TO DO
//    $upload_max_filesize = return_bytes(ini_get('upload_max_filesize'));
//    if ($_FILES[$file_idx]['size'] > $upload_max_filesize) {
//       echo 'upload_max_filesize exceeded.';
//       return;
//    }
//    $post_max_size = return_bytes(ini_get('post_max_size'));
//    if ($_FILES[$file_idx]['size'] > $post_max_size) {
//       echo 'post_max_size exceeded.';
//       return;
//    }

    $dirname = xss_clean($_POST["video-folder"]);
    $filePath = '../public/video_questions/'.$dirname.'/';
    if (!file_exists($filePath)) {
        mkdir('../public/video_questions/' . $dirname, 0777);
    }
    
    $filePath = '../public/video_questions/'.$dirname.'/'. $fileName;
    
    
    // make sure that one can upload only allowed audio/video files
    $allowed = array(
        'webm',
        'wav',
        'mp4',
        'mkv',
        'mp3',
        'ogg'
    );
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
        echo 'Invalid file extension: '.$extension;
        return;
    }
    
    if (!move_uploaded_file($tempName, $filePath)) {
        if(!empty($_FILES["file"]["error"])) {
            $listOfErrors = array(
                '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                '3' => 'The uploaded file was only partially uploaded.',
                '4' => 'No file was uploaded.',
                '6' => 'Missing a temporary folder. Introduced in PHP 5.0.3.',
                '7' => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
                '8' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.'
            );
            $error = $_FILES["file"]["error"];

            if(!empty($listOfErrors[$error])) {
                echo $listOfErrors[$error];
            }
            else {
                echo 'Not uploaded because of error #'.$_FILES["file"]["error"];
            }
        }
        else {
            echo 'Problem saving file: '.$tempName;
        }
        return;
    }
    
    echo 'success';
}

function save_candidate_video_answer(){
    if (!isset($_POST['audio-filename']) && !isset($_POST['video-filename'])) {
        echo 'Empty file name.';
        return;
    }

    // do NOT allow empty file names
    if (empty($_POST['audio-filename']) && empty($_POST['video-filename'])) {
        echo 'Empty file name.';
        return;
    }

    // do NOT allow third party audio uploads
    if (false && isset($_POST['audio-filename']) && strrpos($_POST['audio-filename'], "RecordRTC-") !== 0) {
        echo 'File name must start with "RecordRTC-"';
        return;
    }

    // do NOT allow third party video uploads
    if (false && isset($_POST['video-filename']) && strrpos($_POST['video-filename'], "RecordRTC-") !== 0) {
        echo 'File name must start with "RecordRTC-"';
        return;
    }
    
    $fileName = '';
    $tempName = '';
    $file_idx = '';
    
    if (!empty($_FILES['audio-blob'])) {
        $file_idx = 'audio-blob';
        $fileName = $_POST['audio-filename'];
        $tempName = $_FILES[$file_idx]['tmp_name'];
    } else {
        $file_idx = 'video-blob';
        $fileName = $_POST['video-filename'];
        $tempName = $_FILES[$file_idx]['tmp_name'];
    }
    
    if (empty($fileName) || empty($tempName)) {
        if(empty($tempName)) {
            echo 'Invalid temp_name: '.$tempName;
            return;
        }

        echo 'Invalid file name: '.$fileName;
        return;
    }

//TO DO
//    $upload_max_filesize = return_bytes(ini_get('upload_max_filesize'));
//    if ($_FILES[$file_idx]['size'] > $upload_max_filesize) {
//       echo 'upload_max_filesize exceeded.';
//       return;
//    }
//    $post_max_size = return_bytes(ini_get('post_max_size'));
//    if ($_FILES[$file_idx]['size'] > $post_max_size) {
//       echo 'post_max_size exceeded.';
//       return;
//    }

    $dirname = (isset($_SESSION['candidate_info']['username'])) ? $_SESSION['candidate_info']['username'] : 'super_admin';
    $filePath = '../public/video_answers/'.$dirname.'/';
    if (!file_exists($filePath)) {
        mkdir('../public/video_answers/' . $dirname, 0777);
    }
    
    $filePath = '../public/video_answers/'.$dirname.'/'. $fileName;
    
    
    // make sure that one can upload only allowed audio/video files
    $allowed = array(
        'webm',
        'wav',
        'mp4',
        'mkv',
        'mp3',
        'ogg'
    );
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
        echo 'Invalid file extension: '.$extension;
        return;
    }
    
    if (!move_uploaded_file($tempName, $filePath)) {
        if(!empty($_FILES["file"]["error"])) {
            $listOfErrors = array(
                '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                '3' => 'The uploaded file was only partially uploaded.',
                '4' => 'No file was uploaded.',
                '6' => 'Missing a temporary folder. Introduced in PHP 5.0.3.',
                '7' => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
                '8' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.'
            );
            $error = $_FILES["file"]["error"];

            if(!empty($listOfErrors[$error])) {
                echo $listOfErrors[$error];
            }
            else {
                echo 'Not uploaded because of error #'.$_FILES["file"]["error"];
            }
        }
        else {
            echo 'Problem saving file: '.$tempName;
        }
        return;
    }
    
    echo 'success';
}