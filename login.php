<?php
if ( isset($_POST)  && !empty($_POST) ) {
    echo date("l y/m/d h:i:sa",$_SERVER['REQUEST_TIME'])."\n";
    if ( isset($_POST['username'])  && !empty($_POST['username']) && isset($_POST['password'])  && !empty($_POST['password']) ) {
        require_once 'db_connect.php';
        $query = $db->prepare("SELECT *  FROM `user` WHERE `username` = ? and `password` = ?");
        $query->bind_param("ss", $username,$password);
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query->execute();
        $query->store_result();
        if($query->num_rows()===1){
            $query->bind_result($id,$username, $password,$level,$loginip,$loginbrowser,$logintime,$loginkey);
            while ($query->fetch()) {
                echo "ID: $id\n";
                echo "username: $username\n";
                echo "password: $password\n";
                echo "level: $level\n";
                echo "loginip: $loginip\n";
                echo "loginbrowser: $loginbrowser\n";
                echo "logintime: $logintime\n";
                echo "loginkey: $loginkey\n";
            }
            setcookie("key", md5($id.$username.$password.$level.$loginip.$loginbrowser.$logintime.$loginkey),time() + 60*60*24*365,"/");
        }
        require_once 'db_close.php';
    } else {
        echo 'qwe';
    }
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
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
        <?php
        if( isset($_COOKIE['key']) && !empty(isset($_COOKIE['key'])) ) { ?>
            <nav class="navbar navbar-dark bg-inverse navbar-fixed-top">
                <button class="navbar-toggler hidden-sm-up float-xs-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="/**/"></button>
                <a class="navbar-brand" href onclick="mainpage(); event.preventDefault();">首頁</a>
                <div class="collapse navbar-toggleable-xs" id="navbarResponsive">
                    <ul class="nav navbar-nav">
                        <li class="nav-item" onclick='_loadMap();'><a class="nav-link">地圖<span class="sr-only">(current)</span></a></li>
                        <li style="top:54px;" class="nav-item" onclick='_getData("food",0);'><a class="nav-link">食物<span class="sr-only">(current)</span></a></li>
                        <li class="nav-item" onclick='_getData("travel",0)'><a class="nav-link">旅遊</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">地區</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="alert();">Action</a>
                                <div class="dropdown-divider"></div>    
                                <h6 class="dropdown-header">Dropdown header</h6>
                                <a class="dropdown-item" href="#">Another action</a>
                            </div>
                        </li>
                    </ul>
                    <form class="form-inline col-xs-12 col-sm-5 col-md-4 col-lg-3 float-sm-right" style="padding:0" onsubmit="_search();return false;">
                        <input class="form-control" placeholder="Search" style="width:75%;float:left">
                        <button class="btn btn-outline-success" type="submit" style="width:25%">搜索</button>
                    </form>
                </div>
            </nav>
            <div class="container-fluid">
                <?php echo "Cookie named '" . $_COOKIE['key'] . "' is not set!\n"; ?>
            </div>
            <?php } else { ?>
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
                            <p><a href="#">forgot your password?</a></p>
                        </div>
                    </form>
                </div>
                <!-- end:Main Form -->
            </div>
            <?php
} ?>
    </body>

    </html>
    <?php
}
?>
