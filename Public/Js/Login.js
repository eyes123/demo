$(document).ready(function()
{
	$("form").submit(function()
	{
		if($("input[name='username']").val() == "")
		{
			showMessage('登录失败','用户名或密码不能为空！');
		}
		else if($("input[name='password']").val() == "")
		{
			showMessage('登录失败','用户名或密码不能为空！');
		}
		else
		{
			return true;
		}
		return false;
	});
});