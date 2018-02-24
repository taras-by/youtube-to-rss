<?php

namespace App\Core;

use PDO;

class Model
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->db = Db::getInstance()->getConnection();
    }
}