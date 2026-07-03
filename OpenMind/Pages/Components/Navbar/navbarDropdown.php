<?php 

function isViewProfileActive()
{
    if($_SERVER["REQUEST_URI"] != "/OpenMind/profile")
    { 
        return true;
    }
    
    return false;
}

$profilePic = $_SESSION['user']['user_profile']['photo_hash_name'] .'.'. $_SESSION['user']['user_profile']['photo_extension'];
$alt = $_SESSION['user']['user_profile']['photo_original_name'] . $_SESSION['user']['user_profile']['photo_extension'];
$userName = $_SESSION['user']['user_info']['user_name'];

?>


<a class="navbar-brand ms-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">

    <?php if($_SESSION['user']['user_info']['role_name'] === 'USER' ): ?>
        <img src="Pictures/Uploads/Profile_Pictures/<?php echo $profilePic; ?>" alt="" onerror="this.onerror=null; this.src='Pictures/Assets/default_profile.png'" width="40" height="40" class=" rounded-circle">
    <?php endif;?>
    
    <strong><?php echo $userName; ?></strong> 
</a>

<ul class="dropdown-menu">

    <?php if($_SESSION['user']['user_info']['role_name'] === 'USER' ): ?>
        <li><a class="dropdown-item <?php if(!isViewProfileActive()){ echo "disabled"; } ?> " href="./profile">View Profile</a></li>
        <li><hr class="dropdown-divider"></li>
    <?php endif;?>
    
    <li>
        <form action="./logout" method="post">
            <input type="hidden" name="tokenVal" value=<?php echo $_SESSION['token']; ?> >
            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
            <input type="submit" value="Log Out" name="logoutReq" class="dropdown-item text-danger">
        </form> 
    </li>
</ul>
