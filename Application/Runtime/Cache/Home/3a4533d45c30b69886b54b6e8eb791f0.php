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
    </script>
</head>
<body>
<!-- 顶部页面导航 -->
<h1 class="page_nav">    
    <span class="nav_list1">
        <a>书画后台管理中心</a>
    </span>
    <span class="nav_list1">- 用户列表</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="/demo/index.php?s=/Home/user/add">添加用户</a>
	    </span><?php endif; ?>
</h1>
<!-- 搜索模块 -->
<div class="search_div">
    <form action="">
        <img width="26" height="22" border="0" alt="search" src="/demo/Public/images/icon_search.gif" />
        手机号：
        <input type="text" name="phone" value="<?php echo ($phoneWhere); ?>" />
         日期：
        <input type="text" size="15" name="start_time" value="<?php echo ($startWhere); ?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" /><bold>~</bold>
        <input type="text" size="15" name="end_time" value="<?php echo ($endWhere); ?>" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
        <input style="margin-left:35px;" class="button" type="submit" name="submit" value="搜索" />
    </form>
</div>
<div>
    <form method="post" action="/demo/index.php?s=/Home/App/daochuindex" name="form_daochu">
        <input type='hidden' name="start_time" value="<?php echo ($startWhere); ?>">
        <input type='hidden' name="end_time" value="<?php echo ($endWhere); ?>">
        <input type='hidden' name="phone" value="<?php echo ($phoneWhere); ?>">
        <input type="button" name="btn_output" value="导出" class="submit" onclick="document.form_daochu.submit();"/>
    </form>
</div>
<!-- 列表样式 -->
<form action="/demo/index.php?s=/Home/user/delete" method="get">
    <div class="data-list" >
        <table cellspacing="1" cellpadding="3">
            <tbody>
            <tr>
                <th>用户编号</th>
                <th>用户名</th>
                <th>手机号</th>
                <th>邀请函页</th>
                <th>邀请人数</th>
                <th>邀请单数</th>
                <th>邀请人</th>
                <th>生成时间</th>
                <th>用户来源</th>
            </tr>
            <?php if(empty($users)): ?><tr>
                    <td class="no-records" colspan="9" style="background-color: rgb(244, 250, 251);">没有找到任何记录</td>
                </tr>
                <?php else: ?>
                <?php if(is_array($users)): foreach($users as $k=>$user): ?><tr class="tr<?php echo ($k%2); ?>">
                        <td><?php echo ($user["id"]); ?></td>
                        <td><?php echo ($user["nickname"]); ?></td>
                        <td><?php echo ($user["phone"]); ?></td>
                        <td style="text-align: left;"><?php if($user['invitatiom'] == '0'): ?>未生成<?php else: ?><a href="/demo/index.php?s=/Home/App/yqh&app_id=<?php echo ($user["id"]); ?>">已生成</a><?php endif; ?></td>
                        <td><a href="/demo/index.php?s=/Home/App/yqrs&app_id=<?php echo ($user["id"]); ?>"><?php echo ($user["number"]); ?></a></td>
                        <td><a href="/demo/index.php?s=/Home/App/yqds&app_id=<?php echo ($user["id"]); ?>"><?php echo ($user["orders_no"]); ?></a></td>
                        <td><a href="/demo/index.php?s=/Home/App/yqr&invi_people=<?php echo ($user["invi_people"]); ?>"><?php echo ($user["referees"]); ?></a></td>
                        <td><?php echo ($user["create_time"]); ?></td>
                        <td><?php echo ($user["project_name"]); ?></td>
                        </td>
                    </tr><?php endforeach; endif; ?>
                <tr>
                    <td colspan="9"><?php echo ($page); ?></td>
                </tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</form>
</body>
</html>