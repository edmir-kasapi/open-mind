<?php

require_once('db/DBConnection.php');
require_once('db/QueryBuilder.php');

class Repository
{
    protected $pdo;
    protected $queryBuilder;

    public function __construct()
    {
        //$this -> pdo = DBConnection::getConnection();
        //$this -> queryBuilder = new QueryBuilder();
    }
}

?>