<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/common.php'; ?>
<?

	unset($_SESSION['user_g_id']);
	unset($_SESSION['user_email']);
	unset($_SESSION['user_name']);
	unset($_SESSION['user_dept']);
	unset($_SESSION['user_color']);
	unset($_SESSION['user_position']);
	
	unset($_SESSION['user_auth']);
	
	unset($_SESSION['user_dept_head']);
	unset($_SESSION['user_corp']);
	unset($_SESSION['user_dept_nm']);
	

	echo ("<script>location.href='/_admin/login.php'</script>");
?>
