<?php 

$title = "Profile";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("Pages/Components/Head/baseHeadCode.php"); ?>
</head>
<body>
    <?php include("Pages/Components/Navbar/navbar.php"); ?>
    
    <h1 class="text-center display-4">Welcome to your profile!</h1>  

        <div class ="row w-100">

            <div class="col d-flex justify-content-end">
                <form action="#" method="post" class="form-floating w-50 border border-black p-3 rounded-3 mt-4">

                    <h4 class="text-center display-6">Edit Name and Email</h4>

                    <div class="form-group">
                        <label class="form-label">Username:</label>
                        <input type="text" name="editName" class="form-control" placeholder="Enter username here..." value="<?php echo $userInspected['user_info']["user_name"]?>"> 
                    </div>

                    <div class="form-group mt-2">
                        <label class="form-label">Email:</label>
                        <input type="email" name="editEmail" class="form-control" placeholder="Enter email here..." value=<?php echo $userInspected['user_info']["user_email"]?>>
                    </div>

                    <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
                    <input type="submit" name="editNameEmailReq" value="Edit" class="mt-4 btn btn-dark">
                </form>
            </div>

            <div class="col">
                <section class="form-floating w-50 p-3 border border-info rounded-3 mt-4" >

                    <form action="#" method="post" enctype="multipart/form-data" >

                    <h4 class="text-center display-6">Change Profile Picture</h4>

                    <div class="row">
                        <div class="col">
                            <img src="Pictures/Uploads/Profile_Pictures/<?php echo $userInspected["user_profile"]["photo_hash_name"] . '.' . $userInspected["user_profile"]["photo_extension"]  ?>" onerror="this.onerror=null; this.src='Pictures/Assets/default_profile.png'" alt="..." class="img-thumbnail" width="155" height="155">
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="form-label mt-2">Profile:</label>

                                <input class="form-control" type="file" name="profilePicture" required>

                                <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >

                                <input type="submit" name="editProfileReq" value="Edit" class="btn btn-info text-white mt-3">
                            </div>    
                        </div>
                    </div>
                    
                </form>

                <form action="#" method="post">
                    
                    <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >

                    <input type="submit" name="removeProfileReq" value="Clear Picture" class="btn btn-danger text-white mt-2">
                </form>

                <h5 class="text-center mt-2"> A picture with square dimensions is suggested E.g: 150x150 </h5>
                </section>
            </div>
    </div>

    

    <form action="" method="post" class="form-floating w-25 mx-auto p-3 border border-warning rounded-3 mt-5">

        <h4 class="text-center display-6">Change Password</h4>

        <div class="form-group">
            <label class="form-label">Password:</label>
            <input type="password" name="editPassword" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label mt-2">Confirm:</label>
            <input type="password" name="confirmPassword" class="form-control">
        </div>

        <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
        <input type="submit" name="editPasswordReq" value="Edit" class="btn btn-warning mt-3">
    </form>

    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>
</body>
</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>