<?php
require_once "./src/models/queryModel.php";
class PagesController
{
    private $queryModel;
    private $styles;
    private $scripts;

    /**
     * Constructor de la clase PagesController.
     * Crea una instancia del modelo QueryModel.
     */
    public function __construct() {
        $this->queryModel = new QueryModel();
        $this->styles = [];
        $this->scripts = [];
    }

    public function getStyles() {
        return $this->styles;
    }

    public function updateStyles($data) {
        $this->styles = $data;
    }

    public function getScripts() {
        return $this->scripts;
    }

    public function updateScripts($data) {
        $this->scripts = $data;
    }

    /**
     * Revisar si hay una sesión
     */
    public static function checkSession() {
        $rejectPages = array('myprofile','myposts','myfriends','settings','logout');
        $currentPage = basename($_SERVER['PHP_SELF']);
        if (in_array($currentPage, $rejectPages)) {

            if (!isset($_SESSION['status_login_pricture'])) {

                header('Location: login');
                exit();
            }
        }
    }

    /**
     * Check and shows login page
     */
    public static function login() {   
        if (isset($_SESSION['user_id'])) {

            header('Location: home');
            exit();
        }else{
            require_once "./src/views/pages/login.php";
        }
    }

    /**
     * Check and shows sign up page
     */
    public static function signup() {   
        if (isset($_SESSION['user_id'])) {

            header('Location: home');
            exit();
        }else{
            require_once "./src/views/pages/signup.php";
        }
    }

    /**
     * Logout session
     */
    public static function logout() {   
        echo "Signing out... Redirecting...";
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
        header('Location: home');
        exit();
    }


    public function topHTML() {
        $styles = $this->styles;
        require_once "./src/views/layouts/headerLayout.php";
    }

    public function bottomHTML() { 
        $scripts = $this->scripts;
        require_once "./src/views/layouts/footerLayout.php";
    }

    public static function menuHTML() {   
        require_once "./src/views/layouts/menuLayout.php";
    }

    /**
     * Shows home
     */
    public static function home() {
        require_once "./src/views/pages/home.php";
    }

    
    /**
     * Shows profile page
     */
    public static function myprofile() {
        self::checkSession();
        $db = new QueryModel();
        if(isset($_GET['id'])){
            if($_SESSION['id_rol'])
            $id = $_GET['id'];
            $user = $db->query("SELECT u.*,r.name rol FROM SYS_USER u LEFT JOIN SYS_ROLES r ON u.id_rol = r.id WHERE u.id = :id",[":id"=>$id]);
            if($user){
                $user = $user[0];
                require_once "./src/views/pages/myprofile.php";
            }else{
                echo "Invalid link";
            }
            
        }else{
            echo "Invalid link";
        }
        
    }

    /**
     * Muestra la página de error 404 (página no encontrada).
     */
    public static function error404() {
        self::checkSession();
        require_once "./src/views/error404.php";
    }
    
}
