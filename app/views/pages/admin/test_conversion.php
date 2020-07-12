<!-- Begin Page Content -->
<div class="container-fluid">
    
    <?php if(isset($_GET['err_msg']) && !empty($_GET['err_msg'])): ?>
    <div class="alert alert-danger" role="alert">
       <?= $_GET['err_msg'] ?>
    </div>
    
    <?php endif; ?>
    
    <form  id="test_form" method="POST" action="<?= APP_BASE_URL.'test/convert/?id='.$data['test']['id'] ?>">
        <button type="submit" name="convert" class="btn btn-success" onclick="return confirm('Please confirm test conversion.')">Convert Test</button>
        <input type="hidden" name="assessment_id" value="<?= $data['test']['id'] ?>">
        <br>
        <br>
        <label class="col-md-4 control-label" for="radios">Group by:</label>
        <div class="col-md-4">
            <div class="radio">
                <label for="radios-0">
                  <input type="radio" name="group_test_by" id="radios-0" value="1" checked="checked">
                  Dimension Number
                </label>
            </div>
            <div class="radio">
              <label for="radios-1">
                <input type="radio" name="group_test_by" id="radios-1" value="2">
                Topic Code
              </label>
            </div>
        </div>
        
        <br>
        <label class="col-md-4 control-label" for="radios">Choose Layout:</label>
        <div class="col-md-4">
            <div class="radio">
                <label for="radios-test_layout-0">
                  <input type="radio" name="test_layout" id="radios-test_layout-0" value="basic" checked="checked">
                  Basic
                </label>
            </div>
            <div class="radio">
              <label for="radios-test_layout-1">
                <input type="radio" name="test_layout" id="radios-test_layout-1" value="custom">
                Custom
              </label>
            </div>
        </div>
        
    </form>
    
    <br>

    <table class="table table-bordered table-responsive" style="font-size:85%;">
        <thead class="thead-dark">
            <tr>
                <th>Dimension Name<br><small>(tbdimension.dimensionName)</small></th>
                <th>Dimension Number*<br><small>(tbdimension.dimensionNumber)</small></th>
                <th>Order<br><small>(tbtest_items.fldQOrder)</small></th>
                <th>Number<br><small>(tbtest_items.fldQNo)</small></th>
                <th>Dimension*<br><small>(tbtest_items.level)</small></th>
                <th>Topic Code<br><small>(tbtest_items.TopicCode)</small></th>
                <th>Question<br><small>(tbtest_items.question)</small></th>
                <th>Options<br><small>(tbtest_items.options)</small></th>
                <th>Type<br><small>(tbtest_items.QuesType)</small></th>
                <th>Correct Answer<br><small>(tbtest_items.CorrectAns)</small></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['test']['items_for_conversion'] as $question): ?>
            <tr>
                <td><?= $question['dimensionName'] ?></td>
                <td><?= $question['dimensionNumber'] ?></td>
                <td><?= $question['fldQOrder'] ?></td>
                <td><?= $question['fldQNo'] ?></td>
                <td><?= $question['level'] ?></td>
                <td><?= $question['TopicCode'] ?></td>
                <td><?= $question['question'] ?></td>
                <td><?= $question['options'] ?></td>
                <td><?= $question['QuesType'] ?></td>
                <td><?= $question['CorrectAns'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
<!-- /.container-fluid -->
<script>
var APP_BASE_URL = '<?= APP_BASE_URL ?>';   
</script>