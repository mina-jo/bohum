<?php
 	$sFileInfo = '';
	$headers = array();
	 
	foreach($_SERVER as $k => $v) {
		if(substr($k, 0, 9) == "HTTP_FILE") {
			$k = substr(strtolower($k), 5);
			$headers[$k] = $v;
		} 
	}
	//파일명 변경
	$test = explode(".", rawurldecode($headers['file_name']));
	$name = str_replace("\0", "", time().'-'.rand(0,100).'.'.$test[1]);

	$file = new stdClass;
	//$file->name = str_replace("\0", "", rawurldecode($headers['file_name']));
	$file->name = str_replace("\0", "", rawurldecode($name));	//파일명 변경
	$file->size = $headers['file_size'];
	$file->content = file_get_contents("php://input");
//	echo $file->name;
	$explode = explode('.',$file->name);
	$arr_pop	= array_pop($explode);
	$filename_ext = strtolower($arr_pop);
	$allow_file = array("jpg", "png", "bmp", "gif"); 
	
	if(!in_array($filename_ext, $allow_file)) {
		echo "NOTALLOW_".$file->name;
	} else {
		$uploadDir = '../../../../uploads/EditUpload/';
		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}
		
		$newPath = $uploadDir.iconv("utf-8", "cp949", $file->name);
		
		if(file_put_contents($newPath, $file->content)) {
			$sFileInfo .= "&bNewLine=true";
			$sFileInfo .= "&sFileName=".$file->name;
			$sFileInfo .= "&sFileURL=/_admin/uploads/EditUpload/".$file->name;
		}
		
		echo $sFileInfo;
	}
?>