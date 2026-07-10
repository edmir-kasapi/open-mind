<?php

require_once('Controller.php');
require_once('Services/AuthService.php');
require_once('Services/UserService.php');
require_once('Services/PostService.php');
require_once('Services/AdminService.php');
require_once('Middleware/AuthMiddleware.php');
require_once('Middleware/PostMiddleware.php');
require_once('Middleware/AdminMiddleware.php');

require_once('Customexceptions/ValidationException.php');
require_once('Customexceptions/FileUploadException.php');

class AdminController extends Controller
{
    private $authService;
    private $adminService;
    private $userService;
    private $postService;
    private $authMiddleware;
    private $adminMiddleware;
    private $postMiddleware;

    public function __construct()
    {
        $this -> authService = new AuthService();
        $this -> adminService = new Adminservice();
        $this -> userService = new UserService();
        $this -> postService = new PostService();
        $this -> authMiddleware = new AuthMiddleware();
        $this -> adminMiddleware = new AdminMiddleware();
        $this -> postMiddleware = new Postmiddleware();
        
    }

    public function showAdminMenu()
    {
        $this -> authMiddleware -> adminGuard();

        $admin = $_SESSION['user'];

        //$currentPage = $this -> adminMiddleware -> nullCurrentPageGuard();
        //$totalResult = $this -> adminService -> getUserCount($admin['user_info'] -> __get('user_id'));
        //$totalValue = $totalResult[0]['value'];
        //$this -> adminMiddleware -> paginationGuard($currentPage, $totalValue);

        $stats = $this -> adminService -> getStats($admin['user_info'] -> __get('user_id'));

        $this -> render('adminMenu', ['user' => $admin, 'stats' => $stats]);
    }

    public function showUsersDirectory()
    {
        $this -> authMiddleware -> adminGuard();

        $admin = $_SESSION['user'];

        $currentPage = $this -> adminMiddleware -> nullCurrentPageGuard();
        $options = $this -> adminMiddleware -> getSearchOptions();

        $users = $this -> adminService -> getUserData($admin['user_info'] -> __get('user_id'), $currentPage, $options);
        $userCount = count($users);

        $totalResult = $this -> adminService -> getUserCount($admin['user_info'] -> __get('user_id'), $options);  
        $totalValue = $totalResult[0]['value'];

        $this -> adminMiddleware -> paginationGuard($currentPage, $totalValue);

        

        $this -> render('adminUsersDirectory', ['user' => $admin, 'usersList' => $users, 'userCount' => $userCount, 'currentPage' => $currentPage, 'total' => $totalValue, 'options' => $options]);
   
    }

    public function showInspectUser()
    {
        $this -> authMiddleware -> adminGuard();

        $admin = $_SESSION['user'];
        $inspectedId = $_GET['editingUser'];
        $userInspected = $this -> userService -> getUserInfoId($inspectedId);
        $this -> adminMiddleware -> nullUserGuard($userInspected);

        $this -> render('adminInspectUser', ['user' => $admin, 'userInspected' => $userInspected ]);

    }

    public function showViewUserPosts()
    {
        $this -> authMiddleware -> adminGuard();

        $admin = $_SESSION['user'];
        $inspectedId = $_GET['viewingUser'];
        $userInspected = $this -> userService -> getUserInfoId($inspectedId);
        $this -> adminMiddleware -> nullUserGuard($userInspected);

        $posts = $this -> postService -> getUserPostsData($inspectedId);

        $this -> render('adminViewposts', ['user' => $admin, 'userInspected' => $userInspected, 'posts' => $posts]);
    }

    public function showInspectUserPost()
    {
        $admin = $_SESSION['user'];

        $id = filter_input(INPUT_GET, "editingPost", FILTER_VALIDATE_INT);
        $post = $this -> postService -> getPostInfo($id);

        $this -> postMiddleware -> nullPostGuard($post);

        $this -> render('adminInspectPost', ['user' => $admin, 'post' => $post ]);
    }

    public function showAllPosts()
    {
        $this -> authMiddleware -> adminGuard();

        $admin = $_SESSION['user'];
        $posts = $this -> postService -> getAllPostsData();

        $this -> render('adminAllPosts', ['user' => $admin, 'posts' => $posts ]);
    }

    public function adminEditNameEmail()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $name = filter_input(INPUT_POST, 'editName', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'editEmail', FILTER_SANITIZE_EMAIL);
            $id = filter_input(INPUT_POST, 'editId', FILTER_VALIDATE_INT);

            $userInfo = $this -> userService -> getuserInfoId($id);
            $this -> adminMiddleware -> editRoleGuard($userInfo);

            $this -> authService -> editName($id, $name);
            $this -> authService -> editEmail($id, $email);

            $_SESSION['messages']['success'] = "User edited successfully!";
            $this -> authMiddleware ->resetTokenTime();

        } catch (PDOException | UserNotFoundException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./inspectUser?editingUser={$id}");
        }

    }

    public function adminEditProfilePic()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $id = filter_input(INPUT_POST, 'editId', FILTER_VALIDATE_INT);
            $userInfo = $this -> userService -> getuserInfoId($id);
            $this -> adminMiddleware -> editRoleGuard($userInfo);

            $profilePicture = $_FILES["profilePicture"];
            $originalPicture = $userInfo['user_profile'] -> __get('photo_hash_name') .'.'. $userInfo['user_profile'] -> __get('photo_extension');

            $this -> userService -> changeProfilePicture($id, $profilePicture, $originalPicture);

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

            header("Location: ./inspectUser?editingUser={$id}");
        }

    }

    public function adminClearProfilePic()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $id = filter_input(INPUT_POST, 'editId', FILTER_VALIDATE_INT);
            $userInfo = $this -> userService -> getuserInfoId($id);
            $this -> adminMiddleware -> editRoleGuard($userInfo);

            $profilePicture = $userInfo['user_profile'] -> __get('photo_hash_name') .'.'. $userInfo['user_profile'] -> __get('photo_extension');

            $this -> userService -> clearProfilePicture($id,  $profilePicture);

            $_SESSION['messages']['success'] = "Profile picture cleared successfully!";
            $this -> authMiddleware ->resetTokenTime();

        } catch (PDOException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./inspectUser?editingUser={$id}");

        }
    }

    public function adminChangeUserPassword()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $id = filter_input(INPUT_POST, 'editId', FILTER_VALIDATE_INT);
            $userInfo = $this -> userService -> getuserInfoId($id);
            $this -> adminMiddleware -> editRoleGuard($userInfo);

            $passwordNew = filter_input(INPUT_POST, 'editPassword', FILTER_SANITIZE_SPECIAL_CHARS);
            $passwordConfirm = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_SPECIAL_CHARS);

            $this -> authService -> editPassword($id, $passwordNew, $passwordConfirm);

            $_SESSION['messages']['success'] = "Password changed successfully!";
            $this -> authMiddleware ->resetTokenTime();

        } catch (PDOException | UserNotFoundException | ValidationException $e) {
        
            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {
        
            header("Location: ./404");

        } finally {

            header("Location: ./inspectUser?editingUser={$id}");
            
        }
    }

    public function adminEditPostContent()
    {
        //var_dump($_POST);
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $idUser = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
            $idPost = filter_input(INPUT_POST, 'editId', FILTER_VALIDATE_INT);
            $content = filter_input(INPUT_POST, 'editContent', FILTER_SANITIZE_SPECIAL_CHARS);
            $post = $this -> postService -> getPostInfo($idPost); //post is retrieved to check

            $this -> postMiddleware -> nullPostGuard($post);
            $this -> postMiddleware -> idMismatchGuard($post['post_info']-> __get('user_id'), $idUser);

            $this -> postService -> editPostContent($idPost, $idUser, $content);

            unset($_SESSION['autofill']['edit_content_fill']);
            $_SESSION['messages']['success'] = "Content edited successfully!";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();
            $_SESSION['autofill']['edit_content_fill'] = $content;

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./inspectUserPost?editingPost={$idPost}");

        }
    }

    public function adminAddPostPhotos()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $idUser = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
            $idPost = filter_input(INPUT_POST, 'editId', FILTER_VALIDATE_INT);
            $photos = $_FILES ["addPictures"];
            $post = $this -> postService -> getPostInfo($idPost); //post is retrieved to check

            $this -> postMiddleware -> nullPostGuard($post);
            $this -> postMiddleware -> idMismatchGuard($post['post_info'] -> __get('user_id'), $idUser);

            $this -> postService -> addPostPhotos($idPost, $photos);
            $_SESSION['messages']['success'] = "Photos added successfully!";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (FileUploadException | PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./inspectUserPost?editingPost={$idPost}");

        }

    }

    public function adminDeleteSinglePhoto()
    {
        
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $idUser = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
            $idPhoto = filter_input(INPUT_POST, 'imageId', FILTER_VALIDATE_INT);
            $idPost = filter_input(INPUT_POST, 'postId', FILTER_VALIDATE_INT); 
            $post = $this -> postService -> getPostInfo($idPost); //post is retrieved to check

            $this -> postMiddleware -> nullPostGuard($post);
            $this -> postMiddleware -> idMismatchGuard($post['post_info'] -> __get('user_id'), $idUser);

            $this -> postService -> removePostImage($idPhoto, $idPost);
            $_SESSION['messages']['success'] = "Photo removed successfully!";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./inspectUserPost?editingPost={$idPost}");

        }
    }

    public function adminDeletePost()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $idUser = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
            $idPost = filter_input(INPUT_POST, 'deleteId', FILTER_VALIDATE_INT); 
            $post = $this -> postService -> getPostInfo($idPost); //post is retrieved to check

            $this -> postMiddleware -> nullPostGuard($post);
            $this -> postMiddleware -> idMismatchGuard($post['post_info'] -> __get('user_id'), $idUser);

            $this -> postService -> deletePost($post, $idUser);
            
            $_SESSION['messages']['success'] = "Post deleted.";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenexception $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./viewUserPosts?viewingUser={$idUser}");

        }
        
    }

    public function adminDeleteAllUserPosts()
    {
        
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $idUser = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
            $this -> adminMiddleware -> nullUserGuard( $this -> userService -> getUserInfoId($idUser) );

            $this -> postService -> deleteAllUserPosts($idUser);
            
            $_SESSION['messages']['success'] = "All posts deleted.";
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenexception $e) {

            header("Location: ./404");

        } finally {

            header("Location: ./viewUserPosts?viewingUser={$idUser}");

        }
        
    }

    public function adminDeleteUser()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $idUser = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
            $user = $this -> userService -> getUserInfoId($idUser);
            $this -> adminMiddleware -> nullUserGuard($user);
            $this -> adminMiddleware -> editRoleGuard($user);

            //$this -> postService -> deleteAllUserPosts($idUser);
            //$this -> userService -> deleteUser($user);
         
            $_SESSION['messages']['success'] = 'User deleted successfully';
            $this -> authMiddleware ->resetTokenTime();
            header("Location: ./usersDirectory");
            
        } catch (PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();
            header("Location: ./inspectUser?editingUser={$idUser}");

        } catch (InvalidTokenexception $e) {

            header("Location: ./404");

        }
        
    }

    public function adminCreateUser()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $name = filter_input(INPUT_POST, 'registerName', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'registerEmail', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'registerPassword', FILTER_SANITIZE_SPECIAL_CHARS);
            $role = filter_input(INPUT_POST, 'registerRole', FILTER_SANITIZE_SPECIAL_CHARS);

            $this -> authService -> registerUser($name, $email, $password, $role);
            $_SESSION['messages']['success'] = "Registration Successful!";

            unset($_SESSION['autofill']['reg_name_fill']);
            unset($_SESSION['autofill']['reg_email_fill']);
            $this -> authMiddleware ->resetTokenTime();
            
        } catch (PDOException | ValidationException | UserNotFoundException $e) {
             
            $_SESSION['messages']['error'] = $e -> getMessage();
            $_SESSION['autofill']['reg_name_fill'] = $name;
            $_SESSION['autofill']['reg_email_fill'] = $email;

        } catch (InvalidTokenException $e) {
        
            header("Location: ./404");

        } finally {

            header("Location: ./usersDirectory");
        }
    }
  
}

?>