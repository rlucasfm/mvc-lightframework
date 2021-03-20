<?php
namespace Application\Core;

/**
 * Esta classe implementa o motor de funcionamento do
 * roteamento de URL e seu devido redirecionamento
 * aos controllers
 * 
 * @author Richard Lucas <richardlucasfm@gmail.com>
 * @version 0.1
 */
class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $page404 = false;
    protected $params = [];

    // Método construtor
    public function __construct()
    {
        $router = new \Application\Config\Routes();

        $URL_ARRAY = $this->parseUrl();             
        $ROUTE_STR = array_pop($URL_ARRAY);

        if( $rt = $router->mapRoute($ROUTE_STR) )
        {
            $this->routeController($rt['uri']);                        
        } else {
            $this->routeController($URL_ARRAY); 
        }
        
    }
    /**
    * Encapsula as funções de roteamento de controller genérico
    *
    * @param array
    * @return void
    */
    public function routeController($URL_ARR)
    {                   
        $this->getControllerFromUrl($URL_ARR);
        $this->getMethodFromUrl($URL_ARR);
        $this->getParamsFromUrl($URL_ARR);

        if($this->page404)
        {
            require '../Application/Views/error_pages/error404.php';
        } else {
            // Chama um método de uma classe passando os parâmetros
            call_user_func_array([$this->controller, $this->method], $this->params);
        }  
    }

    /**
     * Este método pega as informações da URL (após o dominio do site) e retorna esses dados
    *
    * @return array
    */
    private function parseUrl()
    {
        if(isset($_GET['url']))
        {
            $REQUEST_URI = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));    
        } else {
            $REQUEST_URI[] = '';
        }
        
        // $REQUEST_URI = explode('/', substr(filter_input(INPUT_SERVER, 'REQUEST_URI'), 1));
        $REQUEST_URI[] = $_GET['url'];
        return $REQUEST_URI;
    }

    /**
     * Este método verifica se o array informado (URL) define um CONTROLADOR a ser direcionado,
    * caso exista, verifica se existe um arquivo com aquele nome no diretório Application/Controllers
    * e instancia um objeto contido no arquivo, caso contrário a variável $page404 recebe true.
    *
    * @param  array  $url   Array contendo informações ou não do controlador, método e parâmetros
    */
    private function getControllerFromUrl($url)
    {
        if ( !empty($url[0]) && isset($url[0]) ) {
            if ( file_exists('../Application/Controllers/' . ucfirst($url[0])  . '.php') ) 
            {
                $this->controller = ucfirst($url[0]);
            } else {
                $this->page404 = true;
            }
        }

        require '../Application/Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller();
    }
    /**
     * Este método verifica se o array informado possui dados que definem o MÉTODO
     * a ser utilizado caso exista, verifica se o método existe naquele determinado controlador
     * e atribui a variável $method da classe.
     * @param  array  $url   Array contendo informações ou não do controlador, método e parâmetros
    */
    private function getMethodFromUrl($url)
    {
        if ( !empty($url[1]) && isset($url[1]) ) {
            if ( method_exists($this->controller, $url[1]) && !$this->page404) 
            {
                $this->method = $url[1];
            } else {
                // caso a classe ou o método informado não exista, o método pageNotFound
                // do Controller é chamado.
                $this->method = 'pageNotFound';
            }
        }
    }
    /**
     * Este método verifica se o array informador possui a quantidade de elementos maior que 2
    * ($url[0] é o controller e $url[1] o método/ação a executar), caso seja, é atribuido
    * a variável $params da classe um novo array  apartir da posição 2 do $url
    *
    * @param  array  $url   Array contendo informações ou não do controlador, método e parâmetros
    */
    private function getParamsFromUrl($url)
    {
        if (count($url) > 2) 
        {
            $this->params = array_slice($url, 2);
        }
    }
}