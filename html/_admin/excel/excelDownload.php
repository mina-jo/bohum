<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/common.php'; ?>
<?
//initialize
if($_SESSION['user_aid'] == "") {
	echo ("<script>location.href='/_admin/login.php'</script>");
}

$aname   = $_GET['aname'];

header( "Content-type: application/vnd.ms-excel; charset=euc-kr" );
header( "Expires: 0" );
header( "Cache-Control: must-revalidate, post-check=0,pre-check=0" );
header( "Pragma: public" );
header( "Content-Disposition: attachment; filename=analytics_".DATE('Y_m_d').".xls" );
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">"); 

?>

<table border='1'>
	<thead>
		<tr> 
						<th>계약일</th>
						<th>지급금액</th>
						<th>3%</th>
						<th>입금 금액</th>
						<th>판촉비<br/>(3만원)</th>
						<th>은행명</th>
						<th>계좌번호</th>
						<th>주민등록번호</th>
						<th>소속</th>
						<th>이름</th>
						<th>연락처</th>
						<th>실적확인</th>
						<th>입금일</th>
						<th>작성자</th>
						<th>등록일</th>
		</tr>
	</thead>
	<tbody>
						<?
						$ssql = "select * from C_TB_BOHUM where 1=1 and aname LIKE '%".$aname."%'";
						$stmt3 = $dbh->prepare($ssql);
						$stmt3->execute();
						$stmt3 -> bindColumn('acontract_date',     $acontract_date);
						$stmt3 -> bindColumn('aamount',     $aamount);
						$stmt3 -> bindColumn('aamount_3per',     $aamount_3per);
						$stmt3 -> bindColumn('aamount_deposit',     $aamount_deposit);
						$stmt3 -> bindColumn('apromotional_cost',     $apromotional_cost);
						$stmt3 -> bindColumn('abank',     $abank);
						$stmt3 -> bindColumn('aaccount',     $aaccount);
						$stmt3 -> bindColumn('apersonal_id',     $apersonal_id);
						$stmt3 -> bindColumn('acompany',     $acompany);
						$stmt3 -> bindColumn('aname',     $aname);
						$stmt3 -> bindColumn('aphone',     $aphone);
						$stmt3 -> bindColumn('aperformace',     $aperformace);
						$stmt3 -> bindColumn('adeposit',     $adeposit);
						$stmt3 -> bindColumn('aregby', $aregby);
						$stmt3 -> bindColumn('aregdate',$aregdate);
						while($row = $stmt3->fetch()){
							?>
							<tr> 
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
							<font style="color: blue;"><?= $row['aname'] ?></font>
							</td>
							<td>
							<?= $row['aphone'] ?>
							</td>
							<td><?= $row['aperformace'] ?></td>
							<td><?= $row['adeposit'] ?></td>
							<td><?= $row['aregby'] ?></td> 
							<td><?= $row['aregdate'] ?></td>
							</tr>
					<?
					}?>
</tbody>
</table>