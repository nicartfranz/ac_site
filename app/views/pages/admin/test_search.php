<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="form-group">
        <form class="" method="POST" action="<?= APP_BASE_URL.'test/search/' ?>">
            <div class="input-group">
              <input value="<?= isset($_POST['assessment_name']) ? $_POST['assessment_name']  : ''; ?>" type="text" name="assessment_name" class="form-control bg-light border-1 col-lg-4" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button type="submit" name="search" class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
        </form>
    </div>
    
    <table class="table table-striped">
        <thead class="bg-primary text-light">
          <tr>
            <th>Name</th>
            <th>Code</th>
            <th>Date Created</th>
            <th>Date Modified</th>
          </tr>
        </thead>
        
        <tbody>
            
            <?php foreach($data['tests'] as $test): ?>
            <tr>
                <td><a href="<?= APP_BASE_URL ?>test/view/?id=<?= $test['id'] ?>" > <?= $test['AssName'] ?></td>
                <td><?= $test['AssCode'] ?></td>
                <td><?= $test['date_inserted'] ?></td>
                <td><?= $test['date_modified'] ?></td>
            </tr>
            <?php endforeach; ?>
            
        </tbody>
        
    </table>

</div>
<!-- /.container-fluid -->