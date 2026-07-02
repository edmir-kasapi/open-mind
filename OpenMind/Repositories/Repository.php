<?php

require_once('db/DBConnection.php');

class Repository
{
    protected $pdo;

    public function __construct()
    {
        $this -> pdo = DBConnection::getConnection();
    }
}

?>