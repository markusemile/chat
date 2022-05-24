<?php
namespace App\Database;

use PDO;


class DbConnect{

    private $host="ns379959.ip-5-196-70.eu";
    private $dbname="c3apitest";
    private $user="c3markuemile";
    private $password="FEg6M5x!pGc";
    public $pdo;

    public function  __construct()
    {
        if($this->pdo===null){
            $this->pdo=$this->getInstancePDO();
        }
        return $this->pdo;
    }

    public function getInstancePDO(){
       $connect = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
       $connect->query("SET NAMES utf8");
       $connect->query("SET CHARACTER SET 'utf8'");
       return $connect;
    }


}