<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>书画系统后台管理</title>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
    <script type="text/javascript" src="/demo/Public/Js/Jquery.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/cat.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/DatePicker/WdatePicker.js"></script>
    <script>
        var module = "/demo/index.php?s=/Home";
        function delConfirm(url)
        {
            msg = "确定要删除？"
            if(confirm(msg))
            {
                location.href=url;
            }
        }
    </script>
</head>
<body>
<!-- 顶部页面导航 -->
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 管理员列表</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="/demo/index.php?s=/Home/user/add">添加用户</a>
	    </span><?php endif; ?>
</h1>

<!-- 列表样式 -->
<form action="/demo/index.php?s=/Home/user/delete" method="get">
    <div class="data-list" >
        <table cellspacing="1" cellpadding="3">
            <tbody>
            <tr>
                <th>用户编号</th>
                <th>登录名</th>
                <th>创建时间</th>
                <th>操作</th>

            </tr>
            <?php if(empty($users)): ?><tr>
                    <td class="no-records" colspan="3" style="background-color: rgb(244, 250, 251);">没有找到任何记录</td>
                </tr>
                <?php else: ?>
                <?php if(is_array($users)): foreach($users as $k=>$user): ?><tr class="tr<?php echo ($k%2); ?>">
                        <td><?php echo ($pageCount*($currentPage-1)+$k+1); ?></td>
                        <td><a href="/demo/index.php?s=/Home/User/edit&user_id=<?php echo ($user["id"]); ?>"><?php echo ($user["name"]); ?></a></td>
                        <td><?php echo ($user["create_time"]); ?></td>
                        <td>
                            <a onclick="delConfirm('/demo/index.php?s=/Home/User/delete&user_id=<?php echo ($user["id"]); ?>')"><img src="/demo/Public/images/icon_del.gif" /></a>
                        </td>
                    </tr><?php endforeach; endif; ?>

                <tr>
                    <td colspan="4"><?php echo ($page); ?></td>
                </tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</form>
</body>
</html>