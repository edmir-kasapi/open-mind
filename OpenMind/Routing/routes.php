<?php

require_once('Controllers/AuthController.php');
require_once('Controllers/UserController.php');
require_once('Controllers/AdminController.php');
require_once('router.php');

$router = new Router();

//auth routes
//GET
$router -> get('/', AuthController::class, 'showLogin' );
$router -> get('/register', AuthController::class, 'showRegister' );
$router -> get('/forgotPassword', AuthController::class, 'showForgotPassword');
//POST
$router -> post('/processLogin', AuthController::class, 'logIn');
$router -> post('/processRegister', AuthController::class, 'registerUser');
$router -> post('/processForgotPassword', AuthController::class, 'processForgotPassword');
$router -> post('/editNameEmail', AuthController::class, 'editNameEmail');
$router -> post('/editPassword', AuthController::class, 'editPassword');
$router -> post('/logout', AuthController::class, 'logOut');

//user routes 
//GET
$router -> get('/mainMenu', UserController::class, 'showMainMenu');
$router -> get('/profile', UserController::class, 'showProfile');
$router -> get('/postForm', UserController::class, 'showPostForm');
$router -> get('/inspectPost', Usercontroller::class, 'showInspectPost');
//POST
$router -> post('/editProfilePic', UserController::class, 'editProfilePic');
$router -> post('/clearPicture', UserController::class, 'clearprofilePic');
$router -> post('/processCreatePost', Usercontroller::class, 'createPost');
$router -> post('/editPostContent', UserController::class, 'editPostContent');
$router -> post('/addPostPhotos', UserController::class, 'addPostPhotos');
$router -> post('/deleteImage', UserController::class, 'deleteSinglePhoto');
$router -> post('/deletePost', UserController::class, 'deletePost');

//admin routes
//GET
$router -> get('/adminMenu', AdminController::class, 'showAdminMenu');
$router -> get('/inspectUser', AdminController::class, 'showInspectUser');
$router -> get('/viewUserPosts', AdminController::class, 'showViewUserPosts');
$router -> get('/inspectUserPost', AdminController::class, 'showInspectuserPost');
$router -> get('/allPosts', AdminController::class, 'showAllPosts');
//POST
$router -> post('/adminEditNameEmail', AdminController::class, 'adminEditNameEmail');
$router -> post('/adminEditProfilePic', AdminController::class, 'adminEditProfilePic');
$router -> post('/adminClearProfilePic', AdminController::class, 'adminClearProfilePic');
$router -> post('/adminChangeUserPassword', AdminController::class,'adminChangeUserPassword');
$router -> post('/adminEditPostContent', AdminController::class, 'adminEditPostContent');
$router -> post('/adminAddPhotos', AdminController::class, 'adminAddPostPhotos');
$router -> post('/adminRemovePhoto', AdminController::class, 'adminDeleteSinglePhoto');
$router -> post('/adminRemovePost', AdminController::class, 'adminDeletePost');
$router -> post('/deleteAllUserPosts', AdminController::class, 'adminDeleteAllUserPosts');
$router -> post('/deleteUser', AdminController::class, 'adminDeleteUser');
$router -> post('/createUser', AdminController::class, 'adminCreateUser');
     

?>