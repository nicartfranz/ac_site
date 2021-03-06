////-=-=-=-=-=-=-=-=-=-=-= DISABLE BACK in mobile and desktop -=-=-=-=-=-=-=-=-=-=-=-=-=-=
if(page_reload_back == 0){
    var myNewState = {
            data: {},
            title: 'Assessment Center',
            url: 'prevent_reload_and_back'
    };
    history.replaceState(myNewState.data, myNewState.title, myNewState.url);
}
//-=-=-=-=-=-=-=-=-=-=-= DISABLE BACK in mobile and desktop -=-=-=-=-=-=-=-=-=-=-=-=-=-=

//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-  GLOBAL VARS -=-=-=--=-=-=-=-=-=-=--=-=-=-=-=-=-
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
var global_candidate_recorder; // globally accessible
var global_candidate_video = document.querySelector('video');
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-  GLOBAL VARS -=-=-=--=-=-=-=-=-=-=--=-=-=-=-=-=-
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

$(document).ready(function(){
    
    //-=-=-=-=-=-=-=-=-=-=-= Detect window blur -=-=-=-=-=-=-=-=-=-=-=-=-=-=
    if(page_focus == 0){
        $(window).blur(function(){
            window.location.replace(APP_BASE_URL+"candidate/window_exit");
        });
    }
    //-=-=-=-=-=-=-=-=-=-=-= Detect window blur -=-=-=-=-=-=-=-=-=-=-=-=-=-=

    //-=-=-=-=-=-=-=-=-=-=-= DISABLE BACK in mobile and desktop -=-=-=-=-=-=-=-=-=-=-=-=-=-=
    if(page_reload_back == 0){
        $('html').backDetect(function(){
            // Callback function
            alert("Back function has been disabled in this site.");
        });
    }
    //-=-=-=-=-=-=-=-=-=-=-= DISABLE BACK in mobile and desktop -=-=-=-=-=-=-=-=-=-=-=-=-=-=

    
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
    
    
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-= Least-Best -=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $("div.least-best-checkbox").on("click", function() {
        var selectedBoxParent = $(this).parent("div");
        var selectedBox = $(this).children("input:first");
        var selectedBoxInputName = $(this).children("input:first").attr("name");

        //Checking the input[checkbox]
        if (selectedBox.prop("checked")) {
            selectedBox.prop("checked", false);

            if($('input[name="'+selectedBoxInputName+'"]').attr('data-required-removed')){
                $('input[name="'+selectedBoxInputName+'"]').attr('required', 'required').removeAttr('data-required-removed');
            }
            
            $(this).attr("class", "least-best-checkbox"); //get back to original state
            return false;
        } else {
            selectedBox.prop("checked", true);
        }

        //Limiting the allowed checks
        var limit = 2;
        var countChecks = $("#" + selectedBoxParent.attr("id") + ' input[type="checkbox"]').filter(":checked").length;
        
        //remove required if it has 2 selected answers
        if($('input[name="'+selectedBoxInputName+'"]').attr('required')){
            if (countChecks == limit){
                $('input[name="'+selectedBoxInputName+'"]').attr('data-required-removed', 'true');
                $('input[name="'+selectedBoxInputName+'"]').removeAttr('required');
                $('input[name="'+selectedBoxInputName+'"]').removeAttr('required');
            }
        }
        
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
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-= Least-Best -=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-= Ranking -=-=-=--=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $(document).on('click', 'span#remove-ranking-choice', function(){
  	var selected_choice_class = $(this).attr('class').split(' ');
        //selected_choice_class[2] = the choice id
        $('div.'+selected_choice_class[2]).css('display', 'block');
        $(this).prev().val('');
        $(this).prev().attr('value', '');
        $(this).remove();
    });
  

    $('div.ranking-choice').on('click', function(){
        var selected_choice_parent_id = $(this).parent().attr('id');
        var selected_choice_class = $(this).attr('class');
        var selected_choice_value = $(this).text();
        var selected_choice_attr_value = $(this).attr('value');
        var has_unanswered = 0;
        //check hidden inupt fields if has answer
        $("div.ranking-question-box-left#" + selected_choice_parent_id + ' > p > input').each(function(i, obj) {
            if($(obj).val() == ''){
                $(obj).val(selected_choice_attr_value);
                $(obj).attr('value', selected_choice_attr_value);
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
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-= Ranking -=-=-=--=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-= SLIDER INPUT QUESTION -=-=-=-=-=-=-=-=-=-=-
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
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
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-= SLIDER INPUT QUESTION -=-=-=-=-=-=-=-=-=-=-
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-= True/False/Undecided Question -=-=-=-=-=-=-
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $('div#radio-image-selector input:radio').addClass('input_radio_hidden');
    $(document).on("click", "#radio-image-selector label", function(){
        var id = $(this).attr('for');
        $('input#'+id).attr('checked', 'true');
        $(this).addClass('input_radio_selected').siblings().removeClass('input_radio_selected');
    });
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-= True/False/Undecided Question -=-=-=-=-=-=-
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-= Multiple Choices [select one] -=-=-=-=-=-=-
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $("input.custom_mc_radio").on('click', function(){
        var this_choice = $(this).attr('name');
        var this_choice_value = $(this).val();
        //remove prev selected 
        $('label.custom_mc_container.'+this_choice).removeClass('custom_mc_radio_selected');
        //add selected class
        $(this).parent().addClass('custom_mc_radio_selected');
    });
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-= Multiple Choices [select one] -=-=-=-=-=-=-
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-= Multiple Choices [select two] -=-=-=-=-=-=-
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $("input.custom_mc_checkbox").on('click', function(){
        var this_choice = $(this).attr('name');
        var this_choice_value = $(this).val();
        var count_checked = $('input[name="'+this_choice+'"]:checked').length;

        var limit = 2;
        if(count_checked > limit){
            return false;
        }
        
        if(count_checked == 0){
            var id = this_choice.split('[')[0];
            var is_answer_required = $('label.custom_mc_container.'+id).hasClass('answer_required');
            if (is_answer_required) {
                $('input[name="'+this_choice+'"]').attr('required', 'required');
            } 
          
        } else {
            $('input[name="'+this_choice+'"]').removeAttr('required');
        }

        if($(this).parent().hasClass('custom_mc_checkbox_selected')){
             $(this).parent().removeClass('custom_mc_checkbox_selected');
        } else {
             $(this).parent().addClass('custom_mc_checkbox_selected');
        }

    }); 
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=-=-=-= Multiple Choices [select two] -=-=-=-=-=-=-
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    
    
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=- Video Answer JS -=-=-=--=-=-=-=-=-=-=--=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $('.btn-start-recording-candidate').on('click', function(){

        var this_button_id = $(this).attr('id');
        var this_data_video_id = $(this).attr('data-video-id');
        global_candidate_video = $('video.'+this_data_video_id)[0];

        this.disabled = true;
        captureCamera_candidate(function(camera) {
            global_candidate_video.muted = true;
            global_candidate_video.volume = 0;
            global_candidate_video.srcObject = camera;

            global_candidate_recorder = RecordRTC(camera, {
                type: 'video'
            });

            global_candidate_recorder.startRecording();

            // release camera on stopRecording
            global_candidate_recorder.camera = camera;

            $('button#stop_'+this_data_video_id).removeAttr('disabled');
        });

        // auto stop recording after 60 seconds
        var milliSeconds = (60 * 1000) + 1000;
        setTimeout(function() {
            global_candidate_recorder.stopRecording(stopRecordingCallback_candidate);
        }, milliSeconds);

    });

    $('.btn-stop-recording-candidate').on('click', function(){
        var this_button_id = $(this).attr('id');
        var this_data_video_id = $(this).attr('data-video-id');
        global_candidate_video = $('video.'+this_data_video_id)[0];

        this.disabled = true;
        $('button#start_'+this_data_video_id).removeAttr('disabled');
        $('button#save_'+this_data_video_id).css('display', 'block');

        global_candidate_recorder.stopRecording(stopRecordingCallback_candidate);
    });

    $('.btn-save-recording-candidate').on('click', function(){
        var this_button_id = $(this).attr('id');
        var this_data_video_id = $(this).attr('data-video-id');
        var this_data_video_filename = $(this).attr('data-video-filename');
        global_candidate_video = $('video.'+this_data_video_id)[0];
        $('#start_'+this_data_video_id).removeAttr('disabled');

        // get recorded blob
        var blob = global_candidate_recorder.getBlob();

        // generating a random file name
        var fileName = this_data_video_filename+'.webm';

        // we need to upload "File" --- not "Blob"
        var fileObject = new File([blob], fileName, {
            type: 'video/webm'
        });

        var formData = new FormData();

        // recorded data
        formData.append('video-blob', fileObject);
        // file name
        formData.append('video-filename', fileObject.name);

        //modal-header
        $('div.modal#modal_'+this_data_video_id+ ' > div > div > div.modal-header > h4').text('Uploading video please wait...');
        var upload_url = APP_BASE_URL + ASS_CODE +"/submitAjax";
        // upload using jQuery
        var ajax_name = 'save_candidate_video_answer';
        formData.append('ajax_name', ajax_name);
        $.ajax({
            url: upload_url, // replace with your own server URL
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(response) {
                if (response === 'success') {
                    $('button#'+this_data_video_id).replaceWith("<button type='button' class='btn btn-secondary'>Answered</button>");
                    $('#modal_'+this_data_video_id).modal('hide');
                } else {
                    alert(response); // error/failure
                }
            }
        });

    });
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //-=-=-=-=-=- Video Answer JS -=-=-=--=-=-=-=-=-=-=--=-=-=-=-=
    //-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    
});


//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-=-=-= Single character Answer (rn2) -=-==--=-=-=-
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
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
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-=-=-= Single character Answer (rn2) -=-==--=-=-=-
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=


//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-=-=-= Single character Answer (rn3) -=-==--=-=-=-
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
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
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-=-=-= Single character Answer (rn3) -=-==--=-=-=-
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=


//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-=-=-=-=-=-= Ranking -=-=-=--=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
function validateRankingQuestion(dis, err_msg){
    var id = dis.id.split('[')[0];
    $('div.ranking-question-box-left#'+id).css('border', '1px solid red');
    console.log(err_msg + ' ' +id);
}
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-=-=-=-=-=-= Ranking -=-=-=--=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=


//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=- Multiple choice required checked -=-=-=--=-=-=-=
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
function validateCustomMCQuestion(dis, err_msg){
    $(dis).parent().css('border', '1px solid red');
    console.log(err_msg);
}
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=- Multiple choice required checked -=-=-=--=-=-=-=
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=- Video Answer JS -=-=-=--=-=-=-=-=-=-=--=-=-=-=-=
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
function captureCamera_candidate(callback) {
    navigator.mediaDevices.getUserMedia({ audio: true, video: true }).then(function(camera) {
        callback(camera);
    }).catch(function(error) {
        alert('Unable to capture your camera. Please check console logs.');
        console.error(error);
    });
}

function stopRecordingCallback_candidate() {
    global_candidate_video.src = global_candidate_video.srcObject = null;
    global_candidate_video.muted = false;
    global_candidate_video.volume = 1;
    global_candidate_video.src = URL.createObjectURL(global_candidate_recorder.getBlob());

    global_candidate_recorder.camera.stop();
}
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//-=-=-=-=-=- Video Answer JS -=-=-=--=-=-=-=-=-=-=--=-=-=-=-=
//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=