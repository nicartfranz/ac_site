<div class="container-sm test-content">
   
    <div class="jumbotron">
        <center>
            <h4 class="display-8">Informed Consent</h4>    
        </center>
        
        <p class="lead">You are invited to take an assessment relative to your application to Profiles Asia Pacific.</p>

        <p>As an integral part of the recruitment and assessment process of the organization, you will be taking a battery of tests which is designed to measure and evaluate different psychological domains such as:</p>

        <div>
            <center>
                <table>
                    <tr>
                        <td>Cognitive Abilities</td>
                        <td>Work Values</td>
                    </tr>
                    <tr>
                        <td>Personal Traits</td>
                        <td>Attitudes</td>
                    </tr>
                    <tr>
                        <td>Behavioral Inclinations</td>
                        <td></td>
                    </tr>
                </table>
            </center>
        </div>  
            
        <br>
        <p>In addition, you will be asked for your personal information such as your name, age, gender, contact information, years of working experience and highest level of educational attainment. Your photo will be randomly taken as means for the Profiles Asia Pacific to validate your identity as the test-taker. All information will be stored, secured and kept in strictest confidence by Profiles Asia Pacific/People Dynamics for norming and research purposes.</p>

        <p>Please take time to read all instructions and raise any questions to the test administrator for clarifications. All data gathered through the Profiles Assessment Center Site (i.e., your personal information and assessment results) will be available to the Human Resource Department of Profiles Asia Pacific.</p>
        
        <p>If you agree to the provisions stated above, please tick the checkboxes below:</p>
        
        <div class="form-check">
            <label class="agree-1">
                <input type="checkbox" class="agree-1" value=""> I give consent to the Profiles Asia Pacific and Profiles Asia Pacific to collect, store and manage the data collected through the Profiles Assessment Center.
            </label>
        </div>
        
        <div class="form-check">
            <label class="agree-2">
                <input type="checkbox" class="agree-2" value=""> I grant permission to the Profiles Assessment Center Site to randomly capture photos to validate my identity as the candidate of Profiles Asia Pacific.
            </label>
        </div>
        
        <div id="agree-1-2-error-msg">
            <span>By not checking the checkboxes above, you are officially withdrawing consent to Profiles Asia Pacific and Profiles Asia Pacific to collect, store and manage the data collected through the Profiles Assessment Center. Please contact the person who referred you to take the exam to inform them of your choice.</span>
        </div>
        <p>By ticking the checkboxes above, you are granting permission to Profiles Asia Pacific (or agents acting on their behalf) that directed you this assessment to receive the results of this evaluation. And all information included herein.</p>
        
        <center>
            <button id="take_assessment" class="btn btn-primary btn-md" role="button">Take Assessment</button>
            <a class="btn btn-danger btn-md" href="<?= APP_BASE_URL.'logout.php' ?>" role="button">Logout</a>
        </center>
        
    </div>
    
</div>
<script>
var APP_BASE_URL = '<?= APP_BASE_URL ?>';
</script>