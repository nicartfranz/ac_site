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
        label: "<span class='text-info'>Start Page Marker</span> [SOP]",
    },
    {
        type: "endPageMarker",
        label: "<span class='text-info'>End Page Marker</span> [SOP]",
    },

];


//All field templates
//Note: When creating template make sure you create a register the class too. See the documetation here https://formbuilder.online/docs/formBuilder/options/templates/
const fb_templates = {
    starRating: function(fieldData) {
      return {
        field: '<span id="' + fieldData.name +'">',
        onRender: () => {
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
            field: '<textarea style="min-height: 200px;" class="form-control" id="'+fieldData.name+'">'+custom_html_value+'</textarea>',
//            onRender: () => {
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
            onRender: () => {
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
            onRender: () => {
                $('p#'+fieldData.name).html(note).css('text-align', 'center');
            }
        }
    },
    
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
                label: '<p><span class="text-warning">[ Enter your question here ]</span></p>',
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
//    {
//        label: 'Multiple textbox template (Multiple/Single answer)',
//        name: 'multi-textbox-template',
//        fields: [
//            {
//                type: "paragraph",
//                subtype: "p",
//                className: "col-sm-12",
//                label: "<span class='text-warning'>[ Enter your question here ]</span>*row-x ",
//            },
//            {
//                type: "text",
//                label: "<span class='text-warning'> [ Change > className = row-x ]</span> ***row-x col-sm-3 ",
//                className: "form-control row-x col-sm-3",
//                subtype: "textarea"
//            },
//            {
//                type: "text",
//                label: "<span class='text-warning'> [ Change > className = row-x ]</span> ***row-x col-sm-3 ",
//                className: "form-control row-x col-sm-3",
//                subtype: "textarea"
//            },
//            {
//                type: "text",
//                label: "<span class='text-warning'> [ Change > className = row-x ]</span> ***row-x col-sm-3 ",
//                className: "form-control row-x col-sm-3",
//                subtype: "textarea"
//            },
//            {
//                type: "text",
//                label: "<span class='text-warning'> [ Change > className = row-x ]</span> ***row-x col-sm-3 ",
//                className: "form-control row-x col-sm-3",
//                subtype: "textarea"
//            },
//           
//        ]
//    },
   
];

const fb_typeUserAttrs = {
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
    'endPageMarker',
];