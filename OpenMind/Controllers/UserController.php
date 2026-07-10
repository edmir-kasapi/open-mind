<?php

//session_start();

require_once('Controller.php');
require_once('Services/AuthService.php');
require_once('Services/UserService.php');
require_once('Services/PostService.php');
require_once('Middleware/AuthMiddleware.php');
require_once('Middleware/PostMiddleware.php');

require_once('Customexceptions/ValidationException.php');
require_once('Customexceptions/FileUploadException.php');

class UserController extends Controller
{
    private $userService;
    private $authMiddleware;
    private $postService;
    private $postMiddleware;

    public function __construct()
    {
        $this -> userService = new UserService();
        $this -> postService = new PostService();
        $this -> authMiddleware = new AuthMiddleware();
        $this -> postMiddleware = new PostMiddleware();
    }

    public function showMainMenu()
    {
        $this -> authMiddleware -> userGuard();

        $user = $_SESSION['user'];
        $posts = $this -> postService -> getAllPostsData();

        $this -> render('mainMenu', ['user' => $user, 'posts' => $posts]);
    }

    public function showProfile()
    {
        $this -> authMiddleware -> userGuard();

        $user = $_SESSION['user'];

        $this -> render('profile', ['user' => $user]);
    }

    public function showPostForm()
    {
        $this -> authMiddleware -> userGuard();

        $user = $_SESSION['user'];

        $this -> render('postForm', ['user' => $user]);
    }

    public function showInspectPost()
    {
        $this -> authMiddleware -> userGuard();

        $user = $_SESSION['user'];
        $id = filter_input(INPUT_GET, "idToEdit", FILTER_VALIDATE_INT);
        $post = $this -> postService -> getPostInfo($id);

        $this -> postMiddleware -> nullPostGuard($post);
        $this -> postMiddleware -> idMismatchGuard($post['post_info'] -> __get('user_id'), $user['user_info'] -> __get('user_id'));

        $this -> render('inspectPost', ['user' => $user, 'post' => $post]);
        
    }

    public function editProfilePic()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $profilePicture = $_FILES["profilePicture"];
            $originalPicture = $_SESSION['user']['user_profile'] -> __get('photo_hash_name') .'.'. $_SESSION['user']['user_profile'] -> __get('photo_extension');
            $id = $_SESSION['user']['user_info'] -> __get('user_id');
            
            $this -> userService -> changeProfilePicture($id, $profilePicture, $originalPicture);

            $_SESSION['user'] = $this -> userService -> getuserInfoId($id);
            $_SESSION['messages']['success'] = "Profile picture edited successfully!";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (FileUploadException $e) {
            
            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (PDOException $e) {

            $this -> userService -> removeorphanedPicture($profilePicture);
            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./profile");

        }
        
    }

    public function clearprofilePic()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $profilePicture = $_SESSION['user']['user_profile'] -> __get('photo_hash_name') .'.'. $_SESSION['user']['user_profile'] -> __get('photo_extension');
            $id = $_SESSION['user']['user_info'] -> __get('user_id');
            
            $this -> userService -> clearProfilePicture($id,  $profilePicture);

            $_SESSION['user'] = $this -> userService -> getuserInfoId($id);
            $_SESSION['messages']['success'] = "Profile picture cleared successfully!";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (PDOException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./profile");

        }
    }

    public function createPost()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);
            
            $id = $_SESSION['user']['user_info'] -> __get('user_id');
            $content = filter_input(INPUT_POST, 'postContent', FILTER_SANITIZE_SPECIAL_CHARS);
            $photos = $_FILES['postPictures'];
            
            $this -> postService -> createPost($id, $content, $photos);

            unset( $_SESSION['autofill']['content_fill']);
            $_SESSION['messages']['success'] = "Post created successfully!";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (FileUploadException | PDOException | ValidationException $e) {

            //$this -> userService -> removeorphanedPicture($filename);
            $_SESSION['messages']['error'] = $e -> getMessage();
            $_SESSION['autofill']['content_fill'] = $content;

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./postForm");

        }
    }

    public function editPostContent()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $user = $_SESSION['user'];
            $id = filter_input(INPUT_POST, 'editId', FILTER_VALIDATE_INT);
            $content = filter_input(INPUT_POST, 'editContent', FILTER_SANITIZE_SPECIAL_CHARS);
            $post = $this -> postService -> getPostInfo($id); //post is retrieved to check

            $this -> postMiddleware -> nullPostGuard($post);
            $this -> postMiddleware -> idMismatchGuard($post['post_info']-> __get('user_id'), $user['user_info'] -> __get('user_id'));

            $this -> postService -> editPostContent($id, $user['user_info'] -> __get('user_id'), $content);

            unset($_SESSION['autofill']['edit_content_fill']);
            $_SESSION['messages']['success'] = "Content edited successfully!";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();
            $_SESSION['autofill']['edit_content_fill'] = $content;

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./inspectPost?idToEdit=$id");

        }
        
    }

    public function addPostPhotos()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $user = $_SESSION['user'];
            $id = filter_input(INPUT_POST, 'editId', FILTER_VALIDATE_INT);
            $photos = $_FILES ["addPictures"];
            $post = $this -> postService -> getPostInfo($id); //post is retrieved to check

            $this -> postMiddleware -> nullPostGuard($post);
            $this -> postMiddleware -> idMismatchGuard($post['post_info'] -> __get('user_id'), $user['user_info'] -> __get('user_id'));

            $this -> postService -> addPostPhotos($id, $photos);
            $_SESSION['messages']['success'] = "Photos added successfully!";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (FileUploadException | PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./inspectPost?idToEdit=$id");

        }
    }

    public function deleteSinglePhoto()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $user = $_SESSION['user'];
            $idPhoto = filter_input(INPUT_POST, 'imageId', FILTER_VALIDATE_INT);
            $idPost = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT); 
            $post = $this -> postService -> getPostInfo($idPost); //post is retrieved to check

            $this -> postMiddleware -> nullPostGuard($post);
            $this -> postMiddleware -> idMismatchGuard($post['post_info'] -> __get('user_id'), $user['user_info'] -> __get('user_id'));

            $this -> postService -> removePostImage($idPhoto, $idPost);
            $_SESSION['messages']['success'] = "Photo removed successfully!";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./inspectPost?idToEdit=$idPost");

        }

    }

    public function deletePost()
    {
        var_dump($_POST);

        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $user = $_SESSION['user'];
            $idPost = filter_input(INPUT_POST, 'deleteId', FILTER_VALIDATE_INT); 
            $post = $this -> postService -> getPostInfo($idPost); //post is retrieved to check

            $this -> postMiddleware -> nullPostGuard($post);
            $this -> postMiddleware -> idMismatchGuard($post['post_info'] -> __get('user_id'), $user['user_info'] -> __get('user_id'));

            $this -> postService -> deletePost($post, $user['user_info'] -> __get('user_id'));
            
            $_SESSION['messages']['success'] = "Post deleted.";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenexception $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./mainMenu");

        }
    }

    
}

?>