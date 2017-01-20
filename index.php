<?php
date_default_timezone_set('Asia/Taipei');
header('charset=utf-8');
$maininfo = '';
function proccessMainInfo($id,$name,$contact,$username, $password,$level,$loginpcname,$loginip,$loginbrowser,$logintime,$loginkey,$prevpcname,$previp,$prevbrowser,$prevtime,$prevkey,$img){
    $tmpstr1 = ($img=='') ? 'profileblank.jpg' : 'upload/'.$img ;
    $tmpstr2 = ($img=='') ? '<input id="userimgupload" type="file" style="visibility:hidden;position:absolute" onchange="imageUpload(this)" accept="image/*"/><div id="userimghover" onclick="$(\'#userimgupload\').click();" style="cursor:pointer;"></div>' : '' ;
    $GLOBALS['maininfo'] = '
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-xs-center">
            <h1 style="margin:10px auto 20px;;">歡迎使用本系統</h1>
        </div>
    </div>
    <div class="row">
        <style>
        .login_info h4{
            margin-top:0;
            margin-bottom:0;
            padding-top:10px;
            padding-bottom:10px;
            background-color:lightblue;
        }
        .login_info .col-xs-6 > div {
            box-shadow: 1px 1px 5px grey;
            display: inline-block;
            width:100%;
        }
        .white_shadow_box{
            background-color: #FCFCFC;
            box-shadow: 1px 1px 5px grey;
            display: inline-block;
            width:100%
        }
        </style>
        <div class="col-xs-12 col-md-4 text-xs-center">
            <div class="white_shadow_box">
                <div id="userimg" style="margin-top:15px;margin-bottom:10px;box-shadow: 1px 1px 10px grey;background-image:url(\'img/'.$tmpstr1.'\')">'.$tmpstr2.'</div>
                <div style="margin-top: 5px;padding: 20px 0;background-color: skyblue;">
                    <h3 style="margin:0;padding-bottom:5px;">'.$name.'</h3>
                    <h4 style="margin:0;padding-top:5px;">'.$contact.'</h4>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-8 text-xs-center">
            <div class="row">
                <div class="col-xs-12 login_info">
                    <div class="white_shadow_box" style="padding:15px 0">
                        <div class="col-xs-12">
                            <h2 style="margin-bottom:10px;">登錄訊息</h2>
                        </div>
                        <div class="col-xs-6">
                            <div style="background-color: antiquewhite;">
                                <h4>上次登錄</h4>
                                <p>'.$prevbrowser.'</p>
                                <p>'.$prevpcname.'</p>
                                <p>'.$previp.'</p>
                                <p>'.date("l y/m/d h:i:sa",$prevtime).'</p>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div style="background-color: lightcyan;">
                                <h4>本次登錄</h4>
                                <p>'.$loginbrowser.'</p>
                                <p>'.$loginpcname.'</p>
                                <p>'.$loginip.'</p>
                                <p>'.date("l y/m/d h:i:sa",$logintime).'</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-xs-center">
            <h4>使用後請登出</h4>
        </div>
    </div>
</div>

';
}
$js_run_main='
$(window).resize(function(event) {
    if ($.cookie("key") || $.cookie("session")) {
        _initMain();
    }
});
_initMain();
';
$js_function = '<script>
function _initMain() {
    navMaxHeight();
    if ($("#userimg").length) {
        $("#userimg").css("height", $("#userimg").css("width"));
    }
}
function navMaxHeight() {
    $(".navbar-toggleable-xs").css("max-height", _height() - 54);
}


function imageUpload(el) {
    var data = new FormData();
    data.append("image", el.files[0]);
    data.append("asd", "asdwqe");
    $.ajax({
            data: data
        })
        .done(function(data) {})
        .fail(function() {})
        .always(function(data) {
            if (data.status == 200) {
                $("#userimghover").remove();
                $("#userimgupload").remove();
                $("#userimg").css("background-image", "url(\"" + data.image_path + "\")");
            }
        });
}

function getData(type) {
    var data = new FormData();
    data.append("get", type);
    $.ajax({
            data: data
        })
        .done(function(data) {
            if (data.status == 9) {
                $("body").text("").append(data.html);
                _initLoginForm();
                $.removeCookie("key", { path: "/" });
                $.removeCookie("session", { path: "/" });
            } else if (data.status >= 100 && data.status <= 102) {
                $(".container-fluid").remove();
                $("nav.navbar").after(data.html);
                if (data.status == 100) {
                    _initMain();
                }
            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

}

function _logout() {
    var data = new FormData();
    data.append("logout", $.cookie("key"));
    $.ajax({
            data: data
        })
        .done(function(data) {
            $("body").text("").append(data.html);
            _initLoginForm();
            $.removeCookie("key", { path: "/" });
            $.removeCookie("session", { path: "/" });
        })
        .fail(function(data) {
            console.log(data);
        })
        .always(function(data) {
            console.log("complete");
        });

}
</script>
';

$footer = '<footer style="padding: 0 15px">
    <div class="text-xs-center">
        <hr>
        <h6 style="font-size:80%;">2017© Copyright 隆易水電工程有限公司提醒您 私自竊取資料系屬違法 請勿以身試法</h6>
    </div>
</footer>
';
$navbar = '
<nav class="navbar navbar-dark bg-inverse navbar-fixed-top">
    <button class="navbar-toggler hidden-sm-up float-xs-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="/**/"></button>
    <a class="navbar-brand" href="#" onclick="getData(\'main\')">首頁
        <span class="sr-only">(current)</span>
    </a>
    <div class="collapse navbar-toggleable-xs" id="navbarResponsive">
        <ul class="nav navbar-nav">
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">工程</a>
                <div class="dropdown-menu">
                    <h6 class="dropdown-header">新增</h6>
                    <a class="dropdown-item" href="#">工程</a>
                    <a class="dropdown-item" href="#">水電進度</a>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">查詢</h6>
					<a class="dropdown-item" href="#">工程進度</a>
                    <a class="dropdown-item" href="#">材料狀態</a>
                    <a class="dropdown-item" href="#">水電進度</a>
                    <a class="dropdown-item" href="#">結案工程</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">愛惠浦</a>
                <div class="dropdown-menu">
                    <h6 class="dropdown-header">濾芯更換</h6>
                    <a class="dropdown-item" href="#">查詢</a>
                    <a class="dropdown-item" href="#">需求增加</a>
                    <a class="dropdown-item" href="#">結案列表</a>
					<h6 class="dropdown-header">客戶</h6>
                    <a class="dropdown-item" href="#" onclick="getData(\'customerAdd\')">增加</a>
                    <a class="dropdown-item" href="#" onclick="getData(\'customerManage\')">管理</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">記事</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">公司記事</a>
                    <a class="dropdown-item" href="#">工程記事</a>
                </div>
            </li>
            
            <li class="nav-item float-sm-right">
                <a onclick="_logout()" class="nav-link" id="logoutButton">
                    <span></span>
                </a>
            </li>
        </ul>
    </div>
</nav>
';
$login = '
<div class="text-center" id="login" class="col-xs-4 offset-xs-4">
    <div class="logo">login</div>
    <div class="login-form-1">
        <form id="login-form" class="text-left">
            <div class="login-form-main-message"></div>
            <div class="main-login-form">
                <div class="login-group">
                    <div class="form-group">
                        <label for="username" class="sr-only">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="username">
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="password">
                    </div>
                    <div class="form-group login-group-checkbox">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">remember</label>
                    </div>
                </div>
                <button type="submit" class="login-button" style="cursor: pointer;"><i class="fa fa-chevron-right"></i></button>
            </div>
            <div class="etc-login-form">
                <p>
                    <a href="#">forgot your password?</a>
                </p>
            </div>
        </form>
    </div>
</div>
';
// status value meaning
// 0 -> login fail
// 1 -> login success
// 9 -> logout
// 100 -> homepage
// 101 -> customer add
// 102 -> customer manage
// 200 -> upload image success
// 201 -> no permission
// 202 -> image too big
// 203 -> unsupported filetype
// 204 -> network not stable
// 205 -> upload image error

if($_GET){
    echo '<pre>';
    exit();
}
// elseif (file_exists('upload/' . $_FILES['file_upload']['name'])){
//         $data = array('msg'=>'File with that name already exists.','status'=>202);
//     } 
require_once 'db_connect.php';
$data = array();
if ( !empty($_FILES) && checkCookie() ) {
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
            if ( isset($_POST['type']) && !empty($_POST['type']) ) {
                
            } else {
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
    if (isset($_POST['get']) && !empty($_POST['get'])) {
        if (checkCookie()) {
            if ($_POST['get']=='main') {
                main('main');
                $data = array('html'=>$maininfo,'status'=>100);
            }elseif ($_POST['get']=='customerAdd') {
                # code...
            }elseif ($_POST['get']=='customerManage') {
                # code...
            }
        }else{
            $data = array('status'=>9,'html'=>$login);
        }
    } elseif ( isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) ) {
        $query = $db->prepare("SELECT * FROM `user` WHERE `username` = ? and `password` = ?");
        $query->bind_param("ss", $username,$password);
        $username = $_POST['username'];
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
            proccessMainInfo(
                $id,
                $name,
                $contact,
                $username, 
                $password,
                $level,
                $clientname,
                $clientip,
                $clientbrowser,
                $clientrequesttime,
                $key,
                $loginpcname,
                $loginip,
                $loginbrowser,
                $logintime,
                $loginkey,
                $img
            );
            $data = array('html'=>$navbar.$maininfo.$footer.$js_function,'status'=>1,'tmp'=>$js_run_main);
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
        if (isset($_COOKIE['key'])&&!empty($_COOKIE['key'])) {
            $query = $GLOBALS['db']->prepare("UPDATE `user` set `loginstatus`=0 WHERE `loginkey` = ?");
            $query->bind_param("s", $_COOKIE['key']);
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
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel='stylesheet' href='css/css.css' type='text/css'>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/metro-icons.min.css">
        <link rel="stylesheet" href="css/custom.css">
        <script src="js/jquery-3.1.0.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/tether.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.cookie.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/custom.js" type="text/javascript" charset="utf-8" async defer></script>
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
    $query = $GLOBALS['db']->prepare("SELECT * FROM `user` WHERE `loginkey` = ?");
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
    proccessMainInfo(
        $id,
        $name,
        $contact,
        $username, 
        $password,
        $level,
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
    if ( $mode == '' ) {
        echo $GLOBALS['navbar'].$GLOBALS['maininfo'].$GLOBALS['footer'].$GLOBALS['js_function'].'<script>'.$GLOBALS['js_run_main'].'</script>';
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
    if (isset($_COOKIE['key'])&&!empty($_COOKIE['key'])) {
        $query = $GLOBALS['db']->prepare("SELECT `$col` FROM `user` WHERE `loginkey` = ?");
        $query->bind_param("s", getKey());
        $query->execute();
        $query->store_result();
        if($query->num_rows()===1){
            $query->bind_result($data);
            $query->fetch();
            $query->close();
            return $data;
        }
    }
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
