<?PHP
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
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
    $query = $db->prepare("SELECT `id`,`name`,`contact`,`username`,`password`,`level`,`userstatus`,`loginstatus`,`loginpcname`,`loginip`,`loginbrowser`,`logintime`,`loginkey`,`prevpcname`,`previp`,`prevbrowser`,`prevtime`,`prevkey`,`image` FROM `user` WHERE `username` = ? and `password` = ?");
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
            $name,
            $contact,
            $loginpcname,
            $loginip,
            $loginbrowser,
            $logintime,
            $prevpcname,
            $previp,
            $prevbrowser,
            $prevtime,
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
?>