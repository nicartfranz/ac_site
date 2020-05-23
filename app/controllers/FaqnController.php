<?php 

class FaqnController extends Controller{
    
    public $ass_code = 'faqn';

    public function __construct() {
        parent::__construct();
        allowPageAccessByUser(['test_taker']);
    }
    
    public function index(){
        
        //init model
        $test = $this->initModel('TestModel');
        $test_info = $test->getTestByAssCode($this->ass_code);
        
        //remove unnecessary attr in the html question
        $decoded_questions = json_decode($test_info['question']);
        foreach ($decoded_questions as $key => $question){
            unset($decoded_questions[$key]->part);
            unset($decoded_questions[$key]->section);
            unset($decoded_questions[$key]->fldQOrder);
            unset($decoded_questions[$key]->correctAns);
        }
        $test_info['question'] = json_encode($decoded_questions);

        //load a view and put it in a variable for later use
        $content = $this->loadView('pages/candidate/testing', ['test' => $test_info]);
        
        //create an array that will store data to be passed to the render view method
        $html = [
            'includeSiteLevelJS' => [
                'public/js/formbuilder/form-builder.min.js', 
                'public/js/formbuilder/form-render.min.js', 
                'public/js/formbuilder/control_plugins/starRating.js', 
                'public/js/formbuilder/control_plugins/sliderTemplate.js', 
                'public/js/formbuilder/control_plugins/customHTMLTemplate.js', 
                'public/js/formbuilder/control_plugins/startPageMarker.js', 
                'public/js/formbuilder/control_plugins/endPageMarker.js', 
                'public/js/fb_fields_acsite.js',
                'public/js/testtaking.js'
            ],
            'content' => $content, //this is the pages/admin/dashboard html
        ];
        $this->renderView('layouts/candidate', $html);
        
    }

}