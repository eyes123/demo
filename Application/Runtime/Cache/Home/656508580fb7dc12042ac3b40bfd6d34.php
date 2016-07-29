<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>修改系统用户密码</title>

<link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />

<link rel="stylesheet" type="text/css" href="/demo/Public/Css/tab.css" />
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/addAdvertisement.css" />

<link rel="stylesheet" type="text/css" href="/demo/Public/Js/diashow/skins/css/diashow.css" />
<script type="text/javascript" src="/demo/Public/Js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/demo/Public/Js/diashow/diashow.js"></script>
<script type="text/javascript">

	var module = "/demo/index.php?s=/Home";
	$(document).ready(function()
	{
		//alert(1);
		var message = '<?php echo ($message); ?>';
		if(message!='')
		{
			showMessage('<?php echo ($message); ?>','<?php echo ($url); ?>','<?php echo ($time); ?>');
		}
	});
</script> 

<script type="text/javascript" src="/demo/Public/Js/Jquery.js"></script>

<link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/category.css" />

</head>
<body>

<div class="form_div">
<form action="/demo/index.php?s=/Home/user/editlogin"  method="post">
<table>
     <tr>
        <td class="label">原密码：</td>
        <td class="value"><input type="password" name="user_pw" /></td>
    </tr>
    <tr>
        <td class="label">新密码：</td>
        <td class="value"><input type="password" name="user_pwd" /></td>
    </tr>
    <tr>
        <td class="label">确认新密码：</td>
        <td class="value"><input type="password" name="confirm_pwd" /></td>
    </tr>
    <tr>
        <td></td>
        <td style="text-align:left;">
            <input class="button" type="submit" name="submit" value="添加">
            <input class="button" type="reset" value="重置"/>
        </td>
    </tr>
</table>
</form>
</div>
</body>
</html>