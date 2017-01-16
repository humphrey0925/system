<?php
if ( isset($_POST)  && !empty($_POST) ) {
    header('Content-Type:text/plain');
    print_r($_POST);
    echo date("l y/m/d h:i:sa",$_SERVER['REQUEST_TIME'])."\n";
    require_once 'db_connect.php';
    $query = $db->prepare("SELECT *  FROM `account` WHERE `username` = ? and `password` = ?");
    $query->bind_param("ss", $username,$password);
    if ( isset($_POST['username'])  && !empty($_POST['username']) && isset($_POST['password'])  && !empty($_POST['password']) ) {
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
    <div class="container-fluid">
        <?php echo "Cookie named '" . $_COOKIE['key'] . "' is not set!"; ?>
    </div><?php
} else { ?>
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
    </div> <?php
} ?>
</body>

</html>
<?php
}
?>
