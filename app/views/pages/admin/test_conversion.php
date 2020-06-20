<!-- Begin Page Content -->
<div class="container-fluid">
    
    <?php if(isset($_GET['err_msg']) && !empty($_GET['err_msg'])): ?>
    <div class="alert alert-danger" role="alert">
       <?= $_GET['err_msg'] ?>
    </div>
    
    <?php endif; ?>
    
    <form id="test_form" method="POST" action="<?= APP_BASE_URL.'test/convert/?id='.$data['test']['id'] ?>">
        <button type="submit" name="convert" class="btn btn-success" onclick="return confirm('Please confirm test conversion.')">Convert Test</button>
        <input type="hidden" name="assessment_id" value="<?= $data['test']['id'] ?>">
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