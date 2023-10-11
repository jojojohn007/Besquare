<?php

declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require dirname(__DIR__).'/Core/Init.php';
require_once ROOT.'/vendor/autoload.php';

set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

//migration (one time only);
//=======================//
// $f = new \App\Models\Migration();
//=======================//

$url =  $_SERVER['QUERY_STRING'];

$router = new Core\Router();
$ctrl = 'controller';
$ac = 'action';
//welcome section
// $router->addRoutes('',[$ctrl=>'Home',$ac=>'index','namespace'=>'Welcome']);
// $router->addRoutes('home',[$ctrl=>'Home',$ac=>'index','namespace'=>'Welcome']);
// $router->addRoutes('about',[$ctrl=>'Contact',$ac=>'index' ,'namespace'=>'Welcome']);
// $router->addRoutes('contact',[$ctrl=>'Contact',$ac=>'index' ,'namespace'=>'Welcome']);
// $router->addRoutes('signup',[$ctrl=>'signup',$ac=>'index' ,'namespace'=>'Welcome']);

$router->post('login',[$ctrl=>'UserController',$ac=>'login' ,'namespace'=>'Authentication']);

//====VIEWS====//
//HOME
$router->get('',['View'=>'Home/index']);
$router->get('login',['View'=>'Home/login']);
$router->get('home',['View'=>'Home/index']);
$router->get('about',['View'=>'Home/about']);
$router->get('contact',['View'=>'Home/contact']);
$router->get('signup',['View'=>'Home/signup']);
$router->get('test',['View'=>'student/test']);
$router->get('teacher', ['View' => 'alerts/info']);
$router->get('parent', ['View' => 'alerts/info']);



//STUDENT
$router->addRoutes('student/home',[$ctrl=>'StudentNavigation',$ac=>'home','namespace'=>'Student']);
$router->addRoutes('student/',[$ctrl=>'StudentNavigation',$ac=>'home','namespace'=>'Student']);
$router->addRoutes('student/progress',[$ctrl=>'StudentNavigation',$ac=>'progress','namespace'=>'Student']);
$router->addRoutes('student/logout',[$ctrl=>'StudentNavigation',$ac=>'logout','namespace'=>'Student']);
$router->get('student/teachers',['View'=>'student/teachers']);
$router->get('student/badges',['View'=>'student/badges']);




//authentication
$router->post('login',[$ctrl=>'UserController',$ac=>'login' ,'namespace'=>'Authentication']);
$router->post('signup',[$ctrl=>'UserController',$ac=>'signup' ,'namespace'=>'Authentication']);


//course related routes

//DELETE REQUESTS
$router->delete('student/delete/{id}',[$ctrl=>'UserController' , $ac=>'deleteCourse','namespace'=>'Authentication']);
    
//ADDING COURSE TO DB
$router->post('student/addcourse',[$ctrl=>'StudentNavigation',$ac=>'startCourse' ,'namespace'=>'Student']);

//ROUTE TO COURSE PAGE
$router->get('student/courses/{controller}',[$ac=>'home','namespace'=>'Courses','parameters'=>'{{controller}}']);

//COURSE DATA MANAGEMENT URL'S
$router->post('student/courses/{controller}',[$ac=>'saveUserdetail','namespace'=>'Courses']);



//ADMIN
$router->addRoutes("admin",[$ctrl=>'Home',$ac=>'index','namespace'=>'Admin']);




$router->addRoutes('post',[$ctrl=>'Post',$ac=>'index']);
$router->addRoutes('post/new',[$ctrl=>'Home',$ac=>'new']);
$router->addRoutes("{controller}/{action}");
$router->addRoutes("admin/{controller}/{action}",['namespace'=>'Admin']);
$router->addRoutes('{controller}/{action}/{id:\d+}');
// vd($router->getAllRoutes());
// 
// pr($router->getAllRoutes());
$router->dispatch($url);
// $router_match_result =  $router->matched($url);








?>