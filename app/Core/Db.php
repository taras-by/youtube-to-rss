<?php

namespace App\Core;

use App\Config;
use PDO;

class Db
{
    /**
     * Options of the PDO connection
     */
    const DB_OPTIONS = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ];

    private static $instance = null;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * Open the database connection with credentials from App\Config
     */
    private function __construct()
    {
        $dsn = "mysql:host=" . Config::DB_HOSTNAME . ";" .
            "port=" . Config::DB_PORT . ";" .
            "dbname=" . Config::DB_DATABASE;

        $this->connection = new PDO(
            $dsn,
            Config::DB_USERNAME,
            Config::DB_PASSWORD,
            self::DB_OPTIONS
        );
    }

    protected function __clone()
    {
        //
    }

    static public function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}