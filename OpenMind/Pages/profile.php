<?php 

require("Config/userConfig.php");

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

    <form action="./processProfileUpdate" method="post" class="form-floating w-25 mx-auto border border-black p-3 rounded-3 mt-4">

        <h4 class="text-center display-6">Edit Name and Email</h4>

        <div class="form-group">
            <label class="form-label">Username:</label>
            <input type="text" name="editName" class="form-control" placeholder="Enter username here..." value=<?php echo $user["user_name"]?>> 
        </div>

        <div class="form-group mt-2">
            <label class="form-label">Email:</label>
            <input type="email" name="editEmail" class="form-control" placeholder="Enter email here..."value=<?php echo $user["user_email"]?>>
        </div>

        <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
        <input type="submit" name="editNameEmailReq" value="Edit" class="mt-4 btn btn-dark">
    </form>

    <form action="./processProfileUpdate" method="post" class="form-floating w-25 mx-auto p-3 border border-warning rounded-3 mt-5">

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
        <input type="hidden" name="editID" value=<?php echo $user["user_id"]?>>
        <input type="submit" name="editPasswordReq" value="Edit" class="btn btn-warning mt-3">
    </form>

    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>
</body>
</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>