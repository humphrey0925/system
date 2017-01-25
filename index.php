<?php
date_default_timezone_set("Asia/Taipei");
header("charset=utf-8");
$login = file_get_contents("sourcecode/loginform.min.html");
$navbar = file_get_contents("sourcecode/navbar.min.html");
$footer = file_get_contents("sourcecode/footer.min.html");
$js_run_main = file_get_contents("sourcecode/js_run.min.js");
$js_function = '<script>'.file_get_contents("sourcecode/js_function.min.js").'</script>' ;
require_once('sourcecode/maininfo.php');
$customerAdd = '';
$customerManage = '';
function processCustomerAdd(){
    $GLOBALS['customerAdd'] = '<div class="row justify-content-md-center"><div class="col-12 col-md-auto"><div class="white_shadow_box p-2"><div class="row"><div class="col-12"><a>';
    for ($i=1; $i <= 10; $i++) 
    $GLOBALS['customerAdd'] .= "$i customerAdd<br>";
    $GLOBALS['customerAdd'] .= '</a></div></div></div></div></div>';
}
function processCustomerManage(){
    $GLOBALS['customerManage'] = '<div class="row justify-content-md-center"><div class="col-12 col-md-auto"><div class="white_shadow_box p-2"><div class="row"><div class="col-12"><a>';
    for ($i=1; $i <= 10; $i++) 
    $GLOBALS['customerManage'] .= "$i customerManage<br>";
    $GLOBALS['customerManage'] .= '</a></div></div></div></div></div>';
}
processCustomerManage();
processCustomerAdd();

// status value meaning
// 0 -> login fail
// 1 -> login success
// 9 -> logout
// content
// 100 -> homepage
// 101 -> customer add
// 102 -> customer manage
// image upload
// 200 -> upload image success
// 201 -> no permission
// 202 -> image too big
// 203 -> unsupported filetype
// 204 -> network not stable
// 205 -> upload image error

if($_GET){
    header("Location: ./");
    exit();
}
// elseif (file_exists('upload/' . $_FILES['file_upload']['name'])){
//         $data = array('msg'=>'File with that name already exists.','status'=>202);
//     } 
require_once 'db_connect.php';
$data = array();
if ( !empty($_FILES) && checkCookie() && IS_AJAX ) {
    if($_FILES['image']['error'] > 0){
        $data = array('msg'=>'upload image error','status'=>205);
    } elseif (!getimagesize($_FILES['image']['tmp_name'])){
        $data = array('msg'=>'network not stable','status'=>204);
    } elseif ($_FILES['image']['type'] != 'image/png' && 
              $_FILES['image']['type'] != 'image/pjpeg' && 
              $_FILES['image']['type'] != 'image/gif' && 
              $_FILES['image']['type'] != 'image/jpeg'){
        $data = array('msg'=>'unsupported filetype','status'=>203);
    } elseif ($_FILES['image']['size'] > 5120000){
        $data = array('msg'=>'image too big','status'=>202);
    } else {
        $imagename = '';
        if ( isset($_POST) && !empty($_POST) ){
            if ( isset($_POST['upload']) && !empty($_POST['upload']) && $_POST['upload']=="userimage") {
                $imagename = getCurrentUser('username').'.'.pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            }
        }else{
            $imagename = $_FILES['image']['name'];
        }
        removeImage($imagename);
        if ( !move_uploaded_file($_FILES['image']['tmp_name'], 'img/upload/' . $imagename )){
            $data = array('msg'=>'no permission','status'=>201);
        } else{
            $id = getCurrentUser('id');
            $loginQuery = $db->prepare("update `user` set `image`=? where `id`=$id");
            $loginQuery->bind_param("s",$imagename);
            $loginQuery->execute();
            $data = array('msg'=>'upload image success.','status'=>200,'image_path'=>'img/upload/' . $imagename);
        }
    }
    echo json_encode($data);
} elseif ( isset($_POST) && !empty($_POST) ) {
    if (isset($_POST['get']) && !empty($_POST['get']) && IS_AJAX) {
        if (checkCookie()) {
            if ($_POST['get']=='main') {
                main('main');
                $data = array('html'=>$maininfo,'status'=>100);
            }elseif ($_POST['get']=='customerAdd') {
                $data = array('html'=>$customerAdd,'status'=>101);
            }elseif ($_POST['get']=='customerManage') {
                $data = array('html'=>$customerManage,'status'=>102);
            }
        }else{
            $data = array('status'=>9,'html'=>$login);
        }
    } elseif ( isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) && IS_AJAX ) {
        $query = $db->prepare("SELECT `id`,`name`,`contact`,`username`,`password`,`level`,`userstatus`,`loginstatus`,`loginpcname`,`loginip`,`loginbrowser`,`logintime`,`loginkey`,`prevpcname`,`previp`,`prevbrowser`,`prevtime`,`prevkey`,`image` FROM `user`
 WHERE `username` = ? and `password` = ?");
        $query->bind_param("ss", $username,$password);
        $username = strtolower($_POST['username']);
        $password = $_POST['password'];
        $password = crypt($password, '$6$'.$username.'$'.$password.'$');
        $query->execute();
        $query->store_result();
        if($query->num_rows()===1){
            $query->bind_result(
                $id,
                $name,
                $contact,
                $username,
                $password,
                $level,
                $userstatus,
                $loginstatus,
                $loginpcname,
                $loginip,
                $loginbrowser,
                $logintime,
                $loginkey,
                $prevpcname,
                $previp,
                $prevbrowser,
                $prevtime,
                $prevkey,
                $img
            );
            $query->fetch();
            $clientname = gethostname();
            $clientip = checkIP();
            $clientrequesttime = $_SERVER['REQUEST_TIME'];
            if(strpos($_SERVER["HTTP_USER_AGENT"],"MSIE"))
                $clientbrowser = "IE";
            elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Firefox"))
                $clientbrowser = "Firefox";
            elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Chrome"))
                $clientbrowser = "Chrome";
            elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Safari"))
                $clientbrowser = "Safari";
            elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Opera"))
                $clientbrowser = "Opera";
            else $clientbrowser = 'N/A';
            
            $md5 = md5(
                $id.
                $name.
                $contact.
                $username.
                $password.
                $level.
                $clientname.
                $clientip.
                $clientbrowser.
                $clientrequesttime.
                $loginkey
            );
            $key = crypt($password, '$6$'.$md5.'$'.$loginkey.'$');
            $loginQuery = $db->prepare("
                update `user` set `loginip`=?,`loginbrowser`=?,`logintime`=?,`loginkey`=?,`loginpcname`=?,`previp`=?,`prevbrowser`=?,`prevtime`=?,`prevkey`=?,`prevpcname`=?,`loginstatus`=1 where `id`=$id");
            $loginQuery->bind_param(
                "ssissssiss",
                $clientip,
                $clientbrowser,
                $clientrequesttime,
                $key,
                $clientname,
                $loginip,
                $loginbrowser,
                $logintime,
                $loginkey,
                $loginpcname
            );
            $loginQuery->execute();
            processMainInfo(
                $name,
                $contact,
                $loginpcname,
                $loginip,
                $loginbrowser,
                $logintime,
                $prevpcname,
                $previp,
                $prevbrowser,
                $prevtime,
                $img
            );
            $data = array('html'=>$navbar.'<div class="container-fluid">'.$maininfo.'</div>'.$footer.$js_function,'status'=>1,'tmp'=>$js_run_main);
            if ( isset($_POST['remember']) && 
                !empty($_POST['remember']) ) {
                $data['key'] = $key;
            }else{
                $data['session'] = $key;}
            $loginQuery->close();
        }else{
            $data = array('status'=>0);
        }
        $query->close();
    } else { // logout code
        if (isset($_COOKIE['key'])&&!empty($_COOKIE['key']) || isset($_COOKIE['session'])&&!empty($_COOKIE['session'])) {
            $query = $GLOBALS['db']->prepare("UPDATE `user` set `loginstatus`=0 WHERE `loginkey` = ?");
            if (isset($_COOKIE['key'])&&!empty($_COOKIE['key'])) {
                $query->bind_param("s", $_COOKIE['key']);}
            elseif (isset($_COOKIE['session'])&&!empty($_COOKIE['session'])){
                $query->bind_param("s", $_COOKIE['session']);}
            else{
                $query->bind_param("s", $_POST['logout']);}
            $query->execute();
            $query->close();
        }
        $data = array('status'=>9,'html'=>$login);
    }
    echo json_encode($data);
} else {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0" />
        <title>隆易水電工程</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/metro-icons.min.css">
        <link rel="stylesheet" href="css/custom.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <script src="js/jquery-3.1.0.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/tether.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/custom.min.js" type="text/javascript" charset="utf-8" async defer></script>
    </head>

    <body>
        <?php if( checkCookie() ) { main(); } else { login(); } ?>
    </body>
    </html>
    <?php
}
function login(){
    echo $GLOBALS['login'];
}
function main($mode=''){ 
    $query = $GLOBALS['db']->prepare("SELECT `id`,`name`,`contact`,`username`,`password`,`level`,`userstatus`,`loginstatus`,`loginpcname`,`loginip`,`loginbrowser`,`logintime`,`loginkey`,`prevpcname`,`previp`,`prevbrowser`,`prevtime`,`prevkey`,`image` FROM `user`
 WHERE `loginkey` = ?");
    $query->bind_param("s", getKey());
    $query->execute();
    $query->store_result();
    $query->bind_result(
        $id,
        $name,
        $contact,
        $username, 
        $password,
        $level,
        $userstatus,
        $loginstatus,
        $loginpcname,
        $loginip,
        $loginbrowser,
        $logintime,
        $loginkey,
        $prevpcname,
        $previp,
        $prevbrowser,
        $prevtime,
        $prevkey,
        $img
    );
    $query->fetch();
    processMainInfo(
        $name,
        $contact,
        $loginpcname,
        $loginip,
        $loginbrowser,
        $logintime,
        $prevpcname,
        $previp,
        $prevbrowser,
        $prevtime,
        $img
    );
    if ( $mode == '' ) {
        // echo $GLOBALS['navbar'].$GLOBALS['maininfo'].$GLOBALS['footer'].$GLOBALS['js_function'].'<script>'.$GLOBALS['js_run_main'].'</script>';
        echo $GLOBALS['navbar'].'<div class="container-fluid">'.$GLOBALS['customerManage'].'</div>'.$GLOBALS['footer'].$GLOBALS['js_function'].'<script>'.$GLOBALS['js_run_main'].'</script>';
    }
    $query->close();
}
function checkIP() {
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
    } elseif (getenv('HTTP_FORWARDED')) {
         $ip = getenv('HTTP_FORWARDED');
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
function checkCookie(){
    if (isset($_COOKIE['key'])&&!empty($_COOKIE['key']) || isset($_COOKIE['session'])&&!empty($_COOKIE['session'])) {
        $query = $GLOBALS['db']->prepare("SELECT `loginkey` FROM `user` WHERE `loginkey` = ?");
        $query->bind_param("s", getKey());
        $query->execute();
        $query->store_result();
        if($query->num_rows()===1){
            $query->close();
            return true;
        }else{
            $query->close();
            setcookie("key", '', 0,'/');
            return false;
        }
    } else {
        return false;
    }
}
function getKey(){
    if(isset($_COOKIE['key'])&&!empty($_COOKIE['key']))
        return $_COOKIE['key'];
    else
        return $_COOKIE['session'];
}
function getCurrentUser($col){
    if (checkCookie()) {
        $query = $GLOBALS['db']->prepare("SELECT `$col` FROM `user` WHERE `loginkey` = ?");
        $query->bind_param("s", getKey());
        $query->execute();
        $query->store_result();
        $query->bind_result($data);
        $query->fetch();
        $query->close();
        return $data;
    }
    return "qweasd";
}
function removeImage($imagename){
    $img = array('jpg','jpeg','gif','png');
    $ext = pathinfo($imagename, PATHINFO_EXTENSION);
    $name = basename($imagename,$ext);
    foreach ($img as $value) {
        $image = $name.$value;
        if(file_exists('img/upload/'.$image)) {
            chmod('img/upload/'.$image,0755);
            unlink('img/upload/'.$image);
        }
    }
}
require_once 'db_close.php';
?>
