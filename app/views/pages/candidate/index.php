<div class="container-sm test-content">
   
    <div class="jumbotron">
        <h4 class="display-8">Hello, test taker!</h4>
        <p class="lead">This is a welcome message, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <div class="form-group">
            <label for="scheduled_tests">Scheduled Test(s):</label>
            <select class="form-control" id="scheduled_tests">
                <?php foreach ($data['scheduled_tests'] as $test): ?>
                <option value="<?= $test['AssCode'] ?>"><?= $test['AssName'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <a class="btn btn-primary btn-lg" onclick="var scheduled_tests = '<?= APP_BASE_URL ?>'+$('#scheduled_tests').val(); javascript:location.href=scheduled_tests+'/page1'" href="javascript:void(0);" role="button">Proceed</a>
    </div>
    
</div>