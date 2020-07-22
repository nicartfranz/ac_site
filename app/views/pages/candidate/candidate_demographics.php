<?php 
if($data['candidate_info']['workexp'] != ''){
    list($workexp_yr, $workexp_mon) = explode('and', $data['candidate_info']['workexp']);
    $workexp_yr = trim($workexp_yr);
    $workexp_mon = trim($workexp_mon);
} else {
    $workexp_yr = 0;
    $workexp_mon = 0;
}
?>

<div class="container-sm test-content">
    
    <div class="jumbotron">
        <form class="form-horizontal" method="POST">
          <fieldset>
             <!-- Form Name -->
             <legend>Personal Information</legend>

             <div class="alert alert-success">
                Please fill up the following information.
             </div>
             <!-- Multiple Radios -->
             <div class="form-group">
                <label class="col-md-4 control-label" for="radios"><b>Gender:</b></label>
                <div class="col-md-4">
                   <div class="radio">
                      <label for="radio-male">
                      <input type="radio" name="gender" id="radio-male" value="M" required <?php if(isset($_POST['gender']) && $_POST['gender'] == 'M' || $data['candidate_info']['gender'] == 'M'){ echo 'checked'; } ?>>
                      Male
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-female">
                      <input type="radio" name="gender" id="radio-female" value="F" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'F' || $data['candidate_info']['gender'] == 'F'){ echo 'checked'; } ?>>
                      Female
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-gender-secret">
                      <input type="radio" name="gender" id="radio-gender-secret" value="U" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'U' || $data['candidate_info']['gender'] == 'U'){ echo 'checked'; } ?>>
                      I do not want to disclose
                      </label>
                   </div>
                </div>
             </div>
             <!-- Text input-->
             <div class="form-group">
                <label class="col-md-4 control-label" for="age"><b>Age:</b></label>  
                <div class="row col-12">
                    <div class="col-4">
                        <input type="number" class="form-control" id="age" name="age" <?php if(isset($_POST['age']) && $_POST['age'] != ''){ echo "value='".$_POST['age']."'"; } else { echo "value='".$data['candidate_info']['age']."'"; } ?>>
                    </div>
                </div>
             </div>
             <!-- Multiple Radios -->
             <div class="form-group">
                <label class="col-md-5 control-label" for="radios"><b>Highest Educational Attainment:</b></label>
                <div class="col-md-5">
                   <div class="radio">
                      <label for="radio-hs">
                      <input type="radio" name="educational_attaiment" id="radio-hs" value="High School Graduate" required <?php if(isset($_POST['educational_attaiment']) && $_POST['educational_attaiment'] == 'High School Graduate' || $data['candidate_info']['high_educ'] == 'High School Graduate'){ echo 'checked'; } ?>>
                      High School Graduate
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-vocational">
                      <input type="radio" name="educational_attaiment" id="radio-vocational" value="Vocational Graduate" <?php if(isset($_POST['educational_attaiment']) && $_POST['educational_attaiment'] == 'Vocational Graduate' || $data['candidate_info']['high_educ'] == 'Vocational Graduate'){ echo 'checked'; } ?>>
                      Vocational Graduate
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-college-under">
                      <input type="radio" name="educational_attaiment" id="radio-college-under" value="College Undergraduate" <?php if(isset($_POST['educational_attaiment']) && $_POST['educational_attaiment'] == 'College Undergraduate' || $data['candidate_info']['high_educ'] == 'College Undergraduate'){ echo 'checked'; } ?>>
                      College Undergraduate
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-college">
                      <input type="radio" name="educational_attaiment" id="radio-college" value="College Graduate" <?php if(isset($_POST['educational_attaiment']) && $_POST['educational_attaiment'] == 'College Graduate' || $data['candidate_info']['high_educ'] == 'College Graduate'){ echo 'checked'; } ?>>
                      College Graduate
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-ongoing-post-grad">
                      <input type="radio" name="educational_attaiment" id="radio-ongoing-post-grad" value="Undergoing Post Graduate Degree Studies" <?php if(isset($_POST['educational_attaiment']) && $_POST['educational_attaiment'] == 'Undergoing Post Graduate Degree Studies' || $data['candidate_info']['high_educ'] == 'Undergoing Post Graduate Degree Studies'){ echo 'checked'; } ?>>
                      Undergoing Post Graduate Degree Studies
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-post-grad">
                      <input type="radio" name="educational_attaiment" id="radio-post-grad" value="Post Graduate Degree Holder" <?php if(isset($_POST['educational_attaiment']) && $_POST['educational_attaiment'] == 'Post Graduate Degree Holder' || $data['candidate_info']['high_educ'] == 'Post Graduate Degree Holder'){ echo 'checked'; } ?>>
                      Post Graduate Degree Holder
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-educ-secret">
                      <input type="radio" name="educational_attaiment" id="radio-educ-secret" value="I do not want to answer" <?php if(isset($_POST['educational_attaiment']) && $_POST['educational_attaiment'] == 'I do not want to answer' || $data['candidate_info']['high_educ'] == 'I do not want to answer'){ echo 'checked'; } ?>>
                      I do not want to answer
                      </label>
                   </div>
                </div>
             </div>
             <!-- Text input-->
             <div class="form-group">
                <label class="col-md-4 control-label" for="work_exp_yr"><b>Work Experience:</b></label>  
                <div class="row col-12">
                    <div class="col-4">
                        <input type="number" class="form-control" id="work_exp_yr" name="work_exp_yr" required <?php if(isset($_POST['work_exp_yr']) && $_POST['work_exp_yr'] != ''){ echo "value='".$_POST['work_exp_yr']."'"; } else { echo "value='".$workexp_yr."'"; } ?>> Year(s)
                    </div>
                    <div class="col-4">
                        <input type="number" class="form-control" id="work_exp_mon" name="work_exp_mon" required <?php if(isset($_POST['work_exp_mon']) && $_POST['work_exp_mon'] != ''){ echo "value='".$_POST['work_exp_mon']."'"; } else { echo "value='".$workexp_mon."'"; } ?>> Month(s)
                    </div>
                </div>
             </div>
             <!-- Multiple Radios -->
             <div class="form-group">
                <label class="col-md-4 control-label" for="radios"><b>Position Applying For:</b></label>
                <div class="col-md-4">
                   <div class="radio">
                      <label for="radio-staff">
                      <input type="radio" name="position" id="radio-staff" value="Staff Level" required <?php if(isset($_POST['position']) && $_POST['position'] == 'Staff Level' || $data['candidate_info']['job_level'] == 'Staff Level'){ echo 'checked'; } ?>>
                      Staff Level
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-office">
                      <input type="radio" name="position" id="radio-office" value="Officer Level" <?php if(isset($_POST['position']) && $_POST['position'] == 'Officer Level' || $data['candidate_info']['job_level'] == 'Officer Level'){ echo 'checked'; } ?>>
                      Officer Level
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-supervisory">
                      <input type="radio" name="position" id="radio-supervisory" value="Supervisory Level" <?php if(isset($_POST['position']) && $_POST['position'] == 'Supervisory Level' || $data['candidate_info']['job_level'] == 'Supervisory Level'){ echo 'checked'; } ?>>
                      Supervisory Level
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-managerial">
                      <input type="radio" name="position" id="radio-managerial" value="Managerial Level" <?php if(isset($_POST['position']) && $_POST['position'] == 'Managerial Level' || $data['candidate_info']['job_level'] == 'Managerial Level'){ echo 'checked'; } ?>>
                      Managerial Level
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-director">
                      <input type="radio" name="position" id="radio-director" value="Director Level" <?php if(isset($_POST['position']) && $_POST['position'] == 'Director Level' || $data['candidate_info']['job_level'] == 'Director Level'){ echo 'checked'; } ?>>
                      Director Level
                      </label>
                   </div>
                </div>
             </div>

             <!-- Button -->
             <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-4">
                    <button id="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
             </div>

          </fieldset>
       </form>
    </div>
</div>
<script>
   var APP_BASE_URL = '<?= APP_BASE_URL ?>';
</script>