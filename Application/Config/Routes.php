<?php
namespace Application\Config;

use \Application\Core\Router as Router;

class Routes extends Router
{    
    public function __construct()
    {        
        $this->get('paginateste', 'Home::index');
    }    
}