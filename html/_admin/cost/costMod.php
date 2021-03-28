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
		$sql ="select * from C_TB_BOHUM where idx = '$idx'";
		$stmt = $dbh ->prepare($sql);
		$stmt->execute(); 
		$stmt -> bindColumn('acontract_date', $acontract_date);
		$stmt -> bindColumn('aamount', $aamount);
		$stmt -> bindColumn('aamount_3per', $aamount_3per);
		$stmt -> bindColumn('apromotional_cost', $apromotional_cost);
		$stmt -> bindColumn('abank', $abank);
		$stmt -> bindColumn('aaccount', $aaccount);
		$stmt -> bindColumn('apersonal_id', $apersonal_id);
		$stmt -> bindColumn('aphone', $aphone);
		$stmt -> bindColumn('acompany', $acompany);
		$stmt -> bindColumn('aname', $aname);
		$stmt -> bindColumn('aperformace', $aperformace);
		$stmt -> bindColumn('adeposit', $adeposit);
		$stmt -> bindColumn('aregby', $aregby);
		$stmt -> bindColumn('aregdate', $aregdate);
		$row = $stmt -> fetch();

	}else{
	    $acontract_date = "";
	    $aamount = "";
	    $aamount_3per = "";
	    $apromotional_cost = "";
	    $abank = "";
	    $aaccount = "";
	    $apersonal_id = "";
	    $aphone = "";
	    $aname = "";
	    $aperformace = "";
	    $adeposit = $today;
		$aregby  = $_SESSION['user_aname'];
		$aregbyemail = $_SESSION['user_aemail'];
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
									<button id="search" type="button" onclick="javascript:goSearch();">검색</button>
									<div id="anameSelDiv" style="display:none">소속/이름 선택 : 
										<select name="anameSel" id="anameSel" style="width:50%;" onchange="javascript:selAccount();">
										</select>
									</div>
								</td>
							</tr>
							<tr>
								<th>소속</th>
								<td>
									<input type="text" id="acompany" value="<?=$acompany?>" style="width:60%;" placeholder="소속을 입력해주세요" />
								</td>
							</tr>
							<tr>
								<th>계약일</th>
								<td>
									<input type="text" id="acontract_date" class="inline calendar" value="<?=$acontract_date?>" style="width:60%;" placeholder="" />
								</td>
							</tr>
							<tr>
								<th>지급금액</th>
								<td>
									<input type="text" id="aamount" onkeydown="onlyNumber(this)" value="<?=$aamount?>" style="width:40%;" placeholder="숫자만 입력해주세요" />
								</td>
							</tr>
							<tr>
								<th>3.3%</th>
								<td>
									<input type="text" id="aamount_3per" onkeydown="onlyNumber(this)" value="<?=$aamount_3per?>" style="width:40%;" placeholder="숫자만 입력해주세요" />
								</td>
							</tr>
							<tr>
								<th>입금 금액</th>
								<td>
									<input type="text" id="aamount_deposit" onkeydown="onlyNumber(this)" value="<?=$aamount_3per?>" style="width:40%;" placeholder="숫자만 입력해주세요" />
								</td>
							</tr>
							<tr>
								<th>판촉비<br/>(3만원)</th>
								<td>
									<input type="checkbox" id="apromotional_cost"  <? if($apromotional_cost == 1){ ?>checked="checked" <?}?> />
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
								<th>연락처</th>
								<td>
									<input type="text" id="aphone" value="<?=$aphone?>" style="width:60%;" placeholder="" />
								</td>
							</tr>
							<tr>
								<th>입금자명</th>
								<td>
									<select id="aperformace" name="aperformace" style="width: 40%;">
										<option value="">선택해주세요</option>
										<option value="김미란" <?=getSelected("김미란",$aperformace)?>>김미란</option>
										<option value="김종철"<?=getSelected("김종철",$aperformace)?> >김종철</option>
									</select>
								</td>
							</tr>
							<tr>
								<th>입금일</th>
								<td>
									<input type="text" id="adeposit" value="<?=$adeposit?>" style="width:60%;" placeholder="" />
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
						<a href="costList.php?<?= $PageParam ?>" class="btn style_3">목록</a>
					</div>
			
				</fieldset>
			</form>
			
		</section>
		
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/snb.php'; ?>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/footer.php'; ?>
</article>
<script>
	$("#aamount").on("change paste keyup", function() {
		var tmp1 = $('#aamount').val()*0.033;
		$('#aamount_3per').val(Math.floor(tmp1));

		var tmp2 = $('#aamount').val() - ($('#aamount').val()*0.033);
		$('#aamount_deposit').val(Math.floor(tmp2));
	});
	
	function goSearch(){
		
		if($("#aname").val() ==''){
			alert('이름을 입력하세요');
			$("#aname").focus();
			return false;
		}
		
		var str = "";
		
		$.ajax({
			url: '/_admin/ajax/ajax.php',
			type: 'post',
			data: {
				proc:"search-account",
				aname:$("#aname").val()
			},
			dataType: "text",
			success: function (response) {
				 $("#anameSelDiv").css("display","block");
				 str = response;
				 $("#anameSel").empty();
				 $("#anameSel").append(str);
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert("ajax error : " + textStatus + "\n" + errorThrown);
			}
		});
	}

	function goSearchTel(){
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
		
		var str = "";
		
		$.ajax({
			url: '/_admin/ajax/ajax.php',
			type: 'post',
			data: {
				proc:"search-tel",
				aname:$("#aname").val(),
				acompany:$("#acompany").val()
			},
			dataType: "text",
			success: function (response) {
				 $("#anameTelDiv").css("display","block");
				 str = response;
				 $("#anameTelSel").empty();
				 $("#anameTelSel").append(str);
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert("ajax error : " + textStatus + "\n" + errorThrown);
			}
		});
	}

	function selTel(){

		var tmp = $("#anameTelSel option:selected").val();

		$("#aphone").val(tmp);

	}

	function selAccount(){

		var tmp = $("#anameSel option:selected").val();
		var tmpArr = tmp.split('/');

		$("#abank").val(tmpArr[0]);
		$("#aaccount").val(tmpArr[1]);
		$("#acompany").val(tmpArr[2]);
		$("#aphone").val(tmpArr[3]);
		$("#apersonal_id").val(tmpArr[4]);

	}

	function goReg() {
		if($("#aname").val() ==''){
			alert('이름을 입력하세요');
			$("#aname").focus();
			return false;
		}

		if($("#acompany").val() ==''){
			alert('소속을 입력하세요');
			$("#aname").focus();
			return false;
		}

		var apromotional_cost = 0;

		if(!$("#apromotional_cost").is(":checked")){

			apromotional_cost = 0;
			
			if($("#aamount").val() ==''){
				alert('지급금액을 입력하세요');
				$("#aamount").focus();
				return false;
			}

			if($("#aamount_3per").val() ==''){
				alert('3%를 입력하세요');
				$("#aamount_3per").focus();
				return false;
			}

			if($("#aamount_deposit").val() ==''){
				alert('입금금액을 입력하세요');
				$("#aamount_deposit").focus();
				return false;
			}
    	}else{
    		apromotional_cost = 1;
        }

		if($("#acontract_date").val() ==''){
			alert('계약일을 입력하세요');
			$("#acontract_date").focus();
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


		if($("#aregby").val() ==''){
			alert('작성자를 입력하세요');
			$("#aregby").focus();
			return false;
		}
	
		$.ajax({
			url: '/_admin/ajax/ajax.php',
			type: 'post',
			data: {
				proc:<?= !empty($idx)?"'cost-up'":"'cost-in'" ?>,
				idx: <?= !empty($idx)? "'$_GET[idx]'": "''" ?>,
				acontract_date:$('#acontract_date').val(),
				aamount:$("#aamount").val(),
				aamount_3per:$("#aamount_3per").val(),
				aamount_deposit:$("#aamount_deposit").val(),
				apromotional_cost,apromotional_cost,
				abank:$("#abank").val(),
				aaccount:$("#aaccount").val(),
				apersonal_id:$("#apersonal_id").val(),
				acompany:$("#acompany").val(),
				aname:$("#aname").val(),
				aphone:$("#aphone").val(),
				aperformace:$("#aperformace option:selected").val(),
				adeposit:$("#adeposit").val(),
				aregby:$("#aregby").val()

			},
			dataType: "json",
			success: function (response) {
				 if(response == 1){
					alert('등록이 완료되었습니다.');
					location.replace('costList.php');
					
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