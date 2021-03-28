<header id="header">
	<div class="header-top">
		<p class="logout">
			<a href="#" onclick="location.href='/_admin/logout.php'" class="btn logout">
				LOGOUT
			</a>
		</p>
	</div>
	
	<nav id="gnb">
		<ul>
			<li>
				<a href="/_admin/cost/costList.php" <?= $lnb_no=="1"?"class='on'":""?> >관리</a>
			</li>
			
		</ul>
	</nav>
</header>