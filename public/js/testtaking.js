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
    
});
