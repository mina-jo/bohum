// 숫자만
function onlyNumber(obj) {
	$(obj).keyup(function(){
		 $(this).val($(this).val().replace(/[^\.0-9]/g,""));
	});
}