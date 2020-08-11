<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="form-group">
        <label for="assessment_name" class="formbuilder-text-label">Assessment Name<span style="color:red">&nbsp;*</span></label>
        <input class="form-control col-lg-4" name="assessment_name" type="text" id="assessment_name" value="<?= $data['test']['AssName'] ?>">
    </div>
    <div class="form-group">
        <label for="assessment_code" class="formbuilder-text-label">Assessment Code<span style="color:red">&nbsp;*</span></label>
        <input class="form-control col-lg-4" disabled name="assessment_code" type="text" id="assessment_code" value="<?= $data['test']['AssCode'] ?>">
    </div>
    
    <label class="formbuilder-text-label">Drag and drop test components<span style="color:red">&nbsp;*</span></label>
    <div id="build-wrap"></div>

</div>
<!-- /.container-fluid -->
<script>
var test_id = '<?= $data['test']['id'] ?>';  
var questionsJSON = <?= $data['test']['question'] ?>    
var APP_BASE_URL = '<?= APP_BASE_URL ?>';   
</script>