<?php
namespace  App\Controllers;


use App\Database\DbConnect;
use App\Models\Message;
use App\Models\User;
use DateInterval;
use DateTime;
use function array_reverse;
use function date;
use function extract;
use function gettype;
use function hex2bin;
use function htmlentities;
use function intval;
use function is_array;
use function json_encode;
use function openssl_random_pseudo_bytes;
use function password_hash;
use function str_replace;
use function strtotime;
use function strval;
use function urldecode;
use function var_dump;
use const PASSWORD_DEFAULT;

class ApiController{
    public $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    /****************************************************************
     *              U S E R   F U N C T I O N S
     **************************************************************/


    /**
     * display the page of the api
     *
     */
    public function index(){
        echo "index apiiii";
    }

    //    GET    ////////////////

    /**
     * action to get all users connected
     *
     * return JSON
     */
    public function user($params){
        $id = isset($params['id']) ? $params['id'] : 0;
        $user = new User($this->db);
        $users=$user->getAllConnected($id);
        $nbMessage = $user->getNbMessagePerUser($id);
        $finalArray=[];
        header('Access-Control-Allow-Origin: *');
        // we create the good array
        foreach($users as $dats){
            unset($dats->db);
            foreach ($dats as $key=>$dat){
            $finalArray[$dats->id][$key]= $dat;

            }
        }
        if(is_array($nbMessage)) {
            foreach ($nbMessage as $message) {
                unset($message->db);
                $finalArray[$message->id]['nb_messages'] = $message->nb_messages;
            }
        }
        echo json_encode($finalArray);
    }

    public function logout($params){
        if(isset($params['id'])){
            $user = new User($this->db);
            extract($params);
            $logOut = $user->logout($id);
            echo json_encode($logOut);
        }else{
            header('Location: /');
        }
    }

    //    POST  //////////////////
    public function signin($params){

        if(isset($params['username']) && isset($params['password'])){
            header('Access-Control-Allow-Origin: *');
            extract($params);
            // hash of the password
            //$this->dd(password_hash("bajmok24210",PASSWORD_DEFAULT));
            // token creation
            $token = bin2hex(openssl_random_pseudo_bytes(32));
            $user = new User($this->db);
            $isUser = $user->checkIfIsUser($username);
            if($isUser && password_verify($password,$isUser->password)){
                // we update the token and we set in the session
                $setToken = $user->activedUser($isUser->username,$token);
                $datas=[
                    'id'=>$setToken->id,
                    'username'=>$setToken->username,
                    'token'=>$setToken->token,
                    'alert'=>[
                        0=>['success','Connexion réussite, Bravo et bon chat']
                    ]
                ];
                echo json_encode($datas);
            }else{
                $datas=[
                    'alert'=>[
                        0=>["error","Username and Password not match !!"],
//                        1=>["error","deuxieme"]
                    ]
                ];
                echo json_encode($datas);

            }
        }else{
            echo json_encode($_POST);
        }
    }
    public function signup($params){
        header('Access-Control-Allow-Origin: *');
        if(isset($params['username']) && isset($params['password']) && isset($params['confirmPassword'])){
            extract($params);
            $username =trim(urldecode(str_replace(' ','',$username)));
            if($password===$confirmPassword){
                $newUser = new User($this->db);
                $password = password_hash($password, PASSWORD_DEFAULT);
                $token = bin2hex(openssl_random_pseudo_bytes(32));
                $response = $newUser->register($username,$password,$token);

                if(intval($response)!=0) {
                    $datas=[
                        'id'=>$response,
                        'username'=>$username,
                        'token'=>$token,
                        'alert'=>[
                            0=>['success','Enregistrement réussite, bon chat']
                        ]
                    ];
                    echo json_encode($datas);
                }else{
                    $datas=[
                        'alert'=>[
                            0=>["error",$response]
                        ]
                    ];
                    echo json_encode($datas);
                }
            }else{
                $datas=[
                    'alert'=>[
                        0=>["error","Bad confirmation password"]//
                    ]
                ];
                echo json_encode($datas);
            }
        }else{
            header("Location: http://myiptest.be/api");
        }

    }


    /****************************************************************
     *              M E S S A G E     F U N C T I O N S
     **************************************************************/


    /**
     *
     * action when we want to get the messages to display to the chat
     *
     * @param $params
     * @return | all messages in JSON
     */
    public function message($params){
        is_array($params) && extract($params) ;
        $room = !isset($room) ? 0 : $room;
        $from = !isset($from) ? 0 : $from;
        $start = !isset($start) ? 0 : $start;
        $limit = !isset($limit) ? null : $limit;

        // on va chercher une instance de message
        $message = new Message($this->db);
        $messages=$message->getAllMessages($from,$room,$start,$limit);
        if(is_array($messages)){
            // on update le status des messages a viewed=1
            $message->updateViewedStatus($from,$room);
            foreach($messages as $mes){
                unset($mes->db);
            }
            header('Access-Control-Allow-Origin: *');
            echo json_encode(array_reverse($messages));
        }else{
            echo json_encode("no messages");
        }

    }

    /**
     *
     * action when we want to register a new message
     *
     * @param $params
     */
    public function messageRegister($params){

        header('Access-Control-Allow-Origin: *');
        extract($params);
        if(isset($from) && isset($room) && isset($message)){
            $newMessage = new Message($this->db);
            if($newMessage->addMessage($from,$room,$message)){
                echo true;
            }else{
                echo false;
            }
        }
    }
    protected function dd($t){
        echo "<pre style='background-color:burlywood'>";
        var_dump($t);
        echo "</pre>";
    }

    public function checkToken($params){
        is_array($params) && extract($params) ;
        header('Access-Control-Allow-Origin: *');
        $user = new User($this->db);
        $accessAllowed = $user->checkSession($username,$token);
        unset($accessAllowed->password);
        unset($accessAllowed->db);
        unset($accessAllowed->connected);
        echo json_encode($accessAllowed);
    }

    public function cleaningDatabase(){
       $delete = (new  Message($this->db))->cleaningMessage();

    }

}
