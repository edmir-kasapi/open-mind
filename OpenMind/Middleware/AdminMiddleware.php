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
            header("Location: ./usersDirectory?currentPage=1");
            return;
        }

        if(($currentPage > $totalPages) && ($totalPages > 0))
        {
            header("Location: ./usersDirectory?currentPage={$totalPages}");
            return;
        }
    }

    public function getSearchoptions()
    {
        $options = [
            'name_email_filter' => ($_GET['nameFilter'] ?? null),
            'category_filter' => ($_GET['categoryFilter'] ?? 'ALL'),
        ];

        return $options;
    }

    public function editRoleGuard($user)
    {
        $_SESSION['messages']['error'] = $user['user_info'] -> __get('role_name');

        if($user['user_info'] -> __get('role_name') == 'ADMIN' )
        {
            
            header("Location: ./404");
            return;
        }
    }
}

?>