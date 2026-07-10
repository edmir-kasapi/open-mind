<?php

$title = "Profile";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("Pages/Components/Head/baseHeadCode.php"); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <?php include("Components/Sidebar/sidebar.php"); ?>
    <?php include("Components/Navbar/adminNavbar.php"); ?>
    

    <main class="app-main" id="main" tabindex="-1">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="mb-0 fs-3">Inspecting User #<?php echo $userInspected['user_info'] -> __get('user_id'); ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content mt-2">
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Profile sidebar -->
                    <div class="col-md-3">
                        <!-- About card -->
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 96px; height: 96px; font-size: 2rem" aria-hidden="true">
                                    <img src="Pictures/Uploads/Profile_Pictures/<?php echo $userInspected["user_profile"] -> __get('photo_hash_name') . '.' . $userInspected["user_profile"] -> __get('photo_extension')  ?>" onerror="this.onerror=null; this.src='Pictures/Assets/default_profile.png'" alt="..." class=" rounded-circle border border-5" width="155" height="155">
                                </div>
                                <h3 class="h5 mb-0"><?php echo $userInspected['user_info']-> __get('user_name'); ?></h3>
                                <p class="text-secondary mb-3"><?php echo $userInspected['user_info']-> __get('user_email'); ?></p>
                                <ul class="list-group list-group-flush text-start small">
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-secondary">Role</span>
                                        <span class="fw-semibold"><?php echo $userInspected['user_info'] -> __get('role_name'); ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-secondary">Joined</span>
                                        <span class="fw-semibold"><?php echo $userInspected['user_info'] -> __get('user_registration_date'); ?></span>
                                    </li>

                                    <!-- 
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-secondary">Friends</span>
                                        <span class="fw-semibold">13,287</span>
                                    </li>
                                    -->
                                </ul>

                                <a href="./viewUserPosts?viewingUser=<?php echo $userInspected['user_info'] -> __get('user_id'); ?>">
                                    <button class="bi bi-body-text btn btn-primary w-100 mt-3"> View Posts </button>
                                </a>

                                <?php if ($userInspected['user_info']-> __get('role_name') === 'USER'): ?>
                                    <form action="./deleteUser" method="post">
                                        <input type="hidden" name="userId" value=<?php echo $userInspected['user_info'] -> __get('user_id'); ?>>
                                        <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?>>
                                        <input type="submit" class=" btn btn-danger w-100 mt-3" value="Delete User" onclick="return confirm('Are you sure you want to edelete this user? This action cannot be undone.')">
                                    </form>
                                <?php endif; ?>    


                            </div>

                        </div>

                        <a href="./usersDirectory">
                                <button class="btn btn-dark mt-3 w-100 text-center"> Back to Users Directory </button>
                        </a>

                        <!-- About details -->
                        <!--
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">About</h3>
                            </div>
                            <div class="card-body small">
                                <p class="fw-semibold mb-1">
                                    <i class="bi bi-mortarboard me-1 text-secondary" aria-hidden="true"></i>
                                    Education
                                </p>
                                <p class="text-secondary mb-3">
                                    BS in Computer Science from the University of Tennessee at Knoxville
                                </p>
                                <p class="fw-semibold mb-1">
                                    <i class="bi bi-geo-alt me-1 text-secondary" aria-hidden="true"></i>
                                    Location
                                </p>
                                <p class="text-secondary mb-3">Malibu, California</p>
                                <p class="fw-semibold mb-1">
                                    <i class="bi bi-tags me-1 text-secondary" aria-hidden="true"></i>
                                    Skills
                                </p>
                                <p class="mb-3">
                                    <span class="badge text-bg-secondary me-1">UI/UX</span>
                                    <span class="badge text-bg-secondary me-1">Figma</span>
                                    <span class="badge text-bg-secondary me-1">Design Systems</span>
                                    <span class="badge text-bg-secondary">Research</span>
                                </p>
                                <p class="fw-semibold mb-1">
                                    <i class="bi bi-pencil-square me-1 text-secondary" aria-hidden="true"></i>
                                    Notes
                                </p>
                                <p class="text-secondary mb-0">
                                    Lorem ipsum represents a long-held tradition for designers, typographers and
                                    the like.
                                </p>
                            </div>
                        </div>
                        -->
                    </div>

                    <!-- Tabbed content -->
                    <div class="col-md-6 mx-4">
                        <div class="card">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="profile-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab" aria-selected="true">
                                            Primary Credentials
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline" type="button" role="tab" aria-selected="false" tabindex="-1">
                                            Profile Picture
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-selected="false" tabindex="-1">
                                            Reset Password
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- Activity tab -->
                                    <div class="tab-pane fade show active" id="activity" role="tabpanel" aria-labelledby="activity-tab">

                                        <form action="./adminEditNameEmail" method="post" class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-first"> Username </label>
                                                <input type="text" name="editName" class="form-control" placeholder="Enter username here..." required value="<?php echo $userInspected['user_info'] -> __get('user_name'); ?>">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-last">Email </label>
                                                <input type="email" name="editEmail" class="form-control" placeholder="Enter email here..." required value=<?php echo $userInspected['user_info'] -> __get('user_email'); ?> >
                                            </div>

                                            <input type="hidden" name="editId" value=<?php echo $userInspected['user_info'] -> __get('user_id');?>>
                                            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?>>

                                            <?php if ($userInspected['user_info']-> __get('role_name') === 'USER'): ?>
                                                <div class="col-12 mt-3">
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                    <button type="reset" class="btn btn-outline-secondary ms-1">
                                                        Cancel
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </form>

                                    </div>

                                    <!-- Timeline tab -->
                                    <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">

                                        <form action="./adminEditProfilePic" method="post" enctype="multipart/form-data" row g-3>

                                            <div class="col-md-6">
                                                <img src="Pictures/Uploads/Profile_Pictures/<?php echo $userInspected["user_profile"] -> __get('photo_hash_name') . '.' . $userInspected["user_profile"] -> __get('photo_extension')  ?>" onerror="this.onerror=null; this.src='Pictures/Assets/default_profile.png'" alt="..." class="img-thumbnail" width="250" height="250">
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label mt-2">Profile:</label>

                                                    <input class="form-control" type="file" name="profilePicture" required>

                                                    <input type="hidden" name="editId" value=<?php echo $userInspected['user_info'] -> __get('user_id'); ?>>
                                                    <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?>>

                                                    <?php if ($userInspected['user_info'] -> __get('role_name') == 'USER'): ?>
                                                        <input type="submit" name="editProfileReq" value="Edit" class="btn btn-info text-white mt-3">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </form>

                                        <form action="./adminClearProfilePic" method="post">

                                            <input type="hidden" name="editId" value=<?php echo $userInspected['user_info'] -> __get('user_id'); ?>>
                                            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?>>

                                            <?php if ($userInspected['user_info'] -> __get('role_name') == 'USER'): ?>
                                                <input type="submit" name="removeProfileReq" value="Clear Picture" class="btn btn-danger text-white mt-2">
                                            <?php endif; ?>

                                        </form>

                                        <h5 class="text-center mt-2"> A picture with square dimensions is suggested E.g: 150x150 </h5>

                                    </div>

                                    <!-- Settings tab -->
                                    <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">

                                        <form action="./adminChangeUserPassword" method="post" class="row g-3">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Password:</label>
                                                    <input type="password" name="editPassword" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label mt-2">Confirm:</label>
                                                    <input type="password" name="confirmPassword" class="form-control">
                                                </div>
                                            </div>


                                            <input type="hidden" name="editId" value=<?php echo $userInspected['user_info'] -> __get('user_id'); ?>>
                                            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?>>

                                            <?php if ($userInspected['user_info'] -> __get('role_name') == 'USER'): ?>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                    <button type="reset" class="btn btn-outline-secondary ms-1">
                                                        Cancel
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </form>

                                        <!--
                                        <form class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-first"> First name </label>
                                                <input type="text" class="form-control" id="profile-first" value="Jane">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-last"> Last name </label>
                                                <input type="text" class="form-control" id="profile-last" value="Doe">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-email"> Email </label>
                                                <input type="email" class="form-control" id="profile-email" value="jane@example.com">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-role"> Role </label>
                                                <input type="text" class="form-control" id="profile-role" value="Product Designer">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="profile-bio">Bio</label>
                                                <textarea class="form-control" id="profile-bio" rows="4">Designer with a soft spot for design tokens and accessibility.</textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                <button type="reset" class="btn btn-outline-secondary ms-1">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                        -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>



</body>

</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>