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

    public function paginationGuard($currentPage, $totalEntries)
    {
        $totalPages = ceil($totalEntries / 10.0);

        if($currentPage <= 0)
        {
            header("Location: ./adminMenu?currentPage=1");
            return;
        }

        if($currentPage > $totalPages)
        {
            header("Location: ./adminMenu?currentPage={$totalPages}");
            return;
        }
    }
}

?>