<?php

class App {
    protected $controller = 'HomeController'; // Controlador por defecto
    protected $method = 'index'; // Método por defecto
    protected $params = []; // Parámetros por defecto

    public function __construct() {
        $url = $this->parseUrl();

        // Verificar si la URL contiene un controlador
        if (!empty($url) && file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }

        // Incluir el controlador
        require_once '../app/controllers/' .$this->controller.'.php';

        // se inicializa el controlador
        $this->controller = new $this->controller;

        // Verificar si el método existe en el controlador
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Obtener parámetros restantes de la URL
        $this->params = $url ? array_values($url) : [];

        // Llamar al método del controlador con los parámetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            return $url;
        }
        // Si no se proporciona una URL, devuelve controlador y método por defecto
        return ['home', 'index'];
    }
}
