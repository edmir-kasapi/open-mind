
<nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

            <img src="Pictures/Assets/brilliance.svg" alt="">
            <i class="bi bi-brilliance">OpenMind</i>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                    <?php
                    
                    if(isset($_SESSION['user']))
                    {
                        include("navbarDropdown.php");
                    }
                    
                    ?>
                </li>
                 <li class="nav-item">
                    <?php
                    
                    if(isset($_SESSION['user']))
                    {
                        include("homeButton.php");
                    }
                    
                    ?> 
                </li>
                <li class="nav-item dropdown">
                    <?php
                    
                    if(isset($_SESSION['user']))
                    {
                        include("postButton.php");
                    }
                    
                    ?>
                </li>
            </ul>
            </div>
        </div>
    </nav>