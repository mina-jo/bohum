<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/common.php'; ?>
<?php 

$aid   = $_REQUEST['aid'];
$pw	   = $_REQUEST['apwd'];


//파라미터체크
if($aid == null && $pw){
?>
<script>alert("아이디를 입력해 주세요."); history.go(-1);</script>
<?php
}else if($pw == null && $aid){
?>
<script>alert("패스워드를 입력해 주세요."); history.go(-1);</script>
<?php
}else if($pw == null && $aid == null){
?>
<script>alert("아이디와 패스워드를 입력해 주세요."); history.go(-1);</script>
<?php
}
 
if( ($aid == "admin" && $pw == "alsk4417") || ($aid == "kjc" && $pw == "0811") || ($aid =="rlagustn" && $pw == "0811") ){
	$_SESSION['user_aid']     = $aid;
	$_SESSION['user_apw']     = $pw;
	if( $aid == "admin"){
	   $_SESSION['user_aname']     = "관리자";
	}else if( $aid == "kjc"){
	    $_SESSION['user_aname']     = "kjc";
	}else if($aid == "rlagustn"){
	    $_SESSION['user_aname']     = "rlagustn";
	}
?>
<script>location.href='/_admin/cost/costList.php'</script>
<?
}else{
?>
<script>alert("아이디 또는 비밀번호를 정확히 입력해주세요."); history.go(-1);</script>
<?
}
?>