$(document).ready(function(){
    var formbuilder_main = $('#build-wrap');
    
    $(formbuilder_main).formRender({
          formData: questionsJSON, // This is json data stored in database when you build the form
          dataType: 'json'
        }
    );
    
});
