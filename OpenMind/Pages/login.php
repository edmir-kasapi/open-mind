<?php 

require("Config/guestConfig.php");

$title = "Log In";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("Pages/Components/Head/baseHeadCode.php"); ?>
</head>
<body>
    <?php include("Pages/Components/Navbar/navbar.php"); ?>

    <h1 class="text-center display-4 mt-xxl-5" > Log-In </h1>

    <section class=" form-floating w-25 mx-auto mt-xxl-5 border border-primary  p-3 rounded-4">
        <form action="processLogin" method="POST">
        <!-- Look for csrf token -->
        <!-- E gjeneron dhe e ruan ne session. -->

            <div class="form-group">
                <label class="form-label">Email:</label>
                <input type="email" name="loginEmail" class="form-control" placeholder="Enter email here..." value="<?php if(isset($_SESSION['autofill']['login_email_fill'])) { echo $_SESSION['autofill']['login_email_fill']; } ?>" required> 
            </div>

            
            <div class="form-group mt-3">
                <label class="form-label">Password:</label>
                <input type="password" name="loginPassword" class="form-control" required>
            </div>

            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
            <input type="submit" name="LoginReq" value="Log In" class="btn btn-primary mx-auto mt-4">

        </form>

        <a href="register"><button class="btn btn-secondary mx-auto mt-1"> Register Page </button></a>
    </section> 

    <h5 class=" text-center mt-2"> Forgot Password? Click <a href="forgotPassword">Here </a></h5>
    
    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>
</body>
</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>



