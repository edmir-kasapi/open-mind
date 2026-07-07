
<nav class="navbar navbar-expand-lg bg-body-tertiary layout-fixed">
        <div class="container-fluid">

            <i class="bi bi-brilliance">OpenMind</i>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if(isset($_SESSION['user'])): ?>
                        <li class="nav-item dropdown">
                            <?php
                                include("navbarDropdown.php");
                            ?>
                        </li>
                        <li class="nav-item">
                            <?php
                                include("homeButton.php");
                            
                            ?> 
                        </li>

                        <?php if($_SESSION['user']['user_info']['role_name'] === 'USER' ): ?>
                            <li class="nav-item dropdown">
                                <?php

                                    include("postButton.php");
                                ?>
                            </li>
                        <?php endif;?>

                <?php endif;?>
                </ul>
            </div>
        </div>
    </nav>