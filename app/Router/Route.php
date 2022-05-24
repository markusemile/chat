<?php
namespace App\Router;

use App\Database\DbConnect;

class Route{

    protected $path; // les routes
    protected $action;
    protected $matches;

    public function __construct(string $path,string $action)
    {
        $this->path=trim($path,' ');
        $this->action=$action;
    }

    public function matches(string $url){ //adresse courante
        //echo $url."|------>".$this->path."<br>";
        $explodeUrl = explode("?",$url);
        if($explodeUrl[0]==$this->path){
            if(isset($explodeUrl[1])){
            $params = explode("&",$explodeUrl[1]);
            foreach($params as $param){
                $parts=explode('=',$param);
                $this->matches[$parts[0]]=$parts[1];
            }
            }else{
                $this->matches=0;
            }
            return true;
        }else{
            return false;
        }
    }

    public function execute(){
        $explodeAction = explode('@',$this->action);
        $method=$explodeAction[1];
        $controller = new $explodeAction[0](new DbConnect());
        $controller->$method($this->matches);

    }


}