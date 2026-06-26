<?php

require("Config/userConfig.php");

if(!isset($_POST['_token']))
{
    header("Location: ./404");
    exit();
}

if(!hash_equals($_SESSION['token'], $_POST['_token'] ))
{
    header("Location: ./404");
    exit();
}

if(!isset($_SESSION["logoutReq"]))
{
    header("Location: ./mainMenu");
}

if($_POST["tokenVal"] == $_SESSION["token"])
{
    session_destroy();
    header("Location: ./");
} 





?>