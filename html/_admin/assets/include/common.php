<?php
//HTML 헤더 셋팅 (P3P 설정)
header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
header("Content-Type: text/html; charset=UTF-8");
@session_cache_limiter('nocache,must-revalidate');
//no-cache 설정
header("Pragma: no-cache");
header("Cache-Control: no-cache,must-revalidate");
//170822 : 크로스 프레임 스크립트 방지에 필요한
header('X-Frame-Options: SAMEORIGIN');
//session http only
ini_set("session.cookie_httponly", 1);
ini_set("session.cache_expire", 1440);
ini_set("session.gc_maxlifetime", 86400*30);
//변수정의
define('ROOT_PATH',			$_SERVER["DOCUMENT_ROOT"]);
//session
session_start();

// include 정의 : S =========================================
include_once ROOT_PATH.'/_admin/assets/db/dbConnect.php';	  //DB
include_once ROOT_PATH.'/_admin/assets/func/common.func.php'; //공통함수
require_once ROOT_PATH.'/_admin/assets/lib/Mobile_Detect.php';//access device check
// include 정의 : E =========================================



//IP
$RealipAddr = getRealIpAddr();


//device check
$MOBILE_DETECT = new Mobile_Detect;
$BrowserType_ = "W";
if ($MOBILE_DETECT->isMobile() || $MOBILE_DETECT->isTablet()) {
	$BrowserType_ = "M";
}


?>