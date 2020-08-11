<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="form-group">
        <label for="assessment_name" class="formbuilder-text-label">Assessment Name<span style="color:red">&nbsp;*</span></label>
        <input class="form-control col-lg-4" name="assessment_name" type="text" id="assessment_name">
    </div>
    <div class="form-group">
        <label for="assessment_code" class="formbuilder-text-label">Assessment Code<span style="color:red">&nbsp;*</span></label>
        <input class="form-control col-lg-4" name="assessment_code" minlength="4" maxlength="4" type="text" id="assessment_code">
    </div>
    
    <label class="formbuilder-text-label">Drag and drop test components<span style="color:red">&nbsp;*</span></label>
    <div id="build-wrap"></div>

</div>
<!-- /.container-fluid -->
<script>
var APP_BASE_URL = '<?= APP_BASE_URL ?>';   
</script>