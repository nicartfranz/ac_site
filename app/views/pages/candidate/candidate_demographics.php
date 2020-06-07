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
                      <input type="radio" name="gender" id="radio-male" value="1">
                      Male
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-female">
                      <input type="radio" name="gender" id="radio-female" value="2">
                      Female
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-gender-secret">
                      <input type="radio" name="gender" id="radio-gender-secret" value="3">
                      I do not want to disclose
                      </label>
                   </div>
                </div>
             </div>
             <!-- Multiple Radios -->
             <div class="form-group">
                <label class="col-md-5 control-label" for="radios"><b>Highest Educational Attainment:</b></label>
                <div class="col-md-5">
                   <div class="radio">
                      <label for="radio-hs">
                      <input type="radio" name="educational_attaiment" id="radio-hs" value="1">
                      High School Graduate
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-vocational">
                      <input type="radio" name="educational_attaiment" id="radio-vocational" value="2">
                      Vocational Graduate
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-college-under">
                      <input type="radio" name="educational_attaiment" id="radio-college-under" value="3">
                      College Undergraduate
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-college">
                      <input type="radio" name="educational_attaiment" id="radio-college" value="4">
                      College Graduate
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-ongoing-post-grad">
                      <input type="radio" name="educational_attaiment" id="radio-ongoing-post-grad" value="5">
                      Undergoing Post Graduate Degree Studies
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-post-grad">
                      <input type="radio" name="educational_attaiment" id="radio-post-grad" value="6">
                      Post Graduate Degree Holder
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-educ-secret">
                      <input type="radio" name="educational_attaiment" id="radio-educ-secret" value="7">
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
                      <input type="number" class="form-control" id="work_exp_yr" name="work_exp_yr"> Year(s)
                    </div>
                    <div class="col-4">
                      <input type="number" class="form-control" id="work_exp_mon" name="work_exp_mon"> Month(s)
                    </div>
                </div>
             </div>
             <!-- Multiple Radios -->
             <div class="form-group">
                <label class="col-md-4 control-label" for="radios"><b>Position Applying For:</b></label>
                <div class="col-md-4">
                   <div class="radio">
                      <label for="radio-staff">
                      <input type="radio" name="position" id="radio-staff" value="1">
                      Staff Level
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-office">
                      <input type="radio" name="position" id="radio-office" value="2">
                      Officer Level
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-supervisory">
                      <input type="radio" name="position" id="radio-supervisory" value="3">
                      Supervisory Level
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-managerial">
                      <input type="radio" name="position" id="radio-managerial" value="4">
                      Managerial Level
                      </label>
                   </div>
                   <div class="radio">
                      <label for="radio-director">
                      <input type="radio" name="position" id="radio-director" value="5">
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