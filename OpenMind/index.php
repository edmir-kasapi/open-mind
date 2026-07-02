<?php

session_start();

if(!isset($_SESSION['token']))
{
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $_SESSION['token_lifetime'] = time() + 10800; //token expires in 3 hours; 
}


require 'Routing/routes.php';

$router -> dispatch();

?>
