<?php

//session_start();

require_once('Controller.php');
require_once('Services/AuthService.php');
require_once('Services/UserService.php');
require_once('Middleware/AuthMiddleware.php');

require_once('Customexceptions/ValidationException.php');
require_once('Customexceptions/UserNotFoundException.php');
require_once('CustomExceptions/InvalidTokenException.php');

class AuthController extends Controller
{   
    private $authService;
    private $userService;
    private $authMiddleware;
    

    public function __construct()
    {
        $this -> authService = new AuthService();
        $this -> authMiddleware = new AuthMiddleware();
        $this -> userService = new UserService();
    }

    public function showLogin()
    { 
        $this -> authMiddleware -> guestGuard();
        $this -> render('login', [] );
    }

    public function showRegister()
    {
        $this -> authMiddleware -> guestGuard();
        $this -> render('register', [] );
    }

    public function showForgotPassword()
    {
        $this -> authMiddleware -> guestGuard();
        $this -> render('forgotPassword', [] );
    }

    public function logIn() //works
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $email = filter_input(INPUT_POST, 'loginEmail', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'loginPassword', FILTER_SANITIZE_SPECIAL_CHARS);

            $_SESSION['user'] = $this -> authService -> authenticateUser($email, $password);
            var_dump($_SESSION['user']);
            unset($_SESSION['autofill']['login_email_fill']);
            $this -> authMiddleware -> resetTokenTime();
            $this -> authMiddleware -> loginguard(); 
            
        } catch (PDOException | ValidationException | UserNotFoundException $e) {
            
            $_SESSION['messages']['error'] = $e -> getMessage();
            $_SESSION['autofill']['login_email_fill'] = $email;
            header("Location: ./");

        } catch(InvalidTokenException $e) {
            header("Location: ./404");
        }
    }

    public function registerUser() 
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $name = filter_input(INPUT_POST, 'registerName', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'registerEmail', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'registerPassword', FILTER_SANITIZE_SPECIAL_CHARS);
            
            $role = 2; //We are registering a simple user here, not an admin

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

            header("Location: ./register");
        }

    }

    public function processForgotPassword() 
    {

        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $email = filter_input(INPUT_POST, 'changePassEmail', FILTER_SANITIZE_EMAIL);
            $passwordNew = filter_input(INPUT_POST, 'changePassNewPassword', FILTER_SANITIZE_SPECIAL_CHARS);
            $passwordConfirm = filter_input(INPUT_POST, 'changePassConfirmPassword', FILTER_SANITIZE_EMAIL);


            $this -> authService -> resetPassword($email, $passwordNew, $passwordConfirm);
            $_SESSION['messages']['success'] = "Your password was reset successfully!";
            unset($_SESSION['autofill']['forgot_email_fill']);
            $this -> authMiddleware ->resetTokenTime();
                    
        } catch (PDOException | ValidationException $e) {

            $_SESSION['messages']['error'] = $e -> getMessage();
            $_SESSION['autofill']['forgot_email_fill'] = $email;

        }catch (InvalidTokenException $e) {
        
            header("Location: ./404");

        } finally {

            header("Location: ./forgotPassword");

        }

    }

    public function editNameEmail()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $user = $_SESSION['user'];
            $id = $user['user_info'] -> __get('user_id'); //taken from the session, no need to filter

            $name = filter_input(INPUT_POST, 'editName', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'editEmail', FILTER_SANITIZE_EMAIL);

            $this -> authService -> editName($id, $name);
            $this -> authService -> editEmail($id, $email);

            $_SESSION['user'] = $this -> userService -> getuserInfoId($id);

            $_SESSION['messages']['success'] = "Profile edited successfully!";
            $this -> authMiddleware ->resetTokenTime();

        } catch (PDOException | UserNotFoundException | ValidationException $e) {
        
            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {
        
            header("Location: ./404");

        } finally {

            header("Location: ./profile");
            
        }
    }

    public function editPassword()
    {
        try {

            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            $user = $_SESSION['user'];
            $id = $user['user_info'] -> __get('user_id'); //taken from the session, no need to filter

            $passwordNew = filter_input(INPUT_POST, 'editPassword', FILTER_SANITIZE_SPECIAL_CHARS);
            $passwordConfirm = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_SPECIAL_CHARS);

            $this -> authService -> editPassword($id, $passwordNew, $passwordConfirm);

            $_SESSION['user'] = $this -> userService -> getuserInfoId($id);

            $_SESSION['messages']['success'] = "Password changed successfully!";
            $this -> authMiddleware ->resetTokenTime();

        } catch (PDOException | UserNotFoundException | ValidationException $e) {
        
            $_SESSION['messages']['error'] = $e -> getMessage();

        } catch (InvalidTokenException $e) {
        
            header("Location: ./404");

        } finally {

            header("Location: ./profile");
            
        }

    }

    public function logOut()
    {
        try {
            
            $this -> authMiddleware -> tokenGuard($_POST['_token'], $_SESSION['token']);

            session_destroy();
            header('Location: ./');

        } catch (InvalidTokenException) {
            header("Location: ./404");
        }
    }

}

?>