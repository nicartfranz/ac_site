/*
 * Contributor: Franz
 * May 16, 2020
 * Description: Test creator drag and drop
 */
const fbOptions = {
    dataType: 'json',
    fields: fb_customFields,
    inputSets: fb_inputSets,
    templates: fb_templates,
    sortableControls: true,
    controlOrder: fb_controlOrder,
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
            
            var is_confirm = confirm('Confirm save');
            if(is_confirm == true){
                var ajax_name = 'save_test';
                $.ajax({
                    url: APP_BASE_URL + "test/submitAjax",
                    type: "POST",
                    data: {"ajax_name" : ajax_name,  "formbuilder_json" : fbJsonData, "assessment_obj": assessment_obj},
                    datatype: "json",
                    success: function (response) {
                       if(response == '1'){
                           alert('Test saved');
                           window.location.href = APP_BASE_URL + "test/search";
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
};

$(document).ready(function(){
    var formbuilder_main = $('#build-wrap');
    $(formbuilder_main).formBuilder(fbOptions);
});