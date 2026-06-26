<?php 

require("Config/userConfig.php");

$title = "Main Menu";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("Components/Head/baseHeadCode.php"); ?>
</head>
<body>
    <?php include("Components/Navbar/navbar.php"); ?>
    
    <h1 class="text-center display-4 mt-3">Welcome to the main menu!</h1>

    <?php include("Components/Links/bootstrapjs.html"); ?>
</body>
</html>

