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
    <span class="nav_list1">- 邀请人数详情</span> 
	
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
            <th>邀请函页</th>
            <th>邀请人数</th>
            <th>邀请单数</th>
            <th>邀请人</th>
            <th>生成时间</th>
            <th>用户来源</th>
        </tr>
        <?php if(empty($yqrs)): ?><tr>
                <td class="no-records" colspan="9" style="background-color: rgb(244, 250, 251);">没有找到任何记录</td>
            </tr>
            <?php else: ?>
        <?php if(is_array($yqrs)): foreach($yqrs as $k=>$list): ?><tr class="tr<?php echo ($k%2); ?>">
            <td><?php echo ($pageCount*($currentPage-1)+$k+1); ?></td>
            <td><?php echo ($list["nickname"]); ?></td>
            <td><?php echo ($list["phone"]); ?></td>
                <td><?php if($list['invitatiom'] == '0'): ?>未生成<?php else: ?>已生成<?php endif; ?></td>
                <td><?php echo ($list["number"]); ?></td>
                <td><?php echo ($list["orders_no"]); ?></td>
                <td><?php echo ($list["referees"]); ?></td>
                <td><?php echo ($list["create_time"]); ?></td>
                <td><?php echo ($list["project_name"]); ?></td>
            <td>
            </td>
        </tr><?php endforeach; endif; ?>
        <tr>
            <td colspan="9"><?php echo ($page); ?></td>
        </tr><?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>