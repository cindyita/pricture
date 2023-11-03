<?php
session_start();
ob_start();

require_once("./config.php");
require_once("./info.php");
require_once("./src/controllers/pagesController.php");
require_once("./src/controllers/routingController.php");
require_once("./src/resources/html.php");
date_default_timezone_set('UTC');
setlocale(LC_TIME, 'es_ES.UTF-8');

$pages = new PagesController();
$router = new Router('PagesController@error404');

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
        case 'myprofile':
            $pages->updateScripts(["./assets/js/pages/myprofile.js"]);
            $pages->menuHTML();
        break;
        case 'user':
            $pages->updateScripts(["./assets/js/pages/user.js"]);
            $pages->menuHTML();
        break;
        case 'home':
            $pages->updateScripts(["./assets/js/pages/home.js"]);
            $pages->menuHTML();
        break;
        case 'newpost':
            $pages->updateScripts(["./assets/js/pages/newpost.js"]);
            $pages->menuHTML();
        break;
        case 'myposts':
            $pages->updateScripts(["./assets/js/pages/myposts.js"]);
            $pages->menuHTML();
        break;
        case 'post':
            $pages->updateScripts(["./assets/js/pages/post.js"]);
            $pages->menuHTML();
        break;
        case 'termsandconditions':
            $pages->menuHTML();
        break;
        case 'privacypolicy':
            $pages->menuHTML();
        break;
        case 'cookies':
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

$router->add('/myposts', 'PagesController@myposts');

$router->add('/user', 'PagesController@user');

$router->add('/post', 'PagesController@post');

$router->add('/newpost', 'PagesController@newpost');

$router->add('/termsandconditions', 'PagesController@termsandconditions');

$router->add('/privacypolicy', 'PagesController@privacypolicy');

$router->add('/cookies', 'PagesController@useofcookies');

$router->run();

/*-------------------------------------*/
/*-------------------------------------*/

$pages->bottomHTML();

/*-------------------------------------*/