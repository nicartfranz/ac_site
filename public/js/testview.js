

$(document).ready(function(){
    
    var formbuilder_main = $('#build-wrap');
    
    $(formbuilder_main).formRender({
        formData: questionsJSON, // This is json data stored in database when you build the form
        dataType: 'json',
    });
    
    var check_name_attr = {};
    var found = false;
    var test_duplicate_name_attr_str = '';
    $('[name]').each(function() {
        if (this.name && check_name_attr[this.name]) {
            found = true;
            console.warn('AC SITE Warning: Duplicate name attribute '+this.name);
        }
        check_name_attr[this.name] = 1;
    });
    
    if(debug_mode == '1'){
        $('[name]').each(function() {
            $('input[name="'+this.name+'"]').replaceWith( "<div style='border: 1px solid orange;color: black;background: bisque;'>POST/GET Variable: <b>"+this.name+"</b></div>" );
        });
    }
    
    //-=-=-=-=-=-=-=-=-=-=-= radio image tf2 -=-=-=-=-=-=-=-=-=-=-=
    $('div#radio-image-selector input:radio').addClass('input_radio_hidden');
    
    $(document).on("click", "#radio-image-selector label", function(){
        var id = $(this).attr('for');
        $('input#'+id).attr('checked', 'true');
        $(this).addClass('input_radio_selected').siblings().removeClass('input_radio_selected');
    });
    //-=-=-=-=-=-=-=-=-=-=-= radio image tf2 -=-=-=-=-=-=-=-=-=-=-=

});
