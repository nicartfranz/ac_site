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
      type: 'sliderTemplate',
      label: 'Slider template (Single answer) 0-5 Steps',
      attrs: {
        type: 'sliderTemplate',
      },
      icon: '',
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
        label: "<span class='text-info'><b>Start Page Marker</b></span> [SOP]",
    },
    {
        type: "endPageMarker",
        label: "<span class='text-danger'><b>End Page Marker</b></span> [SOP]",
    },
    {
        type: "likertQuestion",
        required: false,
        label: "<b>#1 Likert Scale</b>",
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
        label: "<b>#2 Least - Best Answer</b>",
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
    sliderTemplate: function(fieldData) { 
        return {
            field: '<input type="range" class="custom-range" min="0" max="5" id="'+fieldData.name+'">'
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
            fieldData.value = '######### START OF PAGE ###########';
        }
        
        var note = fieldData.value;
        return {
            field: '<form method="POST"><p id="'+fieldData.name+'">'+note+'</p>',
            onRender: function(){
                $('p#'+fieldData.name).html(note).css('text-align', 'center');
            }
        }
    },
    endPageMarker: function (fieldData){
        
        if(fieldData.value == '' || fieldData.value === undefined){
            fieldData.value = '######### END OF PAGE ###########';
        }
        
        var note = fieldData.value;
        return {
            field: '<p id="'+fieldData.name+'">'+note+'</p></form>',
            onRender: function(){
                $('p#'+fieldData.name).html(note).css('text-align', 'center');
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
        <td><center><input type='radio' name='q1' value='1'></center></td>\n\
        <td><center><input type='radio' name='q1' value='2'></center></td>\n\
        <td><center><input type='radio' name='q1' value='3'></center></td>\n\
        <td><center><input type='radio' name='q1' value='4'></center></td>\n\
        <td><center><input type='radio' name='q1' value='5'></center></td>\n\
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
            value: 'alert("Times up! Your current answers will be submitted"); $("input").prop("required",false);  $("form#test_form").submit();',
        },
        enableSnapshot: {
            label: 'Take Snapshot (Desktop)',
            options: {
                false: 'No',
                true : 'Yes',
            },
        }
    },
    'autocomplete': {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
        
    },
    'checkbox-group': {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    date: {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    hidden: {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    number: {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    'radio-group': {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    select: {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    text: {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    textarea: {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    starRating: {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    sliderTemplate: {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    'single-answer-template': {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    'multiple-answer-template': {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    },
    customHTMLTemplate: {
        part: {
            label: 'Part', 
            value: '0',
        },
        section: {
            label: 'Section', 
            value: '0',
        },
        fldQOrder: {
            label: 'Question Order', 
            value: '0',
        },
        correctAns: {
            label: 'Correct Answer', 
            value: '1:0;2:0;3:0;4:0;5:1;',
        },
    }
    
};


const fb_controlOrder = [
    'startPageMarker',
    'autocomplete',
    'button',
    'checkbox-group',
    'date',
    'file',
    'header',
    'hidden',
    'number',
    'paragraph',
    'radio-group',
    'select',
    'text',
    'textarea',
    'starRating',
    'sliderTemplate',
    'single-answer-template',
    'multiple-answer-template',
    'customHTMLTemplate',
    'likertQuestion',
    'LeastBestQuestion',
    'endPageMarker',
];