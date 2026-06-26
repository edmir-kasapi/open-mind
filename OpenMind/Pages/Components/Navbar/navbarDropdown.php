<?php 

function isViewProfileActive()
{
    if($_SERVER["REQUEST_URI"] != "/OpenMind/profile")
    { 
        return true;
    }
    
    return false;
}

?>


<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
     Actions
</a>

<ul class="dropdown-menu">
    <li><a class="dropdown-item <?php if(!isViewProfileActive()){ echo "disabled"; } ?> " href="./profile">View Profile</a></li>
    <li><hr class="dropdown-divider"></li>
    <li>
        <form action="./logout" method="post">
            <input type="hidden" name="tokenVal" value=<?php echo $_SESSION['token']; ?> >
            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
            <input type="submit" value="Log Out" name="logoutReq" class="dropdown-item text-danger">
        </form> 
    </li>
</ul>
