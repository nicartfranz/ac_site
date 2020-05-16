/*
 * Contributor: Franz
 * May 16, 2020
 * Description: Test creator drag and drop
 */

//All custom fields template
const customFields = [
    {
      type: 'autocomplete',
      label: 'Custom Autocomplete',
      required: true,
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
    
//    {
//      label: 'Star Rating',
//      attrs: {
//        type: 'starRating',
//      },
//      icon: '🌟',
//    },
];


//All field templates
const templates = {
//    starRating: function(fieldData) {
//      return {
//        field: '<span id="' + fieldData.name + '">',
//        onRender: () => {
//          $(document.getElementById(fieldData.name)).rateYo({ rating: 3.6 })
//        },
//      }
//    },
};

//All input set fields (multiple input fields) template
//Note: it is considered inputSet if it has fields[] beacause it means it can hold multiple fields.
const inputSets = [
    {
       label: 'Yes / No / Undecided Question',
       name: 'yes-no-undecided-text-question-template', 
       fields: [
            {
                type: 'radio-group',
                label: '<p>Enter your question here Lorem Ipsum is simply dummy text?</p>',
                inline: true,
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
        label:'Multiple Answer Question',
        name: 'multiple-answer-question-template',
        fields:[
            {
            type: 'checkbox-group',
            required: false,
            label: '<p>Enter your question here Lorem Ipsum is simply dummy text?</p>',
            toggle: false,
            inline: false,
            access: false,
            other: false,
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
            }
        ]
    },
    
    
    
    
//    {
//      label: 'User Details',
//      icon: '<i class="far fa-question-circle"></i>',
//      name: 'user-details', // optional
//      showHeader: true, // optional
//      fields: [
//        {
//          type: 'text',
//          label: 'First Name',
//          className: 'form-control',
//        },
//        {
//          type: 'select',
//          label: 'Profession',
//          className: 'form-control',
//          values: [
//            {
//              label: 'Street Sweeper',
//              value: 'option-2',
//              selected: false,
//            },
//            {
//              label: 'Brain Surgeon',
//              value: 'option-3',
//              selected: false,
//            },
//          ],
//        },
//        {
//          type: 'textarea',
//          label: 'Short Bio:',
//          className: 'form-control',
//        },
//      ],
//    },
];

const fbOptions = {
    fields: customFields,
    templates: templates,
    inputSets: inputSets,
    onSave: function() {
        alert($('.build-wrap').formBuilder('getData', 'json', true))
   },
};

$(document).ready(function(){
    var formbuilder_main = $('#build-wrap');
    
    $(formbuilder_main).formBuilder(fbOptions);

//    $('button.save-template').on('click', function(){
//       alert('asfdaf'); 
//    });
    
//    $('.save-template').on('click', function(){
//
//    }
    
});