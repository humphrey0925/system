<?php
date_default_timezone_set("Asia/Taipei");
header("charset=utf-8");
$login = file_get_contents("sourcecode/loginform.min.html");
$navbar = file_get_contents("sourcecode/navbar.min.html");
$footer = file_get_contents("sourcecode/footer.min.html");
$js_run_main = file_get_contents("sourcecode/js_run.min.js");
$js_function = '<script>'.file_get_contents("sourcecode/js_function.min.js").'</script>' ;
require_once('sourcecode/maininfo.php');
require_once('sourcecode/customerAdd.php');
require_once('sourcecode/customerManage.php');
require_once('sourcecode/php_function.php');
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
    require_once("sourcecode/imageUpload.php");
} elseif ( isset($_POST) && !empty($_POST) ) {
    require_once("sourcecode/ajax.php");
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

    <body><?php if( checkCookie() ) { main(); } else { login(); } ?></body>
    </html><?php
}
require_once 'db_close.php';?>
