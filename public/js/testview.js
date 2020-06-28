

$(document).ready(function(){
    var formbuilder_main = $('#build-wrap');
    
    $(formbuilder_main).formRender({
        formData: questionsJSON, // This is json data stored in database when you build the form
        dataType: 'json',
    });
    
    
    //-=-=-=-=-=-=-=-=-=-=-= radio image tf2 -=-=-=-=-=-=-=-=-=-=-=
    $('div#radio-image-selector input:radio').addClass('input_radio_hidden');
    
    $(document).on("click", "#radio-image-selector label", function(){
        var id = $(this).attr('for');
        $('input#'+id).attr('checked', 'true');
        $(this).addClass('input_radio_selected').siblings().removeClass('input_radio_selected');
    });
    //-=-=-=-=-=-=-=-=-=-=-= radio image tf2 -=-=-=-=-=-=-=-=-=-=-=

});
