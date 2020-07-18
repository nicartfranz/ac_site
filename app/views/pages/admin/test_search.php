<!-- Begin Page Content -->
<div class="container-fluid">

    <form class="form-horizontal" method="GET" action="<?= APP_BASE_URL.'test/search/' ?>">
        

        <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Test Name:</span>
                    </div>
                    <input value="<?= isset($_GET['assessment_name']) ? $_GET['assessment_name']  : ''; ?>" type="text" name="assessment_name" class="form-control bg-light border-1 col-lg-3" aria-label="Search" autocomplete="off">
                     <div class="input-group-prepend">
                        <span class="input-group-text">Test Code:</span>
                    </div>
                    <input value="<?= isset($_GET['assessment_code']) ? $_GET['assessment_code']  : ''; ?>" type="text" name="assessment_code" class="form-control bg-light border-1 col-lg-2" aria-label="Search" aria-describedby="basic-addon2" autocomplete="off">
                    <div class="input-group-append">
                        <button type="submit" name="search" value="1" class="btn btn-primary" type="button">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
        </div>

        <div class="float-right">
        <?php
        echo $data['page_links'];
        ?>
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

        <div class="float-right">
        <?php
        echo $data['page_links'];
        ?>
        </div> 
            
    </form>


</div>
<!-- /.container-fluid -->