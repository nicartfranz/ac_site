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
            // camera is live, showing preview image
            // (and user has allowed access)
            console.log('live');
            Webcam.snap( function(data_uri) {
                var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                document.getElementById('mysnapshot').value = raw_image_data;
//                document.getElementById('myform').submit();
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
    
    
});
