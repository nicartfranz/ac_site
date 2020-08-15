<?php

/* 
 * Contributor: Franz
 * Date Modified: May 9, 2020
 * 
 * Description: This file contains all the helper functions that is available everywhere in the site.
 */

//Franz: Loads the site basic header (DEFAULT)
function siteBasicHeader($siteLevelCSS = array()){
    $html ="<!DOCTYPE html>
            <html lang='en'>
                <head>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                    <meta name='description' content=''>
                    <meta name='author' content=''>
                    <link href='".APP_BASE_URL."public/css/bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
                    <link href='".APP_BASE_URL."public/vendor/fontawesome-free/css/all.min.css' rel='stylesheet' type='text/css'>
                    <link href='".APP_BASE_URL."public/css/jquery.rateyo.min.css' rel='stylesheet' type='text/css'> 
                    <!-- Custom fonts for this template-->
                    ".includePageLevelCSS($siteLevelCSS)."
                    <title>".SITENAME."</title>
                </head>
            <body>";
    return $html;
}

//Franz: Loads the site basic footer (DEFAULT)
function siteBasicFooter($siteLevelJS = array()){
    
    $html = "   <!-- JavaScript Babel Polyfill 7.10.1 -->
                <script src='".APP_BASE_URL."public/js/babel-polyfill/polyfill.min.js'></script>
                <!-- Bootstrap core JavaScript-->
                <script src='".APP_BASE_URL."public/js/jquery/jquery.min.js'></script>
                <script src='".APP_BASE_URL."public/js/bootstrap/js/bootstrap.bundle.min.js'></script>

                <!-- Core plugin JavaScript-->
                <script src='".APP_BASE_URL."public/js/jquery-easing/jquery.easing.min.js'></script>
                <script src='".APP_BASE_URL."public/js/jqueryui/jquery-ui.min.js'></script>
                <script src='".APP_BASE_URL."public/js/jqueryui-touch-punch/jquery.ui.touch-punch.min.js'></script>
                    
                <!-- Webcam plugin -->
                <script src='".APP_BASE_URL."public/js/DetectRTC/DetectRTC.js'></script>
                <script src='".APP_BASE_URL."public/js/webcam/webcam.min.js'></script>
                    
                <script src='https://cdn.jsdelivr.net/npm/jquery-backdetect@1.0.3/jquery.backDetect.min.js'></script>
                <script src='https://cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html4+html5/jquery.history.min.js'></script>
                
                <script src='https://cdnjs.cloudflare.com/ajax/libs/RecordRTC/5.5.9/RecordRTC.js'></script>

                <!-- Custom scripts for all pages-->
                <script src='".APP_BASE_URL."public/js/rateYo/jquery.rateyo.min.js'></script>  
                ".includePageLevelJS($siteLevelJS)."
                </body>
              </html>";
   
    return $html;
}

//Franz: Loads the site basic top nav (DEFAULT)
function siteBasicTopbar(){
    
    $link['logout'] = (isset($_SESSION['ac2']['usertype']) && $_SESSION['ac2']['usertype'] == 'test_taker') ? "<li class='nav-item'> <a class='nav-link' href='".APP_BASE_URL."site/logout'>Logout</a></li>" : "";  
    
    $html = "   <!-- Navigation -->
                <nav class='navbar navbar-expand-lg navbar-light bg-light static-top'>
                  <div class='container'>
                    <a class='navbar-brand' href='#'>".SITENAME."</a>
                    <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarResponsive' aria-controls='navbarResponsive' aria-expanded='false' aria-label='Toggle navigation'>
                    <span class='navbar-toggler-icon'></span>
                    </button>
                    <div class='collapse navbar-collapse' id='navbarResponsive'>
                      <ul class='navbar-nav ml-auto'>
                        <li class='nav-item'>
                          <a class='nav-link' href='#'>Contact Support</a>
                        </li>
                        <li class='nav-item'>
                          <a class='nav-link' href='#'>FAQ's</a>
                        </li>
                        <li class='nav-item'>
                          <a class='nav-link' href='#'>About</a>
                        </li>
                        ".$link['logout']."
                      </ul>
                    </div>
                  </div>
                </nav>";
    return $html;
}


//Franz: Loads the site admin header (DEFAULT)
function siteAdminHeader($siteLevelCSS = array()){
    $html ="<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='utf-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                    <meta name='description' content=''>
                    <meta name='author' content=''>

                    <!-- Custom fonts for this template-->
                    <link href='".APP_BASE_URL."public/vendor/fontawesome-free/css/all.min.css' rel='stylesheet' type='text/css'>
                    <link href='".APP_BASE_URL."public/css/jquery.rateyo.min.css' rel='stylesheet' type='text/css'> 
                    <link href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>

                    <!-- Custom styles for this template-->
                    <link href='".APP_BASE_URL."public/css/admin.css' rel='stylesheet'>
                    <link href='".APP_BASE_URL."public/css/sb-admin-2.min.css' rel='stylesheet'>"
                        
                    .includePageLevelCSS($siteLevelCSS).
            
                    "<title>".SITENAME."</title>
                </head>
            <body id='page-top'>
            <link href='".APP_BASE_URL."public/css/formbuilder_override.css' rel='stylesheet' type='text/css'>";
    return $html;
}

//Franz: Loads the site admin footer (DEFAULT)
function siteAdminFooter($siteLevelJS = array()){
    $html = "   <!-- JavaScript Babel Polyfill 7.10.1 -->
                <script src='".APP_BASE_URL."public/js/babel-polyfill/polyfill.min.js'></script>
                <!-- Bootstrap core JavaScript-->
                <script src='".APP_BASE_URL."public/js/jquery/jquery.min.js'></script>
                <script src='".APP_BASE_URL."public/js/bootstrap/js/bootstrap.bundle.min.js'></script>

                <!-- Core plugin JavaScript-->
                <script src='".APP_BASE_URL."public/js/jquery-easing/jquery.easing.min.js'></script>
                <script src='".APP_BASE_URL."public/js/jqueryui/jquery-ui.min.js'></script>
                    
                <!-- Custom scripts for all pages-->
                <script src='".APP_BASE_URL."public/js/admin.js'></script>
                <script src='".APP_BASE_URL."public/js/sb-admin-2.min.js'></script>
                <script src='".APP_BASE_URL."public/js/rateYo/jquery.rateyo.min.js'></script>
                
                <script src='https://cdnjs.cloudflare.com/ajax/libs/RecordRTC/5.5.9/RecordRTC.js'></script>"

                //<script src='".APP_BASE_URL."public/js/fb_fields_acsite.js'></script>
                //<!-- Page level custom scripts -->
                //<script src='".APP_BASE_URL."public/js/demo/chart-area-demo.js'></script>
                //<script src='".APP_BASE_URL."public/js/demo/chart-pie-demo.js'></script>
                .includePageLevelJS($siteLevelJS).
                "</body>
            </html>";
    return $html;
}


//Franz: This function is used to include a particular css file(s) in a page.
function includePageLevelCSS($css = array()){
    
    $html = '';
    if(!empty($css)){
        foreach ($css as $include){
            $html .= "<link href='".APP_BASE_URL.$include."' rel='stylesheet'>";
        } 
    }
    
    return $html;
    
}

//Franz: This function is used to include a particular js file(s) in a page.
function includePageLevelJS($js = array()){
    
    $html = '';
    if(!empty($js)){
        foreach ($js as $include){
            
            $is_babel = '';
//            if(in_array($include, ['public/js/formbuilder/control_plugins/customHTMLTemplate.js'])){
//                $is_babel = 'type="text/babel" data-plugins="transform-class-properties" data-presets="react, es2015,stage-2"';
//            }
            
            $is_module = '';
//            if(in_array($include, array('public/js/formbuilder/src/js/form-builder.js', 'public/js/formbuilder/src/js/form-render.js'))){
//                $is_module = "type='module'";
//            }
            
            $html .= " <script ".$is_babel." ".$is_module." src='".APP_BASE_URL.$include."'></script>";
        } 
    } 
    
    return $html;
    
}

//Franz: Admin side bar
function adminSidebar(){
    $html = '';
    $html = '   <!-- Sidebar -->
                <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                  <!-- Sidebar - Brand -->
                  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../admin/index">
                    <div class="sidebar-brand-text mx-3">'.SITENAME.'</div>
                  </a>

                  <!-- Divider -->
                  <hr class="sidebar-divider my-0">

                  <!-- Nav Item - Dashboard -->
                  <li class="nav-item active">
                    <a class="nav-link" href="'.APP_BASE_URL.'admin/index">
                      <i class="fas fa-fw fa-tachometer-alt"></i>
                      <span>Dashboard</span></a>
                  </li>

                  <!-- Divider -->
                  <hr class="sidebar-divider">

                  <!-- Heading -->
                  <div class="sidebar-heading">
                    Super Admin Functions
                  </div>

                  <!-- Nav Item - Pages Collapse Menu -->
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                      <i class="fas fa-fw fa-cog"></i>
                      <span>Test Manager</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Controls:</h6>
                        <a class="collapse-item" href="'.APP_BASE_URL.'test/index">Create Test</a>
                        <a class="collapse-item" href="'.APP_BASE_URL.'test/search">Search Test</a>
                      </div>
                    </div>
                  </li>

                  <!-- Nav Item - Utilities Collapse Menu -->
                  <!-- <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                      <i class="fas fa-fw fa-file-pdf"></i>
                      <span>Report Manager</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Controls:</h6>
                        <a class="collapse-item" href="#">Create PDF Template</a>
                        <a class="collapse-item" href="#">Create MS Word Template</a>
                        <a class="collapse-item" href="#">Create MS Excel Template</a>
                        <a class="collapse-item" href="#">Search Template</a>
                      </div>
                    </div>
                  </li> -->
                  
                  <!-- Nav Item - Utilities Collapse Menu -->
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities3" aria-expanded="true" aria-controls="collapseUtilities">
                      <i class="fas fa-fw fa-file-pdf"></i>
                      <span>Candidate Site Manager</span>
                    </a>
                    <div id="collapseUtilities3" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Controls:</h6>
                        <a class="collapse-item" href="'.APP_BASE_URL.'candidatesitesettings/requirements">Set Site Requirements</a>
                      </div>
                    </div>
                  </li>

                  <!-- Divider -->
                  <hr class="sidebar-divider d-none d-md-block">

                  <!-- Sidebar Toggler (Sidebar) -->
                  <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                  </div>

                </ul>
                <!-- End of Sidebar -->';
    
    return $html;
}

function adminTopbar($data){
    
    $data = $data;
    $data['page_name'] = (isset($data['page_name'])) ? $data['page_name'] : '';
    
    $html = '';
    $html = '   <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                  <!-- Sidebar Toggle (Topbar) -->
                  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                  </button>

                  <h3 class="text-dark">'.$data['page_name'].'</h3>
                  <!-- Topbar Search -->
                  <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form> -->

                  <!-- Topbar Navbar -->
                  <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                      </a>
                      <!-- Dropdown - Messages -->
                      <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                          <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                              </button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </li>

                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                      <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-envelope fa-fw"></i>
                        <!-- Counter - Messages -->
                        <span class="badge badge-danger badge-counter">2</span>
                      </a>
                      <!-- Dropdown - Messages -->
                      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                        <h6 class="dropdown-header">
                          Message Center
                        </h6>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                          <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="'.APP_BASE_URL.'public/img/doggo60x60.jpg" alt="">
                            <div class="status-indicator bg-success"></div>
                          </div>
                          <div class="font-weight-bold">
                            <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I\'ve been having.</div>
                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                          </div>
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                          <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="'.APP_BASE_URL.'public/img/doggo60x60.jpg" alt="">
                            <div class="status-indicator"></div>
                          </div>
                          <div>
                            <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                            <div class="small text-gray-500">Jae Chun · 1d</div>
                          </div>
                        </a>
                        <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                      </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Super Admin</span>
                        <img class="img-profile rounded-circle" src="'.APP_BASE_URL.'public/img/doggo60x60.jpg">
                      </a>
                      <!-- Dropdown - User Information -->
                      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">
                          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                          Profile
                        </a>
                        <a class="dropdown-item" href="#">
                          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                          Settings
                        </a>
                        <a class="dropdown-item" href="#">
                          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                          Activity Log
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                          Logout
                        </a>
                      </div>
                    </li>

                  </ul>

                </nav>
                <!-- End of Topbar -->';

    return $html;
    
}

//Franz: get controller in the url
function getController(){
    if(isset($_GET['url'])) {
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return strtolower($url[0]);
    }
    return '';
}


//Franz: allow page access by user type
function allowPageAccessByUser($allowed_usertypes){
    
    array_push($allowed_usertypes, 'super_admin');//super_admin can visit any page
    
    if(!in_array($_SESSION['ac2']['usertype'], $allowed_usertypes)){
        header("Location:".APP_BASE_URL."site/index");
    }
    
}

//Franz: set the test timer
//params: 
//  $set_type = unset | init | continue 
//  $ass_code = assessment code
function testTimer($set_type = 'unset', $ass_code = '', $setMaxTime = -1){
    
    $now = date('Y-m-d H:i:s');
    
    if($set_type != 'unset' && $setMaxTime < 0){
        return;
    }
    
    if($set_type == 'init'){
        
        //ON init set the time
        if(!isset($_SESSION['ac2'][$ass_code]['test_timer_created_at'])){
            $_SESSION['ac2'][$ass_code]['test_timer_created_at'] = $now;
            $_SESSION['ac2'][$ass_code]['test_timer_last_modified_at'] = $now;
            $_SESSION['ac2'][$ass_code]['test_timer'] = $setMaxTime; //This is in minutes

            $timer_in_secs = $setMaxTime * 60;
            $get_test_time = getHourMinSec($timer_in_secs);

            //elapse time
            $_SESSION['ac2'][$ass_code]['test_time_elapse_hr'] = $get_test_time['hrs'];        
            $_SESSION['ac2'][$ass_code]['test_time_elapse_min'] = $get_test_time['mins'];
            $_SESSION['ac2'][$ass_code]['test_time_elapse_sec'] = $get_test_time['secs'];        

            //time remaining
            $_SESSION['ac2'][$ass_code]['test_time_remaining_hr'] = $get_test_time['hrs'];
            $_SESSION['ac2'][$ass_code]['test_time_remaining_min'] = $get_test_time['mins'];
            $_SESSION['ac2'][$ass_code]['test_time_remaining_sec'] = $get_test_time['secs'];
            
            //test start and end time
            $_SESSION['ac2'][$ass_code]['test_timer_start_time'] = $now;
            $_SESSION['ac2'][$ass_code]['test_timer_end_time'] = date('Y-m-d H:i:s', strtotime("{$now} +{$timer_in_secs} seconds"));
            
        } else { //if already initialized: start recording elapse time and time remaining
            
            $_SESSION['ac2'][$ass_code]['test_timer_last_modified_at'] = $now;
            $sec_elpase = strtotime($now) - strtotime($_SESSION['ac2'][$ass_code]['test_timer_start_time']);
            $sec_remaining = ($_SESSION['ac2'][$ass_code]['test_timer'] * 60) - $sec_elpase;

            $test_time_elapse = getHourMinSec($sec_elpase);
            $test_time_remaining = getHourMinSec($sec_remaining);

            //elapse time
            $_SESSION['ac2'][$ass_code]['test_time_elapse_hr'] = $test_time_elapse['hrs'];
            $_SESSION['ac2'][$ass_code]['test_time_elapse_min'] = $test_time_elapse['mins'];
            $_SESSION['ac2'][$ass_code]['test_time_elapse_sec'] = $test_time_elapse['secs'];        

            //time remaining
            $_SESSION['ac2'][$ass_code]['test_time_remaining_hr'] = $test_time_remaining['hrs'];
            $_SESSION['ac2'][$ass_code]['test_time_remaining_min'] = $test_time_remaining['mins'];
            $_SESSION['ac2'][$ass_code]['test_time_remaining_sec'] = $test_time_remaining['secs'];
            
        }
                
    } else if ($set_type == 'continue'){
        $_SESSION['ac2'][$ass_code]['test_timer_last_modified_at'] = $now;
        $sec_elpase = strtotime($now) - strtotime($_SESSION['ac2'][$ass_code]['test_timer_start_time']);
        $sec_remaining = ($_SESSION['ac2'][$ass_code]['test_timer'] * 60) - $sec_elpase;
        
        $test_time_elapse = getHourMinSec($sec_elpase);
        $test_time_remaining = getHourMinSec($sec_remaining);
        
        //elapse time
        $_SESSION['ac2'][$ass_code]['test_time_elapse_hr'] = $test_time_elapse['hrs'];
        $_SESSION['ac2'][$ass_code]['test_time_elapse_min'] = $test_time_elapse['mins'];
        $_SESSION['ac2'][$ass_code]['test_time_elapse_sec'] = $test_time_elapse['secs'];        

        //time remaining
        $_SESSION['ac2'][$ass_code]['test_time_remaining_hr'] = $test_time_remaining['hrs'];
        $_SESSION['ac2'][$ass_code]['test_time_remaining_min'] = $test_time_remaining['mins'];
        $_SESSION['ac2'][$ass_code]['test_time_remaining_sec'] = $test_time_remaining['secs'];
        
    } else if ($set_type == 'unset') {
        unset($_SESSION['ac2'][$ass_code]);
    }
    
}

//get the hr:min:sec equivalent
function getHourMinSec($seconds){

    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = $seconds % 60;

    return [
        'hrs' => str_pad($hours, 2, '0', STR_PAD_LEFT), 
        'mins' => str_pad($minutes, 2, '0', STR_PAD_LEFT), 
        'secs' => str_pad($seconds, 2, '0', STR_PAD_LEFT)
    ];

}

//get device type
function getDevice(){

    $tablet_browser = 0;
    $mobile_browser = 0;

    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $tablet_browser++;
    }

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }

    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
        $mobile_browser++;
    }

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
        'newt','noki','palm','pana','pant','phil','play','port','prox',
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
        'wapr','webc','winw','winw','xda ','xda-');

    if (in_array($mobile_ua,$mobile_agents)) {
        $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
        $mobile_browser++;
        //Check for tablets on opera mini alternative headers
        $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
          $tablet_browser++;
        }
    }

    if ($tablet_browser > 0) {
       return 'tablet';
    }
    else if ($mobile_browser > 0) {
       return 'mobile';
    }
    else {
       return 'desktop';
    } 
}


//Usage: to determine if multi-option dropdown is selected
function isMultiOptionSelected($this_option, $options, $is_comma_separated = true){
    
    if($is_comma_separated){
        $options = explode(',', $options);
        if(in_array($this_option, $options)){
            return 'selected';
        }
    } else {
        if(in_array($this_option, $options)){
            return 'selected';
        }
    }
    
    return '';
    
}

//Usage: to determine if checkbox is selected
function isCheckboxChecked($this_option, $options, $is_comma_separated = true){
    
    if($is_comma_separated){
        $options = explode(',', $options);
        if(in_array($this_option, $options)){
            return 'checked';
        }
    } else {
        if(in_array($this_option, $options)){
            return 'checked';
        }
    }
    
    return '';
    
}


//Usage: to determine if radiobox is selected
function isRadioboxChecked($this_option, $radio_value){
    
    if($this_option == $radio_value){
        return 'checked';
    }
    
    return '';
    
}

//check if user allowed to store cookies
function checkCookies(){
    if(isset($_COOKIE['is_cookie_usage_accepted']) && $_COOKIE['is_cookie_usage_accepted'] == true){
        return true;
    } else {
        return false;
    }
}

//explode options|correctAns
//explodeData('CorrectAns', '1:0;2:0;3:1;4:0;');
function explodeData($type, $str){
    $valid_type = ['options', 'CorrectAns'];
    $arr = [];
    if(in_array($type, $valid_type)){
        $exploded_semicolon =  explode(';', $str);
        array_pop($exploded_semicolon); //remove the last because its empty
        foreach($exploded_semicolon as $data){
            $exploded_colon =  explode(':', $data);
            $id = $exploded_colon[0];
            $value = $exploded_colon[1];
            $arr[$id] = $value;
        }
        return $arr;
    } else {
        return false;
    }
    return false;
}


function xss_clean($data)
{
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);

        // we are done...
        return $data;
}

function getCurrentTestPage(){
    
    $page = explode('/', $_GET['url'])[1];
    $page = str_replace("page","",$page);
    return ($page == '') ? 1 : $page;
    
}


////////////////////////////////////////
// Start: Candidate testing functions //
////////////////////////////////////////
//used to send report
function sendReport($recipient, $attachment, $content){

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = MAIL_HOST;                              // Set the SMTP server to send through
        $mail->SMTPAuth   = MAIL_SMTPAUTH;                          // Enable SMTP authentication
        $mail->Username   = MAIL_USERNAME;                          // SMTP username
        $mail->Password   = MAIL_PASSWORD;                          // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = MAIL_PORT;                              // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('joe@example.net', 'Joe User');           // Add a recipient
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        // Attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
////////////////////////////////////////
// End: Candidate testing functions //
////////////////////////////////////////