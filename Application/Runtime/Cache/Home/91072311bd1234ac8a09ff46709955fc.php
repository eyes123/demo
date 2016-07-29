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
    <span class="nav_list1">- 邀请单数详情</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">[url_name]</a>
	    </span><?php endif; ?>
</h1>

<!-- 列表样式 -->
<div class="data-list" >
    <table cellspacing="1" cellpadding="3">
        <tbody>
        <tr>
            <th>序号</th>
            <th>订单号</th>
            <th>用户名</th>
            <th>订单金额</th>
            <th>成单时间</th>
        </tr>
        <?php if(empty($rows)): ?><tr>
                <td class="no-records" colspan="5" style="background-color: rgb(244, 250, 251);">没有找到任何记录</td>
            </tr>
            <?php else: ?>
            <?php if(is_array($rows)): foreach($rows as $k=>$list): ?><tr class="tr<?php echo ($k%2); ?>">
                    <td><?php echo ($pageCount*($currentPage-1)+$k+1); ?></td>
                    <td><?php echo ($list["order_code"]); ?></td>
                    <td><?php echo ($list["nickname"]); ?></td>
                    <td><?php echo ($list["order_price"]); ?></td>
                    <td><?php echo ($list["pay_time"]); ?></td>
                </tr><?php endforeach; endif; ?>
            <tr>
                <td colspan="5"><?php echo ($page); ?></td>
            </tr><?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>