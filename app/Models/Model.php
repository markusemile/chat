<?php
namespace App\Models;


use App\Database\DbConnect;
use PDOException;
use function get_class;
use PDO;
use function substr;

class Model{

    public $db;

    public function __construct($db)
    {
        $this->db=$db;
    }


    protected function query(string $sql,array $params=null,$single=null)
    {
        $method = is_null($params) ? "query" : "prepare";
        $fetch = is_null($single) ? "fetchAll" : "fetch";

        // if insert,update or delete nothing to return

        if(strpos($sql,'INSERT')===0 || strpos($sql,'UPDATE')===0 || strpos($sql,'DELETE')===0){

            try{
                if($method==='query') {
                    $req = $this->db->pdo->$method($sql);
                    return $req->rowCount();
                }else{
                    $req=$this->db->pdo->prepare($sql);
                    $req->execute($params);
                    return ($this->db->pdo)->lastInsertId();

                }
            }catch(PDOException $e){
                return "Error : ".$e->getMessage();
            }
        }else{

            try{

                $req = $this->db->pdo->$method($sql);
                $req->setFetchMode(PDO::FETCH_CLASS,get_class($this),[$this->db]);


                if($method==='prepare') {
                    $req->execute($params);
                }

                if ($req->rowCount() > 0) {
                    return $req->$fetch();
                } else {
                    return 0;
                }


            }catch(PDOException $e){
                return "Error: ".$e->getMessage();
            }
        }
    }


}