$(document).ready(function(){
    
    //-=-=-=-=-=-=-=-=-=-=-= Questions -=-=-=-=-=-=-=-=-=-=-=-=-=-=
    var formbuilder_main = $('#build-wrap');
    $(formbuilder_main).formRender({
          formData: questionsJSON, // This is json data stored in database when you build the form
          dataType: 'json'
        }
    );
    //-=-=-=-=-=-=-=-=-=-=-= Questions -=-=-=-=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-= Timer -=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //Timer 
    if(test_time_remaining_hr >= 0 || test_time_remaining_min >= 0 || test_time_remaining_sec >= 0 || test_timer_end_time >= 0){
        $("#test_timer" ).css('display','block');//Show timer

        // Set the date we're counting down to
        var countDownDate = new Date(test_timer_end_time).getTime();
        // Update the count down every 1 second
        var testCountDown = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for hours, minutes and seconds
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="sample_timer"
            if(test_time_remaining_hr >= 0){
                $("span#test_time_remaining_hr").text(pad(hours, 2) + "h :"); 
            } else {
                $("span#test_time_remaining_hr").text('');
            }

            if(test_time_remaining_min >= 0){
                $("span#test_time_remaining_min").text(pad(minutes, 2) + "m :"); 
            } else {
                $("span#test_time_remaining_min").text(''); 
            }

            if(test_time_remaining_sec >= 0){
                $("span#test_time_remaining_sec").text(pad(seconds, 2) + "s"); 
            } else {
                $("span#test_time_remaining_sec").text(''); 
            }

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(testCountDown);
                $("div#test_timer").text("Times up!");
                eval(onTimesup);//run js stored in varible but be careful here.. TO DO: check for other way
            }
        }, 1000);
    }
    $( "#test_timer" ).draggable();

    //-=-=-=-=-=-=-=-=-=-=-= Timer -=-=-=-=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-= str_pad left -=-=-=-=-=-=-=-=-=-=-=
    function pad(str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }
    //-=-=-=-=-=-=-=-=-=-=-= str_pad left -=-=-=-=-=-=-=-=-=-=-=
    
    //-=-=-=-=-=-=-=-=-=-=-= print screen detect key44 only -=-=-=-=-=-=-=-=-=-=-=
    window.addEventListener("keyup", function(e) {
        if (e.keyCode == 44) {
            var printscreen = confirm('Printscreen is prohibited in this site, are you sure you want to continue?');
            if(printscreen){
                $('html').html('<h5>Printscreen is not allowed! you are disqualified</h5>');
            }
        }
    });
//    function stopPrntScr() {
//        var inpFld = document.createElement("input");
//        inpFld.setAttribute("value", ".");
//        inpFld.setAttribute("width", "0");
//        inpFld.style.height = "0px";
//        inpFld.style.width = "0px";
//        inpFld.style.border = "0px";
//        document.body.appendChild(inpFld);
//        inpFld.select();
//        document.execCommand("copy");
//        inpFld.remove(inpFld);
//    }
//    function AccessClipboardData() {
//        try {
//            window.clipboardData.setData('text', "Access Restricted");
//        } catch (err) {
//            console.log('ERROR: ' + err );
//        }
//    }
//    setInterval(AccessClipboardData(), 100);
    //-=-=-=-=-=-=-=-=-=-=-= print screen detect key44 only -=-=-=-=-=-=-=-=-=-=-=
       
    
    //-=-=-=-=-=-=-=-=-=-=-= enableSnapshot -=-=-=-=-=-=-=-=-=-=-=
    if(enableSnapshot == 'true'){
        
        Webcam.set({
                width: 260,
                height: 160,
                image_format: 'jpeg',
                jpeg_quality: 90
        });
        Webcam.attach('#mycamera');
	Webcam.on('live', function() {
            console.log('live');
            Webcam.snap( function(data_uri) {
                var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                document.getElementById('mysnapshot').value = raw_image_data;
            });
	});
	
	Webcam.on('error', function(err) {
            console.log('Error in webcam: ' + err);
	});
        
    }
    //-=-=-=-=-=-=-=-=-=-=-= enableSnapshot -=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-= Least-Best PCA -=-=-=-=-=-=-=-=-=-=-=
    $("div.least-best-checkbox").on("click", function() {
        var selectedBoxParent = $(this).parent("div");
        var selectedBox = $(this).children("input:first");

        //Checking the input[checkbox]
        if (selectedBox.prop("checked")) {
            selectedBox.prop("checked", false);
            $(this).attr("class", "least-best-checkbox"); //get back to original state
            return false;
        } else {
            selectedBox.prop("checked", true);
        }

        //Limiting the allowed checks
        var limit = 2;
        var countChecks = $("#" + selectedBoxParent.attr("id") + ' input[type="checkbox"]').filter(":checked").length;
        if (countChecks > limit) {
            selectedBox.prop("checked", false);
            return false;
        }


        //Tagging as least or best answer
        if (!$(this).hasClass("bg-least") && !$(this).hasClass("bg-best")) {

            var default_setting = 'least_first'; //first selection is least answer, second selection best answer
            if (default_setting == 'least_first') {
                if (countChecks == 1) {
                    $(this).addClass("bg-least");
                } else {

                    var hasClass = '';
                    $("#" + selectedBoxParent.attr("id") + ' > div.least-best-checkbox').each(function(i, obj) {
                        if ($(obj).hasClass('bg-least')) {
                            hasClass = 'bg-least';
                        }
                        if ($(obj).hasClass('bg-best')) {
                            hasClass = 'bg-best';
                        }
                    });

                    if (hasClass == 'bg-least') {
                        $(this).addClass("bg-best");
                    } else {
                        $(this).addClass("bg-least");
                    }

                }
            } else {
                if (countChecks == 1) {
                    $(this).addClass("bg-best");
                } else {

                    var hasClass = '';
                    $("#" + selectedBoxParent.attr("id") + ' > div.least-best-checkbox').each(function(i, obj) {
                        if ($(obj).hasClass('bg-least')) {
                            hasClass = 'bg-least';
                        }
                        if ($(obj).hasClass('bg-best')) {
                            hasClass = 'bg-best';
                        }
                    });

                    if (hasClass == 'bg-least') {
                        $(this).addClass("bg-best");
                    } else {
                        $(this).addClass("bg-least");
                    }

                }
            }

        }

    });
    //-=-=-=-=-=-=-=-=-=-=-= Least-Best PCA -=-=-=-=-=-=-=-=-=-=-=
    
    //-=-=-=-=-=-=-=-=-=-=-= Ranking DISC -=-=-=-=-=-=-=-=-=-=-=
    $(document).on('click', 'span#remove-ranking-choice', function(){
  	var selected_choice_class = $(this).attr('class').split(' ');
        //selected_choice_class[2] = the choice id
        $('div.'+selected_choice_class[2]).css('display', 'block');
        $(this).prev().val('');
        $(this).remove();
    });
  

    $('div.ranking-choice').on('click', function(){
        var selected_choice_parent_id = $(this).parent().attr('id');
        var selected_choice_class = $(this).attr('class');
        var selected_choice_value = $(this).text();
        var has_unanswered = 0;
        //check hidden inupt fields if has answer
        $("div.ranking-question-box-left#" + selected_choice_parent_id + ' > p > input').each(function(i, obj) {
            if($(obj).val() == ''){
                $(obj).val(selected_choice_value.trim());
                $(obj).after('<span id="remove-ranking-choice" class="'+selected_choice_class+'">'+selected_choice_value+'<span class="xmark">&nbsp;x&nbsp;</span></span>');
                has_unanswered++;
                return false;
            } 
        });
        //hide the selected option
        if(has_unanswered > 0){
            $(this).css('display', 'none');
        }
    });
    //-=-=-=-=-=-=-=-=-=-=-= Ranking DISC -=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-= slider type question CPB -=-=-=-=-=-=-=-=-=-=-=
    $('input#sliderTypeQuestion_range').on('change', function(){
        
        var q_sl = $(this).attr('name');
        var slider_value = $(this).val();
        var data_options_key = $(this).attr('data-options-key');//1:2:3:4:5
        var data_options_val = $(this).attr('data-options-val');//Strongly Disagree:Disagree:Neutral:Agree:Strongly Agree
        var data_options_val_arr = data_options_val.split(':');
        var data_options_type = $(this).attr('data-options-type');
        
        //alert(data_options_key + ' ' + data_options_val + ' ' + data_options_type);
        
        var sl_bg = {'background': '#848484'};
        if(data_options_type == '1'){
            
            var sl_bg = {'background': '#848484'};
            if(slider_value == 1){
                sl_bg = {'background': 'rgb(255, 110, 110)'};
                sl_text = data_options_val_arr[0];
            } else if (slider_value == 2){
                sl_bg = {'background': 'rgb(255, 173, 39)'};
                sl_text = data_options_val_arr[1];
            } else if (slider_value == 3){
                sl_bg = sl_bg;
                sl_text = data_options_val_arr[2];
            } else if (slider_value == 4){
                sl_bg = {'background': 'rgb(50, 167, 111)'};
                sl_text = data_options_val_arr[3];
            } else if (slider_value == 5){
                sl_bg = {'background': 'rgb(38, 216, 131)'};
                sl_text = data_options_val_arr[4];
            }
            $('div.sliderTypeQuestion_text#'+q_sl).css(sl_bg);
            $('div.sliderTypeQuestion_text#'+q_sl+' > span').text(sl_text);
            
        } else if (data_options_type == '2'){
            
            var data_options_val_arr = data_options_val.split(':');
            var sl_bg = {'background': '#2cabe1'};
            if(slider_value == 1){
                sl_text = data_options_val_arr[0];
            } else if (slider_value == 2){
                sl_text = data_options_val_arr[1];
            } else if (slider_value == 3){
                sl_text = data_options_val_arr[2];
            } else if (slider_value == 4){
                sl_bg = {'background': '#848484'};
                sl_text = data_options_val_arr[3];
            } else if (slider_value == 5){
                sl_text = data_options_val_arr[4];
            } else if (slider_value == 6){
                sl_text = data_options_val_arr[5];
            } else if (slider_value == 7){
                sl_text = data_options_val_arr[6];
            }
            $('div.sliderTypeQuestion_text#'+q_sl).css(sl_bg);
            $('div.sliderTypeQuestion_text#'+q_sl+' > span').text(sl_text);
            
        } else {
            
            var sl_bg = {'background': '#848484'};
            if(slider_value == 1){
                sl_bg = {'background': 'rgb(255, 110, 110)'};
                sl_text = data_options_val_arr[0];
            } else if (slider_value == 2){
                sl_bg = {'background': 'rgb(255, 173, 39)'};
                sl_text = data_options_val_arr[1];
            } else if (slider_value == 3){
                sl_bg = sl_bg;
                sl_text = data_options_val_arr[2];
            } else if (slider_value == 4){
                sl_bg = {'background': 'rgb(50, 167, 111)'};
                sl_text = data_options_val_arr[3];
            } else if (slider_value == 5){
                sl_bg = {'background': 'rgb(38, 216, 131)'};
                sl_text = data_options_val_arr[4];
            }
            $('div.sliderTypeQuestion_text#'+q_sl).css(sl_bg);
            $('div.sliderTypeQuestion_text#'+q_sl+' > span').text(sl_text);
            
        }
       
    });
    //-=-=-=-=-=-=-=-=-=-=-= slider type question CPB -=-=-=-=-=-=-=-=-=-=-=
    
    //-=-=-=-=-=-=-=-=-=-=-= radio image tf2 -=-=-=-=-=-=-=-=-=-=-=
    $('div#radio-image-selector input:radio').addClass('input_radio_hidden');
    $(document).on("click", "#radio-image-selector label", function(){
        var id = $(this).attr('for');
        $('input#'+id).attr('checked', 'true');
        $(this).addClass('input_radio_selected').siblings().removeClass('input_radio_selected');
    });
    //-=-=-=-=-=-=-=-=-=-=-= radio image tf2 -=-=-=-=-=-=-=-=-=-=-=

    
});


//-=-=-=-=-=-=-=-=-=-=-= single char question rn2-=-=-=-=-=-=-=-=-=-=-=
function char_question_onBlur(dis){
    var id = $(dis).attr('id');
    var entered_char = $(dis).val().toLowerCase();
    //default
    //A|1 = almost never          B|2 = occasionally          C|3 = very frequently          D|4 = almost always
      if(entered_char == 'a' || entered_char == '1'){
        $(dis).val('A'.toUpperCase());
        $(dis).css({'border':'1px solid #000'});
    } else if(entered_char == 'b' || entered_char == '2'){
        $(dis).val('B'.toUpperCase());
        $(dis).css({'border':'1px solid #000'});
    } else if(entered_char == 'c' || entered_char == '3'){
        $(dis).val('C'.toUpperCase());
        $(dis).css({'border':'1px solid #000'});
    } else if(entered_char == 'd' || entered_char == '4'){
        $(dis).val('D'.toUpperCase());
        $(dis).css({'border':'1px solid #000'});
    } else if(entered_char == ''){
        $(dis).css('border', '4px solid red');
//        $(dis).focus();
    }
}
function char_question_onKeyUp(dis){
    var id = $(dis).attr('id');
    var entered_char = $(dis).val().toLowerCase();
    //default
    //A|1 = almost never          B|2 = occasionally          C|3 = very frequently          D|4 = almost always
    if(entered_char == 'a' || entered_char == '1'){
        $(dis).val('A'.toUpperCase());
        $(dis).css({'border':'1px solid #000'});
    } else if(entered_char == 'b' || entered_char == '2'){
        $(dis).val('B'.toUpperCase());
        $(dis).css({'border':'1px solid #000'});
    } else if(entered_char == 'c' || entered_char == '3'){
        $(dis).val('C'.toUpperCase());
        $(dis).css({'border':'1px solid #000'});
    } else if(entered_char == 'd' || entered_char == '4'){
        $(dis).val('D'.toUpperCase());
        $(dis).css({'border':'1px solid #000'});
    } else {
        $(dis).val('');
    }
}
//-=-=-=-=-=-=-=-=-=-=-= single char question rn2-=-=-=-=-=-=-=-=-=-=-=


//-=-=-=-=-=-=-=-=-=-=-= single char question rn3-=-=-=-=-=-=-=-=-=-=-=
function char_question_rn3_onBlur(dis){
    var id = $(dis).attr('id');
    var entered_char = $(dis).val().toLowerCase();
    //1-Strongly Disagree
    //2-Disagree
    //3-Slightly Disagree
    //4-Neutral
    //5-Slightly Agree
    //6-Agree
    //7-Strongly Agree
    if(entered_char >= 1 && entered_char <= 7){
        $(dis).css({'border':'1px solid #000'});
    } else if(entered_char == ''){
        $(dis).css('border', '4px solid red');
    } else {
        $(dis).val('');
    }
}
function char_question_rn3_onKeyUp(dis){
    var id = $(dis).attr('id');
    var entered_char = $(dis).val().toLowerCase();
    //1-Strongly Disagree
    //2-Disagree
    //3-Slightly Disagree
    //4-Neutral
    //5-Slightly Agree
    //6-Agree
    //7-Strongly Agree
    if(entered_char >= 1 && entered_char <= 7){
        $(dis).css({'border':'1px solid #000'});
    } else {
        $(dis).val('');
    }
}
//-=-=-=-=-=-=-=-=-=-=-= single char question rn3-=-=-=-=-=-=-=-=-=-=-=