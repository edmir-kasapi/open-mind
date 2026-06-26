<?php

require("Config/guestConfig.php");
//require("Config/csrfCheck.php");


require_once("db/DBHandler.php");
require('db/connection.php');
$dbConnection = buildConnection();

$userEmail = htmlspecialchars($_POST["loginEmail"]);
$userPassword = htmlspecialchars($_POST["loginPassword"]);

try{
    
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
    

    $dbHandler = new DBHandler($dbConnection);
    $_SESSION['user'] =  $dbHandler -> verifyUser($userEmail, $userPassword);

    unset($_SESSION['autofill']['login_email_fill']);

    header("Location: ./mainMenu");

} catch (PDOException | NullInputException | UserNotFoundException $e) {

    $_SESSION['messages']['error'] = $e -> getMessage();
    $_SESSION['autofill']['login_email_fill'] = $userEmail;
    header("Location: ./");

}


?>