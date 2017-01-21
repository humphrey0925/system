<?php
    define('DB_USER', "kbh");
    define('DB_PASSWORD', "kbh");
    define('DB_DATABASE', "reportsystem");
    // define('DB_SERVER', "114.35.179.195"); 
    define('DB_SERVER', "localhost"); 
    $db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
    if ($db->connect_error) {
        die("连接失败: " . $db->connect_error);
        exit();
    }
    define('IS_AJAX', !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' );
    $db->query("SET NAMES UTF8");
    // $db;
?>
