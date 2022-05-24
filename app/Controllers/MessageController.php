<?php

namespace App\Controllers;

use App\Models\Message;





class MessageController
{

    protected $from = 1; //current User;


    //  GET
    public function get100()
    {
        echo 'get100';
    }

    public function get200($room = 0)
    {
        $messages = (new Message())->get($this->from, $room);
        var_dump($messages);
    }

    // POST

}
