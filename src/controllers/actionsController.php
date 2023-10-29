<?php

require_once "../models/queryModel.php";
require_once("../../config.php");
session_start();

$action = $_GET['action'];
switch ($action) {
    case 'login':
        login();
    break;
    case 'checkusername':
        checkusername();
    break;
    case 'checkemail':
        checkemail();
    break;
    case 'signup':
        signup();
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
            
            $user = $db->query("SELECT u.*, r.name as rolname, r.status as rolstatus FROM SYS_USER u JOIN SYS_ROL r ON u.id_rol = r.id WHERE username = :username", [':username' => $username]);
            $user = $user[0];

            if ($user && isset($user) && isset($user['password']) && $user['password'] == md5($data['pass'])) {

                foreach ($user as $key => $value) {
                    if($key != "password"){
                        $_SESSION['userdata'][$key] = $value;
                    }
                }
                $_SESSION['status_login_pricture'] = 1;

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

function checkusername(){
    $db = new QueryModel();
    $data = getData();
    $username = $data['input'];
    $value = $db->selectUnique("SYS_USER", "username = '".$username."'","username");
    if($value){
        echo 1;
    }else{
        echo 0;
    }
}

function checkemail(){
    $db = new QueryModel();
    $data = getData();
    $email = $data['input'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 2;
        die();
    }

    list($user, $domain) = explode('@', $email);
    if(!checkdnsrr($domain, 'MX')){
        echo 2;
        die();
    }

    $value = $db->selectUnique("SYS_USER", "email = '".$email."'","email");
    if($value){
        echo 1;
    }else{
        echo 0;
    }
}

function signup() {
    $data = getData();
    try {
        $db = new QueryModel();
        $pass = md5($data['pass']);
        $insertData = [
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => $pass
        ];

        $register = $db->insert('SYS_USER', $insertData);
        echo json_encode($register);

    } catch (Exception $e) {
        echo json_encode('error: '.$e->getMessage());
    }
}