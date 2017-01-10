<?php
    if (phpversion() < 7) {
        die('PHP 7 is required');
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__.'/vendor/autoload.php';

    $app = new \Kickstart\Base\AppController();
