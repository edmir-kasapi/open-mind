<?php

require_once('CustomExceptions/InvalidTokenException.php');

class AuthMiddleware
{
    public function guestGuard()
    {
        $start = 1;

        if(isset($_SESSION['user']))
        {
            switch($_SESSION['user']['user_info']['role_name']){

            case 'USER':
                header("Location: ./mainMenu");
                break;
            
            case 'ADMIN':
                header("Location: ./adminMenu?currentPage={$start}");
                break;
            
            default:
                break;
            }
        }  
    }

    public function userGuard()
    {
        if(!isset($_SESSION['user']))
        {
            header("Location: ./");
            return;
        }

        if( $_SESSION['user'] != 'USER' )
        {
            switch($_SESSION['user']['user_info']['role_name']){

                case 'ADMIN':
                    $start = 1;
                    header("Location: ./adminMenu?currentPage={$start}");
                    break;
                
                default:
                    break;
            }
        }
    }

    public function adminGuard()
    {
        if(!isset($_SESSION['user']))
        {
            header("Location: ./");
            return;
        }

        if( $_SESSION['user'] != 'ADMIN' )
        {
            switch($_SESSION['user']['user_info']['role_name']){
            
            case 'USER':
                header("Location: ./mainMenu");
                break;
            
            default:
                break;
            }
        }
    }

    public function loginGuard()
    {
        switch($_SESSION['user']['user_info']['role_name']){

            case 'USER':
                header("Location: ./mainMenu");
                break;
            
            case 'ADMIN':
                $start = 1;
                header("Location: ./adminMenu?currentPage={$start}");
                break;
            
            default:
                header("Location: ./404");
        }

    }

    public function tokenGuard($submittedToken, $sessionToken) : void
    {
        if(!isset($submittedToken))
        {
            throw new InvalidTokenException('No token was provided');
        }

        if(!hash_equals($sessionToken, $submittedToken))
        {
            throw new InvalidTokenException('Invalid session token.');
        }
        
        if(time() > $_SESSION['token_lifetime'])
        {
            session_destroy();
        }
        
    }

    public function resetTokenTime()
    {
        $_SESSION['token_lifetime'] = time() + 10800;
    }

}

?>