<?php  
$debug_mode = (isset($_GET['debug_mode'])) ? 1 : 0;
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <a href="<?= APP_BASE_URL ?>test/update/?id=<?= $_GET['id'] ?>" class="btn btn-warning float-right">Edit</a>
    <a onclick="window.open('<?= APP_BASE_URL.$data['test']['AssCode'] ?>/', '_blank', 'location=yes,height=800,width=500,scrollbars=yes,status=yes');" href="javascript:void(0);" class="btn btn-info float-right mr-2">Preview</a>
    <?php if($debug_mode == '0'): ?>
        <a href="<?= APP_BASE_URL ?>test/view/?id=<?= $_GET['id'] ?>&debug_mode=1" class="btn btn-secondary float-right float-right mr-2"><i class="fa fa-bug" aria-hidden="true"></i> Debug Mode ON</a>
    <?php else: ?>
        <a href="<?= APP_BASE_URL ?>test/view/?id=<?= $_GET['id'] ?>" class="btn btn-secondary float-right float-right mr-2"><i class="fa fa-bug" aria-hidden="true"></i> Debug Mode OFF</a>
    <?php endif; ?>

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

<!-- Modal -->
<!--<div class="modal fade" id="testViewModal" tabindex="-1" role="dialog" aria-labelledby="testViewModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="testViewModalTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>-->


<!-- /.container-fluid -->
<script>
var questionsJSON = <?= $data['test']['question'] ?>    
var debug_mode = <?= $debug_mode ?>
</script>