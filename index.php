<?php
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set("Asia/Taipei");
$login = file_get_contents("sourcecode/loginform.min.html");
$footer = file_get_contents("sourcecode/footer.min.html");
$js_run_main = file_get_contents("sourcecode/js_run.min.js");
$js_function = '<script>'.file_get_contents("sourcecode/js_function.min.js").'</script><style>'.file_get_contents("sourcecode/css.min.css").'</style>' ;
require_once('sourcecode/php_function.php');
if($_GET){
    header("Location: ./");
    exit();
}
require_once './sourcecode/db_connect.php';
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
        <script src="js/jquery.cookie.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="js/custom.min.js" type="text/javascript" charset="utf-8" async defer></script>
        <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-91209552-1', 'auto');
        ga('send', 'pageview');
        </script>
    </head>

    <body>
        <?php if( checkCookie() ) { main(); } else { login(); } ?>
    </body>

    </html>
    <?php
}
require_once './sourcecode/db_close.php';?>
