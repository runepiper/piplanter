<?php

namespace Kickstart\Base;

class DatabaseConnection
{
    const USER = 'root';
    const PASSWORD = 'password';
    const DATABASE = 'piplanter';

    private $connection = null;

    function __construct()
    {
        $this->connection = new \PDO('mysql:host=localhost;dbname='.self::DATABASE, self::USER, self::PASSWORD);
    }

    public function addWatering(int $amount)
    {
        $query = $this->connection->prepare('INSERT INTO watering (crdate, amount) VALUES ('.time().', '.$amount.')');
        $query->execute();
    }

    public function getLog(int $limit = 10)
    {
        $query = $this->connection->query('SELECT * FROM watering ORDER BY crdate DESC LIMIT '.$limit);

        return $query->fetchAll();
    }

    function __destruct()
    {
        // $this->connection = null;
    }
}
