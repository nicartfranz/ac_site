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
                    <link href='https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css' rel='stylesheet' type='text/css'> 
                    <!-- Custom fonts for this template-->
                    ".includPageLevelCSS($siteLevelCSS)."
                    <title>".SITENAME."</title>
                </head>
            <body>";
    return $html;
}

//Franz: Loads the site basic footer (DEFAULT)
function siteBasicFooter($siteLevelJS = array()){
    
    $html = "   <!-- Bootstrap core JavaScript-->
                <script src='".APP_BASE_URL."public/js/jquery/jquery.min.js'></script>
                <script src='".APP_BASE_URL."public/js/bootstrap/js/bootstrap.bundle.min.js'></script>

                <!-- Core plugin JavaScript-->
                <script src='".APP_BASE_URL."public/js/jquery-easing/jquery.easing.min.js'></script>
                <script src='".APP_BASE_URL."public/js/jqueryui/jquery-ui.min.js'></script>

                <!-- Custom scripts for all pages-->
                <script src='https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.js'></script>  
                <script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min.js'></script>  
                ".includPageLevelJS($siteLevelJS)."
                </body>
              </html>";
   
    return $html;
}

//Franz: Loads the site basic top nav (DEFAULT)
function siteBasicTopbar(){
    
    $link['logout'] = (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'test_taker') ? "<li class='nav-item'> <a class='nav-link' href='../site/logout'>Logout</a></li>" : "";  
    
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
                    <link href='https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css' rel='stylesheet' type='text/css'> 
                    <link href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i' rel='stylesheet'>

                    <!-- Custom styles for this template-->
                    <link href='".APP_BASE_URL."public/css/sb-admin-2.min.css' rel='stylesheet'>"
                        
                    .includPageLevelCSS($siteLevelCSS).
            
                    "<title>".SITENAME."</title>
                </head>
            <body id='page-top'>
            <link href='".APP_BASE_URL."public/css/formbuilder_override.css' rel='stylesheet' type='text/css'>";
    return $html;
}

//Franz: Loads the site admin footer (DEFAULT)
function siteAdminFooter($siteLevelJS = array()){
    $html = "
                <!-- Bootstrap core JavaScript-->
                <script src='".APP_BASE_URL."public/js/jquery/jquery.min.js'></script>
                <script src='".APP_BASE_URL."public/js/bootstrap/js/bootstrap.bundle.min.js'></script>

                <!-- Core plugin JavaScript-->
                <script src='".APP_BASE_URL."public/js/jquery-easing/jquery.easing.min.js'></script>
                <script src='".APP_BASE_URL."public/js/jqueryui/jquery-ui.min.js'></script>

                <!-- Custom scripts for all pages-->
                <script src='".APP_BASE_URL."public/js/sb-admin-2.min.js'></script>
                <script src='https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.js'></script>"

                //<script src='".APP_BASE_URL."public/js/fb_fields_acsite.js'></script>
                //<!-- Page level custom scripts -->
                //<script src='".APP_BASE_URL."public/js/demo/chart-area-demo.js'></script>
                //<script src='".APP_BASE_URL."public/js/demo/chart-pie-demo.js'></script>
                
                .includPageLevelJS($siteLevelJS).
                "</body>
            </html>";
    return $html;
}


//Franz: This function is used to include a particular css file(s) in a page.
function includPageLevelCSS($css = array()){
    
    $html = '';
    if(!empty($css)){
        foreach ($css as $include){
            $html .= "<link href='".APP_BASE_URL.$include."' rel='stylesheet'>";
        } 
    }
    
    return $html;
    
}

//Franz: This function is used to include a particular js file(s) in a page.
function includPageLevelJS($js = array()){
    
    $html = '';
    if(!empty($js)){
        foreach ($js as $include){
            
            $is_module = '';
//            if(in_array($include, array('public/js/formbuilder/src/js/form-builder.js', 'public/js/formbuilder/src/js/form-render.js'))){
//                $is_module = "type='module'";
//            }
            
            $html .= " <script ".$is_module." src='".APP_BASE_URL.$include."'></script>";
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
                  <li class="nav-item">
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
    
    if(!in_array($_SESSION['usertype'], $allowed_usertypes)){
        header("Location:".APP_BASE_URL."site/index");
    }
    
}

//Franz: set the test timer
//params: 
//  $set_type = unset | init | continue 
//  $ass_code = assessment code
function testTimer($set_type = 'unset', $ass_code = '', $setMaxTime = 0){
    
    $now = date('Y-m-d H:i:s');
    
    if($set_type == 'init'){
        
        //ON init set the time
        if(!isset($_SESSION[$ass_code]['test_timer_created_at'])){
            $_SESSION[$ass_code]['test_timer_created_at'] = $now;
            $_SESSION[$ass_code]['test_timer_last_modified_at'] = $now;
            $_SESSION[$ass_code]['test_timer'] = $setMaxTime; //This is in minutes

            $timer_in_secs = $setMaxTime * 60;
            $get_test_time = getHourMinSec($timer_in_secs);

            //elapse time
            $_SESSION[$ass_code]['test_time_elapse_hr'] = $get_test_time['hrs'];        
            $_SESSION[$ass_code]['test_time_elapse_min'] = $get_test_time['mins'];
            $_SESSION[$ass_code]['test_time_elapse_sec'] = $get_test_time['secs'];        

            //time remaining
            $_SESSION[$ass_code]['test_time_remaining_hr'] = $get_test_time['hrs'];
            $_SESSION[$ass_code]['test_time_remaining_min'] = $get_test_time['mins'];
            $_SESSION[$ass_code]['test_time_remaining_sec'] = $get_test_time['secs'];
            
            //test start and end time
            $_SESSION[$ass_code]['test_timer_start_time'] = $now;
            $_SESSION[$ass_code]['test_timer_end_time'] = date('Y-m-d H:i:s', strtotime("{$now} +{$timer_in_secs} seconds"));
            
        } else { //if already initialized: start recording elapse time and time remaining
            
            $_SESSION[$ass_code]['test_timer_last_modified_at'] = $now;
            $sec_elpase = strtotime($now) - strtotime($_SESSION[$ass_code]['test_timer_start_time']);
            $sec_remaining = ($_SESSION[$ass_code]['test_timer'] * 60) - $sec_elpase;

            $test_time_elapse = getHourMinSec($sec_elpase);
            $test_time_remaining = getHourMinSec($sec_remaining);

            //elapse time
            $_SESSION[$ass_code]['test_time_elapse_hr'] = $test_time_elapse['hrs'];
            $_SESSION[$ass_code]['test_time_elapse_min'] = $test_time_elapse['mins'];
            $_SESSION[$ass_code]['test_time_elapse_sec'] = $test_time_elapse['secs'];        

            //time remaining
            $_SESSION[$ass_code]['test_time_remaining_hr'] = $test_time_remaining['hrs'];
            $_SESSION[$ass_code]['test_time_remaining_min'] = $test_time_remaining['mins'];
            $_SESSION[$ass_code]['test_time_remaining_sec'] = $test_time_remaining['secs'];
            
        }
                
    } else if ($set_type == 'continue'){
        $_SESSION[$ass_code]['test_timer_last_modified_at'] = $now;
        $sec_elpase = strtotime($now) - strtotime($_SESSION[$ass_code]['test_timer_start_time']);
        $sec_remaining = ($_SESSION[$ass_code]['test_timer'] * 60) - $sec_elpase;
        
        $test_time_elapse = getHourMinSec($sec_elpase);
        $test_time_remaining = getHourMinSec($sec_remaining);
        
        //elapse time
        $_SESSION[$ass_code]['test_time_elapse_hr'] = $test_time_elapse['hrs'];
        $_SESSION[$ass_code]['test_time_elapse_min'] = $test_time_elapse['mins'];
        $_SESSION[$ass_code]['test_time_elapse_sec'] = $test_time_elapse['secs'];        

        //time remaining
        $_SESSION[$ass_code]['test_time_remaining_hr'] = $test_time_remaining['hrs'];
        $_SESSION[$ass_code]['test_time_remaining_min'] = $test_time_remaining['mins'];
        $_SESSION[$ass_code]['test_time_remaining_sec'] = $test_time_remaining['secs'];
        
    } else if ($set_type == 'unset') {
        unset($_SESSION[$ass_code]['test_timer_created_at']);
        unset($_SESSION[$ass_code]['test_timer_start_time']);
        unset($_SESSION[$ass_code]['test_timer_end_time']);
        unset($_SESSION[$ass_code]['test_timer_last_modified_at']);
        unset($_SESSION[$ass_code]['test_timer']);
        //time remaining and elapse time
        unset($_SESSION[$ass_code]['test_time_elapse_hr']);
        unset($_SESSION[$ass_code]['test_time_remaining_hr']);
        unset($_SESSION[$ass_code]['test_time_elapse_min']);
        unset($_SESSION[$ass_code]['test_time_remaining_min']);
        unset($_SESSION[$ass_code]['test_time_elapse_sec']);        
        unset($_SESSION[$ass_code]['test_time_remaining_sec']);
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

