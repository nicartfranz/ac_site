<?php 
$siteLevelCSS=['public/css/test_taker.css']; 
if(isset($data['includeSiteLevelCSS'])){ 
    foreach($data['includeSiteLevelCSS'] as $includeSiteLevelCSS){
        array_push($siteLevelCSS, $includeSiteLevelCSS);
    }
}
?>
<?= siteBasicHeader($siteLevelCSS); ?>
<?= siteBasicTopbar(); ?>
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