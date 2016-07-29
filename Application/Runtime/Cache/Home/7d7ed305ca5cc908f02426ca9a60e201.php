<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>编辑系统用户信息</title>
<script type="text/javascript" src="/demo/Public/Js/Jquery.js"></script>
<script type="text/javascript" src="/demo/Public/Js/addUser.js"></script>
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/category.css" />

</head>
<body>
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 用户列表</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="/demo/index.php?s=/Home/advertisement/index">编辑用户</a>
	    </span><?php endif; ?>
</h1>

<div class="form_div">
<form action="/demo/index.php?s=/Home/user/edit" method="post">
<input type="hidden" value="editSubmit" name="act" />
<input type="hidden" value="<?php echo ($user["id"]); ?>" name="user_id"/>
<table>

    <tr>
        <td class="label">校区：</td>
        <td class="value">
            <select name="school_id" id="school_id">
                <option value="0">请选择</option>
                <?php if(is_array($schools)): foreach($schools as $key=>$sc): ?><option value="<?php echo ($sc["id"]); ?>" <?php echo ($sc['id']===$schoolId?'selected="selected"':''); ?>><?php echo ($sc["school_name"]); ?></option><?php endforeach; endif; ?>
            </select>
        </td>
    </tr>

    <tr>
        <td class="label">用户权限：</td>
        <td class="value">
        <select name="pow_id">               
                <?php if(is_array($pow)): foreach($pow as $key=>$pw): ?><option value="<?php echo ($pw["id"]); ?>" <?php echo ($pw['id']==$actionId?'selected="selected"':''); ?>><?php echo ($pw["pow_name"]); ?></option><?php endforeach; endif; ?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">用户名：</td>
        <td class="value" id="cat">
        <input type="text" name="user_name" value="<?php echo ($user["name"]); ?>" maxlength="16"/>
        </td>
    </tr>
    <tr>
        <td class="label">密码：</td>
        <td class="value"><input type="password" name="user_pwd" /></td>
    </tr>

    <tr>
        <td class="label"></td>
        <td style="text-align:left;">
            <input class="button" type="submit" name="submit" value="修改">
            <input class="button" type="reset" value="重置"/>
        </td>
    </tr>
</table>
</form>
</div>    
    
</body>
</html>