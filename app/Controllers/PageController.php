<?php
namespace App\Controllers;




class PageController{

    private function view($path,$datas){
        ob_start();
        $realPath="..".DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.$path.".php";
        extract($datas);
        require($realPath);
        $content = ob_get_contents();
        ob_end_clean();
        require ("../views/layout.php");
    }

    public function index($params){
        $title="Homepage";
        return $this->view('homepage',compact('title'));
    }

    public function chatbox($params){
        $title="chatbox";
        return $this->view('chatbox',compact('params','title'));
    }


}
