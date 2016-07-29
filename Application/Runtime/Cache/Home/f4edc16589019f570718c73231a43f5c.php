<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>添加系统用户</title>

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
<script type="text/javascript" src="/demo/Public/Js/addUser.js"></script>
<script type="text/javascript" src="/demo/Public/Js/common.js"></script>
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/category.css" />
</head>
<body>
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 添加系统用户</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">添加用户</a>
	    </span><?php endif; ?>
</h1>

<div class="form_div">
<form action="/demo/index.php?s=/Home/User/add"  method="post">
<input type="hidden" value="addUser" name="act" />
<table>

    <tr>
        <td class="label">校区：</td>
        <td class="value">
            <select name="school_id" id="school_id">
                <option value="0">请选择</option>
                <?php if(is_array($school)): foreach($school as $key=>$sc): ?><option value="<?php echo ($sc["id"]); ?>" <?php echo ($sc['id']===$actionId?'selected="selected"':''); ?>><?php echo ($sc["school_name"]); ?></option><?php endforeach; endif; ?>
            </select>
        </td>
    </tr>

    <tr>
        <td class="label">用户权限：</td>
        <td class="value">
        <select name="pow_id" id="pow_id">               
                <option value="0">请选择</option>
                <?php if(is_array($pow)): foreach($pow as $key=>$pw): ?><option value="<?php echo ($pw["id"]); ?>" <?php echo ($pw['id']===$actionId?'selected="selected"':''); ?>><?php echo ($pw["pow_name"]); ?></option><?php endforeach; endif; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">用户名：</td>
        <td class="value" id="cat">
        <input type="text" name="user_name" value="<?php echo ($one["user_name"]); ?>" maxlength="16"/>
        </td>
    </tr>
    <tr>
        <td class="label">密码：</td>
        <td class="value"><input type="password" name="user_pwd" value="<?php echo ($one["user_pwd"]); ?>" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')"
        /></td>
    </tr>
    <tr>
        <td class="label">确认密码：</td>
        <td class="value"><input type="password" name="confirm_pwd" value="<?php echo ($one["confirm_pwd"]); ?>" /></td>
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