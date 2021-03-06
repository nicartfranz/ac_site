<!-- Login Page Content -->
<?php 
$count_system_req_errs = count($data['error_site_requirement']);
?>
<div class="container">
    <?php  if(isset($data['error_site_requirement']) && !empty($data['error_site_requirement'])): ?>
        <br>
        <?php foreach($data['error_site_requirement'] as $errors): ?>
            <div class="alert alert-danger">
                <?= $errors ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
        
    <?php if(isset($data['requirements']['camera']) && (getDevice() == 'desktop' && $data['requirements']['camera'] == '1')): ?>
        <div class="alert alert-warning mt-3" id="camera_permission" style="display:none;">
            Please allow/accept camera permission in your browser. <button class="btn btn-success" onclick="activate_camera();">Activate Camera</button>
        </div>
    <?php endif; ?> 
        
    <?php if(isset($data['requirements']['microphone']) && (getDevice() == 'desktop' && $data['requirements']['microphone'] == '1')): ?>
        <div class="alert alert-warning mt-3" id="microphone_permission" style="display:none;">
            Please allow/accept microphone permission in your browser. <button class="btn btn-success" onclick="activate_microphone();">Activate Microphone</button>
        </div>
    <?php endif; ?>   
        
    <?php  if(isset($data['warning_site_requirement']) && !empty($data['warning_site_requirement'])): ?>
        <br>
        <?php foreach($data['warning_site_requirement'] as $warning): ?>
            <div class="alert alert-warning">
                <?= $warning ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>    
        
    <?php if($count_system_req_errs == 0 || $count_system_req_errs == ''): ?>    
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="<?php echo APP_BASE_URL ?>site/login" method="post">
                        <h3 class="text-center text-dark">Login</h3>
                        <?php  if(!empty($data)): ?>
                            <p class="text-center text-danger"><?= $data['invalid_login'] ?></p>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="username" class="text-dark">Username:</label><br>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-dark">Password:</label><br>
                            <input type="password" name="password" id="password" class="form-control">
                            <input type="checkbox" onclick="unmask_password()" id="see_password">
                            <label class="form-check-label" for="see_password">Show Password</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="login_type" id="login_type1" value="candidate" checked>
                            <label class="form-check-label" for="login_type1">Candidate</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="login_type" id="login_type2" value="admin">
                            <label class="form-check-label" for="login_type2">Administrator</label>
                        </div>  
                        <hr>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-success btn-md" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>    
</div>
<script>
    function unmask_password(){
        var x = document.getElementById("password"); if (x.type === "password") { x.type = "text"; } else { x.type = "password"; }
    }
    var APP_BASE_URL = '<?= APP_BASE_URL ?>';
    var is_camera_required = '<?= (isset($data['requirements']['camera'])) ? $data['requirements']['camera'] : ''; ?>';
    var is_microphone_required = '<?= (isset($data['requirements']['microphone'])) ? $data['requirements']['microphone'] : ''; ?>';
</script>