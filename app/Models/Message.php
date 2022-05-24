<?php
namespace App\Models;



use function html_entity_decode;
use function htmlentities;
use function htmlspecialchars_decode;
use function mb_detect_encoding;
use function urldecode;
use function utf8_decode;
use function utf8_encode;
use const ENT_QUOTES;

class Message extends Model{

    private $table = "messages";

    /**
     * Fonction qui retourn les message de la room demandé
     * @param $from
     * @param $room
     * @return string
     */
    public function getAllMessages($from,$room,$start=0,$limit=null){
         $sqlPart='';
        if($room!=0){
            $sqlPart=" AND id_user= $from OR room=$from AND id_user=$room AND messages.created_at > (NOW() - INTERVAL SECOND(NOW()) SECOND - INTERVAL 60 MINUTE) " ;

        }

        return $this->query("SELECT messages.content,users.username,messages.created_at,messages.room,id_user,messages.id   
                                FROM `messages` 
                                INNER JOIN users ON messages.id_user=users.id
                                WHERE room=$room  AND messages.id>0 AND messages.created_at > (NOW() - INTERVAL SECOND(NOW()) SECOND - INTERVAL 60 MINUTE) $sqlPart
                                ORDER BY messages.id DESC
                                LIMIT 50");
//        return $this->query("SELECT * FROM $this->table WHERE room = $room $sqlPart AND id>$start ORDER BY id DESC LIMIT $limit ");

    }

    public function updateViewedStatus($from,$room){
        if($room !== 0){
        return $this->query("UPDATE $this->table SET viewed=1 WHERE id_user=$room AND room=$from AND viewed=0");
        }
    }

    public function addMessage($from,$room,$message){
        header('Content-type: text/html; charset=UTF-8');
        return $this->query("INSERT INTO $this->table (id_user,content,room) VALUES (?,?,?)",[$from,$message,$room]);
    }

    public function cleaningMessage(){
        var_dump($this->query('DELETE FROM messages WHERE created_at<(NOW()-INTERVAL  SECOND (NOW()) SECOND-INTERVAL 24 HOUR)'));
    }

}