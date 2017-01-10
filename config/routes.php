<?php

    $router->addRoute('/', function () {
        echo file_get_contents('views/home.html');
    });

    $router->addRoute('404', function () {
        die('Page not found');
    });
