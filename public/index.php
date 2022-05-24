<?php
header('Content-type: text/html; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', '1');
use App\Router\Routers;
require "../vendor/autoload.php";


if(session_status() === PHP_SESSION_NONE) session_start();

$router = new Routers($_SERVER['REQUEST_URI']);


$router->get("/","App\Controllers\PageController@index");
$router->post("/chatbox","App\Controllers\PageController@chatbox");
$router->get("/chatbox","App\Controllers\PageController@index");

$router->get("/api","App\Controllers\ApiController@index");
$router->get('/api/user',"App\Controllers\ApiController@user");
$router->get('/api/user/logout',"App\Controllers\ApiController@logout");

$router->post('/api/user/signin',"App\Controllers\ApiController@signin");
$router->post('/api/user/signup',"App\Controllers\ApiController@signup");
$router->post('/api/checkToken',"App\Controllers\ApiController@checkToken");


$router->get('/api/message',"App\Controllers\ApiController@message");
$router->post('/api/message/new',"App\Controllers\ApiController@messageRegister");

$router->get("/sd45ff5dsf6d5s4","App\Controllers\ApiController@cleaningDatabase");
$router->run();
