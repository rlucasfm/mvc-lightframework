<?php
namespace Application\Core;

/**
 * Classe que implementa métodos comuns a todos os controladores
 * Para seu uso, basta extender esta classe a cada controlador criado
 * 
 * 
 * @author Richard Lucas <richardlucasfm@gmail.com>
 * @version 0.1
 */
class Controller
{

    /**
    * Este método é responsável por chamar uma determinada view (página).
    *
    * @param  string  $view   A view que será chamada (ou requerida)
    * @param  array   $data   Array de dados acessíveis dentro da view
    */
    public function view(string $view, $data = [])
    {
        require '../Application/Views/' . $view . '.php';
    }

    /**
    * Este método é herdado para todas as classes filhas que o chamaram quando
    * o método ou classe informada pelo usuário não forem encontrados.
    */
    public function pageNotFound()
    {
        $this->view('error_pages/error404');
    }
}