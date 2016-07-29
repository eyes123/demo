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
    <span class="nav_list1">- 订单列表</span> 
	
	<?php if(!empty($url)): ?><span class="add_advertisement_btn">
	        <a href="[url]">[url_name]</a>
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
    <form method="post" action="/demo/index.php?s=/Home/Order/daochuindex" name="form_daochu">
        <input type='hidden' name="start_time" value="<?php echo ($startWhere); ?>">
        <input type='hidden' name="end_time" value="<?php echo ($endWhere); ?>">
        <input type='hidden' name="phone" value="<?php echo ($phoneWhere); ?>">
        <input type="button" name="btn_output" value="导出" class="submit" onclick="document.form_daochu.submit();"/>
    </form>
</div>
<!-- 列表样式 -->
<form action="" method="get">
    <div class="data-list" >
        <table cellspacing="1" cellpadding="3">
            <tbody>
            <tr>
                <th>订单编号</th>
                <th>用户名</th>
                <th>手机号</th>
                <th>商品名称</th>
                <th>订单金额</th>
                <th>支付时间</th>
                <th>生成时间</th>
                <th>课程状态</th>
                <th>红包状态</th>
                <th>订单来源</th>
            </tr>
            <?php if(empty($order)): ?><tr>
                    <td class="no-records" colspan="10" style="background-color: rgb(244, 250, 251);">没有找到任何记录</td>
                </tr>
                <?php else: ?>
                <?php if(is_array($order)): foreach($order as $k=>$od): ?><tr class="tr<?php echo ($k%2); ?>">
                        <td><?php echo ($od["id"]); ?></td>
                        <td><?php echo ($od["nickname"]); ?></td>
                        <td><?php echo ($od["phone"]); ?></td>
                        <td ><?php echo ($od["project_name"]); ?></td>
                        <td><?php echo ($od["order_price"]); ?></td>
                        <td><?php if($od['pay_time'] == null): ?>未支付<?php else: echo ($od["pay_time"]); endif; ?></td>
                        <td><?php echo ($od["create_time"]); ?></td>
                        <td><?php if($od['state'] == 1): ?>已完成<?php else: ?>未完成<?php endif; ?></td>
                        <td><?php if($od['hongbao_state'] == 1): ?>已使用<?php else: ?>未使用<?php endif; ?></td>
                        <td><?php echo ($od["project_name"]); ?></td>
                    </tr><?php endforeach; endif; ?>
                <tr>
                    <td colspan="10"><?php echo ($page); ?></td>
                </tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</form>
</body>
</html>