<?php

require_once('CustomExceptions/InvalidTokenException.php');

class AuthMiddleware
{
    public function guestGuard()
    {
        if(isset($_SESSION['user']))
        {
            header("Location: ./mainMenu");
        }  
    }

    public function userGuard()
    {
        if(!isset($_SESSION['user']))
        {
            header("Location: ./");
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