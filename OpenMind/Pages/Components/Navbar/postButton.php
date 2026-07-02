<?php

function isPostButtonActive()
{
    if($_SERVER["REQUEST_URI"] != "/OpenMind/postForm")
    { 
        return true;
    }
    
    return false;
}

?>

<a class="nav-link <?php if(!isPostButtonActive()){ echo "disabled"; } ?>" aria-current="page" href="./postForm"> Post </a>