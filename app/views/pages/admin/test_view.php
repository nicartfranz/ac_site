<!-- Begin Page Content -->
<div class="container-fluid">

    <a href="<?= APP_BASE_URL ?>test/update/?id=<?= $_GET['id'] ?>" class="btn btn-warning float-right">Update</a>
    <div class="form-group">
        <label for="assessment_name" class="formbuilder-text-label">Assessment Name: </label>
        <?= $data['test']['AssName'] ?>
    </div>
    <div class="form-group">
        <label for="assessment_code" class="formbuilder-text-label">Assessment Code: </label>
        <?= $data['test']['AssCode'] ?>
    </div>
    
    <label class="formbuilder-text-label">Question(s):</label>
    <div id="build-wrap"></div>
    
</div>
<!-- /.container-fluid -->
<script>
var questionsJSON = <?= $data['test']['question'] ?>    
</script>