<?php
$REQUEST_URI = basename($_SERVER['PHP_SELF']);
?>
<? if($lnb_no=="1") {?>
<nav id="snb">	
	<h2>관리</h2>
	<ul>
		<li>
			<a href="/_admin/cost/costList.php" <?= $REQUEST_URI=="costList.php"?"class='on'":""?> >실적 관리</a>
		</li>
		<li>
			<a href="/_admin/member/memberList.php" <?= $REQUEST_URI=="memberList.php"?"class='on'":""?> >회원 관리</a>
		</li>
</nav>
<? }?>
