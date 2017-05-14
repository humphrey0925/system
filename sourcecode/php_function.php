<?php
function processMainInfo($name,$contact,$loginpcos,$loginip,$loginbrowser,$logintime,$prevpcos,$previp,$prevbrowser,$prevtime,$img
){
    $prevtime = date('l y/m/d h:i:sa',$prevtime);
    $logintime = date('l y/m/d h:i:sa',$logintime);
    $profileblankimg = ($img=='') ? 'profileblank.jpg' : 'upload/'.$img.'?'.time() ;
    $uploadimageelement = (true) ? '<input id="userimgupload" type="file" style="visibility:hidden;position:absolute" onchange="imageUpload(this)" accept="image/*"/><div class="rounded-circle" id="userimghover" onclick="$(\'#userimgupload\').click();" style="cursor:pointer;"></div>' : '' ;
    $GLOBALS['maininfo'] = strtr(file_get_contents("sourcecode/maininfo.min.html"),array(
        '%profileblankimg%' => $profileblankimg,
        '%uploadimageelement%' => $uploadimageelement,
        '%name%' => $name,
        '%contact%' => $contact,
        '%loginpcos%' => $loginpcos,
        '%loginip%' => $loginip,
        '%loginbrowser%' => $loginbrowser,
        '%logintime%' => $logintime,
        '%prevpcos%' => $prevpcos,
        '%previp%' => $previp,
        '%prevbrowser%' => $prevbrowser,
        '%prevtime%' => $prevtime,
        ));
}
/*******************************************************************************************************************/
function processNavBar(){
    $response = file_get_contents("sourcecode/navbar.min.html");
    // for ($i=1; $i <= 10; $i++) 
    //     $response = strtr($response,array('%data%' => "$i customerManage <br></a><a>%data%",));
    // $SystemManagementNavBar = "";
    $addOn = 
    ( (getCurrentUser('level')*1) <= 2 ) ? 
        // ( (getCurrentUser('level')*1) <= 1 ) ? 
        //     ( (getCurrentUser('level')*1) <= 0 ) ? 
                "<a class=\"dropdown-item\" href=\"systemManagementUserAdd\">新增</a>
                 <a class=\"dropdown-item\" href=\"systemManagementUserManage\">管理</a>" : 
                // "<li class=\"nav-item\"><a class=\"nav-link\" href=\"#\">1</a></li>" : 
                // "<li class=\"nav-item\"><a class=\"nav-link\" href=\"#\">2</a></li>" : 
                "" ;
    $SystemManagementNavBar = ( (getCurrentUser('level')*1) <= 2 ) ? "<li class=\"nav-item dropdown\"><a class=\"nav-link dropdown-toggle\" href data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">系統管理</a><div class=\"dropdown-menu\"><h6 class=\"dropdown-header\">用戶</h6>$addOn</div></li>" : "" ;
    $response = strtr($response,array('%management_system%' => "$SystemManagementNavBar",));
    $GLOBALS['navbar'] = $response;
}
/*******************************************************************************************************************/
function processCustomerAdd(){ $GLOBALS['customerAdd'] = file_get_contents("sourcecode/customerAdd.min.html"); }
/*******************************************************************************************************************/
function processSystemManagementUserAdd(){ $GLOBALS['systemManagementUserAdd'] = file_get_contents("sourcecode/systemManagementUserAdd.min.html"); }
/*******************************************************************************************************************/
function processCustomerManage(){
    $response = file_get_contents("sourcecode/customerManage.min.html");
    $buttonSet = file_get_contents("sourcecode/customerManageButton.min.html");

    if ($result = $GLOBALS['db']->query("SELECT `id`,`name`,`contact`,`address`,`remark` FROM `customer` WHERE `delete_status`=0")) {
        while ($row = $result->fetch_assoc()) {
            $rowData = "<tr data-id=\"{$row['id']}\"><td>{$row['name']}</td><td>{$row['address']}</td><td>{$row['contact']}</td><td>{$row['remark']}</td><td>$buttonSet</td></tr>";
            $GLOBALS['searchData']['customerManage'][] = array('html' => $rowData, 'id' => $row['id'], 'name' => $row['name'], 'remark' => $row['remark'], 'contact' => $row['contact'], 'address' => $row['address'], );
        }
        $str = "";
        foreach ($GLOBALS['searchData']['customerManage'] as $value) {
            $str .= $value['html'];
        }
        $response = strtr( $response,array('%data%' => $str ) );
        $GLOBALS['customerManage'] = $response;
        $result->free();
    }
}
/*******************************************************************************************************************/
function processSystemManagementUserManage(){
    $buttonSet = '<div class="btn-group"><a onclick="adminConfirm(this,\'update\')" class="btn btn-primary">重置密碼</a><a onclick="adminConfirm(this,\'delete\')" class="btn btn-danger">刪除賬號</a></div>';
    $response = file_get_contents("sourcecode/systemManagementUserManage.min.html");
    $currentUsername = getCurrentUser('username');
    $currentUserLevel = getCurrentUser('level')*1;
    if ($result = $GLOBALS['db']->query("SELECT `id`,`name`,`contact`,`username`,`level`,`logintime` FROM `user` WHERE `level`<>0 and `username`<>\"$currentUsername\"") && $currentUserLevel == 0) {
        while ($row = $result->fetch_assoc()) {
            $rowData = "<tr class=\"text-center\" data-id=\"{$row['id']}\"><td>{$row['username']}</td><td>{$row['name']}</td><td>{$row['contact']}</td><td>{$row['level']}</td><td>".date("Y/m/d H:i",$row['logintime'])."</td><td>$buttonSet</td></tr>";
            $GLOBALS['searchData']['systemManagementUserManage'][] = array('html' => $rowData, 'id' => $row['id'], 'name' => $row['name'], 'username' => $row['username'], 'contact' => $row['contact'], 'logintime' => $row['logintime'], 'level' => $row['level'], );
        }
        $str = "";
        foreach ($GLOBALS['searchData']['systemManagementUserManage'] as $value) {
            $str .= $value['html'];
        }
        $response = strtr($response,array('%systemManagementUserManage%' => $str));
        $GLOBALS['systemManagementUserManage'] = $response;
        $result->free();
    }
}
/*******************************************************************************************************************/
function login(){
    echo $GLOBALS['login'];
}
/*******************************************************************************************************************/
function main($mode=''){ 
    $query = $GLOBALS['db']->prepare("SELECT `id`,`name`,`contact`,`username`,`password`,`level`,`userstatus`,`loginpcos`,`loginip`,`loginbrowser`,`logintime`,`loginkey`,`prevpcos`,`previp`,`prevbrowser`,`prevtime`,`prevkey`,`image` FROM `user`
 WHERE `loginkey` = ?");
    $key = getKey();
    $query->bind_param("s", $key);
    $query->execute();
    $query->store_result();
    $query->bind_result($id,$name,$contact,$username, $password,$level,$userstatus,$loginpcos,$loginip,$loginbrowser,$logintime,$loginkey,$prevpcos,$previp,$prevbrowser,$prevtime,$prevkey,$img
    );
    $query->fetch();
    processMainInfo($name,$contact,$loginpcos,$loginip,$loginbrowser,$logintime,$prevpcos,$previp,$prevbrowser,$prevtime,$img
    );
    if ( $mode == '' ) {
        // echo $GLOBALS['navbar'].$GLOBALS['maininfo'].$GLOBALS['footer'].$GLOBALS['js_function'].'<script>'.$GLOBALS['js_run_main'].'</script>';
        processNavBar();
        echo $GLOBALS['navbar'].'<div class="container-fluid">'.$GLOBALS['maininfo'].'</div>'.$GLOBALS['footer'].$GLOBALS['js_function'].'<script>'.$GLOBALS['js_run_main'].'</script>';
    }
    $query->close();
}
/*******************************************************************************************************************/
function checkIP() {
    return 
    (getenv('HTTP_FORWARDED')) ? 
        (getenv('HTTP_FORWARDED_FOR')) ? 
            (getenv('HTTP_X_FORWARDED')) ? 
                (getenv('HTTP_X_FORWARDED_FOR')) ? 
                    (getenv('HTTP_CLIENT_IP')) ? 
                        getenv('HTTP_CLIENT_IP') : 
                        getenv('HTTP_X_FORWARDED_FOR') : 
                        getenv('HTTP_X_FORWARDED') : 
                        getenv('HTTP_FORWARDED_FOR') : 
                        getenv('HTTP_FORWARDED') : 
                        $_SERVER['REMOTE_ADDR'] ;;
}
/*******************************************************************************************************************/
function checkCookie(){
    if (isset($_COOKIE['_key'])&&!empty($_COOKIE['_key']) || isset($_COOKIE['session'])&&!empty($_COOKIE['session'])) {
        $query = $GLOBALS['db']->prepare("SELECT `loginkey` FROM `user` WHERE `loginkey` = ? and `userstatus` = 1");
        $key = getKey();
        $query->bind_param("s", $key);
        $query->execute();
        $query->store_result();
        if($query->num_rows()===1){
            $query->close();
            return true;
        }else{
            $query->close();
            return false;
        }
    } else {
        return false;
    }
}
/*******************************************************************************************************************/
function getKey(){
    return (isset($_COOKIE['_key'])&&!empty($_COOKIE['_key'])) ? $_COOKIE['_key'] : $_COOKIE['session'];
}
/*******************************************************************************************************************/
function getCurrentUser($col){
    if (checkCookie()) {
        $query = $GLOBALS['db']->prepare("SELECT `$col` FROM `user` WHERE `loginkey` = ?");
        $key = getKey();
        $query->bind_param("s", $key);
        $query->execute();
        $query->store_result();
        $query->bind_result($data);
        $query->fetch();
        $query->close();
        return $data;
    }
    return 0;
}
/*******************************************************************************************************************/
function checkCacheEqual($time,$el){
    return getSystemUpdateTime($el)==$time;
}
/*******************************************************************************************************************/
function cacheNameConvert($name){
    // print_r($_POST);
    if ($name == 'systemManagementUserManage' ||
        $name == 'main'
    ) {
        return 'user';
    }
    if ($name == 'customerManage') {
        return 'customer';
    }
    return $name;
}
/*******************************************************************************************************************/
function getSystemUpdateTime($col){
    $query = $GLOBALS['db']->prepare("SELECT `time` FROM `systemupdatetime` WHERE `name` = ?");
    $query->bind_param("s", cacheNameConvert($col) );
    $query->execute();
    $query->store_result();
    $query->bind_result($data);
    $query->fetch();
    $query->close();
    if (empty($data)) {
        return 1;
    }
    return $data;
}
function updateTime($name){
    $time = time();
    $name = cacheNameConvert($name);
    $GLOBALS['db']->query("UPDATE `systemupdatetime` SET `time` = $time WHERE `name` = \"{$name}\"");
}
/*******************************************************************************************************************/
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
/*******************************************************************************************************************/
function getOS() { 
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) {
            $os_platform    =   $value;
            break;
        }
    }   
    return $os_platform;
}
/*******************************************************************************************************************/
function getBrowser() {
    $browser        =   "Unknown Browser";
    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );
    foreach ($browser_array as $regex => $value) { 
        if (preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) {
            $browser    =   $value;
            break;
        }
    }
    return $browser;
}
/*******************************************************************************************************************/?>
