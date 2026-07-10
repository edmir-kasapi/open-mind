<?php

require 'Routing/routes.php';

session_start();

//session_destroy();

if(!isset($_SESSION['token']))
{
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $_SESSION['token_lifetime'] = time() + 10800; //token expires in 3 hours; 
}




$router -> dispatch();

?>
