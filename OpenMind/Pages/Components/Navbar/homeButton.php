<?php

function isHomeButtonActive()
{
    if($_SERVER["REQUEST_URI"] != "/OpenMind/mainMenu")
    { 
        return true;
    }
    
    return false;
}

?>

<a class="nav-link <?php if(!isHomeButtonActive()){ echo "disabled"; } ?>" aria-current="page" href="./mainMenu">Home</a>