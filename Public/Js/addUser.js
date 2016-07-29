$(document).ready(function()
{
	var confirmpwdInput = $("input[name='confirm_pwd']");
	var pwdInput = $("input[name='user_pwd']");
	confirmpwdInput.blur(function() {
		if(confirmpwdInput.val() != pwdInput.val()) {
			alert('两次输入的密码不一致，请重新输入！');
		}
	});
	
	$("form").submit(function()
	{
      
		if($("#pow_id").val() =="0")
		{
			alert("用户权限不能为空！");
		}	
		else if($("input[name='user_name']").val() == "")
		{
			alert("用户名不能为空！");
		}
//		else if($("input[name='user_pwd']").val() == "")
//		{
//			alert("密码不能为空！");
//		}
	
		else
		{
			if($("select[name='user_type']").val() == "merchant")
			{
				if($("input[name='card_num']").val() == '') {
					alert('银行卡号不能为空！');
				} else if($("input[name='card_owner']").val() == '') {
					var reg = /^\d{19}$/g;
					if(!reg.test($("input[name='card_num']").val()) ) { 
					    alert("银行卡号位数不正确！"); 
					} 
					else
						alert("开户名不能为空！");
					
				}
				else if($("input[name='bank_name']").val() == '') {
					alert("开户银行不能为空！");
				} else
					return true;
				
				return false;
				
			}
			
			return true;
		}
		return false;
	});
});