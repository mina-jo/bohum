<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>관리자</title>
<link rel="stylesheet" href="/_admin/assets/css/jquery-ui.min.css">
<link rel="stylesheet" href="/_admin/assets/css/jquery-ui.theme.min.css">
<link rel="stylesheet" href="/_admin/assets/css/admin.css">



<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="/_admin/assets/js/jquery.form.min.js"></script>
<script type="text/javascript" src="/_admin/assets/js/admin.js"></script>

<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
<![endif]-->


<!-- 달력 -->
<script>
$.datepicker.setDefaults({
	dateFormat: 'yy-mm-dd',
	prevText: '이전 달',
	nextText: '다음 달',
	monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
	monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
	dayNames: ['일', '월', '화', '수', '목', '금', '토'],
	dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
	dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
	showMonthAfterYear: true,
	yearSuffix: '년'
});
$(function(){
	$( ".calendar" ).datepicker();
});
</script>