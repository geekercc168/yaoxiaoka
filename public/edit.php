<?php

if($_POST['path'] && $_POST['content'] && $_POST['type']){
	$path=$_POST['path'];//$_POST
	$content=$_POST['content'];
	$type=$_POST['type'];
	$album_id=$_POST['album_id']?$_POST['album_id']:4000253;
	//$content= iconv('GB2312', 'UTF-8', $content);
	//echo $path.'<br>'.$content;
	$path= substr(dirname($_SERVER['SCRIPT_FILENAME']), 0, -7).$path;

	if($type==1){
		$path_arr=explode('/',$path);
		unset($path_arr[count($path_arr)-1]);

		$mkdir_path= implode('/',$path_arr);
		 if (!file_exists($mkdir_path)) {
		     //echo substr(dirname($_SERVER['SCRIPT_FILENAME']), 0, -7).$mkdir_path;die;
			mkdir($mkdir_path,0777,true);
		 }
		  $myfile = fopen($path, "w") or die("Unable to open file!");
		  fwrite($myfile, $content);
		  fclose($myfile);
		  $file_size=Tokb(filesize($path));
		  echo $file_size;
	}else{
		if(file_exists($path)){
		 $myfile = fopen($path, "w") or die("Unable to open file!");
		 fwrite($myfile, $content);
		 fclose($myfile);
		 echo 1;
		
	}else{
		echo 2;
	}
	}
	
}else{
	echo 2;
}
 /**
     * 字节转化
     */
    function Tokb($size)
    {
        $kb = 1024;// 1KB（Kibibyte，千字节）=1024B，
        $mb = 1024 * $kb; //1MB（Mebibyte，兆字节，简称“兆”）=1024KB，
        $gb = 1024 * $mb; // 1GB（Gigabyte，吉字节，又称“千兆”）=1024MB，
        $tb = 1024 * $gb; // 1TB（Terabyte，万亿字节，太字节）=1024GB，
        $pb = 1024 * $tb; //1PB（Petabyte，千万亿字节，拍字节）=1024TB，
        $fb = 1024 * $pb; //1EB（Exabyte，百亿亿字节，艾字节）=1024PB，
        $zb = 1024 * $fb; //1ZB（Zettabyte，十万亿亿字节，泽字节）= 1024EB，
        $yb = 1024 * $zb; //1YB（Yottabyte，一亿亿亿字节，尧字节）= 1024ZB，
        $bb = 1024 * $yb; //1BB（Brontobyte，一千亿亿亿字节）= 1024YB

        if ($size < $kb) {
            return $size . " B";
        } elseif ($size < $mb) {
            return round($size / $kb, 2) . " KB";
        } elseif ($size < $gb) {
            return round($size / $mb, 2) . " MB";
        } elseif ($size < $tb) {
            return round($size / $gb, 2) . " GB";
        } elseif ($size < $pb) {
            return round($size / $tb, 2) . " TB";
        } elseif ($size < $fb) {
            return round($size / $pb, 2) . " PB";
        } elseif ($size < $zb) {
            return round($size / $fb, 2) . " EB";
        } elseif ($size < $yb) {
            return round($size / $zb, 2) . " ZB";
        } else {
            return round($size / $bb, 2) . " YB";
        }

    }
?>