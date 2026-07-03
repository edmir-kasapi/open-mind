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
    private $adminService;
    private $userService;
    private $authMiddleware;
    private $adminMiddleware;

    public function __construct()
    {
        $this -> adminService = new Adminservice();
        $this -> userService = new UserService();
        $this -> authMiddleware = new AuthMiddleware();
        $this -> adminMiddleware = new AdminMiddleware();
        
    }

    public function showAdminMenu()
    {
        $this -> authMiddleware -> adminGuard();

        $admin = $_SESSION['user'];

        $currentPage = $this -> adminMiddleware -> nullCurrentPageGuard();
        $totalResult = $this -> adminService -> getUserCount($admin['user_info']['user_id']);
        $totalValue = $totalResult[0]['value'];
        $this -> adminMiddleware -> paginationGuard($currentPage, $totalValue);

        $users = $this -> adminService -> getUserData($admin['user_info']['user_id'], $currentPage);
        $userCount = count($users);

        $this -> render('adminMenu', ['user' => $admin, 'usersList' => $users, 'userCount' => $userCount, 'currentPage' => $currentPage, 'total' => $totalValue]);
    }

    public function showInspectUser()
    {
        $this -> authMiddleware -> adminGuard();

        $admin = $_SESSION['user'];
        $inspectedId = $_GET['editingUser'];
        $userInspected = $this -> userService -> getUserInfoId($inspectedId);
        
        $this -> render('adminInspectUser', ['user' => $admin, 'userInspected' => $userInspected ]);

    }

}

?>