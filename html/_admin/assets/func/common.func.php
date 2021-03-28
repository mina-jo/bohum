<?
// 자바스크립 경고창
// 기능 : 경고 메시지, 이동 URL,
function Alert($msg, $url='', $target = '', $focus=''){
	echo "<script>\n";
	if ($msg == true ) echo "alert(\"".$msg."\");\n";

	$target = strtolower($target);


	if(empty($target) == false) {
		$target = $target.'.';
	}


	if (empty($url) == false ) {
		switch ($url) {
			case "BACK"		: echo $target."history.back();\n";break;
			case "CLOSE"	: echo $target."self.close();\n";break;
			case "RELOAD"	: echo $target."document.location.reload();\n"; break;
			case "FOCUS"	: echo $target.$focus."\n";break;
			case "NONE"		: break;
			default			: echo $target."document.location.replace(\"$url\");\n";break;
		}
	}

	if (strtolower($focus) == 'close') {
		echo "self.close();\n";
	}
	//echo $targetScript;
	echo "</script>\n";
}


//==============================================================================
//	인젝션 처리
//==============================================================================
function Fn_Requestx($str){
	$str = ($str != "") ? trim($str):"";

	$str = str_replace("<object", "<x-object", $str);
	$str = str_replace("</object", "</x-object", $str);
	$str = str_replace("<style", "<x-style", $str);
	$str = str_replace("</style", "</x-style", $str);
	$str = str_replace("<script", "<x-script", $str);
	$str = str_replace("</script", "</x-script", $str);
	$str = str_replace("<embed", "<x-embed", $str);
	$str = str_replace("</embed", "</x-embed", $str);

//	$str = str_replace("\"", "˝", $str);
//	$str = str_replace("/*", "", $str);
//	$str = str_replace("*/", "", $str);

	$str = str_replace("IcxMarcos", "", $str);
	$str = str_replace("gb2312", "", $str);
	$str = str_replace("encode", "", $str);
	$str = str_replace("session", "", $str);
	$str = str_replace("request", "", $str);


/*
	$str = str_replace("and ","", $str);
	$str = str_replace("or ","", $str);
	$str = str_replace("delete ","", $str);
	$str = str_replace("drop ","", $str);
	$str = str_replace("insert ","", $str);
	$str = str_replace("select ","", $str);
	$str = str_replace("union ","", $str);
	$str = str_replace("update ","", $str);
*/
	$str = str_replace("xp_cmdshell ","", $str);
	$str = str_replace("xp_dirtree ","", $str);
	$str = str_replace("xp_regread ","", $str);
	$str = str_replace("exec ","", $str);
	$str = str_replace("Openrowset ","", $str);
	$str = str_replace("sp_","", $str);
		
	//$pattern = "/\"|'|:|-|<|>|%|\(|\)|\+|;|#|&/";		//해시태그땜에 #은 제외시킴
	$pattern = "/\"|'|:|--|<|>|%|\(|\)|\+|;|&/";

	$lastTxt	= preg_replace_callback($pattern, "Fn_PatternReplace", $str);

	return $lastTxt;
}


function Fn_PatternReplace($matches) {
	switch ($matches[0]) {
		case '"': return "&quot;"; break;
		case "'": return "´"; break;
		case ":": return "&#58;"; break;
		case "--": return "&#45;&#45;"; break;
		case "<": return "&lt;"; break;
		case ">": return "&gt;"; break;
		case "%": return "&#37;"; break;
		case "(": return "&#40;"; break;
		case ")": return "&#41;"; break;
		case "+": return "&#43;"; break;
		case ";": return "&#59;"; break;
		case "#": return "&#35;"; break;
		case "&": return "&amp;"; break;
	}
}


function Fn_htmlDecode($str, $script = ""){	
	$str = str_replace("&amp;", "&", $str);
	$str = str_replace("&quot;", '"', $str);
	$str = str_replace("´", "'", $str);
	$str = str_replace("˝", "\"", $str);
	$str = str_replace("&#58;", ":", $str);
	$str = str_replace("&#59;", ";", $str);	
	$str = str_replace("&#45;&#45;", "--", $str);
	$str = str_replace("&lt;", "<", $str);
	$str = str_replace("&gt;", ">", $str);
	$str = str_replace("&#37;", "%", $str);
	$str = str_replace("&#40;", "(", $str);
	$str = str_replace("&#41;", ")", $str);
	$str = str_replace("&#43;", "+", $str);
	$str = str_replace("&#59;", ";", $str);
	$str = str_replace("&#35;", "#", $str);
	$str = str_replace("&amp;", "&", $str);
	

	if ($script == "script"){
		$str = str_replace("<x-style", "<style", $str);
		$str = str_replace("</x-style", "</style", $str);
	}

	return $str;
}

function Fn_stripTag($str){
	$str	= strip_tags($str);
	$str	= str_replace("&nbsp;"," ",$str);
	return $str;
}

function Fn_utf8_Cutstr($str,$len,$tail=''){
	$len = $len*2;
	$c = substr(str_pad(decbin(ord($str{$len})),8,'0',STR_PAD_LEFT),0,2); 
	if ($c == '10') 
	for (;$c != '11' && $c{0} == 1;$c = substr(str_pad(decbin(ord($str{--$len})),8,'0',STR_PAD_LEFT),0,2)); 
	
	return substr($str,0,$len) . (strlen($str)-strlen($tail) >= $len ? $tail : ''); 
} 


//===============================================================================
// 페이징 함수 (분류별 보기에서 사용)
// Page: 현재 페이지
// PageSize : 페이지사이즈
// TotalPage : 페이지 전체갯수
// Param : 추가로 넘겨줄 파라미터
//===============================================================================
function GetPagingNumber($pageNo,$PageSize,$TotalPage,$Param, $pagingMax = ""){
	if ($TotalPage > 1){
		$intBlockPage;
		$i;
		
		if(!$pagingMax) $pagingMax = 10;	//노출 페이지 수		
		$intBlockPage=(int)(($pageNo-1)/$pagingMax)*$pagingMax+1;


		$sRtnDiv = "		<nav class=\"pagination\">".chr(13);
		$sRtnDiv = $sRtnDiv . "			<ul>".chr(13);
		
		if($intBlockPage == 1){
			$sRtnDiv = $sRtnDiv."	<li class=\"bu prev\"><a href='?pageNo=1".$Param."'>◀</a>".chr(13);
		}else{
			$sRtnDiv = $sRtnDiv."	<li class=\"bu prev\"><a href='?pageNo=".($intBlockPage-$pagingMax).$Param."'>◀</a>".chr(13);
		}

		$i = 1;

		do
		{
			if ((int)$intBlockPage == (int)$pageNo){
				$sRtnDiv = $sRtnDiv."<li><strong>".$intBlockPage."</strong></li>".chr(13);
			}else{
				$sRtnDiv = $sRtnDiv."<li><a href='?pageNo=".$intBlockPage.$Param."'>".$intBlockPage."</a></li>".chr(13);
			}

		  $intBlockPage=$intBlockPage + 1;
		  $i = $i+1;
		}
		while($i  <= $pagingMax && $intBlockPage <= $TotalPage);


		if($intBlockPage > $TotalPage){
			$sRtnDiv = $sRtnDiv."	<li class=\"bu next\"><a href='?pageNo=".$TotalPage.$Param."'>▶</a>".chr(13);
		}else{
			$sRtnDiv = $sRtnDiv."	<li class=\"bu next\"><a href='?pageNo=".$intBlockPage.$Param."'>▶</a>".chr(13);
		}

		$sRtnDiv = $sRtnDiv."		</ul>".chr(13);
		$sRtnDiv = $sRtnDiv."	</nav>".chr(13);
	}
	return $sRtnDiv;
}


function GetPagingNumberAjax($pageNo,$PageSize,$TotalPage,$Param, $pagingMax = ""){
	if ($TotalPage > 1){
		$intBlockPage;
		$i;
		
		if(!$pagingMax) $pagingMax = 10;	//노출 페이지 수		
		$intBlockPage=(int)(($pageNo-1)/$pagingMax)*$pagingMax+1;


		$sRtnDiv = "		<nav class=\"pagination\">".chr(13);
		$sRtnDiv = $sRtnDiv . "			<ul>".chr(13);
		
		if($intBlockPage == 1){
			$sRtnDiv = $sRtnDiv."	<li class=\"bu prev\"><a href='#'>◀</a>".chr(13);
		}else{
			$sRtnDiv = $sRtnDiv."	<li class=\"bu prev\"><a href='#none' data-pageNo=\"".($intBlockPage-$pagingMax)."\">◀</a>".chr(13);
		}

		$i = 1;

		do
		{
			if ((int)$intBlockPage == (int)$pageNo){
				$sRtnDiv = $sRtnDiv."<li><strong>".$intBlockPage."</strong></li>".chr(13);
			}else{
				$sRtnDiv = $sRtnDiv."<li><a href='#none' data-pageNo='".$intBlockPage."'>".$intBlockPage."</a></li>".chr(13);
			}

		  $intBlockPage=$intBlockPage + 1;
		  $i = $i+1;
		}
		while($i  <= $pagingMax && $intBlockPage <= $TotalPage);


		if($intBlockPage > $TotalPage){
			$sRtnDiv = $sRtnDiv."	<li class=\"bu next\"><a href='#'>▶</a>".chr(13);
		}else{
			$sRtnDiv = $sRtnDiv."	<li class=\"bu next\"><a href='#' data-page='".$intBlockPage."'>▶</a>".chr(13);
		}

		$sRtnDiv = $sRtnDiv."		</ul>".chr(13);
		$sRtnDiv = $sRtnDiv."	</nav>".chr(13);
	}
	return $sRtnDiv;
}


//===============================================================================
// 셀렉트 박스 선택설정
//===============================================================================
function getSelected($strValue1, $strValue2){
	if(strtoupper($strValue1) == strtoupper($strValue2)){
		return "selected";
	}
}

//===============================================================================
// 체크박스 선택설정 (단일 값)
//===============================================================================
function getChecked($strValue1, $strValue2){
	if(strtoupper($strValue1) == strtoupper($strValue2)){
		return "checked";
	}
}


//===============================================================================
// 로그인여부 확인
//===============================================================================
function adminLoginChk($chkAdminId){
	/*
	if (strtolower($ArrNowPage_[2]) == '_admin' && $ArrNowPage_[3] <> 'login.php'){
		if($ADMINID_ == ""){
			//alert('로그인 후 시도해주세요.', '/_admin/login.php', 'top');
		}
	}
	*/

	if($chkAdminId == ""){
		alert( "로그인 후 이용 가능합니다.","/_admin/login.php", "top","");
		exit();
	}
}


//파일업로드 function (jpeg|jpg|gif|png) , filetype:image/doc
function file_upload($upfile_ipname, $upfile_dir, $max_filesize = "", $filetype = "", $ori_filename = false, $ori_name=false){

	if ($max_filesize == "")
		$max_filesize = 1024*1024*5;		//최대파일 업로드(5MB 제한)


	$upfile_temp	= $_FILES[$upfile_ipname]['tmp_name'];
	$upfile_name	= $_FILES[$upfile_ipname]['name'];
	$file_size		= $_FILES[$upfile_ipname]['size'];
	$file_type		= $_FILES[$upfile_ipname]['type'];

	if ($upfile_name){

		if($file_size > $max_filesize) {
			echo 'filesize is over. (size:$file_size)';
			exit();
		}

		$current_file=$upfile_name;

		$upfile_name=substr($current_file,0,strrpos($current_file,"."));
		$file_ex=strtolower(strrchr($current_file,"."));

		//확장자 검사
		if ($filetype == "") $filetype = "image";
		if ($filetype == "doc"){
			if (!(preg_match("/doc|docx|ppt|pptx|xls|xlsx|xml|txt/i", $file_ex))) {
				echo 'filetype is wrong.';
				exit();
			}
		}else if ($filetype == "image"){
			if (!(preg_match("/jpeg|jpg|gif|png/i", $file_ex))) {
				echo 'filetype is wrong.';
				exit();
			}
		}else if ($filetype == "all"){
			if (!(preg_match("/doc|docx|ppt|pptx|xls|xlsx|zip|jpeg|jpg|gif|png|pdf/i", $file_ex))) {
				echo 'filetype is wrong.';
				exit();
			}
		}

		//중복파일 검사 - 중복된 파일이 w있을경우 인덱스를 붙인다.
        if ( !$ori_name ) {
            $new_file_name .= mktime(date("H"),date("i"),date("s"),date("d"),date("m"),date("y"));
            if ($ori_filename == true){
                $new_file_name .=  "__" . $upfile_name;
            }

    		$fn_t=$new_file_name;
    		$fileindex=0;

    		while(file_exists(ROOT_PATH.$upfile_dir . "/" . $fn_t . $file_ex)){
    			$fn_t=$fn_t . "_" . $fileindex ;
    			$fileindex++;
    		};
        } else {
            $fn_t = $upfile_name;
        }

		$realfile = $fn_t. $file_ex; //실제파일명
		$dest = ROOT_PATH.$upfile_dir."/".$realfile;
		$srcf = $upfile_temp;
		if(!move_uploaded_file($srcf,$dest));

		return $realfile;

	}else{
		return "";
	}
}


function getRealFileName($filepathname){
	$tempFileArr	= explode("/",$filepathname);
	array_shift($tempFileArr);
	$filename		= $tempFileArr[count($tempFileArr)-1];		//파일명가져옴
	$realnameArr	= explode("__",$filename);				//구분기호 __ 로 분리해서 원래 파일명 가져옴.
	$realfilename	= $realnameArr[1];

	return $realfilename;
}


function getDateDiffTime($startDate,$endDate){
	$timediffsec = (strtotime($endDate) - strtotime($startDate)); 
	$realHour = floor($timediffsec / (60*60) );
	$realMinute = floor( ($timediffsec - ($realHour*(60*60)) ) / 60) ;
	$realSecond = $timediffsec - ($realHour*(60*60)) - ($realMinute*60) ;

	return ($realHour*60)+$realMinute;
}

//===============================================================================
// 자바 스크립트(앨럿창) 시작
//===============================================================================
function js_alert($msg, $action){
	$jsStr;
	$jsStr =	"<script>" . chr(13);
	$jsStr = $jsStr ."alert('" . $msg . "');".chr(13);
	$jsStr = $jsStr.$action.chr(13);
	$jsStr = $jsStr."</script>".chr(13);
	echo $jsStr;
}

//===============================================================================
// 자바 스크립트만 시작
//===============================================================================
function js_noalert($action){
	$jsStr;
	$jsStr =	"<script>" . chr(13);
	$jsStr = $jsStr.$action.chr(13);
	$jsStr = $jsStr."</script>".chr(13);
	echo $jsStr;
}



//===============================================================================
// stripslashes & CLOB 처리(ListArray)
//===============================================================================
function Fn_rsDataListArray($dbRsList, $exceptColumns = null){
	if (empty($exceptColumns)) 
		$exceptColumns	= array("CLOB_CONTS");

	if (!empty($dbRsList)){
		foreach ($dbRsList as $index => $dbRs) {
			foreach ($dbRs as $rsKey => $rsValue) {
				//if ($rsKey == 'CLOB_CONTS'){
				if (in_array($rsKey, $exceptColumns)){
					if(!empty($rsValue))
						$dbRsList[$index][$rsKey]	= stripslashes($rsValue->load());
					else
						$dbRsList[$index][$rsKey]	= "";
				}else{
					$dbRsList[$index][$rsKey] = stripslashes($rsValue);
				}
			}
			
		}
	}

	return $dbRsList;
}



//===============================================================================
// stripslashes & CLOB 처리(Array)
//===============================================================================
function Fn_rsDataArray($dbRs, $exceptColumns = null){
	if (empty($exceptColumns)) 
		$exceptColumns	= array("CLOB_CONTS");

	if (!empty($dbRs)){
		foreach ($dbRs as $rsKey => $rsValue) {
			if (in_array($rsKey, $exceptColumns)){
				if(!empty($rsValue))
					$dbRs[$rsKey]	= stripslashes($rsValue->load());
				else
					$dbRs[$rsKey]	= "";
			}else{
				$dbRs[$rsKey] = stripslashes($rsValue);
			}
		}
	}

	return $dbRs;
}

function DecryptAES($text){
	//
	# --- DECRYPTION ---
	# the key should be random binary, use scrypt, bcrypt or PBKDF2 to
	# convert a string into a key
	# key is specified using hexadecimal

	# key
	$key		= pack('H*', $HEXKEY_);

	# show key size use either 16, 24 or 32 byte keys for AES-128, 192
	# and 256 respectively
	$key_size =  strlen($KEY_);
//	echo "Key size: " . $key_size . "<br>";

//	$plaintext = "This string was AES-256 / CBC / ZeroBytePadding encrypted.";

	# create a random IV to use with CBC encoding
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

	$dec = base64_decode($text);

	# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
	$iv_dec = substr($dec, 0, $iv_size);

	# retrieves the cipher text (everything except the $iv_size in the front)
	$dec = substr($dec, $iv_size);

	# may remove 00h valued characters from end of plain text
	$decrypt = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $dec, MCRYPT_MODE_CBC, $iv_dec);

	return $decrypt;
}

//IP출력
function getRealIpAddr() {
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
	$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
	$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
	$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}



 // send html mail
 function send_htmlmail($fromEmail, $fromName, $toEmail, $toName, $subject, $message){

  $charset='utf-8'; // 문자셋 : UTF-8
  $body = iconv('utf-8', 'euc-kr', $message);  //본문 내용 UTF-8화
  $encoded_subject="=?".$charset."?B?".base64_encode($subject)."?=\n"; // 인코딩된 제목
  $to= "\"=?".$charset."?B?".base64_encode($toName)."?=\" <".$toEmail.">" ; // 인코딩된 받는이
  $from= "\"=?".$charset."?B?".base64_encode($fromName)."?=\" <".$fromEmail.">" ; // 인코딩된 보내는이


 
  $headers="MIME-Version: 1.0\n".
  "Content-Type: text/html; charset=euc-kr; format=flowed\n".
  "To: ". $to ."\n".
  "From: ".$from."\n".
  "Return-Path: ".$from."\n".
  "urn:content-classes:message\n".
  "Content-Transfer-Encoding: 8bit\n"; // 헤더 설정

  //send the email
  $mail_sent = @mail( $to, $encoded_subject, $body, $headers );
  //if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"

  return $mail_sent;
 }
 
function onlyHanAlpha($subject) {
    $pattern = '/([\xEA-\xED][\x80-\xBF]{2}|[a-zA-Z])+/';
    preg_match_all($pattern, $subject, $match);
    return implode('', $match[0]);
}

?>