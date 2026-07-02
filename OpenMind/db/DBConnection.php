<?php

class DBConnection
{
    private static $connection = null;
    private static $host = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "openmind";
    

    public static function getConnection()
    {
        $host = self::$host;
        $dbname = self::$dbname;
        $username = self::$username;
        $password = self::$password;

        if(self::$connection == null){

            self::$connection = new PDO(
                "mysql:host=$host;dbname=$dbname",
                $username,
                $password,
            );

            self::$connection -> setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
            );
        }

        return self::$connection;
    }
}

?>