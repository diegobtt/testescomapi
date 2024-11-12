<?php

namespace app\traits;

use app\database\Connection as DatabaseConnection;

trait Connection {

    protected $connection;


    public function __construct()
    {   
        $this->connection = DatabaseConnection::connection();    
    }
}