<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>관리자 페이지</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="address=no">
	<link rel="icon" type="image/ico" href="/_admin/assets/images/common/favicon.ico">
	<link rel="stylesheet" href="/_admin/assets/css/font.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
	<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/head.php'; ?>
</head>
<style>
fieldset {border:none; margin:0; padding:0;}
#admin_login {font-family: 'Noto Sans KR'; background:url("/_admin/assets/images/common/login_bg.jpg");}
#admin_login .wrap {width:100%; overflow:hidden; background:#3d64b3;}
#admin_login .wrap .inner {background:url("/_admin/assets/images/common/admin_login.png"); width:475px; height:308px; margin:235px auto 0; text-align:center; position:relative;}
#admin_login .wrap .inner h1 {position:absolute; left:30px; top:20px;}
#admin_login .wrap .inner h1 img{display:block;height:40px;}
#admin_login .wrap .inner form {width:230px; margin:0 auto; padding-top:75px; box-sizing:border-box;}
#admin_login .wrap .inner form label {width:100%; text-align:left; color:#171717; font-size:15px; line-height:1.5; font-weight:normal; display:block;}
#admin_login .wrap .inner form input {width:100%; font-size:14px; line-height:29px; padding:0 6px 0 46px; border:1px solid #a9a9a9; color:#00182f; font-weight:normal; box-sizing:border-box; border-radius:0; outline:none;}
#admin_login .wrap .inner form input#aid {background:url("/_admin/assets/images/common/login_id.jpg") left center no-repeat #e2e2e2;}
#admin_login .wrap .inner form input#apwd {background:url("/_admin/assets/images/common/login_pw.jpg") left center no-repeat #e2e2e2;}
#admin_login .wrap .inner form p.id {margin-bottom:8px;}
#admin_login .wrap .inner form p.login {margin:15px 0;}
#admin_login .wrap .inner form p.login .btn {width:127px; border-radius:0; line-height:25px; border:0; background:#21336a; text-align:center; color:#fff; font-size:14px; font-weight:normal;}
#admin_login .wrap .inner p.info {font-size:12px; color:#8f8f8f; font-weight:normal; line-height:1.5;}

#admin_login .footer {width:100%; margin-top:20px; text-align:center; color:#767676; font-size:12px;}
</style>
<body id='admin_login'>
	<div class="wrap">
		<div class='inner'>
			<form method="post" action="login_proc.php">
				<fieldset>
					<legend></legend>
					<p class="id">
						<label for="id">사용자ID</label>
						<input type="text" name="aid" id="aid" required="">
					</p>
					<p class="pw">
						<label for="pw">비밀번호</label>
						<input type="password" name="apwd" id="apwd" required="">
					</p>
					<p class="login">
						<button type="submit" class="btn">LOGIN</button>
					</p>
				</fieldset>	
			</form>
		</div>
	</div>
	<div class="footer">
	</div>
</body>
</html>