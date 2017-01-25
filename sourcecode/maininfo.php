<?php
function processMainInfo(        
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
){
    $prevtime = date('l y/m/d h:i:sa',$prevtime);
    $logintime = date('l y/m/d h:i:sa',$logintime);
    $profileblankimg = ($img=='') ? 'profileblank.jpg' : 'upload/'.$img ;
    $uploadimageelement = ($img=='') ? '<input id="userimgupload" type="file" style="visibility:hidden;position:absolute" onchange="imageUpload(this)" accept="image/*"/><div class="rounded-circle" id="userimghover" onclick="$(\'#userimgupload\').click();" style="cursor:pointer;"></div>' : '' ;
    $GLOBALS['maininfo'] = strtr(file_get_contents("sourcecode/maininfo.min.html"),array(
        '$profileblankimg' => $profileblankimg,
        '$uploadimageelement' => $uploadimageelement,
        '$name' => $name,
        '$contact' => $contact,
        '$loginpcname' => $loginpcname,
        '$loginip' => $loginip,
        '$loginbrowser' => $loginbrowser,
        '$logintime' => $logintime,
        '$prevpcname' => $prevpcname,
        '$previp' => $previp,
        '$prevbrowser' => $prevbrowser,
        '$prevtime' => $prevtime,
        ));
}

?>