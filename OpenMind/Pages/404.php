<?php

$title = "Oops...";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("Pages/Components/Head/baseHeadCode.php"); ?>
</head>
<body>
    
     <body class="bg-body-tertiary">
    <main class="d-flex align-items-center min-vh-100 py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-6 text-center">
            <div class="display-1 fw-bold text-primary lh-1 mb-3">404</div>
            <h1 class="h3 mb-3">Oops! Page not found.</h1>
            <p class="text-secondary mb-4">
              We could not find the page you were looking for. Meanwhile, you may return to the
              previous page.
            </p>
            <form class="row g-2 justify-content-center mb-4" role="search">
              <div class="col-sm-8">
            </form>
          </div>
        </div>
      </div>
    </main>

    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>
</body>
</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>
