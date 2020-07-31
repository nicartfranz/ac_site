/*
 * Contributor: Franz
 * May 19, 2020
 * Description: Add here all the formbuilder fields (JSON)
 */
//All custom fields template
const fb_customFields = [
    {
      type: 'autocomplete',
      label: 'Custom Autocomplete',
      values: [
        { label: 'SQL' },
        { label: 'C#' },
        { label: 'JavaScript' },
        { label: 'Java' },
        { label: 'Python' },
        { label: 'C++' },
        { label: 'PHP' },
        { label: 'Swift' },
        { label: 'Ruby' },
      ],
    }, 
    {
      label: 'Star rating template',
      attrs: {
        type: 'starRating',
        className: 'starRating',
      },
    },
    {
        type: "customHTMLTemplate",
        required: false,
        label: "Custom HTML",
        className: "form-control",
        access: false,
        value: "",
        attrs: {
            type: 'textarea',
            subtype: 'textarea',
        }
    },
    {
        type: "startPageMarker",
        label: "<span class='text-info'><b>Start Page Marker</b></span>",
    },
    {
        type: "endPageMarker",
        label: "<span class='text-danger'><b>End Page Marker</b></span>",
    },
    {
        type: "likertQuestion",
        required: false,
        label: "Likert Scale",
        className: "form-control",
        access: false,
        value: "",
        attrs: {
            type: 'textarea',
            subtype: 'textarea',
        }
    },
    {
        type: "LeastBestQuestion",
        required: false,
        label: "Least - Best Answer",
        className: "form-control",
        access: false,
        value: "",
        attrs: {
            type: 'textarea',
            subtype: 'textarea',
        }
    },
    {
        type: "rankingQuestion",
        required: false,
        label: "Ranking Answer",
        className: "form-control",
        access: false,
        value: "",
        attrs: {
            type: 'textarea',
            subtype: 'textarea',
        }
    },
    {
        type: "sliderQuestion",
        required: false,
        label: "Slider Type Answer",
        className: "form-control",
        access: false,
        value: "",
        attrs: {
            type: 'textarea',
            subtype: 'textarea',
        }
    },
  
    {
        type: "single_char_question_template",
        label: "Single Char Question Template",
    },
    {
        type: "true_false_question_template",
        label: "True False Question Template"
    },
    {
        type:"true_false_undecided_question_template",
        label:"True/False/Undecided Question Template",
    },
    {
        type:"yes_no_question_template",
        label:"Yes No Question Template",
    },
    {
        type:"yes_no_undecided_question_template",
        label:"Yes/No/Undecided Question Template",
    },
    {
        type: "customMC1Question",
        required: false,
        label: "Custom MC Single Answer",
        className: "form-control",
        access: false,
        value: "",
        attrs: {
            type: 'textarea',
            subtype: 'textarea',
        }
    },
    {
        type: "customMC2Question",
        required: false,
        label: "Custom MC Multi-Answer",
        className: "form-control",
        access: false,
        value: "",
        attrs: {
            type: 'textarea',
            subtype: 'textarea',
        }
    }, 
];


//All field templates
//Note: When creating template make sure you create a register the class too. See the documetation here https://formbuilder.online/docs/formBuilder/options/templates/
const fb_templates = {
    starRating: function(fieldData) {
      return {
        field: '<span id="' + fieldData.name +'">',
        onRender: function(){
          $("span#"+fieldData.name).rateYo({ rating: 0, halfStar: true })
        },
      }
    },
    customHTMLTemplate: function(fieldData) { 
        var custom_html_value = fieldData.value || '';
        return {
            field: '<textarea style="min-height: 200px;" class="form-control" id="'+fieldData.name+'">'+formatFactory(custom_html_value)+'</textarea>',
//            onRender: (){
//                $('div#'+fieldData.name).html('sdad');
//            }
        }
    },
    startPageMarker: function (fieldData){
        
        if(fieldData.value == '' || fieldData.value === undefined){
            fieldData.value = 'NEW PAGE';
        }
        
        var note = fieldData.value;
        return {
            field: '<form method="POST">', //VERY IMPORTANT: opens the <form>
            onRender: function(){
                $('p#'+fieldData.name).html(note);
            }
        }
    },
    endPageMarker: function (fieldData){
        
        if(fieldData.value == '' || fieldData.value === undefined){
            fieldData.value = 'END PAGE';
        }
        
        var note = fieldData.value;
        return {
            field: '</form>', //VERY IMPORTANT: close the <form>
            onRender: function(){
                $('p#'+fieldData.name).html(note);
            }
        }
    },
    likertQuestion: function(fieldData) { 
        var setDefaultValue = "\
<table class='table table-striped likert'>\n\
<thead>\n\
    <tr>\n\
        <th></th>\n\
        <th><center>Strongly Disagree</center></th>\n\
        <th><center>Disagree</center></th>\n\
        <th><center>Neutral</center></th>\n\
        <th><center>Agree</center></th>\n\
        <th><center>Strongly Agree</center></th>\n\
    </tr>\n\
</thead>\n\
<tbody>\n\
    <tr>\n\
        <td>Question</td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='1'></center></td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='2'></center></td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='3'></center></td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='4'></center></td>\n\
        <td><center><input type='radio' name='q_lk_1_1' value='5'></center></td>\n\
    </tr>\n\
</tbody>\n\
</table>"
        var custom_html_value = fieldData.value || setDefaultValue;
        return {
            field: '<textarea style="min-height: 500px;" class="form-control" id="'+fieldData.name+'">'+formatFactory(custom_html_value)+'</textarea>',
//            field: custom_html_value,
//            onRender: function(){
//                $('div#'+fieldData.name).html(custom_html_value);
//            }
        }
    },
    LeastBestQuestion: function(fieldData){
        var setDefaultValue = "\n\
<p>Least - Best Question (PCA)</p>\n\
<div class='least-best-div' id='q1'>\n\
  <div class='least-best-checkbox'>\n\
    CHOICE 1\n\
    <input type='checkbox' name='q1[]' value='1'>\n\
  </div>\n\
  <div class='least-best-checkbox'>\n\
    CHOICE 2\n\
    <input type='checkbox' name='q1[]' value='2'>\n\
  </div>\n\
  <div class='least-best-checkbox'>\n\
    CHOICE 3\n\
    <input type='checkbox' name='q1[]' value='3'>\n\
  </div>\n\
  <div class='least-best-checkbox'>\n\
    CHOICE 4\n\
    <input type='checkbox' name='q1[]' value='4'>\n\
  </div>\n\
</div>";
        var custom_html_value = fieldData.value || setDefaultValue;
        return {
            field: '<textarea style="min-height: 250px;" class="form-control" id="'+fieldData.name+'">'+formatFactory(custom_html_value)+'</textarea>',
        }
    },
    rankingQuestion: function (fieldData){
        var setDefaultValue = "\n\
<div class='container-fluid'>\n\
    <div class='row ranking-question'>\n\
        <div class='col-sm ranking-question-box-left' id='q1'>\n\
        </div>\n\
        <div class='col-sm ranking-question-box-right'>\n\
        <div class='row ranking-choice-box' id='q1'>\n\
            <div class='col-xs ranking-choice c1_1' value='4'>Playful</div>\n\
            <div class='col-xs ranking-choice c1_2' value='1'>Strong-willed</div>\n\
            <div class='col-xs ranking-choice c1_3' value='3'>Intellectual</div>\n\
            <div class='col-xs ranking-choice c1_4' value='2'>Cooperative</div>\n\
        </div>\n\
        <br>\n\
        <p><b>Playful</b> - I am full of fun and good humor.</p>\n\
        <p><b>Strong-willed</b> - I am determined to have my way.</p>\n\
        <p><b>Intellectual</b> - I am intelligent or knowledgeable; I am an academic.</p>\n\
        <p><b>Cooperative</b> - I am obliging, helpful, and supportive.</p>\n\
    </div>\n\
</div>";
        var custom_html_value = fieldData.value || setDefaultValue;
        return {
            field: '<textarea style="min-height: 250px;" class="form-control" id="'+fieldData.name+'">'+formatFactory(custom_html_value)+'</textarea>',
        }
    },
    sliderQuestion: function(fieldData){
        var setDefaultValue = "\n\
  <div class='sliderTypeQuestion'>\n\
    <div>\n\
      Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book\n\
    </div>\n\
    <br>\n\
    <div class='sliderTypeQuestion_text' id='q_sl_1'><span>#</span></div>\n\
    <br>\n\
    <div class='sliderTypeQuestion_choice' id='q_sl_1'>\n\
    <input type='range' class='custom-range' min='1' max='5' step='1' id='sliderTypeQuestion_range' name='q_sl_1'>\n\
  </div>";
        var custom_html_value = fieldData.value || setDefaultValue;
        return {
            field: '<textarea style="min-height: 250px;" class="form-control" id="'+fieldData.name+'">'+formatFactory(custom_html_value)+'</textarea>',
        }
    },
    customMC1Question:function(fieldData){
        var setDefaultValue = "\n\
    <div class='container'><div class='row custom_mc_row_question'><b>1.&nbsp;</b>QUESTION</div>\n\
        <div class='row custom_mc_row'>\n\
            <label class='custom_mc_container q1'>\n\
            <input class='custom_mc_radio' type='radio' name='q1' value='1'>\n\
            Choice 1\n\
            </label>\n\
        </div>\n\
        <div class='row custom_mc_row'>\n\
            <label class='custom_mc_container q1'>\n\
            <input class='custom_mc_radio' type='radio' name='q1' value='2'>\n\
            Choice 2\n\
            </label>\n\
        </div>\n\
    </div>";
        var custom_html_value = fieldData.value || setDefaultValue;
        return {
            field: '<textarea style="min-height: 250px;" class="form-control" id="'+fieldData.name+'">'+formatFactory(custom_html_value)+'</textarea>',
//            field: formatFactory(custom_html_value),
//            onRender: function(){
//                var count_frmb = $('ul.frmb li:not(.startPageMarker-field, .button-field, .endPageMarker-field)').length;
//                alert('Total frmb = '  + count_frmb);
//            }
        }
    },
    customMC2Question:function(fieldData){
        var setDefaultValue = "\n\
        <div class='container'>\n\
            <div class='row custom_mc_row_question'><b>1. </b>QUESTION</div>\n\
            <div class='row custom_mc_row'>\n\
                    <label class='custom_mc_container q1'>\n\
                            <input class='custom_mc_checkbox' type='checkbox' name='q1[]' value='1'>\n\
                            Choice 1\n\
                    </label>\n\
            </div>\n\
            <div class='row custom_mc_row'>\n\
                    <label class='custom_mc_container q1'>\n\
                            <input class='custom_mc_checkbox' type='checkbox' name='q1[]' value='2'>\n\
                            Choice 2\n\
                    </label>\n\
            </div>\n\
            <div class='row custom_mc_row'>\n\
                    <label class='custom_mc_container q1'>\n\
                            <input class='custom_mc_checkbox' type='checkbox' name='q1[]' value='3'>\n\
                            Choice 3\n\
                    </label>\n\
            </div>\n\
        </div>";
        var custom_html_value = fieldData.value || setDefaultValue;
        return {
            field: '<textarea style="min-height: 250px;" class="form-control" id="'+fieldData.name+'">'+formatFactory(custom_html_value)+'</textarea>',
        }
    },
    single_char_question_template:function(fieldData){
        
        if(!fieldData.hasOwnProperty('value')){
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_VAR = unique_var;

            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null){ alert('This is a required field!'); return false; }
            var QUESTION_VAR = prompt("Enter the item variable:", QUESTION_VAR);
            if(QUESTION_VAR == null){ alert('This is a required field!'); return false; }

            //final question var 
            var QUESTION_VAR = 'char_question_'+QUESTION_VAR;

            var setDefaultValue = "\
                    <input type='text' onkeyup='javascript:char_question_onKeyUp(this);' onblur='javascript:char_question_onBlur(this);' maxlength='1' style='width:75px;' id='"+QUESTION_VAR+"' name='"+QUESTION_VAR+"'>\n\
                    &nbsp;"+QUESTION_TEXT+"\n\
                    <hr>";

            var custom_html_value = setDefaultValue;
            
        } else {
            var custom_html_value = fieldData.value;
        }
        
        return {
            field: formatFactory(custom_html_value),
            onRender: function(){
                var name_field_id = $('input[value='+fieldData.name.replace('-preview','')+']').attr('id'); 
                var value_field_id = name_field_id.replace('name-','value-');
                
                $('#'+value_field_id).val(formatFactory(custom_html_value));
            }
        }
        
    },
    true_false_question_template:function(fieldData){
        
        if(!fieldData.hasOwnProperty('value')){
       
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_VAR_NAME = unique_var;
            var QUESTION_VAR_TRUE = unique_var;
            var QUESTION_VAR_FALSE = unique_var;
            
            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null){ alert('This is a required field!'); return false; }

            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR_NAME = 'tf1_q_'+QUESTION_VAR;
            var QUESTION_VAR_TRUE = 'tf1_q_'+QUESTION_VAR+'_t';
            var QUESTION_VAR_FALSE = 'tf1_q_'+QUESTION_VAR+'_f';
            var true_image = APP_BASE_URL+'public/img/assessments/types/tf1/True.png';
            var false_image = APP_BASE_URL+'public/img/assessments/types/tf1/False.png';
         
            var setDefaultValue = "\
                <p>"+QUESTION_TEXT+"</p>\
                <div id='radio-image-selector' class='row'>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_TRUE+"' value='1' />\
                    <label for='"+QUESTION_VAR_TRUE+"'><img for='"+QUESTION_VAR_TRUE+"' src='"+true_image+"' width='70' height='70' alt='True' /></label>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_FALSE+"' value='2' />\
                    <label for='"+QUESTION_VAR_FALSE+"'><img for='"+QUESTION_VAR_FALSE+"' src='"+false_image+"' width='70' height='70' alt='False' /></label>\
                </div>";
            
            var custom_html_value = setDefaultValue;
            
        } else {
            var custom_html_value = fieldData.value;
        }
        
        return {
            field: formatFactory(custom_html_value),
            onRender: function(){
                var name_field_id = $('input[value='+fieldData.name.replace('-preview','')+']').attr('id'); 
                var value_field_id = name_field_id.replace('name-','value-');
                
                $('#'+value_field_id).val(custom_html_value);
            }
        }

    },
    yes_no_question_template:function(fieldData){
        
        if(!fieldData.hasOwnProperty('value')){
       
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_VAR_NAME = unique_var;
            var QUESTION_VAR_YES = unique_var;
            var QUESTION_VAR_NO = unique_var;
            
            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null){ alert('This is a required field!'); return false; }

            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR_NAME = 'yn1_q_'+QUESTION_VAR;
            var QUESTION_VAR_YES = 'yn1_q_'+QUESTION_VAR+'_y';
            var QUESTION_VAR_NO = 'yn1_q_'+QUESTION_VAR+'_n';
            var yes_image = APP_BASE_URL+'public/img/assessments/types/yn1/Yes.png';
            var no_image = APP_BASE_URL+'public/img/assessments/types/yn1/No.png';
         
            var setDefaultValue = "\
                <p>"+QUESTION_TEXT+"</p>\
                <div id='radio-image-selector' class='row'>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_YES+"' value='1' />\
                    <label for='"+QUESTION_VAR_YES+"'><img for='"+QUESTION_VAR_YES+"' src='"+yes_image+"' width='70' height='70' alt='Yes' /></label>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_NO+"' value='2' />\
                    <label for='"+QUESTION_VAR_NO+"'><img for='"+QUESTION_VAR_NO+"' src='"+no_image+"' width='70' height='70' alt='No' /></label>\
                </div>";
            
            var custom_html_value = setDefaultValue;
            
        } else {
            var custom_html_value = fieldData.value;
        }
        
        return {
            field: formatFactory(custom_html_value),
            onRender: function(){
                var name_field_id = $('input[value='+fieldData.name.replace('-preview','')+']').attr('id'); 
                var value_field_id = name_field_id.replace('name-','value-');
                
                $('#'+value_field_id).val(custom_html_value);
            }
        }

    },
    true_false_undecided_question_template:function(fieldData){
        
        if(!fieldData.hasOwnProperty('value')){
       
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_VAR_NAME = unique_var;
            var QUESTION_VAR_TRUE = unique_var;
            var QUESTION_VAR_FALSE = unique_var;
            var QUESTION_VAR_UNDECIDED = unique_var;
            
            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null){ alert('This is a required field!'); return false; }

            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR_NAME = 'tf2_q_'+QUESTION_VAR;
            var QUESTION_VAR_TRUE = 'tf2_q_'+QUESTION_VAR+'_t';
            var QUESTION_VAR_FALSE = 'tf2_q_'+QUESTION_VAR+'_f';
            var QUESTION_VAR_UNDECIDED = 'tf2_q_'+QUESTION_VAR+'_u';
            var true_image = APP_BASE_URL+'public/img/assessments/types/tf2/True.png';
            var false_image = APP_BASE_URL+'public/img/assessments/types/tf2/False.png';
            var undecided_image = APP_BASE_URL+'public/img/assessments/types/tf2/Undecided.png';
         
            var setDefaultValue = "\
                <p>"+QUESTION_TEXT+"</p>\
                <div id='radio-image-selector' class='row'>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_TRUE+"' value='1' />\
                    <label for='"+QUESTION_VAR_TRUE+"'><img for='"+QUESTION_VAR_TRUE+"' src='"+true_image+"' width='70' height='70' alt='True' /></label>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_FALSE+"' value='2' />\
                    <label for='"+QUESTION_VAR_FALSE+"'><img for='"+QUESTION_VAR_FALSE+"' src='"+false_image+"' width='70' height='70' alt='False' /></label>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_UNDECIDED+"' value='0.5' />\
                    <label for='"+QUESTION_VAR_UNDECIDED+"'><img for='"+QUESTION_VAR_UNDECIDED+"' src='"+undecided_image+"' width='70' height='70' alt='Undecided' /></label>\
                </div>";
            
            var custom_html_value = setDefaultValue;
            
        } else {
            var custom_html_value = fieldData.value;
        }
        
        return {
            field: formatFactory(custom_html_value),
            onRender: function(){
                var name_field_id = $('input[value='+fieldData.name.replace('-preview','')+']').attr('id'); 
                var value_field_id = name_field_id.replace('name-','value-');
                
                $('#'+value_field_id).val(custom_html_value);
            }
        }
        
    },
    yes_no_undecided_question_template:function(fieldData){
        
        if(!fieldData.hasOwnProperty('value')){
       
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_VAR_NAME = unique_var;
            var QUESTION_VAR_YES = unique_var;
            var QUESTION_VAR_NO = unique_var;
            var QUESTION_VAR_UNDECIDED = unique_var;
            
            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null){ alert('This is a required field!'); return false; }

            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR_NAME = 'yn2_q_'+QUESTION_VAR;
            var QUESTION_VAR_YES = 'yn2_q_'+QUESTION_VAR+'_t';
            var QUESTION_VAR_NO = 'yn2_q_'+QUESTION_VAR+'_f';
            var QUESTION_VAR_UNDECIDED = 'yn2_q_'+QUESTION_VAR+'_u';
            var yes_image = APP_BASE_URL+'public/img/assessments/types/yn2/Yes.png';
            var no_image = APP_BASE_URL+'public/img/assessments/types/yn2/No.png';
            var undecided_image = APP_BASE_URL+'public/img/assessments/types/yn2/Undecided.png';
         
            var setDefaultValue = "\
                <p>"+QUESTION_TEXT+"</p>\
                <div id='radio-image-selector' class='row'>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_YES+"' value='1' />\
                    <label for='"+QUESTION_VAR_YES+"'><img for='"+QUESTION_VAR_YES+"' src='"+yes_image+"' width='70' height='70' alt='True' /></label>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_NO+"' value='2' />\
                    <label for='"+QUESTION_VAR_NO+"'><img for='"+QUESTION_VAR_NO+"' src='"+no_image+"' width='70' height='70' alt='False' /></label>\
                    <input oninvalid='$(this).nextAll(\"label\").eq(0).css(\"border-bottom\", \"2px solid #ffc107\");' type='radio' name='"+QUESTION_VAR_NAME+"' id='"+QUESTION_VAR_UNDECIDED+"' value='0.5' />\
                    <label for='"+QUESTION_VAR_UNDECIDED+"'><img for='"+QUESTION_VAR_UNDECIDED+"' src='"+undecided_image+"' width='70' height='70' alt='Undecided' /></label>\
                </div>";
            
            var custom_html_value = setDefaultValue;
            
        } else {
            var custom_html_value = fieldData.value;
        }
        
        return {
            field: formatFactory(custom_html_value),
            onRender: function(){
                var name_field_id = $('input[value='+fieldData.name.replace('-preview','')+']').attr('id'); 
                var value_field_id = name_field_id.replace('name-','value-');
                
                $('#'+value_field_id).val(custom_html_value);
            }
        }        
    }

};


const fb_replaceFields = [
//    {
//      type: "customHTMLTemplate",
//      label: "123",
////      icon: "☑"
//    }
];


//All input set fields (multiple input fields) template
//Note: it is considered inputSet if it has fields[] beacause it means it can hold multiple fields.
const fb_inputSets = [
    {
       label: 'Radio template (Single Answer)',
       name: 'single-answer-template', 
       fields: [
            {
                type: 'radio-group',
                label: '[ Enter your question here ]',
                values: [
                    {
                        label: 'Yes',
                        value: 'Y'
                    },
                    {
                        label: 'No',
                        value: 'N'
                    },
                    {
                        label: 'Undecided',
                        value: 'U'
                    }
                ]
            }
       ]
    }, 
    {
        label:'Checkbox template (Multiple Answer)',
        name: 'multiple-answer-template',
        fields:[
            {
                type: 'checkbox-group',
                label: "[ Enter your question here ]",
                values: [
                            {
                                label: 'Option 1',
                                value: 'option-1'
                            },
                            {
                                label: 'Option 2',
                                value: 'option-2'
                            },
                            {
                                label: 'Option 3',
                                value: 'option-3'
                            },
                            {
                                label: 'Option 4',
                                value: 'option-4'
                            }
                        ]
            }, 
        ]
    },
];

const fb_typeUserAttrs = {
    'startPageMarker': {
        randomize: {
            label: 'Randomize',
            options: {
                false: 'No',
                true : 'Yes',
            },
        },
        setTimer: {
            label: 'Add Timer (In Minutes)',
            value: 0,
        },
        onTimerTimesUp: {
            label: 'OnTimesUp (Javascript)',
            options: {
                'console.log("Times up!");' : 'Do nothing',
                'alert("Times up! Your current answers will be submitted");': 'Alert Candidate',
                'alert("Times up! Your current answers will be submitted"); $("input").prop("required",false);  $("form#test_form").submit();': 'Alert Candidate | Auto Submit Form',
            },
        },
        enableSnapshot: {
            label: 'Take Snapshot (Desktop)',
            options: {
                false: 'No',
                true : 'Yes',
            },
        }
    },
    customHTMLTemplate: {
        question_type: {
            label: 'Question Type',
            options: {
                '': 'none',
                'adap_mc':'adap_mc',
                'cd':'cd',
                'ein':'ein',
                'lkr':'lkr',
                'mc1':'mc1',
                'mc2':'mc2',
                'mc3':'mc3',
                'mc4':'mc4',
                'pti':'pti',
                'rn1':'rn1',
                'rn2':'rn2',
                'rn3':'rn3',
                'scor_mc':'scor_mc',
                'tf1':'tf1',
                'tf2':'tf2',
                'wh':'wh',
                'yn1':'yn1',
                'yn2':'yn2',
            },
        },
        fldQOrder: {
            label: 'Question Order',
            options: {
                '':'None',
                'display_top': 'Display Top',
                'display_bottom':'Display Bottom',
            },
        }
    },
    sliderQuestion:{
        question_type: {
            label: 'Question Type',
            options: {
                'lkr':'lkr',
            },
        },
        slider_options: {
            label: 'Slider Options',
            options: {
                '1':'"1-Strongly Disagree", "2-Disagree", "3-Neutral", "4-Agree", "5-Strongly Agree"',
                '2':'"1-Very Untrue of Me", "2-Untrue of Me", "3-Somewhat Untrue of Me", "4-Neither True or Untrue", "5-Somewhat True of Me", "6-True of Me", "7-Very True of Me"',
            },
        },
    },
    rankingQuestion:{
        question_type: {
            label: 'Question Type',
            options: {
                'rn1':'rn1',
                'rn2':'rn2',
            },
        },
        rn_question: {
            label: 'Ranking Question',
            options: {
                '1':'"1-Which is most like you?", "2-Which is least like you?", "3-Of the remaining two, which is more like you?"',
                '2':'"1-Least like you", "2-Next Least like you", "3-Next Most like you", "4-Most like you"',
            },
        }
    },  
};


const fb_controlOrder = [
    'startPageMarker',
    'header',
    'paragraph',
    'autocomplete',
    'checkbox-group',
    'select',
    'radio-group',
    'date',
    'hidden',
    'number',
    'text',
    'textarea',
    'file',
    'starRating',
    'single-answer-template',
    'multiple-answer-template',
    'single_char_question_template',
    'true_false_question_template',
    'true_false_undecided_question_template',
    'yes_no_question_template',
    'yes_no_undecided_question_template',
    'customMC1Question',
    'customMC2Question',
    'likertQuestion',
    'LeastBestQuestion',
    'rankingQuestion',
    'sliderQuestion',
    'customHTMLTemplate',
    'button',
    'endPageMarker',
];