<?php

/* 
 * Contributor: Franz
 * Date Modified: May 9, 2020
 * 
 * Description: This file contains all the helper functions that is available everywhere in the site.
 */

//Franz: Loads the site basic header (DEFAULT)
function siteBasicHeader(){
    $html ="<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                <link rel='stylesheet' href='".BASE_URL."/css/style.css'>
                <title>".SITENAME."</title>
            </head>
            <body>";
    return $html;
}

//Franz: Loads the site basic footer (DEFAULT)
function siteBasicFooter(){
    $html = "<script src='".BASE_URL."/js/main.js'></script>"
            . "</body>"
            . "</html>";
    return $html;
}

