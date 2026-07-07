<?php 

$title = "Post";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("Pages/Components/Head/baseHeadCode.php"); ?>
</head>
<body>
    <?php include("Pages/Components/Navbar/navbar.php"); ?>
    
    <h1 class="text-center display-4">What do you have in mind?</h1>  

    <form action="./processCreatePost" method="post" enctype="multipart/form-data" class="form-floating w-25 mx-auto border border-black p-3 rounded-3 mt-4">

        <h4 class="text-center display-6">Create your post</h4>

        <div class="form-group mt-2" enctype="multipart/formdata">
            <label class="form-label">Content</label>
            <textarea class="form-control" id="post-content" name="postContent" rows="3" required><?php if(isset( $_SESSION['autofill']['content_fill'])){ echo  $_SESSION['autofill']['content_fill']; }?></textarea>
        </div>

        <div class="form-group mt-2">
            <label class="form-label">Photos</label>
            <input class="form-control" type="file" multiple="multiple" name="postPictures[]">
        </div>

        

        <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
        <input type="submit" name="postReq" value="Create Post" class="mt-4 btn btn-dark">
    </form>

    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>
</body>
</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>