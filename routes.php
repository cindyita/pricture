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
        case 'home':
            $pages->updateScripts(["./assets/js/pages/home.js"]);
        break;
    }

}

$pages->menuHTML();
/*-------------------------------------*/

$router->add('/', 'PagesController@home');

$router->add('/home', 'PagesController@redirecthome');

$router->add('/login', 'PagesController@login');

$router->add('/logout','PagesController@logout');

$router->add('/profile', 'PagesController@profile');

$router->run();

/*-------------------------------------*/
/*-------------------------------------*/

$pages->bottomHTML();

/*-------------------------------------*/