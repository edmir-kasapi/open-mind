<?php

require_once('Customexceptions/OwnerMismatchException.php');

class PostMiddleware
{
    public function nullPostGuard($post)
    {
        if(!$post)
        {
            var_dump($post);
            header('Location: ./404');
        }
    }

    public function idMismatchGuard($postId, $userID)
    {
        if($postId != $userID)
        {
            header('Location: ./404');
        }
    }
}

?>