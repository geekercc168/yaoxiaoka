<?php
$file =$_FILES['file'];
if(!empty($file)){
    $mydate = date ( 'Y-m-d' );
    $path = '../upload/photos/' . $mydate ;
    if (! file_exists ( $path )) {
        mkdir ( $path, 0777, true ); // 0777表示最大的访问权
    }
    $destination2 = $path . '/' . $file['name'];
    if (is_uploaded_file ( $file ['tmp_name'] )) {
        if (move_uploaded_file ( $file ['tmp_name'], $destination2 )) {
            // 上传成功
            $msg['status'] =200;
            $msg['url'] = $file['name'];
        }else{
            $msg['status'] ='';
            $msg['url'] = "upload/upload.jpg";
        }
    }
}else{
    $msg['status'] ='';
    $msg['url'] = "upload/upload.jpg";
}
echo header("content-type:text/html; charset=utf-8");
echo json_encode($msg);die;

