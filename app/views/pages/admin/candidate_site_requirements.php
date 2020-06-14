<!-- Begin Page Content -->
<div class="container-fluid">

    <?php if(isset($data['success_update_insert']) && $data['success_update_insert'] == true): ?>
        <div class="alert alert-success">
            <strong>Success!</strong> candidate site system requirements has been updated.
        </div>
    <?php endif; ?>
    <form class="form-horizontal" name="candidate_site_requirements" method="POST" action="<?= APP_BASE_URL.'candidatesitesettings/requirements' ?>">
        
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <!-- Select Multiple -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="selectmultiple_webbrowser"><b>Web Browsers:</b></label>
          <div class="col-md-4">
            <select id="selectmultiple_webbrowser" name="selectmultiple_webbrowser[]" class="form-control" multiple="multiple">
              <option value="Chrome" <?= isMultiOptionSelected('Chrome', $data['web_browsers']) ?> >Google Chrome</option>
              <option value="Firefox" <?= isMultiOptionSelected('Firefox', $data['web_browsers']) ?> >Mozilla Firefox</option>
              <option value="Edge" <?= isMultiOptionSelected('Edge', $data['web_browsers']) ?> >Microsoft Edge</option>
              <option value="Internet Explorer" <?= isMultiOptionSelected('Internet Explorer', $data['web_browsers']) ?> >Internet Explorer</option>
              <option value="Safari" <?= isMultiOptionSelected('Safari', $data['web_browsers']) ?> >Safari</option>
              <option value="Opera Mini" <?= isMultiOptionSelected('Opera Mini', $data['web_browsers']) ?> >Opera</option>
            </select>
          </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="checkboxes_devices"><b>Devices:</b></label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="checkboxes_devices-0">
                <input type="checkbox" name="checkboxes_devices[]" id="checkboxes_devices-0" value="desktop" <?= isCheckboxChecked("desktop", $data['devices']) ?> >
              Desktop
            </label>
                </div>
          <div class="checkbox">
            <label for="checkboxes_devices-1">
              <input type="checkbox" name="checkboxes_devices[]" id="checkboxes_devices-1" value="mobile" <?= isCheckboxChecked("mobile", $data['devices']) ?> >
              Mobile
            </label>
          </div>
          <div class="checkbox">
            <label for="checkboxes_devices-2">
              <input type="checkbox" name="checkboxes_devices[]" id="checkboxes_devices-2" value="tablet" <?= isCheckboxChecked("tablet", $data['devices']) ?> >
              Tablet
            </label>
                </div>
          </div>
         
        </div>

        <!-- Select Multiple -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="selectmultiple_os"><b>Operating System:</b></label>
          <div class="col-md-4">
            <select id="selectmultiple_os" name="selectmultiple_os[]" class="form-control" multiple="multiple">
              <option value="Windows" <?= isMultiOptionSelected('Windows', $data['os']) ?> >Windows</option>
              <option value="OS X" <?= isMultiOptionSelected('OS X', $data['os']) ?> >OS X</option>
              <option value="Android" <?= isMultiOptionSelected('Android', $data['os']) ?> >Android (Mobile)</option>
              <option value="iOS" <?= isMultiOptionSelected('iOS', $data['os']) ?> >IOS (Mobile)</option>
            </select>
          </div>
        </div>

        <!-- Multiple Radios (inline) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="radios_cookies"><b>Cookies:</b></label>
          <div class="col-md-4"> 
            <label class="radio-inline" for="radios_cookies-0">
              <input type="radio" name="radios_cookies" id="radios_cookies-0" value="1" <?= isRadioboxChecked(1, $data['cookies']) ?> >
              Required
            </label> 
            &nbsp;&nbsp;&nbsp;
            <label class="radio-inline" for="radios_cookies-1">
              <input type="radio" name="radios_cookies" id="radios_cookies-1" value="0" <?= isRadioboxChecked(0, $data['cookies']) ?> >
              Not Required
            </label>
          </div>
        </div>

        <!-- Multiple Radios (inline) -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="radios_camera"><b>Camera:</b></label>
          <div class="col-md-4"> 
            <label class="radio-inline" for="radios_camera-0">
              <input type="radio" name="radios_camera" id="radios_camera-0" value="1" <?= isRadioboxChecked(1, $data['camera']) ?> >
              Required
            </label> 
            &nbsp;&nbsp;&nbsp;
            <label class="radio-inline" for="radios_camera-1">
              <input type="radio" name="radios_camera" id="radios_camera-1" value="0" <?= isRadioboxChecked(0, $data['camera']) ?> >
              Not Required
            </label>
          </div>
        </div>
        
        <!-- Multiple Radios (inline) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="radios_microphone"><b>Microphone:</b></label>
            <div class="col-md-4"> 
              <label class="radio-inline" for="radios_microphone-0">
                <input type="radio" name="radios_microphone" id="radios_microphone-0" value="1" <?= isRadioboxChecked(1, $data['microphone']) ?> >
                Required
              </label> 
              &nbsp;&nbsp;&nbsp;
              <label class="radio-inline" for="radios_microphone-1">
                <input type="radio" name="radios_microphone" id="radios_microphone-1" value="0" <?= isRadioboxChecked(0, $data['microphone']) ?> >
                Not Required
              </label>
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="singlebutton"></label>
          <div class="col-md-4">
              <button type="submit" value="update" id="submit" name="submit" class="btn btn-success">Save Settings</button>
          </div>
        </div>

    </form>

</div>
<!-- /.container-fluid -->
<script>
var APP_BASE_URL = '<?= APP_BASE_URL ?>';   
</script>