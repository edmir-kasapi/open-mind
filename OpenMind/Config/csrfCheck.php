<?

if(!isset($_POST['_token']))
{
    header("Location: ./404");
    exit();
}

if(!hash_equals($_SESSION['token'], $_POST['_token'] ))
{
    header("Location: ./404");
    exit();
}

?>