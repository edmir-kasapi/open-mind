<?php 

$title = "Forgot Password";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("Pages/Components/Head/baseHeadCode.php"); ?>
</head>
<body>
    <?php include("Pages/Components/Navbar/navbar.php"); ?>

    <h1 class="text-center display-4 mt-xxl-5" > Change Your Password Here </h1>

    <section class="form-floating w-25 mx-auto border border-warning p-2 rounded-2 mt-5">
        <form action="./processForgotPassword" method="POST">
    <!-- Look for csrf token -->
            <div class="form-group">
                <label class="form-label">Username:</label>
                <input type="email" name="changePassEmail" class="form-control" placeholder="Enter email here..." required value="<?php if(isset($_SESSION['autofill']['forgot_email_fill'])) { echo $_SESSION['autofill']['forgot_email_fill']; } ?>"> 
            </div>

            <div class="form-group mt-3">
                <label class="form-label">New Password:</label>
                <input type="password" name="changePassNewPassword" class="form-control" required >
            </div>
            
            <div class="form-group mt-3">
                <label class="form-label">Confirm Password:</label>
                <input type="password" name="changePassConfirmPassword" class="form-control" required >
            </div>

            <input type="submit" name="forgotPassreq" value="Change Password" class="btn btn-warning mx-auto align-self-center mt-4">

        </form>

        <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
        <a href="./"><button class="btn btn-secondary mx-auto align-self-center mt-1"> Cancel </button></a>
    </section>     

    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>
</body>
</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>