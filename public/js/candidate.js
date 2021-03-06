$(document).ready(function(){
    
    //privacy consent
    $('#take_assessment').on('click', function(){
        var agree_1 = $('input.agree-1').prop('checked');
        var agree_2 = $('input.agree-2').prop('checked');
        
        if(agree_1 == false || agree_2 == false){
            $('#agree-1-2-error-msg').css('display', 'block');
        } else {
            location.href = APP_BASE_URL + 'candidate/candidate_demographics';
        }
        
    });
    
});


function getQueryParams(qs) {
    qs = qs.split('+').join(' ');

    var params = {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }

    return params;
}