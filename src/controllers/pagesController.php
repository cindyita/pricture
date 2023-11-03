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
        $rejectPages = array('myprofile','myposts','myfriends','settings','logout','newpost');
        $currentPage = $_GET['page'];
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
        $db = new QueryModel();
        $post = $db->query("SELECT p.*,u.username,u.img_profile FROM REG_POST p LEFT JOIN SYS_USER u ON p.id_user = u.id", []);
        if(isset($_SESSION['status_login_pricture'])){
            $favorites = $db->query("SELECT GROUP_CONCAT(id_post) AS id_posts FROM REG_FAVORITES WHERE id_user = :user_id",[':user_id' => $_SESSION['userdata']['id']]);
            $favorites = explode(',', $favorites[0]['id_posts']);
        }else{
            $favorites = [];
        }
        require_once "./src/views/pages/home.php";
    }

    
    /**
     * Shows profile page
     */
    public static function myprofile() {
        self::checkSession();
        $db = new QueryModel();
        if($_SESSION['userdata']['id']){
            $id = $_SESSION['userdata']['id'];
            $user = $db->query("SELECT u.*, r.name AS rol, t.name AS idol_type, t.color AS color_idol_type 
            FROM SYS_USER u 
            LEFT JOIN SYS_ROL r ON u.id_rol = r.id 
            LEFT JOIN SYS_FAVORITE_BRANDS f ON u.id_favorite_brand = f.id 
            LEFT JOIN SYS_TYPE_IDOLS t ON f.type = t.id 
            WHERE u.id = :id",[":id"=>$id]);
            $user = $user[0];
            if($user['id_custom_brand']){
                $custom_brand = $db->query("SELECT c.id,c.name,c.img,c.type id_type_idol, t.name type_name,t.color type_color FROM REG_CUSTOM_BRANDS c LEFT JOIN SYS_TYPE_IDOLS t ON c.type = t.id WHERE c.id = :id", [":id" => $user['id_custom_brand']]);
            }
            $favorite_brands = $db->query("SELECT b.*,t.name type_name,t.color type_color FROM SYS_FAVORITE_BRANDS b LEFT JOIN SYS_TYPE_IDOLS t ON b.type = t.id",[]);
            $type_brands = $db->select("SYS_TYPE_IDOLS", 1);
            require_once "./src/views/pages/myprofile.php";
        }else{
            header('Location: login');
        }

    }

    /**
     * Shows user page
     */
    public static function user() {
        self::checkSession();
        $db = new QueryModel();
        if($_GET['id']){
            $id = $_GET['id'];
            $user = $db->query("SELECT u.*, r.name AS rol, t.name AS idol_type, t.color AS color_idol_type 
            FROM SYS_USER u 
            LEFT JOIN SYS_ROL r ON u.id_rol = r.id 
            LEFT JOIN SYS_FAVORITE_BRANDS f ON u.id_favorite_brand = f.id 
            LEFT JOIN SYS_TYPE_IDOLS t ON f.type = t.id 
            WHERE u.id = :id",[":id"=>$id]);
            $user = $user[0];
            if($user['id_custom_brand']){
                $custom_brand = $db->query("SELECT c.id,c.name,c.img,c.type id_type_idol, t.name type_name,t.color type_color FROM REG_CUSTOM_BRANDS c LEFT JOIN SYS_TYPE_IDOLS t ON c.type = t.id WHERE c.id = :id", [":id" => $user['id_custom_brand']]);
            }
            require_once "./src/views/pages/user.php";
        }else{
            header('Location: home');
        }

    }

    /**
     * Shows newpost page
     */
    public static function newpost() {
        self::checkSession();
        $db = new QueryModel();
        $categories = $db->select("SYS_CATEGORIES", 1);
        require_once "./src/views/pages/newpost.php";
    }

    /**
     * Shows post page
     */
    public static function post() {
        $db = new QueryModel();
        $idpost = $_GET['id'];
        $post = $db->query("SELECT p.*, c.name AS category, u.username,u.img_profile  FROM REG_POST p LEFT JOIN SYS_CATEGORIES c ON p.id_category = c.id LEFT JOIN SYS_USER u ON p.id_user = u.id WHERE p.id = :id", ["id"=>$idpost]);
        $post = $post[0];
        $comments = $db->query("SELECT c.id, c.id_user, c.comment, c.timestamp_create, u.id AS id_user, u.img_profile, u.username 
            FROM REG_COMMENTS c 
            LEFT JOIN SYS_USER u ON c.id_user = u.id 
            WHERE c.id_post = :id_post 
            ORDER BY c.timestamp_create DESC;
            ", ["id_post"=>$idpost]);
        if(isset($_SESSION['status_login_pricture'])){
            $favorite = $db->select("REG_FAVORITES","id_user = ".$_SESSION['userdata']['id']." AND id_post = ".$idpost);
            $favorite = $favorite ? true : false;
        }else{
            $favorite = false;
        }
        require_once "./src/views/pages/post.php";
    }

    /**
     * Shows myposts page
     */
    public static function myposts() {
        self::checkSession();
        $db = new QueryModel();
        $id = $_SESSION['userdata']['id'];
        $posts = $db->query("SELECT p.*, c.name AS category FROM REG_POST p LEFT JOIN SYS_CATEGORIES c ON p.id_category = c.id WHERE p.id_user = :id", ["id"=>$id]);
        require_once "./src/views/pages/myposts.php";
    }

    /**
     * CONDITIONS PAGES
     */
    public static function termsandconditions() {
        require_once "./src/views/pages/termsandconditions.php";
    }
    public static function privacypolicy() {
        require_once "./src/views/pages/privacypolicy.php";
    }
    public static function useofcookies() {
        require_once "./src/views/pages/useofcookies.php";
    }

    /**
     * Muestra la página de error 404 (página no encontrada).
     */
    public static function error404() {
        require_once "./src/views/pages/error404.php";
    }
    
}
