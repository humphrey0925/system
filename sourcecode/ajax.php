<?PHP
// ************* Return Status Code *****************
// User log in status
// 0 -> login fail
// 1 -> login success
// 9 -> logout
// content (GUI)
// 100 -> homepage (GUI)
// 101 -> customer add (GUI)
// 102 -> customer manage (GUI)
// 103 -> system management user add (GUI)
// 104 -> system management user manage (GUI)
// image upload
// 200 -> upload image success (MSG)
// 201 -> no permission (MSG)
// 202 -> image too big (MSG)
// 203 -> unsupported filetype (MSG)
// 204 -> network not stable (MSG)
// 205 -> upload image error (MSG)
// system management
// 901 -> customer add success (RETURN)
// 901 -> customer add success (RETURN)
// 999 -> system management user add success (RETURN)
// **************************************************
if (isset($_POST['get']) && !empty($_POST['get']) && IS_AJAX && checkCookie()) {
    if ($_POST['get'] == 'main') {
        if (!checkCacheEqual($_POST['cacheTime'],$_POST['get'])) {
            main('main');
            $data = array(
                'html' => $maininfo,
                'status' => 100,
                'cacheTime' => getSystemUpdateTime($_POST['get'])
            );
        }
        else $data = array(
            'el' => $_POST['get'],
            'status' => 1000
        );
    }
    elseif ($_POST['get'] == 'customerAdd') {
        if (!checkCacheEqual($_POST['cacheTime'],$_POST['get'])) {
            processCustomerAdd();
            $data = array(
                'html' => $customerAdd,
                'status' => 101,
                'cacheTime' => getSystemUpdateTime($_POST['get'])
            );
        }
        else $data = array(
            'el' => $_POST['get'],
            'status' => 1000
        );




            // processCustomerAdd();
            // $data = array(
            //     'html' => $customerAdd,
            //     'status' => 101,
            // );
    }
    elseif ($_POST['get'] == 'systemManagementUserAdd') {
        if (!checkCacheEqual($_POST['cacheTime'],$_POST['get'])) {
            processSystemManagementUserAdd();
            $data = array(
                'html' => $systemManagementUserAdd,
                'status' => 103,
                'cacheTime' => getSystemUpdateTime($_POST['get'])
            );
        }
        else $data = array(
            'el' => $_POST['get'],
            'status' => 1000
        );

    }
    elseif ($_POST['get'] == 'customerManage') {
        if (!checkCacheEqual($_POST['cacheTime'],$_POST['get'])) {
            processCustomerManage();
            $data = array(
                'html' => $customerManage,
                'status' => 102,
                'cacheTime' => getSystemUpdateTime($_POST['get']),
                'searchData' => (isset($GLOBALS['searchData']['customerManage'])) ? $GLOBALS['searchData']['customerManage'] : ""
            );
        }
        else $data = array(
            'el' => $_POST['get'],
            'status' => 1000
        );
    }
    elseif ($_POST['get'] == 'systemManagementUserManage') {
        if (!checkCacheEqual($_POST['cacheTime'],$_POST['get'])) {
            processSystemManagementUserManage();
            $data = array(
                'html' => $systemManagementUserManage,
                'status' => 104,
                'cacheTime' => getSystemUpdateTime($_POST['get'])
            );
        }
        else $data = array(
            'el' => $_POST['get'],
            'status' => 1000
        );
    }
} elseif (isset($_POST['add']) && !empty($_POST['add']) && IS_AJAX && checkCookie()) {
    if ( $_POST['add'] == 'customer' ) {
        $query = $db->prepare("INSERT INTO `customer` (`name`, `contact`, `address`, `remark`) VALUES (?, ?, ?, ?)");
        $data = array('status'=>900); 
        if ($_POST['multi']) {
            $namearr = explode("|",$_POST['name']);
            $contactarr = explode("|",$_POST['contact']);
            $addressarr = explode("|",$_POST['address']);
            $remarkarr = explode("|",$_POST['remark']);
            $query->bind_param("ssss", $name,$contact, $address,$remark);
            $invalid = [];
            foreach ($namearr as $key => $value) {
                $name = $value;
                $contact = (isset($contactarr[$key])) ? $contactarr[$key] : "" ;
                $address = (isset($addressarr[$key])) ? $addressarr[$key] : "" ;
                $remark = (isset($remarkarr[$key])) ? $remarkarr[$key] : "" ;
                if ($name != "") {
                    $query->execute();
                    $_time = time();
                    $db->query("UPDATE `systemupdatetime` SET `time` = {$_time} WHERE `name` = \"customerManage\"");

                }elseif ($contact != "" || $address != "" || $remark != "") {
                    array_push($invalid,array('name'=>$name,'contact'=>$contact,'address'=>$address,'remark'=>$remark));
                }
            }
            if (count($invalid)>0) {
                $name = $invalid[0]['name'];
                $contact = $invalid[0]['contact'];
                $address = $invalid[0]['address'];
                $remark = $invalid[0]['remark'];
                for ($i=1; $i < count($invalid); $i++) { 
                    $name .= "|{$invalid[$i]['name']}";
                    $contact .= "|{$invalid[$i]['contact']}";
                    $address .= "|{$invalid[$i]['address']}";
                    $remark .= "|{$invalid[$i]['remark']}";
                }
                $invalid = array('name'=>$name,'contact'=>$contact,'address'=>$address,'remark'=>$remark);
                $data = array('status'=>901,'invalid'=>$invalid);
            }
        } else {
            $query->bind_param("ssss", $name,$contact, $address,$remark);
            $name = $_POST['name'];
            $contact = $_POST['contact'];
            $address = $_POST['address'];
            $remark = $_POST['remark'];
            $query->execute();
            $_time = time();
            $db->query("UPDATE `systemupdatetime` SET `time` = {$_time} WHERE `name` = \"customerManage\"");
        }
    }
} elseif (isset($_POST['update']) && !empty($_POST['update']) && IS_AJAX && checkCookie()) {
    if ( $_POST['update'] == 'customer' ) {
        // $query = $db->prepare("INSERT INTO `customer` (`name`, `contact`, `address`, `remark`) VALUES (?, ?, ?, ?)");
        // $data = array('status'=>900); 
        // if ($_POST['multi']) {
        //     $namearr = explode("|",$_POST['name']);
        //     $contactarr = explode("|",$_POST['contact']);
        //     $addressarr = explode("|",$_POST['address']);
        //     $remarkarr = explode("|",$_POST['remark']);
        //     $query->bind_param("ssss", $name,$contact, $address,$remark);
        //     $invalid = [];
        //     foreach ($namearr as $key => $value) {
        //         $name = $value;
        //         $contact = (isset($contactarr[$key])) ? $contactarr[$key] : "" ;
        //         $address = (isset($addressarr[$key])) ? $addressarr[$key] : "" ;
        //         $remark = (isset($remarkarr[$key])) ? $remarkarr[$key] : "" ;
        //         if ($name != "") {
        //             $query->execute();
        //         }elseif ($contact != "" || $address != "" || $remark != "") {
        //             array_push($invalid,array('name'=>$name,'contact'=>$contact,'address'=>$address,'remark'=>$remark));
        //         }
        //     }
        //     if (count($invalid)>0) {
        //         $name = $invalid[0]['name'];
        //         $contact = $invalid[0]['contact'];
        //         $address = $invalid[0]['address'];
        //         $remark = $invalid[0]['remark'];
        //         for ($i=1; $i < count($invalid); $i++) { 
        //             $name .= "|{$invalid[$i]['name']}";
        //             $contact .= "|{$invalid[$i]['contact']}";
        //             $address .= "|{$invalid[$i]['address']}";
        //             $remark .= "|{$invalid[$i]['remark']}";
        //         }
        //         $invalid = array('name'=>$name,'contact'=>$contact,'address'=>$address,'remark'=>$remark);
        //         $data = array('status'=>901,'invalid'=>$invalid);
        //     }
        // } else {
        //     $query->bind_param("ssss", $name,$contact, $address,$remark);
        //     $name = $_POST['name'];
        //     $contact = $_POST['contact'];
        //     $address = $_POST['address'];
        //     $remark = $_POST['remark'];
        //     $query->execute();
        // }
    }
} elseif (isset($_POST['delete']) && !empty($_POST['delete']) && IS_AJAX && checkCookie()) {
    if ( $_POST['delete'] == 'customer' ) {
        // $query = $db->prepare("INSERT INTO `customer` (`name`, `contact`, `address`, `remark`) VALUES (?, ?, ?, ?)");
        // $data = array('status'=>900); 
        // if ($_POST['multi']) {
        //     $namearr = explode("|",$_POST['name']);
        //     $contactarr = explode("|",$_POST['contact']);
        //     $addressarr = explode("|",$_POST['address']);
        //     $remarkarr = explode("|",$_POST['remark']);
        //     $query->bind_param("ssss", $name,$contact, $address,$remark);
        //     $invalid = [];
        //     foreach ($namearr as $key => $value) {
        //         $name = $value;
        //         $contact = (isset($contactarr[$key])) ? $contactarr[$key] : "" ;
        //         $address = (isset($addressarr[$key])) ? $addressarr[$key] : "" ;
        //         $remark = (isset($remarkarr[$key])) ? $remarkarr[$key] : "" ;
        //         if ($name != "") {
        //             $query->execute();
        //         }elseif ($contact != "" || $address != "" || $remark != "") {
        //             array_push($invalid,array('name'=>$name,'contact'=>$contact,'address'=>$address,'remark'=>$remark));
        //         }
        //     }
        //     if (count($invalid)>0) {
        //         $name = $invalid[0]['name'];
        //         $contact = $invalid[0]['contact'];
        //         $address = $invalid[0]['address'];
        //         $remark = $invalid[0]['remark'];
        //         for ($i=1; $i < count($invalid); $i++) { 
        //             $name .= "|{$invalid[$i]['name']}";
        //             $contact .= "|{$invalid[$i]['contact']}";
        //             $address .= "|{$invalid[$i]['address']}";
        //             $remark .= "|{$invalid[$i]['remark']}";
        //         }
        //         $invalid = array('name'=>$name,'contact'=>$contact,'address'=>$address,'remark'=>$remark);
        //         $data = array('status'=>901,'invalid'=>$invalid);
        //     }
        // } else {
        //     $query->bind_param("ssss", $name,$contact, $address,$remark);
        //     $name = $_POST['name'];
        //     $contact = $_POST['contact'];
        //     $address = $_POST['address'];
        //     $remark = $_POST['remark'];
        //     $query->execute();
        // }
    }
} elseif ( isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) && IS_AJAX ) {
    $query = $db->prepare("SELECT `id`,`name`,`contact`,`username`,`password`,`level`,`userstatus`,`loginpcos`,`loginip`,`loginbrowser`,`logintime`,`loginkey`,`prevpcos`,`previp`,`prevbrowser`,`prevtime`,`prevkey`,`image` FROM `user` WHERE `username` = ? and `password` = ?");
    $query->bind_param("ss", $username,$password);
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    $password = crypt($password, '$6$'.$username.'$'.$password.'$');
    $query->execute();
    $query->store_result();
    if($query->num_rows()===1){
        $query->bind_result($id,$name,$contact,$username,$password,$level,$userstatus,$loginpcos,$loginip,$loginbrowser,$logintime,$loginkey,$prevpcos,$previp,$prevbrowser,$prevtime,$prevkey,$img
        );
        $query->fetch();
        $clientOS = getOS();
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
        
        $md5 = md5($id.$name.$contact.$username.$password.$level.$clientOS.$clientip.$clientbrowser.$clientrequesttime.$loginkey
        );
        $key = crypt($password, '$6$'.$md5.'$'.$loginkey.'$');
        $loginQuery = $db->prepare("
            update `user` set `loginip`=?,`loginbrowser`=?,`logintime`=?,`loginkey`=?,`loginpcos`=?,`previp`=?,`prevbrowser`=?,`prevtime`=?,`prevkey`=?,`prevpcos`=?,`userstatus`=1 where `id`=$id");
        $loginQuery->bind_param(
            "ssissssiss",$clientip,$clientbrowser,$clientrequesttime,$key,$clientOS,$loginip,$loginbrowser,$logintime,$loginkey,$loginpcos
        );
        $loginQuery->execute();
        processMainInfo($name,$contact,$clientOS,$clientip,$clientbrowser,$clientrequesttime,$loginpcos,$loginip,$loginbrowser,$logintime,$img
        );
        processNavBar();
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
    if (isset($_COOKIE['_key'])&&!empty($_COOKIE['_key']) || isset($_COOKIE['session'])&&!empty($_COOKIE['session'])) {
        $query = $GLOBALS['db']->prepare("UPDATE `user` set `userstatus`=0 WHERE `loginkey` = ?");
        if (isset($_COOKIE['_key'])&&!empty($_COOKIE['_key'])) {
            $query->bind_param("s", $_COOKIE['_key']);}
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
