<?php

$title = "Main Menu";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("Components/Head/baseHeadCode.php"); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <?php include("Components/Sidebar/sidebar.php"); ?>
    <?php include("Components/Navbar/adminNavbar.php"); ?>

    <main class="app-main p-1" id="main" tabindex="-1">

        <h1 class="w-25 mx-auto text-center display-4 mt-3">Viewing posts of user:</h1>
        <h1 class="w-25 mx-auto text-center display-4 mt-1"><?php echo $userInspected['user_info']['user_name'] ?></h1>

        <div class="w-25 mx-auto mt-3 ">
            <div class="btn-group gap-3 d-flex justify-content-center" role="group">
                <a href="./inspectUser?editingUser=<?php echo $userInspected['user_info']['user_id']; ?>">
                    <button class="btn btn-dark"> Back </button>
                </a>

                <form action="./deleteAllUserPosts" method="post">
                    <input type="hidden" name="userId" value=<?php echo $userInspected['user_info']['user_id']; ?>>
                    <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?>>
                    <input type="submit" value="Delete All Posts" class="btn btn-danger <?php if (count($posts) <= 0) {
                                                                                            echo "disabled";
                                                                                        } ?> " onclick="return confirm('Are you sure you want to delete all the posts of this user?')">
                </form>
            </div>
        </div>

        <section class="w-50 mx-auto p-2">
            <?php if (count($posts) > 0): ?>

                <?php $p = 0; ?>
                <?php foreach ($posts as $post): ?>
                    <?php
                    $userInfo = $post['post_user'];
                    $postInfo = $post['post_info'];
                    $postPictures = $post['post_pictures'];
                    ?>



                    <div class="card w-75 mx-auto mt-3">
                        <div class="card-body ">

                            <a class="navbar-brand">
                                <img src="Pictures/Uploads/Profile_Pictures/<?php echo $userInfo['user_profile']['photo_hash_name'] . '.' . $userInfo['user_profile']['photo_extension']; ?>" onerror="this.onerror=null; this.src='Pictures/Assets/default_profile.png'" width="40" height="40" class=" rounded-circle ms-3">
                                <strong><?php echo $userInfo['user_info']['user_name']; ?></strong>
                            </a>

                            <section class="my-3">
                                <p class="card-text"><?php echo $postInfo["post_content"] ?></p>
                            </section>

                            <?php if ($post['post_pictures']): ?>
                                <?php
                                $id = "carouselExample{$p}";
                                $p++;
                                ?>

                                <div id="<?php echo $id; ?>" class="carousel slide mt-2 w-100 bg-black mx-auto " style="height: 400px; width: 600px;" data-bs-interval="false">
                                    <div class="carousel-inner h-100">

                                        <?php $i = 1; ?>
                                        <?php foreach ($postPictures as $picture): ?>

                                            <?php $image = $picture['photo_hash_name'] . '.' . $picture['photo_extension']; ?>

                                            <div class="carousel-item <?php if ($i === 1) {
                                                                            echo "active";
                                                                        } ?> h-100 position-relative">
                                                <div class="container" style="z-index:1;">

                                                    <img src="Pictures/Uploads/Post_Pictures/<?php echo $image; ?>" class="d-block position-absolute top-50 start-50 translate-middle" style="width:80%; height:auto; max-height:100%;" alt="..." />

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

                            <?php endif; ?>


                            <?php if ($userInfo['user_info']['role_name'] == 'USER'): ?>
                                <a href="./inspectUserPost?editingPost= <?php echo $postInfo['post_id'] ?>">
                                    <button class="btn btn-warning mt-3"> Edit Post </button>
                                </a>
                            <?php endif; ?>

                            <p class="card-text mt-3"><small class="text-body-secondary">Posted at <?php echo $postInfo['date_created']; ?></small></p>

                            <!--<a href="#" class="btn btn-primary">Button</a>-->
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>
                <h3 class=" text-center mt-5">This user has not posted anything yet</h3>
            <?php endif; ?>
        </section>


    </main>




    <?php include("Components/Links/bootstrapjs.html"); ?>
</body>

</html>


<?php include("Pages/Components/Toasts/toastScript.php"); ?>