<?php

class App
{
    private $controller = 'Home';
    private $method = 'index';

    private function splitURL()
    {
        $url = $_GET['url'] ?? 'home';
        $url = explode("/", trim($url, "/"));
        return $url;
    }

    public function loadController()
    {
        $url = $this->splitURL();

        $filename = '../app/controller/'.ucfirst($url[0]).'Controller.php';
        if(file_exists($filename))
        {
            require $filename;
            $this->controller = ucfirst($url[0])."Controller";
        }
        else
        {
            $filename = '../app/controller/ErrorController.php';
            require $filename;
            $this->controller = "ErrorController";
        }

        $controller = new $this->controller;

        if(!empty($url[1]))
        {
            $this->method = $url[1];
        }

        $method = $this->method;

        if(method_exists($controller, $method))
        {
            $controller->$method();
        }
        else
        {
            $controller->error();
        }
    }
}