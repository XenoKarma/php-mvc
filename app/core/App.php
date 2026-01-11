<?php

class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        
        // didalam folder controller yang namanya sesuai dengan nama yang ada disini
        // kita buat controller
        if(isset($url[0])){
        if(file_exists('../app/controllers/'. $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // untuk method
        if(isset($url[1])){
            // apakah ada methodnya didalam controller
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // params
        if(!empty($url)){
            $this->params = array_values($url);
        }

        // jalankan controller dan method dan kirimkan params jika ada
        // gunakan function call_user_func_array();
        call_user_func_array([$this->controller, $this->method], $this->params);
        
    }

    // membuat method
    public function parseUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}

