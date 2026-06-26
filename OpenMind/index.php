<?php

$uri = $_SERVER["REQUEST_URI"];
$request = str_replace("/OpenMind","",$uri);
$viewDir = "/Pages/";
$processDir = "/Processing/";
$notFoundPage = __DIR__.$viewDir."404.php";
$accessDeniedPage = __DIR__.$viewDir."accessDenied.php";

$routes = [ "" => [ "method" => "GET", "path" =>  __DIR__.$viewDir."login.php" ],
            "/" => [ "method" => "GET", "path" =>  __DIR__.$viewDir."login.php" ],
            "/register" => [ "method" => "GET", "path" =>  __DIR__.$viewDir."login.php" ],
            "/forgotPassword" => [ "method" => "GET", "path" =>  __DIR__.$viewDir."forgotPassword.php" ],
            "/mainMenu" => [ "method" => "GET", "path" =>  __DIR__.$viewDir."mainMenu.php" ], 
            "/profile" => [ "method" => "GET", "path" =>  __DIR__.$viewDir."profile.php" ],
            "/processLogin" => [ "method" => "POST", "path" => __DIR__.$processDir."processLogin.php" ],
            "/processRegister" => [ "method" => "POST", "path" => __DIR__.$processDir."processRegister.php" ],
            "/processForgotPassword" => [ "method" => "POST", "path" => __DIR__.$processDir."processForgotPassword.php" ],
            "/processProfileUpdate" => [ "method" => "POST", "path" => __DIR__.$processDir."processProfileChange.php" ],
            "/logout" => [ "method" => "POST", "path" => __DIR__.$processDir."logout.php" ],
            "/accessDenied" => [ "method" => "POST", "path" => $accessDeniedPage ],
            "/404" => [ "method" => "POST", "path" => $notFoundPage ]
            ];

function matchRoute($request, $routes)
{
    if(!isset($routes[$request]))
    {
        http_response_code(404);
        require $routes["/404"]["path"]; //redirects to the not found page
        return;
    }

    $route = $routes[$request];

    if($_SERVER["REQUEST_METHOD"] != $route["method"])
    {
        http_response_code(404);
        require $routes["/404"]["path"];
        return;
    }

    require $route["path"];
}

matchRoute($request, $routes);

/*

function redirectToAcessDenied($accessDeniedPage) : void
{
    http_response_code(403);
    require $accessDeniedPage;
}

function redirectToNotFound($notFoundPage)
{
    http_response_code(404);
    require $notFoundPage;
}
        

function isMethodGet() : bool
{
    return $_SERVER["REQUEST_METHOD"] === "GET";
}

function isMethodPost() : bool
{
    return $_SERVER["REQUEST_METHOD"] === "POST";
}

switch ($request) {
    case "":
    case "/":
        if(!isMethodGet())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$viewDir."login.php";
        break;

    case "/register":
        if(!isMethodGet())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$viewDir."register.php";
        break;

    case '/forgotPassword':
        if(!isMethodGet())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$viewDir."forgotPassword.php";
        break;

    case '/mainMenu':
        if(!isMethodGet())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$viewDir."mainMenu.php";
        break;

    case '/profile':
        if(!isMethodGet())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$viewDir."profile.php";
        break;

    case '/processLogin':
        if(!isMethodPost())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$processDir."processLogin.php";
        break;

    case '/processRegister':
        if(!isMethodPost())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$processDir."processRegister.php";
        break;

    case '/processForgotPassword':
        if(!isMethodPost())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$processDir."processForgotPassword.php";
        break;

    case '/processProfileUpdate':
        if(!isMethodPost())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$processDir."processProfileChange.php";
        break;

    case '/logout':
        if(!isMethodPost())
        {
            redirectToNotFound($notFoundPage);
            break;
        }
        require __DIR__.$processDir."logout.php";
        break;

    case '/accessDenied':
        redirectToAcessDenied($accessDeniedPage);
        break;


    case '/404':
    default:
        redirectToNotFound($notFoundPage);
        break;
}

*/

?>
