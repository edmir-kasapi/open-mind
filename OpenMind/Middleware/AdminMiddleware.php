<?php

class AdminMiddleware
{
    public function nullCurrentPageGuard()
    {
        if(!isset($_GET['currentPage']))
        {
            return 1;
        }

        return $_GET['currentPage'];
    }

    public function nullUserGuard($user)
    {
        if(!$user['user_info'])
        {
            header("Location: ./404");
            return;
        }
    }

    public function paginationGuard($currentPage, $totalEntries)
    {
        $totalPages = ceil($totalEntries / 10.0);

        if($currentPage <= 0)
        {
            header("Location: ./adminMenu?currentPage=1");
            return;
        }

        if(($currentPage > $totalPages) && ($totalPages > 0))
        {
            header("Location: ./adminMenu?currentPage={$totalPages}");
            return;
        }
    }

    public function editRoleGuard($user)
    {
        if($user['user_info']['role_name'] == 'ADMIN' )
        {
            header("Location: ./404");
            return;
        }
    }
}

?>