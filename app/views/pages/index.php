<?php $siteLevelCSS=['public/css/login.css']; ?>
<?=siteBasicHeader($siteLevelCSS);?>
<?=siteBasicTopbar();?>
    <?= $data['content']; ?>
<?php 
    $siteLevelJS=[]; 
    if(isset($data['includeSiteLevelJS'])){ 
        foreach($data['includeSiteLevelJS'] as $includeSiteLevelJS){
            array_push($siteLevelJS, $includeSiteLevelJS);
        }
    }
?>
<?= siteBasicFooter($siteLevelJS); ?>