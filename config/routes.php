<?php

$router->addRoute('/', function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->doWatering((int) $_POST['amount']);
    }

    $databaseConnection = new \Kickstart\Base\DatabaseConnection();
    $log = $databaseConnection->getLog();

    require 'views/home.php';
});

$router->addRoute('404', function () {
    die('Seite nicht gefunden');
});
