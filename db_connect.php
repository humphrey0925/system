<?php
    define('DB_USER', "kbh");
    define('DB_PASSWORD', "kbh");
    define('DB_DATABASE', "hydropower_project_progress_report_system");
    define('DB_SERVER', "localhost"); 
    $db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
    if ($db->connect_error) {
        die("连接失败: " . $db->connect_error);
        exit();
    }
?>
