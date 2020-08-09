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
    {
        type:"video_question_template",
        label:"Video Question Template",
    },
    {
        type:"record_video_answer_template",
        label:"Record Video Answer Template",
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
        
        if(!fieldData.hasOwnProperty('value')){
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_TEXT_X = 'Text Question X';
            var ADD_MORE_QUESTION = true;
            var QUESTION_VAR = unique_var;

            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR = prompt("Enter the item variable:", "Variable Format: q_lk_1_1");
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            //final question var 
            var QUESTION_VAR = QUESTION_VAR;
            
            var ADD_MORE_QUESTION = confirm("Do you want to add more question(s)?");
            if(ADD_MORE_QUESTION){
                var QUESTION_HTML = "";
                var number_of_new_question = prompt("Enter number of new question(s) to add:", "Please enter a number example '3'");
                parseInt(number_of_new_question);
                if (/^[0-9.,]+$/.test(number_of_new_question)) {
                    
                    for(i=1; i<=number_of_new_question; i++){
                        var QUESTION_TEXT_X = prompt("Enter question:", QUESTION_TEXT_X);
                        if(QUESTION_TEXT_X == null){ alert('This is a required field!'); return false; }
                        
                        if(QUESTION_VAR_X == null){
                            QUESTION_VAR_X = QUESTION_VAR;
                        }
                        
                        var QUESTION_VAR_X = prompt("Enter the item variable:", QUESTION_VAR_X);
                        if(QUESTION_VAR_X == null){ alert('This is a required field!'); return false; }
                        //final question var 

                        QUESTION_HTML += "\n\
                                <tr>\n\
                                    <td>"+QUESTION_TEXT_X+"</td>\n\
                                    <td><center><input type='radio' name='"+QUESTION_VAR_X+"' value='1'></center></td>\n\
                                    <td><center><input type='radio' name='"+QUESTION_VAR_X+"' value='2'></center></td>\n\
                                    <td><center><input type='radio' name='"+QUESTION_VAR_X+"' value='3'></center></td>\n\
                                    <td><center><input type='radio' name='"+QUESTION_VAR_X+"' value='4'></center></td>\n\
                                    <td><center><input type='radio' name='"+QUESTION_VAR_X+"' value='5'></center></td>\n\
                                </tr>\n\
                               ";
                        
                    }

                } else {
                    alert('Error, please enter an integer');
                    return false;
                }
              
            } else {
                var QUESTION_HTML = "";
            }
            
            
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
                                            <td>"+QUESTION_TEXT+"</td>\n\
                                            <td><center><input type='radio' name='"+QUESTION_VAR+"' value='1'></center></td>\n\
                                            <td><center><input type='radio' name='"+QUESTION_VAR+"' value='2'></center></td>\n\
                                            <td><center><input type='radio' name='"+QUESTION_VAR+"' value='3'></center></td>\n\
                                            <td><center><input type='radio' name='"+QUESTION_VAR+"' value='4'></center></td>\n\
                                            <td><center><input type='radio' name='"+QUESTION_VAR+"' value='5'></center></td>\n\
                                        </tr>\n\
                                        "+QUESTION_HTML+"\n\
                                    </tbody>\n\
                                    </table>";

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
    LeastBestQuestion: function(fieldData){

        if(!fieldData.hasOwnProperty('value')){
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_CHOICE_X = 'Choice X';
            var ADD_MORE_CHOICE = true;
            var QUESTION_VAR = unique_var;


            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR = prompt("Enter the item variable:", QUESTION_VAR);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            //final question var 
            var QUESTION_VAR = 'q'+QUESTION_VAR;
        
            var CHOICE_HTML = "";
            var number_of_choices = prompt("Enter number of choice(s):", "Please enter a number example '3'");
            parseInt(number_of_choices);
            if (/^[0-9.,]+$/.test(number_of_choices) && number_of_choices >= 2) {

                for(i=1; i<=number_of_choices; i++){
                    var QUESTION_CHOICE_X = prompt("Enter choice:", QUESTION_CHOICE_X);
                    if(QUESTION_CHOICE_X == null){ alert('This is a required field!'); return false; }

                    CHOICE_HTML += "\n\
                                <div class='least-best-checkbox'>\n\
                                    "+QUESTION_CHOICE_X+"\n\
                                    <input type='checkbox' name='"+QUESTION_VAR+"[]' value='"+i+"'>\n\
                                </div>\n\
                                ";
                }

            } else {
                var CHOICE_HTML = "";
                alert('This is a required field/Number of choices must be more than 1!'); return false;
            }

            var setDefaultValue = "\n\
                                    <p>"+QUESTION_TEXT+"</p>\n\
                                    <div class='least-best-div' id='"+QUESTION_VAR+"'>\n\
                                        "+CHOICE_HTML+"\n\
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
                
                $('#'+value_field_id).val(formatFactory(custom_html_value));
            }
        }
        
        
    },
    rankingQuestion: function (fieldData){

        if(!fieldData.hasOwnProperty('value')){
            var QUESTION_CHOICE_1 = 'Playful|I am full of fun and good humor.';
            var QUESTION_CHOICE_2 = 'Strong-willed|I am determined to have my way.';
            var QUESTION_CHOICE_3 = 'Intellectual|I am intelligent or knowledgeable; I am an academic.';
            var QUESTION_CHOICE_4 = 'Cooperative|I am obliging, helpful, and supportive.';

            var QUESTION_VAR = prompt("Enter the item variable:", "Variable format: 1");
            if(QUESTION_VAR == null || QUESTION_VAR == '' || !/^[0-9.,]+$/.test(QUESTION_VAR)){ alert('This is a required field/variable should be an integer!'); return false; }
        
            var QUESTION_CHOICE_1 = prompt("Enter choice:", "Choice format: "+QUESTION_CHOICE_1);
            if(QUESTION_CHOICE_1 == null || QUESTION_CHOICE_1 == ''){ alert('This is a required field!'); return false; }
            QUESTION_CHOICE_1 = QUESTION_CHOICE_1.split("|");
            QUESTION_CHOICE_1_key = QUESTION_CHOICE_1[0];
            QUESTION_CHOICE_1_value = QUESTION_CHOICE_1[1];
            
            var QUESTION_CHOICE_2 = prompt("Enter choice:", "Choice format: "+QUESTION_CHOICE_2);
            if(QUESTION_CHOICE_2 == null || QUESTION_CHOICE_2 == ''){ alert('This is a required field!'); return false; }
            QUESTION_CHOICE_2 = QUESTION_CHOICE_2.split("|");
            QUESTION_CHOICE_2_key = QUESTION_CHOICE_2[0];
            QUESTION_CHOICE_2_value = QUESTION_CHOICE_2[1];
            
            var QUESTION_CHOICE_3 = prompt("Enter choice:", "Choice format: "+QUESTION_CHOICE_3);
            if(QUESTION_CHOICE_3 == null || QUESTION_CHOICE_3 == ''){ alert('This is a required field!'); return false; }
            QUESTION_CHOICE_3 = QUESTION_CHOICE_3.split("|");
            QUESTION_CHOICE_3_key = QUESTION_CHOICE_3[0];
            QUESTION_CHOICE_3_value = QUESTION_CHOICE_3[1];
            
            var QUESTION_CHOICE_4 = prompt("Enter choice:", "Choice format: "+QUESTION_CHOICE_4);
            if(QUESTION_CHOICE_4 == null || QUESTION_CHOICE_4 == ''){ alert('This is a required field!'); return false; }
            QUESTION_CHOICE_4 = QUESTION_CHOICE_4.split("|");
            QUESTION_CHOICE_4_key = QUESTION_CHOICE_4[0];
            QUESTION_CHOICE_4_value = QUESTION_CHOICE_4[1];

            var setDefaultValue = "\n\
                                    <div class='container-fluid'>\n\
                                        <div class='row ranking-question'>\n\
                                            <div class='col-sm ranking-question-box-left' id='q"+QUESTION_VAR+"'>\n\
                                            </div>\n\
                                            <div class='col-sm ranking-question-box-right'>\n\
                                            <div class='row ranking-choice-box' id='q"+QUESTION_VAR+"'>\n\
                                                <div class='col-xs ranking-choice c"+QUESTION_VAR+"_1' value='4'>"+QUESTION_CHOICE_1_key+"</div>\n\
                                                <div class='col-xs ranking-choice c"+QUESTION_VAR+"_2' value='1'>"+QUESTION_CHOICE_2_key+"</div>\n\
                                                <div class='col-xs ranking-choice c"+QUESTION_VAR+"_3' value='3'>"+QUESTION_CHOICE_3_key+"</div>\n\
                                                <div class='col-xs ranking-choice c"+QUESTION_VAR+"_4' value='2'>"+QUESTION_CHOICE_4_key+"</div>\n\
                                            </div>\n\
                                            <br>\n\
                                            <p><b>"+QUESTION_CHOICE_1_key+"</b> - "+QUESTION_CHOICE_1_value+"</p>\n\
                                            <p><b>"+QUESTION_CHOICE_2_key+"</b> - "+QUESTION_CHOICE_2_value+"</p>\n\
                                            <p><b>"+QUESTION_CHOICE_3_key+"</b> - "+QUESTION_CHOICE_3_value+"</p>\n\
                                            <p><b>"+QUESTION_CHOICE_4_key+"</b> - "+QUESTION_CHOICE_4_value+"</p>\n\
                                        </div>\n\
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
                
                $('#'+value_field_id).val(formatFactory(custom_html_value));
            }
        }
        
        
    },
    sliderQuestion: function(fieldData){

        if(!fieldData.hasOwnProperty('value')){
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_VAR = unique_var;

            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }
            var QUESTION_VAR = prompt("Enter the item variable:", QUESTION_VAR);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }

            //final question var 
            var QUESTION_VAR = 'q_sl_'+QUESTION_VAR;

            var setDefaultValue = "\n\
                                <div class='sliderTypeQuestion'>\n\
                                    <div>\n\
                                        "+QUESTION_TEXT+"\n\
                                    </div>\n\
                                    <br>\n\
                                    <div class='sliderTypeQuestion_text' id='"+QUESTION_VAR+"'><span>Neutral</span></div>\n\
                                    <br>\n\
                                    <div class='sliderTypeQuestion_choice' id='"+QUESTION_VAR+"'>\n\
                                    <input type='range' class='custom-range' min='1' max='5' step='1' id='sliderTypeQuestion_range' name='"+QUESTION_VAR+"'>\n\
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
                
                $('#'+value_field_id).val(formatFactory(custom_html_value));
            }
        }



    },
    customMC1Question:function(fieldData){

        if(!fieldData.hasOwnProperty('value')){
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_CHOICE_1 = 'Choice 1';
            var QUESTION_CHOICE_2 = 'Choice 2';
            var QUESTION_CHOICE_X = 'Choice X';
            var ADD_MORE_CHOICE = true;
            var QUESTION_VAR = unique_var;


            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR = prompt("Enter the item variable:", QUESTION_VAR);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            //final question var 
            var QUESTION_VAR = 'q'+QUESTION_VAR;
            
            var QUESTION_CHOICE_1 = prompt("Enter choice 1:", QUESTION_CHOICE_1);
            if(QUESTION_CHOICE_1 == null || QUESTION_CHOICE_1 == ''){ alert('This is a required field!'); return false; }
            
            var QUESTION_CHOICE_2 = prompt("Enter choice 2:", QUESTION_CHOICE_2);
            if(QUESTION_CHOICE_2 == null || QUESTION_CHOICE_2 == ''){ alert('This is a required field!'); return false; }

            var ADD_MORE_CHOICE = confirm("Do you want to add more choice(s)?");
            if(ADD_MORE_CHOICE){
                var CHOICE_HTML = "";
                var number_of_new_choice = prompt("Enter number of new choice(s) to add:", "Please enter a number example '3'");
                parseInt(number_of_new_choice);
                if (/^[0-9.,]+$/.test(number_of_new_choice)) {
                    
                    for(i=1; i<=number_of_new_choice; i++){
                        var QUESTION_CHOICE_X = prompt("Enter choice:", QUESTION_CHOICE_X);
                        if(QUESTION_CHOICE_X == null){ alert('This is a required field!'); return false; }

                        CHOICE_HTML += "\n\
                                <div class='row custom_mc_row'>\n\
                                    <label class='custom_mc_container "+QUESTION_VAR+"'>\n\
                                    <input class='custom_mc_radio' type='radio' name='"+QUESTION_VAR+"' value='1'>\n\
                                    "+QUESTION_CHOICE_X+"\n\
                                    </label>\n\
                                </div>\n\
                               ";
                    }

                } else {
                    alert('Error, please enter an integer');
                    return false;
                }
              
            } else {
                var CHOICE_HTML = "";
            }

            var setDefaultValue = "\n\
                <div class='container'><div class='row custom_mc_row_question'>"+QUESTION_TEXT+"</div>\n\
                    <div class='row custom_mc_row'>\n\
                        <label class='custom_mc_container "+QUESTION_VAR+"'>\n\
                        <input class='custom_mc_radio' type='radio' name='"+QUESTION_VAR+"' value='1'>\n\
                        "+QUESTION_CHOICE_1+"\n\
                        </label>\n\
                    </div>\n\
                    <div class='row custom_mc_row'>\n\
                        <label class='custom_mc_container "+QUESTION_VAR+"'>\n\
                        <input class='custom_mc_radio' type='radio' name='"+QUESTION_VAR+"' value='2'>\n\
                        "+QUESTION_CHOICE_2+"\n\
                        </label>\n\
                    </div>\n\
                    "+CHOICE_HTML+"\n\
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
                
                $('#'+value_field_id).val(formatFactory(custom_html_value));
            }
        }

    },
    customMC2Question:function(fieldData){
        
        if(!fieldData.hasOwnProperty('value')){
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_CHOICE_1 = 'Choice 1';
            var QUESTION_CHOICE_2 = 'Choice 2';
            var QUESTION_CHOICE_X = 'Choice X';
            var ADD_MORE_CHOICE = true;
            var QUESTION_VAR = unique_var;

            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR = prompt("Enter the item variable:", QUESTION_VAR);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            //final question var 
            var QUESTION_VAR = 'q'+QUESTION_VAR;
            
            var QUESTION_CHOICE_1 = prompt("Enter choice 1:", QUESTION_CHOICE_1);
            if(QUESTION_CHOICE_1 == null || QUESTION_CHOICE_1 == ''){ alert('This is a required field!'); return false; }
            
            var QUESTION_CHOICE_2 = prompt("Enter choice 2:", QUESTION_CHOICE_2);
            if(QUESTION_CHOICE_2 == null || QUESTION_CHOICE_2 == ''){ alert('This is a required field!'); return false; }
            
            var ADD_MORE_CHOICE = confirm("Do you want to add more choice(s)?");
            if(ADD_MORE_CHOICE){
                var CHOICE_HTML = "";
                var number_of_new_choice = prompt("Enter number of new choice(s) to add:", "Please enter a number example '3'");
                parseInt(number_of_new_choice);
                if (/^[0-9.,]+$/.test(number_of_new_choice)) {
                    
                    for(i=1; i<=number_of_new_choice; i++){
                        var QUESTION_CHOICE_X = prompt("Enter choice:", QUESTION_CHOICE_X);
                        if(QUESTION_CHOICE_X == null){ alert('This is a required field!'); return false; }

                        CHOICE_HTML += "\n\
                                <div class='row custom_mc_row'>\n\
                                        <label class='custom_mc_container "+QUESTION_VAR+"'>\n\
                                                <input class='custom_mc_checkbox' type='checkbox' name='"+QUESTION_VAR+"[]' value='1'>\n\
                                                "+QUESTION_CHOICE_X+"\n\
                                        </label>\n\
                                </div>\n\
                               ";
                    }

                } else {
                    alert('Error, please enter an integer');
                    return false;
                }
              
            } else {
                var CHOICE_HTML = "";
            }

            var setDefaultValue = "\n\
            <div class='container'>\n\
                <div class='row custom_mc_row_question'>"+QUESTION_TEXT+"</div>\n\
                <div class='row custom_mc_row'>\n\
                        <label class='custom_mc_container "+QUESTION_VAR+"'>\n\
                                <input class='custom_mc_checkbox' type='checkbox' name='"+QUESTION_VAR+"[]' value='1'>\n\
                                "+QUESTION_CHOICE_1+"\n\
                        </label>\n\
                </div>\n\
                <div class='row custom_mc_row'>\n\
                        <label class='custom_mc_container "+QUESTION_VAR+"'>\n\
                                <input class='custom_mc_checkbox' type='checkbox' name='"+QUESTION_VAR+"[]' value='2'>\n\
                                "+QUESTION_CHOICE_2+"\n\
                        </label>\n\
                </div>\n\
                "+CHOICE_HTML+"\n\
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
                
                $('#'+value_field_id).val(formatFactory(custom_html_value));
            }
        }
        
        
    },
    single_char_question_template:function(fieldData){
        
        if(!fieldData.hasOwnProperty('value')){
            var QUESTION_TEXT = 'Text Question'
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_VAR = unique_var;

            var QUESTION_TEXT = prompt("Enter the item question:", QUESTION_TEXT);
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }
            var QUESTION_VAR = prompt("Enter the item variable:", QUESTION_VAR);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }

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
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }

            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            
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
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }

            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            
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
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }

            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            
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
            if(QUESTION_TEXT == null || QUESTION_TEXT == ''){ alert('This is a required field!'); return false; }

            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            
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
    },
    video_question_template:function(fieldData){
        
        var assessment_code = $('input#assessment_code').val();
        if(assessment_code == null || assessment_code == ''){
            alert('Please enter assessment code');
            return false;
        }
        
        if(!fieldData.hasOwnProperty('value')){
       
            var assessment_code = $('#assessment_code').val();
            var unique_var = '###'+Date.now()+'###';
            var QUESTION_VAR_NAME = unique_var;

            var VIDEO_QUESTION_FOLDER = assessment_code

            var QUESTION_FILENAME = prompt("Enter the video question filename:");
            if(QUESTION_FILENAME == null || QUESTION_FILENAME == ''){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR_NAME = 'video_'+QUESTION_VAR;
            var MODAL_VAR_NAME = 'modal_video_'+QUESTION_VAR;
         
            var setDefaultValue = "\
                <div class='modal' id='"+MODAL_VAR_NAME+"'>\
                    <div class='modal-dialog'>\
                        <div class='modal-content'>\
                            <div class='modal-header'>\
                                <h4 class='modal-title'>"+QUESTION_FILENAME+"</h4>\
                                <button type='button' class='close' data-dismiss='modal'>&times;</button>\
                            </div>\
                            <div class='modal-body'>\
                                <button class='btn btn-xs btn-success btn-start-recording' id='start_"+QUESTION_VAR_NAME+"' data-video-id='"+QUESTION_VAR_NAME+"'>Start Recording</button>\
                                <button class='btn btn-xs btn-danger btn-stop-recording' id='stop_"+QUESTION_VAR_NAME+"' data-video-id='"+QUESTION_VAR_NAME+"' disabled>Stop Recording</button>\
                                <div class='video_holder'><video style='width: 100%; padding: 10px 0px;' class='"+QUESTION_VAR_NAME+"' controls autoplay playsinline></video></div>\
                            </div>\
                            <div class='modal-footer'>\
                                <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>\
                                <button style='display: none;' type='button' class='btn btn-success btn-save-recording' id='save_"+QUESTION_VAR_NAME+"' data-video-id='"+QUESTION_VAR_NAME+"' data-video-filename='"+QUESTION_FILENAME+"'>Save</button>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div id='video_question_box'>\
                    <button type='button' data-toggle='modal' data-target='#"+MODAL_VAR_NAME+"' class='btn btn-primary record_video_question' id='"+QUESTION_VAR_NAME+"' name='"+QUESTION_VAR_NAME+"' data-filename='"+QUESTION_FILENAME+"'>Record Video Question</button>\
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
                
                function captureCamera(callback) {
                    navigator.mediaDevices.getUserMedia({ audio: true, video: true }).then(function(camera) {
                        callback(camera);
                    }).catch(function(error) {
                        alert('Unable to capture your camera. Please check console logs.');
                        console.error(error);
                    });
                }

                function stopRecordingCallback() {
                    video.src = video.srcObject = null;
                    video.muted = false;
                    video.volume = 1;
                    video.src = URL.createObjectURL(recorder.getBlob());

                    recorder.camera.stop();
//                    recorder.destroy();
//                    recorder = null;
                }

                var recorder; // globally accessible
                var video = document.querySelector('video');
                
                $('.btn-start-recording').on('click', function(){
                    var this_button_id = $(this).attr('id');
                    var this_data_video_id = $(this).attr('data-video-id');
                    video = $('video.'+this_data_video_id)[0];
                    
                    
                    //alert('btn-start-recording: ' + this_button_id); 
                    this.disabled = true;
                    captureCamera(function(camera) {
                        video.muted = true;
                        video.volume = 0;
                        video.srcObject = camera;

                        recorder = RecordRTC(camera, {
                            type: 'video'
                        });

                        recorder.startRecording();

                        // release camera on stopRecording
                        recorder.camera = camera;

                        $('button#stop_'+this_data_video_id).removeAttr('disabled');
                    });
                    
                    // auto stop recording after 60 seconds
                    var milliSeconds = (60 * 1000) + 1000;
                    setTimeout(function() {
                        recorder.stopRecording(stopRecordingCallback);
                    }, milliSeconds);
                    
                });
                
                $('.btn-stop-recording').on('click', function(){
                    var this_button_id = $(this).attr('id');
                    var this_data_video_id = $(this).attr('data-video-id');
                    video = $('video.'+this_data_video_id)[0];

                    this.disabled = true;
                    $('button#start_'+this_data_video_id).removeAttr('disabled');
                    $('button#save_'+this_data_video_id).css('display', 'block');
                    
                    recorder.stopRecording(stopRecordingCallback);
                });
                
                $('.btn-save-recording').on('click', function(){
                    var this_button_id = $(this).attr('id');
                    var this_data_video_id = $(this).attr('data-video-id');
                    var this_data_video_filename = $(this).attr('data-video-filename');
                    video = $('video.'+this_data_video_id)[0];
                   
                    $('#modal_'+this_data_video_id).modal("hide")
                    
                    $('#start_'+this_data_video_id).removeAttr('disabled');
                    
                    // get recorded blob
                    var blob = recorder.getBlob();

                    // generating a random file name
                    var fileName = this_data_video_filename+'.webm';

                    // we need to upload "File" --- not "Blob"
                    var fileObject = new File([blob], fileName, {
                        type: 'video/webm'
                    });

                    var formData = new FormData();

                    // recorded data
                    formData.append('video-blob', fileObject);
                    // file name
                    formData.append('video-filename', fileObject.name);
                    //video folder
                    formData.append('video-folder', VIDEO_QUESTION_FOLDER);
                    
                    var upload_url = APP_BASE_URL + "test/submitAjax";
                    // upload using jQuery
                    var ajax_name = 'save_video_question';
                    formData.append('ajax_name', ajax_name);
                    $.ajax({
                        url: upload_url, // replace with your own server URL
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function(response) {
                            if (response === 'success') {
                                
                                $('button#'+this_data_video_id).replaceWith("<button type='button' class='btn btn-secondary'>Video Question Saved</button>");
                                $('#modal_'+this_data_video_id).modal('hide');
                                
                                //This is the video question
                                var video_tag_inside_modal = $('div.modal#modal_'+this_data_video_id+ ' > div > div > div.modal-body > div').html();
                                var $final_video_tag = $('<div>').html(video_tag_inside_modal);
                                $final_video_tag.find('video').attr("src", APP_BASE_URL+'public/video_questions/'+VIDEO_QUESTION_FOLDER+'/'+fileName).html();
                                $final_video_tag.find('video').removeAttr('autoplay playsinline').html();
                                var video_question = $final_video_tag.html();
                                console.log(video_question);
                                $('#'+value_field_id).val(video_question);
                                
                                alert('Successfully created a video question.');
                            } else {
                                alert(response); // error/failure
                            }
                        }
                    });
                    
                });

            }
        }    
    },
    record_video_answer_template: function(fieldData){
        if(!fieldData.hasOwnProperty('value')){
       
            var unique_var = '###'+Date.now()+'###';
            var BUTTON_VAR_NAME = unique_var;
            
            var QUESTION_VAR = prompt("Enter the item variable:", unique_var);
            if(QUESTION_VAR == null || QUESTION_VAR == ''){ alert('This is a required field!'); return false; }
            
            var QUESTION_VAR_NAME = 'record_video_ans_'+QUESTION_VAR;
            var QUESTION_FILENAME = 'video_ans_'+QUESTION_VAR;
            //var no_image = APP_BASE_URL+'public/img/assessments/types/yn2/No.png';
            var MODAL_VAR_NAME = 'modal_record_video_ans_'+QUESTION_VAR;
         
            var setDefaultValue = "\
                <div class='modal' id='"+MODAL_VAR_NAME+"'>\
                    <div class='modal-dialog'>\
                        <div class='modal-content'>\
                            <div class='modal-header'>\
                                <h4>Record Video Answer</h4>\
                                <button type='button' class='close' data-dismiss='modal'>&times;</button>\
                            </div>\
                            <div class='modal-body'>\
                                <button type='button' class='btn btn-xs btn-success btn-start-recording-candidate' id='start_"+QUESTION_VAR_NAME+"' data-video-id='"+QUESTION_VAR_NAME+"'>Start Recording</button>\
                                <button type='button' class='btn btn-xs btn-danger btn-stop-recording-candidate' id='stop_"+QUESTION_VAR_NAME+"' data-video-id='"+QUESTION_VAR_NAME+"' disabled>Stop Recording</button>\
                                <div class='video_holder'><video style='width: 100%; padding: 10px 0px;' class='"+QUESTION_VAR_NAME+"' controls autoplay playsinline></video></div>\
                            </div>\
                            <div class='modal-footer'>\
                                <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>\
                                <button style='display: none;' type='button' class='btn btn-success btn-save-recording-candidate' id='save_"+QUESTION_VAR_NAME+"' data-video-id='"+QUESTION_VAR_NAME+"' data-video-filename='"+QUESTION_FILENAME+"'>Submit</button>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
                <div style='padding: 5px;'>\
                    <button type='button' data-toggle='modal' data-target='#"+MODAL_VAR_NAME+"' class='btn btn-primary record_video_answer' id='"+QUESTION_VAR_NAME+"' name='"+QUESTION_VAR_NAME+"' data-filename='"+QUESTION_FILENAME+"'><i class='fas fa-video'></i>&nbsp;Record Video Answer</button>\
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
    'video_question_template',
    'record_video_answer_template',
    'customHTMLTemplate',
    'button',
    'endPageMarker',
];