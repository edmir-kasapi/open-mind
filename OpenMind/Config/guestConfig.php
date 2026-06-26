<?php 

require('sessionConfig.php');

if(isset($_SESSION['user']))
{
    header("Location: ./mainMenu");
}

?>