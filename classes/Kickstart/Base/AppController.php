<?php

namespace Kickstart\Base;

class AppController
{
    CONST mlPerSecond = 26.7629329735;

    public function __construct()
    {
        if (php_sapi_name() !== 'cli') {
            $this->initializeRouter();
        }

        $this->initializeGPIOPins();
    }

    public function initializeRouter()
    {
        $router = new Router();
        require_once __DIR__.'/../../../config/routes.php';
        $router->execute();
    }

    public function initializeGPIOPins()
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

    /** 
     * @return bool
     */
    public function isMoist()
    {
        $moist = false;

        if ((int)file_get_contents('/sys/class/gpio/gpio27/value') === 0) {
            $moist = true;
        }

        return $moist;
    }

    /**
     * @return bool
     */
    public function checkEnoughWater()
    {
        $enoughWater = true;

        if ((int)file_get_contents('/sys/class/gpio/gpio22/value') === 0) {
            $enoughWater = false;

            // Send push notification to user with Instapush app
            $this->sendEmptyWaterNotification();
        }

        return $enoughWater;
    }

    /**
     * @param int $amount
     * @return void
     */
    public function doWatering(int $amount = 0)
    {
        if ($this->isMoist() === false && $this->checkEnoughWater()) {
            // Start a timer for calculating the amount of water that is beeing watered
            // This is also necessary if we have a fixed amount to loop a certiant time and
            // always check the moisture and water level
            $startOfWatering = time();

            // Check if a fixed amount should be watered
            if ($amount === 0) {
                // Start watering as long as the soil is dry and as long as we have enough water
                do {
                    file_put_contents('/sys/class/gpio/gpio17/value', 1);
                } while($this->isMoist() === false && $this->checkEnoughWater());

                // Calculate watered amount
                $endOfWatering = time();
                $timeOfWatering = $endOfWatering - $startOfWatering;
                // Subtract 1 second for filling the tube
                $amount = (int) ceil(($timeOfWatering - 1) * self::mlPerSecond);
            } else {
                // Add 1 second to fill the tube
                $secondsToWater = ($amount / self::mlPerSecond) + 1;
                // Start watering as long as the soil is dry, as we have enough water and as long
                // we have to water based on a calculation
                do {
                    file_put_contents('/sys/class/gpio/gpio17/value', 1);
                } while($this->isMoist() === false && $this->checkEnoughWater() && (time() <= $secondsToWater + $startOfWatering));
            }

            // Stop watering
            file_put_contents('/sys/class/gpio/gpio17/value', 0);

            // Log watering
            $databaseConnection = new DatabaseConnection();
            $databaseConnection->addWatering($amount);
        }
    }

    public function sendEmptyWaterNotification()
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.instapush.im/v1/post',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => '{
                "event": "Water_level",
                "trackers": {
                    "Water level": "Wassertank auffüllen"
                }
            }',
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => [
                'X-Instapush-Appid: 5877774ea4c48a86ecd40d34',
                'X-Instapush-Appsecret: 090f2d1f0213c4336ff54b4fccd18cc8',
                'Content-Type: application/json'
            ]
        ]);

        curl_exec($ch);
        curl_close ($ch);
    }
}
