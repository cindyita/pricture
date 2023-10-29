<?php
session_start();
ob_start();

require_once("./config.php");
require_once("./info.php");
require_once("./src/controllers/pagesController.php");
require_once("./src/controllers/routingController.php");
require_once("./src/resources/html.php");
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'es_ES.UTF-8');

$pages = new PagesController();
$router = new Router();

/*-------------------------------------*/

$pages->topHTML();

/*-------------------------------------*/

if(isset($_GET['page'])){

    switch ($_GET['page']) {
        case 'login':
            $pages->updateScripts(["./assets/js/pages/login.js"]);
        break;
        case 'signup':
            $pages->updateScripts(["./assets/js/pages/signup.js"]);
        break;
        case 'home':
            $pages->updateScripts(["./assets/js/pages/home.js"]);
            $pages->menuHTML();
        break;
    }

}else{
    $pages->menuHTML();
}

/*-------------------------------------*/

$router->add('/', 'PagesController@home');

$router->add('/home', 'PagesController@home');

$router->add('/login', 'PagesController@login');

$router->add('/signup', 'PagesController@signup');

$router->add('/logout','PagesController@logout');

$router->add('/myprofile', 'PagesController@myprofile');

$router->run();

/*-------------------------------------*/
/*-------------------------------------*/

$pages->bottomHTML();

/*-------------------------------------*/