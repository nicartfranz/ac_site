<div class="container-sm test-content">
   
    <div class="jumbotron">
        <h4 class="display-8">Hello, <?= $_SESSION['candidate_info']['fname'] ?>!</h4>
        <p class="lead">You are invited to take an assessment relative to your application to Profiles Asia Pacific.</p>
        <hr class="my-4">
        <div class="form-group">
            <label for="scheduled_tests">Please select the assessment you want to take:</label>
            <select class="form-control" id="scheduled_tests">
                <?php foreach ($data['scheduled_tests'] as $test): ?>
                <option value="<?= $test['AssCode'] ?>"><?= $test['AssName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <a class="btn btn-primary btn-lg" onclick="var scheduled_tests = '<?= APP_BASE_URL ?>'+$('#scheduled_tests').val(); javascript:location.href=scheduled_tests+'/page1'" href="javascript:void(0);" role="button">Proceed</a>
    </div>
    
</div>