<?php

function login(){
    echo $GLOBALS['login'];
}
function main($mode=''){ 
    $query = $GLOBALS['db']->prepare("SELECT `id`,`name`,`contact`,`username`,`password`,`level`,`userstatus`,`loginstatus`,`loginpcname`,`loginip`,`loginbrowser`,`logintime`,`loginkey`,`prevpcname`,`previp`,`prevbrowser`,`prevtime`,`prevkey`,`image` FROM `user`
 WHERE `loginkey` = ?");
    $query->bind_param("s", getKey());
    $query->execute();
    $query->store_result();
    $query->bind_result($id,$name,$contact,$username, $password,$level,$userstatus,$loginstatus,$loginpcname,$loginip,$loginbrowser,$logintime,$loginkey,$prevpcname,$previp,$prevbrowser,$prevtime,$prevkey,$img
    );
    $query->fetch();
    processMainInfo($name,$contact,$loginpcname,$loginip,$loginbrowser,$logintime,$prevpcname,$previp,$prevbrowser,$prevtime,$img
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
    return 0;
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
?>
