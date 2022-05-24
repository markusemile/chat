<?php

namespace App\Router;

class Routers{

    protected $url;
    protected $routers;

    public function __construct(string $url)
    {
        $this->url=$url;

    }

    public function get(string $path,string $action){
        $this->routers['GET'][]=new Route($path,$action);

    } public function post(string $path,string $action){
        $this->routers['POST'][]=new Route($path,$action);
    }

    public function  run(){
        foreach($this->routers[$_SERVER['REQUEST_METHOD']] as $route){
                if($route->matches($this->url)){
                    $route->execute();
                }else{
                    //echo "error 404";
                }
        }
//        echo "<pre>";
//var_dump($this->routers);
//        echo "</pre>";
}

}