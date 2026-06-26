<?php

require('Config/userConfig.php');
require('config/csrfCheck.php');

require_once("db/DBHandler.php");
require('db/connection.php');
$dbConnection = buildConnection();



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
    
    if(isset($_POST["editNameEmailReq"]))
    {
        $nameToEdit = htmlspecialchars($_POST["editName"]);
        $emailToEdit = htmlspecialchars($_POST["editEmail"]);
        $originalEmail = $user["user_email"]; //taken from the session, no need to filter
        $idToEdit = $user["user_id"]; //taken from the session, no need to filter

        $dbHandler -> changeUserName($idToEdit, $nameToEdit);
        $dbHandler -> changeUserEmail($idToEdit, $emailToEdit, $originalEmail);
        $_SESSION['user'] = $dbHandler -> getUserInfo($idToEdit);
        $_SESSION['messages']['success'] = "Profile Edited successfully!";
    }

    if(isset($_POST["editPasswordReq"]))
    {
        $passwordToEdit = htmlspecialchars($_POST["editPassword"]);
        $ConfirmToEdit = htmlspecialchars($_POST["confirmPassword"]);
        $idToEdit = $_POST["editID"];

        $dbHandler -> changeUserPassword($idToEdit, $passwordToEdit, $ConfirmToEdit);
        $_SESSION['user'] = $dbHandler -> getUserInfo($idToEdit);
        $_SESSION['messages']['success'] = "Password Edited successfully!";
    }
    
} catch (PDOException | UserNotFoundException | NullInputException $e) {

    $_SESSION['messages']['error'] = $e -> getMessage();

} finally {

    header("Location: ./profile");
    
}

?>