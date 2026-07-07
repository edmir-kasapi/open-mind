<?php

function isHomeButtonActive()
{
    switch(($_SESSION['user']['user_info']['role_name'])) {

        case 'USER' :
            if($_SERVER["REQUEST_URI"] != "/OpenMind/mainMenu")
            { 
                return true;
            }
                
            return false;
            break;

        case 'ADMIN' :
            if( !str_contains($_SERVER["REQUEST_URI"], "/OpenMind/adminMenu") )
            {
                 return true;
            }
                
            return false;
            break;
    }   
}

?>

<a class="nav-link <?php if(!isHomeButtonActive()){ echo "disabled"; } ?>" aria-current="page" href="./mainMenu">Home</a>