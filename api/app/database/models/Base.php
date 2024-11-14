<?php
namespace app\database\models;

use app\database\Connection;
use app\traits\Connection as TraitsConnection;
use app\traits\Create;
use app\traits\Delete;
use app\traits\Read;
use app\traits\Update;
use PDOException;

abstract class Base {

    use TraitsConnection, Read , Create,Update,Delete;

 
}