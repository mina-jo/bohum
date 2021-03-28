<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/common.php'; ?>
<?php
	//initialize
    if($_SESSION['user_aid'] == "") {
		echo ("<script>location.href='/_admin/login.php'</script>");
	}
	//lnb 활성화
	$lnb_no = "1";
	
	$today = date("Y-m-d");
	

	// param
	$strPageParam	= Fn_Requestx($_GET['strPageParam']);
	$PageParam		= str_replace("|","&",$strPageParam);

	$idx = $_GET['idx']; 
	if(!empty($idx)){ 
		$sql ="select * from C_TB_MEMBER where idx = '$idx'";
		$stmt = $dbh ->prepare($sql);
		$stmt->execute(); 
		$stmt -> bindColumn('acompany', $acompany);
		$stmt -> bindColumn('aname', $aname);
		$stmt -> bindColumn('aphone', $aphone);
		$stmt -> bindColumn('abank', $abank);
		$stmt -> bindColumn('aaccount', $aaccount);
		$stmt -> bindColumn('aposition', $aposition);
		$stmt -> bindColumn('apersonal_id', $apersonal_id);
		$stmt -> bindColumn('aregby', $aregby);
		$stmt -> bindColumn('aregdate', $aregdate);
		$row = $stmt -> fetch();

	}else{
	    $acompany = "";
	    $aname = "";
	    $aphone = "";
	    $abank = "";
	    $aaccount = "";
	    $aposition = "";
	    $apersonal_id = "";
		$aregby  = $_SESSION['user_aname'];
	}

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
			
			<h3 class="page_sub_title"></h3>
			
			<form name="frm" id="frm" method="post" action="mod_proc.php" enctype="multipart/form-data">
				<fieldset>
					<legend>수정 폼</legend>
					<input type="hidden" name="idx" value="<?= $idx ?>">
					<input type="hidden" name="strPageParam" value="<?= $strPageParam ?>">
					<input type="hidden" name="csrf"  value="<?= $csrf ?>">
					
					<!-- 테이블 가로형 -->
					<table class="table row" style="margin-top:-1px;">
						<colgroup>
							<col width="160">
							<col width="*">
						</colgroup>
						<tbody>
							<tr>
								<th>이름</th>
								<td>
									<input type="text" id="aname" value="<?=$aname?>" style="width:60%;" placeholder="이름을 입력해주세요" />
								</td>
							</tr>
							<tr>
								<th>소속</th>
								<td>
									<input type="text" id="acompany" value="<?=$acompany?>" style="width:60%;" placeholder="소속을 입력해주세요" />
								</td>
							</tr>
							<tr>
								<th>연락처</th>
								<td>
									<input type="text" id="aphone" value="<?=$aphone?>" style="width:60%;" placeholder="" />
								</td>
							</tr>
							<tr>
								
								<th>은행명</th>
								<td>
									<input type="text" id="abank" value="<?=$abank?>" style="width:60%;" placeholder="" />
								</td>
							</tr>
							<tr>
								<th>계좌번호</th>
								<td>
									<input type="text" id="aaccount" value="<?=$aaccount?>" style="width:60%;" placeholder="" />
								</td>
							</tr>
							<tr>
								<th>주민등록번호</th>
								<td>
									<input type="text" id="apersonal_id" value="<?=$apersonal_id?>" style="width:60%;" placeholder="" />
								</td>
							</tr>
							<tr>
								<th>직급</th>
								<td>
									<input type="text" id="aposition" value="<?=$aposition?>" style="width:60%;" placeholder="" />
								</td>
							</tr>
							<tr>
								<th>작성자</th>
								<td>
									<input type="text" id="aregby" value="<?=$aregby?>" style="width:60%;" placeholder="" />
								</td>
							</tr>
							
						</tbody>
					</table>
					
					<!-- 버튼 그룹 -->
					<div class="btn_group">
					<?if($idx){ ?>
						<button type="button" onclick="goReg()" class="btn style_2">수정</button>
					<? } else { ?>
						<button type="button" onclick="goReg()" class="btn style_2">등록</button>
					<? }?>
						<a href="memberList.php?<?= $PageParam ?>" class="btn style_3">목록</a>
					</div>
			
				</fieldset>
			</form>
			
		</section>
		
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/snb.php'; ?>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/footer.php'; ?>
</article>
<script>

	function goReg() {
		if($("#acompany").val() ==''){
			alert('소속을 입력하세요');
			$("#aname").focus();
			return false;
		}

		if($("#aname").val() ==''){
			alert('이름을 입력하세요');
			$("#aname").focus();
			return false;
		}

		if($("#aphone").val() ==''){
			alert('핸드폰번호를 입력하세요');
			$("#aphone").focus();
			return false;
		}

		if($("#abank").val() ==''){
			alert('은행을 입력하세요');
			$("#abank").focus();
			return false;
		}

		if($("#aaccount").val() ==''){
			alert('계좌번호를 입력하세요');
			$("#aaccount").focus();
			return false;
		}
		

		$.ajax({
			url: '/_admin/ajax/ajax.php',
			type: 'post',
			data: {
				proc:<?= !empty($idx)?"'member-up'":"'member-in'" ?>,
				idx: <?= !empty($idx)? "'$_GET[idx]'": "''" ?>,
				acompany:$("#acompany").val(),
				aname:$("#aname").val(),
				aphone:$("#aphone").val(),
				abank:$("#abank").val(),
				aaccount:$("#aaccount").val(),
				aposition:$("#aposition").val(),
				apersonal_id:$("#apersonal_id").val(),
				aregby:$("#aregby").val()

			},
			dataType: "json",
			success: function (response) {
				 if(response == 1){
					alert('등록이 완료되었습니다.');
					location.replace('memberList.php');
					
				}  else if(response == '-2'){
					alert('입력된 값이 없습니다');
				} else {
					alert('등록중에 에러가 발생했습니다');
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert("ajax error : " + textStatus + "\n" + errorThrown);
			}
		});
	}

	function onlyNumber(obj) {
		$(obj).keyup(function(){
			 $(this).val($(this).val().replace(/[^\.0-9]/g,""));
			 
		});
	}

</script>
</body>
</html>