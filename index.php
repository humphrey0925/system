<?php
date_default_timezone_set('Asia/Taipei');
header('charset=utf-8');
$login = '
<div id="login">
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
                    <a href>forgot your password?</a>
                </p>
            </div>
        </form>
    </div>
</div>
';
$navbar = '
<nav class="navbar navbar-toggleable navbar-inverse bg-inverse bg-faded fixed-top">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navDrop" aria-controls="navDrop" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href onclick="getData(\'main\')">首頁</a>
    <div class="collapse navbar-collapse" id="navDrop">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navProject" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">工程</a>
                <div class="dropdown-menu" aria-labelledby="navProject">
                    <h6 class="dropdown-header">新增</h6>
                    <a class="dropdown-item" href>工程</a>
                    <a class="dropdown-item" href>水電進度</a>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">查詢</h6>
                    <a class="dropdown-item" href>工程進度</a>
                    <a class="dropdown-item" href>材料狀態</a>
                    <a class="dropdown-item" href>水電進度</a>
                    <a class="dropdown-item" href>結案工程</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">愛惠浦</a>
                <div class="dropdown-menu">
                    <h6 class="dropdown-header">濾芯更換</h6>
                    <a class="dropdown-item" href>查詢</a>
                    <a class="dropdown-item" href>需求增加</a>
                    <a class="dropdown-item" href>結案列表</a>
                    <h6 class="dropdown-header">客戶</h6>
                    <a class="dropdown-item" href onclick="getData(\'customerAdd\')">增加</a>
                    <a class="dropdown-item" href onclick="getData(\'customerManage\')">管理</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">記事</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href>公司記事</a>
                    <a class="dropdown-item" href>工程記事</a>
                </div>
            </li>
        </ul>
        <span class="navbar-text logoutButton">
            <a onclick="_logout()" class="nav-item" id="logoutButton">
                <span></span>
            </a>
        </span>
    </div>
    <style>
    body {
        padding-top: 70px;
    }
    
    .navbar {
        max-height: 100%;
    }
    
    #navDrop {
        max-height: 100%;
        overflow-y: auto;
    }
    
    .logoutButton {
        width: 100%;
        cursor: pointer;
    }
    
    #logoutButton {
        color: #F2F2F2;
        width: 100%;
        height: 100%;
    }
    
    #logoutButton span:before {
        content: "登出";
    }
    
    @media screen and (min-width:576px) {
        #navDrop {
            overflow-y: initial;
        }

        .logoutButton {
            width: 40px;
            padding: 0;
        }
        #logoutButton {
            border-radius: 50px;
            text-align: center;
            border: 4px solid #efefef;
            display: block;
        }
        #logoutButton:hover {
            border: 4px solid red;
        }
        #logoutButton span {
            position: relative;
            font-family: metro;
            top: 5px;
            left: -1.5px;
        }
        #logoutButton span:before {
            content: "\ea13";
        }
    }
    </style>
</nav>
';
$maininfo = '';
function processMainInfo($id,$name,$contact,$username, $password,$level,$loginpcname,$loginip,$loginbrowser,$logintime,$loginkey,$prevpcname,$previp,$prevbrowser,$prevtime,$prevkey,$img){
    $tmpstr1 = ($img=='') ? 'profileblank.jpg' : 'upload/'.$img ;
    $tmpstr2 = ($img=='') ? '<input id="userimgupload" type="file" style="visibility:hidden;position:absolute" onchange="imageUpload(this)" accept="image/*"/><div id="userimghover" onclick="$(\'#userimgupload\').click();" style="cursor:pointer;"></div>' : '' ;
    $GLOBALS['maininfo'] = '

    <div class="row">
        <div class="col-12 col-md-4 text-center">
            <div class="white_shadow_box" style="padding-top:15px;">
                <div id="userimg" style="margin-bottom:10px;box-shadow: 1px 1px 10px grey;background-image:url(\'img/'.$tmpstr1.'\')">'.$tmpstr2.'</div>
                <div style="margin-top: 5px;padding: 20px 0;background-color: skyblue;">
                    <h3 style="margin:0;padding-bottom:5px;">'.$name.'</h3>
                    <h4 style="margin:0;padding-top:5px;">'.$contact.'</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 text-center login_info">
            <div class="row">
                <div class="col-12">
                    <div class="white_shadow_box" style="padding: 10px 0 0px 0;">
                        <div class="row">
                            <div class="col-12" style="padding: 0 0 5px 0;">
                                <h2 style="margin:0;">登錄訊息</h2>
                            </div>
                            <div class="col-12 col-sm-6" id="prevLoginInfo">
                                <div>
                                    <h4>上次登錄</h4>
                                    <p>'.$prevbrowser.'</p>
                                    <p>'.$prevpcname.'</p>
                                    <p>'.$previp.'</p>
                                    <p>'.date("l y/m/d h:i:sa",$prevtime).'</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6" id="currLoginInfo">
                                <div>
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
    </div>
    <style>
    @media screen and (min-width:576px) {
        #prevLoginInfo {
            padding-right: 0;
        }
        #currLoginInfo {
            padding-left: 0;
        }
    }
    
    #prevLoginInfo > div {
        background-color: antiquewhite;
        padding: 0 0 5px 0;
    }
    
    #currLoginInfo > div {
        background-color: lightcyan;
        padding: 0 0 5px 0;
    }
    
    .row,
    .col,
    .col-1,
    .col-10,
    .col-11,
    .col-12,
    .col-2,
    .col-3,
    .col-4,
    .col-5,
    .col-6,
    .col-7,
    .col-8,
    .col-9,
    .col-lg,
    .col-lg-1,
    .col-lg-10,
    .col-lg-11,
    .col-lg-12,
    .col-lg-2,
    .col-lg-3,
    .col-lg-4,
    .col-lg-5,
    .col-lg-6,
    .col-lg-7,
    .col-lg-8,
    .col-lg-9,
    .col-md,
    .col-md-1,
    .col-md-10,
    .col-md-11,
    .col-md-12,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-5,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-sm,
    .col-sm-1,
    .col-sm-10,
    .col-sm-11,
    .col-sm-12,
    .col-sm-2,
    .col-sm-3,
    .col-sm-4,
    .col-sm-5,
    .col-sm-6,
    .col-sm-7,
    .col-sm-8,
    .col-sm-9,
    .col-xl,
    .col-xl-1,
    .col-xl-10,
    .col-xl-11,
    .col-xl-12,
    .col-xl-2,
    .col-xl-3,
    .col-xl-4,
    .col-xl-5,
    .col-xl-6,
    .col-xl-7,
    .col-xl-8,
    .col-xl-9,
    .container-fulid {
        transition: initial;
    }
    
    .login_info p {
        margin-top: 5px;
        margin-bottom: 5px;
    }
    
    .login_info h4 {
        margin-top: 0;
        margin-bottom: 0;
        padding-top: 10px;
        padding-bottom: 10px;
        background-color: lightblue;
    }
    
    .login_info .col-6 > div {
        box-shadow: 1px 1px 5px grey;
        width: 100%;
    }
    
    .white_shadow_box {
        background-color: #FCFCFC;
        box-shadow: 1px 1px 5px grey;
    }
    
    #userimg {
        width: 70%;
        border-radius: 999999px;
        background-image: url("../img/profileblank.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        left: 0;
        right: 0;
        margin: auto;
    }
    
    #userimghover {
        width: 100%;
        height: 100%;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        position: relative;
        border-radius: 999999px;
        opacity: 0;
        background-color: transparent;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-image: url("../img/upload.png");
        transition: opacity ease-in-out 750ms;
    }
    
    #userimghover:hover {
        opacity: 0.35;
    }
    </style>

';
}
$customerAdd = '';
function processCustomerAdd(){
    $GLOBALS['customerAdd'] = '
    <div class="row justify-content-md-center">
        <div class="col col-lg-2">
            1 of 3
        </div>
        <div class="col-12 col-md-auto">
            Variable width content
        </div>
        <div class="col col-lg-2">
            3 of 3
        </div>
    </div>
    <div class="row">
        <div class="col">
            1 of 3
        </div>
        <div class="col-12 col-md-auto">
            Variable width content
        </div>
        <div class="col col-lg-2">
            3 of 3
        </div>
    </div>
';
}

$customerManage = '';
function processCustomerManage(){
    $GLOBALS['customerManage'] = '
    <div class="row justify-content-md-center">
        <div class="col col-lg-2">
            1 of 3
        </div>
        <div class="col-12 col-md-auto">
            Variable width content
        </div>
        <div class="col col-lg-2">
            3 of 3
        </div>
    </div>
    <div class="row">
        <div class="col">
            1 of 3
        </div>
        <div class="col-12 col-md-auto">
            Variable width content
        </div>
        <div class="col col-lg-2">
            3 of 3
        </div>
    </div>
';
}
processCustomerManage();
processCustomerAdd();

$footer = '
<footer>
    <div class="text-center">
        <hr>
        <h6>2017© Copyright 隆易水電工程有限公司提醒您 私自竊取資料系屬違法 請勿以身試法</h6>
    </div>
    <style>
    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
    }
    
    footer>div {
        background-color: #efefef;
        padding: 0px 15px 5px 15px;
    }
    
    .container-fluid {
        margin-bottom: 88px;
    }
    
    footer h6 {
        font-size: 80%;
    }
    
    @media screen and (min-width:283px) {
        .container-fluid {
            margin-bottom: 74px;
        }
    }
    
    @media screen and (min-width:500px) {
        .container-fluid {
            margin-bottom: 74px;
        }
        footer h6 {
            font-size: 85%;
        }
    }
    
    @media screen and (min-width:576px) {
        .container-fluid {
            margin-bottom: 61px;
        }
        footer h6 {
            font-size: 89.5%;
        }
    }
    </style>
</footer>
<div class="load-bar">
    <div class="bar"></div>
    <div class="bar"></div>
    <div class="bar"></div>
    <style>
    .load-bar {
        width: 100%;
        height: 6px;
        background-color: #fdba2c;
        position: fixed;
        bottom: 0;
        display: none;
        opacity: 0;
        transition: initial;
    }
    
    .bar {
        content: "";
        display: inline;
        position: absolute;
        width: 0;
        height: 100%;
        left: 50%;
        text-align: center;
    }
    
    .bar:nth-child(1) {
        background-color: #da4733;
        animation: loading 3s linear infinite;
    }
    
    .bar:nth-child(2) {
        background-color: #3b78e7;
        animation: loading 3s linear 1s infinite;
    }
    
    .bar:nth-child(3) {
        background-color: #fdba2c;
        animation: loading 3s linear 2s infinite;
    }
    
    @keyframes loading {
        from {
            left: 50%;
            width: 0;
            z-index: 100;
        }
        33.3333% {
            left: 0;
            width: 100%;
            z-index: 10;
        }
        to {
            left: 0;
            width: 100%;
        }
    }
    </style>
</div>
';

$js_run_main='$(window).resize(function(event) {    if ($.cookie("key") || $.cookie("session")) { _initMain(); };});_initMain();';

$js_function = '
<script>
function _initMain() {
    navMaxHeight();
    if ($("#userimg").length) {
        $("#userimg").css("height", $("#userimg").css("width"));
    }
}

function navMaxHeight() {
    // $(".navbar-toggleable").css("max-height", _height() - 54);
}

function imageUpload(el) {
    var data = new FormData();
    data.append("image", el.files[0]);
    data.append("asd", "asdwqe");
    $.ajax({
            data: data
        })
        .always(function(data) {
            if (data.status == 200) {
                $("#userimghover").remove();
                $("#userimgupload").remove();
                $("#userimg").css("background-image", "url(\"" + data.image_path + "\")");
            }
        });
}

function getData(type) {
    event.preventDefault();
    var data = new FormData();
    data.append("get", type);
    $.ajax({
            data: data,
            beforeSend: function() {
                $(".container-fluid").animate({ opacity: 0 }, 200);
            }
        })
        .done(function(data) {
            if (data.status == 9) {
                        $("body").text("").append(data.html);
                        _initLoginForm();
                        $.removeCookie("key", {
                            path: "/"
                        });
                        $.removeCookie("session", {
                            path: "/"
                        });
            } else if (data.status >= 100 && data.status <= 102) {
                        $(".container-fluid").text("");
                        $(".container-fluid").append(data.html);
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
    data.append("logout", "");
    $.ajax({
            data: data
        })
        .always(function(data) {
            $("body").animate({
                    opacity: 0
                },
                200,
                function() {
                    $("body").text("").append(data.html);
                    _initLoginForm();
                    $.removeCookie("key", {
                        path: "/"
                    });
                    $.removeCookie("session", {
                        path: "/"
                    });
                    $(this).animate({
                            opacity: 1
                        },
                        200);
                });
        });
}
</script>
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
        <link rel="stylesheet" href="css/font-awesome.min.css">
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
        <link rel="stylesheet" href="css/custom.css">

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
    if (isset($_COOKIE['key'])&&!empty($_COOKIE['key'])) {
        $query = $GLOBALS['db']->prepare("SELECT ? FROM `user` WHERE `loginkey` = ?");
        $query->bind_param("ss",$col, getKey());
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
