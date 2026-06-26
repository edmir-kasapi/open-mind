<?php 

if(isset($_SESSION['messages']['success'])){
   include("successToast.php");
}

if(isset($_SESSION['messages']['error'])){
   include("errorToast.php");
}

?>