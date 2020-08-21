<?php 
$username = (isset($_GET['username']) && !empty($_GET['username'])) ? xss_clean($_GET['username']) : '';
$test = (isset($_GET['test']) && !empty($_GET['test'])) ? xss_clean($_GET['test']) : '';

$username = ($username == '') ? xss_clean($_POST['username']) : $username;
$test = ($test == '') ? xss_clean($_POST['test']) : $test;

if($_SESSION['ac2']['username'] == $username && $_SESSION['ac2']['is_authenticated'] == '1'){
    header("Location:".APP_BASE_URL.$test."/");
}
?>
<div class="container-sm test-content">

    <div class="jumbotron">
        <div class="alert alert-info">
            Please confirm candidate information.
        </div>
         <form id="login-form" class="form" action="<?php echo APP_BASE_URL ?>site/confirm_redirect_login" method="post">
             <input type="hidden" name="test" value="<?= $test ?>">
            <div class="form-group">
                <label for="username" class="text-dark">Username:</label><br>
                <input type="text" name="username" id="username" class="form-control" value="<?= $username ?>">
            </div>
            <div class="form-group">
                <label for="password" class="text-dark">Password:</label><br>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <hr>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success btn-md" value="Submit">
            </div>
        </form>
    </div>
    
</div>