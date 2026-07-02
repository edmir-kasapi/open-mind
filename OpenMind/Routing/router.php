<?php 

class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method)
    {
        $this -> routes[$method][$route] = ['controller' => $controller, 'action' => $action ];
    }

    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'GET');
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, 'POST');
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $uri = str_replace('/OpenMind','', $uri);
        $method = $_SERVER['REQUEST_METHOD'];

        var_dump($_SESSION['token']);
        var_dump($_SESSION['token_lifetime']);
       

        if(array_key_exists($uri, $this->routes[$method]))
        {
            $controller = $this -> routes[$method][$uri]['controller'];
            $action = $this -> routes[$method][$uri]['action'];

            $controller = new $controller();
            $controller -> $action();
        } 
        else 
        {
            include __DIR__.'/../Pages/404.php';
        }
        
    }
}


?>