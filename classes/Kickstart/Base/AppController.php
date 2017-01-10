<?php

namespace Kickstart\Base;

class AppController
{
    public function __construct()
    {
        $this->loadRouter();
    }

    private function loadRouter()
    {
        $router = new Router();
        require_once __DIR__.'/../../../config/routes.php';
        $router->execute();
    }
}
