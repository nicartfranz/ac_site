<!-- Login Page Content -->
<div class="container">
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
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-info btn-md" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
