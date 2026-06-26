<?php

require('sessionConfig.php');

if(!isset($_SESSION['user']))
{
    header("Location: ./");
}

$user = $_SESSION['user'];

?>