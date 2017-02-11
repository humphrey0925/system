<?PHP
if($_FILES['image']['error'] > 0){
    $data = array('msg'=>'upload image error','status'=>205);
} elseif (!getimagesize($_FILES['image']['tmp_name'])){
    $data = array('msg'=>'network not stable','status'=>204);
} elseif ($_FILES['image']['type'] != 'image/png' && 
          $_FILES['image']['type'] != 'image/pjpeg' && 
          $_FILES['image']['type'] != 'image/gif' && 
          $_FILES['image']['type'] != 'image/jpeg'){
    $data = array('msg'=>'unsupported filetype','status'=>203);
} elseif ($_FILES['image']['size'] > 5120000){
    $data = array('msg'=>'image too big','status'=>202);
} else {
    $imagename = '';
    if ( isset($_POST) && !empty($_POST) ){
        if ( isset($_POST['upload']) && !empty($_POST['upload']) && $_POST['upload']=="userimage") {
            $imagename = getCurrentUser('username').'.'.pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        }
    }else{
        $imagename = $_FILES['image']['name'];
    }
    removeImage($imagename);
    if ( !move_uploaded_file($_FILES['image']['tmp_name'], "img/upload/$imagename" )){
        $data = array('msg'=>'no permission','status'=>201);
    } else{
        $id = getCurrentUser('id');
        $loginQuery = $db->prepare("update `user` set `image`=? where `id`=$id");
        $loginQuery->bind_param("s",$imagename);
        $loginQuery->execute();
        $data = array('status'=>200,'image_path'=>"img/upload/$imagename".'?cache='.time());
    }
}
echo json_encode($data);
?>