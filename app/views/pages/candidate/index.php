<div class="container-sm test-content">
   
    <div class="jumbotron">
        <h4 class="display-8">Hello, <?= ($_SESSION['usertype'] == 'super_admin') ? 'Super Admin' : $_SESSION['candidate_info']['fname'] ?>!</h4>
        <p class="lead">You are invited to take an assessment relative to your application to Profiles Asia Pacific.</p>
        <hr class="my-4">
        <div class="form-group">
            <label for="scheduled_tests">Please select the assessment you want to take:</label>
            <select class="form-control" id="scheduled_tests">
                <?php foreach ($data['scheduled_tests'] as $test): ?>
                
                <?php 
                    if(in_array($test['status'], array('completed', 'scored'))){
                        $page = 'scored';
                        $option_style = 'style="background:#b1b1b1;font-weight:bold;color:#FFF;"';
                    } else {
                        $page = 'page1';
                        $option_style = '';
                    }
                ?>
                
                <option <?= $option_style ?> value="<?= $test['AssCode'].'/'.$page ?>"><?= $test['AssName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <a class="btn btn-primary btn-lg" onclick="var scheduled_tests = '<?= APP_BASE_URL ?>'+$('#scheduled_tests').val(); javascript:location.href=scheduled_tests" href="javascript:void(0);" role="button">Proceed</a>
    </div>
    
</div>