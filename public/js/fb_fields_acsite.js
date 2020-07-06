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
        type: "customMC1Question",
        required: false,
        label: "Custom mc1 Answer",
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
        label: "Custom mc2 Multi-Answer",
        className: "form-control",
        access: false,
        value: "",
        attrs: {
            type: 'textarea',
            subtype: 'textarea',
        }
    }
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
            <div class='col-xs ranking-choice c1_1'>Playful</div>\n\
            <div class='col-xs ranking-choice c1_2'>Strong-willed</div>\n\
            <div class='col-xs ranking-choice c1_3'>Intellectual</div>\n\
            <div class='col-xs ranking-choice c1_4'>Cooperative</div>\n\
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
                label: '<span class="text-warning">[ Enter your question here ]</span>',
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
                label: "<span class='text-warning'>[ Enter your question here ]</span>",
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
    {
        label: 'Single Character Question template',
        name: 'single_char_question_template',
        fields:[
        {
            type: "paragraph",
            subtype: "p",
            label: "<font color=\"#000000\">&lt;input type=\"text\" onkeyup=\"javascript:char_question_onKeyUp(this);\" onblur=\"javascript:char_question_onBlur(this);\" maxlength=\"1\" style=\"width:75px;\" id=\"char_question_1\" name=\"char_question_1\"&gt;&amp;nbsp;Question&lt;hr&gt;</font>",
            access: false
          },
        ]
    },
    {
        label: 'True, False Question Template',
        name: 'true_false_question_template',
        fields:[
        {
            type: "paragraph",
            subtype: "p",
            label: "&lt;p&gt;Question.&lt;/p&gt;<br>&lt;div id=\"radio-image-selector\" class=\"row\"&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"tf1_q_1\" id=\"tf1_q_1_t\" value=\"1\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"tf1_q_1_t\"&gt;&lt;img for=\"tf1_q_1_t\" src=\"../img/assessments/types/tf1/True.png\" width=\"70\" height=\"70\" alt=\"True\" /&gt;&lt;/label&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"tf1_q_1\" id=\"tf1_q_1_f\" value=\"2\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"tf1_q_1_f\"&gt;&lt;img for=\"tf1_q_1_f\" src='../img/assessments/types/tf1/False.png' width=\"70\" height=\"70\" alt=\"False\" /&gt;&lt;/label&gt;<br>&lt;/div&gt;",
            access: false
          },
        ]
    },
    {
        label: 'True, False, Undecided Question Template',
        name: 'true_false_undecided_question_template',
        fields:[
        {
            type: "paragraph",
            subtype: "p",
            label: "&lt;p&gt;Question.&lt;/p&gt;<br>&lt;div id=\"radio-image-selector\" class=\"row\"&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"tf2_q_1\" id=\"tf2_q_1_t\" value=\"1\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"tf2_q_1_t\"&gt;&lt;img for=\"tf2_q_1_t\" src=\"../img/assessments/types/tf2/True.png\" width=\"70\" height=\"70\" alt=\"True\" /&gt;&lt;/label&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"tf2_q_1\" id=\"tf2_q_1_f\" value=\"2\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"tf2_q_1_f\"&gt;&lt;img for=\"tf2_q_1_f\" src='../img/assessments/types/tf2/False.png' width=\"70\" height=\"70\" alt=\"False\" /&gt;&lt;/label&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"tf2_q_1\" id=\"tf2_q_1_u\" value=\"0.5\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"tf2_q_1_u\"&gt;&lt;img for=\"tf2_q_1_u\" src='../img/assessments/types/tf2/Undecided.png' width=\"70\" height=\"70\" alt=\"Undecided\" /&gt;&lt;/label&gt;<br>&lt;/div&gt;",
            access: false
          },
        ]
    },
    {
        label: 'Yes, No Question Template',
        name: 'yes_no_question_template',
        fields:[
        {
            type: "paragraph",
            subtype: "p",
            label: "&lt;p&gt;Question.&lt;/p&gt;<br>&lt;div id=\"radio-image-selector\" class=\"row\"&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"yn1_q_1\" id=\"yn1_q_1_y\" value=\"1\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"yn1_q_1_y\"&gt;&lt;img for=\"yn1_q_1_y\" src=\"../img/assessments/types/yn1/Yes.png\" width=\"70\" height=\"70\" alt=\"Yes\" /&gt;&lt;/label&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"yn1_q_1\" id=\"yn1_q_1_n\" value=\"2\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"yn1_q_1_n\"&gt;&lt;img for=\"yn1_q_1_n\" src='../img/assessments/types/yn1/No.png' width=\"70\" height=\"70\" alt=\"No\" /&gt;&lt;/label&gt;<br>&lt;/div&gt;",
            access: false
          },
        ]
    },
    {
        label: 'Yes, No, Undecided Question Template',
        name: 'yes_no_undecided_question_template',
        fields:[
        {
            type: "paragraph",
            subtype: "p",
            label: "&lt;p&gt;Question.&lt;/p&gt;<br>&lt;div id=\"radio-image-selector\" class=\"row\"&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"yn2_q_1\" id=\"yn2_q_1_y\" value=\"1\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"yn2_q_1_y\"&gt;&lt;img for=\"yn2_q_1_y\" src=\"../img/assessments/types/yn2/Yes.png\" width=\"70\" height=\"70\" alt=\"Yes\" /&gt;&lt;/label&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"yn2_q_1\" id=\"yn2_q_1_n\" value=\"2\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"yn2_q_1_n\"&gt;&lt;img for=\"yn2_q_1_n\" src='../img/assessments/types/yn2/No.png' width=\"70\" height=\"70\" alt=\"No\" /&gt;&lt;/label&gt;<br>&nbsp;&nbsp;&nbsp; &lt;input type=\"radio\" name=\"yn2_q_1\" id=\"yn2_q_1_u\" value=\"0.5\" /&gt;<br>&nbsp;&nbsp;&nbsp; &lt;label for=\"yn2_q_1_u\"&gt;&lt;img for=\"yn2_q_1_u\" src='../img/assessments/types/yn2/Undecided.png' width=\"70\" height=\"70\" alt=\"Undecided\" /&gt;&lt;/label&gt;<br>&lt;/div&gt;",
            access: false
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
//    customMC1Question:{
//        question_type: {
//            label: 'Question Type',
//            options: {
//                'mc1':'mc1',
//                'mc2':'mc2',
//                'mc3':'mc3',
//                'mc4':'mc4',
//            },
//        },
//    },  
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