<?php
$maincontent = '<div class="container-fluid">qweqwe</div>';
$navbar = '<nav class="navbar navbar-dark bg-inverse navbar-fixed-top">
    <button class="navbar-toggler hidden-sm-up float-xs-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="/**/"></button>
    <a class="navbar-brand" href onclick="mainpage(); event.preventDefault();"">首頁</a>
    <div class="collapse navbar-toggleable-xs" id="navbarResponsive">
        <ul class="nav navbar-nav">
            <li class="nav-item" onclick>
                <a class="nav-link">地圖
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li style="top:54px;" class="nav-item" onclick>
                <a class="nav-link">食物
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item" onclick>
                <a class="nav-link">旅遊</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">地區</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" onclick="alert();">Action</a>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Dropdown header</h6>
                    <a class="dropdown-item" href="#">Another action</a>
                </div>
            </li>
            <li class="nav-item float-sm-right">
                <a onclick="_logout()" class="nav-link" id="logoutButton"><span class="asd"></span></a>
            </li>
        </ul>
    </div>
</nav>
';
        // <form class="form-inline col-xs-12 col-sm-5 col-md-4 col-lg-3 float-sm-right" style="padding:0" onsubmit="_search();return false;">
        //     <button class="btn btn-outline-success" type="submit" style="width:25%">登出</button>
        // </form>
$login = '<div class="text-center" id="login" class="col-xs-4 offset-xs-4">
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

if($_GET){
    exit();
}
if ( isset($_POST) && !empty($_POST) ) {
    $data = array();
    if ( isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) ) {
        require_once 'db_connect.php';
        $query = $db->prepare("SELECT * FROM `user` WHERE `username` = ? and `password` = ?");
        $query->bind_param("ss", $username,$password);
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = crypt($password, '$6$'.$username.'$'.$password.'$');
        $query->execute();
        $query->store_result();
        if($query->num_rows()===1){
            $query->bind_result($id,$name,$contact,$username, $password,$level,$loginpcname,$loginip,$loginbrowser,$logintime,$loginkey);
            $query->fetch();
            $clientname = gethostname();
            $clientip = ipCheck();
            $clientrequesttime = $_SERVER['REQUEST_TIME'];
            $clientbrowser = $_SERVER['HTTP_USER_AGENT'];
            $md5 = md5($id.$name.$contact.$username.$password.$level.$clientname.$clientip.$clientbrowser.$clientrequesttime.$loginkey);
            $key = crypt($password, '$6$'.$md5.'$'.$loginkey.'$');
            $loginQuery = $db->prepare("update `user` set `loginip`=?,`loginbrowser`=?,`logintime`=?,`loginkey`=?,`loginpcname`=? where `id`=$id");
            $loginQuery->bind_param("ssiss",$clientip,$clientbrowser,$clientrequesttime,$key,$clientname);
            $loginQuery->execute();
            $data = array('html'=>$navbar.$maincontent,'status'=>1);
            if ( isset($_POST['remember']) && !empty($_POST['remember']) ) {
                $data['key'] = $key;
            }else{
                $data['session'] = $key;
            }
        }else{
            $data = array('status'=>0);
        }
        require_once 'db_close.php';
    } else if ( isset($_POST['logout']) && !empty($_POST['logout']) ){
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
        <?php if( isset($_COOKIE['key']) && !empty($_COOKIE['key']) ) { main(); } else { login(); } ?>
    </body>

    </html>
    <?php
}
function login(){
    echo $GLOBALS['login'];
}
function main(){ 
    echo $GLOBALS['navbar'].$GLOBALS['maincontent'];
}
function ipCheck() {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
?>
