<?php

use App\Router\Router;

require '../vendor/autoload.php';

$router = new Router($_SERVER['REQUEST_URI']);
// API -----------------------------------------------------------------------------------------------------

// GET METHOD
$router->get('http://myiptest.be/api/user', 'App\Controllers\ApiController@get100'); // get all users
$router->get('http://myiptest.be/api/message:params', 'App\Controllers\ApiController@get200'); // get message of room id (0=public,etc...)
//---------------------------------------------------------------------------------------------------------------
// MESSAGE ------------------------------------------------------------------------------------------------------
// GET METHOD
// $router->get('message/:id', 'App\Controllers\MessageController@get200'); // get message of room id (0=public,etc...)
//------------------------------------------------------------------------------------------------------------
// USERS------------------------------------------------------------------------------------------------------
// GET METHOD
// $router->get('users', 'App\Controllers\UserController@get100'); // get message of room id (0=public,etc...)
// $router->get('users/:id', 'App\Controllers\UserController@get101'); // edit profil user
// // POST METHOD
// $router->post('users/', 'App\Controllers\UserController@post102'); // register users
// $router->post('users/:id', 'App\Controllers\UserController@post103'); // update profil  users


$router->run();
?>
TT
