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
	
	$startDate		= Fn_Requestx($_GET["startDate"]);	// 구분(검색단어)
	$endDate		= Fn_Requestx($_GET["endDate"]);	// 구분(검색단어)
	//페이징
	$page_size = 10;
	if(!$pageNo) $pageNo = 1;
	if(preg_match("/[^0-9]/",$pageNo)){
		alert('잘못된 접근입니다.', "costList.php");
		exit();
	};



	$queryTable		= " C_TB_BOHUM ";
	$queryWhere		= " WHERE 1=1";
	// where 
	if ( $ScWord ){
			$queryWhere .= " AND aname LIKE '%$ScWord%' ";
	}
	
	if ( $startDate || $endDate ){
	    $queryWhere .= " AND date_format(acontract_date, '%Y-%m-%d') between  '$startDate' AND '$endDate'";
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
										<th>등록된 회원 검색</th>
										<td>
											<input type="text" name="searchName" id="searchName" class="inline" value="<?=$searchName?>" title="searchword">
										</td>
									</tr>
									<tr id="asearchList" style="display: none;">
										<th>검색 결과</th>
										<td>
											<input type="text" name="asearchListTd" id="asearchListTd" class="inline" title="asearchListTd">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="submit">
							<button type="button" class="btn search" onclick="javascript:searchMember();">회원 검색</button>
							<button type="button" class="btn search" style="background: #6799FF;" onclick="javascript:location.href='/_admin/member/memberMod.php';">회원 등록</button>
						</div>
					</fieldset>
				</form>
			</div>
			
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
									<tr>
										<th>계약일 검색</th>
										<td>
											<input type="text" name="startDate" id="startDate" class="inline calendar" value="<?=$startDate?>" >~
											<input type="text" name="endDate" id="endDate" class="inline calendar" value="<?=$endDate?>" >
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
				<input type="hidden" id="proc" name="proc" value="cost-del">

				<!-- 검색 수 -->
				<p class="search_total">
					총 <?= $count ?>건이 검색 되었습니다.
				</p>
				
				<!-- 버튼 그룹 -->
				<div class="btn_group">
					<button type="submit" class="btn">삭제</button>
					<a href="costMod.php" class="btn style_3">등록</a>
				</div>
				
				<!-- 테이블 세로형 -->
				<table class="table col">
					<tr>
						<th>
							<input type="checkbox" id="idxCheckAll">
						</th>
						<th>번호</th>
						<th style="width: 8%;">계약일</th>
						<th>지급금액</th>
						<th>3.3%</th>
						<th>입금급액</th>
						<th>판촉비<br/>(3만원)</th>
						<th style="width: 8%;">은행명</th>
						<th style="width: 8%;">계좌번호</th>
						<th>주민등록번호</th>
						<th style="width: 8%;">소속</th>
						<th style="width: 8%;">이름</th>
						<th>연락처</th>
						<th>입금자명</th>
						<th style="width: 8%;">입금일</th>
						<th>작성자</th>
						<th>등록일</th>
						
					</tr>
			<?
					$stmt = $dbh -> prepare($q);
					$stmt -> execute();
					$stmt -> bindColumn('idx',     $idx);
					$stmt -> bindColumn('acontract_date',     $acontract_date);
					$stmt -> bindColumn('aamount',     $aamount);
					$stmt -> bindColumn('aamount_3per',     $aamount_3per);
					$stmt -> bindColumn('aamount_deposit',     $aamount_deposit);
					$stmt -> bindColumn('apromotional_cost',     $apromotional_cost);
					$stmt -> bindColumn('abank',     $abank);
					$stmt -> bindColumn('aaccount',     $aaccount);
					$stmt -> bindColumn('apersonal_id',     $apersonal_id);
					$stmt -> bindColumn('aphone',     $aphone);
					$stmt -> bindColumn('acompany',     $acompany);
					$stmt -> bindColumn('aname',     $aname);
					$stmt -> bindColumn('aperformace',     $aperformace);
					$stmt -> bindColumn('adeposit',     $adeposit);
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
							<td><?= $row['acontract_date'] ?></td>
							<td><?= $row['aamount'] ?></td>
							<td><?= $row['aamount_3per'] ?></td>
							<td><?= $row['aamount_deposit'] ?></td>
							<td><? if($apromotional_cost == 1){ ?>예<?}else{ ?>아니오<? } ?></td>
							<td><?= $row['abank'] ?></td>
							<td><?= $row['aaccount'] ?></td>
							<td><?= $row['apersonal_id'] ?></td>
							<td><?= $row['acompany'] ?></td>
							<td>
							<a href="/_admin/cost/costMod.php?idx=<?= $row['idx']?>">
							<font style="color: blue;"><?= $row['aname'] ?></font>
							</a>
							</td>
							<td>
							<a href="/_admin/cost/costMod.php?idx=<?= $row['idx']?>">
							<?= $row['aphone'] ?>
							</a>
							</td>
							<td><?= $row['aperformace'] ?></td>
							<td><?= $row['adeposit'] ?></td>
							<td><?= $row['aregby'] ?></td> 
							<td><?= $row['aregdate'] ?></td>
							
						</tr>
					<? $bunho++;
					} ?>
				</table>
				
				<!-- 버튼 그룹 -->
				<div class="btn_group">
					<button type="submit" class="btn">삭제</button>
					<a href="costMod.php" class="btn style_3">등록</a>
				</div>
				
				<!-- 페이징 -->
				<div class="search_pagination">
					<?=GetPagingNumber($pageNo,$page_size,$last_page,$PageUrl,"")?>
				</div>
			</form>
		<div class="btn_group">
				<a href="/_admin/excel/excelDownload.php?aname=<?=$ScWord?>" class="btn style_1">엑셀다운로드</a>
		</div>
		</section>
		
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/snb.php'; ?>
	</div>
	
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/footer.php'; ?>
</article>

<script>

	function searchMember(){

		$.ajax({
			url: '/_admin/ajax/ajax.php',
			type: 'post',
			data: {
				proc:"search-member",
				aname:$("#searchName").val()
			},
			dataType: "text",
			success: function (response) {
				if(response != ""){
					$("#asearchList").css("display","");
					 var str = response;
					 $("#asearchListTd").empty();
					 $("#asearchListTd").val(str);
				}else{
					$("#asearchList").css("display","none");
					$("#asearchListTd").val();
					alert("등록된 회원이 없습니다.");
				}
				
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert("ajax error : " + textStatus + "\n" + errorThrown);
			}
		});
		
	}

	
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