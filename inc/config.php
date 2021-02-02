<?php

    define('DEBUG', false);

    set_time_limit(0);
    ini_set('post_max_size', '600M');
    ini_set('upload_max_filesize', '600M');

    if(DEBUG == true) {
        ini_set('display_errors', 'On');
        error_reporting(E_ALL & ~E_NOTICE);
    } else {
        ini_set('display_errors', 'Off');
        error_reporting(0);
    }
    date_default_timezone_set('America/Manaus');

    $pageTitle = 'Webpage Manager v1';
    $appTitle = 'Webpage Manager v1';
    $databaseHost = 'localhost';
    $databaseUser = 'root';
    $databasePass = '0000';
    $databaseName = 'ln_website';
    $databasePort = 3307;
    $githubLink = "https://github.com/andreadelucca/webpage_manager";

    $connection = mysqli_connect($databaseHost, $databaseUser, $databasePass, $databaseName, $databasePort);
    $selectDatabase = mysqli_select_db($connection, $databaseName);
    $databaseCharset = mysqli_set_charset($connection, 'UTF8');
