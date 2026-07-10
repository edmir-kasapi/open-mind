<?php

$title = "Admin Dashboard";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("Components/Head/baseHeadCode.php"); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary app-loaded">

    <?php include("Components/Sidebar/sidebar.php"); ?>
    <?php include("Components/Navbar/adminNavbar.php"); ?>


    <main class="app-main p-1" id="main" tabindex="-1">

        <h1 class="w-25 mx-auto text-center display-4 mt-3">Welcome, admin!</h1>

        <div class="row w-100 mt-3 p-4 mx-auto">
            <!--begin::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 1-->
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3><?php echo $stats['total_posts']; ?></h3>

                        <p>Active Posts</p>
                    </div>

                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12.5 5C14.3856 5 15.3284 5 15.9142 5.58579C16.5 6.17157 16.5 7.11438 16.5 9V15C16.5 16.8856 16.5 17.8284 15.9142 18.4142C15.3284 19 14.3856 19 12.5 19H11.5C9.61438 19 8.67157 19 8.08579 18.4142C7.5 17.8284 7.5 16.8856 7.5 15L7.5 9C7.5 7.11438 7.5 6.17157 8.08579 5.58579C8.67157 5 9.61438 5 11.5 5L12.5 5Z" stroke="#1C274C" stroke-width="1.5" />
                        <path opacity="0.5" d="M22 19H21.5C20.1193 19 19 17.8807 19 16.5L19 7.5C19 6.11929 20.1193 5 21.5 5L22 5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                        <path opacity="0.5" d="M2 19H2.5C3.88071 19 5 17.8807 5 16.5L5 7.5C5 6.11929 3.88071 5 2.5 5L2 5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    </svg>


                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        <!-- More info <i class="bi bi-link-45deg"></i> -->
                    </a>


                </div>
                <!--end::Small Box Widget 1-->
            </div>
            <!--end::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3><?php echo $stats['total_pictures']; ?></h3>

                        <p>Stored Pictures</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M8.5 10C9.32843 10 10 9.32843 10 8.5C10 7.67157 9.32843 7 8.5 7C7.67157 7 7 7.67157 7 8.5C7 9.32843 7.67157 10 8.5 10Z" fill="#0F1729" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0055 2H12.9945C14.3805 1.99999 15.4828 1.99999 16.3716 2.0738C17.2819 2.14939 18.0575 2.30755 18.7658 2.67552C19.8617 3.24477 20.7552 4.1383 21.3245 5.23415C21.6925 5.94253 21.8506 6.71811 21.9262 7.62839C22 8.5172 22 9.61946 22 11.0054V12.9945C22 13.6854 22 14.306 21.9909 14.8646C22.0049 14.9677 22.0028 15.0726 21.9846 15.175C21.9741 15.6124 21.9563 16.0097 21.9262 16.3716C21.8506 17.2819 21.6925 18.0575 21.3245 18.7658C20.7552 19.8617 19.8617 20.7552 18.7658 21.3245C18.0575 21.6925 17.2819 21.8506 16.3716 21.9262C15.4828 22 14.3805 22 12.9946 22H11.0055C9.61955 22 8.5172 22 7.62839 21.9262C6.71811 21.8506 5.94253 21.6925 5.23415 21.3245C4.43876 20.9113 3.74996 20.3273 3.21437 19.6191C3.20423 19.6062 3.19444 19.5932 3.185 19.5799C2.99455 19.3238 2.82401 19.0517 2.67552 18.7658C2.30755 18.0575 2.14939 17.2819 2.0738 16.3716C1.99999 15.4828 1.99999 14.3805 2 12.9945V11.0055C1.99999 9.61949 1.99999 8.51721 2.0738 7.62839C2.14939 6.71811 2.30755 5.94253 2.67552 5.23415C3.24477 4.1383 4.1383 3.24477 5.23415 2.67552C5.94253 2.30755 6.71811 2.14939 7.62839 2.0738C8.51721 1.99999 9.61949 1.99999 11.0055 2ZM20 11.05V12.5118L18.613 11.065C17.8228 10.2407 16.504 10.2442 15.7182 11.0727L11.0512 15.9929L9.51537 14.1359C8.69326 13.1419 7.15907 13.1746 6.38008 14.2028L4.19042 17.0928C4.13682 16.8463 4.09606 16.5568 4.06694 16.2061C4.0008 15.4097 4 14.3905 4 12.95V11.05C4 9.60949 4.0008 8.59025 4.06694 7.79391C4.13208 7.00955 4.25538 6.53142 4.45035 6.1561C4.82985 5.42553 5.42553 4.82985 6.1561 4.45035C6.53142 4.25538 7.00955 4.13208 7.79391 4.06694C8.59025 4.0008 9.60949 4 11.05 4H12.95C14.3905 4 15.4097 4.0008 16.2061 4.06694C16.9905 4.13208 17.4686 4.25538 17.8439 4.45035C18.5745 4.82985 19.1702 5.42553 19.5497 6.1561C19.7446 6.53142 19.8679 7.00955 19.9331 7.79391C19.9992 8.59025 20 9.60949 20 11.05ZM6.1561 19.5497C5.84198 19.3865 5.55279 19.1833 5.295 18.9467L7.97419 15.4106L9.51005 17.2676C10.2749 18.1924 11.6764 18.24 12.5023 17.3693L17.1693 12.449L19.9782 15.3792C19.9683 15.6812 19.9539 15.9547 19.9331 16.2061C19.8679 16.9905 19.7446 17.4686 19.5497 17.8439C19.1702 18.5745 18.5745 19.1702 17.8439 19.5497C17.4686 19.7446 16.9905 19.8679 16.2061 19.9331C15.4097 19.9992 14.3905 20 12.95 20H11.05C9.60949 20 8.59025 19.9992 7.79391 19.9331C7.00955 19.8679 6.53142 19.7446 6.1561 19.5497Z" fill="#0F1729" />
                    </svg>

                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover" data-bs-toggle="dropdown" aria-expanded="false">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>

                    <div class="dropdown">
                        <ul class="dropdown-menu w-100">
                            <li class="dropdown-item disabled text-black"> Profile Pictures: <?php echo $stats['total_profile_pictures'] ?> </li>
                            <hr>
                            <li class="dropdown-item disabled text-black"> Post Uploads: <?php echo $stats['total_post_pictures'] ?></li>
                        </ul>
                    </div>

                </div>
                <!--end::Small Box Widget 2-->
            </div>
            <!--end::Col-->
            <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 3-->
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3><?php echo $stats['total_registered']; ?></h3>

                        <p>Registered Users</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M15.5 7.5C15.5 9.433 13.933 11 12 11C10.067 11 8.5 9.433 8.5 7.5C8.5 5.567 10.067 4 12 4C13.933 4 15.5 5.567 15.5 7.5Z" fill="#0F1729"/>
                        <path d="M18 16.5C18 18.433 15.3137 20 12 20C8.68629 20 6 18.433 6 16.5C6 14.567 8.68629 13 12 13C15.3137 13 18 14.567 18 16.5Z" fill="#0F1729"/>
                        <path d="M7.12205 5C7.29951 5 7.47276 5.01741 7.64005 5.05056C7.23249 5.77446 7 6.61008 7 7.5C7 8.36825 7.22131 9.18482 7.61059 9.89636C7.45245 9.92583 7.28912 9.94126 7.12205 9.94126C5.70763 9.94126 4.56102 8.83512 4.56102 7.47063C4.56102 6.10614 5.70763 5 7.12205 5Z" />
                        <path d="M5.44734 18.986C4.87942 18.3071 4.5 17.474 4.5 16.5C4.5 15.5558 4.85657 14.744 5.39578 14.0767C3.4911 14.2245 2 15.2662 2 16.5294C2 17.8044 3.5173 18.8538 5.44734 18.986Z" />
                        <path d="M16.9999 7.5C16.9999 8.36825 16.7786 9.18482 16.3893 9.89636C16.5475 9.92583 16.7108 9.94126 16.8779 9.94126C18.2923 9.94126 19.4389 8.83512 19.4389 7.47063C19.4389 6.10614 18.2923 5 16.8779 5C16.7004 5 16.5272 5.01741 16.3599 5.05056C16.7674 5.77446 16.9999 6.61008 16.9999 7.5Z" />
                        <path d="M18.5526 18.986C20.4826 18.8538 21.9999 17.8044 21.9999 16.5294C21.9999 15.2662 20.5088 14.2245 18.6041 14.0767C19.1433 14.744 19.4999 15.5558 19.4999 16.5C19.4999 17.474 19.1205 18.3071 18.5526 18.986Z" />
                    </svg>

                    <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover" data-bs-toggle="dropdown" aria-expanded="false">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>

                    <div class="dropdown">
                        <ul class="dropdown-menu w-100">
                            <li class="dropdown-item disabled text-black"> Admins: <?php echo $stats['total_admins'] ?> </li>
                            <hr>
                            <li class="dropdown-item disabled text-black"> Users: <?php echo $stats['total_users'] ?></li>
                        </ul>
                    </div>

                </div>
                <!--end::Small Box Widget 3-->
            </div>
            <!--end::Col-->
        </div>

    </main>

    <?php include("Components/Links/bootstrapjs.html"); ?>
</body>

</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>