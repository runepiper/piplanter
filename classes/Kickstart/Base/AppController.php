<?php

namespace Kickstart\Base;

class AppController
{
    public function __construct()
    {
        $this->initializeRouter();
        $this->initializeGPIOPins();
    }

    private function initializeRouter()
    {
        $router = new Router();
        require_once __DIR__.'/../../../config/routes.php';
        $router->execute();
    }

    private function initializeGPIOPins()
    {
        // Waterpump
        if (file_exists('/sys/class/gpio/gpio17') === false) {
            file_put_contents('/sys/class/gpio/export', 17);
            sleep(1);
            file_put_contents('/sys/class/gpio/gpio17/direction', 'out');
        }

        // Moisture sensor
        if (file_exists('/sys/class/gpio/gpio27') === false) {
            file_put_contents('/sys/class/gpio/export', 27);
            sleep(1);
            file_put_contents('/sys/class/gpio/gpio27/direction', 'in');
        }

        // Water level
        if (file_exists('/sys/class/gpio/gpio22') === false) {
            file_put_contents('/sys/class/gpio/export', 22);
            sleep(1);
            file_put_contents('/sys/class/gpio/gpio22/direction', 'in');
        }
    }
}
