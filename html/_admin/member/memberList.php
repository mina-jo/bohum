<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/common.php'; ?>
<?php
	//initialize
    if($_SESSION['user_aid'] == "") {
		echo ("<script>location.href='/_admin/login.php'</script>");
	}
	//lnb 활성화
	$lnb_no = "1";	

	
	// request param config
	$pageNo		= Fn_Requestx($_GET["pageNo"]);		// current page number
	// $ScFind		= Fn_Requestx($_GET["find"]);	 	// 구분(키워드)
	$ScWord		= Fn_Requestx($_GET["searchword"]);	// 구분(검색단어)
	//페이징
	$page_size = 10;
	if(!$pageNo) $pageNo = 1;
	if(preg_match("/[^0-9]/",$pageNo)){
		alert('잘못된 접근입니다.', "memberList.php");
		exit();
	};



	$queryTable		= " C_TB_MEMBER ";
	$queryWhere		= " WHERE 1=1";
	// where 
	if ( $ScWord ){
			$queryWhere .= " AND aname LIKE '%$ScWord%' ";
	}

	//글 총수 
	$sql = "SELECT count(*) as cnt FROM $queryTable $queryWhere ;";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$stmt->bindColumn(1, $count);
	while($row = $stmt->fetch()){;}
	//데이터
	$q = " select * from $queryTable $queryWhere order by idx desc limit ".($pageNo-1)*$page_size.",".$page_size.";";
	$last_page = ceil($count/$page_size);

	// queryStringParam
	$PageUrl	= "&find=".$ScFind."&searchword=".$ScWord;
	$PageParam = "pageNo=".$pageNo.$PageUrl;
	$PageParam = str_replace("&","|",$PageParam);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/head.php'; ?>
</head>
<body>
<article id="wrap">
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/header.php'; ?>
	
	<div id="container">
		<section id="content">
			<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/header_page.php'; ?>

			<!-- 검색 폼 -->
			<div class="search_form">
				<form name="" id="" method="get" action="">		
					<fieldset>
						<legend>검색 폼</legend>
						<div class="form">
							<table class="table row">
								<caption>검색 폼</caption>
								<colgroup>
									<col width="120">
									<col width="*">
									<col width="120">
									<col width="*">
								</colgroup>
								<tbody>
									<tr>
										<th>이름 검색</th>
										<td>
											<input type="text" name="searchword" id="searchword" class="inline" value="<?=$ScWord?>" title="searchword">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="submit">
							<button type="submit" class="btn search">검색</button>
						</div>
					</fieldset>
				</form>
			</div>
			
			<form method="POST" name="del_form" id="del_form" action="/_admin/ajax/ajax.php">
				<input type="hidden" id="proc" name="proc" value="member-del">

				<!-- 검색 수 -->
				<p class="search_total">
					총 <?= $count ?>건이 검색 되었습니다.
				</p>
				
				<!-- 버튼 그룹 -->
				<div class="btn_group">
					<button type="submit" class="btn">삭제</button>
					<a href="memberMod.php" class="btn style_3">등록</a>
				</div>
				<!-- 테이블 세로형 -->
				<table class="table col">
					<tr>
						<th>
							<input type="checkbox" id="idxCheckAll">
						</th>
						<th>번호</th>
						<th>소속</th>
						<th>이름</th>
						<th>핸드폰번호</th>
						<th>은행</th>
						<th>계좌번호</th>
						<th>주민등록번호</th>
						<th>직급</th>
						<th>작성자</th>
						<th>등록일</th>
						
					</tr>
			<?
					$stmt = $dbh -> prepare($q);
					$stmt -> execute();
					$stmt -> bindColumn('idx',     $idx);
					$stmt -> bindColumn('acompany',     $acompany);
					$stmt -> bindColumn('aname',     $aname);
					$stmt -> bindColumn('aphone',     $aphone);
					$stmt -> bindColumn('abank',     $abank);
					$stmt -> bindColumn('aaccount',     $aaccount);
					$stmt -> bindColumn('apersonal_id',     $apersonal_id);
					$stmt -> bindColumn('aposition',     $aposition);
					$stmt -> bindColumn('aregby', $aregby);
					$stmt -> bindColumn('aregdate',$aregdate);
					
					$bunho = 1+(($pageNo-1) * $page_size);
					while($row = $stmt->fetch()){
						?>
						<tr>
							<td>
								<input type="checkbox" name="idx[]" value="<?= $row['idx'] ?>">
							</td>
							<td><?= $bunho ?></td>
							<td><?= $row['acompany'] ?></td>
							<td>
							<a href="/_admin/member/memberMod.php?idx=<?= $row['idx']?>">
							<font style="color: blue;"><?= $row['aname'] ?></font>
							</a>
							</td>
							<td><?= $row['aphone'] ?></td>
							<td><?= $row['abank'] ?></td>
							<td><?= $row['aaccount'] ?></td>
							<td><?= $row['apersonal_id']?></td>
							<td><?= $row['aposition'] ?></td>
							<td><?= $row['aregby'] ?></td> 
							<td><?= $row['aregdate'] ?></td>
							
						</tr>
					<? $bunho++;
					} ?>
				</table>
				
				<!-- 버튼 그룹 -->
				<div class="btn_group">
					<button type="submit" class="btn">삭제</button>
					<a href="memberMod.php" class="btn style_3">등록</a>
				</div>
				
				<!-- 페이징 -->
				<div class="search_pagination">
					<?=GetPagingNumber($pageNo,$page_size,$last_page,$PageUrl,"")?>
				</div>
			</form>
		<div class="btn_group">
		</div>
		</section>
		
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/snb.php'; ?>
	</div>
	
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/footer.php'; ?>
</article>

<script>
(function () {
	var $document = $(document);
	
	var form = $('#del_form');
	var checkbox = $('[name="idx[]"]');
	
	$document
		// 체크박스 선택
		.on('click', '#idxCheckAll', function () {
			var isChecked = $(this).is(':checked');
			
			$.each(checkbox, function () {
				this.checked = isChecked;
			});
		})
		
		// 삭제
		.on('click', '#del_form [type="submit"]', function () {			
			if (confirm('삭제 하시겠습니까?')) {
				form.submit();
			}
			return false;
		});
	
})();
</script>
</body>
</html>