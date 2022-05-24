<?php
namespace App\Models;



use function array_intersect;
use function array_intersect_assoc;
use function array_merge;

class User extends Model{

    private $table = "users";

    /**
     * Fonction qui retourn les message de la room demandé
     * @param $from
     * @param $room
     * @return string
     */
    public function getAllConnected(){
        return $this->query("SELECT * FROM $this->table WHERE connected=1");
    }

    public function getNbMessagePerUser($id){
        return $this->query("SELECT  users.id,count(*) as nb_messages
                                 FROM users
                                 INNER JOIN messages ON  id_user=users.id AND room=$id
                                 WHERE connected=1 AND viewed=0 
                                 GROUP BY users.id ");
}

    public function checkIfIsUser($user){
        return $this->query("SELECT * from users WHERE username='".$user."' LIMIT 1",null,true);
    }
    public function checkSession($user,$token){
        return $this->query("SELECT * from users WHERE username='".$user."' AND token='".$token."' AND connected=1",null,true);
    }

    public function activedUser($username,$token){
        $update = $this->query("UPDATE users  SET token=?,connected=1 WHERE username=? ",[$token,$username]);
        return $this->checkIfIsUser($username);
    }

    public function register($username,$password,$token){
        return $this->query("INSERT INTO $this->table (username,password,token,connected) VALUES (?,?,?,?)",[$username,$password,$token,1]);
    }

    public function logout($id){
        return $this->query("UPDATE users SET connected=0 WHERE id=".$id);
    }

    private function dd($t){
        echo "<pre>";
        var_dump($t);
        echo "</pre>";
    }

}