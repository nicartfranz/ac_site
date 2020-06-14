$(document).ready(function(){
    
    var hasWebcam = false;
    var hasMicrophone = false;
    var isWebsiteHasWebcamPermissions = false;
    var isWebsiteHasMicrophonePermissions = false;
    
    var has_audioInputDevices = false;
    var has_audioOutputDevices = false;
    var has_videoInputDevices = false;
    
    DetectRTC.load(function() {
        hasWebcam = DetectRTC.hasWebcam; // (has webcam device!)
        hasMicrophone = DetectRTC.hasMicrophone; // (has microphone device!)

        isWebsiteHasWebcamPermissions = DetectRTC.isWebsiteHasWebcamPermissions;        // getUserMedia allowed for HTTPs domain in Chrome?
        isWebsiteHasMicrophonePermissions = DetectRTC.isWebsiteHasMicrophonePermissions;    // getUserMedia allowed for HTTPs domain in Chrome?

        has_audioInputDevices = DetectRTC.audioInputDevices;    // microphones
        has_audioOutputDevices = DetectRTC.audioOutputDevices;   // speakers
        has_videoInputDevices = DetectRTC.videoInputDevices;    // cameras
 
        //IE 11 - camera not supported yet
        //Miscrosoft Edge (Google V8) - OK supported
        //Safari - Not yet tested
        //Firefox - OK supported
        //Chrome - OK supported
        if(is_camera_required == 1){
            if(hasWebcam == true && has_videoInputDevices.length > 0 && isWebsiteHasWebcamPermissions == false){
                $("#camera_permission").css('display', 'block');
                $("#login-row").css('display', 'none');
            }
        }
        
        //IE 11 - camera not supported yet
        //Miscrosoft Edge (Google V8) - OK supported
        //Safari - Not yet tested
        //Firefox - OK supported
        //Chrome - OK supported
        if(is_microphone_required == 1){
            if(hasMicrophone == true && has_audioOutputDevices.length > 0 && isWebsiteHasMicrophonePermissions == false){
                $("#microphone_permission").css('display', 'block');
                $("#login-row").css('display', 'none');
            }
        }
        
    });
    
});

function activate_camera(){
    alert("Check if your web cam is currently blocked. If blocked, go to your browser permission(s) tab and search for camera then change camera status to 'always allow on this site'");

    navigator.getMedia = ( navigator.getUserMedia || // use the proper vendor prefix
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

    navigator.getMedia({video: true}, function() {
            console.log("CAMERA ALLOWED");
            location.reload();
    }, function(e) {
            console.log("CAMERA DECLINED");
            alert("Webcam blocked/disabled");
            location.reload();
    });
}


function activate_microphone(){
    
    alert("Check if your microphone is currently blocked. If blocked, go to your browser permission(s) tab and search for camera then change microphone status to 'always allow on this site'");

    navigator.getMedia = ( navigator.getUserMedia || // use the proper vendor prefix
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

    navigator.getMedia({audio: true}, function() {
            console.log("MIC ALLOWED");
            location.reload();
    }, function(e) {
            console.log("MIC DECLINED");
            alert("Microphone blocked/disabled");
            location.reload();
    });
    
}