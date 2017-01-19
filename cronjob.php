<?php
    if (phpversion() < 7) {
        die('PHP 7 is required');
    }

    require_once __DIR__.'/vendor/autoload.php';

    $app = new \Kickstart\Base\AppController();
    $app->doWatering();
