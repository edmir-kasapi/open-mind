<?php

require('config/guestConfig.php');

require_once("db/DBHandler.php");
require('db/connection.php');
$dbConnection = buildConnection();

$userName = htmlspecialchars( $_POST["registerName"] ); 
$userEmail = htmlspecialchars( $_POST["registerEmail"] ); 
$userPassword = htmlspecialchars( $_POST["registerPassword"] );

try {

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
    $dbHandler -> registerUser($userName, $userEmail, $userPassword);
    $_SESSION['messages']['success'] = "Registration Successful!";

    unset($_SESSION['autofill']['reg_name_fill']);
    unset($_SESSION['autofill']['reg_email_fill']);

} catch (PDOException | NullInputException $e) {

    $_SESSION['messages']['error'] = $e -> getMessage();
    $_SESSION['autofill']['reg_name_fill'] = $userName;
    $_SESSION['autofill']['reg_email_fill'] = $userEmail;

} finally {

   header("Location: ./register");
    
}

?>