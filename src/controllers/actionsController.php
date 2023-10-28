<?php

require_once "../models/queryModel.php";
require_once("../../config.php");
session_start();

$action = $_GET['action'];
switch ($action) {
    case 'login':
        login();
    break;
    default:
        echo json_encode("No action defined: ".$action);
    break;
}

function getData(){
    return isset($_POST) ? $_POST : '';
}

function login(){
    $data = getData();

    try{
        /*-ReCaptcha-----
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
        $recaptcha_secret = RECAPTCHA_SECRET; 
        $recaptcha_response = $data['g-recaptcha-response']; 
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
        $recaptcha = json_decode($recaptcha); 

        if($recaptcha->success == true){-----*/

            $db = new QueryModel();
            $username = $data['username'];
            
            $user = $db->query("SELECT u.*, r.id as rolid, r.name as rolname, r.status as rolstatus FROM SYS_USER u JOIN SYS_ROLES r ON u.id_rol = r.id WHERE username = :username", [':username' => $username]);
            $user = $user[0];

            if ($user && isset($user) && isset($user['password']) && $user['password'] == md5($data['pswd'])) {

                $permissions_screen = $db->query("SELECT s.href FROM REG_PERMISSIONS_SCREENS p JOIN SYS_PERMISSIONS_SCREENS s ON p.id_screen = s.id WHERE p.id_rol = :id_rol", [':id_rol' => $user['rolid']]);

                foreach ($user as $key => $value) {
                    if($key != "password"){
                        $_SESSION['userdata'][$key] = $value;
                    }
                }

                foreach ($permissions_screen as $key => $value) {
                    $_SESSION['screens'][$key] = $value['href'];
                }

                echo 1;
            } else {
                echo 0;
            }
        /*-----
        } else {
            echo 2;
        }--*/
        
    }catch(exception $e){
        echo json_encode('error: '.$e->getMessage());
    }
}