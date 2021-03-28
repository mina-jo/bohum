<?php include $_SERVER['DOCUMENT_ROOT'] . '/_admin/assets/include/common.php'; ?>
<?php
//upload
$uploadBase = '../uploads/';


//idx
$idx        = $_REQUEST['idx'];


// param
$strPageParam		= Fn_Requestx($_POST['strPageParam']);
$PageParam			= str_replace("|","&",$strPageParam);


//관리자
$proc      = Fn_Requestx($_REQUEST['proc']);
$aid       = Fn_Requestx($_REQUEST['aid']);
$aname     = Fn_Requestx($_REQUEST['aname']);
$aemail    = Fn_Requestx($_REQUEST['aemail']);
$apw       = hash('sha256',$_REQUEST['apw']);


//BOARD
$idx= $_REQUEST['idx'];
$acontract_date= $_REQUEST['acontract_date'];
$aamount= $_REQUEST['aamount'];
$aamount_3per= $_REQUEST['aamount_3per'];
$aamount_deposit = $_REQUEST['aamount_deposit'];
$apromotional_cost = $_REQUEST['apromotional_cost'];
$abank= $_REQUEST['abank'];
$aaccount= $_REQUEST['aaccount'];
$apersonal_id= $_REQUEST['apersonal_id'];
$aphone= $_REQUEST['aphone'];
$acompany= $_REQUEST['acompany'];
$aname= $_REQUEST['aname'];
$aperformace= $_REQUEST['aperformace'];
$adeposit= $_REQUEST['adeposit'];
$aregby= $_REQUEST['aregby'];
$aregdate   = $_REQUEST['aregdate'];

$aposition   = $_REQUEST['aposition'];


switch ($proc) {

	case 'cost-in':
		
		
		$sql  = "insert into C_TB_BOHUM
		set acontract_date   = '{$acontract_date}'
        , aamount = '{$aamount}'
        , aamount_3per = '{$aamount_3per}' 
        , aamount_deposit = '{$aamount_deposit}'
        , apromotional_cost = '{$apromotional_cost}'   
        , abank = '{$abank}'
        , aaccount = '{$aaccount}'
        , apersonal_id = '{$apersonal_id}'
        , aphone = '{$aphone}'
        , acompany = '{$acompany}'
        , aname = '{$aname}'
        , aperformace = '{$aperformace}'
		, adeposit = '{$adeposit}'
        , aregby = '{$aregby}'
		, aregdate = now()
		";
		$stmt = $dbh -> prepare($sql);
		$stmt -> execute();

		echo json_encode("1");
		break;
		
	case 'cost-up':
		if(!$idx) break;
		
		
		$sql  = "UPDATE C_TB_BOHUM SET acontract_date = '$acontract_date'
                                    , aamount = '$aamount'
                                    , aamount_3per = '$aamount_3per'
                                    , aamount_deposit = '$aamount_deposit'
                                    , apromotional_cost = '$apromotional_cost'
                                    , abank = '$abank'
                                    , aaccount = '$aaccount' 
                                    , apersonal_id = '$apersonal_id' 
                                    , aphone = '$aphone'
                                    , acompany = '$acompany'
                                    , aname = '$aname'
                                    , aperformace = '$aperformace'
                                    , adeposit = '$adeposit'
                                    , aregby = '$aregby'    WHERE idx = '$idx'";
		$stmt = $dbh -> prepare($sql);
		$stmt -> execute();


		echo json_encode("1");
		break;

	case 'cost-del':
		for($i=0; $i<count($idx); $i++) { 
			$sql   = "DELETE FROM C_TB_BOHUM WHERE idx = '" .$idx[$i]. "'";
			$stmt = $dbh -> prepare($sql);
			$stmt -> execute();
		}
		alert("정상적으로 삭제되었습니다.",'/_admin/cost/costList.php');
		break;
		
	case 'search-account':
	    $sql   = "SELECT DISTINCT acompany, aname,abank,aaccount,aphone,apersonal_id FROM C_TB_MEMBER WHERE aname like '%".$aname."%'";
	    $stmt = $dbh -> prepare($sql);
	    $stmt -> execute();
	    $stmt -> bindColumn('abank', $abank);
	    $stmt -> bindColumn('aaccount', $aaccount);
	    $stmt -> bindColumn('acompany', $acompany);
	    $stmt -> bindColumn('aname', $aname);
	    $stmt -> bindColumn('aphone', $aphone);
	    $stmt -> bindColumn('apersonal_id', $apersonal_id);
	    
	    
	    $str = "<option>선택해주세요</option>";
	    $num = 0;
	    
	    while($row = $stmt->fetch()){
	        $num++;
	        $str .= '<option value="'.$abank.'/'.$aaccount.'/'.$acompany.'/'.$aphone.'/'.$apersonal_id.'">'.$acompany.'/'.$aname.'</option>';
	    }
	    
	    echo $str;
	    break;
	   
	case 'search-tel':
	    $sql   = "SELECT DISTINCT aphone FROM C_TB_MEMBER WHERE aname like '%".$aname."%' and acompany like '%".$acompany."%'";
	    $stmt = $dbh -> prepare($sql);
	    $stmt -> execute();
	    $stmt -> bindColumn('aphone', $aphone);
	    
	    $str = "<option>선택해주세요</option>";
	    $num = 0;
	    
	    while($row = $stmt->fetch()){
	        $num++;
	        $str .= '<option value="'.$aphone.'">'.$aphone.'</option>';
	    }
	    
	    echo $str;
	    break;
	    
	case 'search-member':
	    $sql   = "SELECT count(*) as cnt FROM C_TB_MEMBER WHERE aname like '%".$aname."%'";
	    $stmt = $dbh -> prepare($sql);
	    $stmt -> execute();
	    $stmt -> bindColumn('cnt', $cnt);
	    $row = $stmt->fetch();
	    
	    $str = "";
	    
	    if($cnt != 0){
	        $sql2   = "SELECT acompany,aname FROM C_TB_MEMBER WHERE aname like '%".$aname."%'";
	        $stmt2 = $dbh -> prepare($sql2);
	        $stmt2 -> execute();
	        $stmt2 -> bindColumn('acompany', $acompany);
	        $stmt2 -> bindColumn('aname', $aname);
	        
	        while($row = $stmt2->fetch()){
	            $str .= $acompany.'/'.$aname;
	        }
	        
	    }else{
	        $str = "";
	      }
	    
	    echo $str;
	    break;
	    
	case 'member-in':
	    
	    
	    $sql  = "insert into C_TB_MEMBER
		set aphone = '{$aphone}'
        , acompany = '{$acompany}'
        , aname = '{$aname}'
        , abank = '{$abank}'
        , aaccount = '{$aaccount}'
		, aposition = '{$aposition}'
		, apersonal_id = '{$apersonal_id}'
        , aregby = '{$aregby}'
		, aregdate = now()
		";
	    $stmt = $dbh -> prepare($sql);
	    $stmt -> execute();
	    
	    echo json_encode("1");
	    break;
	    
	case 'member-up':
	    if(!$idx) break;
	    
	    
	    $sql  = "UPDATE C_TB_MEMBER SET aphone = '$aphone'
                                    , acompany = '$acompany'
                                    , aname = '$aname'
                                    , abank = '$abank'
                                    , aaccount = '$aaccount'
                                    , apersonal_id = '$apersonal_id'
                                    , aposition = '$aposition'
                                    , aregby = '$aregby'    WHERE idx = '$idx'";
	    $stmt = $dbh -> prepare($sql);
	    $stmt -> execute();
	    
	    
	    echo json_encode("1");
	    break;
	    
	case 'member-del':
	    for($i=0; $i<count($idx); $i++) {
	        $sql   = "DELETE FROM C_TB_MEMBER WHERE idx = '" .$idx[$i]. "'";
	        $stmt = $dbh -> prepare($sql);
	        $stmt -> execute();
	    }
	    alert("정상적으로 삭제되었습니다.",'/_admin/member/memberList.php');
	    break;


	default:
		break;

}
?>