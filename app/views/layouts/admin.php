<?php 
$siteLevelCSS=[]; 
if(isset($data['includeSiteLevelCSS'])){ 
    foreach($data['includeSiteLevelCSS'] as $includeSiteLevelCSS){
        array_push($siteLevelCSS, $includeSiteLevelCSS);
    }
}
?>
<?= siteAdminHeader($siteLevelCSS); ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

      <?= adminSidebar(); ?>  

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

          <?= adminTopbar($data); ?>

          <?= $data['content']; ?>

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; <?= SITENAME .' '.date('Y'); ?></span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?= APP_BASE_URL ?>site/logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
    
<script>
//APP BASE URL
var APP_BASE_URL = '<?= APP_BASE_URL ?>';
</script>
<?php 
    $siteLevelJS=[]; 
    if(isset($data['includeSiteLevelJS'])){ 
        foreach($data['includeSiteLevelJS'] as $includeSiteLevelJS){
            array_push($siteLevelJS, $includeSiteLevelJS);
        }
    }
?>
<?= siteAdminFooter($siteLevelJS); ?>