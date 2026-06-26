<?php 

function buildConnection()
{
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "openmind";

    return new PDO("mysql:host=$host;dbname=$dbname", $username, $password, NULL);
}

