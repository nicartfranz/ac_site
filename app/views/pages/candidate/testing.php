<?php 
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';
//current datetime;
$now = date('Y-m-d H:i:s');

//Timer sessions
$test_time_remaining_hr = (isset($_SESSION[$data['AssCode']]['test_time_remaining_hr'])) ? $_SESSION[$data['AssCode']]['test_time_remaining_hr'] : -1;
$test_time_remaining_min = (isset($_SESSION[$data['AssCode']]['test_time_remaining_min'])) ? $_SESSION[$data['AssCode']]['test_time_remaining_min'] : -1;
$test_time_remaining_sec = (isset($_SESSION[$data['AssCode']]['test_time_remaining_sec'])) ? $_SESSION[$data['AssCode']]['test_time_remaining_sec'] : -1;
$test_timer_end_time = (isset($_SESSION[$data['AssCode']]['test_timer_end_time'])) ? $_SESSION[$data['AssCode']]['test_timer_end_time'] : -1;
?>
<div class="container-sm test-content">
    
    <?php if(strtotime($test_timer_end_time) < strtotime($now)): ?>
        <div id="test_timer">
            <div>Times up!</div>
        </div>
    <?php else: ?>
        <div id="test_timer" style="display: none;">
            <div>Time Remaining:</div>
            <div>
                <span id="test_time_remaining_hr"><?= $test_time_remaining_hr.'h :' ?></span>
                <span id="test_time_remaining_min"><?= $test_time_remaining_min.'m :' ?></span>
                <span id="test_time_remaining_sec"><?= $test_time_remaining_sec.'s' ?></span>
            </div>
        </div>
    <?php endif; ?>
   
    <form id="test_form" method="POST" action="<?= APP_BASE_URL.$data['AssCode'].'/'.$data['submit_page'] ?>">
        <div id="build-wrap"></div>
    </form>
    
</div>
<script>
//Timer JS vars
var test_time_remaining_hr = <?= $test_time_remaining_hr ?>;
var test_time_remaining_min = <?= $test_time_remaining_min ?>;
var test_time_remaining_sec = <?= $test_time_remaining_sec ?>;
var test_timer_end_time = '<?= date('m/d/Y H:i:s', strtotime($test_timer_end_time)) ?>'; // format as "mm/dd/yyyy hh:mm:ss" to fix IE Nan:Nan:Nan
//On times up => run this js
var onTimesup = '<?= $data['onTimesUp'] ?>';

//Question JSON data
var questionsJSON = <?= $data['question'] ?> 
</script>