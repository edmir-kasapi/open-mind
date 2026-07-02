<?php 

$title = "Inspect Post";

$contentFill = "";

if(!isset($_SESSION['autofill']['edit_content_fill']))
{
    $contentFill = $post['post_info']['post_content'];
}
else
{
    $contentFill = $_SESSION['autofill']['edit_content_fill'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("Pages/Components/Head/baseHeadCode.php"); ?>
</head>
<body>
    <?php include("Pages/Components/Navbar/navbar.php"); ?>
    
    <h1 class="text-center display-4">You are now inspecting your post</h1>
    
    <div class="row w-100" >

        <div class="col" >

            <div class="d-flex justify-content-end">
                <form action="./editPostContent" method="post" class="form-floating w-50 h-75 border border-black p-3 rounded-3 mt-4">

                    <h4 class="text-center display-6">Edit Content</h4>

                    <div class="form-group mt-2">
                        <textarea class="form-control" id="post-content" name="editContent" rows="3" required><?php echo $contentFill; ?></textarea>
                    </div>

                    <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
                    <input type="hidden" name="editId" value=<?php echo $post['post_info']['post_id'] ?> >
                    <input type="submit" name="postReq" value="Edit" class="mt-4 btn btn-dark">
                </form>
            </div>

            <div class="d-flex justify-content-end">
                <form action="./addPostPhotos" method="post" enctype="multipart/form-data" class="form-floating w-50 h-75 border border-black p-3 rounded-3 ">

                    <h4 class="text-center display-6">Add Photos</h4>

                    <div class="form-group mt-2">
                        <input class="form-control" type="file" multiple="multiple" name="addPictures[]" required>
                    </div>

                    <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
                    <input type="hidden" name="editId" value=<?php echo $post['post_info']['post_id'] ?> >
                    <input type="submit" name="postReq" value="Add" class="mt-4 btn btn-dark">
                </form>
            </div>



        </div>

        <div class="col" >
            <section class="form-floating w-75 border border-black p-3 rounded-3 mt-4">

                <?php if($post['post_pictures']): ?>
                    <?php 
                        $id = "carouselExample"; 
                    ?>

                    <div id="<?php echo $id;?>" class="carousel slide mt-2 bg-black mx-auto" style="height: 400px; width: 600px;" data-bs-interval="false">
                        <div class="carousel-inner h-100">

                            <?php $i = 1;?>
                            <?php foreach($post['post_pictures'] as $picture):?>

                                <?php $image = $picture['photo_hash_name'] .'.'. $picture['photo_extension']; ?>
                                            
                                <div class="carousel-item <?php if($i === 1){echo "active"; } ?> h-100 position-relative">
                                    <div class="container" style="z-index:1;">

                                        <img src="Pictures/Uploads/Post_Pictures/<?php echo $image; ?>" class="d-block position-absolute top-50 start-50 translate-middle" style="width:80%; height:auto; max-height:100%;" alt="..." />                   
                                        <form action="./deleteImage" method="post">

                                            <input type="hidden" name="_token" value=<?php echo $_SESSION['token']; ?> >
                                            <input type="hidden" name="postId" value=<?php echo $post['post_info']['post_id']; ?> >
                                            <input type="hidden" name="imageId" value=<?php echo $picture['photo_id']; ?> >
                                            
                                            <input type="submit"class="btn btn-danger position-absolute top-0 ms-2 mt-sm-1 translate-middle-x" style="z-index:999; width: 37px;" value="X">
                                    
                                        </form>
                                    
                                    </div>
                                </div>
                                                                
                                <?php $i++;?>
                            <?php endforeach; ?> 
                                            
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $id;?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $id;?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>

                    </div>

                <?php else:?>

                    <h4 class="text-center display-6">This post has no pictures</h4>

                <?php endif;?>

            </section>

            <div class="d-flex">
                <form action="./deletePost" method="post" >

                    <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
                    <input type="hidden" name="deleteId" value=<?php echo $post['post_info']['post_id'] ?> >
                    <input type="submit" name="postReq" value="Delete Post" onclick="return confirm('Are you sure you want to delete this post?')" class="mt-4 btn btn-danger">

                </form>
            </div>

        </div>

    </div>

    

    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>
</body>
</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>