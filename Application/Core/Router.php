<?php
namespace Application\Core;

/**
 * Esta classe implementa a criação de rotas 
 * customizadas.
 * 
 * @author Richard Lucas <richardlucasfm@gmail.com>
 * @version 1.0
 */

 class Router
 {
    protected $routes = [];

    public function get($route, $controller)
    {
        $this->routes[] = [
            'method' => 'GET',
            'uri' => $route,
            'controller' => $controller
        ];
    }

    public function post($route, $controller)
    {
        $this->routes[] = [
            'method' => 'POST',
            'uri' => $route,
            'controller' => $controller
        ];
    }

    public function put($route, $controller)
    {
        $this->routes[] = [
            'method' => 'PUT',
            'uri' => $route,
            'controller' => $controller
        ];
    }

    public function cancel($route, $controller)
    {
        $this->routes[] = [
            'method' => 'CANCEL',
            'uri' => $route,
            'controller' => $controller
        ];
    }

    public function mapRoute($uri)
    {
        foreach( $this->routes as $route )
        {
            if( $route['uri'] == $uri )
            {
                $response['uri'] = explode('::', $route['controller']);
                return $response;
            }
        }
        return false;
    }
 }