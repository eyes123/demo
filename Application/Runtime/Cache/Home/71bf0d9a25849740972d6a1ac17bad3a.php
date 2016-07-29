<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>书画后台管理</title>

    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
    <script type="text/javascript" src="/demo/Public/Js/Jquery.js"></script>
    <script>
        var module = "/demo/index.php?s=/Home";
    </script>
</head>
<body>

<!-- 顶部页面导航 -->
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 邀请函详情</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">[url_name]</a>
	    </span><?php endif; ?>
</h1>

<!-- 列表样式 -->
<div class="data-list" >
    <table cellspacing="1" cellpadding="3">
        <tbody>
        <tr>
            <th>用户编号</th>
            <th>用户名</th>
            <th>手机号</th>
            <th>邀请链接</th>
            <th>邀请二维码</th>
        </tr>
        <tr>
            <td><?php echo ($yqh["id"]); ?></td>
            <td><?php echo ($yqh["nickname"]); ?></td>
            <td><?php echo ($yqh["phone"]); ?></td>
            <td><?php echo ($url); ?></td>
            <td><img class="myshare" id="myshare" width="250px" alt="" src="/demo/index.php?s=/Home/App/getQrcode&tiker=<?php echo ($yqh["id"]); ?>" /></td>

        </tr>
        </tbody>
    </table>
</div>
</body>
</html>