<?php

$title = "Inspect Post";

$contentFill = "";

if (!isset($_SESSION['autofill']['edit_content_fill'])) {
    $contentFill = $post['post_info'] -> __get('post_content');
} else {
    $contentFill = $_SESSION['autofill']['edit_content_fill'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("Pages/Components/Head/baseHeadCode.php"); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <?php include("Components/Sidebar/sidebar.php"); ?>
    <?php include("Components/Navbar/adminNavbar.php"); ?>

    <h1 class="text-center display-4">You are now inspecting post #<?php echo $post['post_info']-> __get('user_id') ?></h1>
    <h1 class="text-center display-4">of user <?php echo $post['post_user']['user_info']-> __get('user_id') ?></h1>

    <main class="app-main" id="main" tabindex="-1">

        <div class="row w-100 mt-3">

            <div class="col-md-6">

                <div class="w-50 ms-auto">

                    <div class="card card-info card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Edit Content</div>
                        </div>
                        <form action="./adminEditPostContent" method="post" class="needs-validation was-validated" data-gtm-form-interact-id="0">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col">
                                        <div class="form-group mt-2">
                                            <textarea class="form-control w-100" id="post-content" name="editContent" rows="3" required><?php echo $contentFill; ?></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?>>
                            <input type="hidden" name="userId" value=<?php echo $post['post_user']['user_info'] -> __get('user_id') ?>>
                            <input type="hidden" name="editId" value=<?php echo $post['post_info'] -> __get('post_id') ?>>

                            <div class="card-footer">
                                <button class="btn btn-info" type="submit">Submit form</button>
                            </div>

                        </form>
                    </div>

                </div>

                <div class="w-50 ms-auto">

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Add Pictures</div>
                        </div>
                        <form action="./adminAddPhotos" method="post" enctype="multipart/form-data" class="needs-validation was-validated" data-gtm-form-interact-id="0">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col">
                                        <div class="form-group mt-2">
                                            <input type="file" name="addPictures[]" multiple="multiple" class="form-control" required>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?>>
                            <input type="hidden" name="userId" value=<?php echo $post['post_user']['user_info'] -> __get('user_id') ?>>
                            <input type="hidden" name="editId" value=<?php echo $post['post_info'] -> __get('post_id') ?>>

                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">Add Pictures</button>
                            </div>
                        </form>
                    </div>

                </div>



            </div>

            <div class="col">
                <section class="card card-dark card-outline mb-4 w-75">

                    <div class="card-header">
                        <div class="card-title">Pictures</div>
                    </div>

                    <?php if ($post['post_pictures']): ?>
                        <?php
                        $id = "carouselExample";
                        ?>

                        <div id="<?php echo $id; ?>" class="carousel slide mt-2 mb-3 bg-black mx-auto" style="height: 400px; width: 600px;" data-bs-interval="false">
                            <div class="carousel-inner h-100">

                                <?php $i = 1; ?>
                                <?php foreach ($post['post_pictures'] as $picture): ?>

                                    <?php $image = $picture -> __get('photo_hash_name') . '.' . $picture -> __get('photo_extension'); ?>

                                    <div class="carousel-item <?php if ($i === 1) {
                                                                    echo "active";
                                                                } ?> h-100 position-relative">
                                        <div class="container" style="z-index:1;">

                                            <img src="Pictures/Uploads/Post_Pictures/<?php echo $image; ?>" class="d-block position-absolute top-50 start-50 translate-middle" style="width:80%; height:auto; max-height:100%;" alt="..." />
                                            <form action="./adminRemovePhoto" method="post">

                                                <input type="hidden" name="_token" value=<?php echo $_SESSION['token']; ?>>
                                                <input type="hidden" name="userId" value=<?php echo $post['post_user']['user_info'] -> __get('user_id') ?>>
                                                <input type="hidden" name="postId" value=<?php echo $post['post_info'] -> __get('post_id'); ?>>
                                                <input type="hidden" name="imageId" value=<?php echo $picture -> __get('photo_id'); ?>>

                                                <input type="submit" class="btn btn-danger position-absolute top-0 ms-2 mt-sm-1 translate-middle-x" style="z-index:999; width: 37px;" value="X">

                                            </form>

                                        </div>
                                    </div>

                                    <?php $i++; ?>
                                <?php endforeach; ?>

                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $id; ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $id; ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>

                        </div>

                    <?php else: ?>

                        <h4 class="text-center display-6">This post has no pictures</h4>

                    <?php endif; ?>

                    <div class='card-footer'>

                        <div class="d-flex btn-group gap-2" role="group">

                            <a href="./viewUserPosts?viewingUser=<?php echo $post['post_user']['user_info'] -> __get('user_id') ?>">
                                <button class="btn btn-dark"> User's Posts </button>
                            </a>

                            <a href="./allPosts">
                                <button class="btn btn-dark"> All Posts </button>
                            </a>

                            <form action="./adminRemovePost" method="post">

                                <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?>>
                                <input type="hidden" name="userId" value=<?php echo $post['post_user']['user_info'] -> __get('user_id') ?>>
                                <input type="hidden" name="deleteId" value=<?php echo $post['post_info'] -> __get('user_id') ?>>
                                <input type="submit" name="postReq" value="Delete Post" onclick="return confirm('Are you sure you want to delete this post?')" class=" btn btn-danger">
                            </form>

                        </div>

                    </div>

                </section>



            </div>

        </div>

    </main>

    <?php include("Pages/Components/Links/bootstrapjs.html"); ?>
</body>

</html>

<?php include("Pages/Components/Toasts/toastScript.php"); ?>