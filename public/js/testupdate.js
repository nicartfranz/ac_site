/*
 * Contributor: Franz
 * May 18, 2020
 * Description: Test update drag and drop
 */
const fbOptions = {
    dataType: 'json',
    formData: questionsJSON, //this is the question json fetch from the database
    fields: fb_customFields,
    inputSets: fb_inputSets,
    templates: fb_templates,
    disabledAttrs: ["multiple"],
    replaceFields: fb_replaceFields,
    sortableControls: true,
    controlOrder: fb_controlOrder,
    typeUserAttrs: fb_typeUserAttrs,
    fieldRemoveWarn: true, // defaults to false
    onSave: function() {
        var fbJsonData = $('.build-wrap').formBuilder('getData', 'json', true);
        
        var assessment_name = $('#assessment_name').val();
        var assessment_code = $('#assessment_code').val();
        var assessment_obj = {'assessment_name': assessment_name,
                              'assessment_code': assessment_code};
        
        if(fbJsonData == '[]'|| assessment_name == '' || assessment_code == ''){
            alert('Please fill all the required field(s).');
        } else {
            
            var is_confirm = confirm('Confirm update');
            if(is_confirm == true){
                var ajax_name = 'update_test';
                $.ajax({
                    url: APP_BASE_URL + "test/submitAjax",
                    type: "POST",
                    data: {"ajax_name" : ajax_name, 'test_id' : test_id,  "formbuilder_json" : fbJsonData, "assessment_obj": assessment_obj},
                    datatype: "json",
                    success: function (response) {
                       if(response == '1'){
                           window.location.href = APP_BASE_URL + "test/view/?id=" + test_id;
                       } else {
                           alert(JSON.stringify(response));
                       }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                       console.log(textStatus, errorThrown);
                    }
                });
            }
        }
   },
//   disableInjectedStyle: true,
};

$(document).ready(function(){
    var formbuilder_main = $('#build-wrap');
    $(formbuilder_main).formBuilder(fbOptions);
});