<?php

require('config/guestConfig.php');
//require('config/csrfCheck.php');

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
    $email = htmlspecialchars($_POST["changePassEmail"]);
    $password = htmlspecialchars($_POST["changePassNewPassword"]);
    $confirm = htmlspecialchars($_POST["changePassConfirmPassword"]);

    $user = $dbHandler -> getUserInfoByEmail($email);
    $dbHandler -> changeUserPassword($user["user_id"], $password, $confirm);
    
    $_SESSION['messages']['success'] = "Your password was reset successfully!";
    unset($_SESSION['autofill']['forgot_email_fill']);

} catch (PDOException | NullInputException | UserNotFoundException $e) {
    $_SESSION['messages']['error'] = $e -> getMessage();
    $_SESSION['autofill']['forgot_email_fill'] = $email;
} finally {
    header("Location: ./forgotPassword");
}

?>