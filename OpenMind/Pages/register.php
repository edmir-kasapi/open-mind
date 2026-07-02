<?php 

$title = "Register";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("Pages/Components/Head/baseHeadCode.php"); ?>
</head>
<body>
    <?php include("Pages/Components/Navbar/navbar.php"); ?>

    <h1 class="text-center display-4 mt-xxl-5" > Register </h1>

    <section class="form-floating w-25 mx-auto border border-danger p-2 rounded-2 mt-5">
        <form action="./processRegister" method="POST">
        <!-- Look for csrf token -->
            <div class="form-group">
                <label class="form-label">Username:</label>
                <input type="text" name="registerName" class="form-control" placeholder="Enter username here..." required value=<?php if(isset($_SESSION['autofill']['reg_name_fill'])){ echo $_SESSION['autofill']['reg_name_fill']; } ?> > 
            </div>

            <div class="form-group mt-3">
                <label class="form-label">Email:</label>
                <input type="email" name="registerEmail" class="form-control" placeholder="Enter email here..." required  value=<?php if(isset($_SESSION['autofill']['reg_email_fill'])){ echo $_SESSION['autofill']['reg_email_fill']; } ?> >
            </div>
            
            <div class="form-group mt-3">
                <label class="form-label">Password:</label>
                <input type="password" name="registerPassword" class="form-control" required>
            </div>

            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
            <input type="submit" name="registerReq" value="Register" class="btn btn-danger mx-auto align-self-center mt-4">

        </form>

        <a href="./"><button class="btn btn-secondary mx-auto align-self-center mt-1"> Log In Page </button></a>
    </section>

    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>
</body>
</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>
