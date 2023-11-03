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
    case 'saveprofile':
        saveprofile();
    break;
    case 'updateProfile':
        updateProfile();
    break;
    case 'newPost':
        newPost();
    break;
    case 'deletePost':
        deletePost();
    break;
    case 'updateMyPosts':
        updateMyPosts();
    break;
    case 'likePost':
        likePost();
    break;
    case 'unlikePost':
        unlikePost();
    break;
    case 'newCommentPost':
        newCommentPost();
    break;
    case 'updateCommentPost':
        updateCommentPost();
    break;
    case 'deleteCommentPost':
        deleteCommentPost();
    break;
    case 'updatePosts':
        updatePosts();
    break;
    case 'sendContactForm':
        sendContactForm();
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
        /*-ReCaptcha----------*/
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
        $recaptcha_secret = RECAPTCHA_SECRET; 
        $recaptcha_response = $data['g-recaptcha-response']; 
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
        $recaptcha = json_decode($recaptcha); 

        if($recaptcha->success == true){

            $db = new QueryModel();
            $username = $data['username'];
            
            $user = $db->query("SELECT u.*, r.name as rolname, r.status as rolstatus,t.name as idol_type, t.color as color_idol_type FROM SYS_USER u JOIN SYS_ROL r ON u.id_rol = r.id LEFT JOIN SYS_FAVORITE_BRANDS f ON u.id_favorite_brand = f.id 
            LEFT JOIN SYS_TYPE_IDOLS t ON f.type = t.id WHERE username = :username", [':username' => $username]);
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
        /*-------*/
        } else {
            echo 2;
        }
        
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
        /*-ReCaptcha----------*/
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
        $recaptcha_secret = RECAPTCHA_SECRET; 
        $recaptcha_response = $data['g-recaptcha-response']; 
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
        $recaptcha = json_decode($recaptcha); 

        if($recaptcha->success == true){

            $db = new QueryModel();
            $pass = md5($data['pass']);
            $insertData = [
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => $pass
            ];

            $register = $db->insert('SYS_USER', $insertData);

            // if($register){
            //     sendEmailSMTP("contact@pricture.theblux.com", $data['name'], $data['email'], $data['username'],"Thank you for registering on Pricture", '', ["host"=>"ngx341.inmotionhosting.com","username"=>"contact@pricture.theblux.com","password"=>"-K7prPb9#8=}","port"=>"465"],["title"=>"Thank you for registering on the page","content"=>"We hope that your stay is to your liking, remember that we are still in the development and testing phase. Stop by from time to time to see what's new on the page and if you have any problems with your account, send us an email."]);
            // }
            echo json_encode($register);
            
        } else {
            echo 6;
        }


    } catch (Exception $e) {
        echo json_encode('error: '.$e->getMessage());
    }
}

function saveprofile(){
    $data = getData();
    $db = new QueryModel();

    // Profile image
    $newimgprofile = null;
    if (isset($_FILES['img-profile'])) {
        $uploadDirectory = '../../assets/img/user/img-profile/';
        $profileFileName = $_SESSION['userdata']['id'] . '.' . strtolower(pathinfo($_FILES['img-profile']['name'], PATHINFO_EXTENSION));

        if (file_exists($uploadDirectory . $profileFileName)) {
            unlink($uploadDirectory . $profileFileName);
        }

        $newimgprofile = uploadFile($_FILES['img-profile'], $uploadDirectory, $profileFileName);
    }

    // Custom brand
    $custom_brand = null;
    if (isset($_FILES['custom_brand'])) {
        $uploadDirectory = '../../assets/img/user/custom-brands/';
        $CustomBrandFileName = $_SESSION['userdata']['id'] . '.' . strtolower(pathinfo($_FILES['custom_brand']['name'], PATHINFO_EXTENSION));

        if (file_exists($uploadDirectory . $CustomBrandFileName)) {
            unlink($uploadDirectory . $CustomBrandFileName);
        }

        $img_custom_brand = uploadFile($_FILES['custom_brand'], $uploadDirectory, $CustomBrandFileName);
    }

    // Custom brand
    if ($data['id_favorite_brand'] == 2) {
        if ($data['name_custom_brand'] || $img_custom_brand) {
            $db->delete('REG_CUSTOM_BRANDS', 'id_user = ' . $_SESSION['userdata']['id']);
            $customBrandFileName = $img_custom_brand ? $CustomBrandFileName : null;
            $insertData = [
                'name' => $data['name_custom_brand'],
                'type' => $data['custom_type_idol'],
                'img' => $customBrandFileName,
                'id_user' => $_SESSION['userdata']['id']
            ];
            $register = $db->insert('REG_CUSTOM_BRANDS', $insertData);
            $custom_brand = $db->lastid("REG_CUSTOM_BRANDS");
        } else {
            if ($data['id_custom_brand'] == "") {
                $data['id_favorite_brand'] = 1;
            }
        }
    }

    if ($data['id_favorite_brand'] != 2) {
        $db->delete('REG_CUSTOM_BRANDS', 'id_user = ' . $_SESSION['userdata']['id']);
        $custom_brand = null;
    }

    // Update data
    $updateData = [
        'friendcode' => $data['friendcode'],
        'birthday' => isset($data['birthday']) ? $data['birthday'] : null,
        'id_favorite_brand' => $data['id_favorite_brand'],
        'id_custom_brand' => $custom_brand,
        'biography' => $data['biography']
    ];

    if ($data['username'] != $data['actual_username']) {
        $updateData['username'] = $data['username'];
    }
    if ($newimgprofile) {
        $updateData['img_profile'] = $profileFileName;
    }

    try {
        $register = $db->update('SYS_USER', $updateData, 'id =' . $_SESSION['userdata']['id']);
        echo json_encode($register);
    } catch (Exception $e) {
        echo json_encode('error: ' . $e->getMessage());
    }
}



function updateProfile() {
    $response = array();

    $db = new QueryModel();
    $id = $_SESSION['userdata']['id'];
    $user = $db->query("SELECT u.*, r.name AS rol, t.name AS idol_type, t.color AS color_idol_type 
    FROM SYS_USER u 
    LEFT JOIN SYS_ROL r ON u.id_rol = r.id 
    LEFT JOIN SYS_FAVORITE_BRANDS f ON u.id_favorite_brand = f.id 
    LEFT JOIN SYS_TYPE_IDOLS t ON f.type = t.id 
    WHERE u.id = :id", [":id" => $id]);
    $user = $user[0];
    $custom_brand = null;
    if($user['id_custom_brand']){
        $custom_brand = $db->query("SELECT c.id,c.name,c.img,c.type id_type_idol, t.name type_name,t.color type_color FROM REG_CUSTOM_BRANDS c LEFT JOIN SYS_TYPE_IDOLS t ON c.type = t.id WHERE c.id = :id", [":id" => $user['id_custom_brand']]);
        $custom_brand = $custom_brand[0];
    }

    $response['user'] = $user;
    $response['custom_brand'] = $custom_brand;

    echo json_encode($response);
}

function newPost(){
    $data = getData();
    $db = new QueryModel();
    $id = $_SESSION['userdata']['id'];

    $fileName = null;
    $category = $data['category'] ? $data['category'] : null;

    if (isset($_FILES['img'])) {
        $uploadDirectory = '../../assets/img/posts/'.$id.'/';
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        $currentDateTime = date('YmdHis');
        $fileName = $id . $currentDateTime . '.' . strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        $img_post = uploadFile($_FILES['img'], $uploadDirectory, $fileName);
    }


    try {
        $insertData = [
            'id_user' => $id,
            'img' => $id.'/'.$fileName,
            'extract' => $data['text'],
            'id_category' => $category
        ];

        $register = $db->insert('REG_POST', $insertData);
        echo json_encode($register);

    } catch (Exception $e) {
        echo json_encode('error: '.$e->getMessage());
    }
}

/*---------------------------*/
function uploadFile($file, $directory, $fileName) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
            $destination = $directory . $fileName;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 'The file is not a valid image. Only JPG, JPEG, PNG, and GIF are allowed.';
        }
    }
    return null;
}

function deletePost(){
    $data = getData();
    $db = new QueryModel();
    $reg = $data['id'];
    $id = $_SESSION['userdata']['id'];
    $delete = $db->delete('REG_POST', 'id = '.$reg.' AND id_user = '.$id);
    echo json_encode($delete);
}

function updateMyPosts(){
    $db = new QueryModel();
    $id = $_SESSION['userdata']['id'];
    $posts = $db->query("SELECT p.*, c.name AS category FROM REG_POST p LEFT JOIN SYS_CATEGORIES c ON p.id_category = c.id WHERE p.id_user = :id", ["id"=>$id]);

    $html = "";

    foreach ($posts as $value) {
            $html .= `<div class="green-card">
                <div class="head">
                    <div class="img">
                        <img src="./assets/img/posts/`.$value["img"].`" alt="img post">
                    </div>
                    <div class="info">
                        <strong>Post id: `.$value["id"].`</strong>
                        <span>Category: `.$value["id_category"].`</span>
                        <span>Created: `.formatDate($value["timestamp_create"]).`</span>
                    </div>
                </div>
                <div class="options">
                    <div class="dropdown">
                        <a class="btn button-options" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" onclick="deletePost(`.$value["id"].`)">Delete post <i class="fa-solid fa-trash"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>`;
    }
    if(!$posts){
        $html = "<i><span class='text-secondary'>You haven't published anything yet</span></i>";
    }
    echo json_encode($html);
}

function likePost(){
    $data = getData();
    $id_post = $data['id'];
    if (isset($_SESSION['status_login_pricture'])) {
        $id_user = $_SESSION['userdata']['id'];
        $db = new QueryModel();
        try {
            $data = [
                'id_post' => $id_post,
                'id_user' => $id_user,
            ];

            $register = $db->insert('REG_FAVORITES', $data);
            $update = $db->query('UPDATE REG_POST SET num_hearts = num_hearts + 1 WHERE id = :id', [':id' => $id_post]);
            echo json_encode($register);

        } catch (Exception $e) {
            echo json_encode('error: ' . $e->getMessage());
        }
    }else{
        echo 5;
    }
}

function unlikePost(){
    $data = getData();
    $id_post = $data['id'];
    if (isset($_SESSION['status_login_pricture'])) {
        $id_user = $_SESSION['userdata']['id'];
        $db = new QueryModel();
        try {
            $register = $db->delete('REG_FAVORITES', 'id_post = ' . $id_post . ' AND id_user = ' . $id_user);
            $update = $db->query('UPDATE REG_POST SET num_hearts = num_hearts - 1 WHERE id = :id', [':id' => $id_post]);
            echo json_encode($register);

        } catch (Exception $e) {
            echo json_encode('error: ' . $e->getMessage());
        }
    }else{
        echo 5;
    }
}

function newCommentPost(){
    $data = getData();
    if (isset($_SESSION['status_login_pricture'])) {
        $id_user = $_SESSION['userdata']['id'];
        $id_post = $data['id'];
        $db = new QueryModel();
        date_default_timezone_set('UTC');
        try {
            $data = [
                'id_post' => $id_post,
                'id_user'=> $id_user,
                'comment' => $data['comment'],
                'timestamp_create'=>date('Y-m-d H:i:s')
            ];
            $register = $db->insert('REG_COMMENTS', $data);
            $update = $db->query('UPDATE REG_POST SET num_comments = num_comments + 1 WHERE id = :id', [':id' => $id_post]);
            echo json_encode($register);

        } catch (Exception $e) {
            echo json_encode('error: '.$e->getMessage());
        }
    }else{
        echo 5;
    }
    
}

function updateCommentPost(){
    $data = getData();
    $id_post = $data['idpost'];
    $db = new QueryModel();
    try {
        $comments = $db->query("SELECT c.id, c.id_user, c.comment, c.timestamp_create, u.id AS id_user, u.img_profile, u.username 
            FROM REG_COMMENTS c 
            LEFT JOIN SYS_USER u ON c.id_user = u.id 
            WHERE c.id_post = :id_post 
            ORDER BY c.timestamp_create DESC;
        ", ["id_post"=>$id_post]);
        $html = "";

        foreach ($comments as $key => $value) {
            $imgProfile = $value['img_profile'] ? 'user/img-profile/' . $value['img_profile'] : 'system/defaultprofile.jpg';

            $html .= '<div class="d-flex flex-column gap-4">
                        <div class="d-flex gap-2">
                            <div>
                                <div class="user-post">
                                    <a href="#"><img src="./assets/img/' . $imgProfile . '" alt="image profile"></a>
                                </div>
                            </div>
                            <div class="d-flex flex-column w-100">
                                <div class="d-flex justify-content-between">
                                    <span class="user-name">
                                        <a href="user?id=1">' . $value['username'] . '</a> <span class="ms-2 text-secondary relativedate">' . $value['timestamp_create'] . '</span>
                                    </span>
                                    <span>';
            if (isset($_SESSION['status_login_pricture'])) {
                if ($_SESSION['userdata']['id'] == $value['id_user'] || $_SESSION['userdata']['id_rol'] <= 2) {
                    $html .= '<a class="text-danger cursor-pointer" data-bs-toggle="modal" data-bs-target="#confirmDeleteComment" onclick="deleteComment(' . $value['id_user'] . ',' . $value['id'] . ',' . $id_post.')"><i class="fa-solid fa-trash"></i></a>';

                }
            }

            $html .= '</span>
                                </div>
                                <span class="p-2">' . $value['comment'] . '</span>
                            </div>
                        </div>
                    </div>';
        }
        echo json_encode($html);

    } catch (Exception $e) {
        echo json_encode('error: '.$e->getMessage());
    }
}


function deleteCommentPost(){
    $data = getData();
    $id_comm = $data['id_comm'];
    $id_usercomm = $data['id_user'];
    if (isset($_SESSION['status_login_pricture'])) {
        $id_user = $_SESSION['userdata']['id'];
        if ($id_usercomm == $id_user || $id_user <= 2) {
            $db = new QueryModel();
            try {
                $register = $db->delete('REG_COMMENTS', 'id = ' . $id_comm);
                $update = $db->query('UPDATE REG_POST SET num_comments = num_comments - 1 WHERE id = :id', [':id' => $data['idpost']]);
                echo json_encode($register);

            } catch (Exception $e) {
                echo json_encode('error: ' . $e->getMessage());
            }
        }else{
            echo json_encode("Invalid request. You do not have permissions to perform this operation.");
        }
    }else{
        echo 5;
    }
    
}

function updatePosts() {
    $db = new QueryModel();
    $post = $db->query("SELECT p.*, u.username, u.img_profile FROM REG_POST p LEFT JOIN SYS_USER u ON p.id_user = u.id", []);

    $favorites = [];
    if (isset($_SESSION['status_login_pricture'])) {
        $favoritesResult = $db->query("SELECT id_post FROM REG_FAVORITES WHERE id_user = :user_id", [':user_id' => $_SESSION['userdata']['id']]);
        foreach ($favoritesResult as $favorite) {
            $favorites[] = $favorite['id_post'];
        }
    }

    $html = "";
    foreach ($post as $value) {
        $html .= '<div class="post-pink-box post d-flex flex-column gap-2">
            <div  class="d-flex w-100 justify-content-between align-items-center flex-column flex-sm-row">
                <div class="d-flex gap-2 align-items-center">
                    <div class="user-post">
                        <img src="./assets/img/' . ($value['img_profile'] ? 'user/img-profile/' . $value['img_profile'] : 'system/defaultprofile.jpg') . '" alt="image profile">
                    </div>
                    <span class="user-name"><a href="user?id=1">' . $value['username'] . '</a></span>
                </div>
                <div class="stats">
                    <a href="post?id=' . $value['id'] . '">
                        <span class="comments">' . $value['num_comments'] . ' <i class="fa-solid fa-comment"></i></span>
                    </a>
                    <span class="hearts">
                        <span class="numHearts">' . $value['num_hearts'] . '</span>
                        <i class="fa-solid fa-heart btn-like ' . (in_array($value['id'], $favorites) ? 'active' : '') . '" onclick="changeFavorite(this, ' . $value['id'] . ')"></i>
                    </span>
                </div>
            </div>
            <div>
                <a href="post?id=' . $value['id'] . '">
                    <div class="img-post">
                        <img src="./assets/img/' . ($value['img'] ? 'posts/' . $value['img'] : 'system/defaultimg.jpg') . '" alt="image">
                    </div>
                </a>
            </div>
            <div class="d-flex justify-content-between options">
                <span class="date relativedate">' . $value['timestamp_create'] . '</span>
                <span class="d-flex gap-2 d-none">
                    <a onclick="viewCollection()"><i class="fa-solid fa-images"></i></a>
                    <a onclick="addBookmark()"><i class="fa-solid fa-bookmark"></i></a>
                </span>
            </div>
            <div>
                <a href="post?id=' . $value['id'] . '"><span class="extract">' . reducirTexto($value['extract'], 110) . '</span></a>
            </div>
        </div>';
    }
    echo json_encode($html);
}


function reducirTexto($texto, $longitudMaxima) {
    $texto = strip_tags($texto);
    if (strlen($texto) > $longitudMaxima) {
        $textoReducido = substr($texto, 0, $longitudMaxima) . "[...]";
    } else {
        $textoReducido = $texto;
    }

    return $textoReducido;
}

function sendContactForm(){
    $data = getData();

    /*-ReCaptcha----------*/
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify'; 
    $recaptcha_secret = RECAPTCHA_SECRET; 
    $recaptcha_response = $data['g-recaptcha-response']; 
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); 
    $recaptcha = json_decode($recaptcha);

    if ($recaptcha->success == true) {

        $db = new QueryModel();

        require("../resources/email.php");

        $para = "contact@pricture.theblux.com";
        $asunto = "New " . $data['subject'] . " From: " . $data['name'];
        $user = "";

        if (isset($_SESSION['status_login_pricture'])) {
            $user = $_SESSION['userdata']['id'];
        }
        $mensaje = "<strong>New contact form message</strong><br><br> User id: " . $user . "<br> Email: " . $data['email'] . "<br> Message:<br> " . $data['comment'];

        sendEmailSMTP($para, $data['name'], $para, "pricture admin", $data['subject'], $mensaje, ["host" => "ngx341.inmotionhosting.com", "username" => "contact@pricture.theblux.com", "password" => "-K7prPb9#8=}", "port" => "465"]);
    }else{
        echo 6;
    }

}