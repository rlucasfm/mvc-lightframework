<?php 

use Application\Core\Controller;

class Home extends Controller
{
    /*
    * chama a view index.php do  /home   ou somente   /
    */
    public function index()
    {
        $this->view('home/index', ['title' => 'Página MVC']);
    }

    public function soma($int, $int2)
    {
        echo "$int + $int2 = ".strval($int+$int2);
    }
}